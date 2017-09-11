<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AddressTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateAddress()
    {
        $admin = factory('App\User', 'admin')->create();
        $address = factory('App\Address')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $address) {
            $browser->loginAs($admin)
                ->visit(route('admin.addresses.index'))
                ->clickLink('Add new')
                ->select("contact_id", $address->contact_id)
                ->type("street", $address->street)
                ->select("city_id", $address->city_id)
                ->select("state_id", $address->state_id)
                ->select("country_id", $address->country_id)
                ->type("note", $address->note)
                ->select("address_type_id", $address->address_type_id)
                ->press('Save')
                ->assertRouteIs('admin.addresses.index')
                ->assertSeeIn("tr:last-child td[field-key='contact']", $address->contact->first_name)
                ->assertSeeIn("tr:last-child td[field-key='street']", $address->street)
                ->assertSeeIn("tr:last-child td[field-key='city']", $address->city->name)
                ->assertSeeIn("tr:last-child td[field-key='state']", $address->state->name)
                ->assertSeeIn("tr:last-child td[field-key='country']", $address->country->name)
                ->assertSeeIn("tr:last-child td[field-key='note']", $address->note)
                ->assertSeeIn("tr:last-child td[field-key='address_type']", $address->address_type->name);
        });
    }

    public function testEditAddress()
    {
        $admin = factory('App\User', 'admin')->create();
        $address = factory('App\Address')->create();
        $address2 = factory('App\Address')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $address, $address2) {
            $browser->loginAs($admin)
                ->visit(route('admin.addresses.index'))
                ->click('tr[data-entry-id="' . $address->id . '"] .btn-info')
                ->select("contact_id", $address2->contact_id)
                ->type("street", $address2->street)
                ->select("city_id", $address2->city_id)
                ->select("state_id", $address2->state_id)
                ->select("country_id", $address2->country_id)
                ->type("note", $address2->note)
                ->select("address_type_id", $address2->address_type_id)
                ->press('Update')
                ->assertRouteIs('admin.addresses.index')
                ->assertSeeIn("tr:last-child td[field-key='contact']", $address2->contact->first_name)
                ->assertSeeIn("tr:last-child td[field-key='street']", $address2->street)
                ->assertSeeIn("tr:last-child td[field-key='city']", $address2->city->name)
                ->assertSeeIn("tr:last-child td[field-key='state']", $address2->state->name)
                ->assertSeeIn("tr:last-child td[field-key='country']", $address2->country->name)
                ->assertSeeIn("tr:last-child td[field-key='note']", $address2->note)
                ->assertSeeIn("tr:last-child td[field-key='address_type']", $address2->address_type->name);
        });
    }

    public function testShowAddress()
    {
        $admin = factory('App\User', 'admin')->create();
        $address = factory('App\Address')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $address) {
            $browser->loginAs($admin)
                ->visit(route('admin.addresses.index'))
                ->click('tr[data-entry-id="' . $address->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='contact']", $address->contact->first_name)
                ->assertSeeIn("td[field-key='street']", $address->street)
                ->assertSeeIn("td[field-key='city']", $address->city->name)
                ->assertSeeIn("td[field-key='state']", $address->state->name)
                ->assertSeeIn("td[field-key='country']", $address->country->name)
                ->assertSeeIn("td[field-key='note']", $address->note)
                ->assertSeeIn("td[field-key='address_type']", $address->address_type->name);
        });
    }

}
