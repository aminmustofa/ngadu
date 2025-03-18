<?php
// logout.php

session_start();

// Menghapus semua session yang ada
session_unset(); 

// Menghancurkan session
session_destroy(); 

// Mengarahkan pengguna kembali ke halaman index setelah logout
header("Location: index.php");
exit();
?>
