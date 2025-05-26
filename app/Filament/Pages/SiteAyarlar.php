<?php

// Bu dosya, Filament yönetici paneli için site ayarları sayfasını tanımlar.

namespace App\Filament\Pages;


use App\Models\Ayarlar;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;

class SiteAyarlar extends Page implements Forms\Contracts\HasForms
{

    use Forms\Concerns\InteractsWithForms;
    // Formlarla etkileşim için gerekli trait'i kullanır.

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    // Sol menüde sayfa için kullanılacak ikonu belirler.
    protected static ?string $navigationLabel = 'Ayarlar';
    // Sol menüde sayfanın görünen adını belirler.
    protected static ?string $navigationGroup = null;
    // Sayfanın menüde hangi gruba ait olduğunu belirler
    protected static ?int $navigationSort = 5;
    // Menüdeki sıralamasını belirler.
    protected static string $view = 'filament.pages.site-ayarlar';
    // Sayfanın Blade (view) dosyasının yolunu belirtir.
    protected static ?string $title = 'Site Ayarları';
    // Sayfanın başlığını belirler.

    public ?Ayarlar $ayar;
    // Sayfa için 'Ayarlar' modelinden bir özellik tanımlar.

    public array $data = [];
    // Form verilerini depolamak için bir dizi tanımlar.

    public function mount(): void
    {
        // Sayfa yüklendiğinde bu metot çalışır.
        $this->ayar = Ayarlar::firstOrCreate([]);
        // 'Ayarlar' kaydını bulur veya yoksa yeni bir tane oluşturur.
        $this->fillForm(); // form nesnesi dolmadan çağırma!
        // Formu mevcut ayar verileriyle doldurur.
    }

    protected function fillForm(): void
    {
        // Form alanlarını 'ayar' modelindeki verilerle doldurur.
        $this->data = [
            'site_adi' => $this->ayar->site_adi,
            'site_mail' => $this->ayar->site_mail,
            'facebook' => $this->ayar->facebook,
            'twitter' => $this->ayar->twitter,
            'instagram' => $this->ayar->instagram,
            'linkedin' => $this->ayar->linkedin,
            'firma_adi' => $this->ayar->firma_adi,
            'telefon' => $this->ayar->telefon,
            'adres' => $this->ayar->adres,
            'vergi_no' => $this->ayar->vergi_no,
            'hakkimda' => $this->ayar->hakkimda, // yeni alan
        ];
    }

    public function form(Form $form): Form
    {
        // Form yapısını tanımlar.
        return $form
            ->schema($this->getFormSchema())
            // Form şemasını 'getFormSchema' metodundan alır.
            ->statePath('data'); // form verilerini 'data' içinde sakla
        // Form verilerinin 'data' özelliğinde saklanacağını belirtir.
    }

    protected function getFormSchema(): array
    {
        // Formun görsel düzenini ve alanlarını tanımlayan şemayı döndürür.
        return [
            Section::make('Genel Bilgiler')->schema([
                // 'Genel Bilgiler' başlığı altında bir bölüm oluşturur.
                Grid::make(2)->schema([
                    // İçine 2 sütunlu bir ızgara yerleştirir.
                    TextInput::make('site_adi')->label('Site Adı'),
                    // 'Site Adı' girişi ekler.
                    TextInput::make('site_mail')->label('Site Maili'),
                    // 'Site Maili' girişi ekler.
                ]),
            ]),

            Section::make('Sosyal Medya')->schema([
                Grid::make(2)->schema([
                    TextInput::make('facebook'),
                    TextInput::make('twitter'),
                    TextInput::make('instagram'),
                    TextInput::make('linkedin'),
                ]),
            ]),

            Section::make('Kurumsal Bilgiler')->schema([
                Grid::make(2)->schema([
                    TextInput::make('firma_adi')->label('Firma Adı'),
                    TextInput::make('telefon'),
                    Textarea::make('adres')->rows(2),
                    TextInput::make('vergi_no')->label('Vergi No'),
                ]),
            ]),

            Section::make('Hakkımda')->schema([
                Textarea::make('hakkimda')->label('Hakkımda')->rows(5),
            ]),
        ];
    }

    public function submit(): void
    {
        // Form gönderildiğinde bu metot çalışır.
        $this->ayar->update($this->data);
        // 'Ayarlar' modelini formdan gelen verilerle günceller.

        Notification::make()
            // Kullanıcıya bir bildirim gösterir.
            ->title('Ayarlar başarıyla güncellendi.')
            ->success()
            ->send();
    }

}
