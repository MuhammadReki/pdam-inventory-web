@extends('layouts.app')

@section('title', __('form.tambah_barang_keluar'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom">
        <div class="d-flex align-items-center">
            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-arrow-up-circle text-danger fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.tambah_barang_keluar') }}</h4>
        </div>
        <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left"></i> {{ __('form.kembali') }}
        </a>
    </div>
    
    <form action="{{ route('barang-keluar.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-boxes text-danger me-1"></i> {{ __('form.pilih_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <select name="barang_id" class="form-select form-select-lg @error('barang_id') is-invalid @enderror" required>
                    <option value="">{{ __('form.pilih_barang_placeholder') }}</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}">
                            {{ $b->kode_barang }} - {{ $b->nama_barang }} ({{ __('form.stok') }}: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.pilih_barang_keluar_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-dash-circle text-danger me-1"></i> {{ __('form.jumlah') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="jumlah" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" placeholder="{{ __('form.jumlah_keluar_placeholder') }}" required>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.jumlah_keluar_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-calendar text-danger me-1"></i> {{ __('form.tanggal_keluar') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="date" name="tanggal_keluar" class="form-control form-control-lg @error('tanggal_keluar') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                @error('tanggal_keluar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.tanggal_keluar_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-pencil-square text-danger me-1"></i> {{ __('form.keterangan') }}
                </label>
                <textarea name="keterangan" class="form-control form-control-lg" rows="3" placeholder="{{ __('form.opsional') }}"></textarea>
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.keterangan_info') }}</small>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-danger btn-lg w-100" style="border: none; background: linear-gradient(135deg, #c62828, #d32f2f); color: white; padding: 14px; font-size: 1rem; border-radius: 12px; letter-spacing: 1px; font-weight: 600;">
                    <i class="bi bi-arrow-up-circle me-2"></i> {{ strtoupper(__('form.simpan_barang_keluar')) }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection