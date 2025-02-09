<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocsResource\Pages;
use App\Filament\Resources\DocsResource\RelationManagers;
use App\Models\Docs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocsResource extends Resource
{
    protected static ?string $model = Docs::class;

    protected static ?string $navigationIcon = 'heroicon-s-document';

    public static function form(Form $form): Form
    {
//        dd(request(),$form);
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file_path')
                    ->required(),
                Forms\Components\FileUpload::make('image_preview')
//                    ->image()
                    ->required(),
//                    ->acceptedFileTypes(['image/jpeg', 'image/jpg','image/png']),
                Forms\Components\Toggle::make('published')
                    ->label('Published')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        // TODO : fix the preview below in list view
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('File Path'),
//                Tables\Columns\ImageColumn::make('image_preview')
//                    ->label('Preview'),
                Tables\Columns\BooleanColumn::make('published')
                    ->label('Published')
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->placeholder('Search by name')
                            ->label('Name'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['name'])) {
                            $query->where('name', 'like', '%' . $data['name'] . '%');
                        }
                    }),
                Tables\Filters\Filter::make('published')
                    ->query(fn (Builder $query): Builder => $query->where('published', true)),
                Tables\Filters\Filter::make('unpublished')
                    ->query(fn (Builder $query): Builder => $query->where('published', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocs::route('/'),
            'create' => Pages\CreateDocs::route('/create'),
            'edit' => Pages\EditDocs::route('/{record}/edit'),
        ];
    }
}
