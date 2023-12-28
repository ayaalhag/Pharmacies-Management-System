<?php

namespace App\Http\Controllers;
use  App\Http\Requests\PharmacyRequest;
use  App\Http\Requests\PharmacyLoginRequest;
use  App\Models\User;
use  App\Http\Controllers\BaseController;
use App\Http\Resources\PharmacyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class PharmacistController extends BaseController
{
    public function register(PharmacyRequest $request){
        $user = new User($request->all());       
        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;
            $data['token'] = $accessToken;
            $data['token_type']= 'Bearer';
            $data['user'] = new PharmacyResource($user);
            return $this->sendResponse($data, "Registration Done");
    }

    public function login(PharmacyLoginRequest $request)
     { 
        $dataRequest=$request->only('phone','password');
        if(!auth()->attempt($dataRequest)){
            return $this->sendError("this data is false");
        }
        $user = User::where('phone', $request->phone)->first();
        if(!Hash::check($request->password, $user->password)){
            return $this->sendError("this data is false");     
        }
        $accessToken = $user->createToken('authToken')->accessToken;
        $data['token'] = $accessToken;
        $data['token_type']= 'Bearer';
        $data['user'] = new PharmacyResource($user);
        return $this->sendResponse($data, "Login successfully");
    }

   /* public function logout()
    {
        Auth::user()->token()->revoke();
        return $this->sendResponse( '',"logged out succesfully"); 
     }
     */
    public function logout()
{
    $user = Auth::user();

    if ($user) {
        $user->token()->revoke();
        return $this->sendResponse('', "logged out successfully");
    } else {
        return $this->sendError('User not authenticated', [], 401);
    }
}
}
