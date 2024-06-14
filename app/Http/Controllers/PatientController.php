<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Clinician;
use App\Models\User;
use App\Models\Patient;
use App\Models\ClinicianPatient;
use App\Mail\WelcomeEmail;
use App\Mail\AccountCreateMail;
use Auth, DB, Mail, Session;

class PatientController extends Controller
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
            $data[$key]['actions'] = view('appends.actions.patient', [ "row" => $row ])->render();
        }

        return $data;
    }

    public function index()
    {
        return view('admin.patient.list');
    }
 
    public function create()
    {
        $patients = Patient::all(); 
        return view('admin.patient.create');
    }

    public function save(Request $request)
    {
        $name = $request->first_name . ' ' . $request->last_name;
        $type = 4;

        $user = new User();
        $user->name = $name;
        $user->email =$request->email;
        $user->password = bcrypt($request->password);
        $user->user_type = $type;
        $user->status = $request->status;
        $user->save();

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

        Mail::to($user->email)->send(new AccountCreateMail($request->all()));

        return redirect()->route('list-patient')->with('success', 'Patient has created successfully.');
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

        if ($request->has('password') && $request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Patient Updated successfully.');
    }

    public function generateTable(Request $request) {
        $columns = array(
            0 => 'patients.id',
            1 => 'userName',
            2 => 'u.email',
            3 => 'patients.phone'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $patients = Patient::assigned()->join('users as u', 'u.id', '=', 'patients.user_id');

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $patients = $patients->where(function($q) use($search) {
                $q->where('patients.id', 'LIKE', "%{$search}%")
                    ->orWhere('userName', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('patients.phone', 'LIKE', "%{$search}%");
            });
        }

        $patients = $patients->select('patients.*', 'u.email', DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS userName"));

        $counts = $patients->count();
        $patients = $patients->orderBy($order, $dir);
        if($limit >= 0) {
            $patients = $patients->offset($start)->limit($limit);
        }

        $patients = $patients->with([ 'user' ])->get();

        $values = $this->generateTableValues($patients);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    public function activate($id) {
        User::where('id', $id)->update([ 'status' => '1' ]);
        return redirect()->back()->with('success', 'Patient Activated successfully.');
    }

    public function deactivate($id) {
        User::where('id', $id)->update([ 'status' => '0' ]);
        return redirect()->back()->with('success', 'Patient Deactivated successfully.');
    }


}
