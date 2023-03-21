<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\StudentSurveySection;
use App\Models\SurveyOption;
use App\Models\TeacherSurveySection;
use App\Models\UserSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $whereClause = [];

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
        DB::beginTransaction();
        try {
            //code...

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
            DB::commit();

            return ['result' => 'success'];
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response(['errorMessage' => 'Đã xảy ra lỗi không xác định', 'info' => $th], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Survey::with('questions.options')->with('option')->where('id', $id)->get();
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

        UserSurvey::updateOrCreate([
            'user_id' => $body['section']['user_id'],
            'survey_id' => $body['section']['survey_id'],
        ], [
            'is_finish' => true,
        ]);

        Answer::where('user_id', $body['section']['user_id'])
            ->where('survey_id', $body['section']['survey_id'])
            ->delete();
        Answer::insert($body['answers']);
        return ['result' => 'success'];
    }

    public function show_all_answer_by_survey($survey_id)
    {
        $answer = DB::table('answers')
            ->where('survey_id', '=', $survey_id)
            ->get();

        return ['data' => $answer];
    }

    public function show_survey_answer($survey_id, $user_id)
    {
        $answer = DB::table('answers')
            ->where('survey_id', '=', $survey_id)
            ->where('user_id', '=', $user_id)
            ->get();

        return ['data' => $answer];
    }
    public function option(Request $request, $survey_id)
    {   
        $body = $request->all();
        try {
            //code...
            DB::table('survey_options')->insert(
                array(
                    'survey_id' => $survey_id,
                    'limit' => $body['limit'],
                    'shuffle_question_order' => $body['shuffle_question_order'],
                    'view_results'=>  $body['view_results'],
                    'public' => $body['public'],
                    'class_id' =>$body['class_id'],
                    'user_surveys' =>$body['user_surveys']
                )
            );
            //add survey by class
            if (is_array($body['class_ids']) )
            {
                foreach ($body['class_ids'] as $i => $class_id)//tim list user id theo class_id
                {
                    $list_user_id = DB::table('student_classes')->where('class_id', '=', $class_id)->lists('user_id');
                    foreach ($list_user_id as $key1 => $user_id) {
                        # code...
                        DB::table('user_surveys')->insert(
                            array(
                                'user_id' => $user_id,
                                'survey_id' => $survey_id,
                            )
                        );

                    }

                }
                 
            }
            //add survey by user id
            if(is_array($body['user_surveys'])){
                foreach ($body['user_surveys'] as $key2 => $user_id) {
                    # code...
                    DB::table('user_surveys')->insert(
                        array(
                            'user_id' => $user_id,
                            'survey_id' => $survey_id,
                        )
                    );

                }
            }


        } catch (\Throwable $th) {
            //throw $th;
            return response(['errorMessage' => 'Đã xảy ra lỗi không xác định', 'info' => $th], 400);
        }
        

    }
}
