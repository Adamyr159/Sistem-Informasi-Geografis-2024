<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProvinceData;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProvinceDataResource\Pages;
use App\Filament\Resources\ProvinceDataResource\RelationManagers;

class ProvinceDataResource extends Resource
{
    protected static ?string $model = ProvinceData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('year')
                    ->label('Tahun')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('name_data_id')
                    ->label('Nama Data')
                    ->relationship('nameData', 'name')
                    ->required(),
                Forms\Components\Select::make('province_id')
                    ->label('Provinsi')
                    ->relationship('province', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Jumlah')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nameData.name')
                    ->label('Nama Data')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
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
            'index' => Pages\ListProvinceData::route('/'),
            'create' => Pages\CreateProvinceData::route('/create'),
            'edit' => Pages\EditProvinceData::route('/{record}/edit'),
        ];
    }
}
