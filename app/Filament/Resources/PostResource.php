<?php

// Bu dosya, Filament paneli için 'Post' modelini yöneten kaynağı (Resource) tanımlar.

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    // Bu sınıf, 'Post' modelini Filament paneli üzerinden yönetmek için kullanılır.

    protected static ?string $model = Post::class;
    // Bu kaynağın hangi Eloquent modeliyle ilişkili olduğunu belirtir.

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // Sol menüde kaynak için kullanılacak ikonu belirler.

    public static function form(Form $form): Form
    {
        // Kayıt oluşturma ve düzenleme formunun yapısını tanımlar.
        return $form
            ->schema([
                // Form alanları buraya eklenecek.
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        // Bu kaynağın sol menüde gösterilip gösterilmeyeceğini belirler.
        return false;
    }

    public static function table(Table $table): Table
    {
        // Kayıtları listeleme tablosunun yapısını tanımlar.
        return $table
            ->columns([
                // Tablo sütunları buraya eklenecek.
            ])
            ->filters([
                // Tablo filtreleri buraya eklenecek.
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Kayıtları düzenleme eylemi ekler.
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Toplu silme eylemi ekler.
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        // Kaynakla ilişkili ilişkileri tanımlar (şu an boş).
        return [
            // İlişki yöneticileri buraya eklenecek.
        ];
    }

    public static function getPages(): array
    {
        // Kaynakla ilişkili sayfaları (listeleme, oluşturma, düzenleme) tanımlar.
        return [
            'index' => Pages\ListPosts::route('/'),
            // Gönderileri listeleme sayfası.
            'create' => Pages\CreatePost::route('/create'),
            // Yeni gönderi oluşturma sayfası.
            'edit' => Pages\EditPost::route('/{record}/edit'),
            // Mevcut gönderiyi düzenleme sayfası.
        ];
    }
}
