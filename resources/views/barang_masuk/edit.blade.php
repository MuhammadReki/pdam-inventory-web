@extends('layouts.app')

@section('title', __('form.edit_barang_masuk'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom">
        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-pencil text-warning fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.edit_barang_masuk') }}</h4>
            <span class="badge bg-warning ms-3 rounded-pill" style="color: #1a2332;">
                <i class="bi bi-pencil me-1"></i> {{ __('form.edit_mode') }}
            </span>
        </div>
        <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 8px 20px; font-weight: 500;">
            <i class="bi bi-arrow-left"></i> {{ __('form.kembali') }}
        </a>
    </div>
    
    <form action="{{ route('barang-masuk.update', $barangMasuk) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-boxes text-primary me-1"></i> {{ __('form.pilih_barang') }} 
                    <span class="text-danger">*</span>
                </label>
                <select name="barang_id" class="form-select form-select-lg @error('barang_id') is-invalid @enderror" required 
                        style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease; background: #fafbfc; color: #1a2332;">
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}" {{ $barangMasuk->barang_id == $b->id ? 'selected' : '' }} style="color: #1a2332;">
                            {{ $b->kode_barang }} - {{ $b->nama_barang }} ({{ __('form.stok') }}: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.pilih_barang_masuk_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-plus-square text-primary me-1"></i> {{ __('form.jumlah') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="number" name="jumlah" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" 
                       value="{{ $barangMasuk->jumlah }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease;">
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.jumlah_masuk_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-calendar text-primary me-1"></i> {{ __('form.tanggal_masuk') }} 
                    <span class="text-danger">*</span>
                </label>
                <input type="date" name="tanggal_masuk" class="form-control form-control-lg @error('tanggal_masuk') is-invalid @enderror" 
                       value="{{ $barangMasuk->tanggal_masuk }}" required 
                       style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease; background: #fafbfc;">
                @error('tanggal_masuk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.tanggal_masuk_info') }}</small>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold" style="color: #1a2332;">
                    <i class="bi bi-pencil-square text-primary me-1"></i> {{ __('form.keterangan') }}
                </label>
                <textarea name="keterangan" class="form-control form-control-lg" rows="3" 
                          style="border-radius: 12px; border: 2px solid #e8edf3; padding: 12px 16px; transition: all 0.3s ease; resize: none;">{{ $barangMasuk->keterangan }}</textarea>
                <small class="text-muted" style="font-size: 0.75rem;">{{ __('form.keterangan_info') }}</small>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-lg w-100" style="border: none; background: linear-gradient(135deg, #f57c00, #fb8c00); color: white; padding: 14px; font-size: 1rem; border-radius: 12px; letter-spacing: 1px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(245, 124, 0, 0.3);">
                    <i class="bi bi-pencil me-2"></i> {{ strtoupper(__('form.update_barang_masuk')) }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection