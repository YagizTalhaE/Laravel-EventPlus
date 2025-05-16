<?php

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
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Kullanıcı Onayı';
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::query()) // Tüm kullanıcılar
            ->columns([
                TextColumn::make('name')->label('Ad Soyad'),
                TextColumn::make('email')->label('E-posta'),
                IconColumn::make('is_approved')
                    ->label('Onay Durumu')
                    ->boolean()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                SelectFilter::make('onay_durumu')
                    ->label('Onay Durumu')
                    ->options([
                        'approved' => 'Onaylılar',
                        'not_approved' => 'Onaysızlar',
                    ])
                    ->query(function ($query, array $data) {
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
                    ->label('Onayla')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (User $record) {
                        $record->is_approved = true;
                        $record->save();
                    })
                    ->visible(fn (User $record) => !$record->is_approved),

                Action::make('revoke')
                    ->label('Onayı Kaldır')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->is_approved = false;
                        $record->save();
                    })
                    ->visible(fn (User $record) => $record->is_approved),

                DeleteAction::make()
                    ->label('Üyeyi Sil')
                    ->requiresConfirmation()
                    ->color('warning'),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Ad Soyad')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('E-Posta')
                    ->email()
                    ->required()
                    ->unique(),

                Forms\Components\TextInput::make('password')
                    ->label('Şifre')
                    ->password()
                    ->required()
                    ->minLength(6),

                Forms\Components\Toggle::make('is_approved')
                    ->label('Hemen Onayla')
                    ->default(true),
            ]);
    }

    public static function getModelLabel(): string
    {
        return 'Kullanıcı';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kullanıcılar';
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\KullanıcıOnayıResource\Pages\ListKullanıcıOnayları::route('/'),
            'create' => \App\Filament\Resources\KullanıcıOnayıResource\Pages\CreateKullanıcıOnayı::route('/create'),
        ];
    }
}
