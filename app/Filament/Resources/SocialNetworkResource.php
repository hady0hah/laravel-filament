<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialNetworkResource\Pages;
use App\Filament\Resources\SocialNetworkResource\RelationManagers;
use App\Models\SocialNetwork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialNetworkResource extends Resource
{
    protected static ?string $model = SocialNetwork::class;

    protected static ?string $navigationIcon = 'heroicon-s-bell-alert';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->required(),

                Forms\Components\TextInput::make('link')
                    ->required()
                    ->url(),

                Forms\Components\Toggle::make('published')
                    ->label('Published')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('link'),
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


                Tables\Filters\Filter::make('title')
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->placeholder('Search by Title')
                            ->label('Title'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['title'])) {
                            $query->where('title', 'like', '%' . $data['title'] . '%');
                        }
                    }),

                Tables\Filters\Filter::make('link')
                    ->form([
                        Forms\Components\TextInput::make('link')
                            ->placeholder('Search by Link')
                            ->label('Link'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['link'])) {
                            $query->where('link', 'like', '%' . $data['link'] . '%');
                        }
                    }),

                Tables\Filters\Filter::make('published')
                    ->query(fn (Builder $query): Builder => $query->where('published', true)),
                Tables\Filters\Filter::make('unpublished')
                    ->query(fn (Builder $query): Builder => $query->where('published', false)),


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSocialNetworks::route('/'),
            'create' => Pages\CreateSocialNetwork::route('/create'),
            'edit' => Pages\EditSocialNetwork::route('/{record}/edit'),
        ];
    }
}
