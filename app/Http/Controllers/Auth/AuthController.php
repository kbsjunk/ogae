<?php

namespace Ogae\Http\Controllers\Auth;

use Ogae\User;
use Validator;
use Ogae\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Auth;
use Socialite;
use Illuminate\Http\Request;

use Facebook\Authentication\AccessToken;

class AuthController extends Controller
{
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

  use AuthenticatesAndRegistersUsers, ThrottlesLogins;

  /**
  * Where to redirect users after login / registration.
  *
  * @var string
  */
  protected $redirectTo = '/';

  /**
  * Create a new authentication controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);
  }

  /**
  * Create a new user instance after a valid registration.
  *
  * @param  array  $data
  * @return User
  */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
    ]);
  }

  /**
  * Redirect the user to the GitHub authentication page.
  *
  * @return Response
  */
  public function redirect()
  {
    return Socialite::driver('facebook')->redirect();
  }

  /**
  * Obtain the user information from GitHub.
  *
  * @return Response
  */
  public function callback(Request $request)
  {
    $fbUser = Socialite::driver('facebook')->user();

    if (!$user = User::where('email', $fbUser->email)->orWhere('facebook_id', $fbUser->id)->first()) {
      $user = new User;
    }

    if (!$user->name) $user->name = $fbUser->name;
    if (!$user->email) $user->email = $fbUser->email;

    $user->facebook_name = $fbUser->name;
    $user->facebook_id = $fbUser->id;
    $user->facebook_avatar = $fbUser->avatar_original;
    $token = $this->exchangeAccessToken($fbUser->token);

    $user->facebook_token = $token->getValue();
    $user->facebook_token_expires_at = $token->getExpiresAt();

    $user->save();

    if (Auth::guard($this->getGuard())->login($user, true)) {
      return $this->sendLoginResponse($request);
    }

    return $this->sendFailedLoginResponse($request);
  }

  protected function exchangeAccessToken($shortAccessToken)
  {
    $fb = app('facebook');
    $oAuth2Client = $fb->getOAuth2Client();

    $tokenMetadata = $oAuth2Client->debugToken($shortAccessToken);
    $shortAccessToken = new AccessToken($shortAccessToken, $tokenMetadata->getExpiresAt()->getTimestamp());

    if (! $shortAccessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($shortAccessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
      }

      return $accessToken->getValue();
    }

    return $shortAccessToken;
  }

  public function authenticated(Request $request, User $user) {
    $user->logged_in_at = $user->freshTimestamp();
    $user->save();

    return redirect()->intended($this->redirectPath());
  }
}
