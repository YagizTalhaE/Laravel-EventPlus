<h2>Giriş Yap</h2>
<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Şifre">
    <button type="submit">Giriş</button>
</form>

