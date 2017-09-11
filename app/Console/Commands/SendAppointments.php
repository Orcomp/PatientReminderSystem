<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Appointment;
use App\Notifications\AppointmentsToday;
use App\Settings;
use App\User;
use Illuminate\Console\Command;

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
        $this->first_reminder = NULL;
        $first_reminder = Settings::where('key', 'first_reminder')->first();
        if ($first_reminder) {
            $this->first_reminder = $first_reminder->value;
        }
        $this->second_reminder = NULL;
        $second_reminder = Settings::where('key', 'second_reminder')->first();
        if ($second_reminder) {
            $this->second_reminder = $second_reminder->value;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings = Settings::all();

        $appointments = collect([
            $this->face_to_face_today(),
            $this->over_the_phone_today(),
            $this->remind_unconfirmed()
        ])->collapse();

        $users = $appointments->groupBy('user_id');
        foreach ($users as $user_id => $appointments) {
            $data = '';
            $send_types = $appointments->groupBy('send_type');
            foreach ($send_types as $send_type => $appointments) {
                switch ($send_type) {
                    case 'facetoface':
                        $data .= "**Face-to-face today:**<br>";
                        break;

                    case 'phone':
                        $data .= "**Over-the-phone today:**<br>";
                        break;

                    case 'unconfirmed':
                        $data .= "**Unconfirmed:**<br>";
                        break;

                    default:
                        break;
                }
                foreach ($appointments as $appointment) {
                    $data .= $appointment->appointment_time . ' ' . $appointment->patient->full_name . "<br>";
                }
            }

            $user = User::findOrFail($user_id);
            $user->notify(new AppointmentsToday($user->full_name, $data));
        }
    }

    public function face_to_face_today() {
        $appointments = Appointment::whereDate('appointment_time', '=', Carbon::today()->toDateString())
            ->where('appointment_type_id', 1)
            ->whereNotNull('confirmed_at')
            ->get()
            ->each(function($model){
                $model->send_type = 'facetoface';
            });
        return $appointments;
    }

    public function over_the_phone_today() {
        $appointments = Appointment::where('appointment_type_id', 2)
            ->whereDate('appointment_time', '=', Carbon::today()->toDateString())
            ->get()
            ->each(function($model){
                $model->send_type = 'phone';
            });
        return $appointments;
    }

    public function remind_unconfirmed() {
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
}
