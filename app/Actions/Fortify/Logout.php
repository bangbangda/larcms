<?php
namespace App\Actions\Fortify;

use Illuminate\Http\JsonResponse;

class Logout implements \Laravel\Fortify\Contracts\LogoutResponse
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect('/login');
    }
}
