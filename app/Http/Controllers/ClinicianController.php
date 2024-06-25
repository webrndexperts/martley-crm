<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Clinician;
use App\Models\ClinicianPatient;
use App\Mail\WelcomeEmail;
use App\Mail\AccountCreateMail;
use App\Services\UploadService;
use Auth, DB, Mail, Session, Str, Validator;

class ClinicianController extends Controller
{
    protected $uploader;
    public function __construct() {
        $this->uploader = new UploadService();
    }

    /**
     * Function to generate form Values.
     * @param $listing Laravel Array of objects from query.
     * 
     * @return Array values.
     */
    protected function generateTableValues($listing) {
        $data = array();

        foreach ($listing as $key => $row) {
            $_r = new \stdClass();
            // $_r->style = ($row->trashed()) ? "background-color: #f5c1c1;" : "";

            $data[$key]['DT_RowAttr'] = $_r;
            $data[$key]['id'] = $row->id;
            $data[$key]['name'] = ucwords($row->userName);
            $data[$key]['email'] = $row->email;
            $data[$key]['phone'] = $row->phone;
            $data[$key]['actions'] = view('appends.actions.clinitian', [ "row" => $row ])->render();
        }

        return $data;
    }

    public function index()
    {
        return view('admin.clinician.list');
    }

    public function create()
    {
        $clinicians = Clinician::all(); 
        return view('admin.clinician.create');
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0-9\-\+\(\) ]+$/',
            'birthday' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profile = null;

        if($request->hasFile('profile_photo')) {
            $profile = $this->uploader->upload($request->file('profile_photo'), '/images/profile');
        }
        
        $name = $request->first_name . ' ' . $request->last_name;
        $type = 3;
        $password = ($request->password) ? $request->password : Str::ascii(Str::random(8));

        $user = new User();
        $user->name = $name;
        $user->profile = $profile;
        $user->email =$request->email;
        $user->password = bcrypt($password);
        $user->user_type = $type;
        $user->status = $request->status;
        $user->save();

        $clinician = new Clinician;
        $clinician->user_id = $user->id;
        $clinician->first_name = $request->first_name;
        $clinician->last_name = $request->last_name;
        $clinician->phone = $request->phone;
        $clinician->birthday = $request->birthday;
        $clinician->sex = $request->gender;
        $clinician->status = $request->status;
        $clinician->address = $request->address;
        $clinician->save();

        $mailData['user'] = $request->all();
        $mailData['password'] = $password;

        Mail::to($user->email)->send(new AccountCreateMail($mailData));

        return redirect()->route('list-clinician')->with('success', 'Clinician has been created successfully.');
    }
    public function edit($id)
    {
        $clinician = Clinician::where('id' , $id)->first(); 
        return view('admin.clinician.edit' , compact('clinician'));
    }
    public function update(Request $request, $id)
    {
        $validateData = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^[0-9\-\+\(\) ]+$/',
            'birthday' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ];

        if($request->password || $request->password_confirmation) {
            $validateData['password'] = 'required|confirmed|min:6';
        }

        $validator = Validator::make($request->all(), $validateData);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $clinician = Clinician::find($id);

        $clinician->first_name = $request->input('first_name');
        $clinician->last_name = $request->input('last_name');
        $clinician->birthday = $request->input('birthday');
        $clinician->sex = $request->input('gender');  
        $clinician->status = $request->input('status'); 
        $clinician->phone = $request->input('phone');
        $clinician->address = $request->input('address');
        $clinician->save();

        $user = User::find($clinician->user_id);
        $user->name = $clinician->first_name . ' ' . $clinician->last_name;

        if ($request->has('password') && $request->password) {
            $user->password = bcrypt($request->password);
        }

        $profile = $user->profile; $oldProfile = $user->profile;

        if($request->hasFile('profile_photo')) {
            $profile = $this->uploader->upload($request->file('profile_photo'), '/images/profile');
        }
        $user->profile = $profile;
        $user->status = $request->status;

        $user->save();

        return redirect()->back()->with('success', 'Clinician has been updated successfully.');
    }

    public function activeClinician($id)
    {
        User::where('id', $id)->update([ 'status' => '1' ]);
        return redirect()->back()->with('success', 'Clinition Activated successfully.');
    }

    public function deactiveClinician($id)
    {
        User::where('id', $id)->update([ 'status' => '0' ]);
        return redirect()->back()->with('success', 'Clinition Deactivated successfully.');
    }

    public function PatientClinician()
    {
        $user = Patient::where('user_id' , Auth::user()->id)->first();
        $clinicians = ClinicianPatient::where('patient_id' , $user->id)->get(); 
        
        return view('admin.clinician.list', compact('clinicians'));
    }

    public function generateTable(Request $request) {
        $columns = array(
            0 => 'clinicians.id',
            1 => 'userName',
            2 => 'u.email',
            3 => 'clinicians.phone'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $clinitians = Clinician::assigned()->join('users as u', 'u.id', '=', 'clinicians.user_id');

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $clinitians = $clinitians->where(function($q) use($search) {
                $q->where('clinicians.id', 'LIKE', "%{$search}%")
                    ->orWhere('userName', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('clinicians.phone', 'LIKE', "%{$search}%");
            });
        }

        $clinitians = $clinitians->select('clinicians.*', 'u.email', DB::raw("CONCAT(clinicians.first_name, ' ', clinicians.last_name) AS userName"));

        $counts = $clinitians->count();
        $clinitians = $clinitians->orderBy($order, $dir);
        if($limit >= 0) {
            $clinitians = $clinitians->offset($start)->limit($limit);
        }

        $clinitians = $clinitians->with([ 'user' ])->get();

        $values = $this->generateTableValues($clinitians);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

}