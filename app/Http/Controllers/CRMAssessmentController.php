<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRMAssessment;
use App\Models\Clinician;
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
        return redirect()->route('assessment-list')->with('success', 'Clinical Assessment added successfully');
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

    // public function update(Request $request)
    // {
    //     // dd($request->all());

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'due_date' => 'required',
    //     ]);
        
    //     $assessment = CRMAssessment::find($request->id);

    //     if (!$assessment) {
    //         return back()->with('error', 'Assessment not found');
    //     }
    
    //     $assessment->update([
    //         'title' => $request->input('title'),
    //         'description' => $request->input('description'),
    //         'due_date' => $request->input('due_date'), 
    //     ]);   

    //     $questions = $request->questions ?? [];

    //     foreach ($questions as $questionData) {

    //         if (isset($questionData['id'])) {
    //             $question = CRMAssessmentQuestion::find($questionData['id']);
    //             $question->update([
    //                 'question' => $questionData['question'],
    //                 'answer' => isset($questionData['options']) ? implode(',', $questionData['options']) : null,
    //             ]);
    //         } else {
    //             $question = new CRMAssessmentQuestion();
    //             $question->assessment_id = $assessment->id;
    //             $question->question = $questionData['question'];
    //             $question->question_type = $questionData['type'];
    //             $question->answer = isset($questionData['options']) && $questionData['type'] === 'radio' ? implode(',', $questionData['options']) : null;
    //             $question->save();
    //         }
    //     }

    //     return redirect()->route('assessment-list')->with('success', 'Assessment updated successfully');
    // }
    
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
        $questions = CRMAssessmentQuestion::where('assessment_id' , $id)->get();   

        foreach ($questions as $question) {
            $question->delete();
        } 
  
        $assessment = CRMAssessment::find($id);

        return $assessment->delete();
    }
}
