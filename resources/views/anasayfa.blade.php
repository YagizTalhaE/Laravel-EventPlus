
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>EventPlus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .top-bar {
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .top-bar .left {
            display: flex;
            align-items: center;
        }

        .top-bar .logo {
            height: 40px;
            margin-right: 10px;
        }

        .top-bar .app-name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .top-bar .center {
            flex: 1;
            padding: 0 30px;
        }

        .top-bar .search-box {
            width: 100%;
            max-width: 500px;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
        }

        .top-bar .right {
            display: flex;
            align-items: center;
        }

        .top-bar .auth-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #007BFF;
        }

        .top-bar .user-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ccc;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<!-- Top Bar -->
<div class="top-bar" style="display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; padding: 10px 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

    <!-- Sol kısım: Logo + İsim -->
    <div class="left" style="display: flex; align-items: center;">
        <a href="{{ route('anasayfa') }}" style="display: flex; align-items: center; text-decoration: none;">
            <img src="{{ asset('logo.png') }}" alt="EventPlus Logo" style="height: 40px; margin-right: 10px;">
            <span style="font-size: 22px; font-weight: bold; color: black;">EventPlus</span>
        </a>
    </div>

    <!-- Orta kısım: Arama kutusu -->
    <div class="center" style="flex: 1; display: flex; justify-content: center; padding: 0 20px;">
        <div style="position: relative; width: 100%; max-width: 400px;">
            <input type="text" placeholder="Etkinlik ara..." style="width: 100%; padding: 8px 40px 8px 12px; border-radius: 20px; border: 1px solid #ccc;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="gray" viewBox="0 0 24 24" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                <path d="M10 2a8 8 0 105.293 14.293l4.707 4.707 1.414-1.414-4.707-4.707A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z"/>
            </svg>
        </div>
    </div>


    <!-- Sağ kısım: Giriş/Kayıt & kullanıcı ikonu -->
    <div class="right" style="display: flex; align-items: center;">
        <div class="auth-links">
        </div>
        <div class="user-icon" style="width: 30px; height: 30px; border-radius: 50%; background-color: #ccc; margin-left: 15px;"></div>
    </div>
</div>

<!-- Ana içerik -->
<div class="content" style="padding: 20px;">
    <h2>Hoş Geldiniz!</h2>
    <p>Burada yaklaşan etkinlikleri görebilirsiniz.</p>
    <!-- Etkinlik listeleme bileşenleri buraya gelecek -->
</div>

</body>
</html>


