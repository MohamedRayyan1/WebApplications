<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\User_Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{


    private $user_serve ;

    public function __construct(User_Service $user_serve)
    {
        $this->user_serve=$user_serve;
    }

    public function register(Request $request)
    {
    return $this->user_serve->user_register($request);
    }

    public function login(Request $request)
    {
        return $this->user_serve->user_login($request);
    }

    public function CreateGroup(Request $request)
    {
        return $this->user_serve->create_group($request);
    }

    public function AddUser_Group($group_id , $user_id)
    {
        return $this->user_serve->AddUser_ToGroup($group_id , $user_id);
    }



}
