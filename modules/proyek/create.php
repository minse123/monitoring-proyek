<?php
require_once __DIR__ . '/../../config/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];
$namaProyek = '';
$tanggalMulai = '';
$tanggalTargetSelesai = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaProyek = trim($_POST['nama_proyek'] ?? '');
    $tanggalMulai = $_POST['tanggal_mulai'] ?? '';
    $tanggalTargetSelesai = $_POST['tanggal_target_selesai'] ?? '';

    if ($namaProyek === '') {
        $errors[] = 'Nama proyek wajib diisi.';
    }

    if ($tanggalMulai === '') {
        $errors[] = 'Tanggal mulai wajib diisi.';
    }

    if ($tanggalTargetSelesai === '') {
        $errors[] = 'Tanggal target selesai wajib diisi.';
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 'INSERT INTO proyek (nama_proyek, tanggal_mulai, tanggal_target_selesai) VALUES (?, ?, ?)');

        if (! $stmt) {
            $errors[] = 'Terjadi kesalahan pada server. Silakan coba lagi.';
        } else {
            mysqli_stmt_bind_param($stmt, 'sss', $namaProyek, $tanggalMulai, $tanggalTargetSelesai);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header('Location: index.php?status=created');
                exit;
            }

            $errors[] = 'Gagal menyimpan data proyek. Silakan coba lagi.';
            mysqli_stmt_close($stmt);
        }
    }
}

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Proyek</h1>
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <h6 class="alert-heading">Terjadi Kesalahan</h6>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Proyek</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="nama_proyek" class="form-label">Nama Proyek</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" placeholder="Masukkan nama proyek" value="<?= htmlspecialchars($namaProyek, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= htmlspecialchars($tanggalMulai, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_target_selesai" class="form-label">Tanggal Target Selesai</label>
                            <input type="date" class="form-control" id="tanggal_target_selesai" name="tanggal_target_selesai" value="<?= htmlspecialchars($tanggalTargetSelesai, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light mr-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
