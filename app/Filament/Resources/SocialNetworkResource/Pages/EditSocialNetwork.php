<?php

namespace App\Filament\Resources\SocialNetworkResource\Pages;

use App\Filament\Resources\SocialNetworkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialNetwork extends EditRecord
{
    protected static string $resource = SocialNetworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
