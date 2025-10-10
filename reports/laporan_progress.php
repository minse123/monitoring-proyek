<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$projectOptions = [];
$projectQueryError = null;

$projectQuery = 'SELECT id, nama_proyek FROM proyek ORDER BY nama_proyek ASC';
$projectResult = mysqli_query($conn, $projectQuery);

if ($projectResult instanceof mysqli_result) {
    while ($project = mysqli_fetch_assoc($projectResult)) {
        $projectOptions[] = $project;
    }

    mysqli_free_result($projectResult);
} else {
    $projectQueryError = 'Tidak dapat memuat daftar proyek. Silakan coba lagi.';
}

$selectedProjectId = isset($_GET['project_id']) && $_GET['project_id'] !== ''
    ? (int) $_GET['project_id']
    : null;

$startDateInput = isset($_GET['start_date']) ? trim((string) $_GET['start_date']) : '';
$endDateInput = isset($_GET['end_date']) ? trim((string) $_GET['end_date']) : '';

$startDate = null;
$endDate = null;
$validationErrors = [];

if ($startDateInput !== '') {
    $startDateObject = DateTime::createFromFormat('Y-m-d', $startDateInput);

    if ($startDateObject instanceof DateTime && $startDateObject->format('Y-m-d') === $startDateInput) {
        $startDate = $startDateObject->format('Y-m-d');
    } else {
        $validationErrors[] = 'Format tanggal awal tidak valid.';
    }
}

if ($endDateInput !== '') {
    $endDateObject = DateTime::createFromFormat('Y-m-d', $endDateInput);

    if ($endDateObject instanceof DateTime && $endDateObject->format('Y-m-d') === $endDateInput) {
        $endDate = $endDateObject->format('Y-m-d');
    } else {
        $validationErrors[] = 'Format tanggal akhir tidak valid.';
    }
}

if ($startDate !== null && $endDate !== null && $startDate > $endDate) {
    $validationErrors[] = 'Tanggal akhir harus setelah tanggal awal.';
}

$progressQueryError = null;
$progressData = [];

if ($validationErrors === []) {
    $whereClauses = [];

    if ($selectedProjectId !== null) {
        $whereClauses[] = 'id_proyek = ' . $selectedProjectId;
    }

    if ($startDate !== null) {
        $escapedStart = mysqli_real_escape_string($conn, $startDate);
        $whereClauses[] = "tanggal_update >= '{$escapedStart}'";
    }

    if ($endDate !== null) {
        $escapedEnd = mysqli_real_escape_string($conn, $endDate);
        $whereClauses[] = "tanggal_update <= '{$escapedEnd}'";
    }

    $progressQuery = 'SELECT tanggal_update, nama_proyek, nama_pekerja, persentase_progress FROM progress';

    if ($whereClauses !== []) {
        $progressQuery .= ' WHERE ' . implode(' AND ', $whereClauses);
    }

    $progressQuery .= ' ORDER BY tanggal_update DESC';

    $progressResult = mysqli_query($conn, $progressQuery);

    if ($progressResult instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($progressResult)) {
            $progressData[] = $row;
        }

        mysqli_free_result($progressResult);
    } else {
        $progressQueryError = 'Tidak dapat memuat data progress. Silakan coba lagi.';
    }
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Progress Proyek</h1>
    <button type="button" class="btn btn-primary d-flex align-items-center" onclick="window.print()">
        <i class="fas fa-print mr-2"></i>
        Cetak Laporan
    </button>
</div>

<?php if ($projectQueryError !== null): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($projectQueryError, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<?php if ($validationErrors !== []): ?>
    <div class="alert alert-warning" role="alert">
        <ul class="mb-0 pl-3">
            <?php foreach ($validationErrors as $message): ?>
                <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form method="get">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="project_id">ID Proyek</label>
                    <select class="form-control" id="project_id" name="project_id">
                        <option value="">Semua Proyek</option>
                        <?php foreach ($projectOptions as $project): ?>
                            <option value="<?= (int) $project['id']; ?>" <?= $selectedProjectId === (int) $project['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($project['nama_proyek'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="start_date">Tanggal Awal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="<?= htmlspecialchars($startDateInput, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="<?= htmlspecialchars($endDateInput, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-filter mr-2"></i>
                        Terapkan
                    </button>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 ml-auto">
                    <a href="<?= base_url('reports/laporan_progress.php'); ?>" class="btn btn-light w-100">
                        Atur Ulang
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Progress</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="progressTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 160px;">Tanggal Pembaruan</th>
                        <th>Nama Proyek</th>
                        <th>Nama Pekerja</th>
                        <th style="width: 180px;">Persentase Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($validationErrors === [] && $progressData !== []): ?>
                        <?php foreach ($progressData as $progress): ?>
                            <tr>
                                <td>
                                    <?php
                                    $rawDate = $progress['tanggal_update'] ?? null;
                                    echo htmlspecialchars($rawDate !== null ? date('d/m/Y', strtotime($rawDate)) : '-', ENT_QUOTES, 'UTF-8');
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($progress['nama_proyek'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($progress['nama_pekerja'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php
                                    $rawPercentage = $progress['persentase_progress'] ?? null;
                                    $formattedPercentage = $rawPercentage !== null ? number_format((float) $rawPercentage, 2, ',', '.') : '0,00';
                                    echo htmlspecialchars($formattedPercentage, ENT_QUOTES, 'UTF-8') . '%';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php elseif ($validationErrors === []): ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data progress.</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Perbaiki filter untuk menampilkan data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($progressQueryError !== null): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= htmlspecialchars($progressQueryError, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var datatableCssPath = '<?= asset_url('vendor/datatables/dataTables.bootstrap4.min.css'); ?>';
        if (!document.querySelector('link[href="' + datatableCssPath + '"]')) {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = datatableCssPath;
            document.head.appendChild(link);
        }

        function loadScript(src, callback) {
            var script = document.createElement('script');
            script.src = src;
            script.onload = callback;
            script.onerror = function() {
                console.warn('Gagal memuat skrip: ' + src);
            };
            document.body.appendChild(script);
        }

        function initializeDataTable() {
            if (!window.jQuery || !jQuery.fn) {
                setTimeout(initializeDataTable, 100);
                return;
            }

            if (!jQuery.fn.DataTable) {
                loadScript('<?= asset_url('vendor/datatables/jquery.dataTables.min.js'); ?>', function() {
                    loadScript('<?= asset_url('vendor/datatables/dataTables.bootstrap4.min.js'); ?>', function() {
                        if (jQuery.fn.DataTable) {
                            jQuery('#progressTable').DataTable({
                                order: [
                                    [0, 'desc']
                                ],
                                pageLength: 10
                            });
                        }
                    });
                });
                return;
            }

            jQuery('#progressTable').DataTable({
                order: [
                    [0, 'desc']
                ],
                pageLength: 10
            });
        }

        initializeDataTable();
    });
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
