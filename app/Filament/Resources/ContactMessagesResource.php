<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessagesResource\Pages;
use App\Filament\Resources\ContactMessagesResource\RelationManagers;
use App\Models\ContactMessages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactMessagesResource extends Resource
{
    protected static ?string $model = ContactMessages::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->maxLength(15)
                    ->tel(),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(5000),

                Forms\Components\Toggle::make('published')
                    ->label('Published')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number'),
                Tables\Columns\BooleanColumn::make('published')
                    ->label('Published')
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('subject')->limit(20),
//                Tables\Columns\TextColumn::make('message')->limit(20),
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
                            ->placeholder('Search by Name')
                            ->label('Name'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['name'])) {
                            $query->where('name', 'like', '%' . $data['name'] . '%');
                        }
                    }),
                Tables\Filters\Filter::make('email')
                    ->form([
                        Forms\Components\TextInput::make('email')
                            ->placeholder('Search by Email')
                            ->label('Email'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['email'])) {
                            $query->where('email', 'like', '%' . $data['email'] . '%');
                        }
                    }),
                Tables\Filters\Filter::make('phone_number')
                    ->form([
                        Forms\Components\TextInput::make('phone_number')
                            ->placeholder('Search by Phone')
                            ->label('Phone'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['phone_number'])) {
                            $query->where('phone_number', 'like', '%' . $data['phone_number'] . '%');
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessages::route('/create'),
            'edit' => Pages\EditContactMessages::route('/{record}/edit'),
        ];
    }
}
