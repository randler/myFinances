<?php

namespace App\Policies;

use App\Models\FinanceAssets;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssetsPolicy
{

    public function update(User $user, FinanceAssets $assets)
    {
        return $user->id === $assets->user_id
            ? Response::allow()
            : Response::deny('You do not own this asset.');
    }

    public function view(User $user, FinanceAssets $assets)
    {
        return $user->id === $assets->user_id
            ? Response::allow()
            : Response::deny('You do not own this asset.');
    }

    /*public function viewAny(User $user)
    {
        //return $user->can('user.finance.view');
    }*/

}
