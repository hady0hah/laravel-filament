<?php

namespace App\Filament\Resources\DocsResource\Pages;

use App\Filament\Resources\DocsResource;
use App\Models\Docs;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateDocs extends CreateRecord
{
    protected static string $resource = DocsResource::class;
    public $name;
    public $file_path;
    public $image_preview;
    public $published;




}
