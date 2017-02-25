<?php
/**
 * Author: mike
 * Date: 25.02.17
 * Time: 22:05
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Mikelmi\MksAdmin\Notifications\ResetAdminPassword;

trait AdminableUser
{
    public function sendPasswordResetNotification($token)
    {
        if ($this instanceof Authorizable && $this->can('admin.access')) {
            $this->notify(new ResetAdminPassword($token));
        } else {
            $this->notify(new ResetPassword($token));
        }
    }
}