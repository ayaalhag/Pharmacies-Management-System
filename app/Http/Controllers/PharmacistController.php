<?php

namespace App\Http\Controllers;
use  App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use  App\Http\Requests\PharmacyRequest;
use  App\Http\Requests\PharmacyLoginRequest;
use App\Http\Requests\ShwoProductRequest;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StoresResource;
use App\Http\Resources\ProductResource;

use  App\Models\User;
use  App\Models\Category;
use  App\Models\Product;

class PharmacistController extends BaseController
{
    public function register(PharmacyRequest $request)
    {
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
public function showCategory()
{
     $categories=category::all();
     return $this->sendResponse(CategoryResource::collection($categories), "Categories List");
}

public function showProducts(ShwoProductRequest $request)
{
    $query=Product::query();
    if($request->category_id )
    $query->where('user_id', $request->user_id)
        ->where('category_id',$request->category_id);
    if($request->commercial_name)
    $query->where('user_id', $request->user_id)
    ->where('commercial_name','LIKE' , "%". $request->commercial_name . "%");
    $products = $query->get();
    return $this->sendResponse(ProductResource::collection($products), "Proudcts List");
}
public function showStores()
{
    $stores=User::where('rule', 'store')->get();
    return $this->sendResponse(StoresResource::collection($stores), "Stores List");
}
}
