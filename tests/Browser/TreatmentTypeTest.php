<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class TreatmentTypeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateTreatmentType()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment_type = factory('App\TreatmentType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $treatment_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatment_types.index'))
                ->clickLink('Add new')
                ->type("name", $treatment_type->name)
                ->press('Save')
                ->assertRouteIs('admin.treatment_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $treatment_type->name);
        });
    }

    public function testEditTreatmentType()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment_type = factory('App\TreatmentType')->create();
        $treatment_type2 = factory('App\TreatmentType')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $treatment_type, $treatment_type2) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatment_types.index'))
                ->click('tr[data-entry-id="' . $treatment_type->id . '"] .btn-info')
                ->type("name", $treatment_type2->name)
                ->press('Update')
                ->assertRouteIs('admin.treatment_types.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $treatment_type2->name);
        });
    }

    public function testShowTreatmentType()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment_type = factory('App\TreatmentType')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $treatment_type) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatment_types.index'))
                ->click('tr[data-entry-id="' . $treatment_type->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $treatment_type->name);
        });
    }

}
