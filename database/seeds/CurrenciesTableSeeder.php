<?php

use Illuminate\Database\Seeder;


class CurrenciesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('currencies')->insert([
            'symbol'    => '€',
            'code'      => 'EUR',
            'name'      => 'Euro',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('currencies')->insert([
            'symbol'    => '$',
            'code'      => 'USD',
            'name'      => 'US. Dollar',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('currencies')->insert([
            'symbol'    => '£',
            'code'      => 'GBP',
            'name'      => 'British Pound',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
