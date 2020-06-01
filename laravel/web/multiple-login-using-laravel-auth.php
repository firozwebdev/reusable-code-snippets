<?php



/***********  Multiple logging  system  where different type of users will be saved in different tables ( admin in admins, manager in managers and user in users etc...**************/

/*
Step-1 ==== configuration for app/config/auth.php ( here we will create admin)
*/

// here we want to create admin, so we have to place below code inside guards array

'admin' => [
    'driver' => 'session',
    'provider' => 'admins',
],

//  here we have to place below inside providers array

'admins' => [
    'driver' => 'eloquent',
    'model' => App\Admin::class,
],


// this is for reset password for admin, we have to place below code inside passwords array

'admins' => [
    'provider' => 'admins',
    'table' => 'password_resets',
    'expire' => 60,
    'throttle' => 60,
],



/*
Step-2 ==== configuration for app/Exceptions/Handler.php === Where a guest (without logged in) will go  will be defined here...
*/


// put the below method name unauthenticated. This method will redirect  if any user remain unauthenticated

protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $guard =\Arr::get($exception->guards(), 0);

        switch ($guard) {
            case 'admin':
                $login = 'admin.login.get'; // this route name where we want to redirect
                break;
            default:
                $login = 'login'; // this route name where we want to redirect
                break;
        }
        return redirect()->guest(route($login));
    }



/*
Step-3 ==== configuration for app/Providers/RouteServiceProvider.php === Setting url for different users after logged in 
*/

public const HOME = '/home'; // for normal users
public const ADMIN_HOME = '/admin/dashboard'; // for admin users

/*
Step-4 ==== configuration for app/Http/Middleware/RedirectIfAuthenticated.php === Where a user  will go after logged in  will be defined here...
*/



public function handle($request, Closure $next, $guard = null)
{
    switch($guard){
        case 'admin':
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::ADMIN_HOME);
            }
            break;
        default:
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
            break;
    }


    return $next($request);
}

/*
Step-5 ==== Admin model has to me authenticable as we have crate admin role

if we create manager then we have to make Manager model authenticable 
*/

use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable{


}