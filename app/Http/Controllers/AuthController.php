<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ThrottlesLogins;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ThrottlesLogins;
    
    public function authenticate(Request $request) : JsonResponse
    {
        $this->validate($request,
                        [
                            'email'    => 'required',
                            'password' => 'required',
                        ]);
        
        /**
         * @var User $user
         */
        $user = UserRepository::findByEmail($request['email']);
        
        if($user === null || !$user->active)
            return new JsonResponse(['message' => 'Forbidden'], 403);
        
        $this->createThrottlingConfig($request,
                                      config('settings.max_login_attempts'),
                                      config('settings.login_throttling_time_minutes'));
        
        if($this->tooManyAttempts())
            return new JsonResponse(sprintf('Too many failed attempts, login available in %s seconds', $this->availableIn()), 429);
        
        if(!$user->tryAuthenticate($request['password']))
        {
            $this->hitThrottleCounter();
            
            return new JsonResponse(['message' => 'Forbidden'], 403);
        }
        
        return new JsonResponse($user);
    }
}