# IMPLEMENTASI DOKUMENTASI PERUBAHAN – v5.1 (Agustus 2025)

Dokumen ini merevisi dan merapikan instruksi implementasi agar spesifik, terukur, konsisten Bahasa Indonesia, dan bebas ambiguitas.

## Ringkasan Perubahan
- Header: perapihan kotak pencarian (tinggi, margin ikon, placeholder, aksesibilitas) dan konsistensi di semua halaman.
- Sidebar: restrukturisasi kategori; modul bisnis dipindah ke kategori “MANAGEMENT” yang diletakkan tepat di atas “SETTINGS”.
- Penamaan: “Pengiriman & Delivery/Shipping Delivery” diganti menjadi “Penjualan Barang”; “Pembelian” menjadi “Pembelian Barang”.

## Tujuan
- Menyamakan tampilan dan perilaku kotak pencarian (search box) di header.
- Menata ulang kategori dan label modul sidebar agar lebih logis dan mudah dipahami.
- Menjaga seluruh teks UI dalam Bahasa Indonesia yang baku.

## Ruang Lingkup
- UI header global (search box, ikon, placeholder, alignment, aksesibilitas).
- Struktur, urutan, dan label sidebar pada `app/Http/Middleware/AdminSidebarMenu.php`.
- Tidak mengubah skema database, permission, atau rute (routes) selain label/penempatan menu.

## Prasyarat & Catatan
- Pastikan tidak ada duplikasi komponen search di sidebar atau tempat lain.
- Jika label menggunakan translasi, boleh sementara memakai string literal sampai file translasi diperbarui.
- Setelah perubahan, lakukan pembersihan cache tampilan/konfigurasi bila perlu.

## Instruksi Teknis (Langkah-demi-Langkah)

1) Perapihan Search Box pada Header
- File: `resources/views/layouts/partials/header.blade.php`
- Aksi:
  - Tinggi & konsistensi: terapkan utilitas seperti `tw-h-8 tw-py-0 tw-leading-none` pada elemen input agar setara dengan komponen header lain.
  - Ikon & jarak: ikon kiri diberi `tw-mr-2`; jika dekoratif, tambahkan `aria-hidden="true"`.
  - Placeholder: gunakan Bahasa Indonesia yang jelas, contoh: "Cari data, produk, transaksi…"; tambahkan `aria-label="Pencarian"` dan `title="Pencarian"` pada input.
  - Alignment: pastikan wrapper baris memakai `tw-flex tw-items-center` agar vertikal sejajar.
  - Hilangkan/disable duplikasi elemen search di sidebar (jika masih ada), sehingga hanya versi header yang aktif.
- Kriteria Penerimaan:
  - Tinggi input seragam; ikon tidak terpotong; margin ikon rapi; placeholder Bahasa Indonesia.
  - Berlaku sama di semua halaman karena header dipakai via layout utama.

2) Restrukturisasi Sidebar: Kategori “MANAGEMENT”
- File: `app/Http/Middleware/AdminSidebarMenu.php`
- Aksi:
  - Buat/gunakan dropdown kategori “MANAGEMENT” yang memuat modul:
    - Biaya (Expenses)
    - Akuntansi (Accounts/Accounting)
    - Produksi (Manufacturing)
    - CRM
    - Essentials
    - HRM
    - Manajemen Aset (Asset Management)
  - Pindahkan item-item di atas ke dalam dropdown “MANAGEMENT” (jika sebelumnya tersebar atau berada di “AI Modules”).
  - Posisi urutan: letakkan “MANAGEMENT” tepat di atas “SETTINGS”. Contoh: `MANAGEMENT ->order(80)`, `SETTINGS ->order(85)` (sesuaikan dengan skema urutan yang ada agar tidak tabrakan).
  - Jangan mengubah permission/guard yang sudah ada; hanya memindahkan penempatan/label kategori.
