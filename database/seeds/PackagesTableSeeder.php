<?php

use App\Package;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'name'       => 'Basic',
            'price'      => '1000000',
            'wallet'     => '200',
            'creator_id' => 1,
        ]);
        Package::create([
            'name'       => 'Medium',
            'price'      => '5000000',
            'wallet'     => '2600',
            'creator_id' => 1,
        ]);
        Package::create([
            'name'       => 'Advanced',
            'price'      => '10000000',
            'wallet'     => '5600',
            'creator_id' => 1,
        ]);
    }
}
