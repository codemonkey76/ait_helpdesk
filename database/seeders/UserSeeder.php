<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Company;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supportTeam = Team::whereName('support')->first();
        $salesTeam = Team::whereName('sales')->first();
        $accountsTeam = Team::whereName('accounts')->first();


        $ait = Company::whereName('Alpha IT Centre')->first();
        $shane = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Shane Poppleton',
                'email'                 => 'shane@alphasg.com.au',
                'phone'                 => '0400 588 588',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
                'terms'                 => true
            ])
            ->assignRole(['admin', 'agent', 'user', 'restricted user']);
        $shane->update(['email_verified_at' => now()]);
        $shane->companies()->attach($ait);

        $len = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Len Groves',
                'email'                 => 'len@alphasg.com.au',
                'phone'                 => '0438 711 559',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
                'terms'                 => true
            ])
            ->assignRole(['agent', 'user', 'restricted user']);
        $len->update(['email_verified_at' => now()]);
        $len->companies()->attach($ait);

        $theresa = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Theresa Groves',
                'email'                 => 'accounts@alphasg.com.au',
                'phone'                 => '0438 717 559',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
                'terms'                 => true
            ])
            ->assignRole(['agent', 'user', 'restricted user']);
        $theresa->update(['email_verified_at' => now()]);
        $theresa->companies()->attach($ait);

        // Create 1-3 users per company
//        Company::each(fn($company) => User::factory()
//            ->count(mt_rand(1, 3))
//            ->state(new Sequence(fn() => [['email_verified_at' => now()], ['email_verified_at' => null]][mt_rand(0, 1)]
//            ))
//            ->create(['current_team_id' => $supportTeam->id])
//            ->each(function ($user) use ($company, $supportTeam, $accountsTeam, $salesTeam) {
//                $user->companies()->attach($company->id);
//                $supportTeam->users()->attach($user, ['role' => 'editor']);
//                $accountsTeam->users()->attach($user, ['role' => 'editor']);
//                $salesTeam->users()->attach($user, ['role' => 'editor']);
//            })
//        );


        // Create some users with no company assigned
//        User::factory()
//            ->count(30)
//            ->state(new Sequence(
//                ['email_verified_at' => now()],
//                ['email_verified_at' => null]
//            ))
//            ->create(['current_team_id' => $supportTeam->id])
//            ->each(function ($user) use ($supportTeam, $accountsTeam, $salesTeam) {
//                $supportTeam->users()->attach($user, ['role' => 'editor']);
//                $accountsTeam->users()->attach($user, ['role' => 'editor']);
//                $salesTeam->users()->attach($user, ['role' => 'editor']);
//            });

        $theresa = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Test User',
                'email'                 => 'test@test.com',
                'phone'                 => '123456789',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
                'terms'                 => true
            ])
            ->assignRole(['user', 'restricted user']);

//        Ticket::factory()
//            ->count(5)
//            ->create([
//                'user_id' => $testUser->id,
//                'current_team_id' => $testUser->current_team_id
//            ]);
    }
}
