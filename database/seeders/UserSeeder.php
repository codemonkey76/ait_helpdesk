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


        $shane = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Shane Poppleton',
                'email'                 => 'shane@alphasg.com.au',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123'
            ])
            ->assignRole(['admin', 'agent', 'user', 'restricted user']);
        $shane->update(['email_verified_at' => now()]);
        $shane->teams()->attach([$supportTeam->id, $salesTeam->id, $accountsTeam->id]);

        $len= app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Len Groves',
                'email'                 => 'len@alphasg.com.au',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123'
            ])
            ->assignRole(['agent', 'user', 'restricted user']);
        $len->update(['email_verified_at' => now()]);
        $len->teams()->attach([$supportTeam->id, $salesTeam->id, $accountsTeam->id]);


        // Create 1-3 users per company
        Company::each(fn($company) => User::factory()
            ->count(mt_rand(1, 3))
            ->state(new Sequence(fn() => [['email_verified_at' => now()], ['email_verified_at' => null]][mt_rand(0, 1)]
            ))
            ->create(['current_team_id' => $supportTeam->id])
            ->each(function ($user) use ($company, $supportTeam, $accountsTeam, $salesTeam) {
                $user->companies()->attach($company->id);
                $supportTeam->users()->attach($user, ['role' => 'editor']);
                $accountsTeam->users()->attach($user, ['role' => 'editor']);
                $salesTeam->users()->attach($user, ['role' => 'editor']);
            })
        );


        // Create some users with no company assigned
        User::factory()
            ->count(30)
            ->state(new Sequence(
                ['email_verified_at' => now()],
                ['email_verified_at' => null]
            ))
            ->create(['current_team_id' => $supportTeam->id])
            ->each(function($user) use ($supportTeam, $accountsTeam, $salesTeam) {
                $supportTeam->users()->attach($user, ['role' => 'editor']);
                $accountsTeam->users()->attach($user, ['role' => 'editor']);
                $salesTeam->users()->attach($user, ['role' => 'editor']);
            });

        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => now(),
            'current_team_id' => $supportTeam->id
        ]);

        $testUser->assignRole('user', 'restricted user');

        $supportTeam->users()->attach($testUser, ['role' => 'editor']);
        $accountsTeam->users()->attach($testUser, ['role' => 'editor']);
        $salesTeam->users()->attach($testUser, ['role' => 'editor']);

        Ticket::factory()
            ->count(5)
            ->create([
                'user_id' => $testUser->id,
                'current_team_id' => $testUser->current_team_id
            ]);
    }
}
