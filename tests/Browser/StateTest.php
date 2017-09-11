<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class StateTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateState()
    {
        $admin = factory('App\User', 'admin')->create();
        $state = factory('App\State')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $state) {
            $browser->loginAs($admin)
                ->visit(route('admin.states.index'))
                ->clickLink('Add new')
                ->type("name", $state->name)
                ->select("country_id", $state->country_id)
                ->press('Save')
                ->assertRouteIs('admin.states.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $state->name)
                ->assertSeeIn("tr:last-child td[field-key='country']", $state->country->name);
        });
    }

    public function testEditState()
    {
        $admin = factory('App\User', 'admin')->create();
        $state = factory('App\State')->create();
        $state2 = factory('App\State')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $state, $state2) {
            $browser->loginAs($admin)
                ->visit(route('admin.states.index'))
                ->click('tr[data-entry-id="' . $state->id . '"] .btn-info')
                ->type("name", $state2->name)
                ->select("country_id", $state2->country_id)
                ->press('Update')
                ->assertRouteIs('admin.states.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $state2->name)
                ->assertSeeIn("tr:last-child td[field-key='country']", $state2->country->name);
        });
    }

    public function testShowState()
    {
        $admin = factory('App\User', 'admin')->create();
        $state = factory('App\State')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $state) {
            $browser->loginAs($admin)
                ->visit(route('admin.states.index'))
                ->click('tr[data-entry-id="' . $state->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $state->name)
                ->assertSeeIn("td[field-key='country']", $state->country->name);
        });
    }

}
