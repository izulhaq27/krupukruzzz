# Dokumen Wawancara - Proyek KrupuKruzzz

**Proyek:** Website E-Commerce & Company Profile untuk UMKM Kerupuk bernama **“KrupuKruzzz”**
**Nama Kelompok:**
1. Muhammad Mutaqim (Project Manager)
2. Fhensa Difta Arlena (System Analyst)
3. Yusdi Hartono (Programmer)
4. Ilham Fajar Akbar (Tester)

**Narasumber:** Pemilik KrupuKruzzz
**Tujuan Wawancara:** Menggali informasi untuk pembuatan website e-commerce dan company profile KrupuKruzzz yang berfungsi sebagai media penjualan online, promosi, dan informasi usaha.

---

### 1. Tujuan Proyek
Website KrupuKruzzz dibuat dengan tujuan untuk:
1. **Memperkenalkan KrupuKruzzz** kepada masyarakat luas sebagai produsen kerupuk berkualitas, gurih, dan higienis dari Bojonegoro.
2. **Transformasi Digital:** Beralih dari penjualan konvensional ke sistem e-commerce agar pelanggan dapat melakukan pembelian langsung melalui website.
3. **Meningkatkan Jangkauan Pasar:** Memperluas area promosi secara online sehingga pelanggan dari luar daerah dapat menemukan dan memesan produk dengan mudah.
4. **Otomasi Transaksi:** Mempermudah pembayaran menggunakan integrasi Midtrans dan fitur pelacakan pesanan secara real-time.
5. **Membangun Branding:** Mencerminkan kualitas produk melalui tampilan website yang profesional, informatif, dan terpercaya.

---

### 2. Wawancara
#### A. Pertanyaan Umum Tentang Usaha
| No | Pertanyaan | Jawaban Klien |
|:---|:---|:---|
| 1 | Sejak kapan KrupuKruzzz berdiri? | KrupuKruzzz mulai berkembang sebagai UMKM lokal yang fokus pada kualitas rasa sejak tahun 2023. |
| 2 | Apa ide awal berdirinya usaha kerupuk ini? | Ingin menyediakan camilan kerupuk tradisional dengan kualitas premium namun harga tetap merakyat untuk masyarakat Bojonegoro dan sekitarnya. |
| 3 | Apa makna dari nama "KrupuKruzzz"? | Nama ini merepresentasikan suara renyah (kruzz-kruzz) saat kerupuk dimakan, menunjukkan kesegaran dan kerenyahan produk kami. |
| 4 | Siapa target utama pelanggan Anda? | Target kami mencakup semua kalangan: mulai dari ibu rumah tangga, pemilik warung makan, hingga anak muda yang gemar ngemil. |
| 5 | Apa yang membedakan KrupuKruzzz dari kerupuk lain? | Kerupuk kami memiliki banyak varian rasa (Gurung, Amplang, Bawang Pedas, Rujak) dan diproses dengan bahan alami berkualitas tinggi. |
| 6 | Apa visi dan misi usaha ini? | Menjadi produsen kerupuk pilihan utama di Jawa Timur dengan tetap mempertahankan cita rasa tradisional yang otentik. |
| 7 | Nilai apa yang ingin diberikan kepada pelanggan? | Memberikan pengalaman ngemil yang memuaskan dengan rasa yang pas di lidah dan pelayanan yang cepat melalui platform digital. |

#### B. Pertanyaan Tentang Desain dan Tampilan
| No | Pertanyaan | Jawaban Klien |
|:---|:---|:---|
| 1 | Warna apa yang mewakili identitas KrupuKruzzz? | Kami ingin dominasi warna **Hijau (Forest Green)** yang memberikan kesan segar, alami, dan bersih. |
| 2 | Gaya desain seperti apa yang diinginkan? | Bersih, minimalis, namun terlihat modern dengan navigasi yang mudah bagi orang tua maupun anak muda. |
| 3 | Sisi mana yang ingin lebih ditonjolkan? | Sisi kemudahan belanja. Kami ingin pelanggan merasa mudah saat memilih kategori kerupuk dan memasukkannya ke keranjang. |
| 4 | Bagaimana harapan Anda terhadap tampilan akhir website? | Website yang responsif, cepat diakses dari HP, dan memiliki identitas visual yang kuat dengan logo KrupuKruzzz yang ikonik. |

