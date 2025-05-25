@extends('layouts.app')

@section('title', 'Sepetim')

@section('content')
    <div class="container mt-4 pb-5">
        <h2 class="mb-4">🛒 Sepetim</h2>

        {{-- Otomatik kaybolan mesajlar için container üstü boşluk --}}
        <div id="messageContainer">
            @if(session('success'))
                <div class="alert alert-success" id="successMessage">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" id="errorMessage">{{ session('error') }}</div>
            @endif
        </div>

        @if(count($cartItems))
            <form method="POST" action="{{ route('cart.checkout') }}" id="paymentForm">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>Seç</th>
                            <th>Etkinlik</th>
                            <th>Bilet Türü</th>
                            <th>Adet</th>
                            <th>Birim Fiyat</th>
                            <th>Toplam</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $item)
                            @php
                                $lineTotal = $item->ticketType->price * $item->quantity;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox">
                                </td>
                                <td>{{ $item->ticketType->etkinlik->baslik ?? 'Etkinlik Yok' }}</td>
                                <td>{{ $item->ticketType->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary quantity-decrease" data-id="{{ $item->id }}">−</button>
                                        <span class="item-quantity" id="quantity-{{ $item->id }}">{{ $item->quantity }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary quantity-increase" data-id="{{ $item->id }}">+</button>
                                    </div>
                                </td>
                                <td>₺{{ number_format($item->ticketType->price, 2) }}</td>
                                <td>₺{{ number_format($lineTotal, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div><strong>Seçilenlerin Toplamı: ₺<span id="selectedTotal">0.00</span></strong></div>
                    <div>
                        <button type="button" class="btn btn-primary" id="showPaymentOptions">Ödeme Yap</button>

                        <div id="paymentOptions" class="mt-2 text-end" style="display: none;">
                            <p><strong>Ödeme Yöntemini Seçin:</strong></p>
                            <button type="submit" name="payment_method" value="card" class="btn btn-outline-success me-2">💳 Kredi/Banka Kartı</button>
                            <button type="submit" name="payment_method" value="eft" class="btn btn-outline-secondary">🏦 EFT/Havale</button>
                        </div>
                    </div>
                </div>

                {{-- Seçilenleri sil ve Sepeti boşalt butonları, arada boşluk --}}
                <div class="mt-3 mb-5 d-flex gap-2">
                    <button type="button" id="deleteSelected" class="btn btn-danger">Seçilenleri Sil</button>
                    <button type="button" id="clearCart" class="btn btn-warning">Sepeti Boşalt</button>
                </div>
            </form>
        @else
            <p class="empty-cart-message">Sepetiniz boş.</p>
        @endif
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Otomatik kaybolan flash mesajlar
            ['successMessage', 'errorMessage'].forEach(id => {
                const msg = document.getElementById(id);
                if(msg){
                    setTimeout(() => {
                        msg.style.transition = 'opacity 0.5s ease';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.style.display = 'none', 500);
                    }, 3000);
                }
            });
        });

        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectedTotalSpan = document.getElementById('selectedTotal');
        const showPaymentOptionsBtn = document.getElementById('showPaymentOptions');
        const paymentOptionsDiv = document.getElementById('paymentOptions');
        const deleteSelectedBtn = document.getElementById('deleteSelected');
        const clearCartBtn = document.getElementById('clearCart');
        const messageContainer = document.getElementById('messageContainer');

        const itemTotals = @json($cartItems->pluck('ticketType.price')->toArray());
        const itemQuantities = @json($cartItems->pluck('quantity')->toArray());

        function updateSelectedTotal() {
            let total = 0;
            checkboxes.forEach((cb, i) => {
                if (cb.checked) {
                    total += itemTotals[i] * itemQuantities[i];
                }
            });
            selectedTotalSpan.textContent = total.toFixed(2);
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedTotal));

        showPaymentOptionsBtn.addEventListener('click', () => {
            paymentOptionsDiv.style.display = 'block';
        });

        deleteSelectedBtn.addEventListener('click', () => {
            const selectedIds = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if(selectedIds.length === 0) {
                alert('Lütfen silmek için en az bir ürün seçin.');
                return;
            }

            fetch('{{ route('cart.deleteSelected') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({selected_items: selectedIds})
            })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        showTemporaryMessage('Seçilen ürünler silindi.', 'success');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        showTemporaryMessage('Silme işlemi sırasında hata oluştu.', 'danger');
                    }
                })
                .catch(() => showTemporaryMessage('Silme işlemi sırasında hata oluştu.', 'danger'));
        });

        clearCartBtn.addEventListener('click', () => {
            fetch('{{ route('cart.clear') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        showTemporaryMessage('Sepet boşaltıldı.', 'success');
                        setTimeout(() => window.location.reload(), 3000);
                    } else {
                        showTemporaryMessage('Sepet boşaltılırken hata oluştu.', 'danger');
                    }
                })
                .catch(() => showTemporaryMessage('Sepet boşaltılırken hata oluştu.', 'danger'));
        });

        function showTemporaryMessage(message, type = 'success') {
            // Önce var olan mesajları temizle
            messageContainer.innerHTML = '';

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;
            messageContainer.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.5s ease';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 3000);
        }

        // Sayfa yüklendiğinde toplamı güncelle
        updateSelectedTotal();


        document.querySelectorAll('.quantity-increase').forEach(btn => {
            btn.addEventListener('click', () => updateQuantity(btn.dataset.id, 'increase'));
        });

        document.querySelectorAll('.quantity-decrease').forEach(btn => {
            btn.addEventListener('click', () => updateQuantity(btn.dataset.id, 'decrease'));
        });

        function updateQuantity(cartItemId, action) {
            fetch('{{ route('cart.updateQuantity') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    id: cartItemId,
                    action: action
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('quantity-' + cartItemId).textContent = data.new_quantity;
                        window.location.reload(); // Güncel toplamları görmek için sayfayı yenile
                    } else {
                        showTemporaryMessage(data.message || 'Güncelleme başarısız.', 'danger');
                    }
                })
                .catch(() => showTemporaryMessage('Sunucu hatası.', 'danger'));
        }
    </script>
@endsection
