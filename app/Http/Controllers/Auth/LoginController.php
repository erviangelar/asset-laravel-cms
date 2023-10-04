<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\MenuAccess;
use Spatie\Activitylog\Models\Activity;

use App\Libraries\Helper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Add your custom code here
        // For example, you can log the login activity or update user-related information.

        // Example: Log the login activity
        $role = UserRole::select('user_roles.role_id as role_id','roles.name as role_name')
        ->where('user_id', $user->id)
        ->leftJoin('roles', 'roles.id', '=', 'user_roles.role_id')
        ->first();
        // $currentUser = Auth::user();
        // $currentUser->session()->put('role', ['role_id' => $role->id, 'role_name' => $role->name]);
        // $customData = $currentUser->session()->get('role');
        // Display the custom data
        // dd($user->password);
        // print_r($user);
        // die();
        $menuAccess = MenuAccess::select('menus.route as route')
        ->where('role_id', $role->role_id)
        ->leftJoin('menus', 'menus.id', '=', 'menu_accesses.menu_id')
        ->where('has_access', 1)
        ->get();
        $access = array();
        foreach ($menuAccess as $repository) {
            $access[] = $repository->route;
        }

        // activity()
        //     ->causedBy($user)
        //     ->withProperties(['ip' => $request->ip()])
        //     ->log('User logged in');
        // LogActivity::log('User logged in', auth()->user(), ['ip' => request()->ip()]);
        $activity = Activity::create([
            'log_name' => 'form login', // Optional log name
            'description' => 'User logged in',
            'subject_type' => 'authentication',
            'event' => 'login',
            'causer_id' => $user->id
        ])->causedBy($user);

        if($user->first_login == 1){
            return redirect('auth/change-password');
        }

        return redirect($this->redirectTo)
        ->with(Session::put('user', $user))
        ->with(Session::put('role', ['role_id' => $role->role_id, 'role_name' => $role->role_name]))
        ->with(Session::put('access', $access))
        ->with(Session::put('auth', Helper::generate_token($user->password)));
    }
}
