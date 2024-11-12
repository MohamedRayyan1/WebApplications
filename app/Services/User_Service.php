<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\User_Repo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User_Service{

    private $user_repo ;

    public function __construct(User_Repo $user_repo)
    {
        $this->user_repo=$user_repo;
    }



    public function user_register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'group_name' => 'string|nullable'
        ]);

        $nameOfGroup = $validator['name'];

        // if($validator['group_name']==null){

        //     $group=$this->user_repo->createGroup($nameOfGroup);
        // }
        // $group=$this->user_repo->createGroup($validator['group_name']);
        $group=$this->user_repo->createGroup($nameOfGroup);
        $group_id = $group->id;

        $user= $this->user_repo->create($validator,$group_id);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'User'=>$user,
           ]);
    }

    public function user_login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $user=$this->user_repo->login($validator);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'User' => $user,
            ]);
        }

        return response()->json([
            'message'=> 'you have not account']);
    }





}
