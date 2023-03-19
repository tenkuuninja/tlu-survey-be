<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\StudentSurveySection;
use App\Models\TeacherSurveySection;
use App\Models\UserSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Survey::with('questions.options')
            ->where('title', 'like', '%' . $request->query('search') . '%')
            ->get();
        return [
            'data' => $data
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // var_dump($request);
        $body = $request->all();
        $survey = Survey::create([
            'code' => Str::uuid(),
            'title' => $body['title'],
            'note' => '123',
            'status' => 1,
        ]);
        if (is_array($body['questions'])) {
            foreach ($body['questions'] as $i => $q) {
                $question = Question::create([
                    'survey_id' => $survey->id,
                    'type_id' => $q['type_id'],
                    'title' => $q['title'],
                    'required' => $q['required'],
                    'question_no' => $i,
                ]);
                if (is_array($q['options'])) {
                    foreach ($q['options'] as $j => $option) {
                        $newOption = Option::create([
                            'question_id' => $question->id,
                            'title' => $option['title'],
                            'option_no' => $j,
                        ]);
                    }
                }
            }
        }

        return ['result' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Survey::with('questions.options')->where('id', $id)->get();
        return ['data' => $data[0]];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // var_dump($request);
        $body = $request->all();

        $survey = Survey::find($id);
        $survey->title = $body['title'];
        $survey->note = '123';
        $survey->status = 1;
        $survey->save();

        if (is_array($body['questions'])) {
            $notDeleteQuestionIds = [];
            foreach ($body['questions'] as $i => $q) {
                $newQuestionId = null;
                $newQuestionRecord = [
                    'survey_id' => $survey->id,
                    'type_id' => $q['type_id'],
                    'title' => $q['title'],
                    'required' => $q['required'],
                    'question_no' => $i + 1,
                ];
                if (isset($q['id']) && is_numeric($q['id'])) {
                    Question::where('id', $q['id'])->update($newQuestionRecord);
                    $newQuestionId = $q['id'];
                } else {
                    $newQuestion = Question::create($newQuestionRecord);
                    $newQuestionId = $newQuestion->id;
                }
                array_push($notDeleteQuestionIds, $newQuestionId);
                if (is_array($q['options'])) {
                    $notDeleteOptionIds = [];
                    foreach ($q['options'] as $j => $option) {
                        $newOptionRecord = [
                            'question_id' => $newQuestionId,
                            'title' => $option['title'],
                            'option_no' => $j + 1,
                        ];
                        if (isset($option['id']) && is_numeric($option['id'])) {
                            Option::where('id', $option['id'])->update($newOptionRecord);
                            array_push($notDeleteOptionIds, $option['id']);
                        } else {
                            $newOption = Option::create($newOptionRecord);
                            array_push($notDeleteOptionIds, $newOption->id);
                        }
                    }
                    Option::whereNotIn('id', $notDeleteOptionIds)->where('question_id', $newQuestionId)->delete();
                }
            }
            Question::whereNotIn('id', $notDeleteQuestionIds)->where('survey_id', $id)->delete();
        }

        return ['result' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Survey::destroy($id);
        return ['result' => 'success'];
    }

    public function submit_form_survey(Request $request)
    {
        $body = $request->all();
        Answer::insert($body['answers']);
        UserSurvey::create($body['teacher_section']);
        return ['result' => 'success'];
    }
}
