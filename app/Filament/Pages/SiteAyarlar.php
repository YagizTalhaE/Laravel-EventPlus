<?php

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

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Ayarlar';
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 5;
    protected static string $view = 'filament.pages.site-ayarlar';
    protected static ?string $title = 'Site Ayarları';

    public ?Ayarlar $ayar;

    public array $data = [];

    public function mount(): void
    {
        $this->ayar = Ayarlar::firstOrCreate([]);
        $this->fillForm(); // form nesnesi dolmadan çağırma!
    }

    protected function fillForm(): void
    {
        $this->data = [
            'site_adi' => $this->ayar->site_adi,
            'site_mail' => $this->ayar->site_mail,
            'bakim_modu' => $this->ayar->bakim_modu,
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
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data'); // form verilerini 'data' içinde sakla
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Genel Bilgiler')->schema([
                Grid::make(2)->schema([
                    TextInput::make('site_adi')->label('Site Adı'),
                    TextInput::make('site_mail')->label('Site Maili'),
                    Toggle::make('bakim_modu')->label('Bakım Modu'),
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
        $this->ayar->update($this->data);

        Notification::make()
            ->title('Ayarlar başarıyla güncellendi.')
            ->success()
            ->send();
    }

}
