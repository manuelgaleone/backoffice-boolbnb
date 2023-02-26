<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Home;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homes = config('homes');
        foreach ($homes as $home) {
            $new_home = new Home();
            $new_home->user_id = $home['user_id'];
            $new_home->title = $home['title'];
            $new_home->slug = Str::slug($home['title'], '-');
            $new_home->rooms = $home['rooms'];
            $new_home->beds = $home['beds'];
            $new_home->bathrooms = $home['bathrooms'];
            $new_home->square_meters = $home['square_meters'];
            $new_home->address = $home['address'];
            $new_home->latitude = $home['latitude'];
            $new_home->longitude = $home['longitude'];
            $new_home->cover_image = $home['cover_image'];
            $new_home->visible = $home['visible'];
            $new_home->save();
        }
    }
}
