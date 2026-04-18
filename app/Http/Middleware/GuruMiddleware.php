<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuruMiddleware
{
    // Mapping email per tipe guru
    private $guruEmails = [
        'guru1' => 'guru1@ukk2026.com',
        'guru2' => 'guru2@ukk2026.com',
        'guru3' => 'guru3@ukk2026.com',
    ];

    public function handle($request, Closure $next, $tipe = null)
    {
        // Cek sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Cek role harus guru
        if ($user->role !== 'guru') {
            abort(403, 'Akses ditolak');
        }

        // Kalau ada parameter tipe (guru1/guru2/guru3), cek emailnya
        if ($tipe) {
            if (!isset($this->guruEmails[$tipe])) {
                abort(403, 'Tipe guru tidak valid');
            }

            if ($user->email !== $this->guruEmails[$tipe]) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini');
            }
        }

        return $next($request);
    }
}