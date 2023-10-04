<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Institution;
use App\Models\UserRole;
use App\Models\MenuAccess;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // dd($data);
        $currentDate = Carbon::now();
        $newDate = $currentDate->addDays(7);
        $formattedDate = $newDate->format('Y-m-d');
        $institution = Institution::create([
            'name' => $data["institution_name"],
            'active_date' => date('Y-m-d'),
            'end_date' => $formattedDate,
            'status' => 'Trial'
        ]);
        // dd($institution);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_login' => 0,
            'institution_id' => $institution->id
        ]);
        $role = UserRole::create([
            'role_id' => 1,
            'user_id' => $user->id
        ]);
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $role = UserRole::select('user_roles.role_id as role_id','roles.name as role_name')
        ->where('user_id', $user->id)
        ->leftJoin('roles', 'roles.id', '=', 'user_roles.role_id')
        ->first();
        // dd($customData);
        $menuAccess = MenuAccess::select('menus.route as route')
        ->where('role_id', $role->role_id)
        ->leftJoin('menus', 'menus.id', '=', 'menu_accesses.menu_id')
        ->where('has_access', 1)
        ->get();
        $access = array();
        foreach ($menuAccess as $repository) {
            $access[] = $repository->route;
        }

        return redirect($this->redirectTo)
        ->with(Session::put('user', $user))
        ->with(Session::put('role', ['role_id' => $role->role_id, 'role_name' => $role->role_name]))
        ->with(Session::put('access', $access));
    }
}
