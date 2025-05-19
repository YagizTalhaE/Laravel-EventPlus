<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DuyurularResource\Pages;
use App\Models\Duyurular;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class DuyurularResource extends Resource
{
    protected static ?string $model = Duyurular::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationLabel = 'Duyurular';
    protected static ?int $navigationSort = 2;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('baslik')
                ->label('Başlık')
                ->required()
                ->maxLength(100),

            Textarea::make('icerik')
                ->label('İçerik')
                ->rows(5)
                ->required(),

            Toggle::make('aktif')
                ->label('Yayında mı?')
                ->onColor('success')
                ->offColor('gray'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('baslik')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('aktif')
                    ->boolean()
                    ->label('Yayında mı?'),

                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('aktif')
                    ->label('Yayında Olanlar')
                    ->query(fn ($query) => $query->where('aktif', true)),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDuyurular::route('/'),
            'create' => Pages\CreateDuyurular::route('/create'),
            'edit' => Pages\EditDuyurular::route('/{record}/edit'),
        ];
    }
}
