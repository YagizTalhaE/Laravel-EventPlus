<?php

// Bu dosya, Filament paneli için Duyurular modelini yöneten kaynağı (Resource) tanımlar.

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
    // Bu sınıf, 'Duyurular' modelini Filament paneli üzerinden yönetmek için kullanılır.

    protected static ?string $model = Duyurular::class;
    // Bu kaynağın hangi Eloquent modeliyle ilişkili olduğunu belirtir.

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    // Sol menüde kaynak için kullanılacak ikonu belirler.
    protected static ?string $navigationLabel = 'Duyurular';
    // Sol menüde kaynağın görünen adını belirler.
    protected static ?int $navigationSort = 2;
    // Menüdeki sıralamasını belirler.

    public static function form(Forms\Form $form): Forms\Form
    {
        // Kayıt oluşturma ve düzenleme formunun yapısını tanımlar.
        return $form->schema([
            TextInput::make('baslik')
                // 'Başlık' adında bir metin giriş alanı oluşturur.
                ->label('Başlık')
                ->required()
                ->maxLength(100),

            Textarea::make('icerik')
                // 'İçerik' adında çok satırlı bir metin alanı oluşturur.
                ->label('İçerik')
                ->rows(5)
                ->required(),

            Toggle::make('aktif')
                // 'Yayında mı?' adında bir açma/kapama anahtarı oluşturur.
                ->label('Yayında mı?')
                ->onColor('success')
                ->offColor('gray'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        // Kayıtları listeleme tablosunun yapısını tanımlar.
        return $table
            ->columns([
                TextColumn::make('baslik')
                    // 'Başlık' sütunu oluşturur ve arama/sıralama özelliklerini ekler.
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('aktif')
                    // 'Yayında mı?' sütunu oluşturur ve boolean değerleri ikon olarak gösterir.
                    ->boolean()
                    ->label('Yayında mı?'),

                TextColumn::make('created_at')
                    // 'Tarih' sütunu oluşturur ve tarih formatını belirler, sıralama özelliği ekler.
                    ->label('Tarih')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('aktif')
                    // 'Yayında Olanlar' adında bir filtre oluşturur.
                    ->label('Yayında Olanlar')
                    ->query(fn ($query) => $query->where('aktif', true)),
                // Sadece aktif olan kayıtları filtreler.
            ])
            ->actions([
                EditAction::make(),
                // Kayıtları düzenleme eylemi ekler.
                DeleteAction::make(),
                // Kayıtları silme eylemi ekler.
            ])
            ->defaultSort('created_at', 'desc');
        // Tabloyu varsayılan olarak oluşturulma tarihine göre azalan sırada sıralar.
    }

    public static function getPages(): array
    {
        // Kaynakla ilişkili sayfaları (listeleme, oluşturma, düzenleme) tanımlar.
        return [
            'index' => Pages\ListDuyurular::route('/'),
            // Duyuruları listeleme sayfası.
            'create' => Pages\CreateDuyurular::route('/create'),
            // Yeni duyuru oluşturma sayfası.
            'edit' => Pages\EditDuyurular::route('/{record}/edit'),
            // Mevcut duyuruyu düzenleme sayfası.
        ];
    }
}
