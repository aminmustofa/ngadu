<?php
// logout.php

session_start(); // Memulai session

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
