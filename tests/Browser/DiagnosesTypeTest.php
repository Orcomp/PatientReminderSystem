<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DiagnosesTypeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateDiagnosesType()
    {
        $admin = factory('App\User', 'admin')->create();
        $diagnoses_type = factory('App\DiagnosesType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $diagnoses_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.diagnoses_types.index'))
                ->clickLink('Add new')
                ->type("name", $diagnoses_type->name)
                ->press('Save')
                ->assertRouteIs('admin.diagnoses_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $diagnoses_type->name);
        });
    }

    public function testEditDiagnosesType()
    {
        $admin = factory('App\User', 'admin')->create();
        $diagnoses_type = factory('App\DiagnosesType')->create();
        $diagnoses_type2 = factory('App\DiagnosesType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $diagnoses_type, $diagnoses_type2) {
            $browser->loginAs($admin)
                ->visit(route('admin.diagnoses_types.index'))
                ->click('tr[data-entry-id="' . $diagnoses_type->id . '"] .btn-info')
                ->type("name", $diagnoses_type2->name)
                ->press('Update')
                ->assertRouteIs('admin.diagnoses_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $diagnoses_type2->name);
        });
    }

    public function testShowDiagnosesType()
    {
        $admin = factory('App\User', 'admin')->create();
        $diagnoses_type = factory('App\DiagnosesType')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $diagnoses_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.diagnoses_types.index'))
                ->click('tr[data-entry-id="' . $diagnoses_type->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $diagnoses_type->name);
        });
    }

}