#### C. Pertanyaan Teknis dan Pengelolaan
| No | Pertanyaan | Jawaban Klien |
|:---|:---|:---|
| 1 | Apakah sudah memiliki domain dan hosting? | Menggunakan local environment untuk pengembangan (Laragon) dan siap di-deploy ke hosting PHP & MySQL. |
| 2 | Siapa yang akan mengelola isi website nantinya? | Karena efisiensi manajerial, owner akan mengelola sendiri melalui dashboard admin (manajemen produk & pesanan). |
| 3 | Apakah website harus responsif di HP? | Tentu, karena mayoritas pelanggan kami memesan melalui smartphone. |

#### D. Pertanyaan Tentang Fasilitas Penjualan
| No | Pertanyaan | Jawaban Klien |
|:---|:---|:---|
| 1 | Fitur utama apa saja yang tersedia di website? | Katalog produk berbasis kategori, keranjang belanja, integrasi pembayaran Midtrans, dan pelacakan resi. |
| 2 | Apakah ada promo khusus yang ingin ditampilkan? | Ya, kami ingin ada section khusus untuk produk rekomendasi di halaman beranda. |
| 3 | Bagaimana pelanggan menghubungi Anda jika ada kendala? | Melalui WhatsApp Button dan informasi kontak yang tersedia di Footer. |

---

### 3. Struktur Website
**A. Halaman Home (Beranda)**
- **Hero Section:** Tagline "Solusi camilan kerupuk berkualitas, gurih, dan harga bersahabat" dengan tombol CTA "Belanja Sekarang".
- **Rekomendasi Produk:** Menampilkan card produk unggulan seperti Kerupuk Gurung dan Amplang.
- **Fitur Unggulan:** Informasi pengiriman, kualitas bahan, dan kemudahan pembayaran.

**B. Halaman Produk & Kategori**
- Daftar lengkap produk kerupuk berdasarkan kategori (misal: Kerupuk Ikan, Kerupuk Pedas).
- Fitur "Beli" untuk memasukkan produk ke keranjang.

**C. Halaman Keranjang & Checkout**
- Ringkasan pesanan pelanggan.
- Formulir pengiriman dan pemilihan metode pembayaran otomatis via Midtrans.

**D. Halaman Pelacakan (Tracking)**
- Fitur untuk melacak status pesanan secara real-time hanya dengan memasukkan nomor resi atau ID pesanan.

**E. Dashboard Admin**
- Manajemen Produk (Tambah/Edit/Hapus).
- Manajemen Kategori.
- Monitoring Pesanan Masuk dan Update Status Pengiriman.

---

### 4. Fitur Unggulan Website
1. **Responsive Design:** Optimal diakses dari Desktop, Tablet, hingga Mobile.
2. **Midtrans Integration:** Pembayaran aman dan otomatis menggunakan berbagai metode (Bank Transfer, E-Wallet, dll).
3. **Order Tracking System:** Transparansi pengiriman bagi pelanggan melalui fitur lacak resi yang terdedikasi.
4. **Admin Panel Powerful:** Kemudahan bagi pemilik untuk mengelola inventaris produk dan memantau penjualan harian.
5. **Optimized SEO:** Struktur kode yang bersih untuk visibilitas yang lebih baik di mesin pencari.

---

### 5. Tim Proyek & Informasi Teknis
- **Muhammad Mutaqim - Project Manager:** Mengkoordinir tim dan timeline.
- **Fhensa Difta Arlena - System Analyst:** Merancang arsitektur database (ERD) dan alur sistem (UML).
- **Yusdi Hartono - Programmer:** Mengimplementasikan kode menggunakan Laravel (PHP, MySQL, Bootstrap).
- **Ilham Fajar Akbar - Tester:** Memastikan aplikasi bebas bug dan fitur pembayaran berjalan lancar.

**Informasi Kontak:**
- **Alamat:** Dusun Garas RT 001 RW 001 Desa Palembon, Kec. Kanor, Kab. Bojonegoro.
- **WhatsApp:** 0816-1550-0168
- **Email:** krupukruzzz@gmail.com

---
*Dokumen ini merupakan laporan akhir hasil wawancara dan spesifikasi proyek KrupuKruzzz.*
**Tanggal Penyelesaian:** Desember 2025
