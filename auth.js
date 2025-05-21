// Kullanıcı durumunu kontrol et ve navbar'ı güncelle
window.addEventListener('DOMContentLoaded', function() {
    const userProfileLink = document.getElementById('userProfileLink');
    if (userProfileLink) {
        const currentUser = JSON.parse(localStorage.getItem('currentUser'));
        if (currentUser) {
            userProfileLink.textContent = currentUser.name;
            userProfileLink.href = 'profil.html';
        } else {
            userProfileLink.textContent = 'KULLANICI GİRİŞİ';
            userProfileLink.href = 'kullanıcıkayıt.html';
        }
    }
});
