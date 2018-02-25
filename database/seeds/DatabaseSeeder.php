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
        factory(\App\Models\Patient::class, 80)->create();
        factory(\App\Models\PatientDetail::class,300)->create();
    }
}
