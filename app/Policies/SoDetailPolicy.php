<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class SoDetailPolicy extends BasePolicy
{
    public function table(User $user): Response
    {
        return Response::allow();
    }

    public function ambil(User $user): Response
    {
        return Response::allow();
    }

    public function lembar(User $user): Response
    {
        return Response::allow();
    }

    public function beritaacara(User $user): Response
    {
        return Response::allow();
    }

    public function sertifikat(User $user): Response
    {
        return Response::allow();
    }
}
