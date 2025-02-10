<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnologyResource\Pages;
use App\Filament\Resources\TechnologyResource\RelationManagers;
use App\Models\Technology;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static ?string $navigationIcon = 'heroicon-s-code-bracket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
                    ->image()
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

                Tables\Columns\TextColumn::make('name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('image_path')
                    ->label('Image Preview')
                    ->toggleable(),

                ToggleColumn::make('published')
                    ->label('Published')
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

                Filter::make('created_at')
                    ->label('Created Date')
                    ->form([
                        Forms\Components\Group::make([
                            Forms\Components\DatePicker::make('start')
                                ->label('Start Date')
                                ->placeholder('Select start date')
                                ->extraAttributes(['class' => 'custom-label-class']),
                            Forms\Components\DatePicker::make('end')
                                ->label('End Date')
                                ->placeholder('Select end date')
                                ->extraAttributes(['class' => 'custom-label-class']),
                        ])->columns(2),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start'], fn($q, $start) => $q->whereDate('created_at', '>=', $start))
                            ->when($data['end'], fn($q, $end) => $q->whereDate('created_at', '<=', $end));
                    }),

                Filter::make('updated_at')
                    ->label('Updated Date')
                    ->form([
                        Forms\Components\Group::make([
                            Forms\Components\DatePicker::make('start')
                                ->label('Start Date')
                                ->placeholder('Select start date'),
                            Forms\Components\DatePicker::make('end')
                                ->label('End Date')
                                ->placeholder('Select end date'),
                        ])->columns(2),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start'], fn($q, $start) => $q->whereDate('updated_at', '>=', $start))
                            ->when($data['end'], fn($q, $end) => $q->whereDate('updated_at', '<=', $end));
                    }),

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
            'index' => Pages\ListTechnologies::route('/'),
            'create' => Pages\CreateTechnology::route('/create'),
            'edit' => Pages\EditTechnology::route('/{record}/edit'),
        ];
    }
}
