<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Ubah isi profil: hanya pemilik akun sendiri.
     * Admin tidak boleh mengedit profil orang lain.
     */
    public function update(User $actor, User $target): bool
    {
        return $actor->id === $target->id;
    }

    /**
     * Nonaktifkan/aktifkan akun: hanya admin,
     * dan akun admin tidak boleh dinonaktifkan.
     */
    public function toggleStatus(User $actor, User $target): bool
    {
        return $actor->role === 'admin'
            && $target->role !== 'admin';
    }
}
