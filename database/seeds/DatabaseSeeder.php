<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);
        $this->call(RoleSeedPivot::class);
        $this->call(UserSeedPivot::class);
        $this->call(ContactTypesSeed::class);
        $this->call(DesignationTypesSeed::class);
        $this->call(AppointmentTypesSeed::class);
        $this->call(AddressTypesSeed::class);
        $this->call(SettingsSeed::class);
        $this->call(PatientSeed::class);
        $this->call(ContactSeed::class);
        $this->call(AddressSeed::class);
        $this->call(AppointmentSeed::class);
        $this->call(CountrySeed::class);

    }
}
