<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Auth;

use Override;

final class Login extends \Filament\Auth\Pages\Login
{
    #[Override]
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => true,
        ];
    }
}
