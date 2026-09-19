@extends('layouts.app')

@section('title', __('menu.dashboard'))
@section('page-title', __('menu.dashboard'))
@section('breadcrumb', __('menu.dashboard') . ' / ' . __('menu.selamat_datang'))

@section('content')

<!-- 4 KARTU STATISTIK -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 animate-fade-in-up animate-delay-1">
        <div class="stat-card" style="background: #ffffff; border-radius: 16px; padding: 20px 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border-left: 4px solid #0d47a1; height: 100%;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label" style="font-size: 0.7rem; color: #6c7a8a; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        <i class="bi bi-box me-1"></i> {{ __('form.total_barang') }}
                    </p>
                    <h3 class="stat-number" style="font-size: 2rem; font-weight: 700; color: #1a2332; margin: 4px 0 0 0;">{{ $totalBarang }}</h3>
                </div>
                <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(13, 71, 161, 0.1); color: #0d47a1; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="mt-2">
                <span style="color: #94a3b8; font-size: 0.65rem; letter-spacing: 0.5px;">
                    <i class="bi bi-arrow-up-short" style="color: #10b981;"></i> +2 {{ __('form.dari_bulan_lalu') }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 animate-fade-in-up animate-delay-2">
        <div class="stat-card" style="background: #ffffff; border-radius: 16px; padding: 20px 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border-left: 4px solid #10b981; height: 100%;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label" style="font-size: 0.7rem; color: #6c7a8a; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        <i class="bi bi-boxes me-1"></i> {{ __('form.total_stok') }}
                    </p>
                    <h3 class="stat-number" style="font-size: 2rem; font-weight: 700; color: #1a2332; margin: 4px 0 0 0;">{{ $totalStok }}</h3>
                </div>
                <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-boxes"></i>
                </div>
            </div>
            <div class="mt-2">
                <span style="color: #94a3b8; font-size: 0.65rem; letter-spacing: 0.5px;">
                    <i class="bi bi-arrow-up-short" style="color: #10b981;"></i> +15 {{ __('form.dari_bulan_lalu') }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 animate-fade-in-up animate-delay-3">
        <div class="stat-card" style="background: #ffffff; border-radius: 16px; padding: 20px 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border-left: 4px solid #f59e0b; height: 100%;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label" style="font-size: 0.7rem; color: #6c7a8a; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        <i class="bi bi-exclamation-triangle me-1"></i> {{ __('form.stok_menipis_5_10') }}
                    </p>
                    <h3 class="stat-number" style="font-size: 2rem; font-weight: 700; color: #1a2332; margin: 4px 0 0 0;">{{ $stokMenipis }}</h3>
                </div>
                <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
            <div class="mt-2">
                <span style="color: #94a3b8; font-size: 0.65rem; letter-spacing: 0.5px;">
                    <i class="bi bi-exclamation-circle" style="color: #f59e0b;"></i> {{ __('form.perlu_perhatian') }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 animate-fade-in-up animate-delay-4">
        <div class="stat-card" style="background: #ffffff; border-radius: 16px; padding: 20px 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border-left: 4px solid #dc2626; height: 100%;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="stat-label" style="font-size: 0.7rem; color: #6c7a8a; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        <i class="bi bi-exclamation-octagon me-1"></i> {{ __('form.stok_kritis_5') }}
                    </p>
                    <h3 class="stat-number" style="font-size: 2rem; font-weight: 700; color: #1a2332; margin: 4px 0 0 0;">{{ $stokKritis }}</h3>
                </div>
                <div class="stat-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(220, 38, 38, 0.1); color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>
            </div>
            <div class="mt-2">
                <span style="color: #94a3b8; font-size: 0.65rem; letter-spacing: 0.5px;">
                    <i class="bi bi-exclamation-circle" style="color: #dc2626;"></i> {{ __('form.segera_diisi') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- LIST BARANG LENGKAP -->
<div class="card" style="background: #ffffff; border: none; border-radius: 20px; padding: 28px 30px; box-shadow: 0 2px 16px rgba(0,0,0,0.05);">
    <div class="card-header" style="border-bottom: 2px solid #e8edf3; padding-bottom: 18px; margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: transparent;">
        <div class="d-flex align-items-center gap-3">
            <div style="width: 40px; height: 40px; background: rgba(13, 71, 161, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-list-ul" style="color: #0d47a1; font-size: 1.2rem;"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="color: #1a2332;">{{ __('form.list_semua_barang') }}</h5>
                <span style="color: #94a3b8; font-size: 0.75rem;">{{ __('form.data_inventaris') }}</span>
            </div>
            <span class="badge" style="background: #e8edf3; color: #1a2332; padding: 4px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">{{ $barangs->count() }} {{ __('form.item') }}</span>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form action="{{ route('dashboard') }}" method="GET" class="d-flex">
                <div class="input-group" style="width: 220px;">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="{{ __('form.cari') }}..." 
                           value="{{ request('search') }}" 
                           style="border: 2px solid #e8edf3; border-radius: 10px 0 0 10px; padding: 6px 14px; font-size: 0.85rem;">
                    <button class="btn" type="submit" style="border-radius: 0 10px 10px 0; padding: 6px 16px; background: #0d47a1; color: #fff; border: none;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            @if(request('search'))
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm" style="border-radius: 8px; padding: 6px 12px; background: #e8edf3; color: #1a2332; border: none;">
                    <i class="bi bi-x-circle"></i> {{ __('form.reset') }}
                </a>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0 8px;">
            <thead>
                <tr>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 12px 0 0 12px;">{{ __('form.no') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.kode') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.nama_barang') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.satuan') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.harga') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">{{ __('form.stok') }}</th>
                    <th style="padding: 12px 16px; background: #f0f4f8; color: #1a2332; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 0 12px 12px 0;">{{ __('form.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $key => $b)
                <tr style="background: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #1a2332; border-radius: 12px 0 0 12px;">{{ $key + 1 }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle;">
                        <span style="background: #e8edf3; color: #1a2332; padding: 4px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">{{ $b->kode_barang }}</span>
                    </td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 500; color: #1a2332;">{{ $b->nama_barang }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; color: #6c7a8a;">{{ $b->satuan ?? '-' }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 600; color: #0d47a1;">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; font-weight: 700; color: #1a2332;">{{ $b->stok }}</td>
                    <td style="padding: 14px 16px; border: none; vertical-align: middle; border-radius: 0 12px 12px 0;">
                        @php
                            if ($b->stok > 10) {
                                $status = __('form.tersedia');
                                $class = 'tersedia';
                            } elseif ($b->stok >= 5) {
                                $status = __('form.menipis');
                                $class = 'menipis';
                            } else {
                                $status = __('form.kritis');
                                $class = 'kritis';
                            }
                        @endphp
                        <span style="padding: 4px 14px; border-radius: 20px; font-weight: 500; font-size: 0.7rem;
                            @if($class == 'tersedia') background: #d4edda; color: #155724;
                            @elseif($class == 'menipis') background: #fff3cd; color: #856404;
                            @else background: #f8d7da; color: #721c24; @endif">
                            {{ $status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color: #94a3b8;">
                        <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #d1d5db;"></i>
                        <span style="font-size: 1rem;">{{ __('form.belum_ada_data_barang') }}</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Footer Table -->
    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap" style="border-color: #e8edf3 !important;">
        <div>
            <span style="font-size: 0.82rem; color: #94a3b8;">
                <i class="bi bi-person-circle me-1"></i> 
                <span style="font-weight: 500; color: #1a2332;">Muhammad Reki</span>
                <span style="color: #cbd5e1;">· {{ __('form.admin') }}</span>
            </span>
        </div>
        <div>
            <span style="font-size: 0.78rem; color: #94a3b8;">
                {{ __('form.menampilkan') }} 1 - {{ min(5, $barangs->count()) }} {{ __('form.dari') }} {{ $barangs->count() }} {{ __('form.data') }}
            </span>
        </div>
    </div>
</div>

@endsection