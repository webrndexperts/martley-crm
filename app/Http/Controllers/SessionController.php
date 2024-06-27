<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadService;
use App\Models\CrmSession;
use App\Models\Patient;
use App\Models\Clinician;
use App\Models\CrmMeeting;
use App\Http\Controllers\PatientController;
use View, Auth, Session, Mail, Validator;
use Carbon\Carbon;

class SessionController extends Controller
{
    protected $uploader;
    protected $patientController;

    public function __construct() {
        $this->uploader = new UploadService();
        $this->patientController = new PatientController;
        $this->middleware('adminOrClinician')->except(['index', 'generateTable', 'generateTableValues']);
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

            $clinicName = ($row->clinician && $row->clinician->id) ?
                ucwords($row->clinician->first_name).' '.ucwords($row->clinician->last_name)
                : '';
            $patientNamw = ($row->patient && $row->patient->id) ?
                ucwords($row->patient->first_name).' '.ucwords($row->patient->last_name)
                : '';

            $meeting = CrmMeeting::where('session_id', $row->id)->first();
            $file = ($row->file) ? url($row->file) : '';

            $data[$key]['DT_RowAttr'] = $_r;
            $data[$key]['id'] = $row->id;
            $data[$key]['clinician'] = $clinicName;
            $data[$key]['patient'] = $patientNamw;
            $data[$key]['session'] = $row->title;
            $data[$key]['start_date'] = Carbon::parse($row->start_date)->format('Y-m-d h:m:s A');
            $data[$key]['end_date'] = Carbon::parse($row->end_date)->format('Y-m-d h:m:s A');
            $data[$key]['file'] = $file;
            $data[$key]['meeting'] = view('appends.actions.sessions.join-url', [ "row" => $row, 'meeting' => $meeting ])->render();
            $data[$key]['actions'] = view('appends.actions.sessions.index', [ "row" => $row, 'meeting' => $meeting ])->render();
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sessions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array();
        $data['patients'] = array();
        $data['clinicName'] = "";

        if(Auth::user()->user_type == '3') {
            $clinician = Clinician::where('user_id', Auth::user()->id)->first();
            $data['clinicName'] = "$clinician->first_name $clinician->last_name";
            $data['patients'] = $this->patientController->getClinicPatient($clinician->id);
        }

        if(Auth::user()->user_type == '2') {
            $data['clinicians'] = Clinician::all();
        }
        return view('sessions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = [
            'patient_id' => 'required',
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        if(Auth::user()->user_type == '2') {
            $validateData['clinician_id'] = 'required|exists:clinicians,id';
        }

        $validator = Validator::make($request->all(), $validateData);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $clinitianId = '';

        if(array_key_exists('clinician_id', $request->all())) {
            $clinitianId = $request->clinician_id;
        } else {
            $clinic = Clinician::where('user_id', Auth::user()->id)->first();
            $clinitianId = ($clinic && $clinic->id) ? $clinic->id : '';
        }

        if($clinitianId) {
            $start_date = "$request->start_date $request->start_hour:$request->start_minute";
            $end_date = "$request->end_date $request->end_hour:$request->end_minute";
            $upload = null;


            if($request->hasFile('upload_file')) {
                $upload = $this->uploader->upload($request->file('upload_file'), '/files/session');
            }

            $session = new CrmSession;
            $session->user_id = Auth::user()->id;
            $session->clinician_id = $clinitianId;
            $session->patient_id = $request->patient_id;
            $session->title = $request->title_first.' - '.$request->title;
            $session->description = $request->description;
            $session->start_date = $start_date;
            $session->end_date = $end_date;
            $session->file = $upload;

            if($session->save()) {
                $meetings = CrmMeeting::createMeeting($request->title, Carbon::parse($start_date));
                $values = $meetings['data'];

                if($values && array_key_exists('id', $values)) {
                    $meeting = new CrmMeeting;

                    $meeting->session_id = $session->id;
                    $meeting->zoom_id = $values['id'];
                    $meeting->start_time = $values['start_time'];
                    $meeting->start_url = $values['start_url'];
                    $meeting->join_url = $values['join_url'];
                    $meeting->password = $values['password'];
                    $meeting->duration = $values['duration'];
                    $meeting->status = $values['status'];

                    $meeting->save();
                }

                return redirect()->route('sessions.index')->with('success', 'New Session has been created.');
            }

            return redirect()->back()->with('error', 'Unable to create session.');
        }

        return redirect()->back()->with('error', 'You are not allowed to create session.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['clinicians'] = Clinician::all();
        $session = CrmSession::where('id', base64_decode($id))->first();
        $data['session'] = $session;
        $data['patients'] = array();
        $data['clinicName'] = '';

        if(Auth::user()->user_type == '3') {
            $clinician = Clinician::where('user_id', Auth::user()->id)->first();
            $data['clinicName'] = "$clinician->first_name $clinician->last_name";
            $data['patients'] = $this->patientController->getClinicPatient($clinician->id);
        } else {
            $data['patients'] = $this->patientController->getClinicPatient($session->clinician_id);
        }

        return view('sessions.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = [
            'patient_id' => 'required',
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        if(Auth::user()->user_type == '2') {
            $validateData['clinician_id'] = 'required|exists:clinicians,id';
        }

        $validator = Validator::make($request->all(), $validateData);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $clinitianId = '';

        if(array_key_exists('clinician_id', $request->all())) {
            $clinitianId = $request->clinician_id;
        } else {
            $clinic = Clinician::where('user_id', Auth::user()->id)->first();
            $clinitianId = ($clinic && $clinic->id) ? $clinic->id : '';
        }

        if($clinitianId) {
            $start_date = "$request->start_date $request->start_hour:$request->start_minute";
            $end_date = "$request->end_date $request->end_hour:$request->end_minute";

            $session = CrmSession::findOrFail(base64_decode($id));
            $upload = $session->file;


            if($request->hasFile('upload_file')) {
                $upload = $this->uploader->upload($request->file('upload_file'), '/files/session');
            }

            $session->clinician_id = $clinitianId;
            $session->patient_id = $request->patient_id;
            $session->title = $request->title_first.' - '.$request->title;
            $session->description = $request->description;
            $session->start_date = $start_date;
            $session->end_date = $end_date;
            $session->file = $upload;

            if($session->save()) {
                $meeting = CrmMeeting::where('session_id', $session->id)->first();

                if($meeting && $meeting->id) {
                    CrmMeeting::deleteMeeting($meeting->zoom_id);

                    $meetings = CrmMeeting::createMeeting($request->title, Carbon::parse($start_date));
                    $values = $meetings['data'];

                    if($values && array_key_exists('id', $values)) {
                        $meeting->zoom_id = $values['id'];
                        $meeting->start_time = $values['start_time'];
                        $meeting->start_url = $values['start_url'];
                        $meeting->join_url = $values['join_url'];
                        $meeting->password = $values['password'];
                        $meeting->duration = $values['duration'];
                        $meeting->status = $values['status'];

                        $meeting->save();
                    }
                }

                return redirect()->back()->with('success', 'Your Session has been updated.');
            }

            return redirect()->back()->with('error', 'Unable to update session.');
        }

        return redirect()->back()->with('error', 'You are not allowed to update session.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CrmSession::where('id', base64_decode($id))->delete();
        $meeting = CrmMeeting::where('session_id', base64_decode($id))->first();
        
        if($meeting) {
            CrmMeeting::where('session_id', $meeting->id)->delete();
            CrmMeeting::deleteMeeting($meeting->zoom_id);
        }

        return redirect()->back()->with('success', 'Session and meeting deleted successfully.');
    }

    /**
     * generate table values.
     */
    public function generateTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'clinician_id',
            2 => 'title',
            3 => 'start_date',
            4 => 'end_date',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $sessions = CrmSession::assigned();

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $sessions = $sessions->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        }

        $counts = $sessions->count();
        $sessions = $sessions->orderBy($order, $dir);
        if($limit >= 0) {
            $sessions = $sessions->offset($start)->limit($limit);
        }

        $sessions = $sessions->with([ 'clinician', 'meeting' ])->get();

        $values = $this->generateTableValues($sessions);
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
