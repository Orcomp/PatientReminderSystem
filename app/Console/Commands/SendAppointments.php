<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Appointment;
use App\Notifications\AppointmentsToday;
use App\Settings;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class SendAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind a doctor to contact a patient';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->first_reminder    = NULL;
        $this->second_reminder   = NULL;
        $this->look_ahead_window = NULL;
        if (Schema::hasTable('settings')) {
            $first_reminder = Settings::where('key', 'first_reminder')->first();
            if ($first_reminder) {
                $this->first_reminder = $first_reminder->value;
            }
            $second_reminder = Settings::where('key', 'second_reminder')->first();
            if ($second_reminder) {
                $this->second_reminder = $second_reminder->value;
            }
            $look_ahead_window = Settings::where('key', 'look_ahead_window')->first();
            if ($look_ahead_window) {
                $this->look_ahead_window = $look_ahead_window->value;
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('Starting the appointment sending...');

        $appointments = collect([
            $this->face_to_face_today(),
            $this->over_the_phone_today(),
            $this->remind_unconfirmed()
        ])->collapse();
        \Log::info('Appointments found: ' . $appointments->count());

        $users = $appointments->groupBy('user_id');
        foreach ($users as $user_id => $appointments) {
            $data = '';
            $send_types = $appointments->groupBy('send_type');
            foreach ($send_types as $send_type => $appointments) {
                switch ($send_type) {
                    case 'facetoface':
                        $data .= "**".trans('mail.appointments.face').":**<br>";
                        break;

                    case 'phone':
                        $data .= "**".trans('mail.appointments.phone').":**<br>";
                        break;

                    case 'unconfirmed':
                        $data .= "**".trans('mail.appointments.unconfirmed').":**<br>";
                        break;

                    default:
                        break;
                }
                foreach ($appointments as $appointment) {
                    $data .= $appointment->appointment_time . ' <a href="'.route('admin.patients.show', $appointment->patient_id).'">' . $appointment->patient->full_name . "</a><br>";
                }
            }
            $user = User::findOrFail($user_id);
            $upcoming = $this->upcoming_appointments($user_id);
            $user->notify(new AppointmentsToday($user, $data, $upcoming));
        }
        \Log::info('Finished the appointment sending.');
    }

    private function face_to_face_today() {
        $appointments = Appointment::whereDate('appointment_time', '=', Carbon::today()->toDateString())
            ->where('appointment_type_id', 1)
            ->whereNotNull('confirmed_at')
            ->get()
            ->each(function($model){
                $model->send_type = 'facetoface';
            });
        return $appointments;
    }

    private function over_the_phone_today() {
        $appointments = Appointment::where('appointment_type_id', 2)
            ->whereDate('appointment_time', '=', Carbon::today()->toDateString())
            ->get()
            ->each(function($model){
                $model->send_type = 'phone';
            });
        return $appointments;
    }

    private function remind_unconfirmed() {
        if (is_null($this->first_reminder) || is_null($this->second_reminder)) {
            return [];
        }

        $appointments = Appointment::where('appointment_type_id', 1)
            ->whereDate('appointment_time', '=', Carbon::today()->addDays($this->first_reminder)->toDateString())
            ->orWhereDate('appointment_time', '=', Carbon::today()->addDays($this->second_reminder)->toDateString())
            ->whereNull('confirmed_at')
            ->get()
            ->each(function($model){
                $model->send_type = 'unconfirmed';
            });

        return $appointments;
    }

    private function upcoming_appointments($user_id) {
        return Appointment::where('user_id', $user_id)
                ->whereBetween('appointment_time',[
                    Carbon::today()->toDateString(), Carbon::today()->addDays($this->look_ahead_window)->toDateString()
                ])
                ->get()
                ->each(function($appointment){
                    $appointment->diff = Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d H:i', $appointment->appointment_time));
                })
                ->sortBy('appointment_time');
    }
}
