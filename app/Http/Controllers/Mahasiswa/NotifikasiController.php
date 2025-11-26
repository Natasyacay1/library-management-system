<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = NotifikasiController::forUser($user->id)
                                ->recent()
                                ->paginate(15);
        
        return view('student.notifications.index', compact('notifications'));
    }

    public function show(NotifikasiController $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('student.notifications.show', compact('notification'));
    }

    public function markAsRead(NotifikasiController $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->back()
            ->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        NotifikasiController::forUser($user->id)
                ->unread()
                ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->back()
            ->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }

    public function destroy(NotifikasiController $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return redirect()->route('student.notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearAll()
    {
        $user = Auth::user();
        NotifikasiController::forUser($user->id)->delete();

        return redirect()->route('student.notifications.index')
            ->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}