- Kriteria Penerimaan:
  - Semua modul di daftar berada di dalam dropdown “MANAGEMENT”.
  - Urutan kategori sidebar konsisten: … (kategori lain) → MANAGEMENT → SETTINGS.

3) Penamaan Ulang Modul Transaksi
- File: `app/Http/Middleware/AdminSidebarMenu.php`
- Aksi:
  - Ganti label “Pengiriman & Delivery”/“Shipping Delivery” menjadi “Penjualan Barang”. (Rute/permission/handler tidak berubah.)
  - Ganti label “Pembelian” menjadi “Pembelian Barang”.
  - Ikon boleh disesuaikan agar relevan dengan penjualan/pembelian (opsional).
- Kriteria Penerimaan:
  - Sidebar menampilkan “Penjualan Barang” dan “Pembelian Barang” menggantikan label lama.
  - Semua tautan/aksi di dalam dropdown terkait tetap berfungsi (tanpa 404 atau route mismatch).

4) Konsistensi Bahasa Indonesia
- Pastikan seluruh label menu, placeholder input, judul dropdown, tooltip/title, aria-label menggunakan Bahasa Indonesia yang konsisten dan baku.

## Rekomendasi Urutan Sidebar (Contoh)
- Dashboard (5)
- User Management (10)
- Kontak (15)
- Produk/Inventori (20)
- Penyesuaian Stok (21)
- Penjualan Barang (30)
- Pengiriman Paket (30–35, jika dipisahkan khusus modul)
- AI Assistance (35–40)
- Laporan (55)
- MANAGEMENT (80)
- SETTINGS (85)
Catatan: Angka hanyalah contoh; sesuaikan agar tidak bertabrakan dengan urutan yang sudah ada.

## Dampak & Batasan
- Tidak ada perubahan pada nama rute (`name()`), URL, controller, maupun permission. Perubahan hanya label dan penempatan menu.
- Status aktif/nonaktif modul pada `modules_statuses.json` tidak diubah oleh dokumen ini.

## Pengujian & Validasi
- Validasi rute: jalankan `php artisan route:list` dan pastikan tidak ada rute duplikat/hilang akibat perubahan label.
- Uji manual di browser:
  - Header: cek beberapa halaman (Dashboard, Penjualan, Pembelian, Laporan, dll.) dan pastikan search box konsisten.
  - Sidebar: buka dropdown “MANAGEMENT” dan pastikan Biaya, Akuntansi, Produksi, CRM, Essentials, HRM, Manajemen Aset tampil dan dapat diakses.
  - Penamaan: pastikan label “Penjualan Barang” dan “Pembelian Barang” tampil dan tautannya berfungsi normal.
- Aksesibilitas: input memiliki label/aria-label; ikon dekoratif memiliki `aria-hidden`.

## Definisi Selesai (DoD)
- Header: tinggi search box seragam, margin ikon rapi, placeholder & label Bahasa Indonesia, tanpa duplikasi komponen search di sidebar.
- Sidebar: kategori “MANAGEMENT” berisi modul sesuai daftar dan berada tepat di atas “SETTINGS”.
- Label: “Pengiriman & Delivery/Shipping Delivery” → “Penjualan Barang”; “Pembelian” → “Pembelian Barang”.
- Tidak ada error di log; tidak ada 404 pada navigasi item terkait; pemeriksaan rute lulus.

## Lampiran A – Pemetaan Modul ke “MANAGEMENT”
- Expenses → Biaya
- Accounts/Accounting → Akuntansi
- Manufacturing → Produksi
- CRM → CRM
- Essentials → Essentials
- HRM → HRM
- AssetManagement/Asset → Manajemen Aset

## Catatan Implementasi
- Jika nantinya diperlukan translasi, tambahkan entri ke file bahasa lalu ganti string literal di middleware menjadi helper translasi.
- Lakukan pembersihan cache tampilan/konfigurasi jika perubahan label tidak langsung terlihat.
