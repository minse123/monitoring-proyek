<?php
require_once __DIR__ . '/../../includes/header.php';

$query = 'SELECT id, nama_proyek, tanggal_mulai, tanggal_target_selesai FROM proyek ORDER BY tanggal_mulai DESC';
$result = mysqli_query($conn, $query);

$statusMessage = null;
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'created':
            $statusMessage = ['type' => 'success', 'text' => 'Data proyek berhasil ditambahkan.'];
            break;
        case 'updated':
            $statusMessage = ['type' => 'success', 'text' => 'Data proyek berhasil diperbarui.'];
            break;
        case 'deleted':
            $statusMessage = ['type' => 'success', 'text' => 'Data proyek berhasil dihapus.'];
            break;
        case 'error':
            $statusMessage = ['type' => 'danger', 'text' => 'Terjadi kesalahan saat memproses permintaan.'];
            break;
    }
}

$queryError = $result === false ? 'Tidak dapat memuat data proyek. Silakan coba lagi.' : null;

?>

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Proyek</h1>
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            Tambah Proyek
        </a>
    </div>

    <?php if ($statusMessage !== null): ?>
        <div class="alert alert-<?= htmlspecialchars($statusMessage['type'], ENT_QUOTES, 'UTF-8'); ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($statusMessage['text'], ENT_QUOTES, 'UTF-8'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($queryError !== null): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($queryError, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Proyek</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" style="width: 60px;">No</th>
                            <th scope="col">Nama Proyek</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Target Selesai</th>
                            <th scope="col" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_proyek'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['tanggal_mulai'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['tanggal_target_selesai'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= urlencode((string) $row['id']); ?>" class="btn btn-sm btn-warning mr-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <a href="delete.php?id=<?= urlencode((string) $row['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data proyek.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if ($result instanceof mysqli_result) {
    mysqli_free_result($result);
}

require_once __DIR__ . '/../../includes/footer.php';
