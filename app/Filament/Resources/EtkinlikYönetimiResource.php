<?php

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
    protected static ?string $model = EtkinlikYönetimi::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Etkinlik Yönetimi';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('baslik')
                ->label('Başlık')
                ->required()
                ->maxLength(255),

            Textarea::make('aciklama')
                ->label('Açıklama')
                ->rows(5),

            Textarea::make('kurallar')
                ->label('Etkinlik Kuralları')
                ->rows(4)
                ->placeholder('Etkinliğe katılım kurallarını buraya yazınız...')
                ->columnSpan(2),


            DateTimePicker::make('baslangic_tarihi')
                ->label('Başlangıç Tarihi')
                ->required(),

            DateTimePicker::make('bitis_tarihi')
                ->label('Bitiş Tarihi')
                ->required(),

            Forms\Components\Select::make('adres')
                ->label('Şehir')
                ->options(self::getSehirListesi())
                ->searchable()
                ->required(),

            Forms\Components\Select::make('tur')
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
                ->label('İlçe')
                ->maxLength(255)
                ->required(),
            TextInput::make('mekan')
                ->label('Mekan Adı')
                ->maxLength(255)
                ->required(),


            Toggle::make('aktif')
                ->label('Aktif mi?')
                ->onColor('success')
                ->offColor('danger')
                ->inline(false)
                ->default(true),


            FileUpload::make('gorsel')
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
                ->label('Popüler mi?')
                ->onColor('primary')
                ->offColor('gray')
                ->inline(false)
                ->default(false),


            Repeater::make('ticketTypes')
                ->relationship('ticketTypes')
                ->label('Bilet Türleri')
                ->schema([
                    TextInput::make('name')
                        ->label('Bilet Türü')
                        ->required(),

                    TextInput::make('price')
                        ->label('Fiyat (TL)')
                        ->numeric()
                        ->rules(['min:0'])
                        ->required()
                        ->extraInputAttributes(['min' => 0]),

                    TextInput::make('kontenjan')
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
        return $table
            ->columns([
                TextColumn::make('baslik')->label('Başlık')->searchable()->sortable(),
                TextColumn::make('tur')->label('Tür')->badge()->sortable(),
                TextColumn::make('adres')->label('Şehir')->sortable()->searchable(),
                TextColumn::make('ilce')->label('İlçe')->sortable()->searchable(),
                TextColumn::make('mekan')->label('Mekan')->searchable()->sortable(),
                TextColumn::make('baslangic_tarihi')
                    ->label('Başlangıç')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('bitis_tarihi')
                    ->label('Bitiş')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('kontenjan')
                    ->label('Kontenjan')
                    ->sortable()
                    ->alignCenter(),
                IconColumn::make('aktif')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('adres')
                    ->label('Şehir')
                    ->options(self::getSehirListesi())
                    ->searchable(),

                Tables\Filters\SelectFilter::make('tur')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('aktif_et')
                        ->label('Aktif Et')
                        ->icon('heroicon-o-check')
                        ->action(fn (Collection $records) => $records->each->update(['aktif' => true])),
                    Tables\Actions\BulkAction::make('pasif_et')
                        ->label('Pasif Et')
                        ->icon('heroicon-o-x-mark')
                        ->action(fn (Collection $records) => $records->each->update(['aktif' => false])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEtkinlikYönetimis::route('/'),
            'create' => Pages\CreateEtkinlikYönetimi::route('/create'),
            'edit' => Pages\EditEtkinlikYönetimi::route('/{record}/edit'),
        ];
    }

    protected static function getSehirListesi(): array
    {
        return [
            'Adana' => 'Adana',
            'Adıyaman' => 'Adıyaman',
            'Afyonkarahisar' => 'Afyonkarahisar',
            'Ağrı' => 'Ağrı',
            'Amasya' => 'Amasya',
            'Ankara' => 'Ankara',
            'Antalya' => 'Antalya',
            'Artvin' => 'Artvin',
            'Aydın' => 'Aydın',
            'Balıkesir' => 'Balıkesir',
            'Bilecik' => 'Bilecik',
            'Bingöl' => 'Bingöl',
            'Bitlis' => 'Bitlis',
            'Bolu' => 'Bolu',
            'Burdur' => 'Burdur',
            'Bursa' => 'Bursa',
            'Çanakkale' => 'Çanakkale',
            'Çankırı' => 'Çankırı',
            'Çorum' => 'Çorum',
            'Denizli' => 'Denizli',
            'Diyarbakır' => 'Diyarbakır',
            'Edirne' => 'Edirne',
            'Elazığ' => 'Elazığ',
            'Erzincan' => 'Erzincan',
            'Erzurum' => 'Erzurum',
            'Eskişehir' => 'Eskişehir',
            'Gaziantep' => 'Gaziantep',
            'Giresun' => 'Giresun',
            'Gümüşhane' => 'Gümüşhane',
            'Hakkâri' => 'Hakkâri',
            'Hatay' => 'Hatay',
            'Isparta' => 'Isparta',
            'Mersin' => 'Mersin',
            'İstanbul' => 'İstanbul',
            'İzmir' => 'İzmir',
            'Kars' => 'Kars',
            'Kastamonu' => 'Kastamonu',
            'Kayseri' => 'Kayseri',
            'Kırklareli' => 'Kırklareli',
            'Kırşehir' => 'Kırşehir',
            'Kocaeli' => 'Kocaeli',
            'Konya' => 'Konya',
            'Kütahya' => 'Kütahya',
            'Malatya' => 'Malatya',
            'Manisa' => 'Manisa',
            'Kahramanmaraş' => 'Kahramanmaraş',
            'Mardin' => 'Mardin',
            'Muğla' => 'Muğla',
            'Muş' => 'Muş',
            'Nevşehir' => 'Nevşehir',
            'Niğde' => 'Niğde',
            'Ordu' => 'Ordu',
            'Rize' => 'Rize',
            'Sakarya' => 'Sakarya',
            'Samsun' => 'Samsun',
            'Siirt' => 'Siirt',
            'Sinop' => 'Sinop',
            'Sivas' => 'Sivas',
            'Tekirdağ' => 'Tekirdağ',
            'Tokat' => 'Tokat',
            'Trabzon' => 'Trabzon',
            'Tunceli' => 'Tunceli',
            'Şanlıurfa' => 'Şanlıurfa',
            'Uşak' => 'Uşak',
            'Van' => 'Van',
            'Yozgat' => 'Yozgat',
            'Zonguldak' => 'Zonguldak',
            'Aksaray' => 'Aksaray',
            'Bayburt' => 'Bayburt',
            'Karaman' => 'Karaman',
            'Kırıkkale' => 'Kırıkkale',
            'Batman' => 'Batman',
            'Şırnak' => 'Şırnak',
            'Bartın' => 'Bartın',
            'Ardahan' => 'Ardahan',
            'Iğdır' => 'Iğdır',
            'Yalova' => 'Yalova',
            'Karabük' => 'Karabük',
            'Kilis' => 'Kilis',
            'Osmaniye' => 'Osmaniye',
            'Düzce' => 'Düzce',
            ];
        }
}
