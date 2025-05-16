<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtkinlikYönetimiResource\Pages;
use App\Filament\Resources\EtkinlikYönetimiResource\RelationManagers;
use App\Models\EtkinlikYönetimi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EtkinlikYönetimiResource extends Resource
{
    protected static ?string $model = EtkinlikYönetimi::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Etkinlik Yönetimi';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListEtkinlikYönetimis::route('/'),
            'create' => Pages\CreateEtkinlikYönetimi::route('/create'),
            'edit' => Pages\EditEtkinlikYönetimi::route('/{record}/edit'),
        ];
    }
}
