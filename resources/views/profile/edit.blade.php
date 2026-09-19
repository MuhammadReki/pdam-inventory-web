@extends('layouts.app')

@section('title', __('menu.profile'))

@section('content')

<div class="row g-4">
    
    <!-- ==================== SIDEBAR KIRI ==================== -->
    <div class="col-md-4">
        <div class="card-custom shadow-sm">
            <div class="text-center py-4">
                <!-- Avatar -->
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width: 100px; height: 100px;">
                    <i class="bi bi-person-fill text-primary" style="font-size: 48px;"></i>
                </div>
                
                <!-- Nama & Email -->
                <h5 class="fw-bold mb-1 text-dark">{{ Auth::user()->name }}</h5>
                <p class="text-muted small mb-2">{{ Auth::user()->email }}</p>
                <span class="badge bg-primary px-3 py-2 rounded-pill">{{ __('profile.administrator') }}</span>
                
                <hr class="my-3">
                
                <!-- Informasi Akun -->
                <div class="text-start px-3">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small"><i class="bi bi-calendar3 me-2"></i> {{ __('profile.bergabung') }}</span>
                        <span class="fw-semibold small">{{ Auth::user()->created_at->format('d F Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small"><i class="bi bi-clock me-2"></i> {{ __('profile.update_terakhir') }}</span>
                        <span class="fw-semibold small">{{ Auth::user()->updated_at->format('d F Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ==================== KANAN ==================== -->
    <div class="col-md-8">
        
        <!-- ====== KARTU EDIT PROFIL ====== -->
        <div class="card-custom shadow-sm">
            <div class="card-header-custom border-0 pb-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-pencil-square text-primary me-2" style="font-size: 1.4rem;"></i>
                    <h5 class="fw-bold mb-0 text-dark">{{ __('profile.edit_profile') }}</h5>
                </div>
                <p class="text-muted small mb-0">{{ __('profile.edit_profile_desc') }}</p>
            </div>
            
            <div class="pt-2">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row g-3">
                        <!-- NAMA -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-person me-1"></i> {{ __('profile.nama_lengkap') }}
                            </label>
                            <input type="text" name="name" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   value="{{ old('name', Auth::user()->name) }}" required
                                   style="border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- EMAIL -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-envelope me-1"></i> {{ __('profile.email') }}
                            </label>
                            <input type="email" name="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   value="{{ old('email', Auth::user()->email) }}" required readonly
                                   style="border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem; background: #f8fafc;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" style="font-size: 0.7rem;">{{ __('profile.email_tidak_diubah') }}</small>
                        </div>
                        
                        <!-- BUTTON -->
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary w-100 py-2" 
                                    style="border-radius: 10px; font-weight: 600; letter-spacing: 0.5px; background: linear-gradient(135deg, #0d47a1, #1565c0); border: none;">
                                <i class="bi bi-save me-2"></i> {{ __('profile.simpan_perubahan') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- ====== KARTU GANTI PASSWORD ====== -->
        <div class="card-custom shadow-sm mt-4">
            <div class="card-header-custom border-0 pb-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-lock text-danger me-2" style="font-size: 1.4rem;"></i>
                    <h5 class="fw-bold mb-0 text-dark">{{ __('profile.ganti_password') }}</h5>
                </div>
                <p class="text-muted small mb-0">{{ __('profile.ganti_password_desc') }}</p>
            </div>
            
            <div class="pt-2">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <!-- PASSWORD LAMA -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-key me-1"></i> {{ __('profile.password_lama') }}
                            </label>
                            <input type="password" name="current_password" 
                                   class="form-control form-control-lg @error('current_password') is-invalid @enderror" 
                                   placeholder="{{ __('profile.password_lama_placeholder') }}" required
                                   style="border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem;">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- PASSWORD BARU -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-key-fill me-1"></i> {{ __('profile.password_baru') }}
                            </label>
                            <input type="password" name="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   placeholder="{{ __('profile.password_baru_placeholder') }}" required
                                   style="border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- KONFIRMASI PASSWORD -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-check-circle me-1"></i> {{ __('profile.konfirmasi_password') }}
                            </label>
                            <input type="password" name="password_confirmation" 
                                   class="form-control form-control-lg" 
                                   placeholder="{{ __('profile.konfirmasi_password_placeholder') }}" required
                                   style="border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem;">
                        </div>
                        
                        <!-- BUTTON -->
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn w-100 py-2" 
                                    style="border-radius: 10px; font-weight: 600; letter-spacing: 0.5px; background: linear-gradient(135deg, #c62828, #d32f2f); color: white; border: none;">
                                <i class="bi bi-lock me-2"></i> {{ __('profile.perbarui_password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

@endsection