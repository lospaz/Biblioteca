<?php
namespace Modules\Library\Traits;

use Illuminate\Support\Facades\Auth;

trait BookTrait {

    public static function permission(){
        $user = Auth::user();
        return [
            'create' => $user->hasPermissionTo('library.create'),
            'edit' => $user->hasPermissionTo('library.edit'),
            'delete' => $user->hasPermissionTo('library.delete'),
        ];
    }

}