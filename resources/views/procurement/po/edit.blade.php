@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 px-lg-3">
        <header
            class="d-flex flex-wrap flex-md-nowrap align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Ubah Purchase Order</h1>
                <p class="text-muted mb-0">Perbarui detail purchase order untuk memastikan data tetap akurat.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('procurement.purchase-orders.show', $purchaseOrder) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </header>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                @include('procurement.po.partials.form', [
                    'action' => route('procurement.purchase-orders.update', $purchaseOrder),
                    'method' => 'PUT',
                    'submitLabel' => 'Perbarui Purchase Order',
                    'purchaseOrder' => $purchaseOrder,
                    'suppliers' => $suppliers,
                    'projects' => $projects,
                    'materials' => $materials,
                    'materialRequests' => $materialRequests,
                    'statuses' => $statuses,
                ])
            </div>
        </div>
    </div>
@endsection
