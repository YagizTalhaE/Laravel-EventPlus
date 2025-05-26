<?php

// Bu dosya, kullanıcı kayıt işlemlerini yöneten kontrolcüyü tanımlar.

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    // Bu sınıf, kullanıcı kayıt formunu gösterme ve kayıt işlemini gerçekleştirme sorumluluğunu taşır.

    public function showRegisterForm()
    {
        // Kayıt formunu gösteren metot.
        $kvkkMetni = "KİŞİSEL VERİLERİN KORUNMASI AYDINLATMA METNİ
Ticketpass / EventPlus olarak 6698 sayılı Kişisel Verilerin Korunması Kanunu (“KVKK”) uyarınca, kişisel verilerinizin güvenliğine ve gizliliğine önem veriyoruz. Bu kapsamda, sizleri bilgilendirmek isteriz.

1. Veri Sorumlusu
Bu aydınlatma metni, veri sorumlusu sıfatıyla hareket eden Ticketpass tarafından hazırlanmıştır.

2. İşlenen Kişisel Veriler
Üyelik işlemleri sırasında aşağıdaki kişisel verileriniz işlenmektedir:

Ad, soyad

E-posta adresi

Şifre

IP adresi

Kullanıcı hareketleri (giriş zamanı, işlem bilgileri vb.)

3. Kişisel Verilerin İşlenme Amaçları
Toplanan kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:

Üyelik oluşturma ve kullanıcı hesabının yönetimi

Etkinlik kaydı, bilet işlemleri ve bilgilendirme

Güvenliğin sağlanması ve sistemin kötüye kullanımının önlenmesi

İlgili mevzuat kapsamında yükümlülüklerin yerine getirilmesi

4. Kişisel Verilerin Aktarılması
Kişisel verileriniz, sadece yukarıda belirtilen amaçlar doğrultusunda, gerekli olduğu ölçüde;

Yetkili kamu kurum ve kuruluşlarına

Teknik destek ve barındırma hizmeti alınan firmalara
aktarılabilir.

5. Kişisel Verilerin Toplanma Yöntemi ve Hukuki Sebebi
Verileriniz, internet sitemiz üzerinden üyelik formunu doldurmanız suretiyle elektronik ortamda toplanmakta olup, KVKK’nın 5. maddesinde belirtilen:

Bir sözleşmenin kurulması ve ifası için gerekli olması,

İlgili kişinin açık rızasının alınması,
hukuki sebeplerine dayanılarak işlenmektedir.

6. Haklarınız
KVKK’nın 11. maddesi uyarınca;

Kişisel verilerinizin işlenip işlenmediğini öğrenme,

İşlenmişse buna ilişkin bilgi talep etme,

İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme,

Yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri bilme,

Eksik veya yanlış işlenmişse düzeltilmesini isteme,

KVKK’da öngörülen şartlar çerçevesinde silinmesini veya yok edilmesini isteme,

Bu işlemlerin aktarıldığı üçüncü kişilere bildirilmesini isteme,

İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle kişinin aleyhine bir sonucun ortaya çıkmasına itiraz etme,

Kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması hâlinde zararın giderilmesini talep etme
haklarına sahipsiniz.

Başvurularınızı [eventplus@ticketpass.com.tr] adresine iletebilirsiniz.";
        // KVKK (Kişisel Verilerin Korunması Kanunu) metnini tanımlar.
        return view('auth.register', compact('kvkkMetni'));
        // 'auth.register' görünümünü KVKK metniyle birlikte döndürür.
    }

    public function register(Request $request)
    {
        // Kullanıcı kayıt işlemini gerçekleştiren metot.
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'kvkk' => ['accepted'],
        ], [
            'email.unique' => 'Bu eposta adresi kullanılıyor.',
            'email.required' => 'Eposta alanı zorunludur.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
            'password.min' => 'Şifre en az 6 karakter olmalı.',
            'name.required' => 'İsim alanı zorunludur.',
            'kvkk.accepted' => 'KVKK metnini onaylamadan kayıt oluşturamazsınız.',
        ]);
        // Gelen istek verilerini doğrular ve hata mesajlarını özelleştirir.


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Yeni kullanıcıyı veritabanına kaydeder ve şifreyi hashler.


        return redirect('/')->with('success', 'Kayıt oluşturuldu, onay bekleniyor...');
        // Kullanıcıyı ana sayfaya yönlendirir ve bir başarı mesajı gösterir.
    }
}
