<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DiagnosisTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateDiagnosis()
    {
        $admin = factory('App\User', 'admin')->create();
        $diagnosis = factory('App\Diagnosis')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $diagnosis) {
            $browser->loginAs($admin)
                ->visit(route('admin.diagnoses.index'))
                ->clickLink('Add new')
                ->select("patient_id", $diagnosis->patient_id)
                ->select("diagnose_type_id", $diagnosis->diagnose_type_id)
                ->type("diagnose_date", $diagnosis->diagnose_date)
                ->type("notes", $diagnosis->notes)
                ->press('Save')
                ->assertRouteIs('admin.diagnoses.index')
                ->assertSeeIn("tr:last-child td[field-key='patient']", $diagnosis->patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='diagnose_type']", $diagnosis->diagnose_type->name)
                ->assertSeeIn("tr:last-child td[field-key='diagnose_date']", $diagnosis->diagnose_date)
                ->assertSeeIn("tr:last-child td[field-key='notes']", $diagnosis->notes);
        });
    }

    public function testEditDiagnosis()
    {
        $admin = factory('App\User', 'admin')->create();
        $diagnosis = factory('App\Diagnosis')->create();
        $diagnosis2 = factory('App\Diagnosis')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $diagnosis, $diagnosis2) {
            $browser->loginAs($admin)
                ->visit(route('admin.diagnoses.index'))
                ->click('tr[data-entry-id="' . $diagnosis->id . '"] .btn-info')
                ->select("patient_id", $diagnosis2->patient_id)
                ->select("diagnose_type_id", $diagnosis2->diagnose_type_id)
                ->type("diagnose_date", $diagnosis2->diagnose_date)
                ->type("notes", $diagnosis2->notes)
                ->press('Update')
                ->assertRouteIs('admin.diagnoses.index')
                ->assertSeeIn("tr:last-child td[field-key='patient']", $diagnosis2->patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='diagnose_type']", $diagnosis2->diagnose_type->name)
                ->assertSeeIn("tr:last-child td[field-key='diagnose_date']", $diagnosis2->diagnose_date)
                ->assertSeeIn("tr:last-child td[field-key='notes']", $diagnosis2->notes);
        });
    }

    public function testShowDiagnosis()
    {
        $admin = factory('App\User', 'admin')->create();
        $diagnosis = factory('App\Diagnosis')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $diagnosis) {
            $browser->loginAs($admin)
                ->visit(route('admin.diagnoses.index'))
                ->click('tr[data-entry-id="' . $diagnosis->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='patient']", $diagnosis->patient->first_name)
                ->assertSeeIn("td[field-key='diagnose_type']", $diagnosis->diagnose_type->name)
                ->assertSeeIn("td[field-key='diagnose_date']", $diagnosis->diagnose_date)
                ->assertSeeIn("td[field-key='notes']", $diagnosis->notes);
        });
    }

}
