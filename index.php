<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/includes/header.php';

if (! function_exists('formatIndonesianDate')) {
    function formatIndonesianDate(?string $date): string
    {
        if ($date === null) {
            return '-';
        }

        $timestamp = strtotime($date);

        return $timestamp !== false ? date('d M Y', $timestamp) : '-';
    }
}

$statsConfig = [
    'proyek' => [
        'label' => 'Total Proyek',
        'color' => 'primary',
        'icon' => 'fas fa-project-diagram',
        'url' => base_url('modules/proyek/index.php'),
        'subtitle' => 'Proyek yang terdaftar di sistem'
    ],
    'pekerja' => [
        'label' => 'Total Pekerja',
        'color' => 'success',
        'icon' => 'fas fa-users',
        'url' => base_url('modules/pekerja/index.php'),
        'subtitle' => 'Tenaga kerja yang aktif'
    ],
    'jadwal_pekerjaan' => [
        'label' => 'Total Jadwal',
        'color' => 'warning',
        'icon' => 'fas fa-calendar-alt',
        'url' => base_url('modules/pekerjaan/index.php'),
        'subtitle' => 'Penugasan dan jadwal pekerjaan'
    ],
    'progress_proyek' => [
        'label' => 'Laporan Progress',
        'color' => 'info',
        'icon' => 'fas fa-chart-line',
        'url' => base_url('modules/progress/index.php'),
        'subtitle' => 'Update perkembangan proyek'
    ],
];

$statistics = [];
$statErrors = [];

foreach ($statsConfig as $table => $meta) {
    $query = sprintf('SELECT COUNT(*) AS total FROM %s', $table);
    $result = mysqli_query($conn, $query);

    if ($result instanceof mysqli_result) {
        $row = mysqli_fetch_assoc($result);
        $statistics[$table] = isset($row['total']) ? (int) $row['total'] : 0;
        mysqli_free_result($result);
        continue;
    }

    $statistics[$table] = null;
    $statErrors[] = sprintf('Tidak dapat memuat statistik %s.', $meta['label']);
}

$recentProjects = [];
$recentProjectsError = null;

$recentQuery = mysqli_query(
    $conn,
    'SELECT nama_proyek, tanggal_mulai, tanggal_target_selesai FROM proyek ORDER BY tanggal_mulai DESC LIMIT 5'
);

if ($recentQuery instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($recentQuery)) {
        $recentProjects[] = $row;
    }

    mysqli_free_result($recentQuery);
} else {
    $recentProjectsError = 'Tidak dapat memuat proyek terbaru.';
}

$upcomingDeadlines = [];
$upcomingDeadlinesError = null;

$deadlineQuery = mysqli_query(
    $conn,
    'SELECT nama_proyek, tanggal_target_selesai FROM proyek WHERE tanggal_target_selesai >= CURDATE() ORDER BY tanggal_target_selesai ASC LIMIT 5'
);

if ($deadlineQuery instanceof mysqli_result) {
    while ($row = mysqli_fetch_assoc($deadlineQuery)) {
        $upcomingDeadlines[] = $row;
    }

    mysqli_free_result($deadlineQuery);
} else {
    $upcomingDeadlinesError = 'Tidak dapat memuat deadline proyek.';
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="<?= base_url('reports/laporan_proyek.php'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i>
        Unduh Laporan Proyek
    </a>
</div>

<?php if (! empty($statErrors)): ?>
    <div class="alert alert-warning" role="alert">
        <?php foreach ($statErrors as $error): ?>
            <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="row">
    <?php foreach ($statsConfig as $key => $meta): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?= htmlspecialchars($meta['color'], ENT_QUOTES, 'UTF-8'); ?> shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-<?= htmlspecialchars($meta['color'], ENT_QUOTES, 'UTF-8'); ?> text-uppercase mb-1">
                                <?= htmlspecialchars($meta['label'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if ($statistics[$key] !== null): ?>
                                    <?= htmlspecialchars(number_format($statistics[$key]), ENT_QUOTES, 'UTF-8'); ?>
                                <?php else: ?>
                                    <span class="text-muted">&mdash;</span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2 text-xs text-muted">
                                <?= htmlspecialchars($meta['subtitle'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="<?= htmlspecialchars($meta['icon'], ENT_QUOTES, 'UTF-8'); ?> fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <?php if (! empty($meta['url'])): ?>
                    <div class="card-footer py-2">
                        <a href="<?= htmlspecialchars($meta['url'], ENT_QUOTES, 'UTF-8'); ?>" class="text-xs font-weight-bold text-secondary">
                            Lihat detail
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Proyek Terbaru</h6>
            </div>
            <div class="card-body">
                <?php if ($recentProjectsError !== null): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($recentProjectsError, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php elseif (empty($recentProjects)): ?>
                    <p class="text-muted mb-0">Belum ada data proyek terbaru.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nama Proyek</th>
                                    <th scope="col">Tanggal Mulai</th>
                                    <th scope="col">Target Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentProjects as $project): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($project['nama_proyek'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars(formatIndonesianDate($project['tanggal_mulai'] ?? null), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars(formatIndonesianDate($project['tanggal_target_selesai'] ?? null), ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Deadline Terdekat</h6>
            </div>
            <div class="card-body">
                <?php if ($upcomingDeadlinesError !== null): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($upcomingDeadlinesError, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php elseif (empty($upcomingDeadlines)): ?>
                    <p class="text-muted mb-0">Belum ada deadline dalam waktu dekat.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($upcomingDeadlines as $deadline): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($deadline['nama_proyek'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="badge badge-warning badge-pill">
                                    <?= htmlspecialchars(formatIndonesianDate($deadline['tanggal_target_selesai'] ?? null), ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
