<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ContactTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateContact()
    {
        $admin = factory('App\User', 'admin')->create();
        $contact = factory('App\Contact')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $contact) {
            $browser->loginAs($admin)
                ->visit(route('admin.contacts.index'))
                ->clickLink('Add new')
                ->type("first_name", $contact->first_name)
                ->type("last_name", $contact->last_name)
                ->type("mobile_number", $contact->mobile_number)
                ->type("phone_number", $contact->phone_number)
                ->type("email", $contact->email)
                ->select("contact_type_id", $contact->contact_type_id)
                ->select("designation_type_id", $contact->designation_type_id)
                ->select("user_id", $contact->user_id)
                ->check("is_primary")
                ->select("patient_id", $contact->patient_id)
                ->press('Save')
                ->assertRouteIs('admin.contacts.index')
                ->assertSeeIn("tr:last-child td[field-key='first_name']", $contact->first_name)
                ->assertSeeIn("tr:last-child td[field-key='last_name']", $contact->last_name)
                ->assertSeeIn("tr:last-child td[field-key='mobile_number']", $contact->mobile_number)
                ->assertSeeIn("tr:last-child td[field-key='phone_number']", $contact->phone_number)
                ->assertSeeIn("tr:last-child td[field-key='email']", $contact->email)
                ->assertSeeIn("tr:last-child td[field-key='contact_type']", $contact->contact_type->name)
                ->assertSeeIn("tr:last-child td[field-key='designation_type']", $contact->designation_type->name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $contact->user->name)
                ->assertChecked("is_primary")
                ->assertSeeIn("tr:last-child td[field-key='patient']", $contact->patient->first_name);
        });
    }

    public function testEditContact()
    {
        $admin = factory('App\User', 'admin')->create();
        $contact = factory('App\Contact')->create();
        $contact2 = factory('App\Contact')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $contact, $contact2) {
            $browser->loginAs($admin)
                ->visit(route('admin.contacts.index'))
                ->click('tr[data-entry-id="' . $contact->id . '"] .btn-info')
                ->type("first_name", $contact2->first_name)
                ->type("last_name", $contact2->last_name)
                ->type("mobile_number", $contact2->mobile_number)
                ->type("phone_number", $contact2->phone_number)
                ->type("email", $contact2->email)
                ->select("contact_type_id", $contact2->contact_type_id)
                ->select("designation_type_id", $contact2->designation_type_id)
                ->select("user_id", $contact2->user_id)
                ->check("is_primary")
                ->select("patient_id", $contact2->patient_id)
                ->press('Update')
                ->assertRouteIs('admin.contacts.index')
                ->assertSeeIn("tr:last-child td[field-key='first_name']", $contact2->first_name)
                ->assertSeeIn("tr:last-child td[field-key='last_name']", $contact2->last_name)
                ->assertSeeIn("tr:last-child td[field-key='mobile_number']", $contact2->mobile_number)
                ->assertSeeIn("tr:last-child td[field-key='phone_number']", $contact2->phone_number)
                ->assertSeeIn("tr:last-child td[field-key='email']", $contact2->email)
                ->assertSeeIn("tr:last-child td[field-key='contact_type']", $contact2->contact_type->name)
                ->assertSeeIn("tr:last-child td[field-key='designation_type']", $contact2->designation_type->name)
                ->assertSeeIn("tr:last-child td[field-key='user']", $contact2->user->name)
                ->assertChecked("is_primary")
                ->assertSeeIn("tr:last-child td[field-key='patient']", $contact2->patient->first_name);
        });
    }

    public function testShowContact()
    {
        $admin = factory('App\User', 'admin')->create();
        $contact = factory('App\Contact')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $contact) {
            $browser->loginAs($admin)
                ->visit(route('admin.contacts.index'))
                ->click('tr[data-entry-id="' . $contact->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='first_name']", $contact->first_name)
                ->assertSeeIn("td[field-key='last_name']", $contact->last_name)
                ->assertSeeIn("td[field-key='mobile_number']", $contact->mobile_number)
                ->assertSeeIn("td[field-key='phone_number']", $contact->phone_number)
                ->assertSeeIn("td[field-key='email']", $contact->email)
                ->assertSeeIn("td[field-key='contact_type']", $contact->contact_type->name)
                ->assertSeeIn("td[field-key='designation_type']", $contact->designation_type->name)
                ->assertSeeIn("td[field-key='user']", $contact->user->name)
                ->assertNotChecked("is_primary")
                ->assertSeeIn("td[field-key='patient']", $contact->patient->first_name);
        });
    }

}
