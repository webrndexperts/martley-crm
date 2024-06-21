<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Clinician;
use App\Models\User;
use App\Models\Patient;
use App\Models\ClinicianPatient;
use App\Mail\WelcomeEmail;
use App\Mail\AccountCreateMail;
use App\Mail\AssignedPatient;
use App\Mail\AssignedClinitian;
use App\Services\UploadService;
use Auth, DB, Mail, Session, Str, Validator;

class PatientController extends Controller
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
            $data[$key]['actions'] = view('appends.actions.patient.index', [ "row" => $row ])->render();
        }

        return $data;
    }

    /**
     * Function to generate form Values.
     * @param $listing Laravel Array of objects from query.
     * 
     * @return Array values.
     */
    protected function generateAssingTableValues($listing) {
        $data = array();

        foreach ($listing as $key => $row) {
            $_r = new \stdClass();
            // $_r->style = ($row->trashed()) ? "background-color: #f5c1c1;" : "";

            $data[$key]['DT_RowAttr'] = $_r;
            $data[$key]['id'] = $row->id;
            $data[$key]['patient'] = ucwords($row->patientName);
            $data[$key]['clinitian'] = ucwords($row->clinicName);
            $data[$key]['actions'] = view('appends.actions.patient.assign', [ "row" => $row ])->render();
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profile = Auth::user()->profile; $oldProfile = Auth::user()->profile;

        if($request->hasFile('profile_photo')) {
            $profile = $this->uploader->upload($request->file('profile_photo'), '/images/profile');
        }

        $name = $request->first_name . ' ' . $request->last_name;
        $type = 4;
        $password = ($request->password) ? $request->password : Str::random(8);

        $user = new User();
        $user->name = $name;
        $user->profile = $profile;
        $user->email =$request->email;
        $user->password = bcrypt($password);
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

        $profile = Auth::user()->profile; $oldProfile = Auth::user()->profile;

        if($request->hasFile('profile_photo')) {
            $profile = $this->uploader->upload($request->file('profile_photo'), '/images/profile');
        }
        $user->profile = $profile;

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

    public function assignPatient() {
        return view('admin.patient.assign.index');
    }

    public function assignPatientTable(Request $request) {
        $columns = array(
            0 => 'clinician_patients.id',
            1 => 'patientName',
            2 => 'clinicName',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $patients = ClinicianPatient::join('patients as p', 'p.id', '=', 'clinician_patients.patient_id')
            ->join('clinicians as c', 'c.id', '=', 'clinician_patients.clinician_id');

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $patients = $patients->where(function($q) use($search) {
                $q->where('clinician_patients.id', 'LIKE', "%{$search}%")
                    ->orWhere('patientName', 'LIKE', "%{$search}%")
                    ->orWhere('clinicName', 'LIKE', "%{$search}%");
            });
        }

        $patients = $patients->select('clinician_patients.*', DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS patientName"), DB::raw("CONCAT(c.first_name, ' ', c.last_name) AS clinicName"));

        $counts = $patients->count();
        $patients = $patients->orderBy($order, $dir);
        if($limit >= 0) {
            $patients = $patients->offset($start)->limit($limit);
        }

        $patients = $patients->get();

        $values = $this->generateAssingTableValues($patients);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    public function addAssignPatient() {
        $data['clinicians'] = Clinician::all();

        return view('admin.patient.assign.add', $data);
    }

    public function getAssignmentPatient($id) {
        $assigned = ClinicianPatient::where('clinician_id', $id)->pluck('patient_id')->toArray();

        $patients = Patient::Query();
        if($assigned && count($assigned) > 0) { $patients = $patients->whereNotIn('id', $assigned); }
        $patients = $patients->get();

        return $patients;
    }

    public function submitAssignPatient(Request $request) {
        $clinitian = Clinician::where('id', $request->clinician_id)->first();
        $patients = '';

        $mailValues['clinitian'] = $clinitian;

        foreach ($request->patient_id as $key => $value) {
            $patient = Patient::where('id', $value)->first();
            $mailValues['patient'] = $patient;
            $name = ucfirst("$patient->first_name $patient->last_name");

            $record = ClinicianPatient::updateOrCreate([
                'patient_id' => $value,
                'clinician_id' => $request->clinician_id
            ], [
                'updated_at' => now()
            ]);

            if ($record->wasRecentlyCreated) {
                $patients = ($patients) ? "$patients, $name" : $name;
                Mail::to($patient->user->email)->send(new AssignedPatient($mailValues));
            }
        }

        if($patients) {
            $mailValues['patientNames'] = $patients;
            Mail::to($clinitian->user->email)->send(new AssignedClinitian($mailValues));
        }

        return redirect()->route('patient.assignment.get')->with('success', 'Patients are assigned successfully.');
    }

    public function editAssignPatient($id) {
        $value = ClinicianPatient::findOrFail(base64_decode($id));
        $data['clinicians'] = Clinician::all();
        $data['value'] = $value;

        $assigned = ClinicianPatient::where('clinician_id', $value->clinician_id)->pluck('patient_id')->toArray();
        $index = array_search($value->patient_id, $assigned);

        if($index !== false) {
            unset($assigned[$index]);
        }

        $assigned = array_values($assigned);

        $patients = Patient::Query();
        if($assigned && count($assigned) > 0) { $patients = $patients->whereNotIn('id', $assigned); }
        $data['patients'] = $patients->get();

        return view('admin.patient.assign.edit', $data);
    }

    public function updateAssignPatient(Request $request) {
        $assigned = ClinicianPatient::findOrFail($request->id);
        $clinitian = Clinician::where('id', $request->clinician_id)->first();

        $patient = Patient::where('id', $request->patient_id)->first();
        $mailValues['patient'] = $patient;
        $mailValues['clinitian'] = $clinitian;
        $patientName = ucfirst("$patient->first_name $patient->last_name");

        $assigned->patient_id = $request->patient_id;
        $assigned->clinician_id = $request->clinician_id;

        if($assigned->save()) {
            if ($request->old_patient != $request->patient_id) {
                Mail::to($patient->user->email)->send(new AssignedPatient($mailValues));
            }

            if($request->old_clinitian != $request->clinician_id) {
                $mailValues['patientNames'] = $patientName;
                Mail::to($clinitian->user->email)->send(new AssignedClinitian($mailValues));
            }

            return redirect()->back()->with('success', 'Record updated successfully.');
        }

        return redirect()->back()->with('error', 'Unable to update record.');
    }

    public function deleteAssignPatient($id) {
        ClinicianPatient::where('id', base64_decode($id))->delete();

        return redirect()->route('patient.assignment.get')->with('success', 'Patient Assesment deleted successfully.');
    }
}
