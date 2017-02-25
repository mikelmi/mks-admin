<?php
/**
 * Author: mike
 * Date: 25.02.17
 * Time: 22:27
 */

namespace Mikelmi\MksAdmin\Contracts;


use Illuminate\Contracts\Auth\Access\Authorizable;

interface AdminableUserInterface extends Authorizable
{
    public function isSuperAdmin() : bool;
}