<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Classs;
use App\Models\Option;
use App\Models\Question;
use App\Models\StudentClass;
use App\Models\StudentSurveySection;
use App\Models\SurveyOption;
use App\Models\TeacherSurveySection;
use App\Models\UserModel;
use App\Models\UserSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use User;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payload = JWTAuth::parseToken()->getPayload()->get('myCustomArray');

        $query = Survey::with('questions.options')
            ->with('option')
            ->with('user_surveys.user')
            ->where('title', 'like', '%' . $request->query('search') . '%');

        if ($payload['role'] == 'student') {
            $query = $query->where(function ($subQuery) use ($payload) {
                $subQuery
                    ->whereIn(
                        'id',
                        UserSurvey::where('user_id', $payload['id'])
                            ->select('survey_id')
                            ->get()
                    )
                    ->orWhereRelation('option', 'public', '!=', false);
            });
        }

        $data = $query->get();
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
            return response(['errorMessage' => 'Đã xảy ra lỗi không xác định', 'info' => $th], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $survey = Survey::with('questions.options')
            ->with('option')
            ->where('id', $id)
            ->first();
        if ($survey->option && !$survey->option->public) {
            $payload = JWTAuth::parseToken()->getPayload()->get('myCustomArray');
            $check = UserSurvey::where('user_id', $payload['id'])->where('survey_id', $id)->first();
            if (!$check) {
                return response([
                    'errorMessage' => 'Tài khoản của bạn không đủ điều kiện để thực hiện khảo sát này'
                ], 401);
            }
        }
        return ['data' => $survey];
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

        try {
            DB::beginTransaction();

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

            DB::commit();

            return ['result' => 'success'];
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
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
        $answer = Answer::with('user')
            ->with('survey')
            ->with('question')
            ->with('option')
            ->where('survey_id', '=', $survey_id)
            ->get();

        return ['data' => $answer];
    }

    public function show_survey_answer($survey_id, $user_id)
    {
        $answer = Answer::with('user')
            ->with('survey')
            ->with('question')
            ->with('option')
            ->where('survey_id', '=', $survey_id)
            ->where('user_id', '=', $user_id)
            ->get();

        return ['data' => $answer];
    }

    public function get_option($id)
    {
        $option = SurveyOption::where('survey_id', $id)->first();
        if (!$option) {
            return ['data' => null];
        }

        $class_ids = explode(',', $option->classes);
        $classes = [];
        if (count($class_ids) > 0) {
            $classes = Classs::whereIn('id', $class_ids)->get();
        }
        $students = UserModel::with('department')->where('role', 'student')
            ->whereIn('id', UserSurvey::where('survey_id', $id)->select('user_id')->get())
            ->get();

        return [
            'data' => $option,
            'students' => $students,
            'classes' => $classes,
        ];
    }

    public function update_option(Request $request, $survey_id)
    {
        try {
            DB::beginTransaction();

            $body = $request->all();
            SurveyOption::updateOrCreate([
                'survey_id' => $survey_id
            ], [
                'survey_id' => $survey_id,
                'limit' => $body['limit'],
                'shuffle_question_order' => $body['shuffle_question_order'],
                'view_results' =>  $body['view_results'],
                'public' => $body['public'],
            ]);
            UserSurvey::where('survey_id', $survey_id)->delete();
            if (is_array($body['class_ids'])) {
                foreach ($body['class_ids'] as $class_id) //tim list user id theo class_id
                {
                    $student_classes = StudentClass::where('class_id', $class_id)->get();
                    foreach ($student_classes as $key1 => $student_class) {
                        UserSurvey::updateOrCreate([
                            'user_id' => $student_class->user_id,
                            'survey_id' => $survey_id,
                        ], [
                            'user_id' => $student_class->user_id,
                            'survey_id' => $survey_id
                        ]);
                    }
                    SurveyOption::where('survey_id', $survey_id)->update([
                        'classes' => implode(',', $body['class_ids'])
                    ]);
                }
            }
            //add survey by userid
            if (is_array($body['student_ids'])) {
                foreach ($body['student_ids'] as $user_id) {
                    UserSurvey::updateOrCreate([
                        'user_id' => $user_id,
                        'survey_id' => $survey_id,
                    ], [
                        'user_id' => $user_id,
                        'survey_id' => $survey_id,
                    ]);
                }
            }

            DB::commit();
            return ['result' => 'success'];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response(['errorMessage' => 'Đã xảy ra lỗi không xác định', 'info' => $th], 400);
        }
    }
}
