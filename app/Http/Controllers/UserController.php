<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        /**Take note of this: Your user authentication access token is generated here **/
        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['name'] =  $user->name;

        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
    }

    // public function login(Request $request)
    // {
    //     // $data = [
    //     //     'email' => $request->email,
    //     //     'password' => $request->password
    //     // ];

    //     // if (auth()->guard('api')->attempt($data)) {

    //     //     $token = auth()->user()->createToken('api')->accessToken;

    //     //     return response()->json(['token' => $token], 200);
    //     // } else {
    //     //     return response()->json(['error' => 'Unauthorised'], 401);
    //     // }

    //         $email=$request->input('email');
    //         $password=$request->input('password');
    //         $user=User::where('email',$email)->first();
    //         if($user AND Hash::check($password,$user->password)){

    //             $api_token =base64_encode(Str::random(40));
    //             return $api_token;

    //         }
    //         else{
    //             return "Can't access";
    //         }
    // }
    public function logout(Request $request){

        $token =$request->user()->token();
        $token->revoke();
        $response=["message"=>" You have successfully logout !!"];
        return response($response,200);
    }


    public function refresh()
    {
          return $this->respondWithToken(auth()->refresh());
        // $newToken = Auth::guard()->refresh();
    }


}

