<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Clinician;
use App\Services\UploadService;
use Auth, Validator;

class UserController extends Controller
{
    protected $uploader;
    public function __construct() {
        $this->uploader = new UploadService();
    }

    public function profile() {
        $data['user'] = Patient::where('user_id', Auth::user()->id)->first();

        if(Auth::user()->user_type == '2') {
            $data['user'] = Auth::user();
        } else if(Auth::user()->user_type == '3') {
            $data['user'] = Clinician::where('user_id', Auth::user()->id)->first();
        }

        return view('auth.profile', $data);
    }

    public function updateProfile(Request $request) {
        $validations = []; $name = '';

        if($request->password || $request->password_confirmation) {
            $validations['password'] = 'required|confirmed|min:6';
        }

        if(Auth::user()->user_type == '2') {
            $validations['name'] = 'required';
            $name = $request->name;
        } else {
            $validations['first_name'] = 'required';
            $validations['last_name'] = 'required';

            $name = "$request->first_name $request->last_name";
        }

        $validator = Validator::make($request->all(), $validations);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $profile = Auth::user()->profile; $oldProfile = Auth::user()->profile;

        if($request->hasFile('profile_pic')) {
            $profile = $this->uploader->upload($request->file('profile_pic'), '/images/profile');
        }

        $user = User::findOrFail(Auth::user()->id);

        $user->name = $name;
        $user->profile = $profile;

        if($request->password) {
            $user->password = bcrypt($request->password);
        }

        if($user->save()) {
            if($oldProfile && $profile != $oldProfile) {
                unlink($oldProfile);
            }
            if(Auth::user()->user_type != '2') {
                $innerProfile = Patient::where('user_id', Auth::user()->id)->first();
                if(Auth::user()->user_type == '3') {
                    $innerProfile = Clinician::where('user_id', Auth::user()->id)->first();
                }

                $innerProfile->first_name = $request->first_name;
                $innerProfile->last_name = $request->last_name;
                $innerProfile->save();
            }

            return redirect()->back()->with('success', 'Profile updated successfully.');
        }

        return redirect()->back()->with('error', 'Unable to Update Profile.');
    }
}
