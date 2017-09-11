<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class PatientTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreatePatient()
    {
        $admin = factory('App\User', 'admin')->create();
        $patient = factory('App\Patient')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $patient) {
            $browser->loginAs($admin)
                ->visit(route('admin.patients.index'))
                ->clickLink('Add new')
                ->type("first_name", $patient->first_name)
                ->type("last_name", $patient->last_name)
                ->select("gender", $patient->gender)
                ->type("birth_date", $patient->birth_date)
                ->uncheck("schooled")
                ->type("notes", $patient->notes)
                ->press('Save')
                ->assertRouteIs('admin.patients.index')
                ->assertSeeIn("tr:last-child td[field-key='first_name']", $patient->first_name)
                ->assertSeeIn("tr:last-child td[field-key='last_name']", $patient->last_name)
                ->assertSeeIn("tr:last-child td[field-key='gender']", $patient->gender)
                ->assertSeeIn("tr:last-child td[field-key='birth_date']", $patient->birth_date)
                ->assertNotChecked("schooled")
                ->assertSeeIn("tr:last-child td[field-key='notes']", $patient->notes);
        });
    }

    public function testEditPatient()
    {
        $admin = factory('App\User', 'admin')->create();
        $patient = factory('App\Patient')->create();
        $patient2 = factory('App\Patient')->make();

        

        $this->browse(function (Browser $browser) use ($admin, $patient, $patient2) {
            $browser->loginAs($admin)
                ->visit(route('admin.patients.index'))
                ->click('tr[data-entry-id="' . $patient->id . '"] .btn-info')
                ->type("first_name", $patient2->first_name)
                ->type("last_name", $patient2->last_name)
                ->select("gender", $patient2->gender)
                ->type("birth_date", $patient2->birth_date)
                ->uncheck("schooled")
                ->type("notes", $patient2->notes)
                ->press('Update')
                ->assertRouteIs('admin.patients.index')
                ->assertSeeIn("tr:last-child td[field-key='first_name']", $patient2->first_name)
                ->assertSeeIn("tr:last-child td[field-key='last_name']", $patient2->last_name)
                ->assertSeeIn("tr:last-child td[field-key='gender']", $patient2->gender)
                ->assertSeeIn("tr:last-child td[field-key='birth_date']", $patient2->birth_date)
                ->assertNotChecked("schooled")
                ->assertSeeIn("tr:last-child td[field-key='notes']", $patient2->notes);
        });
    }

    public function testShowPatient()
    {
        $admin = factory('App\User', 'admin')->create();
        $patient = factory('App\Patient')->create();

        


        $this->browse(function (Browser $browser) use ($admin, $patient) {
            $browser->loginAs($admin)
                ->visit(route('admin.patients.index'))
                ->click('tr[data-entry-id="' . $patient->id . '"] .btn-primary')
                ->assertSeeIn("td[field-key='first_name']", $patient->first_name)
                ->assertSeeIn("td[field-key='last_name']", $patient->last_name)
                ->assertSeeIn("td[field-key='gender']", $patient->gender)
                ->assertSeeIn("td[field-key='birth_date']", $patient->birth_date)
                ->assertChecked("schooled")
                ->assertSeeIn("td[field-key='notes']", $patient->notes);
        });
    }

}
