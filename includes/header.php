<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';

function menu_active(array $targets): string
{
    $current = basename($_SERVER['PHP_SELF']);

    return in_array($current, $targets, true) ? 'active' : '';
}

function menu_collapse_show(array $targets): string
{
    return menu_active($targets) === 'active' ? 'show' : '';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Monitoring Proyek">
    <meta name="author" content="Agha Jaya">

    <title>Sistem Monitoring Proyek</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="/assets/sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/sbadmin2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/assets/custom/custom.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-hard-hat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Monitoring</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item <?= menu_active(['index.php']); ?>">
                <a class="nav-link" href="/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Manajemen Data
            </div>

            <li class="nav-item <?= menu_active(['modules/proyek/index.php', 'modules/proyek/create.php', 'modules/proyek/edit.php']); ?>">
                <a class="nav-link" href="/modules/proyek/index.php">
                    <i class="fas fa-fw fa-project-diagram"></i>
                    <span>Data Proyek</span></a>
            </li>

            <li class="nav-item <?= menu_active(['modules/pekerja/index.php', 'modules/pekerja/create.php', 'modules/pekerja/edit.php']); ?>">
                <a class="nav-link" href="/modules/pekerja/index.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Pekerja</span></a>
            </li>

            <li class="nav-item <?= menu_active(['modules/pekerjaan/index.php', 'modules/progress/index.php']); ?>">
                <a class="nav-link" href="/modules/pekerjaan/index.php">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Jadwal &amp; Progress</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Laporan
            </div>

            <li class="nav-item <?= menu_active([
                'reports/laporan_proyek.php',
                'reports/laporan_jadwal.php',
                'reports/laporan_kinerja.php',
                'reports/laporan_progress.php',
                'reports/laporan_evaluasi.php'
            ]); ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
                    aria-expanded="true" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseReports" class="collapse <?= menu_collapse_show([
                    'reports/laporan_proyek.php',
                    'reports/laporan_jadwal.php',
                    'reports/laporan_kinerja.php',
                    'reports/laporan_progress.php',
                    'reports/laporan_evaluasi.php'
                ]); ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/reports/laporan_proyek.php">Laporan Proyek</a>
                        <a class="collapse-item" href="/reports/laporan_jadwal.php">Laporan Jadwal</a>
                        <a class="collapse-item" href="/reports/laporan_kinerja.php">Laporan Kinerja</a>
                        <a class="collapse-item" href="/reports/laporan_progress.php">Laporan Progress</a>
                        <a class="collapse-item" href="/reports/laporan_evaluasi.php">Laporan Evaluasi</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari sesuatu..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">12 Oktober 2024</div>
                                        Proyek baru telah ditambahkan.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Lihat semua notifikasi</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link" href="/logout.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </li>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : 'Admin'; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="/assets/sbadmin2/img/undraw_profile.svg" alt="User">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">
