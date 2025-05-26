<?php

// Bu dosya, Filament paneli için Etkinlik Yönetimi modelini yöneten kaynağı (Resource) tanımlar.

namespace App\Filament\Resources;

use App\Filament\Resources\EtkinlikYönetimiResource\Pages;
use App\Models\EtkinlikYönetimi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Repeater;


class EtkinlikYönetimiResource extends Resource
{
    // Bu sınıf, 'EtkinlikYönetimi' modelini Filament paneli üzerinden yönetmek için kullanılır.

    protected static ?string $model = EtkinlikYönetimi::class;
    // Bu kaynağın hangi Eloquent modeliyle ilişkili olduğunu belirtir.

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    // Sol menüde kaynak için kullanılacak ikonu belirler.
    protected static ?string $navigationLabel = 'Etkinlik Yönetimi';
    // Sol menüde kaynağın görünen adını belirler.
    protected static ?int $navigationSort = 3;
    // Menüdeki sıralamasını belirler.

    public static function form(Form $form): Form
    {
        // Kayıt oluşturma ve düzenleme formunun yapısını tanımlar.
        return $form->schema([
            TextInput::make('baslik')
                // 'Başlık' adında bir metin giriş alanı oluşturur.
                ->label('Başlık')
                ->required()
                ->maxLength(255),

            Textarea::make('aciklama')
                // 'Açıklama' adında çok satırlı bir metin alanı oluşturur.
                ->label('Açıklama')
                ->rows(5),

            Textarea::make('kurallar')
                // 'Etkinlik Kuralları' metin alanı oluşturur.
                ->label('Etkinlik Kuralları')
                ->rows(4)
                ->placeholder('Etkinliğe katılım kurallarını buraya yazınız...')
                ->columnSpan(2),


            DateTimePicker::make('baslangic_tarihi')
                // 'Başlangıç Tarihi' için tarih ve saat seçici oluşturur.
                ->label('Başlangıç Tarihi')
                ->required(),

            DateTimePicker::make('bitis_tarihi')
                // 'Bitiş Tarihi' için tarih ve saat seçici oluşturur.
                ->label('Bitiş Tarihi')
                ->required(),

            Forms\Components\Select::make('adres')
                // 'Şehir' seçimi için bir açılır liste oluşturur.
                ->label('Şehir')
                ->options(self::getSehirListesi())
                ->searchable()
                ->required(),

            Forms\Components\Select::make('tur')
                // 'Etkinlik Türü' seçimi için bir açılır liste oluşturur.
                ->label('Etkinlik Türü')
                ->options([
                    'muzik' => 'Müzik',
                    'sinema' => 'Sinema',
                    'tiyatro' => 'Tiyatro',
                    'spor' => 'Spor',
                    'egitim' => 'Eğitim',
                    'atolye' => 'Atölye',
                    'diger' => 'Diğer',
                ])
                ->searchable()
                ->required(),
            TextInput::make('ilce')
                // 'İlçe' adında bir metin giriş alanı oluşturur.
                ->label('İlçe')
                ->maxLength(255)
                ->required(),
            TextInput::make('mekan')
                // 'Mekan Adı' adında bir metin giriş alanı oluşturur.
                ->label('Mekan Adı')
                ->maxLength(255)
                ->required(),


            Toggle::make('aktif')
                // 'Aktif mi?' adında bir açma/kapama anahtarı oluşturur.
                ->label('Aktif mi?')
                ->onColor('success')
                ->offColor('danger')
                ->inline(false)
                ->default(true),


            FileUpload::make('gorsel')
                // 'Etkinlik Görseli' yüklemek için dosya yükleme alanı oluşturur.
                ->label('Etkinlik Görseli')
                ->directory('etkinlikler')
                ->image()
                ->imageEditor()
                ->preserveFilenames()
                ->downloadable()
                ->previewable(true)
                ->openable()
                ->nullable(),



            Toggle::make('populer_mi')
                // 'Popüler mi?' adında bir açma/kapama anahtarı oluşturur.
                ->label('Popüler mi?')
                ->onColor('primary')
                ->offColor('gray')
                ->inline(false)
                ->default(false),


            Repeater::make('ticketTypes')
                // 'Bilet Türleri' için tekrarlayıcı bir alan oluşturur.
                ->relationship('ticketTypes')
                ->label('Bilet Türleri')
                ->schema([
                    TextInput::make('name')
                        // Bilet türü adı girişi.
                        ->label('Bilet Türü')
                        ->required(),

                    TextInput::make('price')
                        // Bilet fiyatı girişi.
                        ->label('Fiyat (TL)')
                        ->numeric()
                        ->rules(['min:0'])
                        ->required()
                        ->extraInputAttributes(['min' => 0]),

                    TextInput::make('kontenjan')
                        // Bilet kontenjanı girişi.
                        ->label('Kontenjan')
                        ->numeric()
                        ->required()
                        ->extraInputAttributes(['min' => 0, 'max' => 1000000]),
                ])
                ->collapsible()
                ->createItemButtonLabel('Yeni Bilet Türü Ekle')
                ->columns(3)
                ->columnSpanFull(),

        ]);

    }

