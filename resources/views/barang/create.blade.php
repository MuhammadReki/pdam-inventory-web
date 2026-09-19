@extends('layouts.app')

@section('title', __('form.tambah_barang'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-plus-circle text-primary fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.tambah_barang') }}</h4>
        </div>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left"></i> {{ __('form.kembali') }}
        </a>
    </div>
    
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-tag text-primary me-1"></i> {{ __('form.kode_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="kode_barang" class="form-control form-control-lg @error('kode_barang') is-invalid @enderror" 
                       placeholder="{{ __('form.contoh_kode') }}" required style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('kode_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.kode_unik') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-box text-primary me-1"></i> {{ __('form.nama_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="text" name="nama_barang" class="form-control form-control-lg @error('nama_barang') is-invalid @enderror" 
                       placeholder="{{ __('form.nama_barang_placeholder') }}" required style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
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
                       placeholder="{{ __('form.contoh_satuan') }}" required style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.satuan_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-currency-rupiah text-primary me-1"></i> {{ __('form.harga') }} (Rp) 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="harga" class="form-control form-control-lg @error('harga') is-invalid @enderror" 
                       placeholder="0" required style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-boxes text-primary me-1"></i> {{ __('form.stok_awal_label') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="stok" class="form-control form-control-lg @error('stok') is-invalid @enderror" 
                       placeholder="0" required style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.stok_awal_info') }}</small>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary-custom btn-lg w-100" style="padding: 14px; font-size: 1rem; border-radius: 12px; letter-spacing: 1px;">
                    <i class="bi bi-save me-2"></i> {{ strtoupper(__('form.simpan_barang')) }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection