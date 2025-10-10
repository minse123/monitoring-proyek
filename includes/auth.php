<?php
require_once __DIR__ . '/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (! isset($_SESSION['username'])) {
    header('Location: ' . base_url('login.php'));
    exit;
}