    public static function table(Table $table): Table
    {
        // Kayıtları listeleme tablosunun yapısını tanımlar.
        return $table
            ->columns([
                TextColumn::make('baslik')->label('Başlık')->searchable()->sortable(),
                // 'Başlık' sütunu oluşturur.
                TextColumn::make('tur')->label('Tür')->badge()->sortable(),
                // 'Tür' sütunu oluşturur.
                TextColumn::make('adres')->label('Şehir')->sortable()->searchable(),
                // 'Şehir' sütunu oluşturur.
                TextColumn::make('ilce')->label('İlçe')->sortable()->searchable(),
                // 'İlçe' sütunu oluşturur.
                TextColumn::make('mekan')->label('Mekan')->searchable()->sortable(),
                // 'Mekan' sütunu oluşturur.
                TextColumn::make('baslangic_tarihi')
                    // 'Başlangıç' tarihi sütunu oluşturur.
                    ->label('Başlangıç')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('bitis_tarihi')
                    // 'Bitiş' tarihi sütunu oluşturur.
                    ->label('Bitiş')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('kontenjan')
                    // 'Kontenjan' sütunu oluşturur.
                    ->label('Kontenjan')
                    ->sortable()
                    ->alignCenter(),
                IconColumn::make('aktif')->label('Aktif')->boolean(),
                // 'Aktif' durumu için ikon sütunu oluşturur.
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('adres')
                    // 'Şehir' için filtre oluşturur.
                    ->label('Şehir')
                    ->options(self::getSehirListesi())
                    ->searchable(),

                Tables\Filters\SelectFilter::make('tur')
                    // 'Etkinlik Türü' için filtre oluşturur.
                    ->label('Etkinlik Türü')
                    ->options([
                        'muzik' => 'Müzik',
                        'sinema' => 'Sinema',
                        'tiyatro' => 'Tiyatro',
                        'spor' => 'Spor',
                        'egitim' => 'Eğitim',
                        'atolye' => 'Atölye',
                        'diger' => 'Diğer',
                    ])
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Kayıtları düzenleme eylemi ekler.
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Toplu silme eylemi ekler.
                    Tables\Actions\BulkAction::make('aktif_et')
                        // Toplu 'Aktif Et' eylemi ekler.
                        ->label('Aktif Et')
                        ->icon('heroicon-o-check')
                        ->action(fn (Collection $records) => $records->each->update(['aktif' => true])),
                    Tables\Actions\BulkAction::make('pasif_et')
                        // Toplu 'Pasif Et' eylemi ekler.
                        ->label('Pasif Et')
                        ->icon('heroicon-o-x-mark')
                        ->action(fn (Collection $records) => $records->each->update(['aktif' => false])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        // Kaynakla ilişkili ilişkileri tanımlar (şu an boş).
        return [];
    }

    public static function getPages(): array
    {
        // Kaynakla ilişkili sayfaları (listeleme, oluşturma, düzenleme) tanımlar.
        return [
            'index' => Pages\ListEtkinlikYönetimis::route('/'),
            // Etkinlikleri listeleme sayfası.
            'create' => Pages\CreateEtkinlikYönetimi::route('/create'),
            // Yeni etkinlik oluşturma sayfası.
            'edit' => Pages\EditEtkinlikYönetimi::route('/{record}/edit'),
            // Mevcut etkinliği düzenleme sayfası.
        ];
    }

    protected static function getSehirListesi(): array
    {
        // Türkiye'deki şehirlerin listesini döndürür.
        return [
            'Adana' => 'Adana', 'Adıyaman' => 'Adıyaman', 'Afyonkarahisar' => 'Afyonkarahisar', 'Ağrı' => 'Ağrı',
            'Amasya' => 'Amasya', 'Ankara' => 'Ankara', 'Antalya' => 'Antalya', 'Artvin' => 'Artvin',
            'Aydın' => 'Aydın', 'Balıkesir' => 'Balıkesir', 'Bilecik' => 'Bilecik', 'Bingöl' => 'Bingöl',
            'Bitlis' => 'Bitlis', 'Bolu' => 'Bolu', 'Burdur' => 'Burdur', 'Bursa' => 'Bursa',
            'Çanakkale' => 'Çanakkale', 'Çankırı' => 'Çankırı', 'Çorum' => 'Çorum', 'Denizli' => 'Denizli',
            'Diyarbakır' => 'Diyarbakır', 'Edirne' => 'Edirne', 'Elazığ' => 'Elazığ', 'Erzincan' => 'Erzincan',
            'Erzurum' => 'Erzurum', 'Eskişehir' => 'Eskişehir', 'Gaziantep' => 'Gaziantep', 'Giresun' => 'Giresun',
            'Gümüşhane' => 'Gümüşhane', 'Hakkâri' => 'Hakkâri', 'Hatay' => 'Hatay', 'Isparta' => 'Isparta',
            'Mersin' => 'Mersin', 'İstanbul' => 'İstanbul', 'İzmir' => 'İzmir', 'Kars' => 'Kars',
            'Kastamonu' => 'Kastamonu', 'Kayseri' => 'Kayseri', 'Kırklareli' => 'Kırklareli', 'Kırşehir' => 'Kırşehir',
            'Kocaeli' => 'Kocaeli', 'Konya' => 'Konya', 'Kütahya' => 'Kütahya', 'Malatya' => 'Malatya',
            'Manisa' => 'Manisa', 'Kahramanmaraş' => 'Kahramanmaraş', 'Mardin' => 'Mardin', 'Muğla' => 'Muğla',
            'Muş' => 'Muş', 'Nevşehir' => 'Nevşehir', 'Niğde' => 'Niğde', 'Ordu' => 'Ordu',
            'Rize' => 'Rize', 'Sakarya' => 'Sakarya', 'Samsun' => 'Samsun', 'Siirt' => 'Siirt',
            'Sinop' => 'Sinop', 'Sivas' => 'Sivas', 'Tekirdağ' => 'Tekirdağ', 'Tokat' => 'Tokat',
            'Trabzon' => 'Trabzon', 'Tunceli' => 'Tunceli', 'Şanlıurfa' => 'Şanlıurfa', 'Uşak' => 'Uşak',
            'Van' => 'Van', 'Yozgat' => 'Yozgat', 'Zonguldak' => 'Zonguldak', 'Aksaray' => 'Aksaray',
            'Bayburt' => 'Bayburt', 'Karaman' => 'Karaman', 'Kırıkkale' => 'Kırıkkale', 'Batman' => 'Batman',
            'Şırnak' => 'Şırnak', 'Bartın' => 'Bartın', 'Ardahan' => 'Ardahan', 'Iğdır' => 'Iğdır',
            'Yalova' => 'Yalova', 'Karabük' => 'Karabük', 'Kilis' => 'Kilis', 'Osmaniye' => 'Osmaniye',
            'Düzce' => 'Düzce',
        ];
    }
}
