<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\User;
use App\Models\User_Group;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

class User_Repo{

    public function create(array $data)
    {


        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            ]);

        return $user ;
    }
    public function createGroup(array $data , $user_id)
    {
        $group=Group::create([
            'name'=>$data['name'],
            'description'=>$data['description'],
            ]);

        $user_group=User_Group::create([
            'user_id'=>$user_id,
            'group_id'=>$group->id,
            'role'=>'owner',
            ]);
        return $user_group ;
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

    public function addTo_group($group_id,$user_id)
    {

        $user_group=User_Group::create([
            'user_id'=>$user_id,
            'group_id'=>$group_id,
            ]);
            return $user_group;
    }

    public function checkRole($group_id)
    {
        $role = User_Group::where('group_id' , $group_id)->first();
        return $role->role;
    }




}
