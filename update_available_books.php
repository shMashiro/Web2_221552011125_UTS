<?php
// Memulai session
session_start();

// Mengembalikan daftar buku yang tersedia dalam format JSON
echo json_encode($_SESSION['availableBooks']);
?>
