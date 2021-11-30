<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route("home.index");
        }else{
            return $this->loginISP($credentials);
        }
    }

    private function loginISP($credentials){
        $command = 'curl --insecure "https://10.2.6.7/?out=xml&func=auth&username='.$credentials['email'].'&password='.$credentials['password'].'"';
        $xml_string = exec($command);
        //$xml_string = $this->testTrueXML();
        if($this->parseXML($xml_string) !== false){
            $path = explode("@",$credentials['email']);
            $credentials['name'] = $path[0];
            event(new Registered($user = $this->create($credentials)));
            Auth::attempt($credentials);
        }
        return redirect()->back()->withErrors([
            'login' => Lang::get('auth.login'),
        ]);
    }

    private function parseXML($xml_string)
    {
        return mb_strpos($xml_string,'<auth') !== false;
    }

    private function testTrueXML()
    {
        return '<doc lang="ru" func="auth" binary="/billmgr" host="https://10.2.6.7" themename="orion" theme="orion" stylesheet="login" features="a0c6f79b4a7c43dbcd05f09e8e1800e7" notify="" branddir="https://10.2.6.7/manimg/orion/">
	<auth id="f33bc6752e3a434e231230f6" level="16">f33bc6752e3a434e231230f6</auth>
	<tparams>
		<out>xml</out>
		<username>am@amoskvin.ca</username>
		<func>auth</func>
	</tparams>
	<saved_filters></saved_filters>
</doc>';
    }

    private function testFalseXML()
    {
        return '<doc>
	<error type="auth" object="badpassword" lang="ru" code="1">
		<param name="object" type="msg">badpassword<param name="value">
				<stack>
					<action level="0" user="">auth</action>
				</stack>
				<detail>Неверное имя пользователя или пароль</detail>
				<msg>Неверное имя пользователя или пароль</msg>
			</error>
</doc>';
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


}
