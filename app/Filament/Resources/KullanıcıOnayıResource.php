<?php

// Bu dosya, Filament paneli için 'User' modelini yöneten 'Kullanıcı Onayı' kaynağını tanımlar.

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms;
use Filament\Forms\Form;

class KullanıcıOnayıResource extends Resource
{
    // Bu sınıf, 'User' modelini Filament paneli üzerinden yönetmek için kullanılır.

    protected static ?string $model = User::class;
    // Bu kaynağın hangi Eloquent modeliyle ilişkili olduğunu belirtir.

    protected static ?string $navigationLabel = 'Kullanıcı Onayı';
    // Sol menüde kaynağın görünen adını belirler.
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    // Sol menüde kaynak için kullanılacak ikonu belirler.
    protected static ?int $navigationSort = 2;
    // Menüdeki sıralamasını belirler.

    public static function table(Table $table): Table
    {
        // Kayıtları listeleme tablosunun yapısını tanımlar.
        return $table
            ->query(User::query())
            // Tabloya 'User' modelinden veri çeker.
            ->columns([
                TextColumn::make('name')->label('Ad Soyad'),
                // 'Ad Soyad' sütunu oluşturur.
                TextColumn::make('email')->label('E-posta'),
                // 'E-posta' sütunu oluşturur.
                IconColumn::make('is_approved')
                    // 'Onay Durumu' için ikon sütunu oluşturur.
                    ->label('Onay Durumu')
                    ->boolean()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('is_admin')
                    // 'Admin' durumu için ikon sütunu oluşturur.
                    ->label('Admin')
                    ->boolean()
                    ->trueIcon('heroicon-s-shield-check')
                    ->falseIcon('heroicon-o-shield-check')
                    ->trueColor('info')
                    ->falseColor('gray'),
            ])
            ->filters([
                SelectFilter::make('onay_durumu')
                    // 'Onay Durumu' için bir filtre oluşturur.
                    ->label('Onay Durumu')
                    ->options([
                        'approved' => 'Onaylılar',
                        'not_approved' => 'Onaysızlar',
                    ])
                    ->query(function ($query, array $data) {
                        // Filtreleme mantığını tanımlar.
                        if (($data['value'] ?? null) === 'approved') {
                            return $query->where('is_approved', true);
                        } elseif (($data['value'] ?? null) === 'not_approved') {
                            return $query->where('is_approved', false);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Action::make('approve')
                    // 'Onayla' eylemi ekler.
                    ->label('Onayla')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (User $record) {
                        $record->is_approved = true;
                        $record->save();
                    })
                    ->visible(fn (User $record) => !$record->is_approved),

                Action::make('revoke')
                    // 'Onayı Kaldır' eylemi ekler.
                    ->label('Onayı Kaldır')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->is_approved = false;
                        $record->save();
                    })
                    ->visible(fn (User $record) => $record->is_approved),

                Action::make('make_admin')
                    // 'Admin Yap' eylemi ekler.
                    ->label('Admin Yap')
                    ->icon('heroicon-o-shield-check')
                    ->color('info')
                    ->action(function (User $record) {
                        $record->is_admin = true;
                        $record->save();
                    })
                    ->visible(fn (User $record) => !$record->is_admin),

                Action::make('remove_admin')
                    // 'Adminliği Kaldır' eylemi ekler.
                    ->label('Adminliği Kaldır')
                    ->icon('heroicon-s-shield-exclamation')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->is_admin = false;
                        $record->save();
                    })
                    ->visible(fn (User $record) => $record->is_admin),

                DeleteAction::make()
                    // 'Üyeyi Sil' eylemi ekler.
                    ->label('Üyeyi Sil')
                    ->requiresConfirmation()
                    ->color('warning'),
            ]);
    }

    public static function form(Form $form): Form
    {
        // Kayıt oluşturma ve düzenleme formunun yapısını tanımlar.
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    // 'Ad Soyad' metin giriş alanı.
                    ->label('Ad Soyad')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    // 'E-Posta' metin giriş alanı.
                    ->label('E-Posta')
                    ->email()
                    ->required()
                    ->unique(),

                Forms\Components\TextInput::make('password')
                    // 'Şifre' metin giriş alanı.
                    ->label('Şifre')
                    ->password()
                    ->required()
                    ->minLength(6),

                Forms\Components\Toggle::make('is_approved')
                    // 'Hemen Onayla' açma/kapama anahtarı.
                    ->label('Hemen Onayla')
                    ->default(true),

                Forms\Components\Toggle::make('is_admin')
                    // 'Admin Yetkisi Ver' açma/kapama anahtarı.
                    ->label('Admin Yetkisi Ver')
                    ->default(false),
            ]);
    }

    public static function getModelLabel(): string
    {
        // Modelin tekil etiketini döndürür.
        return 'Kullanıcı';
    }

    public static function getPluralModelLabel(): string
    {
        // Modelin çoğul etiketini döndürür.
        return 'Kullanıcılar';
    }

    public static function getPages(): array
    {
        // Kaynakla ilişkili sayfaları (listeleme, oluşturma) tanımlar.
        return [
            'index' => \App\Filament\Resources\KullanıcıOnayıResource\Pages\ListKullanıcıOnayları::route('/'),
            // Kullanıcıları listeleme sayfası.
            'create' => \App\Filament\Resources\KullanıcıOnayıResource\Pages\CreateKullanıcıOnayı::route('/create'),
            // Yeni kullanıcı oluşturma sayfası.
        ];
    }
}
