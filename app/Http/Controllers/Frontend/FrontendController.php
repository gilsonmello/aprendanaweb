<?php

namespace App\Http\Controllers\Frontend;

use App\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Banner\BannerContract;
use App\Repositories\Frontend\Subsection\SubsectionContract;
use App\Repositories\Frontend\Video\VideoContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Module\ModuleContract;
use App\Repositories\Frontend\Package\PackageContract;
use App\Repositories\Frontend\Section\SectionContract;
use App\Repositories\Frontend\Article\ArticleContract;
use App\Repositories\Frontend\News\NewsContract;
use App\Repositories\Frontend\User\UserContract;
use App\Repositories\Frontend\Slider\SliderContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller {

    public function __construct(UserContract $users, ArticleContract $articles, SectionContract $sections, CourseContract $courses, VideoContract $videos, SliderContract $sliders, NewsContract $news, ModuleContract $modules, BannerContract $banners, PackageContract $packages, SubsectionContract $subsections) {
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
        $this->subsections = $subsections;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index2017() {
        return view('frontend.2017.index', []);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index() {


        setlocale(LC_ALL, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');

        $teachers = $this->users->teachersfeatured()->shuffle()->take(6);
        $articles = $this->articles->getArticlesPaginated(8, 'activation_date', 'desc');
        $news = $this->news->getNewsPaginated(8, 'date', 'desc');
        $videos = $this->videos->getVideosPaginated(8, 'activation_date', 'desc');
        $sections = $this->sections->getSectionsPaginatedWithImg(4, 'sequence', 'asc');

        // $sliders = $this->sliders->getAllSliders();
        //$coursesFeatured = $this->courses->getFeatured(12)->shuffle()->take(8);
        // $coursesRelease = $this->courses->getRelease(8);
        //$coursesSpecialOffer = $this->courses->getSpecialOffer(12)->shuffle()->take(8);
        //$coursesRecommended = $this->courses->getRecommended(12)->take(8);
        //  $coursesBestSelling = $this->courses->getBestSelling(12)->take(8);

        $coursesCategorySet = Collect([]);
        //$coursesFirstCategory = $this->courses->getBySectionName('Combinadas e Isoladas',8)->shuffle()->take(3)->sortBy('featured');
        // $coursesSecondCategory = $this->courses->getBySectionName('Novo CPC',8)->shuffle()->take(3)->sortBy('featured');
        $coursesFirstCategory = $this->getRandomCoursesWithFeaturedFirst('Cursos de Programação');

        $coursesSecondCategory = $this->getRandomCoursesWithFeaturedFirst('Aperfeiçoamento e Extensão');
        $coursesThirdCategory = $this->getRandomCoursesWithFeaturedFirst('Exame OAB');

        $coursesCategorySet = $coursesCategorySet->push($coursesThirdCategory);
        $coursesCategorySet = $coursesCategorySet->push($coursesSecondCategory);
        $coursesCategorySet = $coursesCategorySet->push($coursesFirstCategory);
        //$coursesSecondCategory = $this->courses->getBySectionName('SAAP OAB',12)->shuffle()->take(4);
        //$newsSecondCategory = $this->news->getBySearch('SAAP OAB')->take(3);

        $banners = $this->banners->getAllBanners()/* ->shuffle()->take(2) */;
        $carousels = $this->banners->getAllBanners('order', 'asc', 1);
        $packages = $this->packages->getAllPackages()->shuffle()->take(6);
        $firstBanner = $banners->first();


        return view('frontend.index', compact(
                        'teachers', 'articles', 'sections', 'videos', 'news', 'coursesCategorySet', 'banners', 'firstBanner', 'carousels', 'packages'
        ));
    }

    public function getRandomCoursesWithFeaturedFirst($section_name) {

        $courses = $this->courses->getBySectionName($section_name, 8); //->shuffle();
        if ($courses->count() > 0) {
            if ($courses->take(4)->sortByDesc('featured')->first()->featured == 1) {
                return $courses->take(4)->sortByDesc('featured')->shuffle();
            } else {
                $featured_only = $courses->where('featured', 1);
                if ($featured_only->count() > 0) {
                    return $courses->take(4)->push($featured_only->first())->sortByDesc('featured')->shuffle();
                }
            }

            return $courses->take(4);
        }
    }

    /**
     * @param null $slug
     * @param null $section
     * @return $this
     */
    public function getCourseOrSection(Request $request, $sectionSlug = null, $slug = null, $active_tag = "") {

        $section = $this->sections->findBySlug($sectionSlug);

        /**
         * If found section
         */
        if (is_null($section)) {
            $section = $this->sections->findBySlug($slug);
        }


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
                return view('frontend.courses.index')
                                ->withCourses($courses_query->paginate(20))
                                ->withSections($this->sections->getAllSections())
                                ->withSectionSlug($section->slug)
                                ->withTitle($section->name)
                                ->withColor($section->color)
                                ->withTags($tags)->withSlug($slug)
                                ->withActive($active_tag)->withSection($section);
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

                return view('frontend.packages.index')
                                ->withPackages($epackages_query->paginate(20))
                                ->withSections($this->sections->getAllSections())
                                ->withTitle($section->name)
                                ->withTags($tags)
                                ->withColor($section->color)
                                ->withSlug($slug)
                                ->withActive($active_tag);
            }
        }

        //Caso Exita um slug
        if ($slug) {

            /**
             *  If found subsection
             */
            $subsection = $this->subsections->findBySlug($slug);
            $section = \App\Section::where('id', '=', $subsection->section_id)->first();


            if (count($subsection) > 0) {

                //Sem paginação inicialmente para pegarmos todas as tags.
                $courses_query = $subsection->courses(0);
                $courses = $courses_query->get();

                if ($active_tag !== "" && $active_tag !== null) {
                    $courses_query->where('tags', 'like', '%' . $active_tag . "%");
                }

                if (count($courses) != 0) {
                    //Redirecionando usuário para o curso, se a seção possuir somente 1 curso
                    if (count($courses) == 1) {
                        return redirect()->route('course-section-ga', [$section->slug, $courses[0]->slug]);
                    }
                    $tags = Collect([]);
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


                    $tags = $tags->sortBy(function($item, $key) {
                        return $key;
                    });

                    //A paginação entra aqui, de forma separada.
                    return view('frontend.courses.index')
                                    ->withSectionSlug($section->slug)
                                    ->withCourses($courses_query->paginate(20))
                                    ->withSections($this->sections->getAllSections())
                                    ->withTags($tags)
                                    ->withTitle($subsection->name)
                                    ->withColor($subsection->section->color)
                                    ->withSlug($slug)
                                    ->withActive($active_tag)
                                    ->withSection($subsection->section);
                } else {
                    $epackages_query = $subsection->packages(0);
                    $epackages = $epackages_query->get();
                    if ($active_tag !== "") {
                        $epackages_query->where('tags', 'like', '%' . $active_tag . "%");
                    }

                    $tags = Collect([]);

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

                    $tags = $tags->sortBy(function($item, $key) {
                        return $key;
                    });


                    return view('frontend.packages.index')->withPackages($epackages_query->paginate(20))
                                    ->withSections($this->sections->getAllSections())
                                    ->withTitle($subsection->name)
                                    ->withTags($tags)
                                    ->withColor($subsection->section->color)
                                    ->withSlug($slug)
                                    ->withActive($active_tag);
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
        } else {

            return redirect()->intended('/');
            ## REFATORAR ## REFATORAR## 
            #REFATORAR## REFATORAR## REFATORAR## REFATORAR## 
            #REFATORAR## REFATORAR## REFATORAR## REFATORAR## 
            #REFATORAR## REFATORAR## REFATORAR## REFATORAR## 
            #REFATORAR## REFATORAR## REFATORAR## REFATORAR## REFATORAR
//            $slug = $request->path();
//            //Pesquisando o Slug
//            $section = $this->sections->findBySlug($slug);
//            
//            //Recuperando os subsections associados
//
//            $courses = DB::table('courses as c')
//                    ->join('subsections as s', 'c.subsection_id', '=', 's.id')
//                    ->where('s.section_id', '=', $section->id)
//                    ->where('c.is_active', '=', 1)
//                    ->get();
//
//
//            //A paginação entra aqui, de forma separada.
//            return view('frontend.courses.index_of_section')
//                            ->withSectionSlug($slug)
//                            ->withCourses($courses)
//                            ->withSections($section)
//                            ->withTags([$slug])
//                            ->withTitle($slug)
//                            ->withColor($section->color)
//                            ->withSlug($slug)
//                            ->withActive([$slug])
//                            ->withSection($section);
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

    public function openTellAFriend() {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $suggestion_name = $_POST['title'];
        $route = $_SERVER['HTTP_REFERER'];

        return view('frontend.includes.tell-a-friend')->withId($id)->withType($type)->withRoute($route)->withSuggestionName($suggestion_name)->render();
    }

    public function sendToAFriend() {
        $type = $_POST['type'];
        $id = $_POST['type-id'];

        $object = null;
        $friends = explode(',', $_POST['friends']);


        if ($type == "curso") {
            $object = $this->courses->findOrThrowException($id);
            $this->courses->incrementClick($object, count($friends));
        } else {
            $object = $this->packages->findOrThrowException($id);
            $this->packages->incrementClick($object, count($friends));
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $route = $_POST['route'];
        $recommendation = $_POST['message'];

        foreach ($friends as $friend) {
            if (trim($friend) != "") {
                $friend = rtrim($friend, ',');

                Log::info($friend);
                Mail::send('emails.tell_a_friend', [
                    'name' => $name,
                    'email' => $email,
                    'friend' => $friend,
                    'route' => $route,
                    'recommendation' => $recommendation,
                        ], function($message) use ($friend, $name, $email) {
                    $message->from($email, $name);
                    $message->to($friend);
                    $message->subject($name . ' encontrou o que você procurava.');
                });
            }
        }

        return redirect($route);
    }

    /**
     * Carrega a tela com a listagem de cursos
     * @param type $subsection  //Subsessão do site
     * @param type $id
     * @return type
     */
    public function course($subsection = null, $id) {

        $course = $this->courses->findBySlug($id);

        if (count($course) == 0) {
            return redirect('/');
        }

        $course->teachers = $course->teachers->sortBy(function($objTeacher) {
            return $objTeacher->teacher->name;
        });

        $course->video_frag = parse_video($course->video_ad_url);

        $arrTags = explode(";", $course->tags);

        $query = 'AND (';
        $i = 0;
        foreach ($arrTags as $value => $tag) {
            if ($i == 0) {
                $query .= "courses.tags like '%" . $tag . "%' ";
            } else {
                $query .= "OR courses.tags like '%" . $tag . "%' ";
            }
            $i++;
        }
        $query .= ')';


        $related = DB::select(
                        DB::raw("
                SELECT courses.*, 
                    subsections.name as subsection_name,
                    sections.name as section_name,
                    sections.slug section_slug
                FROM courses 
                iNNER JOIN subsections ON subsections.id = courses.subsection_id
                INNER JOIN sections ON sections.id = subsections.section_id
                WHERE courses.is_active = 1 AND courses.id != $course->id $query
                ORDER BY RAND()
                LIMIT 4
            ")
        );

        foreach ($course->modules as $module) {
            $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule($module);
        }

        $course->modules = $course->modules->sortBy('sequence');


        $subsection = \App\Subsection::where('id', '=', $course->subsection_id)->first();

        return view('frontend.courses.show')
                        ->withCourse($course)
                        ->withRelatedcourses($related)
                        ->withSectionname($subsection);
    }

}
