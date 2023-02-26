<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = config('homes_services');
        foreach ($services as $service) {
            $new_service = new Service();
            $new_service->title = $service['title'];
            $new_service->slug = Str::slug($service['title'], '-');
            $new_service->save();
        }
    }
}
