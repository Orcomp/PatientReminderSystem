<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ContactTypeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateContactType()
    {
        $admin = factory('App\User', 'admin')->create();
        $contact_type = factory('App\ContactType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $contact_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.contact_types.index'))
                ->clickLink('Add new')
                ->type("name", $contact_type->name)
                ->press('Save')
                ->assertRouteIs('admin.contact_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $contact_type->name);
        });
    }

    public function testEditContactType()
    {
        $admin = factory('App\User', 'admin')->create();
        $contact_type = factory('App\ContactType')->create();
        $contact_type2 = factory('App\ContactType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $contact_type, $contact_type2) {
            $browser->loginAs($admin)
                ->visit(route('admin.contact_types.index'))
                ->click('tr[data-entry-id="' . $contact_type->id . '"] .btn-info')
                ->type("name", $contact_type2->name)
                ->press('Update')
                ->assertRouteIs('admin.contact_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $contact_type2->name);
        });
    }

    public function testShowContactType()
    {
        $admin = factory('App\User', 'admin')->create();
        $contact_type = factory('App\ContactType')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $contact_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.contact_types.index'))
                ->click('tr[data-entry-id="' . $contact_type->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $contact_type->name);
        });
    }

}
