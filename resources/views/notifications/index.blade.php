@extends('layouts.app')

@section('title', __('menu.notifikasi'))
@section('page-title', __('menu.notifikasi'))
@section('breadcrumb', __('menu.daftar_notifikasi'))

@section('content')

<div class="card-premium animate-fade-in-up">
    <div class="card-header-premium">
        <div>
            <h5>
                <i class="bi bi-bell-fill me-2" style="color: #4fc3f7;"></i>
                {{ __('menu.semua_notifikasi') }}
                @if($unreadCount > 0)
                    <span class="badge-count ms-2">{{ $unreadCount }} {{ __('menu.belum_dibaca') }}</span>
                @endif
            </h5>
        </div>
        <div class="d-flex gap-2">
            @if($unreadCount > 0)
                <button class="btn-premium btn-premium-sm" onclick="markAllRead()">
                    <i class="bi bi-check2-all"></i> {{ __('menu.tandai_semua_dibaca') }}
                </button>
            @endif
        </div>
    </div>

    @if($notifications->count() > 0)
        <div class="notif-list-full">
            @foreach($notifications as $notif)
                <div class="notif-item-full {{ $notif->is_read ? 'read' : 'unread' }}" 
                     data-id="{{ $notif->id }}"
                     onclick="handleNotifClick({{ $notif->id }}, '{{ $notif->reference_type }}', '{{ $notif->reference_id }}')">
                    
                    <div class="notif-icon-full" style="background: {{ $notif->type === 'danger' ? 'rgba(255,107,107,0.15)' : ($notif->type === 'warning' ? 'rgba(255,193,7,0.15)' : ($notif->type === 'success' ? 'rgba(46,213,115,0.15)' : 'rgba(79,195,247,0.15)')) }};">
                        {{ $notif->icon ?? '🔔' }}
                    </div>

                    <div class="notif-body-full">
                        <div class="notif-title-full">{{ $notif->title }}</div>
                        <div class="notif-message-full">{{ $notif->message }}</div>
                        <div class="notif-meta-full">
                            <span class="notif-badge-source">
                                <i class="bi bi-{{ $notif->source === 'mobile' ? 'phone' : ($notif->source === 'web' ? 'globe' : 'gear') }}"></i>
                                {{ ucfirst($notif->source) }}
                            </span>
                            <span class="notif-time-full">
                                <i class="bi bi-calendar"></i>
                                {{ $notif->created_at->locale(app()->getLocale())->translatedFormat('d M Y') }}
                                &nbsp;
                                <i class="bi bi-clock"></i>
                                {{ $notif->created_at->format('H:i:s') }}
                                <span style="color: rgba(255,255,255,0.3); font-style: italic; margin-left: 6px;">
                                    ({{ $notif->created_at->diffForHumans() }})
                                </span>
                            </span>
                        </div>
                    </div>

                    @if(!$notif->is_read)
                        <div class="notif-dot-full"></div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div style="font-size: 4rem; opacity: 0.3;">🔕</div>
            <h5 style="color: rgba(255,255,255,0.5); margin-top: 16px;">{{ __('menu.belum_ada_notif') }}</h5>
            <p style="color: rgba(255,255,255,0.3);">{{ __('menu.semua_notif_muncul') }}</p>
        </div>
    @endif
</div>

<style>
.notif-list-full {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.notif-item-full {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.04);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.notif-item-full:hover {
    background: rgba(255,255,255,0.06);
    border-color: rgba(79,195,247,0.15);
    transform: translateX(4px);
}

.notif-item-full.unread {
    background: rgba(79,195,247,0.05);
    border-color: rgba(79,195,247,0.1);
}

.notif-item-full.read {
    opacity: 0.6;
}

.notif-icon-full {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.notif-body-full {
    flex: 1;
}

.notif-title-full {
    font-weight: 700;
    color: #fff;
    font-size: 0.95rem;
    margin-bottom: 4px;
}

.notif-message-full {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    margin-bottom: 8px;
}

.notif-meta-full {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 0.7rem;
    color: rgba(255,255,255,0.5);
    align-items: center;
}

.notif-badge-source,
.notif-time-full {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
}

.notif-time-full i {
    color: #4fc3f7;
}

.notif-dot-full {
    width: 8px;
    height: 8px;
    background: #4fc3f7;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 6px;
}
</style>

<script>
function handleNotifClick(id, refType, refId) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        if (window.refreshNotifBadge) window.refreshNotifBadge();

        if (refType === 'Barang') {
            window.location.href = `/barang/${refId}/edit`;
        } else if (refType === 'BarangMasuk') {
            window.location.href = `/barang-masuk`;
        } else if (refType === 'BarangKeluar') {
            window.location.href = `/barang-keluar`;
        } else {
            window.location.reload();
        }
    });
}

function markAllRead() {
    fetch('{{ route('notifications.read-all') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        window.location.reload();
    });
}
</script>

@endsection