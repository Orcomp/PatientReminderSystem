<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RescheduleReasonTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateRescheduleReason()
    {
        $admin = factory('App\User', 'admin')->create();
        $reschedule_reason = factory('App\RescheduleReason')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $reschedule_reason) {
            $browser->loginAs($admin)
                ->visit(route('admin.reschedule_reasons.index'))
                ->clickLink('Add new')
                ->type("name", $reschedule_reason->name)
                ->press('Save')
                ->assertRouteIs('admin.reschedule_reasons.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $reschedule_reason->name);
        });
    }

    public function testEditRescheduleReason()
    {
        $admin = factory('App\User', 'admin')->create();
        $reschedule_reason = factory('App\RescheduleReason')->create();
        $reschedule_reason2 = factory('App\RescheduleReason')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $reschedule_reason, $reschedule_reason2) {
            $browser->loginAs($admin)
                ->visit(route('admin.reschedule_reasons.index'))
                ->click('tr[data-entry-id="' . $reschedule_reason->id . '"] .btn-info')
                ->type("name", $reschedule_reason2->name)
                ->press('Update')
                ->assertRouteIs('admin.reschedule_reasons.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $reschedule_reason2->name);
        });
    }

    public function testShowRescheduleReason()
    {
        $admin = factory('App\User', 'admin')->create();
        $reschedule_reason = factory('App\RescheduleReason')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $reschedule_reason) {
            $browser->loginAs($admin)
                ->visit(route('admin.reschedule_reasons.index'))
                ->click('tr[data-entry-id="' . $reschedule_reason->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $reschedule_reason->name);
        });
    }

}
