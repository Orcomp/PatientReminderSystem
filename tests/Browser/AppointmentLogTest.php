<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AppointmentLogTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateAppointmentLog()
    {
        $admin = factory('App\User', 'admin')->create();
        $appointment_log = factory('App\AppointmentLog')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $appointment_log) {
            $browser->loginAs($admin)
                ->visit(route('admin.appointment_logs.index'))
                ->clickLink('Add new')
                ->select("appointment_id", $appointment_log->appointment_id)
                ->type("appointment_time", $appointment_log->appointment_time)
                ->type("note", $appointment_log->note)
                ->select("reschedule_reason_id", $appointment_log->reschedule_reason_id)
                ->select("created_by_id", $appointment_log->created_by_id)
                ->press('Save')
                ->assertRouteIs('admin.appointment_logs.index')
                ->assertSeeIn("tr:last-child td[field-key='appointment']", $appointment_log->appointment->appointment_time)
                ->assertSeeIn("tr:last-child td[field-key='appointment_time']", $appointment_log->appointment_time)
                ->assertSeeIn("tr:last-child td[field-key='note']", $appointment_log->note)
                ->assertSeeIn("tr:last-child td[field-key='reschedule_reason']", $appointment_log->reschedule_reason->name)
                ->assertSeeIn("tr:last-child td[field-key='created_by']", $appointment_log->created_by->name);
        });
    }

    public function testEditAppointmentLog()
    {
        $admin = factory('App\User', 'admin')->create();
        $appointment_log = factory('App\AppointmentLog')->create();
        $appointment_log2 = factory('App\AppointmentLog')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $appointment_log, $appointment_log2) {
            $browser->loginAs($admin)
                ->visit(route('admin.appointment_logs.index'))
                ->click('tr[data-entry-id="' . $appointment_log->id . '"] .btn-info')
                ->select("appointment_id", $appointment_log2->appointment_id)
                ->type("appointment_time", $appointment_log2->appointment_time)
                ->type("note", $appointment_log2->note)
                ->select("reschedule_reason_id", $appointment_log2->reschedule_reason_id)
                ->select("created_by_id", $appointment_log2->created_by_id)
                ->press('Update')
                ->assertRouteIs('admin.appointment_logs.index')
                ->assertSeeIn("tr:last-child td[field-key='appointment']", $appointment_log2->appointment->appointment_time)
                ->assertSeeIn("tr:last-child td[field-key='appointment_time']", $appointment_log2->appointment_time)
                ->assertSeeIn("tr:last-child td[field-key='note']", $appointment_log2->note)
                ->assertSeeIn("tr:last-child td[field-key='reschedule_reason']", $appointment_log2->reschedule_reason->name)
                ->assertSeeIn("tr:last-child td[field-key='created_by']", $appointment_log2->created_by->name);
        });
    }

    public function testShowAppointmentLog()
    {
        $admin = factory('App\User', 'admin')->create();
        $appointment_log = factory('App\AppointmentLog')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $appointment_log) {
            $browser->loginAs($admin)
                ->visit(route('admin.appointment_logs.index'))
                ->click('tr[data-entry-id="' . $appointment_log->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='appointment']", $appointment_log->appointment->appointment_time)
                ->assertSeeIn("td[field-key='appointment_time']", $appointment_log->appointment_time)
                ->assertSeeIn("td[field-key='note']", $appointment_log->note)
                ->assertSeeIn("td[field-key='reschedule_reason']", $appointment_log->reschedule_reason->name)
                ->assertSeeIn("td[field-key='created_by']", $appointment_log->created_by->name);
        });
    }

}
