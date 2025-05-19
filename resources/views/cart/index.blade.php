<!DOCTYPE html>
<html>
<head>
    <title>Sepet</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <h1>Sepetim</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(count($cart) > 0)
        @foreach($cart as $item)
            <div class="card">
                <div class="card-info">
                    <strong>{{ $item['name'] }}</strong><br>
                    {{ $item['price'] }} TL – Adet: {{ $item['quantity'] }}
                </div>
                <div class="card-actions">
                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                        @csrf
                        <button type="submit">Sil</button>
                    </form>
                </div>
            </div>
        @endforeach

        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit">Sepeti Boşalt</button>
        </form>
    @else
        <p>Sepetiniz boş.</p>
    @endif

    <a href="{{ route('products.index') }}">Ürünlere Geri Dön</a>
</div>
</body>
</html>
