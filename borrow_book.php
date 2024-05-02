<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];

    // Cek apakah buku tersedia
    $bookFound = false;
    foreach ($_SESSION['availableBooks'] as &$book) {
        if ($book['title'] == $title && !$book['isBorrowed']) {
            $book['isBorrowed'] = true;
            $bookFound = true;
            break;
        }
    }

    if ($bookFound) {
        $_SESSION['borrowedBooks'][] = $title;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Buku tidak tersedia atau sudah dipinjam.']);
    }
}
?>
