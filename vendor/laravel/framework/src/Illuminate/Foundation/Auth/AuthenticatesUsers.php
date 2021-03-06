<?php

namespace Illuminate\Foundation\Auth;

use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $split= explode("@", $request->email);

        if(!array_key_exists(1,$split))
            $request->merge(['email' => $split[0]."@upv.edu.mx"]);

        $response=false;
        if($this->guard()->attempt($this->credentials($request), $request->filled('remember'))==false){
            if(!array_key_exists(1,$split)){
                $request->merge(['email' => $split[0]]);
                $response=false;
            }
        }else
            $response=true;
        return $response;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //Insercion cuando un usuario inicia sesion en el SIITA
        $date = date("Y-m-d H:i:s"); //
        $action = 1;
        $user_id = Auth::user()->id;
        $type = DB::select("SELECT type FROM users WHERE id = $user_id");
        switch ($type[0]->type) {
          case 1:
                $message = "El administrador ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
          case 2:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
          case 3:
                $message = "El alumno ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
          case 4:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
          case 5:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
          case 6:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
          case 7:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." ha iniciado sesión";
            break;
        }

        DB::insert('INSERT INTO log (message, date, action, user_id) values (?, ?, ?, ?)', [$message, $date, $action, $user_id]);

        //$filas = DB::select("SELECT * FROM `tutorias` WHERE CURRENT_DATE()>tutorias.date_attention + INTERVAL 1 day AND tutorias.state=1");

        //$filas_asesorias = DB::select("SELECT * FROM `asesorias` WHERE CURRENT_DATE()>asesorias.date_attention + INTERVAL 1 day AND asesorias.state=1");
/*
        for ($i=0; $i < sizeof($filas); $i++) {
              $query = DB::statement("UPDATE `tutorias` SET `state`= 2 WHERE id = ?",[$filas[$i]->id]);
        }

        for ($i=0; $i < sizeof($filas_asesorias); $i++) {
              $query = DB::statement("UPDATE `asesorias` SET `state`= 2 WHERE id = ?",[$filas_asesorias[$i]->id]);
        }
*/
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Usuario o Contraseña Incorrectos.'],
        ]);
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
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //Insercion cuando un usuario cierra sesion en el SIITA
        $date = date("Y-m-d H:i:s"); //
        $action = 2;
        $user_id = Auth::user()->id;
        $type = DB::select("SELECT type FROM users WHERE id = $user_id");
        switch ($type[0]->type) {
          case 1:
                $message = "El administrador ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
          case 2:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
          case 3:
                $message = "El alumno ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
          case 4:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
          case 5:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
          case 6:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
          case 7:
                $message = Auth::user()->title." ".Auth::user()->first_name." ".Auth::user()->last_name." ".Auth::user()->second_last_name." cerró sesión";
            break;
        }

        DB::insert('INSERT INTO log (message, date, action, user_id) values (?, ?, ?, ?)', [$message, $date, $action, $user_id]);

        $this->guard()->logout();

        $request->session()->invalidate();
        //return $this->loggedOut($request) ?: redirect('/');
        return $this->loggedOut($request) ?: redirect(\URL::previous());
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
