<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h2>Tambah Buku</h2>
                <form id="addBookForm">
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
                    <button type="submit" class="btn btn-primary">Tambah Buku</button>
                </form>
            </div>
            <div class="col">
                <h2>Pinjam Buku</h2>
                <form id="borrowBookForm">
                    <div class="form-group">
                        <label for="borrowTitle">Judul Buku:</label>
                        <select class="form-control" id="borrowTitle" name="borrowTitle">
                            <option value="" selected disabled>Pilih Judul Buku</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Pinjam Buku</button>
                </form>
            </div>
            <div class="col">
                <h2>Pengembalian Buku</h2>
                <form id="returnBookForm">
                    <div class="form-group">
                        <label for="returnTitle">Judul Buku:</label>
                        <select class="form-control" id="returnTitle" name="returnTitle">
                            <option value="" selected disabled>Pilih Judul Buku</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Kembalikan Buku</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <h2>Daftar Buku Tersedia</h2>
                <ul id="availableBooks" class="list-group">
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Definisikan kelas Book
        class Book {
            // Atribut
            constructor(title, author, publicationYear) {
                this.title = title;
                this.author = author;
                this.publicationYear = publicationYear;
                this.isBorrowed = false;
            }

            // Meminjam buku
            borrowBook() {
                this.isBorrowed = true;
            }

            // Mengembalikan buku
            returnBook() {
                this.isBorrowed = false;
            }

            // Menampilkan informasi buku
            displayInfo() {
                return `${this.title} oleh ${this.author} (Tahun Terbit: ${this.publicationYear})`;
            }
        }

        // Definisikan kelas Library
        class Library {
            // Atribut
            constructor() {
                this.books = [];
            }

            // Menambahkan buku baru
            addBook(book) {
                this.books.push(book);
            }

            // Meminjam buku
            borrowBook(title) {
                const book = this.books.find(book => book.title === title && !book.isBorrowed);
                if (book) {
                    book.borrowBook();
                    console.log(`Buku berhasil dipinjam: ${title}`);
                    return book;
                } else {
                    console.log(`Buku tidak tersedia atau sudah dipinjam.`);
                    return null;
                }
            }

            // Mengembalikan buku
            returnBook(title) {
                const book = this.books.find(book => book.title === title && book.isBorrowed);
                if (book) {
                    book.returnBook();
                    console.log(`Buku berhasil dikembalikan: ${title}`);
                    return book;
                } else {
                    console.log(`Buku tidak ditemukan atau tidak sedang dipinjam.`);
                    return null;
                }
            }

            // Mendapatkan daftar buku yang tersedia
            getAvailableBooks() {
                return this.books.filter(book => !book.isBorrowed);
            }
        }

        $(document).ready(function () {
            const library = new Library();
            const borrowTitleSelect = $("#borrowTitle");
            const returnTitleSelect = $("#returnTitle");
            const availableBooksList = $("#availableBooks");

            // Memproses penambahan buku
            $("#addBookForm").submit(function (event) {
                event.preventDefault();
                const title = $("#title").val();
                const author = $("#author").val();
                const publicationYear = $("#publicationYear").val();

                const book = new Book(title, author, publicationYear);
                library.addBook(book);

                borrowTitleSelect.append(`<option value="${title}">${title}</option>`);
                returnTitleSelect.append(`<option value="${title}">${title}</option>`);

                const bookInfo = book.displayInfo();
                availableBooksList.append(`<li class="list-group-item">${bookInfo}</li>`);
            });

            // Memproses peminjaman buku
            $("#borrowBookForm").submit(function (event) {
                event.preventDefault();
                const title = $("#borrowTitle").val();
                const book = library.borrowBook(title);
                if (book) {
                    $(`#availableBooks li:contains('${title}')`).remove();
                }
            });

            // Memproses pengembalian buku
            $("#returnBookForm").submit(function (event) {
                event.preventDefault();
                const title = $("#returnTitle").val();
                const book = library.returnBook(title);
                if (book) {
                    const bookInfo = book.displayInfo();
                    availableBooksList.append(`<li class="list-group-item">${bookInfo}</li>`);
                }
            });

            // Menampilkan daftar buku yang tersedia saat halaman dimuat
            $(document).ajaxStart(function () {
                $.get("get_available_books.php", function (books) {
                    books.forEach(function (book) {
                        borrowTitleSelect.append(`<option value="${book.title}">${book.title}</option>`);
                        returnTitleSelect.append(`<option value="${book.title}">${book.title}</option>`);
                        const bookInfo = `${book.title} oleh ${book.author} (Tahun Terbit: ${book.publicationYear})`;
                        availableBooksList.append(`<li class="list-group-item">${bookInfo}</li>`);
                    });
                });
            });
        });
    </script>
</body>
</html>
