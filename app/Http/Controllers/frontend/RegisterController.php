<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function index()
    {
        return view('frontend.register');
    }

    public function login()
    {
        return view('frontend.login');
    }

    public function saveRegister(Request $request)
    {
        $userObject = new User();

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|string|unique:users,email,' . $request->id . ',id,deleted_at,NULL',
            'phone' => 'required|string|unique:users,phone,' . $request->id . ',id,deleted_at,NULL',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ], [
            'firstname.required' => 'First Name is required',
            'lastname.required' => 'Last Name is required',
        ]);

        if (!empty($request->file('profile_img'))) {
            $destinationPath = 'uploads/profile';
            $profilePic = time() . '_' . $request->file('profile_img')->getClientOriginalName();

            $request->file('profile_img')->move(public_path($destinationPath), $profilePic);

            $filePath = $destinationPath . '/' . $profilePic;
        }

        $profileImg = json_encode($filePath);

        if ($validator->passes()) {
            $userObject->firstname = $request->firstname;
            $userObject->lastname = $request->lastname;
            $userObject->email = $request->email;
            $userObject->phone = $request->phone;
            $userObject->profile_img = $profileImg;
            $userObject->password = Hash::make($request->password);
            $userObject->save();
            $lastInsertedId = $userObject->id;

            $check = User::find($lastInsertedId);

            if ($check) {
                session()->put('admin', $check);
            }

            $response['msg'] = 'Registration has been completed successfully.';
            $response['success'] = 1;
            $response['redirect_url'] = url('/login');
            return response()->json($response);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    function verifyLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::guard('web')->attempt($credentials)) {
                $user = Auth::guard('web')->user();

                session()->put('users', $user);
                $response['msg'] = 'Login successful.';
                $response['success'] = 1;
                $response['redirect_url'] = url('/dashboard');

                return response()->json($response);
            } else {
                $response['cred_error'] = 'Invalid credentials!';
                return response()->json($response);
            }
        }

        return response()->json(['error' => $validator->errors()]);
    }
}
