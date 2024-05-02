<?php
// Simulasi database buku yang tersedia
$availableBooks = [
    ['title' => 'Book 1', 'author' => 'Author 1', 'publicationYear' => '2020'],
    ['title' => 'Book 2', 'author' => 'Author 2', 'publicationYear' => '2021'],
    ['title' => 'Book 3', 'author' => 'Author 3', 'publicationYear' => '2022'],
];

// Menerima data buku baru dari form
$title = $_POST['title'];
$author = $_POST['author'];
$publicationYear = $_POST['publicationYear'];

// Menambahkan buku baru ke dalam database
$availableBooks[] = ['title' => $title, 'author' => $author, 'publicationYear' => $publicationYear];

// Mengembalikan respons
$response = ['success' => true, 'bookInfo' => "{$title} oleh {$author} (Tahun Terbit: {$publicationYear})"];
echo json_encode($response);
?>
