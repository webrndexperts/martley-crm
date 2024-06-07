<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRMAssessment;
use App\Models\Clinician;
use App\Models\ClinicianPatient;
use App\Models\Patient;
use App\Models\AssignedAssessment;
use App\Models\CRMAssessmentQuestion;
use Illuminate\Support\Facades\Auth;


class CRMAssessmentController extends Controller
{
    public function index()
    {
        $assessments = CRMAssessment::orderBy('id', 'DESC')->get();

        return view('assessment.list', compact('assessments'));
    }

    public function create()
    {        
        return view('assessment.create');
    }

    public function save(Request $request)
    {
        // dd($request->all());

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

        $assessments = CRMAssessment::all();
        
        $questions = $request->questions ?? [];
        // dd($request->questions);

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
                        // 'question_type' => $questionData['type'],
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
        // dd($assessment);
        
        $data = CRMAssessment::Where('id', $assessment)->first();
        $questions = CRMAssessmentQuestion::where('assessment_id', $data->id)->get();
        
        return view('assessment.show', compact('data', 'questions'));
    }
    public function destroy($id)
    {
        // dd($id);
        $questions = CRMAssessmentQuestion::where('assessment_id' , $id);   

        foreach ($questions as $question) {
            $question->delete();
        } 
  
        $assessment = CRMAssessment::findOrFail($id);
        
        $assessment->delete();
        return redirect()->route('assessment-list')->with('success', 'Assessment and related questions deleted successfully.');
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
        $assessments = CRMAssessment::all();
        $patients = ClinicianPatient::where('clinician_id' , Auth::user()->id)->get(); 

        return view('assigned_assessment.assign-assessment', compact('assessments', 'patients'));
    }

    public function saveAssignedAssessment(Request $request)
    {
        // dd($request->all());

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
        // dd($id);
        $assessment = AssignedAssessment::where('id' , $id)->first();

        $assessment->delete();

        return redirect()->route('assign-assessment-list')->with('success', 'Assessment Deleted successfully');
    }
}
