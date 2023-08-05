<?php namespace Modules\Payeer\GraphQL\Queries; class Staff extends \Modules\Atom\GraphQL\Queries\Query {
    public function __construct( ) {
        $this -> Repository = \Modules\Payeer\Repositories\Staff::instance( ) ;
    }
}