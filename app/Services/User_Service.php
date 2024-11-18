<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_Group;
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
        ]);
        $user= $this->user_repo->create($validator);
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

    public function create_group(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $user_id=auth()->user()->id;
        $group=$this->user_repo->createGroup($validator ,$user_id);
        return $group ;
    }

    public function AddUser_ToGroup($user_id , $group_id)
    {
        $role=$this->user_repo->checkRole($group_id);
        // dd($role);
        if($role == 'owner'){
            $existUser=User_Group::where('user_id' , $user_id)->
            where('group_id',$group_id)->first();
            if(!$existUser){
                $userGroup_joiner= $this->user_repo->addTo_group($group_id  , $user_id);
                return $userGroup_joiner;
            }else{

                return response()->json(['message'=>'the user already exists']);
            }
        }

        return response()->json(['message'=>'you are not owner in this group']);

    }





}
