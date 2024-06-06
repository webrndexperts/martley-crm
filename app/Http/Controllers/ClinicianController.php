<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Clinician;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ClinicianController extends Controller
{
    public function dashboard()
    {
        // $clinicians = Clinician::all(); 
        return view('clinician.dashboard');
    }
    public function index()
    {
        $clinicians = Clinician::all(); 
        return view('admin.clinician.list', compact('clinicians'));
    }

    public function create()
    {
        $clinicians = Clinician::all(); 
        return view('admin.clinician.create');
    }
    public function save(Request $request)
    {
        // dd($request->all());
        
        $name = $request->first_name . ' ' . $request->last_name;
        
        $type = 3;

        $user = new User();
        $user->name = $name;
        $user->email =$request->email;
        $user->password = bcrypt($request->password);
        $user->user_type = $type;
        $user->save();

        // Mail::to($user->email)->send(new WelcomeEmail('add', $name));

        $clinician = new Clinician;
        $clinician->user_id = $user->id;
        $clinician->first_name = $request->first_name;
        $clinician->last_name = $request->last_name;
        $clinician->phone = $request->phone;
        $clinician->birthday = $request->birthday;
        $clinician->sex = $request->sex;
        $clinician->status = $request->status;
        $clinician->address = $request->address;
        $clinician->save();

        session()->flash('success', 'Clinician has been created successfully.');

        return redirect()->route('list-clinician');
    }
    public function edit($id)
    {
        $clinician = Clinician::where('id' , $id)->first(); 
        return view('admin.clinician.edit' , compact('clinician'));
    }
    public function update(Request $request, $id)
    {

        // dd($request->all());

        $clinician = Clinician::find($id);

        $clinician->first_name = $request->input('first_name');
        $clinician->last_name = $request->input('last_name');
        $clinician->birthday = $request->input('birthday');
        $clinician->sex = $request->input('sex');  
        $clinician->status = $request->input('status'); 
        $clinician->phone = $request->input('phone');
        $clinician->address = $request->input('address');
        $clinician->save();

        $user = User::find($clinician->user_id);
        $user->name = $clinician->first_name . ' ' . $clinician->last_name;
        $user->save();
        
        $name = $user->name;
        
        // Mail::to($user->email)->send(new WelcomeEmail('update', $name));

        if ($request->has('email')) {
            $user = User::find($clinician->user_id);
            $user->email = $request['email'];
            $user->save();
        }

        if ($request->has('password')) {
            $user = User::find($clinician->user_id);
            $user->password = bcrypt($request['password']);
            $user->save();
        }

        if ($request->has('user_type')) {
            $role = $request->input('user_type');
            $user = User::find($clinician->user_id);
            $user->user_type = $role;
            $user->save();
        }

        Session::flash('Success Message', 'Clinician has been updated successfully.');

        return redirect()->route('list-clinician', $id);
    }

    public function activeClinician($id)
        {
            $user = User::findOrFail($id);
            $user->status = 'active';
            $user->save();

            return redirect()->route('list-clinician')->with('success', 'User enabled successfully.');
        }

    public function deactiveClinician($id)
        {
            $user = User::findOrFail($id);
            $user->status = 'deactive';
            $user->save();

            return redirect()->route('list-clinician')->with('success', 'User disabled successfully.');
        }
}