<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Clinician;
use App\Models\ClinicianPatient;
use App\Mail\WelcomeEmail;
use App\Mail\AccountCreateMail;
use Auth, DB, Mail, Session;

class ClinicianController extends Controller
{
    
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
        $name = $request->first_name . ' ' . $request->last_name;
        $type = 3;

        $user = new User();
        $user->name = $name;
        $user->email =$request->email;
        $user->password = bcrypt($request->password);
        $user->user_type = $type;
        $user->status = $request->status;
        $user->save();

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

        Mail::to($user->email)->send(new AccountCreateMail($request->all()));

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

        if ($request->has('password') && $request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        Session::flash('Success Message', 'Clinician has been updated successfully.');

        return redirect()->route('list-clinician', $id);
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

        $clinitians = Clinician::join('users as u', 'u.id', '=', 'clinicians.user_id');

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