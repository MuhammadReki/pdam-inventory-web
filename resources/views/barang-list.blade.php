@extends('layouts.app')

@section('title', __('form.list_barang_stok_akhir'))

@section('content')
<div class="card-custom shadow-sm">
    <div class="card-header-custom" style="flex-wrap: wrap; gap: 10px;">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-eye text-primary fs-5"></i>
            </div>
            <h4 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.list_barang_stok_akhir') }}</h4>
            <span class="badge bg-secondary ms-3 rounded-pill">{{ $barangs->count() }} {{ __('form.item') }}</span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <form action="{{ route('barang-list') }}" method="GET" class="d-flex">
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
            @if(request('search'))
                <a href="{{ route('barang-list') }}" class="btn btn-secondary" 
                   style="border-radius: 8px; padding: 6px 12px;">
                    <i class="bi bi-x-circle"></i> {{ __('form.reset') }}
                </a>
            @endif
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table-custom" style="width: 100%; border-collapse: separate; border-spacing: 0 8px;">
            <thead>
                <tr>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 12px 0 0 12px;">{{ __('form.no') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.kode') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.nama_barang') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.satuan') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.harga') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.stok_awal') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.total_masuk') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.stok_akhir') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 0 12px 12px 0;">{{ __('form.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $key => $b)
                <tr style="background: #ffffff; border-radius: 12px; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332; border-radius: 12px 0 0 12px;">{{ $key + 1 }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle;">
                        <span style="background: #e8edf3; color: #1a2332; padding: 4px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">{{ $b->kode_barang }}</span>
                    </td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332;">{{ $b->nama_barang }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; color: #6c7a8a;">{{ $b->satuan ?? '-' }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332;">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 500; color: #1a2332;">{{ $b->stok_awal }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle;">
                        <span style="font-weight: 600; color: #28a745;">
                            <i class="bi bi-plus-circle me-1"></i> +{{ $b->total_masuk }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle;">
                        <span style="font-weight: 700; font-size: 1rem; color: #0d47a1;">{{ $b->stok_akhir }}</span>
                    </td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; border-radius: 0 12px 12px 0;">
                        @php
                            if ($b->stok_akhir > 10) {
                                $status = __('form.tersedia');
                                $color = 'bg-success';
                            } elseif ($b->stok_akhir > 5) {
                                $status = __('form.terbatas');
                                $color = 'bg-warning';
                            } else {
                                $status = __('form.kritis');
                                $color = 'bg-danger';
                            }
                        @endphp
                        <span style="padding: 6px 14px; border-radius: 20px; font-weight: 500; font-size: 0.75rem; 
                            @if($color == 'bg-success') background: #d4edda; color: #155724; 
                            @elseif($color == 'bg-warning') background: #fff3cd; color: #856404; 
                            @else background: #f8d7da; color: #721c24; @endif">
                            {{ $status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <span style="font-size: 1rem;">{{ __('form.belum_ada_data_barang') }}</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-3 d-flex justify-content-between align-items-center text-muted" style="border-top: 1px solid #e8edf3; padding-top: 16px;">
        <div>
            <i class="bi bi-info-circle me-1"></i> {{ __('form.total_barang') }}: <strong style="color: #1a2332;">{{ $barangs->count() }}</strong> {{ __('form.item') }}
        </div>
        <div>
            <span class="badge bg-success me-1">● {{ __('form.tersedia') }}</span>
            <span class="badge bg-warning me-1">● {{ __('form.terbatas') }}</span>
            <span class="badge bg-danger">● {{ __('form.kritis') }}</span>
        </div>
    </div>
</div>
@endsection