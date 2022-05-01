<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function register(Request $request) {
        $validator = $request->validate([
            'nama_depan'=>'required|string',
            'nama_belakang'=>'required|string',
            'email' => 'required|string|unique:mentors,email',
            'password'=> 'required|string'
        ]);



        // 'nama_depan'=>$user->nama_depan,
        // 'nama_belakang'=>$user->nama_belakang,
        // 'email'=>$user->email,
        // 'password'=>$user->password,
        // 'alamat'=>$user->alamat,
        // 'pekerjaan'=>$user->pekerjaan,
        // 'id_bidang'=>$user->id_bidang,
        // 'latar_belakang'=>$user->latar_belakang,
        // 'tarif'=>$user->tarif,
        // 'pendidikan'=>$user->pendidikan,
        // 'token'=>$token


        $user = User::create([
            'email' => $validator['email'],
            'name' => $validator['name'],
            'password' => bcrypt($validator['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        
        $data =[
            'email'=>$user->email,
            'name'=>$user->name,
            'password'=>$user->password,
            'token' => $token
        ];

        $response = [
            'success' => true,
            'data' => $data

        ]; 

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'crypto/bcrypt: hashedPassword is not the hash of the given password',
                'success' => 'error',
                'data' => null
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;


        $data =[
            'email'=>$user->email,
            'name'=>$user->name,
            'password'=>$user->password,
            'token' => $token
        ];

        $response = [
            'success' => true,
            'data' => $data,
            
        ]; 
        

        return response($response, 201);
    }
    public function logout(Request $req){
        Auth::logout();

    $req->session()->invalidate();

    $req->session()->regenerateToken();


    }
}
