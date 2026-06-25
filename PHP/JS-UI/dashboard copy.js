// 1. Ambil elemen dari HTML berdasarkan ID
const hamburgerBtn = document.getElementById('hamburger-btn');
const sidebarmenu = document.getElementById('sidebarmenu');
const sidebar = document.querySelector('.sidebar');
const backgroundMainColor = document.querySelector('.background_maincolor');

sidebarmenu.classList.add('hidden');
sidebarmenu.classList.remove('background_maincolor'); // Pastikan sidebar awalnya tidak memiliki kelas active
// 2. Event listener untuk membuka/menutup sidebar
hamburgerBtn.addEventListener('click', function() {
  switch (sidebarmenu.classList.contains('hidden')) {
      case true:
          sidebarmenu.classList.toggle('hidden'); // Toggle kelas hidden untuk membuka/menutup sidebar
          sidebarmenu.classList.toggle('background_maincolor'); // Hapus kelas active saat sidebar ditutup
          sidebar.classList.toggle('background_maincolor'); // Hapus kelas active saat sidebar ditutup
          break;
      case false:
          sidebarmenu.classList.toggle('hidden'); // Toggle kelas hidden untuk membuka/menutup sidebar
          sidebarmenu.classList.toggle('background_maincolor'); // Tambahkan kelas active saat sidebar dibuka
            sidebar.classList.toggle('background_maincolor'); // Tambahkan kelas active saat sidebar dibuka
          break;
    }
});
if (window.innerWidth <= 768) {
    sidebarmenu.classList.add('hidden');
}
// Opsional: Tutup sidebar kalau user klik area di luar sidebar
document.addEventListener('click', function(event) {
  if (!sidebarmenu.contains(event.target) && !hamburgerBtn.contains(event.target)) {
    // Gunakan .add() atau .remove() secara langsung, jangan toggle
    
    // Misalnya, tambahkan class 'hidden' untuk menyembunyikan
    sidebarmenu.classList.add('hidden'); 
    
    // Hapus class warna jika memang itu logikanya
    sidebarmenu.classList.remove('background_maincolor'); 
    sidebar.classList.remove('background_maincolor'); 
  }
});
