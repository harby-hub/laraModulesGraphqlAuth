<?php namespace Modules\Payeer\Models; class Staff extends \Modules\Atom\Models\BaseUser {
    public string $AuthenticationModel = \Modules\Authentication\Models\Staff::class ;
}