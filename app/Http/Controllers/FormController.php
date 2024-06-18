<?php

namespace App\Http\Controllers;

use App\Models\Clinician;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\FormField;
use App\Models\ClinicianPatient;
use App\Models\Patient;
use App\Models\AssignedForm;
use App\Services\UploadService;
use App\Services\MailService;
use App\Mail\AssignFormMail;
use View, Auth, Session, Mail;
use Carbon\Carbon;

class FormController extends Controller
{
    protected $uploadService;
    protected $mailService;
    protected $adminMail;

    public function __construct() {
        $this->uploadService = new UploadService();
        $this->mailService = new MailService();

        $user = User::where('user_type', '2')->first();
        $this->adminMail = ($user && $user->id) ? $user->email : '';
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
            $data[$key]['name'] = ($row->name) ? ucwords($row->name) : "";
            $data[$key]['description'] = ucwords($row->description);
            $data[$key]['user'] = ($row->user && $row->user->id) ? $row->user->name : "";
            $data[$key]['created_at'] = Carbon::parse($row->created_at)->format('Y-m-d');
            $data[$key]['actions'] = view('appends.actions.forms', [ "row" => $row ])->render();
        }

        return $data;
    }

    /**
     * Function to generate form Values.
     * @param $listing Laravel Array of objects from query.
     * 
     * @return Array values.
     */
    protected function generateListTableValues($listing) {
        $data = array();

        foreach ($listing as $key => $row) {
            $_r = new \stdClass();
            // $_r->style = ($row->trashed()) ? "background-color: #f5c1c1;" : "";

            $data[$key]['DT_RowAttr'] = $_r;
            $data[$key]['id'] = $row->id;
            $data[$key]['name'] = ($row->user && $row->user->id) ? $row->user->name : "";
            $data[$key]['created_at'] = Carbon::parse($row->created_at)->format('Y-m-d');
            $data[$key]['actions'] = view('appends.actions.form-submission', [ "row" => $row ])->render();
        }

        return $data;
    }

    /**
     * Function to generate form Values.
     * @param $listing Laravel Array of objects from query.
     * 
     * @return Array values.
     */
    protected function generateAssignedListValues($listing) {
        $data = array();

        foreach ($listing as $key => $row) {
            $_r = new \stdClass();
            // $_r->style = ($row->trashed()) ? "background-color: #f5c1c1;" : "";

            $data[$key]['DT_RowAttr'] = $_r;
            $data[$key]['id'] = $row->id;
            $data[$key]['form'] = $row->form->name;
            $data[$key]['patient'] = $row->patient->first_name.' '.$row->patient->last_name;
            $data[$key]['actions'] = view('appends.actions.form-assign', [ "row" => $row ])->render();
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('forms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->user_type != '2') {
            return redirect()->route('forms.index')->with('error', 'You are not allowed to access this route.');
        }

        $data['renders'] = View::make('forms.includes.fields')->render();
        return view('forms.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = 'error'; $message = 'Unable to add new form';

        try {
            $newArray = array_values($request->form);
            $form = new Form;

            // $form->user_id = Auth::user()->id;
            $form->user_id = 1;
            $form->name = $request->name;
            $form->description = $request->description;
            $form->submit = $request->button;

            if($form->save()) {
                foreach ($newArray as $key => $value) {
                    $fields = new FormField;

                    $fields->form_id = $form->id;
                    $fields->type = $value['type'];
                    $fields->label = $value['label'];
                    $fields->options = json_encode($value['options']);

                    $fields->save();
                }

                $type = 'success'; $message = 'New record has been created.';
            }
        } catch(\Exception $err) {
            $message = $err->getMessage();
        }

        return redirect()->route('forms.index')->with($type, $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['form'] = Form::where('id', base64_decode($id))->with('fields')->first();
        return view('forms.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->user_type != '2') {
            return redirect()->route('forms.index')->with('error', 'You are not allowed to access this route.');
        }

        $data['form'] = Form::where('id', base64_decode($id))->with('fields')->first();
        $data['renders'] = View::make('forms.includes.fields')->render();

        return view('forms.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = 'error'; $message = 'Something went wrong while updating form values.';

        try {
            $newArray = array_values($request->form);
            $form = Form::find(base64_decode($id));

            $form->name = $request->name;
            $form->description = $request->description;
            $form->submit = $request->button;

            if($form->save()) {
                foreach ($newArray as $key => $value) {
                    if($value && isset($value['id'])) {
                        FormField::updateOrCreate([
                            'id' => $value['id'],
                            'form_id' => base64_decode($id)
                        ], [
                            'type' => $value['type'],
                            'label' => $value['label'],
                            'options' => json_encode($value['options']),
                        ]);
                    } else {
                        $fields = new FormField;

                        $fields->form_id = base64_decode($id);
                        $fields->type = $value['type'];
                        $fields->label = $value['label'];
                        $fields->options = json_encode($value['options']);

                        $fields->save();
                    }
                }

                $type = 'success'; $message = 'Form Updated Successfully.';
            }

            if($request->removed) {
                FormField::whereIn('id', explode(',', $request->removed))->delete();
            }
        } catch(\Exception $err) {
            $message = $err->getMessage();
        }

        return redirect()->back()->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type != '2') {
            return redirect()->route('forms.index')->with('error', 'You are not allowed to access this route.');
        }

        $_id = base64_decode($id);
        Form::where('id', $_id)->delete();
        $ids = FormField::where('form_id', $_id)->pluck('id')->toArray();
        
        FormField::whereIn('id', $ids)->delete();
        FormAnswer::where('form_id', $_id)->whereIn('form_field_id', $ids)->delete();

        return redirect()->back()->with('success', 'Form Deleted Successfully.');
    }

    public function generateTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user_id',
            3 => 'created_at'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $forms = Form::assigned();

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $forms = $forms->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        }

        $counts = $forms->count();
        $forms = $forms->orderBy($order, $dir);
        if($limit >= 0) {
            $forms = $forms->offset($start)->limit($limit);
        }

        $forms = $forms->with([ 'user', 'fields', 'submited' ])->get();

        $values = $this->generateTableValues($forms);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    // API function to get empty fields data.
    public function fetchFields() {
        $html = View::make('forms.includes.fields')->render();
        return response()->json(['html' => $html]);
    }

    public function checkFormSubmit($id) {

        $check = FormAnswer::where('form_id', base64_decode($id))->where('user_id', Auth::user()->id)->first();
        if($check && $check->id) {
            return redirect()->route('forms.index')->with('success', 'You have already submitted this form.');
        }

        $data['form'] = Form::where('id', base64_decode($id))->with('fields')->first();
        return view('forms.submit', $data);
    }

    /**
     * Function to submit all the form values from users end.
     */
    public function submitAnswers(Request $request) {
        if($request->answers && count($request->answers) > 0) {
            foreach($request->answers as $key => $value) {
                $_values = array();

                if($value['type'] == 'file') {
                    $file = $this->uploadService->upload($value['answer'], '/forms/answers');
                    $_values['answer'] = url($file);
                } else {
                    $_values['answer'] = $value['answer'];
                }

                FormAnswer::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'form_id' => $request->form_id,
                    'form_field_id' => $value['id']
                ], $_values);
            }

            $form = Form::where('id', $request->form_id)->first();
            $patient = Patient::where('user_id', Auth::user()->id)->first();
            $clinician = ($patient && $patient->id) ? 
                AssignedForm::where('patient_id', $patient->id)
                    ->where('form_id', $request->form_id)
                    ->first()
            : null;

            $data['form'] = $form;
            $data['answers'] = FormAnswer::where('user_id', Auth::user()->id)->where('form_id', $request->form_id)->get();

            // send email to admin
            $this->mailService->send($data, 'emails.forms.submit', $this->adminMail, "$form->name, details has been submitted.");
            // Send mail to clinitian
            if($clinician && $clinician->id) {
                if($clinician->user->email != $this->adminMail) {
                    $this->mailService->send($data, 'emails.forms.submit', $clinician->user->email, "$form->name, details has been submitted.");
                }
            }

            return redirect()->route('forms.index')->with('success', 'Thanks, your forms details are submitted.');
        }

        return redirect()->back()->with('error', 'Please fill values to complete submission');
    }

    public function listSubmissions(string $id) {
        $data['form'] = Form::where('id', base64_decode($id))->first();

        return view('forms.list-submit', $data);
    }

    public function listTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'user_id',
            2 => 'created_at'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $forms = FormAnswer::where('form_id', $request->id);

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $forms = $forms->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        }

        $counts = $forms->count();
        $forms = $forms->orderBy($order, $dir);
        if($limit >= 0) {
            $forms = $forms->offset($start)->limit($limit);
        }

        $forms = $forms->groupBy('user_id')->groupBy('form_id');
        $forms = $forms->with([ 'user' ])->get();

        $values = $this->generateListTableValues($forms);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    public function viewSubmission(string $id, string $user) {
        $data['form'] = Form::where('id', base64_decode($id))->first();

        $data['formAnswers'] = FormAnswer::where('form_id', base64_decode($id))
            ->where('user_id', base64_decode($user))
            ->with('question')
            ->get();

        return view('forms.view-submission', $data);
    }


    /**********************************************************************
     *                      clinician Assign Forms
     *********************************************************************/   
    public function AssignFormList() {
        return view('assigned_forms.assigned-list');
    }

    public function assignedList(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'user_id',
            2 => 'created_at'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $forms = AssignedForm::Query();

        if(Auth::user()->user_type != '2') {
            $forms = $forms->where('user_id', Auth::user()->id);
        }

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $forms = $forms->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        }

        $counts = $forms->count();
        $forms = $forms->orderBy($order, $dir);
        if($limit >= 0) {
            $forms = $forms->offset($start)->limit($limit);
        }

        $forms = $forms->with([ 'user', 'patient' ])->get();

        $values = $this->generateAssignedListValues($forms);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    public function AssignForm()
    {
        $data['forms'] = Form::all();
        $data['patients'] = Patient::assigned()->get();

        return view('assigned_forms.assign-form', $data);
    }

    public function saveAssignedForm(Request $request)
    {
        $form = Form::where('id', $request->form_id)->first();

        foreach($request->patient_id as $patient) {
            $record = AssignedForm::updateOrCreate([
                'patient_id' => $patient,
                'form_id' => $request->form_id
            ], [
                'user_id' => Auth::user()->id
            ]);

            if ($record->wasRecentlyCreated) {
                $patient = Patient::where('id', $patient)->first();
                $mailValues['patient'] = $patient;

                $mailValues['form'] = $form;
                $mailValues['user'] = Auth::user();

                Mail::to($patient->user->email)->send(new AssignFormMail($mailValues));
            }
        }
        
        session()->flash('success', 'Form has been assigned successfully.');

        return redirect()->route('assign-form-list');
    }

    public function editAssignedForm($id)
    {
        $data['forms'] = Form::all();
        $data['patients'] = Patient::assigned()->get();
        $data['assigned'] = AssignedForm::where('id' , $id)->with('patient' , 'form')->first();

        return view('assigned_forms.edit-assigned', $data);
    }

    public function updateAssignedForm(Request $request , $id)
    {
        $form = AssignedForm::findOrFail($id);

        $form->patient_id = $request->input('patient_id');
        $form->form_id = $request->input('form_id');
        $form->save();

        return redirect()->route('assign-form-list')->with('success', 'Assigned form Updated successfully');
    }

    public function destroyAssignedForm($id)
    {
        $form = AssignedForm::where('id' , $id)->first();
        $form->delete();

        return redirect()->route('assign-form-list');
    }

}
