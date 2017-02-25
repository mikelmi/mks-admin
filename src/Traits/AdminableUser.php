<?php
/**
 * Author: mike
 * Date: 25.02.17
 * Time: 22:05
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Auth\Notifications\ResetPassword;
use Mikelmi\MksAdmin\Notifications\ResetAdminPassword;

trait AdminableUser
{
    public function isAdmin()
    {
        return false;
    }

    public function sendPasswordResetNotification($token)
    {
        if (!$this->isAdmin()) {
            $this->notify(new ResetPassword($token));
        } else {
            $this->notify(new ResetAdminPassword($token));
        }
    }
}