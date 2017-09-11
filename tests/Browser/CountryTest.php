<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class CountryTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateCountry()
    {
        $admin = factory('App\User', 'admin')->create();
        $country = factory('App\Country')->make();

        $this->browse(function (Browser $browser) use ($admin, $country) {
            $browser->loginAs($admin)
                ->visit(route('admin.countries.index'))
                ->clickLink('Add new')
                ->type("name", $country->name)
                ->press('Save')
                ->assertRouteIs('admin.countries.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $country->name);
        });
    }

    public function testEditCountry()
    {
        $admin = factory('App\User', 'admin')->create();
        $country = factory('App\Country')->create();
        $country2 = factory('App\Country')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $country, $country2) {
            $browser->loginAs($admin)
                ->visit(route('admin.countries.index'))
                ->click('tr[data-entry-id="' . $country->id . '"] .btn-info')
                ->type("name", $country2->name)
                ->press('Update')
                ->assertRouteIs('admin.countries.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $country2->name);
        });
    }

    public function testShowCountry()
    {
        $admin = factory('App\User', 'admin')->create();
        $country = factory('App\Country')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $country) {
            $browser->loginAs($admin)
                ->visit(route('admin.countries.index'))
                ->click('tr[data-entry-id="' . $country->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $country->name);
        });
    }

}
