<?php
// Memulai session
session_start();

// Inisialisasi session availableBooks jika belum ada
if (!isset($_SESSION['availableBooks'])) {
    $_SESSION['availableBooks'] = [
        ['title' => 'Book 1', 'author' => 'Author 1', 'publicationYear' => '2020', 'isBorrowed' => false],
        ['title' => 'Book 2', 'author' => 'Author 2', 'publicationYear' => '2021', 'isBorrowed' => false],
        ['title' => 'Book 3', 'author' => 'Author 3', 'publicationYear' => '2022', 'isBorrowed' => false],
    ];
}
?>
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
            </div>
            <div class="col">
                <h2>Pinjam Buku</h2>
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
            </div>
            <div class="col">
                <h2>Pengembalian Buku</h2>
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
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <h2>Daftar Buku Tersedia</h2>
                <ul id="availableBooks" class="list-group">
                    <?php
                    foreach ($_SESSION['availableBooks'] as $book) {
                        if (!$book['isBorrowed']) {
                            echo "<li class='list-group-item'>{$book['title']} oleh {$book['author']} (Tahun Terbit: {$book['publicationYear']})</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // Memproses penambahan buku
            $("#addBookForm").submit(function (event) {
                event.preventDefault();
                const title = $("#title").val();
                const author = $("#author").val();
                const publicationYear = $("#publicationYear").val();

                $.post("add_book.php", {title: title, author: author, publicationYear: publicationYear}, function (response) {
                    if (response.success) {
                        const bookInfo = `${title} oleh ${author} (Tahun Terbit: ${publicationYear})`;
                        $("#availableBooks").append(`<li class="list-group-item">${bookInfo}</li>`);
                        $("#borrowTitle").append(`<option value="${title}">${title}</option>`);
                        $("#returnTitle").append(`<option value="${title}">${title}</option>`);
                    } else {
                        alert(response.message);
                    }
                }, 'json');
            });

            // Memproses peminjaman buku
            $("#borrowBookForm").submit(function (event) {
                event.preventDefault();
                const title = $("#borrowTitle").val();
                $.post("borrow_book.php", {title: title}, function (response) {
                    if (response.success) {
                        console.log(`Buku berhasil dipinjam: ${title}`);
                        $(`#availableBooks li:contains('${title}')`).remove();
                        $("#borrowTitle option:selected").remove();
                        $("#returnTitle").append(`<option value="${title}">${title}</option>`);
                    } else {
                        console.log(response.message);
                    }
                }, 'json');
            });

            // Memproses pengembalian buku
            $("#returnBookForm").submit(function (event) {
                event.preventDefault();
                const title = $("#returnTitle").val();
                $.post("return_book.php", {title: title}, function (response) {
                    if (response.success) {
                        const bookInfo = `${title} oleh ${response.author} (Tahun Terbit: ${response.publicationYear})`;
                        $("#availableBooks").append(`<li class="list-group-item">${bookInfo}</li>`);
                        $("#returnTitle option:selected").remove();
                        $("#borrowTitle").append(`<option value="${title}">${title}</option>`);
                    } else {
                        console.log(response.message);
                    }
                }, 'json');
            });
        });
    </script>
</body>
</html>
