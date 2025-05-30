<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Ad;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role','user')->get();
        $ads = Ad::all();

        foreach ($ads as $ad) {
            $user = $users->random();
            Review::create([
                'ad_id'   => $ad->id,
                'user_id' => $user->id,
                'rating'  => rand(3, 5),
                'comment' => 'Great ad! Very helpful and informative.',
            ]);
        }
    }
}
