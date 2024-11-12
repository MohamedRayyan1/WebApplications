<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

class User_Repo{

    public function create(array $data,$group_id)
    {

      
        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'group_id'=>$group_id,
            ]);

        return $user ;
    }
    public function createGroup($nameOfGroup)
    {

        $group=Group::create([
            'name'=>$nameOfGroup,
            ]);

        return $group ;
    }

    public function login(array $request)
    {
        $user=User::where('email', $request['email'])->first();
        return $user ;
    }

    public function findBy_Id($user_id)
    {
        $user=User::where('id' , $user_id)->find();
        return $user ;
    }





}
