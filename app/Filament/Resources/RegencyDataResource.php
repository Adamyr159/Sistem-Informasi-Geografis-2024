<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegencyDataResource\Pages;
use App\Filament\Resources\RegencyDataResource\RelationManagers;
use App\Models\RegencyData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegencyDataResource extends Resource
{
    protected static ?string $model = RegencyData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Geo Data';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('regency_id')
                    ->label('Regency')
                    ->relationship('regency', 'name')
                    ->required()
                    ->preload(),

                Forms\Components\Select::make('name_data_id')
                    ->label('Name Data')
                    ->relationship('nameData', 'name')
                    ->required()
                    ->preload(),

                Forms\Components\TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->defaultGroup('regency.name')
            ->groups([
                Tables\Grouping\Group::make('regency.name')->titlePrefixedWithLabel(false)->collapsible()
            ])
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->label('ID')
                //     ->sortable(),

                // Tables\Columns\TextColumn::make('regency.name')
                //     ->label('Regency')
                //     ->sortable()
                //     ->searchable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nameData.name')
                    ->label('Name Data')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn(string $state): string => number_format((int) $state, 0, ',', '.'))
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListRegencyData::route('/'),
            'create' => Pages\CreateRegencyData::route('/create'),
            'edit' => Pages\EditRegencyData::route('/{record}/edit'),
        ];
    }
}
