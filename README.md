### WEB2_21552011125_UTS

### Perpustakaan sederhana menggunakan php oop

<ul>
  <li>Tugas: Ujian Tengah Semester - Project Perpustakaan</li>
  <li>Nama: Reihan Aulia Darojat</li>
  <li>NIM: 21552011125</li>
  <li>Kelas: 221PA - Semester 6</li>
</ul>

#### Ringkasan:

Sistem perpustakaan ini memungkinkan pengguna untuk menambah, meminjam, dan mengembalikan buku. Halaman utama (`index.php`) memiliki tiga bagian utama: 

1. **Tambah Buku**: Pengguna dapat menambahkan buku baru dengan mengisi formulir.
2. **Pinjam Buku**: Pengguna dapat meminjam buku yang tersedia.
3. **Pengembalian Buku**: Pengguna dapat mengembalikan buku yang sudah dipinjam.

#### Penjelasan:

- **index.php**: Halaman utama yang menampilkan formulir untuk menambah buku baru, meminjam buku, mengembalikan buku, dan daftar buku yang tersedia.
- **add_book.php**: Menambahkan buku baru ke dalam daftar buku yang tersedia.
- **borrow_book.php**: Memproses peminjaman buku. 
- **return_book.php**: Memproses pengembalian buku.
- **update_available_books.php**: Mengupdate daftar buku yang tersedia.

#### Contoh Penggunaan:

1. **Tambah Buku**:

    ```html
    <form id="addBookForm" method="post">
        <div class="form-group">
            <label for="title">Judul:</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="author">Penulis:</label>
            <input type="text" class="form-control" id="author" name="author">
        </div>
        <div class="form-group">
            <label for="publicationYear">Tahun Terbit:</label>
            <input type="text" class="form-control" id="publicationYear" name="publicationYear">
        </div>
        <button type="submit" class="btn btn-primary" name="addBook">Tambah Buku</button>
    </form>
    ```

2. **Pinjam Buku**:

    ```html
    <form id="borrowBookForm" method="post">
        <div class="form-group">
            <label for="borrowTitle">Judul Buku:</label>
            <select class="form-control" id="borrowTitle" name="borrowTitle">
                <option value="" selected disabled>Pilih Judul Buku</option>
                <?php
                foreach ($_SESSION['availableBooks'] as $book) {
                    if (!$book['isBorrowed']) {
                        echo "<option value='{$book['title']}'>{$book['title']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="borrowBook">Pinjam Buku</button>
    </form>
    ```

3. **Pengembalian Buku**:

    ```html
    <form id="returnBookForm" method="post">
        <div class="form-group">
            <label for="returnTitle">Judul Buku:</label>
            <select class="form-control" id="returnTitle" name="returnTitle">
                <option value="" selected disabled>Pilih Judul Buku</option>
                <?php
                foreach ($_SESSION['availableBooks'] as $book) {
                    if ($book['isBorrowed']) {
                        echo "<option value='{$book['title']}'>{$book['title']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="returnBook">Kembalikan Buku</button>
    </form>
    ```
