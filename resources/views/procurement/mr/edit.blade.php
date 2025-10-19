@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 px-lg-3">
        <header
            class="d-flex flex-wrap flex-md-nowrap align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Ubah Permintaan Material</h1>
                <p class="text-muted mb-0">Perbarui rincian permintaan material sesuai kebutuhan terbaru.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('procurement.material-requests.show', $materialRequest) }}"
                    class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </header>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                @include('procurement.mr.partials.form', [
                    'action' => route('procurement.material-requests.update', $materialRequest),
                    'method' => 'PUT',
                    'submitLabel' => 'Perbarui Permintaan',
                    'materialRequest' => $materialRequest,
                    'projects' => $projects,
                    'materials' => $materials,
                    'statuses' => $statuses,
                ])
            </div>
        </div>
    </div>
@endsection
