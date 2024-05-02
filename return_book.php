<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];

    // Cek apakah buku sedang dipinjam
    $bookFound = false;
    $returnedBook = null;
    foreach ($_SESSION['availableBooks'] as &$book) {
        if ($book['title'] == $title && $book['isBorrowed']) {
            $book['isBorrowed'] = false;
            $bookFound = true;
            $returnedBook = $book;
            break;
        }
    }

    if ($bookFound) {
        // Hapus buku dari daftar buku yang dipinjam
        if (($key = array_search($title, $_SESSION['borrowedBooks'])) !== false) {
            unset($_SESSION['borrowedBooks'][$key]);
        }
        echo json_encode(['success' => true, 'author' => $returnedBook['author'], 'publicationYear' => $returnedBook['publicationYear']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Buku tidak ditemukan atau tidak sedang dipinjam.']);
    }
}
?>
