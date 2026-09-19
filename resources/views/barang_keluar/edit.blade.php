@extends('layouts.app')

@section('title', __('form.edit_barang_keluar'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom">
        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-pencil text-warning fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.edit_barang_keluar') }}</h4>
            <span class="badge bg-warning ms-3 rounded-pill" style="color: #1a2332;">
                <i class="bi bi-pencil me-1"></i> {{ __('form.edit_mode') }}
            </span>
        </div>
        <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left"></i> {{ __('form.kembali') }}
        </a>
    </div>
    
    <form action="{{ route('barang-keluar.update', $barangKeluar) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-boxes text-danger me-1"></i> {{ __('form.pilih_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <select name="barang_id" class="form-select form-select-lg @error('barang_id') is-invalid @enderror" required>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}" {{ $barangKeluar->barang_id == $b->id ? 'selected' : '' }}>
                            {{ $b->kode_barang }} - {{ $b->nama_barang }} ({{ __('form.stok') }}: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-dash-circle text-danger me-1"></i> {{ __('form.jumlah') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="jumlah" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" value="{{ $barangKeluar->jumlah }}" required>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-calendar text-danger me-1"></i> {{ __('form.tanggal_keluar') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="date" name="tanggal_keluar" class="form-control form-control-lg @error('tanggal_keluar') is-invalid @enderror" value="{{ $barangKeluar->tanggal_keluar }}" required>
                @error('tanggal_keluar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-pencil-square text-danger me-1"></i> {{ __('form.keterangan') }}
                </label>
                <textarea name="keterangan" class="form-control form-control-lg" rows="3">{{ $barangKeluar->keterangan }}</textarea>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-warning btn-lg w-100" style="border: none; background: linear-gradient(135deg, #f57c00, #fb8c00); color: white; padding: 14px; font-size: 1rem; border-radius: 12px; letter-spacing: 1px; font-weight: 600;">
                    <i class="bi bi-pencil me-2"></i> {{ strtoupper(__('form.update_barang_keluar')) }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection 