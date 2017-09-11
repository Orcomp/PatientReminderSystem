<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AppointmentTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateAppointment()
    {
        $admin = factory('App\User', 'admin')->create();
        $appointment = factory('App\Appointment')->make();



        $this->browse(function (Browser $browser) use ($admin, $appointment) {
            $browser->loginAs($admin)
                ->visit(route('admin.appointments.index'))
                ->clickLink('Add new')
                ->select("patient_id", $appointment->patient_id)
                ->select("user_id", $appointment->user_id)
                ->type("appointment_time", $appointment->appointment_time)
                ->type("confirmed_at", $appointment->confirmed_at)
                ->select("contacted_contact_id", $appointment->contacted_contact_id)
                ->type("notes", $appointment->notes)
                ->select("created_by_id", $appointment->created_by_id)
                ->press('Save')
                ->assertRouteIs('admin.appointments.index')
                ->assertSeeIn("tr:last-child td[field-key='patient']", $appointment->patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $appointment->user->name)
                ->assertSeeIn("tr:last-child td[field-key='appointment_time']", $appointment->appointment_time)
                ->assertSeeIn("tr:last-child td[field-key='confirmed_at']", $appointment->confirmed_at)
                ->assertSeeIn("tr:last-child td[field-key='contacted_contact']", $appointment->contacted_contact->first_name)
                ->assertSeeIn("tr:last-child td[field-key='notes']", $appointment->notes)
                ->assertSeeIn("tr:last-child td[field-key='created_by']", $appointment->created_by->name);
        });
    }

    public function testEditAppointment()
    {
        $admin = factory('App\User', 'admin')->create();
        $appointment = factory('App\Appointment')->create();
        $appointment2 = factory('App\Appointment')->make();



        $this->browse(function (Browser $browser) use ($admin, $appointment, $appointment2) {
            $browser->loginAs($admin)
                ->visit(route('admin.appointments.index'))
                ->click('tr[data-entry-id="' . $appointment->id . '"] .btn-info')
                ->select("patient_id", $appointment2->patient_id)
                ->select("user_id", $appointment2->user_id)
                ->type("appointment_time", $appointment2->appointment_time)
                ->type("confirmed_at", $appointment2->confirmed_at)
                ->select("contacted_contact_id", $appointment2->contacted_contact_id)
                ->type("notes", $appointment2->notes)
                ->select("created_by_id", $appointment2->created_by_id)
                ->press('Update')
                ->assertRouteIs('admin.appointments.index')
                ->assertSeeIn("tr:last-child td[field-key='patient']", $appointment2->patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $appointment2->user->name)
                ->assertSeeIn("tr:last-child td[field-key='appointment_time']", $appointment2->appointment_time)
                ->assertSeeIn("tr:last-child td[field-key='confirmed_at']", $appointment2->confirmed_at)
                ->assertSeeIn("tr:last-child td[field-key='contacted_contact']", $appointment2->contacted_contact->first_name)
                ->assertSeeIn("tr:last-child td[field-key='notes']", $appointment2->notes)
                ->assertSeeIn("tr:last-child td[field-key='created_by']", $appointment2->created_by->name);
        });
    }

    public function testShowAppointment()
    {
        $admin = factory('App\User', 'admin')->create();
        $appointment = factory('App\Appointment')->create();




        $this->browse(function (Browser $browser) use ($admin, $appointment) {
            $browser->loginAs($admin)
                ->visit(route('admin.appointments.index'))
                ->click('tr[data-entry-id="' . $appointment->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='patient']", $appointment->patient->first_name)
                ->assertSeeIn("td[field-key='user']", $appointment->user->name)
                ->assertSeeIn("td[field-key='appointment_time']", $appointment->appointment_time)
                ->assertSeeIn("td[field-key='confirmed_at']", $appointment->confirmed_at)
                ->assertSeeIn("td[field-key='contacted_contact']", $appointment->contacted_contact->first_name)
                ->assertSeeIn("td[field-key='notes']", $appointment->notes)
                ->assertSeeIn("td[field-key='created_by']", $appointment->created_by->name);
        });
    }

}
