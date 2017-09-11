<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class TreatmentStageTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateTreatmentStage()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment_stage = factory('App\TreatmentStage')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $treatment_stage) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatment_stages.index'))
                ->clickLink('Add new')
                ->type("name", $treatment_stage->name)
                ->press('Save')
                ->assertRouteIs('admin.treatment_stages.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $treatment_stage->name);
        });
    }

    public function testEditTreatmentStage()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment_stage = factory('App\TreatmentStage')->create();
        $treatment_stage2 = factory('App\TreatmentStage')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $treatment_stage, $treatment_stage2) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatment_stages.index'))
                ->click('tr[data-entry-id="' . $treatment_stage->id . '"] .btn-info')
                ->type("name", $treatment_stage2->name)
                ->press('Update')
                ->assertRouteIs('admin.treatment_stages.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $treatment_stage2->name);
        });
    }

    public function testShowTreatmentStage()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment_stage = factory('App\TreatmentStage')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $treatment_stage) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatment_stages.index'))
                ->click('tr[data-entry-id="' . $treatment_stage->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $treatment_stage->name);
        });
    }

}
