<!DOCTYPE html>
<html>
<head>
    <title>Ürünler</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <h1>Ürünler</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @php
        $products = [
            ['id' => 1, 'name' => 'Konser Bileti', 'price' => 150],
            ['id' => 2, 'name' => 'Tiyatro Bileti', 'price' => 90],
            ['id' => 3, 'name' => 'Festival Bileti', 'price' => 200],
        ];
    @endphp

    @foreach($products as $product)
        <div class="card">
            <div class="card-info">
                <strong>{{ $product['name'] }}</strong><br>
                {{ $product['price'] }} TL
            </div>
            <div class="card-actions">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                    <button type="submit">Sepete Ekle</button>
                </form>
            </div>
        </div>
    @endforeach

    <a href="{{ route('cart.index') }}">Sepete Git</a>
</div>
</body>
</html>
