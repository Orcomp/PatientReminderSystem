<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AddressTypeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateAddressType()
    {
        $admin = factory('App\User', 'admin')->create();
        $address_type = factory('App\AddressType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $address_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.address_types.index'))
                ->clickLink('Add new')
                ->type("name", $address_type->name)
                ->press('Save')
                ->assertRouteIs('admin.address_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $address_type->name);
        });
    }

    public function testEditAddressType()
    {
        $admin = factory('App\User', 'admin')->create();
        $address_type = factory('App\AddressType')->create();
        $address_type2 = factory('App\AddressType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $address_type, $address_type2) {
            $browser->loginAs($admin)
                ->visit(route('admin.address_types.index'))
                ->click('tr[data-entry-id="' . $address_type->id . '"] .btn-info')
                ->type("name", $address_type2->name)
                ->press('Update')
                ->assertRouteIs('admin.address_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $address_type2->name);
        });
    }

    public function testShowAddressType()
    {
        $admin = factory('App\User', 'admin')->create();
        $address_type = factory('App\AddressType')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $address_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.address_types.index'))
                ->click('tr[data-entry-id="' . $address_type->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $address_type->name);
        });
    }

}
