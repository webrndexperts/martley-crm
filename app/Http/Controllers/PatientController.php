<?php

namespace App\Http\Controllers;
use App\Models\Clinician;
use App\Models\User;
use App\Models\Patient;
use App\Models\ClinicianPatient;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Http\Request;
class PatientController extends Controller
{
    public function index()
    {
        if(Auth::user()->user_type == 2){

            $patients = Patient::all(); 

        } else{

            $user = Clinician::where('user_id' , Auth::user()->id)->first();
            $patients = ClinicianPatient::where('clinician_id' , $user->id)->get(); 
            
        }
        return view('admin.patient.list' , compact('patients'));
    }
 
    public function create()
    {
        $patients = Patient::all(); 
        return view('admin.patient.create');
    }
    public function save(Request $request)
    {

        // dd($request->all());
        $name = $request->first_name . ' ' . $request->last_name;
        
        $type = 4;

        $user = new User();
        $user->name = $name;
        $user->email =$request->email;
        $user->password = bcrypt($request->password);
        $user->user_type = $type;
        $user->save();

        // Mail::to($user->email)->send(new WelcomeEmail('add', $name));

        $patient = new Patient;
        $patient->user_id = $user->id;
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->phone = $request->phone;
        $patient->birthday = $request->birthday;
        $patient->sex = $request->sex;
        $patient->status = $request->status;
        $patient->address = $request->address;
        $patient->save();

        session()->flash('success', 'patient has been created successfully.');

        return redirect()->route('list-patient')->with('success', 'Patient Save successfully.');
    }
    public function edit($id)
    {
        $patient = Patient::where('id' , $id)->first(); 
        return view('admin.patient.edit' , compact('patient') );
    }
    public function update(Request $request, $id)
    {

        $patient = Patient::find($id);

        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->birthday = $request->input('birthday');
        $patient->sex = $request->input('sex');  
        $patient->status = $request->input('status'); 
        $patient->phone = $request->input('phone');
        $patient->address = $request->input('address');
        $patient->save();

        $user = User::find($patient->user_id);
        $user->name = $patient->first_name . ' ' . $patient->last_name;
        $user->save();

        $name = $user->name;
        
        // Mail::to($user->email)->send(new WelcomeEmail('update', $name));

        if ($request->has('email')) {
            $user = User::find($patient->user_id);
            $user->email = $request['email'];
            $user->save();
        }

        // if ($request->has('password')) {
        //     $user = User::find($patient->user_id);
        //     $user->password = bcrypt($request['password']);
        //     $user->save();
        // }

        if ($request->has('user_type')) {
            $role = $request->input('user_type');
            $user = User::find($patient->user_id);
            $user->user_type = $role;
            $user->save();
        }

        Session::flash('Success Message', 'patient has been updated successfully.');

        return redirect()->route('list-patient')->with('success', 'Patient Updated successfully.');
    } 

}
