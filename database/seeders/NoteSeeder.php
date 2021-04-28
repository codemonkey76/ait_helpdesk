<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Note;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = User::first()->id;

        Company::each(fn($company) =>
            Note::factory()
                ->count(mt_rand(1,5))
                ->create([
                    'user_id' => $userId,
                    'noteable_id' => $company->id,
                    'noteable_type' => $company->getMorphClass()
                    ])
        );

        Organization::each(fn($org) =>
        Note::factory()
            ->count(mt_rand(1,5))
            ->create([
                'user_id' => $userId,
                'noteable_id' => $org->id,
                'noteable_type' => $org->getMorphClass()
            ])
        );
    }
}
