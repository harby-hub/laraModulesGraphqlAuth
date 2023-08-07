<?php namespace Modules\Authentication\Providers;

use Laravel\Passport\Passport;
use Laravel\Passport\Http\Middleware\CheckScopes;
use Laravel\Passport\Http\Middleware\CheckForAnyScope;

use Illuminate\Support\Facades\Config;

use Modules\Authentication\validators\Authentication as validator;

use Modules\Authentication\Models\Passport\PersonalAccessToken;
use Modules\Authentication\Models\Passport\Client;
use Modules\Authentication\Models\Passport\AuthCode;
use Modules\Authentication\Models\Passport\RefreshToken;

use Modules\Authentication\Http\Middleware\Authenticate;
use Modules\Authentication\Http\Middleware\RedirectIfAuthenticated;

use Modules\Atom\Providers\BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    /**
     * Boot the application events.
     */
    public function boot ( ) : void {
        $this -> registerTranslations    ( );
        $this -> registerConfig          ( );
        $this -> registerViews           ( );
        $this -> registerAuthConfig      ( );
        $this -> registerMigrations      ( );
        $this -> registerGraphqlNameSpace( );
        $this -> registerAliasMiddleware ( [
            'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth :: class ,
            'can'              => \Illuminate\Auth\Middleware\Authorize                 :: class ,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword           :: class ,
            'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified     :: class ,
            'Authenticate'     => Authenticate                                          :: class ,
            'guest'            => RedirectIfAuthenticated                               :: class ,
            'scopes'           => CheckScopes                                           :: class ,
            'scope'            => CheckForAnyScope                                      :: class ,
        ] ) ;
        $this -> registerValidatorExtend ( [
            'EmailProvidersExists' => validator :: class ,
            'EmailProvidersUnique' => validator :: class ,
        ] ) ;
        $this -> registerLighthouseSchema ( [
            new \GraphQL\Type\Definition\PhpEnumType( \Modules\Authentication\Enums\AuthenticationProviders::class )
        ] ) ;
    }

    /**
     * Register config.
     */
    public function registerConfig( ) : void {
        parent::registerConfig( ) ;
        Config::set( 'auth.defaults.guard'  , Config::get( $this -> getModuleNamelower( ) . '.Sub_defaults.guard'  ) );
        collect( Config::get( $this -> getModuleNamelower( ) . '.Sub_guards'    ) ) -> map( fn( array $value , String | int $key ) => Config::set( 'auth.guards.'    . $key , $value ) );
        collect( Config::get( $this -> getModuleNamelower( ) . '.Sub_providers' ) ) -> map( fn( array $value , String | int $key ) => Config::set( 'auth.providers.' . $key , $value ) );
    }

    /**
     * Register Auth.
     */
    public function registerAuthConfig( ) : void {
        $this -> registerPassport ( ) ;
    }

    public function registerPassport( ) : void {
        Passport::tokensExpireIn               ( now( ) -> addDays     ( 15 ) ) ;
        Passport::refreshTokensExpireIn        ( now( ) -> addDays     ( 30 ) ) ;
        Passport::personalAccessTokensExpireIn ( now( ) -> addMonths   ( 6  ) ) ;
        Passport::useTokenModel                ( PersonalAccessToken :: class ) ;
        Passport::useClientModel               ( Client              :: class ) ;
        Passport::useAuthCodeModel             ( AuthCode            :: class ) ;
        Passport::useRefreshTokenModel         ( RefreshToken        :: class ) ;
        Passport::tokensCan                    ( Config::get( $this -> getModuleNamelower( ) . '.tokensCan' ) ) ;
    }

}