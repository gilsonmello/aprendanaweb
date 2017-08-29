<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ access()->user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form (Optional) -->
        <!--form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('strings.search_placeholder') }}"/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!--<li class="header">{{ trans('menus.general') }}</li>-->
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Active::pattern('admin/dashboard') }}"><a style="border-left-color: #51bc5d; color: white;" href="{!!route('backend.dashboard')!!}"><span><strong>{{ trans('menus.dashboard') }}</strong></span></a></li>

            {{-- Verificação para saber se o usuário logado é gerente de conveniado, mudo a aparência do menu lateral --}}
            @if(is_partner_manager())
                <li class="father_menu">
                    <a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_crm').css('display', 'block');  return false;">
                        <span>
                            <strong>{{ trans('menus.reports') }}</strong>
                        </span>
                    </a>
                </li>
                @if (access()->hasPermission('accompaniment'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/partnermanagers/accompaniment') }}">
                        <a href="{!!url('admin/partnermanagers/accompaniment')!!}">
                            <span>{{ trans('menus.accompaniment') }}</span>
                        </a>
                    </li>
                @endif
                @if (access()->hasPermission('partnermanager_execution_saap'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/partnermanagers/executionsaap') }}">
                        <a href="{!!url('admin/partnermanagers/executionsaap')!!}">
                            <span>{{ trans('menus.execution_saap') }}</span>
                        </a>
                    </li>
                @endif
                @if (access()->hasPermission('partnermanager_execution_saap'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/partnermanagers/perfomancesaap') }}">
                        <a href="{!!url('admin/partnermanagers/perfomancesaap')!!}">
                            <span>{{ trans('menus.execution_saap') }}</span>
                        </a>
                    </li>
                @endif
            {{-- Se o usuário não for gerente de conveniado, aparência do menu padrão --}}
            @else
                <li class="father_menu active active">
                    <a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_configuration').css('display', 'block');  return false;">
                        <span>
                            <strong>{{ trans('menus.config') }}</strong>
                        </span>
                    </a>
                </li>

                @if (access()->hasRole('Administrador'))
                    <li class="sub_menu sub_configuration {{ Active::pattern('admin/configurations/1/edit') }}"><a href="{!!url('admin/configurations/1/edit')!!}"><span>{{ trans('menus.config') }}</span></a></li>
                @endif
                @if (access()->hasRole('Administrador'))
                    <li class="sub_menu sub_configuration {{ Active::pattern('admin/access/*') }}"><a href="{!!url('admin/access/users')!!}"><span>{{ trans('menus.user_management') }}</span></a></li>
                @endif
                @if (access()->hasPermission('userteachers'))
                    <li class="sub_menu sub_configuration {{ Active::pattern('admin/userteachers*') }}"><a href="{!!url('admin/userteachers')!!}"><span>{{ trans('menus.user_teachers') }}</span></a></li>
                @endif
                @if (access()->hasPermission('processteacherstatements'))
                    <li class="sub_menu sub_configuration {{ Active::pattern('admin/processteacherstatements*') }}"><a href="{!!url('admin/processteacherstatements')!!}"><span>{{ trans('menus.processteacherstatements') }}</span></a></li>
                @endif
                @if (access()->hasPermission('enrollmentstest'))
                    <li class="sub_menu sub_configuration {{ Active::pattern('admin/enrollments/*-test') }}"><a href="{!!url('admin/enrollments/index-test')!!}"><span>{{ trans('menus.enrollments_test') }}</span></a></li>
                @endif
                @if (access()->hasPermission('enrollmentssaapincourse'))
                    <li class="sub_menu sub_configuration {{ Active::pattern('admin/enrollments/*-saapincourse') }}"><a href="{!!url('admin/enrollments/index-saapincourse')!!}"><span>{{ trans('menus.enrollments_saapincourse') }}</span></a></li>
                @endif

                <li class="father_menu">
                    <a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_crm').css('display', 'block');  return false;">
                        <span>
                            <strong>{{ trans('menus.crm') }}</strong>
                        </span>
                    </a>
                </li>
                @if (access()->hasPermission('userstudents'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/userstudents*') }}"><a href="{!!url('admin/userstudents')!!}"><span>{{ trans('menus.user_students') }}</span></a></li>
                @endif
                @if (access()->hasPermission('userrepresentatives'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/userrepresentatives*') }}"><a href="{!!url('admin/userrepresentatives')!!}"><span>{{ trans('menus.user_representatives') }}</span></a></li>
                @endif
                @if (access()->hasPermission('newsletters'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/newsletters*') }}"><a href="{!!url('admin/newsletters')!!}"><span>{{ trans('menus.newsletters') }}</span></a></li>
                @endif
                @if (access()->hasPermission('orders'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/orders*') }}"><a href="{!!url('admin/orders')!!}"><span>{{ trans('menus.orders') }}</span></a></li>
                @endif
                @if (access()->hasPermission('tickets'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/tickets*') }}"><a href="{!!url('admin/tickets')!!}"><span>{{ trans('menus.tickets') }}</span></a></li>
                @endif
                @if (access()->hasPermission('coupons'))
                    <li class="sub_menu sub_crm {{ Active::pattern('admin/coupons*') }}"><a href="{!!url('admin/coupons')!!}"><span>{{ trans('menus.coupons') }}</span></a></li>
                @endif

                {{-- Menu de Cursos --}}
                <li class="father_menu"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_course').css('display', 'block');  return false;"><span><strong>{{ trans('menus.course') }}</strong></span></a></li>

                @if (access()->hasPermission('courses'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/courses*') }}"><a href="{!!url('admin/courses')!!}"><span>{{ trans('menus.courses') }}</span></a></li>
                @endif
                @if (access()->hasPermission('courses'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/generaldiscount*') }}"><a href="{!!url('admin/generaldiscount')!!}"><span>{{ trans('menus.generaldiscount') }}</span></a></li>
                @endif
                @if (access()->hasPermission('coursealerts'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/coursealerts*') }}"><a href="{!!url('admin/coursealerts')!!}"><span>{{ trans('menus.coursealerts') }}</span></a></li>
                @endif
                @if (access()->hasPermission('coursecalendars'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/coursecalendars*') }}"><a href="{!!url('admin/coursecalendars')!!}"><span>{{ trans('menus.coursecalendars') }}</span></a></li>
                @endif
                @if (access()->hasPermission('asktheteachers'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/asktheteachers*') }}"><a href="{!!url('admin/asktheteachers')!!}"><span>{{ trans('menus.asktheteachers') }}</span></a></li>
                @endif
                @if (access()->hasPermission('content_comments'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/contentcomments*') }}"><a href="{!!url('admin/contentcomments')!!}"><span>{{ trans('menus.content_comments') }}</span></a></li>
                @endif
                {{-- Webinars --}}
                @if (access()->hasPermission('webinars'))
                    <li class="sub_menu sub_course {{ Active::pattern('admin/webinars*') }}">
                        <a href="{!!url('admin/webinars')!!}">
                            <span>{{ trans('menus.webinars.webinars') }}</span>
                        </a>
                    </li>
                @endif
                
                @if(isCoordinatorCourse() || access()->hasRole('Administrador'))
                    {{-- Menu Site --}}

                    <li class="sub_menu sub_course {{ Active::pattern('admin/enrollments*') }}">
                        <a href="{!!url('admin/enrollments')!!}">
                            <span>Liberar Certificação</span>
                        </a>
                    </li>
                @endif
                
                
                {{--@if (access()->hasPermission('modules'))--}}
                {{--<li class="{{ Active::pattern('admin/modules*') }}"><a href="{!!url('admin/modules')!!}"><span>{{ trans('menus.modules') }}</span></a></li>--}}
                {{--@endif--}}
                {{--@if (access()->hasPermission('lessons'))--}}
                {{--<li class="{{ Active::pattern('admin/lessons*') }}"><a href="{!!url('admin/lessons')!!}"><span>{{ trans('menus.lessons') }}</span></a></li>--}}
                {{--@endif--}}

                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_exams').css('display', 'block');  return false;"><span><strong>{{ trans('menus.exams') }}</strong></span></a></li>

                @if (access()->hasPermission('exams'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/exams*') }}"><a href="{!!url('admin/exams')!!}"><span>{{ trans('menus.exams') }}</span></a></li>
                @endif
                @if (access()->hasPermission('questions'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/questions*') }}"><a href="{!!url('admin/questions')!!}"><span>{!! trans('menus.questions') !!}</span></a></li>
                @endif
                @if (access()->hasPermission('packages'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/packages*') }}"><a href="{!!url('admin/packages')!!}"><span>{{ trans('menus.packages') }}</span></a></li>
                @endif
                @if (access()->hasPermission('subjects'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/subjects*') }}"><a href="{!!url('admin/subjects')!!}"><span>{{ trans('menus.subjects') }}</span></a></li>
                @endif
                @if (access()->hasPermission('sources'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/sources*') }}"><a href="{!!url('admin/sources')!!}"><span>{{ trans('menus.sources') }}</span></a></li>
                @endif
                @if (access()->hasPermission('institutions'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/institutions*') }}"><a href="{!!url('admin/institutions')!!}"><span>{{ trans('menus.institutions') }}</span></a></li>
                @endif
                @if (access()->hasPermission('offices'))
                    <li class="sub_menu sub_exams {{ Active::pattern('admin/offices*') }}"><a href="{!!url('admin/offices')!!}"><span>{{ trans('menus.offices') }}</span></a></li>
                @endif

                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_workshop').css('display', 'block');  return false;"><span><strong>{{ trans('menus.workshops') }}</strong></span></a></li>
                @if (access()->hasPermission('workshops'))
                    <li class="sub_menu sub_workshop {{ Active::pattern('admin/workshops*') }}"><a href="{!!url('admin/workshops')!!}"><span>{{ trans('menus.workshops') }}</span></a></li>
                @endif
                @if (access()->hasPermission('workshopevaluations'))
                    <li class="sub_menu sub_workshop {{ Active::pattern('admin/myworkshopevaluations*') }}"><a href="{!!url('admin/myworkshopevaluations')!!}"><span>{{ trans('menus.workshopevaluations') }}</span></a></li>
                @endif

                @if (access()->hasPermission('asktheteachers'))
                    <li class="sub_menu sub_workshop {{ Active::pattern('admin/askthetutors*') }}"><a href="{!!url('admin/askthetutors/index')!!}"><span>{{ trans('menus.asktheteachers') }}</span></a></li>
                @endif
                @if (access()->hasPermission('tutorsthestudents'))
                    <li class="sub_menu sub_workshop {{ Active::pattern('admin/myworkshoptutors/tutorsthestudents*') }}"><a href="{!!url('admin/myworkshoptutors/tutorsthestudents')!!}"><span>{{--{{ trans('menus.asktheteachers') }}--}}Tutores de Alunos</span></a></li>
                @endif
                {{--@if (access()->hasPermission('changetutor'))--}}
                {{--<li class="sub_menu sub_workshop {{ Active::pattern('admin/changetutor*') }}"><a href="{!!url('admin/changetutor')!!}"><span>{{ trans('menus.changetutor') }}</span></a></li>--}}
                {{--@endif--}}


               <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_analysis').css('display', 'block');  return false;"><span><strong>{{ trans('menus.analysis') }}</strong></span></a></li>

                @if (access()->hasPermission('analysisexamgroups'))
                    <li class="sub_menu sub_analysis {{ Active::pattern('admin/analysisexamgroups*') }}"><a href="{!!url('admin/analysisexamgroups')!!}"><span>{{ trans('menus.analysisexamgroups') }}</span></a></li>
                @endif
                @if (access()->hasPermission('analysis'))
                    <li class="sub_menu sub_analysis {{ Active::pattern('admin/analysiss*') }}"><a href="{!!url('admin/analysiss')!!}"><span>{{ trans('menus.analysis') }}</span></a></li>
                @endif
                @if (access()->hasPermission('analysisexams'))
                    <li class="sub_menu sub_analysis {{ Active::pattern('admin/analysisexams*') }}"><a href="{!!url('admin/analysisexams')!!}"><span>{{ trans('menus.analysisexams') }}</span></a></li>
                @endif


                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_content').css('display', 'block');  return false;"><span><strong>{{ trans('menus.content') }}</strong></span></a></li>
                @if (access()->hasPermission('articles'))
                    <li class="sub_menu sub_content {{ Active::pattern('admin/articles*') }}"><a href="{!!url('admin/articles')!!}"><span>{{ trans('menus.articles') }}</span></a></li>
                @endif
                @if (access()->hasPermission('videos'))
                    <li class="sub_menu sub_content {{ Active::pattern('admin/videos*') }}"><a href="{!!url('admin/videos')!!}"><span>{{ trans('menus.videos') }}</span></a></li>
                @endif
                @if (access()->hasPermission('news'))
                    <li class="sub_menu sub_content {{ Active::pattern('admin/news*') }}"><a href="{!!url('admin/news')!!}"><span>{{ trans('menus.news') }}</span></a></li>
                @endif

                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_partner').css('display', 'block');  return false;"><span><strong>{{ trans('menus.partners') }}</strong></span></a></li>
                @if (access()->hasPermission('partners'))
                    <li class="sub_menu sub_partner {{ Active::pattern('admin/partners*') }}"><a href="{!!url('admin/partners')!!}"><span>{{ trans('menus.partners') }}</span></a></li>
                @endif
                @if (access()->hasPermission('partnerorders'))
                    <li class="sub_menu sub_partner {{ Active::pattern('admin/partnerorders*') }}"><a href="{!!url('admin/partnerorders')!!}"><span>{{ trans('menus.partnerorders') }}</span></a></li>
                @endif
                @if (access()->hasPermission('studentgroups'))
                    <li class="sub_menu sub_partner {{ Active::pattern('admin/studentgroups*') }}"><a href="{!!url('admin/studentgroups')!!}"><span>{{ trans('menus.studentgroups') }}</span></a></li>
                @endif
                @if (access()->hasPermission('preenrollments'))
                    <li class="sub_menu sub_partner {{ Active::pattern('admin/preenrollments*') }}"><a href="{!!url('admin/preenrollments')!!}"><span>{{ trans('menus.preenrollments') }}</span></a></li>
                @endif

                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_reference').css('display', 'block');  return false;"><span><strong>{{ trans('menus.reference') }}</strong></span></a></li>
                @if (access()->hasPermission('advertisingpartners'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/advertisingpartners*') }}"><a href="{!!url('admin/advertisingpartners')!!}"><span>{{ trans('menus.advertisingpartners') }}</span></a></li>
                @endif
                @if (access()->hasPermission('tags'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/tags*') }}"><a href="{!!url('admin/tags')!!}"><span>{{ trans('menus.tags') }}</span></a></li>
                @endif
                @if (access()->hasPermission('sections'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/sections*') }}"><a href="{!!url('admin/sections')!!}"><span>{{ trans('menus.sections') }}</span></a></li>
                @endif
                @if (access()->hasPermission('subsections'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/subsections*') }}"><a href="{!!url('admin/subsections')!!}"><span>{{ trans('menus.subsections') }}</span></a></li>
                @endif
                @if (access()->hasPermission('sectors'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/sectors*') }}"><a href="{!!url('admin/sectors')!!}"><span>{{ trans('menus.sectors') }}</span></a></li>
                @endif
                @if (access()->hasPermission('occupations'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/occupations*') }}"><a href="{!!url('admin/occupations')!!}"><span>{{ trans('menus.occupations') }}</span></a></li>
                @endif
                @if (access()->hasPermission('cities'))
                    <li class="sub_menu sub_reference {{ Active::pattern('admin/cities*') }}"><a href="{!!url('admin/cities')!!}"><span>{{ trans('menus.cities') }}</span></a></li>
                @endif

                {{-- Menu Relatórios --}}
                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_reports').css('display', 'block');  return false;"><span><strong>{{ trans('menus.reports') }}</strong></span></a></li>

                {{-- Extrato do Professor --}}
                @if (access()->hasPermission('teacherstatements'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/teacherstatements*') }}"><a href="{!!url('admin/teacherstatements')!!}"><span>{{ trans('menus.teacherstatements') }}</span></a></li>
                @endif

                {{-- Estatística --}}
                @if (access()->hasPermission('stats'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/stats/*') }}"><a href="{!!url('admin/stats/coursesrank')!!}"><span>{{ trans('menus.stats') }}</span></a></li>
                @endif

                {{-- Relatório de Estatística de Vendas --}}
                @if (access()->hasPermission('coursereports'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/coursereports/*') }}"><a href="{!!url('admin/coursereports/sales')!!}"><span>{{ trans('menus.course_sales') }}</span></a></li>
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/coursereports/*') }}"><a href="{!!url('admin/coursereports/stats')!!}"><span>{{ trans('menus.course_stats') }}</span></a></li>
                @endif

                {{-- Relatório de Pagamentos a Professores --}}
                @if (access()->hasPermission('teacherpaymentreports'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/teacherpaymentreports/*') }}"><a href="{!!url('admin/teacherpaymentreports/index')!!}"><span>{{ trans('menus.teacher_payment') }}</span></a></li>
                @endif

                {{-- Relatório --}}
                @if (access()->hasPermission('studentreports'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/studentreports/index') }}">
                        <a href="{!!url('admin/studentreports/index')!!}">
                            <span>{{ trans('menus.student_performance') }}</span>
                        </a>
                    </li>
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/studentreports/saap') }}">
                        <a href="{!!url('admin/studentreports/saap')!!}">
                            <span>{{ trans('menus.execution_saap') }}</span>
                        </a>
                    </li>
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/studentreports/demographics') }}">
                        <a href="{!!url('admin/studentreports/demographics')!!}">
                            <span>{{ trans('menus.student_demographics') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Relatório de Questões de SAAP --}}
                @if (access()->hasPermission('report_questions'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/questions/reports') }}">
                        <a href="{!!url('admin/questions/reports')!!}">
                            <span>{{ trans('menus.questions_saap') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Relatório de Atividades --}}
                @if (access()->hasPermission('activities_report'))
                    <li class="sub_menu sub_reports {{ Active::pattern('admin/workshopactivitys/activitiesreport') }}">
                        <a href="{!!url('admin/workshopactivitys/activitiesreport')!!}">
                            <span>{{ trans('menus.activities_report') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Menu Site --}}
                <li class="father_menu active"><a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_site').css('display', 'block'); return false;"><span><strong>{{ trans('menus.site') }}</strong></span></a></li>
                @if (access()->hasPermission('faq_category'))
                    <li class="sub_menu sub_site {{ Active::pattern('admin/faqcategory*') }}"><a href="{!!url('admin/faqcategory')!!}"><span>{{ trans('menus.faq_category') }}</span></a></li>
                @endif
                @if (access()->hasPermission('faqs'))
                    <li class="sub_menu sub_site {{ Active::pattern('admin/faqs*') }}"><a href="{!!url('admin/faqs')!!}"><span>{{ trans('menus.faqs') }}</span></a></li>
                @endif
                @if (access()->hasPermission('sliders'))
                    <li class="sub_menu sub_site {{ Active::pattern('admin/sliders*') }}"><a href="{!!url('admin/sliders')!!}"><span>Slider</span></a></li>
                @endif
                @if (access()->hasPermission('banners'))
                    <li class="sub_menu sub_site {{ Active::pattern('admin/banners*') }}"><a href="{!!url('admin/banners')!!}"><span>Banner</span></a></li>
                @endif
                
                {{-- 
                Menu Site 
                <li class="father_menu active">
                    <a style="border-left-color: #51bc5d; color: white;" href="#" onclick="javascript: $('.sub_menu').css('display', 'none'); $('.sub_book_store').css('display', 'block'); return false;">
                        <span>
                            <strong>{{ trans('menus.site') }} </strong>
                        </span>
                    </a>
                </li>
                
                
                Refatorar.: Alterar o nome da permissão 
                @if (access()->hasPermission('faq_category'))
                    <li class="sub_menu sub_book_store {{ Active::pattern('admin/faqcategory*') }}"><a href="{!!url('admin/suppliers')!!}"><span>{{ trans('menus.faq_category') }}</span></a></li>
                @endif

                Refatorar.: Alterar o nome da permissão 
                @if (access()->hasPermission('faq_category'))
                    <li class="sub_menu sub_book_store {{ Active::pattern('admin/faqcategory*') }}">
                        <a href="{!!url('admin/products')!!}">
                            <span>{{ trans('menus.faq_category') }}</span>
                        </a>
                    </li>
                @endif
                
                --}}

            @endif

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
