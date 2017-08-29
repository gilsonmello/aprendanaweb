<?PHP

namespace App\Http\Controllers\Frontend;

use App\Enrollment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Access\LoginRequest;
use App\Preenrollment;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Section\SectionContract;
use App\Repositories\Frontend\Module\ModuleContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use App\CourseAggregatedExam;

/**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class CourseController extends Controller {

    /**
     * @param CourseContract $courses
     * @param SectionContract $sections
     */
    public function __construct(CourseContract $courses, SectionContract $sections, ModuleContract $module, Guard $auth) {
        $this->courses = $courses;
        $this->sections = $sections;
        $this->module = $module;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index() {
        $tags = [];
        $courses = \App\Course::join('subsections', 'subsections.id', '=', 'courses.subsection_id')
                ->where('subsection_id', '<>', '')
                ->paginate(12);

        $section = null;
        $section->slug = "-";

        return view('frontend.courses.index')
                        ->withCourses($courses)
                        ->withSections($this->sections->getAllSections())
                        ->withSubsectionSlug($section->slug)
                        ->withTitle('Cursos')
                        ->withSection(null)
                        ->withTags($tags);
    }

    /**
     * @return mixed
     */
    public function getReleases() {
        $courses = $this->courses->getRelease(12);

        return view('frontend.courses.index')
                        ->withCourses($courses)->withSections($this->sections->getAllSections())->withTitle('Lançamentos')->withSection(null);
    }

    /**
     * @return mixed
     */
    public function getSpecialOffers() {
        $courses = $this->courses->getSpecialOffer(12);
        return view('frontend.courses.index')
                        ->withCourses($courses)->withSections($this->sections->getAllSections())->withTitle('Promoções')->withSection(null);
    }

    /**
     * @return mixed
     */
    public function getRecommended() {
        $courses = $this->courses->getRecommended(12);
        return view('frontend.courses.index')
                        ->withCourses($courses)->withSections($this->sections->getAllSections())->withTitle('Recomendados')->withSection(null);
    }

    /**
     * @return mixed
     */
    public function getBestSelling() {
        $courses = $this->courses->getBestSelling(12);
        return view('frontend.courses.index')
                        ->withCourses($courses)->withSections($this->sections->getAllSections())->withTitle('Mais vendidos')->withSection(null);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id) {
        $course = $this->courses->findOrThrowException($id, true);
        $course->video_frag = parse_video($course->video_ad_url);

        $related = Course::where('id', '<>', $course->id)
                ->where('is_active', 1)
                ->where('activation_date', '<=', Carbon::now())
                ->where('subsection_id', $course->subsection_id)
                ->get()
                ->shuffle()
                ->take(4);

        foreach ($course->modules as $module) {
            $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule($module);
        }

        return view('frontend.courses.show')
                        ->withCourse($course)->withRelatedcourses($related);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function preenrollment($subscribe_key) {
        $preenrollments = Preenrollment::where('subscribe_key', '=', $subscribe_key)->get();

        if (count($preenrollments) != 0) {
            $preenrollment = $preenrollments[0];
        } else {
            $preenrollment = null;
        }

        return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function subscribe(Request $request) {
        $terms_accepted = $request['terms_accepted'];

        $password = $request['password'];
        $rpassword = $request['rpassword'];

        $subscribe_key = $request['subscribe_key'];
        $preenrollments = Preenrollment::where('subscribe_key', '=', $subscribe_key)->get();

        if (count($preenrollments) != 0) {
            $preenrollment = $preenrollments[0];
        } else {
            $preenrollment = null;
        }

        if ($terms_accepted != '1') {
            return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.terms_accepted"));
        }

        if (!$preenrollment->partnerorder->is_active) {
            return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.order_not_active"));
        }

        if ($preenrollment->partnerorder->total_enrollments <= $preenrollment->partnerorder->used_enrollments) {
            return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.total_enrollments_reached"));
        }

        if (Carbon::parse($preenrollment->date_deadline)->format('Y-m-d') < Carbon::now()->format('Y-m-d')) {
            return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.deadline"));
        }

        if (strlen($password) < 6) {
            return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.password_minimum_6_char"));
        }

        try {
            if (($preenrollment->student->confirmed != 1) || ($preenrollment->student->password == null) || ($preenrollment->student->password == '')) {
                if ($password != $rpassword) {
                    return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.password_different"));
                }

                if (($password == null) || ($password == '')) {
                    return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.password_empty"));
                }
                $preenrollment->student->password = $request['password'];
                $preenrollment->student->confirmed = 1;
                $preenrollment->student->status = 1;
                $preenrollment->student->save();

                $request['email'] = $preenrollment->student->email;
                if (!$this->auth->attempt($request->only('email', 'password'), $request->has('remember'))) {
                    return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.login_fail"));
                }
            } else {
                if (($password == null) || ($password == '')) {
                    return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.password_empty"));
                }

                try {
                    $request['email'] = $preenrollment->student->email;

                    if (!$this->auth->attempt($request->only('email', 'password'), $request->has('remember'))) {
                        return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.login_fail"));
                    }
                } catch (GeneralException $e) {
                    return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError($e->getMessage());
                }
            }

            \DB::beginTransaction();

            $enrollment = new Enrollment();
            $enrollment->order_id = null;
            $enrollment->student_id = $preenrollment->student_id;
            $enrollment->course_id = $preenrollment->course_id;
            $enrollment->date_begin = Carbon::now();
            $enrollment->date_end = Carbon::now()->addDays($preenrollment->course->access_time);
            $enrollment->is_active = 1;
            $enrollment->is_paid = 1;
            $enrollment->studentgroup_id = $preenrollment->studentgroup_id;
            $enrollment->partner_id = $preenrollment->partner_id;
            $enrollment->save();

            $preenrollment->course->orders_count = $preenrollment->course->orders_count + 1;
            $preenrollment->course->save();

            $preenrollment->partnerorder->used_enrollments = $preenrollment->partnerorder->used_enrollments + 1;
            $preenrollment->partnerorder->save();

            $preenrollment->date_activation = Carbon::now();
            $preenrollment->enrollment_id = $enrollment->id;
            $preenrollment->save();

            \DB::commit();

            return redirect()->route('frontend.dashboard');
        } catch (Exception $e) {
            \DB::rollback();
            return view('frontend.preenrollments.subscribe')->withPreenrollment($preenrollment)->withError(trans("alerts.preenrollments.error"));
        }
    }

}
