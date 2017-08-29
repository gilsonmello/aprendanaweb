<?php

namespace App\Http\Controllers\Frontend;

use App\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Banner\BannerContract;
use App\Repositories\Frontend\Video\VideoContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Module\ModuleContract;
use App\Repositories\Frontend\Package\PackageContract;
use App\Repositories\Frontend\Section\SectionContract;
use App\Repositories\Frontend\Article\ArticleContract;
use App\Repositories\Frontend\News\NewsContract;
use App\Repositories\Frontend\User\UserContract;
use App\Repositories\Frontend\Slider\SliderContract;
use App\Repositories\Frontend\User\UserTeacherContract;
use App\Repositories\Frontend\CourseTeacher\CourseTeacherContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Frontend\ContactUs\ContactUsRequest;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class PublicSectorController extends Controller {

    public function __construct(UserContract $users, ArticleContract $articles, SectionContract $sections, CourseContract $courses, VideoContract $videos, SliderContract $sliders, NewsContract $news, ModuleContract $modules, BannerContract $banners, PackageContract $packages, UserTeacherContract $teachers, CourseTeacherContract $courseteachers) {
        $this->users = $users;
        $this->articles = $articles;
        $this->sections = $sections;
        $this->courses = $courses;
        $this->videos = $videos;
        $this->sliders = $sliders;
        $this->news = $news;
        $this->modules = $modules;
        $this->banners = $banners;
        $this->packages = $packages;
        $this->teachers = $teachers;
        $this->courseteachers = $courseteachers;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index() {

        setlocale(LC_ALL, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');

        $teachers = $this->getUserTeachersPaginated(24, 'Gestão Pública', null)->shuffle()->take(6);

        $PUBLICSECTOR_DOMAIN = 1;
        $news = $this->news->getNewsPaginated(8, 'date', 'desc', null, null, $PUBLICSECTOR_DOMAIN);

        $coursesCategorySet = Collect([]);
        $coursesFirstCategory = $this->getRandomCoursesWithFeaturedFirst('Gestão Pública');
        $coursesCategorySet = $coursesCategorySet->push($coursesFirstCategory);

        $banners = $this->banners->getAllBanners()->shuffle()->take(2);

        return view('frontend.publicsector.index', compact(
                        'teachers', 'articles', 'sections', 'videos', 'news', 'coursesCategorySet', 'banners', 'packages'
        ));
    }

    public function getRandomCoursesWithFeaturedFirst($section_name) {
        $courses = $this->courses->getBySectionName($section_name, 8)->shuffle();
        if ($courses->count() > 0) {
            if ($courses->take(3)->sortByDesc('featured')->first()->featured == 1) {
                return $courses->take(3)->sortByDesc('featured');
            } else {
                $featured_only = $courses->where('featured', 1);
                if ($featured_only->count() > 0) {
                    return $courses->take(2)->push($featured_only->first())->sortByDesc('featured');
                }
            }

            return $courses->take(3);
        }
    }

    public function courses(Request $request, $slug = null, $active_tag = "") {

        $section = $this->sections->findOrThrowException(23);

        if ($active_tag == "") {
            $active_tag = $request['tag'];
        }

        if (count($section) > 0) {
            //Sem paginação inicialmente para pegarmos todas as tags.
            $courses_query = $section->courses(0, 'asc');

            if ($active_tag !== "" && $active_tag !== null) {
                $courses_query->where('tags', 'like', '%' . $active_tag . "%");
            }
            $courses = $courses_query->get();
            if (count($courses) != 0) {
                $tags = Collect([]);

                if ($section->show_tag_cloud == true) {
                    foreach ($courses as $course) {

                        $course_tags = $course->tags;

                        if ($course_tags != null && $course_tags != '') {

                            $course_tags = explode(";", $course_tags);

                            foreach ($course_tags as $tag) {
                                if (isset($tags[$tag])) {
                                    $tags[$tag] = $tags[$tag] + 1;
                                } else {
                                    $tags[$tag] = 1;
                                }
                            }
                        }
                    }
                }

                $tags = $tags->sortBy(function($item, $key) {
                    return $key;
                });

                //A paginação entra aqui, de forma separada.
                return view('frontend.publicsector.courses.index')->withCourses($courses_query->paginate(20))->
                                withSections($this->sections->getAllSections())->withTitle($section->name)->
                                withColor($section->color)->withTags($tags)->withSlug($slug)->withActive($active_tag)->withSection($section);
            }
        }

        return redirect()->intended('/gestaopublica');
    }

    public function course(Request $request, $slug = null, $active_tag = "") {
        $course = $this->courses->findBySlug($slug);

        if (count($course) > 0) {
            $course->teachers = $course->teachers->sortBy(function($objTeacher) {
                return $objTeacher->teacher->name;
            });

            $course->video_frag = parse_video($course->video_ad_url);

            $related = Course::where('id', '<>', $course->id)->where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('subsection_id', $course->subsection_id)->orderBy('activation_date', 'DESC')->get()->shuffle()->take(4);

            foreach ($course->modules as $module) {
                $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule($module);
            }

            $count = 1;
            if ($request['count'] != null) {
                $count = $request['count'];
            }

            return view('frontend.publicsector.courses.show')
                            ->withCourse($course)
                            ->withRelatedcourses($related)
                            ->withCount($count);
        }
    }

    public function cartItems(Request $request) {
        $items = session('publicsector.cart');

        if (count($items) == 0) {
            return $this->courses($request);
        } else {
            return view('frontend.publicsector.cart.items')->withItems($items);
        }
    }

    public function cartAdd(Request $request) {
        $course = $this->courses->findOrThrowException($request['course']);

        $items = session('publicsector.cart');
        if ($items == null) {
            $items = [$course->id => ['course' => $course->id, 'title' => $course->title, 'img' => $course->featured_img, 'count' => $request['count'], 'slug' => $course->slug]];
        } else {
            $items[$course->id] = ['course' => $course->id, 'title' => $course->title, 'img' => $course->featured_img, 'count' => $request['count'], 'slug' => $course->slug];
        }
        session(['publicsector.cart' => $items]);

        //return view('frontend.publicsector.cart.items')->withItems($items);
        return view('frontend.publicsector.cart.contact')->withItems($items);
    }

    public function cartRemove(Request $request) {
        $items = session('publicsector.cart');
        if ($items != null) {
            unset($items[$request['course']]);
        }
        session(['publicsector.cart' => $items]);

        if (count($items) == 0) {
            return $this->courses($request);
        } else {
            return view('frontend.publicsector.cart.items')->withItems($items);
        }
    }

    public function cartContact(Request $request) {
        $items = session('publicsector.cart');
        if (count($items) == 0) {
            return redirect()->intended('/gestaopublica');
        } else {
            return view('frontend.publicsector.cart.contact')->withItems($items);
        }
    }

    public function cartSend(Request $input) {

        $nameFrom = $input['name'];
        $emailFrom = $input['email'];
        $phoneFrom = $input['phone'];
        $celFrom = $input['cel'];
        $number = $input['number'];
        $organizationFrom = $input['organization'];
        $obsFrom = $input['obs'];

        $items = session('publicsector.cart');

        Mail::send('emails.publicsector', ['from_name' => $nameFrom,
            'from_email' => $emailFrom,
            'from_phone' => $phoneFrom,
            'from_organization' => $organizationFrom,
            'from_obs' => $obsFrom,
            'from_obs' => $obsFrom,
            'from_cel' => $celFrom,
            'number' => $number,
            'items' => $items
                ], function($message) use ($emailFrom, $nameFrom ) {
            $message->to('gestaopublica@brasiljuridico.com.br', 'Gestão Pública');
            $message->to('mariana@brasiljuridico.com.br', 'Mariana');
            $message->to('adhemarfontes@gmail.com', 'Adhemar');
//            $message->replyTo($emailFrom, $nameFrom);
            $message->subject(app_name() . ' | Gestão Pública Solicitação de Orçamento');
        });

        return view('frontend.publicsector.cart.contact_success');

        throw new GeneralException('Problema no envio do e-mail.');
    }

    /**
     * @return mixed
     */
    public function teachers(Request $request) {
        $f_submit = $request->input('f_submit', '');
        $f_search = get_parameter_or_session($request, 'f_search', '', $f_submit, '');
        $f_social = get_parameter_or_session($request, 'f_social', '', $f_submit, '');

        $teachers = $this->getUserTeachersPaginated(24, 'Gestão Pública', $f_social);

        return view('frontend.publicsector.teachers.index')
                        ->withTeachers($teachers)
                        ->withSearch($f_search);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function teacher($id) {

        $teacher = $this->teachers->findBySlug($id);



        if ($teacher == null) {
            $teacher = $this->teachers->findOrThrowException($id);
        }

        $teacher->video_frag = parse_video($teacher->video);

        $coursesrelated = $this->courseteachers->getAllCourseTeachersPerTeacher($teacher->id);
        $collectionCourse = new Collection($coursesrelated);
        $collectionCourse = $collectionCourse->sortByDesc(function($item) {
            return $item->course->orders_count;
        });



        return view('frontend.publicsector.teachers.show')
                        ->withTeacher($teacher)
                        ->withCoursesrelated($collectionCourse->slice(0, 4));
    }

    public function institutional() {
        return view('frontend.publicsector.institutional.index');
    }

    public function contract() {
        return view('frontend.publicsector.institutional.contract');
    }

    public function advantages() {
        return view('frontend.publicsector.institutional.advantages');
    }

    public function certification() {
        return view('frontend.publicsector.institutional.certification');
    }

    /*     * ******************************************************* */

    /**
     * @param null $slug
     * @return $this
     */
    public function getCourseOrSection(Request $request, $slug = null, $active_tag = "") {

        /**
         * If found section
         */
        $section = $this->sections->findBySlug($slug);

        if ($active_tag == "") {
            $active_tag = $request['tag'];
        }

        if (count($section) > 0) {

            //Sem paginação inicialmente para pegarmos todas as tags.
            $courses_query = $section->courses(0);
            $courses = $courses_query->get();
            if ($active_tag !== "" && $active_tag !== null) {
                $courses_query->where('tags', 'like', '%' . $active_tag . "%");
            }



            if (count($courses) != 0) {



                $tags = Collect([]);

                if ($section->show_tag_cloud == true) {
                    foreach ($courses as $course) {

                        $course_tags = $course->tags;

                        if ($course_tags != null && $course_tags != '') {

                            $course_tags = explode(";", $course_tags);

                            foreach ($course_tags as $tag) {
                                if (isset($tags[$tag])) {
                                    $tags[$tag] = $tags[$tag] + 1;
                                } else {
                                    $tags[$tag] = 1;
                                }
                            }
                        }
                    }
                }

                $tags = $tags->sortBy(function($item, $key) {
                    return $key;
                });





                //A paginação entra aqui, de forma separada.
                return view('frontend.courses.index')->withCourses($courses_query->paginate(20))->
                                withSections($this->sections->getAllSections())->withTitle($section->name)->
                                withColor($section->color)->withTags($tags)->withSlug($slug)->withActive($active_tag)->withSection($section);
            } else {


                $epackages_query = $section->packages(0);
                $epackages = $epackages_query->get();
                if ($active_tag !== "") {
                    $epackages_query->where('tags', 'like', '%' . $active_tag . "%");
                }

                $tags = Collect([]);

                if ($section->show_tag_cloud == true) {
                    foreach ($epackages as $package) {
                        $package_tags = $package->tags;
                        if ($package_tags != null && $package_tags != '') {
                            $package_tags = explode(";", $package_tags);

                            foreach ($package_tags as $tag) {
                                if (isset($tags[$tag])) {
                                    $tags[$tag] = $tags[$tag] + 1;
                                } else {
                                    $tags[$tag] = 1;
                                }
                            }
                        }
                    }
                }


                $tags = $tags->sortBy(function($item, $key) {
                    return $key;
                });



                return view('frontend.packages.index')->withPackages($epackages_query->paginate(20))->
                                withSections($this->sections->getAllSections())->withTitle($section->name)->withTags($tags)->
                                withColor($section->color)->withSlug($slug)->withActive($active_tag);
            }
        }

        /**
         * If found course
         */
        $course = $this->courses->findBySlug($slug);

        if (count($course) > 0) {
            $course->teachers = $course->teachers->sortBy(function($objTeacher) {
                return $objTeacher->teacher->name;
            });

            $course->video_frag = parse_video($course->video_ad_url);

            $related = Course::where('id', '<>', $course->id)->where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('subsection_id', $course->subsection_id)->get()->shuffle()->take(4);

            foreach ($course->modules as $module) {
                $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule($module);
            }

            return view('frontend.courses.show')->withCourse($course)->withRelatedcourses($related);
        }

//        return redirect()->intended('auth/login');
        return redirect()->intended('/');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros() {
        return view('frontend.macros');
    }

    public function analysis() {
        return view('frontend.analysis');
    }

    public function exameOab() {

        $course1 = $this->courses->findOrThrowException(465);
        $course2 = $this->courses->findOrThrowException(423);
        $course3 = $this->courses->findOrThrowException(340);

        $courses = [$course1, $course2, $course3];

        $package1 = $this->packages->findOrThrowException(27);
        $package2 = $this->packages->findOrThrowException(30);
        $package3 = $this->packages->findOrThrowException(28);

        $packages = [$package1, $package2, $package3];

        return view('frontend.exame-oab')->withCourses($courses)->withPackages($packages);
    }

    public function passaporteOab() {

        $courses = Course::where('title', 'like', 'CE | Exame OAB |%')->where('is_active', 1)->where('activation_date', '<=', Carbon::now())->orderBy("activation_date", "desc")->get();
        return view('frontend.passaporte-oab')->withCourses($courses);
    }

    public function indexNews() {
        $PUBLICSECTOR_DOMAIN = 1;

        $featured_news = $this->news->getFeaturedNewsByDomain($PUBLICSECTOR_DOMAIN)->take(3);
        $except_ids = $featured_news->pluck('id');

        $news = $this->news->getNewsPaginated(10, 'activation_date', 'desc', $except_ids, null, $PUBLICSECTOR_DOMAIN);

        return view('frontend.publicsector.news.index')
                        ->withNews($news)->withFeatureds($featured_news);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function showNews($id) {

        $news = $this->news->findOrThrowException($id, true);
        $news->hits = $news->hits + 1;
        $news->save();
        $news->video_frag = parse_video($news->video);

        $tags = $news->tags;
        if ($tags != null && $tags != '') {
            $tags = explode(";", $tags);
        }

        $PUBLICSECTOR_DOMAIN = 1;
        $more_news = $this->news->getFeaturedNewsByDomain($PUBLICSECTOR_DOMAIN);

        $section = $this->sections->findOrThrowException(23);
        $courses_query = $section->courses(0);
        $more_courses = $courses_query->get();

//        $more_courses = Collect([]);
//
//        if ($tags != '') {
//            foreach ($tags as $tag) {
//                if ($courses_remaining > 0) {
//                    $more_courses = $more_courses->merge($this->courses->getBySearch($tag)->diff($more_courses));
//                    $courses_remaining = $courses_remaining - $more_courses->count();
//                }
//            }
//        }
//        if ($courses_remaining > 0) {
//            $more_courses = $more_courses->merge($this->courses->getFeatured()->take($courses_remaining)->diff($more_courses));
//        }

        return view('frontend.publicsector.news.show')
                        ->withNews($news)->withMoreNews($more_news->take(3))->withMoreCourses($more_courses->take(2));
    }

    public function terms() {
        return view('frontend.publicsector.institutional.terms');
    }

    public function ondemand() {
        return view('frontend.publicsector.institutional.ondemand');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getUserTeachersPaginated($per_page, $search, $social, $order_by = 'name', $sort = 'asc') {

        $query = User::teachers();

        if ((isset($search)) && ($search != '')) {
            $query->where('name', 'like', '%' . $search . '%');
            $query->orWhere('tags', 'like', '%' . $search . '%');
        }

        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @return mixed
     */
    public function contactUs() {
        return view('frontend.publicsector.contactus.index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function send(ContactUsRequest $request) {
        if($this->answered($request->all())){
            return redirect()->back()->withFlashSuccess(trans("alerts.contactus.send"));
        }
        return redirect()->back()->withFlashDanger(trans("alerts.contactus.send_error"));
    }

    public function answered($input) {

        $emailFrom = $input['email'];
        $nameFrom = $input['name'];

        try{
            Mail::send('emails.publicsector_contact_us', ['from_name' => $nameFrom,
                'from_email' => $emailFrom,
                'reply_message' => $input['message']
                    ], function($message) use ($emailFrom, $nameFrom ) {
                $message->to([
                    "gestaopublica@brasiljuridico.com.br", 
                    "adhemarfontes@gmail.com", 
                    "mariana@brasiljuridico.com.br"
                ], "BrJ Gestão Pública");
                $message->replyTo($emailFrom, $nameFrom);
                $message->subject("BrJ Gestão Pública :: Fale Conosco");
            });
            return true;
        }catch(Exception $e){
            return false;
        }
    }

}
