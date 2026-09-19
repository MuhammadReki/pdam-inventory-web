@extends('layouts.app')

@section('title', __('form.master_barang'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom" style="flex-wrap: wrap; gap: 10px;">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-box-seam text-primary fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.master_barang') }}</h4>
            <span class="badge bg-primary ms-3 rounded-pill">{{ $barangs->count() }} {{ __('form.item') }}</span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- FORM SEARCH -->
            <form action="{{ route('barang.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="{{ __('form.cari') }}..." 
                           value="{{ request('search') }}" 
                           style="border-radius: 8px 0 0 8px; border: 2px solid #e8edf3; padding: 6px 12px; width: 220px;">
                    <button class="btn btn-primary-custom" type="submit" 
                            style="border-radius: 0 8px 8px 0; padding: 6px 16px;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <!-- RESET -->
            @if(request('search'))
                <a href="{{ route('barang.index') }}" class="btn btn-secondary" 
                   style="border-radius: 8px; padding: 6px 12px;">
                    <i class="bi bi-x-circle"></i> {{ __('form.reset') }}
                </a>
            @endif
            <!-- TOMBOL TAMBAH -->
            <a href="{{ route('barang.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle"></i> {{ __('form.tambah_barang') }}
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table-custom" style="width: 100%; border-collapse: separate; border-spacing: 0 8px;">
            <thead>
                <tr>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 12px 0 0 12px;">{{ __('form.no') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.kode_barang') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.nama_barang') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.satuan') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.harga') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.stok') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 0 12px 12px 0;" class="text-center">{{ __('form.aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $key => $b)
                <tr style="background: #ffffff; border-radius: 12px; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332; border-radius: 12px 0 0 12px;">{{ $key + 1 }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle;">
                        <span style="background: #e8edf3; color: #1a2332; padding: 4px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.3px;">{{ $b->kode_barang }}</span>
                    </td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332;">{{ $b->nama_barang }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; color: #6c7a8a;">{{ $b->satuan ?? '-' }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332;">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle;">
                        @php
                            $stokClass = $b->stok > 10 ? 'bg-success' : ($b->stok > 5 ? 'bg-warning' : 'bg-danger');
                            $stokColor = $b->stok > 10 ? '#155724' : ($b->stok > 5 ? '#856404' : '#721c24');
                            $stokBg = $b->stok > 10 ? '#d4edda' : ($b->stok > 5 ? '#fff3cd' : '#f8d7da');
                        @endphp
                        <span style="padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; background: {{ $stokBg }}; color: {{ $stokColor }};">
                            <i class="bi bi-box me-1"></i> {{ $b->stok }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; border-radius: 0 12px 12px 0;" class="text-center">
                        <a href="{{ route('barang.edit', $b) }}" class="btn btn-sm btn-warning" style="border-radius: 8px; margin-right: 4px; padding: 6px 10px;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('barang.destroy', $b) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 8px; padding: 6px 10px;" onclick="return confirm('{{ __('form.yakin_hapus') }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <span style="font-size: 1rem;">{{ __('form.belum_ada_data_barang') }}</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection