@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 px-lg-3">
        <header
            class="d-flex flex-wrap flex-md-nowrap align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Ubah Supplier</h1>
                <p class="text-muted mb-0">Perbarui informasi pemasok agar selalu akurat dan terbaru.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-outline-secondary">
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

                <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="row g-4">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Supplier</label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name', $supplier->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Nama perusahaan" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="npwp" class="form-label">NPWP</label>
                        <input type="text" id="npwp" name="npwp"
                            value="{{ old('npwp', $supplier->npwp) }}"
                            class="form-control @error('npwp') is-invalid @enderror" placeholder="NPWP perusahaan">
                        @error('npwp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $supplier->email) }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="contoh@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone"
                            value="{{ old('phone', $supplier->phone) }}"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="0812xxxxxxx">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="rating" class="form-label">Rating</label>
                        <select id="rating" name="rating" class="form-select @error('rating') is-invalid @enderror">
                            @foreach (range(0, 5) as $ratingOption)
                                <option value="{{ $ratingOption }}"
                                    @selected((int) old('rating', $supplier->rating) === $ratingOption)>
                                    {{ $ratingOption }}
                                </option>
                            @endforeach
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nilai 0 menandakan belum ada penilaian.</div>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea id="address" name="address" rows="4"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Alamat lengkap kantor atau gudang">{{ old('address', $supplier->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-between gap-2">
                        <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
