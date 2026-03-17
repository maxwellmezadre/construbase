<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Admins\Pages;

use App\Filament\Admin\Resources\Admins\AdminResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateAdmin extends CreateRecord
{
    #[Override]
    protected static string $resource = AdminResource::class;
}
