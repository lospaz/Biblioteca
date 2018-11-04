<?php
namespace Modules\Library\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LibraryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user){
        return true;
    }

    public function create(User $user){
        return $user->hasPermissionTo('library.create');
    }

    public function update(User $user){
        return $user->hasPermissionTo('library.edit');
    }

    public function delete(User $user){
        return $user->hasPermissionTo('library.delete');
    }
}
