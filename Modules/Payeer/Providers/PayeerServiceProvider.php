<?php namespace Modules\Payeer\Providers; class PayeerServiceProvider extends \Modules\Atom\Providers\BaseServiceProvider {
    public function boot( ) : void {
        $this -> registerConfig           ( ) ;
        $this -> registerGraphqlNameSpace ( ) ;
        $this -> registerMigrations       ( ) ;
        $this -> registerRelationMorphMap ( [
            'Staff' ,
        ] ) ;
    }
}