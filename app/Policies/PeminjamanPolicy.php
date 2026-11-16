<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeminjamanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya boleh melihat peminjaman miliknya sendiri (mencegah IDOR).
        // Kepemilikan ditentukan lewat anggota yang emailnya sama dengan akun.
        $peminjaman->loadMissing('anggota');

        return $peminjaman->anggota !== null
            && $peminjaman->anggota->email === $user->email;
    }
}