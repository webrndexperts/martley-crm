<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRMAssessment;
use App\Models\Clinician;
use App\Models\ClinicianPatient;
use App\Models\Patient;
use App\Models\AssignedAssessment;
use App\Models\CRMAssessmentQuestion;
use App\Models\AssesmentAnswer;
use Auth;
use Carbon\Carbon;


class CRMAssessmentController extends Controller
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
            $data[$key]['name'] = ucwords($row->title);
            $data[$key]['description'] = $row->description;
            $data[$key]['date'] = Carbon::parse($row->due_date)->format('Y-m-d');
            $data[$key]['actions'] = view('appends.actions.assesments', [ "row" => $row ])->render();
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
            $data[$key]['assessment'] = ($row->assessment && $row->assessment->id) ? $row->assessment->title : "";
            $data[$key]['created_at'] = Carbon::parse($row->created_at)->format('Y-m-d');
            $data[$key]['actions'] = view('appends.actions.assesment-submission', [ "row" => $row ])->render();
        }

        return $data;
    }

    public function index()
    {
        return view('assessment.list');
    }

    public function create()
    {        
        return view('assessment.create');
    }

    public function save(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            
        ]);
        
        $assessment = new CRMAssessment();
        $assessment->user_id = $id;
        $assessment->title = $request->input('title');
        $assessment->description = $request->input('description');
        $assessment->due_date = $request->input('due_date');
        $assessment->save();
        
        $assessmentId = $assessment->id;        
        $questions = $request->questions ?? [];

        foreach ($questions as $questionData) {
            $question = new CRMAssessmentQuestion();
            $question->assessment_id = $assessmentId;
            $question->question = $questionData['question'];
            $question->question_type = $questionData['type'];

            if ($questionData['type'] === 'radio') {
                $question->answer = implode(',', $questionData['options']);
            }

            $question->save();
        }
        return redirect()->route('assessment-list')->with('success', 'Assessment added successfully');
    }

    public function edit(CRMAssessment $assessment)
    {        
        $questions = CRMAssessmentQuestion::where('assessment_id', $assessment->id)->orderBy('id', 'ASC')->get();
        return view('assessment.edit', compact('assessment' , 'questions'));
    }

    public function destroyQuestion($id)
    {
        $question = CRMAssessmentQuestion::find($id);

        if ($question) {
            $question->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Question not found'], 404);
        }
    }
        
    public function update(Request $request, $assessment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
        ]);
    
        $assessment = CRMAssessment::findOrFail($assessment);
    
        $assessment->update([
            'title' => $request->input('title'),
            'due_date' => $request->input('due_date'),
            'description' => $request->input('description'),
        ]);
    
        $questions = $request->questions ?? [];
    
        foreach ($questions as $key => $questionData) {
            if (isset($questionData['id'])) {
                // Update existing question
                $question = CRMAssessmentQuestion::find($questionData['id']);
                if ($question) {
                    $question->update([
                        'question' => $questionData['question'],
                        'answer' => isset($questionData['options']) ? implode(',', $questionData['options']) : null,
                    ]);
                }
            } else {
                // Create new question
                $question = new CRMAssessmentQuestion();
                $question->assessment_id = $assessment->id;
                $question->question = $questionData['question'];
                $question->question_type = $questionData['type'];
                $question->answer = isset($questionData['options']) && $questionData['type'] === 'radio' ? implode(',', $questionData['options']) : null;
                $question->save();
            }
        }
    
        return redirect()->route('assessment-list')->with('success', 'Assessment updated successfully');
    }

    
    public function show($assessment)
    {
        $data = CRMAssessment::Where('id', $assessment)->first();
        $questions = CRMAssessmentQuestion::where('assessment_id', $data->id)->get();
        
        return view('assessment.show', compact('data', 'questions'));
    }
    public function destroy($id)
    {
        $questions = CRMAssessmentQuestion::where('assessment_id' , $id);   

        foreach ($questions as $question) {
            $question->delete();
        } 
  
        $assessment = CRMAssessment::findOrFail($id);
        
        $assessment->delete();
        return redirect()->route('assessment-list')->with('success', 'Assessment and related questions deleted successfully.');
    }


    public function generateTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'description',
            3 => 'due_date'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $assesments = CRMAssessment::assigned();

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $assesments = $assesments->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('due_date', 'LIKE', "%{$search}%");
            });
        }

        $counts = $assesments->count();
        $assesments = $assesments->orderBy($order, $dir);
        if($limit >= 0) {
            $assesments = $assesments->offset($start)->limit($limit);
        }

        $assesments = $assesments->with([ 'submited' ])->get();

        $values = $this->generateTableValues($assesments);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    
    /**********************************************************************
     *                      clinician Assign Assessment
     *********************************************************************/
    public function AssignAssessmentList()
    {
        $id = Auth::user()->id;
        $assessments = AssignedAssessment::where('user_id' , $id)->get();
        return view('assigned_assessment.assigned-list', compact('assessments'));
    }

    public function AssignAssessment()
    {
        $data['assessments'] = CRMAssessment::all();
        $clinitian = Clinician::where('user_id', Auth::user()->id)->first();
        $data['patients'] = ClinicianPatient::where('clinician_id' , $clinitian->id)->get(); 

        return view('assigned_assessment.assign-assessment', $data);
    }

    public function saveAssignedAssessment(Request $request)
    {
        $form =  New AssignedAssessment;
        $form->patient_id = $request->patient_id;
        $form->assessment_id = $request->assessment_id;
        $form->user_id = Auth::user()->id;

        $form->save();
        
        session()->flash('success', 'Form has been assigned successfully.');

        return redirect()->route('assign-assessment-list')->with('success', 'Assessment Created successfully');
    }

    public function editAssignedAssessment($id)
    {
        $assessments = CRMAssessment::all();
        $patients = Patient::all();
        $assigned = AssignedAssessment::where('id' , $id)->with('patient' , 'assessment')->first();

        return view('assigned_assessment.edit-assigned', compact('assessments', 'patients' , 'assigned'));
    }

    public function updateAssignedAssessment(Request $request , $id)
    {
        $assessment = AssignedAssessment::findOrFail($id);

        $assessment->patient_id = $request->input('patient_id');
        $assessment->assessment_id = $request->input('assessment_id');
        $assessment->save();

        return redirect()->route('assign-assessment-list')->with('success', 'Assigned Assessment Updated successfully');
    }

    public function destroyAssignedAssessment($id)
    {
        $assessment = AssignedAssessment::where('id' , $id)->first();

        $assessment->delete();

        return redirect()->route('assign-assessment-list')->with('success', 'Assessment Deleted successfully');
    }


    public function listSubmissions(string $id) {
        $data['assessment'] = CRMAssessment::where('id', base64_decode($id))->first();

        return view('assessment.list-submit', $data);
    }

    public function listTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'user_id',
            1 => 'assesment_id',
            2 => 'created_at'
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $answers = AssesmentAnswer::where('assesment_id', $request->id);

        if(!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $answers = $answers->where(function($q) use($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    ->orWhere('assesment_id', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        }

        $counts = $answers->count();
        $answers = $answers->orderBy($order, $dir);
        if($limit >= 0) {
            $answers = $answers->offset($start)->limit($limit);
        }

        $answers = $answers->groupBy('user_id')->groupBy('assesment_id');
        $answers = $answers->with([ 'user', 'assessment' ])->get();

        $values = $this->generateListTableValues($answers);
        $json_data = array(
            "input" => $request->all(),
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($counts),
            "recordsFiltered" => intval($counts),
            "data" => $values
        );

        return json_encode($json_data);
    }

    public function checkFormSubmit($id) {

        $check = AssesmentAnswer::where('assesment_id', base64_decode($id))->where('user_id', Auth::user()->id)->first();
        if($check && $check->id) {
            return redirect()->route('assessment-list')->with('success', 'You have already submitted this assessment.');
        }

        $data['assessment'] = CRMAssessment::where('id', base64_decode($id))->with('questions')->first();
        return view('assessment.submit', $data);
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

                AssesmentAnswer::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'assesment_id' => $request->assessment_id,
                    'question_id' => $value['id']
                ], $_values);
            }

            return redirect()->route('assessment-list')->with('success', 'Thanks, your assesment details are submitted.');
        }

        return redirect()->back()->with('error', 'Please fill values to complete submission');
    }

    public function viewSubmission(string $id, string $user) {
        $data['assessment'] = CRMAssessment::where('id', base64_decode($id))->first();

        $data['answers'] = AssesmentAnswer::where('assesment_id', base64_decode($id))
            ->where('user_id', base64_decode($user))
            ->with('question')
            ->get();

        return view('assessment.view-submission', $data);
    }
}
