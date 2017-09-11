<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DesignationTypeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateDesignationType()
    {
        $admin = factory('App\User', 'admin')->create();
        $designation_type = factory('App\DesignationType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $designation_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.designation_types.index'))
                ->clickLink('Add new')
                ->type("name", $designation_type->name)
                ->press('Save')
                ->assertRouteIs('admin.designation_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $designation_type->name);
        });
    }

    public function testEditDesignationType()
    {
        $admin = factory('App\User', 'admin')->create();
        $designation_type = factory('App\DesignationType')->create();
        $designation_type2 = factory('App\DesignationType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $designation_type, $designation_type2) {
            $browser->loginAs($admin)
                ->visit(route('admin.designation_types.index'))
                ->click('tr[data-entry-id="' . $designation_type->id . '"] .btn-info')
                ->type("name", $designation_type2->name)
                ->press('Update')
                ->assertRouteIs('admin.designation_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $designation_type2->name);
        });
    }

    public function testShowDesignationType()
    {
        $admin = factory('App\User', 'admin')->create();
        $designation_type = factory('App\DesignationType')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $designation_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.designation_types.index'))
                ->click('tr[data-entry-id="' . $designation_type->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $designation_type->name);
        });
    }

}
