@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 px-lg-3">
        <header
            class="d-flex flex-wrap flex-md-nowrap align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Ubah Satuan</h1>
                <p class="text-muted mb-0">Perbarui detail satuan sesuai kebutuhan.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('units.show', $unit) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-eye me-2"></i>Lihat Detail
                </a>
                <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </header>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <div class="fw-semibold mb-2">Terdapat kesalahan pada input Anda:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('units.update', $unit) }}" method="POST" class="row g-4">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Satuan</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $unit->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="symbol" class="form-label">Simbol</label>
                        <input type="text" id="symbol" name="symbol" value="{{ old('symbol', $unit->symbol) }}"
                            class="form-control @error('symbol') is-invalid @enderror" required>
                        @error('symbol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Gunakan singkatan maksimal 20 karakter.</div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Perbarui Satuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
