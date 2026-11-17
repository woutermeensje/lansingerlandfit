<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

/**
 * Maakt de eerste beheerder aan (daarna kan dat via /admin/beheerders).
 *   php artisan admin:create
 */
class CreateAdmin extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Maak een beheerder aan voor /admin';

    public function handle(): int
    {
        $name = $this->ask('Naam');
        $email = Str::lower((string) $this->ask('E-mailadres'));
        $password = $this->secret('Wachtwoord (minimaal 10 tekens)');

        $validator = Validator::make(compact('name', 'email', 'password'), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(10)],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::create(compact('name', 'email', 'password'));

        $this->info("Beheerder {$email} is aangemaakt. Log in op ".route('admin.login'));

        return self::SUCCESS;
    }
}
