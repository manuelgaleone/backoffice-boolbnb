<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsored;
use Illuminate\Support\Str;

class SponsoredSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsoreds = config('homes_sponsoreds');
        foreach ($sponsoreds as $sponsored) {
            $new_sponsored = new Sponsored();
            $new_sponsored->title = $sponsored['title'];
            $new_sponsored->slug = Str::slug($sponsored['title'], '-');
            $new_sponsored->price = $sponsored['price'];
            $new_sponsored->duration = $sponsored['duration'];
            $new_sponsored->save();
        }
    }
}
