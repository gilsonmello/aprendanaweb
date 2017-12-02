<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Occupation\OccupationContract;
use App\Repositories\Frontend\User\UserStudentContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\StudyPlan\StudyPlanContract;
use App\City;
use App\State;
use App\StudyPlan;
use App\SurveySimpleResponse;
use Carbon\Carbon;
use Matriphe\Imageupload\Imageupload;
use Illuminate\Http\Request;


/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

    public function __construct(StudyPlanContract $studyPlan, OccupationContract $occupations) {
        $this->studyPlan = $studyPlan;
        $this->occupations = $occupations;
    }

	/**
	 * @param $id
	 * @return mixed
	 */
	public function edit($id) {
        $city = City::withTrashed()->find(auth()->user($id)->city_id);
        $state = new State();
        if ($city != null) {
            $state = State::withTrashed()->find($city->state_id);
        } else {
            $city = new City();
        }


		$photooriginal = imageurl("users/", $id, auth()->user($id)->photo);
		$photoresize = imageurl("users/", $id, auth()->user($id)->photo, 200);

        $studyPlan = $this->studyPlan->findByUser(auth()->user()->id);
        $studyPlanHours = 3;
        if($studyPlan != null) {
            $studyPlanHours = $studyPlan->daily_time;
        }

        $occupations = $this->occupations->getAllOccupations('description', 'asc');

		return view('frontend.studentarea.profile.edit')
			->withUser(auth()->user($id))
			->withPhotooriginal($photooriginal)
			->withPhotoresize($photoresize)
            ->withCity($city)
            ->withState($state)
            ->withStudyplanhours($studyPlanHours)
            ->withOccupations($occupations);
	}

	/**
	 * @param $id
	 * @param UserContract $user
	 * @param UpdateProfileRequest $request
	 * @return mixed
	 */
	public function update($id, UserStudentContract $userStudent, UpdateProfileRequest $request, Imageupload $upload) {


		$userStudent->updateProfile($id, $request->except("planstudy_hours"));


        if ($request->hasFile('photo')){

            $new_file_name = $request['name'] . '_' . str_random(4);


            $imgResult = $upload->upload($request->file('photo'), $new_file_name, '/users/'.$id);
            if(!isset($imgResult['error'])) $userStudent->updatePhoto($id, $imgResult['filename']);
        }

        $planstudy_hours = $request['planstudy_hours'];

        if ($planstudy_hours != null){
            $studyPlan = $this->studyPlan->findByUser(auth()->user()->id);

            if($studyPlan != null) {
                $studyPlan->daily_time = $planstudy_hours;
                $studyPlan->save();
            } else {
                $studyPlan = new StudyPlan();
                $studyPlan->daily_time = $planstudy_hours;
                $studyPlan->user_id = auth()->user()->id;
                $studyPlan->save();
            }
        }

        if($request->from_cart == 1){
            return redirect()->route('cart.payment');
        }else {
            return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.profile_successfully_updated"));
        }
	}

    /**
     * @param $id
     * @param UserContract $user
     * @param UpdateProfileRequest $request
     * @return mixed
     */
    public function updateOccupation(UserStudentContract $userStudent, Request $request) {
        $userStudent->updateOccupation(auth()->user()->id, $request);

        return redirect()->route('frontend.dashboard');
    }

    public function dontAnswerSurvey(Request $request) {
        $surveyResponse = new SurveySimpleResponse();
        $surveyResponse->user_id = auth()->user()->id;
        $surveyResponse->survey_id = $request['survey'];
        $surveyResponse->response = "-";
        $surveyResponse->save();

        auth()->user()->last_data_update = Carbon::now();
        auth()->user()->save();


        return redirect()->route('frontend.dashboard');
    }

    public function answerSurvey(Request $request) {
        $surveyResponse = new SurveySimpleResponse();
        $surveyResponse->user_id = auth()->user()->id;
        $surveyResponse->survey_id = $request['survey'];

        $response = "\"" . $request['qst1'] . "\"," .
            "\"" . $request['qst2'] . "\"," .
            "\"" . $request['qst3'] . "\"," .
            "\"" . $request['qst4'] . "\"," .
            "\"" . $request['qst5'] . "\"," .
            "\"" . $request['qst6'] . "\"";

        $surveyResponse->response = $response;
        $surveyResponse->save();

        auth()->user()->last_data_update = Carbon::now();
        auth()->user()->save();

        return redirect()->route('frontend.dashboard');
    }

}