<?php namespace Modules\Delivering\Providers; class DeliveringServiceProvider extends \Modules\Atom\Providers\BaseServiceProvider {
    public function boot( ) : void {
        $this -> registerConfig           ( ) ;
        $this -> registerMigrations       ( ) ;
        $this -> registerGraphqlNameSpace ( ) ;
        $this -> registerMigrations       ( ) ;
        $this -> registerRelationMorphMap ( [
            'Delegate' ,
        ] );
    }
}