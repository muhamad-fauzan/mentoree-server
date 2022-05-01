<?php

namespace App\Http\Controllers;

use App\Models\mentor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class mentorController extends Controller
{
    public function register(Request $request) {
        $validator = $request->validate([
            'nama_depan'=>'required|string',
            'nama_belakang'=>'required|string',
            'email' => 'required|string|unique:mentors,email',
            'password'=> 'required|string',
            'alamat'=>'required|string',
            'pekerjaan'=>'required|string',
            'id_bidang'=>'required',
            'latar_belakang'=>'required|string',
            'tarif'=>'required',
            'pendidikan'=>'required|string'
        ]);

        $user = mentor::create([
            'nama_depan' => $validator['nama_depan'],
            'nama_belakang'=> $validator['nama_belakang'],
            'email'=> $validator['email'],
            'password'=> bcrypt($validator['password']),
            'alamat'=> $validator['alamat'],
            'pekerjaan'=> $validator['pekerjaan'],
            'id_bidang'=> $validator['id_bidang'],
            'latar_belakang'=> $validator['latar_belakang'],
            'tarif'=> $validator['tarif'],
            'pendidikan'=> $validator['pendidikan']
            
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;

        $data = [
            'nama_depan'=>$user->nama_depan,
            'nama_belakang'=>$user->nama_belakang,
            'email'=>$user->email,
            'password'=>$user->password,
            'alamat'=>$user->alamat,
            'pekerjaan'=>$user->pekerjaan,
            'id_bidang'=>$user->id_bidang,
            'latar_belakang'=>$user->latar_belakang,
            'tarif'=>$user->tarif,
            'pendidikan'=>$user->pendidikan,
            'token'=>$token
        ];
        
        
        
        $response = [
            'success' => true,
            'data' => $data
            
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $validator = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = mentor::where('email', $validator['email'])->first();

        // Check password
        if(!$user || !Hash::check($validator['password'], $user->password)) {
            return response([
                'message' => 'crypto/bcrypt: hashedPassword is not the hash of the given password',
                'success' => 'error',
                'data' => null
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $data = [
            'nama_depan'=>$user->nama_depan,
            'nama_belakang'=>$user->nama_belakang,
            'email'=>$user->email,
            'password'=>$user->password,
            'alamat'=>$user->alamat,
            'pekerjaan'=>$user->pekerjaan,
            'id_bidang'=>$user->id_bidang,
            'latar_belakang'=>$user->latar_belakang,
            'tarif'=>$user->tarif,
            'pendidikan'=>$user->pendidikan,
            'token'=>$token
        ];

        $response = [
            'success' => true,
            'data' => $data
            
        ];

        return response($response, 201);
    }


    public function detail($id) {
       $user =   mentor::where('id', $id)->get();

       $data = [
        'nama_depan'=>$user->nama_depan,
        'nama_belakang'=>$user->nama_belakang,
        'email'=>$user->email,
        'password'=>$user->password,
        'alamat'=>$user->alamat,
        'pekerjaan'=>$user->pekerjaan,
        'id_bidang'=>$user->id_bidang,
        'latarBelakang'=>$user->latar_belakang,
        'tarif'=>$user->tarif,
        'pendidikan'=>$user->pendidikan
    ];
        $response = [
            'data' => $data,
            'success' => true
        ];
        return response($response,200);
    }
    public function getall(){
        $user = mentor::all();

        $data = [
            'nama_depan'=>$user->nama_depan,
            'nama_belakang'=>$user->nama_belakang,
            'email'=>$user->email,
            'password'=>$user->password,
            'alamat'=>$user->alamat,
            'pekerjaan'=>$user->pekerjaan,
            'id_bidang'=>$user->id_bidang,
            'latarBelakang'=>$user->latar_belakang,
            'tarif'=>$user->tarif,
            'pendidikan'=>$user->pendidikan
        ];
        $response = [
            'data' => $data,
            'success' => true
        ];
        return response($response,200);
    }
    public function explore($kategoriid){
        $user = mentor::where('id_bidang',$kategoriid)->get();

        $data = [
            'nama_depan'=>$user->nama_depan,
            'nama_belakang'=>$user->nama_belakang,
            'email'=>$user->email,
            'password'=>$user->password,
            'alamat'=>$user->alamat,
            'pekerjaan'=>$user->pekerjaan,
            'id_bidang'=>$user->id_bidang,
            'latarBelakang'=>$user->latar_belakang,
            'tarif'=>$user->tarif,
            'pendidikan'=>$user->pendidikan
        ];
        $response = [
            'success' => true,
            'data' => $data
        ];
        return response($response,200);
    }
    public function logout(Request $req){
        Auth::logout();

    $req->session()->invalidate();

    $req->session()->regenerateToken();


    }
}
