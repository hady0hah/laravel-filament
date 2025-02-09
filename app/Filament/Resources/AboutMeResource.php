<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutMeResource\Pages;
use App\Filament\Resources\AboutMeResource\RelationManagers;
use App\Models\AboutMe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutMeResource extends Resource
{
    protected static ?string $model = AboutMe::class;
    protected static ?string $label = 'About Me';
    protected static ?string $pluralLabel = 'About Me';
    protected static ?string $slug = 'about-me';


    protected static ?string $navigationIcon = 'heroicon-s-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\TextInput::make('tags'),

                Forms\Components\Textarea::make('description')
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
//                    ->image()
                    ->required(),

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
                Tables\Columns\TextColumn::make('tags'),
                Tables\Columns\BooleanColumn::make('published')
                    ->label('Published')
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->date(),
            ])
            ->filters([

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
            'index' => Pages\ListAboutMes::route('/'),
            'create' => Pages\CreateAboutMe::route('/create'),
            'edit' => Pages\EditAboutMe::route('/{record}/edit'),
        ];
    }
}
