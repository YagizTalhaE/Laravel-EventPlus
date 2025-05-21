@extends('layouts.app')

@section('content')
    <style>
        .item-check {
            width: 22px;
            height: 22px;
            accent-color: #007bff; /* Mavi renk */
            border: 2px solid #007bff;
            border-radius: 4px;
            cursor: pointer;
        }

        .checkbox-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <div class="container mt-5 mb-5"> {{-- Footer ile boşluk için mb-5 eklendi --}}
        <h2 class="mb-4">Sepetim</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(count($cart) > 0)
            <form id="cart-form">
                <table class="table table-bordered align-middle">
                    <thead>
                    <tr>
                        <th style="width: 50px;">Seç</th>
                        <th>Etkinlik</th>
                        <th>Adet</th>
                        <th>Bilet Fiyatı</th>
                        <th>Toplam</th>
                        <th>İşlem</th>
                    </tr>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['adet'] * $item['fiyat']; $total += $subtotal; @endphp
                        <tr data-id="{{ $id }}">
                            <td class="checkbox-wrapper">
                                <input type="checkbox" class="item-check" />
                            </td>
                            <td>{{ $item['baslik'] }}</td>
                            <td>
                                <input type="number" class="form-control adet-input" value="{{ $item['adet'] }}" min="1" />
                            </td>
                            <td class="fiyat" data-fiyat="{{ $item['fiyat'] }}">₺{{ number_format($item['fiyat'], 2) }}</td>
                            <td class="toplam">₺{{ number_format($subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('cart.remove.get', $id) }}" class="btn btn-danger btn-sm">Sil</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-end"><strong>Toplam:</strong></td>
                        <td colspan="2"><strong id="genel-toplam">₺{{ number_format($total, 2) }}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </form>

            <div class="d-flex justify-content-between mt-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Sepeti Boşalt</button>
                </form>

                <div>
                    <button class="btn btn-primary" onclick="togglePayment()" type="button">Ödeme Yap</button>

                    <div id="payment-options" class="mt-3 d-none">
                        <button onclick="handlePayment('kart')" class="btn btn-success">Kredi / Banka Kartı</button>
                        <button onclick="handlePayment('havale')" class="btn btn-primary">Havale / EFT</button>
                    </div>
                </div>
            </div>
        @else
            <p>Sepetiniz boş.</p>
        @endif
    </div>

    <script>
        // Ödeme kutusunu açma/kapatma (isteğe bağlı)
        function togglePayment() {
            document.getElementById('payment-options').classList.toggle('d-none');
        }

        // Sepetteki toplam tutarı güncelleme
        function updateToplam() {
            let toplam = 0;

            document.querySelectorAll('tr[data-id]').forEach(row => {
                const checkbox = row.querySelector('.item-check');
                if (checkbox.checked) {
                    const adet = parseInt(row.querySelector('.adet-input').value) || 0;
                    const fiyat = parseFloat(row.querySelector('.fiyat').dataset.fiyat);
                    const satirToplam = adet * fiyat;

                    row.querySelector('.toplam').innerText = '₺' + satirToplam.toLocaleString('tr-TR', { minimumFractionDigits: 2 });
                    toplam += satirToplam;
                } else {
                    row.querySelector('.toplam').innerText = '₺0.00';
                }
            });

            document.getElementById('genel-toplam').innerText = '₺' + toplam.toLocaleString('tr-TR', { minimumFractionDigits: 2 });
        }

        // Sayfa yüklendiğinde adet ve checkbox değişikliklerini dinle
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.adet-input, .item-check').forEach(el => {
                el.addEventListener('input', updateToplam);
                el.addEventListener('change', updateToplam);
            });

            updateToplam(); // Başlangıçta hesapla
        });

        // Ödeme butonuna tıklanınca çalışan fonksiyon
        function handlePayment(method) {
            const selected = Array.from(document.querySelectorAll('.item-check'))
                .filter(chk => chk.checked)
                .map(chk => chk.closest('tr').dataset.id); // ID'leri array olarak al

            if (selected.length === 0) {
                alert("Lütfen ödeme yapmak için en az 1 ürün seçiniz.");
                return;
            }

            fetch('/cart/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    selected: selected, // ['9', '13' gibi etkinlik ID'leri]
                    odeme_yontemi: method // 'kart' ya da 'havale'
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Sunucu hatası!");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const container = document.querySelector('.container');
                        const mesaj = document.createElement('div');
                        mesaj.className = 'alert alert-success mt-4';
                        mesaj.textContent = '✅ Ödeme Alındı! (' + (method === 'kart' ? 'Kredi / Banka Kartı' : 'Havale / EFT') + ')';
                        container.prepend(mesaj);

                        setTimeout(() => {
                            window.location.href = '/';
                        }, 3000);
                    } else {
                        alert("Hata: " + (data.message || "Ödeme sırasında hata oluştu."));
                    }
                })
                .catch(error => {
                    console.error("Hata:", error);
                    alert("Bir hata oluştu, lütfen tekrar deneyiniz.");
                });
        }
    </script>
@endsection
