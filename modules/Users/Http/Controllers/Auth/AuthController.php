<?php namespace KodiCMS\Users\Http\Controllers\Auth;

use KodiCMS\CMS\Http\Controllers\System\FrontendController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AuthController extends FrontendController {

	/**
	 * @var string
	 */
	public $templatePreffix = 'users::';

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;
	
	protected $redirectPath = '/';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param Guard $auth
	 * @param Registrar $registrar
	 */
	public function boot(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->redirectPath = $this->session->get('nextUrl', \CMS::backendPath());

		$this->beforeFilter('@checkPermissions', ['except' => 'getLogout']);
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		$this->setContent('auth.login');
	}

	public function checkPermissions(Route $router, Request $request)
	{
		if ($this->auth->check() AND $this->currentUser->hasRole('login')) {
			return redirect($this->redirectPath);
		}
	}
}