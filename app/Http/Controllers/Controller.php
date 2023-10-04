<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\User;

use App\Libraries\Helper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $global_config;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (Session::has('user')) {
                // GET USER DATA
                $user_session = Session::get('user');
                $user_data = User::find($user_session->id);

                // if password has been changed, then force user to re-login
				$auth = Helper::generate_token($user_data->password);
				$token_db = Helper::validate_token($auth);
                $token_session = Helper::validate_token(Session::get('auth'));
				if ($token_db != $token_session) {
					// PASSWORD HAS BEEN CHANGED, THEN FORCE USER TO RE-LOGIN
					Session::flush();
                    return redirect()->route('login')->with('info', lang('Your password has been changed, please re-login'));
                }

                if($user_data->status == 0 || $user_data->status == 2){
                    // FORCE LOGOUT FROM ALL SESSIONS
					Session::flush();
                    return redirect()->route('login')->with('info', lang('Your session has been logged out, please re-login'));
                }
			}

            // get global config data
            $global_config = new \stdClass();
            $global_config->app_name = env('APP_NAME');
            $global_config->app_version = env('APP_VERSION');
            $global_config->app_url_site = env('APP_URL_SITE');
            $global_config->app_favicon_type = env('APP_FAVICON_TYPE');
            $global_config->app_favicon = env('APP_FAVICON');
            $global_config->app_logo = env('APP_LOGO');
            $global_config->app_logo_image = env('APP_LOGO_IMAGE');
            $global_config->powered = env('POWERED');
            $global_config->powered_url = env('POWERED_URL');

            $global_config->meta_title = env('APP_NAME');
            $global_config->meta_description = env('META_DESCRIPTION');
            $global_config->meta_author = env('META_AUTHOR');
            $global_config->meta_keywords = '';

            // share variable to all Views
            View::share('global_config', $global_config);
            // set this variable with translation data
            $this->global_config = $global_config;

            // set app logo
            if (empty($global_config->app_logo_image)) {
                $app_logo = '<i class="fa fa-' . $global_config->app_logo . '"></i>';
            } else {
                $app_logo = '<img src=" ' . asset($global_config->app_logo_image) . '" style="max-width:40px" />';
            }

            // share variable to all Views
            View::share('app_logo', $app_logo);

            // set this variable with translation data
            $this->app_logo = $app_logo;

            return $next($request);
        });
    }
}
