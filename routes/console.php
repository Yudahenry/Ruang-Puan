<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('verify:user {identifier?}', function (?string $identifier = null) {
    if (!$identifier) {
        \App\Models\User::whereNull('email_verified_at')->update(['email_verified_at' => now()]);
        $this->info("All unverified users have been verified!");
        return;
    }
    $user = is_numeric($identifier) 
        ? \App\Models\User::find($identifier) 
        : \App\Models\User::where('email', $identifier)->first();

    if (!$user) {
        $this->error("User not found!");
        return;
    }
    $user->update(['email_verified_at' => now()]);
    $this->info("User {$user->email} has been verified successfully!");
});

Artisan::command('make:admin {email}', function (string $email) {
    $user = \App\Models\User::where('email', $email)->first();
    if (!$user) {
        $this->error("User with email {$email} not found!");
        return;
    }
    $user->update([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    \App\Models\Admin::firstOrCreate(
        ['user_id' => $user->id],
        ['email' => $user->email, 'password' => $user->password]
    );
    $this->info("User {$email} is now an Admin!");
});
