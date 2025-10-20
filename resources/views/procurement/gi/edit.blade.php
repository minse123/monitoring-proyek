@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 px-lg-3">
        <header
            class="d-flex flex-wrap flex-md-nowrap align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Ubah Goods Issue</h1>
                <p class="text-muted mb-0">Perbarui informasi pengeluaran material dan penelusuran stok.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('procurement.goods-issues.show', $goodsIssue) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </header>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                @include('procurement.gi.partials.form', [
                    'action' => route('procurement.goods-issues.update', $goodsIssue),
                    'method' => 'PUT',
                    'goodsIssue' => $goodsIssue,
                    'projects' => $projects,
                    'materials' => $materials,
                    'statuses' => $statuses,
                    'submitLabel' => 'Perbarui Goods Issue',
                ])
            </div>
        </div>
    </div>
@endsection
