@extends('layouts.app')

@section('title', __('form.edit_barang'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom">
        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-pencil text-warning fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.edit_barang') }}</h4>
            <span class="badge bg-warning ms-3 rounded-pill" style="color: #1a2332;">
                <i class="bi bi-pencil me-1"></i> {{ __('form.edit_mode') }}
            </span>
        </div>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left"></i> {{ __('form.kembali') }}
        </a>
    </div>
    
    <form action="{{ route('barang.update', $barang) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-tag text-primary me-1"></i> {{ __('form.kode_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="kode_barang" class="form-control form-control-lg @error('kode_barang') is-invalid @enderror" 
                       value="{{ $barang->kode_barang }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease; background: #fafbfc;">
                @error('kode_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-box text-primary me-1"></i> {{ __('form.nama_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="nama_barang" class="form-control form-control-lg @error('nama_barang') is-invalid @enderror" 
                       value="{{ $barang->nama_barang }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-rulers text-primary me-1"></i> {{ __('form.satuan') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="satuan" class="form-control form-control-lg @error('satuan') is-invalid @enderror" 
                       value="{{ $barang->satuan }}" placeholder="{{ __('form.contoh_satuan') }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-currency-rupiah text-primary me-1"></i> {{ __('form.harga') }} (Rp) 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="harga" class="form-control form-control-lg @error('harga') is-invalid @enderror" 
                       value="{{ $barang->harga }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-boxes text-primary me-1"></i> {{ __('form.stok') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="stok" class="form-control form-control-lg @error('stok') is-invalid @enderror" 
                       value="{{ $barang->stok }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-lg w-100" style="border: none; background: linear-gradient(135deg, #f57c00, #fb8c00); color: white; padding: 14px; font-size: 1rem; border-radius: 12px; letter-spacing: 1px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(245, 124, 0, 0.3);">
                    <i class="bi bi-pencil me-2"></i> {{ strtoupper(__('form.update_barang')) }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection