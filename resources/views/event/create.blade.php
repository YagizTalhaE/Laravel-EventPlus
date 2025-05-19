<!-- resources/views/events/create.blade.php -->

<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Başlık:</label>
    <input type="text" name="baslik" required>

    <label>Açıklama:</label>
    <textarea name="aciklama" required></textarea>

    <label>Başlangıç Tarihi:</label>
    <input type="date" name="baslangic_tarihi" required>

    <label>Bitiş Tarihi:</label>
    <input type="date" name="bitis_tarihi" required>

    <label>Adres:</label>
    <input type="text" name="adres" required>

    <label>Tür:</label>
    <input type="text" name="tur" required>

    <label>Görsel Yükle:</label>
    <input type="file" name="gorsel" accept="image/*" required>

    <button type="submit">Oluştur</button>
</form>
