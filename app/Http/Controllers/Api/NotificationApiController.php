<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationApiController extends Controller
{
    /**
     * GET /api/notifications
     */
    public function index(Request $request)
    {
        $platform = $request->query('platform', 'mobile');
        $since = $request->query('since', 0);
        $user = $request->user();

        $query = Notification::query()
            ->forPlatform($platform)
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->when($since > 0, function ($q) use ($since) {
                $q->where('id', '>', $since);
            })
            ->orderBy('created_at', 'desc')
            ->limit(50);

        $notifications = $query->get();

        return response()->json([
            'success'        => true,
            'count'          => $notifications->count(),
            'unread_count'   => Notification::forPlatform($platform)->unread()->count(),
            'notifications'  => $notifications,
            'last_id'        => $notifications->first()->id ?? $since,
        ]);
    }

    /**
     * GET /api/notifications/unread-count
     */
    public function unreadCount(Request $request)
    {
        $platform = $request->query('platform', 'mobile');
        $user = $request->user();

        $count = Notification::query()
            ->forPlatform($platform)
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->unread()
            ->count();

        return response()->json([
            'success'      => true,
            'unread_count' => $count,
        ]);
    }

    /**
     * POST /api/notifications/{id}/read
     */
    public function markAsRead($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $notif->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca',
        ]);
    }

    /**
     * POST /api/notifications/read-all
     */
    public function markAllAsRead(Request $request)
    {
        $platform = $request->query('platform', 'mobile');
        $user = $request->user();

        Notification::query()
            ->forPlatform($platform)
            ->when($user, function ($q) use ($user) {
                $q->forRole($user->role);
            })
            ->unread()
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca',
        ]);
    }

    /**
     * DELETE /api/notifications/{id}
     */
    public function destroy($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $notif->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi dihapus',
        ]);
    }
}