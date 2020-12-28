<?php

use Illuminate\Database\Seeder;

class WeatherEngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WeatherEngine::create(['name' => 'Default Weather / No 3rd Party Engine']);
        WeatherEngine::create(['name' => 'Active Sky Next']);
        WeatherEngine::create(['name' => 'Active Sky 2016 (32-bit for FSX/P3Dv1-3)']);
        WeatherEngine::create(['name' => 'Active Sky (64-bit for P3Dv4)']);
        WeatherEngine::create(['name' => 'REX SkyForce']);
        WeatherEngine::create(['name' => 'FS Global Real Weather']);
        WeatherEngine::create(['name' => 'FSXWX']);
        WeatherEngine::create(['name' => 'NOAA Weather Plugin for XP11']);
        WeatherEngine::create(['name' => 'XEnviro for XP11']);
        WeatherEngine::create(['name' => 'Other']);
    }
}
