<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('about'),

                Forms\Components\TextInput::make('link'),

                Forms\Components\Textarea::make('description')
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
//                    ->image()
                    ->required(),

                Forms\Components\Toggle::make('show_in_homepage')
                    ->label('Show In Homepage')
                    ->default(false),

                Forms\Components\Toggle::make('published')
                    ->label('Published')
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('about'),
                Tables\Columns\TextColumn::make('link'),

                ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable()
                    ->toggleable(),

                ToggleColumn::make('show_in_homepage')
                    ->label('Show In Homepage')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->toggleable(),


            ])
            ->filters([

                Tables\Filters\Filter::make('published_in_homepage')
                    ->query(fn (Builder $query): Builder => $query->where('show_in_homepage', true)),
                Tables\Filters\Filter::make('hidden_in_homepage')
                    ->query(fn (Builder $query): Builder => $query->where('show_in_homepage', false)),

                Tables\Filters\Filter::make('published')
                    ->query(fn (Builder $query): Builder => $query->where('published', true)),
                Tables\Filters\Filter::make('unpublished')
                    ->query(fn (Builder $query): Builder => $query->where('published', false)),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}
