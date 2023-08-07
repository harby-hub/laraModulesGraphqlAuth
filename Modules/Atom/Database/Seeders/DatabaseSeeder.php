<?php namespace Modules\Atom\Database\Seeders; class DatabaseSeeder extends \Illuminate\Database\Seeder {
    public function run( ) : void {
        \Nwidart\Modules\Facades\Module::toCollection ( )
            -> sortBy        ( 'priority' )
            -> keys          ( )
            -> map           ( fn( string $Module_Name ) => 'Modules\\' . $Module_Name . '\\Database\\Seeders\\DatabaseSeeder' )
            -> filter        ( fn( string $Seeder      ) => $Seeder !== static::class and class_exists( $Seeder ) )
            -> map           ( fn( string $Seeder      ) => $this -> call( $Seeder ) )
        ;
    }
}