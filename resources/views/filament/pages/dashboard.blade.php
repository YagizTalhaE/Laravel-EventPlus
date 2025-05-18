<x-filament::page>

    {{-- İstatistikler --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @php
            $totalUsers = \App\Models\User::count();
            $approvedUsers = \App\Models\User::where('is_approved', true)->count();
            $unapprovedUsers = \App\Models\User::where('is_approved', false)->count();
        @endphp

        <x-filament::card>
            <div class="flex items-center space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A9.956 9.956 0 0112 15c2.21 0 4.243.717 5.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div>
                    <div class="text-sm text-black dark:text-white">Toplam Kullanıcı</div>
                    <div class="text-lg font-bold">{{ $totalUsers }}</div>
                </div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="flex items-center space-x-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <div class="text-sm text-black dark:text-white">Onaylı Kullanıcı</div>
                    <div class="text-lg font-bold">{{ $approvedUsers }}</div>
                </div>
            </div>
        </x-filament::card>

        <x-filament::card>
            <div class="flex items-center space-x-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div>
                    <div class="text-sm text-black dark:text-white">Onaysız Kullanıcı</div>
                    <div class="text-lg font-bold">{{ $unapprovedUsers }}</div>
                </div>
            </div>
        </x-filament::card>
    </div>

    <x-filament::card class="mb-6">
        <div class="text-lg font-bold px-4 py-2 rounded mb-4 text-black dark:text-white bg-gray-100 dark:bg-gray-800">
            Son Kullanıcılar
        </div>

        <ul class="divide-y divide-gray-700 dark:divide-gray-200">
            @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                <li class="py-2 flex justify-between">
                    <span class="text-black dark:text-white">{{ $user->name }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                </li>
            @endforeach
        </ul>
    </x-filament::card>


    {{-- ✅ Onay Bekleyen Kullanıcılar --}}
    <x-filament::card class="mb-6">
        <div class="flex items-center justify-between text-lg font-bold px-4 py-2 rounded mb-4 text-black dark:text-white bg-gray-100 dark:bg-gray-800">
            <span>Onay Bekleyen Kullanıcılar</span>
            <a
                href="{{ \App\Filament\Resources\KullanıcıOnayıResource::getUrl() . '?tableFilters[is_approved]=0' }}"
                class="text-sm text-primary-600 hover:underline"
            >
                Tümünü Gör
            </a>
        </div>

        <ul class="divide-y divide-gray-100">
            @forelse(\App\Models\User::where('is_approved', false)->latest()->take(5)->get() as $user)
                <li class="py-2 flex justify-between">
                    <span>{{ $user->name }}</span>
                    <span class="text-sm text-gray-500">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                </li>
            @empty
                <li class="py-2 text-sm text-gray-500">Bekleyen kullanıcı yok.</li>
            @endforelse
        </ul>
    </x-filament::card>


    {{-- Hızlı Erişim --}}
    <x-filament::card class="mb-6">
        <x-slot name="header">Hızlı Erişim</x-slot>
        <div class="flex flex-wrap gap-4">
            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Resources\KullanıcıOnayıResource::getUrl() }}"
                icon="heroicon-o-users"
            >
                Kullanıcı Listesi
            </x-filament::button>

            <x-filament::button
                tag="a"
                href="{{ \App\Filament\Resources\KullanıcıOnayıResource::getUrl('create') }}"
                color="primary"
                icon="heroicon-o-plus"
            >
                Yeni Kullanıcı Ekle
            </x-filament::button>
        </div>
    </x-filament::card>

    {{-- Sistem Bilgileri --}}
    <x-filament::card>
        <x-slot name="header">Sistem Bilgileri</x-slot>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-700">
            <li><strong>PHP Sürümü:</strong> {{ PHP_VERSION }}</li>
            <li><strong>Laravel Sürümü:</strong> {{ Illuminate\Foundation\Application::VERSION }}</li>
            <li><strong>Uygulama Ortamı:</strong> {{ app()->environment() }}</li>
            <li><strong>Veritabanı:</strong> {{ \DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME) }}</li>
        </ul>
    </x-filament::card>

</x-filament::page>
