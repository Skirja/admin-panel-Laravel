# Proyek Laravel 8: Sistem Manajemen Buku

Proyek ini adalah sistem manajemen buku sederhana yang dibangun menggunakan Laravel 8.  Sistem ini mendemonstrasikan pola arsitektur Model-View-Controller (MVC) dan menyertakan penanganan kesalahan dasar.

## Implementasi MVC

Aplikasi ini mengikuti pola MVC untuk memisahkan kekhawatiran dan meningkatkan organisasi kode.

**Models:** Model `App\Models\Book` dan `App\Models\Author` merepresentasikan struktur data untuk buku dan penulis, masing-masing. Model ini berinteraksi dengan database untuk mengambil, menyimpan, dan memperbarui data.

**Views:** Views terletak di direktori `resources/views`.  Mereka bertanggung jawab untuk menampilkan data kepada pengguna.  Contohnya, `resources/views/admin/books/index.blade.php` menampilkan daftar buku.  Mesin templating Blade digunakan untuk menghasilkan HTML secara dinamis.

**Controllers:** Controllers menangani permintaan pengguna dan berinteraksi dengan model untuk mengambil dan memanipulasi data.  Kemudian mereka meneruskan data ke views yang sesuai untuk dirender.  Contohnya, `App\Http\Controllers\BookController` mengelola semua permintaan yang berkaitan dengan buku (membuat, membaca, memperbarui, menghapus).

Berikut adalah interaksi antara komponen-komponen ini:

1. Pengguna berinteraksi dengan aplikasi (misalnya, mengklik tombol untuk membuat buku baru).
2. Permintaan diarahkan ke metode controller yang sesuai (misalnya, `BookController@store`).
3. Metode controller berinteraksi dengan model untuk melakukan operasi database yang diperlukan.
4. Metode controller meneruskan data ke view.
5. View merender data dan menampilkannya kepada pengguna.

**Contoh Kode (BookController.php):**

```php
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'author_id' => 'required|exists:authors,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil dibuat!');
    }
```

Kode di atas menunjukkan contoh validasi input dan pembuatan buku baru.


## Penanganan Kesalahan

Aplikasi ini menggunakan mekanisme penanganan pengecualian bawaan Laravel.  File `app/Exceptions/Handler.php` berisi handler pengecualian default. Saat ini, tidak menyertakan logika penanganan pengecualian khusus. Semua pengecualian dilaporkan, dan bidang input sensitif tidak diflash kembali ke pengguna untuk alasan keamanan. Meskipun ini memberikan penanganan kesalahan dasar, implementasi yang lebih kuat dapat mencakup halaman kesalahan khusus, logging, dan penanganan khusus untuk berbagai jenis pengecualian.  Peningkatan di masa mendatang dapat mencakup penambahan penanganan dan logging kesalahan yang lebih canggih untuk memberikan debugging dan umpan balik pengguna yang lebih baik.