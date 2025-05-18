<h2>Kayıt Ol</h2>
<form method="POST" action="/register">
    @csrf
    <input type="text" name="name" placeholder="İsim">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Şifre">
    <input type="password" name="password_confirmation" placeholder="Şifre Tekrar">
    <button type="submit">Kayıt Ol</button>
</form>
