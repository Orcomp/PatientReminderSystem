<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class TreatmentTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateTreatment()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment = factory('App\Treatment')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $treatment) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatments.index'))
                ->clickLink('Add new')
                ->select("patient_id", $treatment->patient_id)
                ->select("treatment_type_id", $treatment->treatment_type_id)
                ->select("treatment_stage_id", $treatment->treatment_stage_id)
                ->type("start_date", $treatment->start_date)
                ->type("end_date", $treatment->end_date)
                ->type("notes", $treatment->notes)
                ->press('Save')
                ->assertRouteIs('admin.treatments.index')
                ->assertSeeIn("tr:last-child td[field-key='patient']", $treatment->patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='treatment_type']", $treatment->treatment_type->name)
                ->assertSeeIn("tr:last-child td[field-key='treatment_stage']", $treatment->treatment_stage->name)
                ->assertSeeIn("tr:last-child td[field-key='start_date']", $treatment->start_date)
                ->assertSeeIn("tr:last-child td[field-key='end_date']", $treatment->end_date)
                ->assertSeeIn("tr:last-child td[field-key='notes']", $treatment->notes);
        });
    }

    public function testEditTreatment()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment = factory('App\Treatment')->create();
        $treatment2 = factory('App\Treatment')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $treatment, $treatment2) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatments.index'))
                ->click('tr[data-entry-id="' . $treatment->id . '"] .btn-info')
                ->select("patient_id", $treatment2->patient_id)
                ->select("treatment_type_id", $treatment2->treatment_type_id)
                ->select("treatment_stage_id", $treatment2->treatment_stage_id)
                ->type("start_date", $treatment2->start_date)
                ->type("end_date", $treatment2->end_date)
                ->type("notes", $treatment2->notes)
                ->press('Update')
                ->assertRouteIs('admin.treatments.index')
                ->assertSeeIn("tr:last-child td[field-key='patient']", $treatment2->patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='treatment_type']", $treatment2->treatment_type->name)
                ->assertSeeIn("tr:last-child td[field-key='treatment_stage']", $treatment2->treatment_stage->name)
                ->assertSeeIn("tr:last-child td[field-key='start_date']", $treatment2->start_date)
                ->assertSeeIn("tr:last-child td[field-key='end_date']", $treatment2->end_date)
                ->assertSeeIn("tr:last-child td[field-key='notes']", $treatment2->notes);
        });
    }

    public function testShowTreatment()
    {
        $admin = factory('App\User', 'admin')->create();
        $treatment = factory('App\Treatment')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $treatment) {
            $browser->loginAs($admin)
                ->visit(route('admin.treatments.index'))
                ->click('tr[data-entry-id="' . $treatment->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='patient']", $treatment->patient->first_name)
                ->assertSeeIn("td[field-key='treatment_type']", $treatment->treatment_type->name)
                ->assertSeeIn("td[field-key='treatment_stage']", $treatment->treatment_stage->name)
                ->assertSeeIn("td[field-key='start_date']", $treatment->start_date)
                ->assertSeeIn("td[field-key='end_date']", $treatment->end_date)
                ->assertSeeIn("td[field-key='notes']", $treatment->notes);
        });
    }

}
