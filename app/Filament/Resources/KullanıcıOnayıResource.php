<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KullanıcıOnayıResource\Pages;
use App\Filament\Resources\KullanıcıOnayıResource\RelationManagers;
use App\Models\KullanıcıOnayı;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KullanıcıOnayıResource extends Resource
{
    protected static ?string $model = KullanıcıOnayı::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Kullanıcı Onayı';
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
            'index' => Pages\ListKullanıcıOnayıs::route('/'),
            'create' => Pages\CreateKullanıcıOnayı::route('/create'),
            'edit' => Pages\EditKullanıcıOnayı::route('/{record}/edit'),
        ];
    }
}
