<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Halaman daftar notifikasi
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::query()
            ->forPlatform('web')
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::query()
            ->forPlatform('web')
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->unread()
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Ambil notif terbaru (AJAX buat dropdown & polling)
     */
    public function latest(Request $request)
    {
        $user = Auth::user();
        $since = $request->query('since', 0);

        $query = Notification::query()
            ->forPlatform('web')
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->orderBy('created_at', 'desc');

        if ($since > 0) {
            $query->where('id', '>', $since);
        }

        $notifications = $query->limit(10)->get();

        $unreadCount = Notification::query()
            ->forPlatform('web')
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->unread()
            ->count();

        return response()->json([
            'success'       => true,
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
            'last_id'       => $notifications->first()->id ?? $since,
        ]);
    }

    /**
     * Tandai 1 notif sudah dibaca
     */
    public function markAsRead($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json(['success' => false, 'message' => 'Notif tidak ditemukan'], 404);
        }

        $notif->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Tandai semua notif sudah dibaca
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        Notification::query()
            ->forPlatform('web')
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->unread()
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Hapus notif
     */
    public function destroy($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json(['success' => false], 404);
        }

        $notif->delete();

        return response()->json(['success' => true]);
    }
}