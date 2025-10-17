@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 px-lg-3">
        <header
            class="d-flex flex-wrap flex-md-nowrap align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Data Proyek</h1>
                <p class="text-muted mb-0">Kelola informasi proyek mulai dari perencanaan hingga arsip.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Proyek
                </a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('projects.index') }}" method="GET" class="row g-3 align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Proyek</label>
                        <input type="search" id="search" name="search" value="{{ request('search') }}"
                            class="form-control" placeholder="Cari kode, nama, klien, atau lokasi">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status Proyek</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected((string) $value === request('status'))>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="per_page" class="form-label">Data per Halaman</label>
                        <select id="per_page" name="per_page" class="form-select">
                            @foreach ([10, 25, 50] as $size)
                                <option value="{{ $size }}" @selected((string) $size === (string) request('per_page', 10))>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Terapkan
                        </button>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                        </a>
                    </div>
                </form>

                @php
                    $statusClasses = [
                        'planned' => 'bg-secondary',
                        'ongoing' => 'bg-primary',
                        'done' => 'bg-success',
                        'archived' => 'bg-dark',
                    ];
                    $isPaginated = $projects instanceof Illuminate\Pagination\AbstractPaginator;
                    $isLengthAware = $projects instanceof Illuminate\Pagination\LengthAwarePaginator;
                @endphp

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 70px;">No.</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama Proyek</th>
                                <th scope="col">Klien</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Periode</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Anggaran</th>
                                <th scope="col" class="text-end" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                @php
                                    $statusLabel = $statuses[$project->status] ?? ucfirst($project->status ?? '');
                                    $badgeClass = $statusClasses[$project->status] ?? 'bg-secondary';
                                    $start = optional($project->start_date)->format('d M Y');
                                    $end = optional($project->end_date)->format('d M Y');
                                @endphp
                                <tr>
                                    <td>
                                        {{ $isPaginated ? $projects->firstItem() + $loop->index : $loop->iteration }}
                                    </td>
                                    <td class="fw-semibold">{{ $project->code }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $project->name }}</div>
                                        <div class="text-muted small">ID #{{ $project->id }}</div>
                                    </td>
                                    <td>{{ $project->client ?? '-' }}</td>
                                    <td>{{ $project->location ?? '-' }}</td>
                                    <td>
                                        <div>{{ $start ?? 'Belum ditetapkan' }}</div>
                                        <div class="text-muted small">{{ $end ? 's.d. ' . $end : 'Tanggal selesai TBD' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if (!is_null($project->budget))
                                            <span class="fw-semibold">Rp {{ number_format($project->budget, 2, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group" aria-label="Aksi Proyek">
                                            <a href="{{ route('projects.show', $project) }}"
                                                class="btn btn-sm btn-outline-secondary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('projects.edit', $project) }}"
                                                class="btn btn-sm btn-outline-primary" title="Ubah">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus proyek ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-kanban text-muted display-5 d-block mb-3"></i>
                                        <p class="mb-1 fw-semibold">Belum ada data proyek</p>
                                        <p class="text-muted mb-3">Mulai tambahkan proyek untuk memantau progres dan anggaran.</p>
                                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-2"></i>Tambah Proyek Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($isPaginated)
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-4">
                        @if ($isLengthAware)
                            <div class="text-muted small">
                                Menampilkan
                                <span class="fw-semibold">{{ $projects->firstItem() }}-{{ $projects->lastItem() }}</span>
                                dari
                                <span class="fw-semibold">{{ $projects->total() }}</span> proyek
                            </div>
                        @endif
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
