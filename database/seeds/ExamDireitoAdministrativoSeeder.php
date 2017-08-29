<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ExamDireitoAdministrativoSeeder extends Seeder {

        public function run() {

                if(env('DB_DRIVER') == 'mysql')
                        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                $package = App\Package::where('title', 'like', 'OAB - Direito Administrativo')->get()->first();
                if ($package == null) {
                        $package = new App\Package;
                        $package->title = 'OAB - Direito Administrativo';
                        $package->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $package->video_ad_url = null;
                        $package->activation_date = Carbon::now();
                        $package->price = 80;
                        $package->discount_price = 65;
                        $package->start_special_price = null;
                        $package->end_special_price = null;
                        $package->special_price = null;
                        $package->subsection_id = 9;
                        $package->created_at = Carbon::now();
                        $package->updated_at = Carbon::now();
                        $package->deleted_at = null;
                        $package->tags = null;
                        $package->is_active = 1;
                        $package->slug = 'saap-oab-direito-administrativo';
                        $package->access_time = 120;
                        $package->teachers_percentage = 30;
                        $package->save();
                }

                $exam = App\Exam::where('title', 'like', 'OAB - Direito Administrativo')->get()->first();
                if ($exam == null) {
                        $exam = new App\Exam;
                        $exam->title = 'OAB - Direito Administrativo';
                        $exam->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $exam->subsection_id = 9;
                        $exam->slug = 'saap-oab-direito-administrativo';
                        $exam->tags = null;
                        $exam->is_active = 1;
                        $exam->max_tries = 2;
                        $exam->course_id = null;
                        $exam->created_at = Carbon::now();
                        $exam->updated_at = Carbon::now();
                        $exam->deleted_at = null;
                        $exam->explanation = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $exam->time_by_question = null;
                        $exam->subsection_id = 9;
                        $exam->required_reading = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $exam->additional_reading = null;
                        $exam->note1 = null;
                        $exam->note2 = null;
                        $exam->note3 = null;
                        $exam->note4 = null;
                        $exam->duration = 120;
                        $exam->questions_count = 30;
                        $exam->minimum_percentage = 70;
                        $exam->display_explanation = 1;
                        $exam->featured_img = null;
                        $exam->teacher_message_id = 2543;
                        $exam->save();

                        $exam_package = new App\ExamPackage;
                        $exam_package->package_id = $package->id;
                        $exam_package->exam_id = $exam->id;
                        $exam_package->created_at = Carbon::now();
                        $exam_package->updated_at = Carbon::now();
                        $exam_package->deleted_at = null;
                        $exam_package->save();
                }

                $group = App\Group::where('title', 'like', 'OAB - Direito Administrativo')->get()->first();
                if ($group == null) {
                        $group = new App\Group;
                        $group->title = 'Direito Administrativo';
                        $group->answer_type = '';
                        $group->is_random = false;
                        $group->exam_id = $exam->id;
                        $group->weight = 1;
                        $group->created_at = Carbon::now();
                        $group->updated_at = Carbon::now();
                        $group->deleted_at = null;
                        $group->save();
                }


                $subjectGrandFather = App\Subject::where('name', 'like', 'Direito Administrativo')->get()->first();
                if ($subjectGrandFather == null) {
                        $subjectGrandFather = new App\Subject;
                        $subjectGrandFather->name = 'Direito Administrativo';
                        $subjectGrandFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectGrandFather->created_at = Carbon::now();
                        $subjectGrandFather->updated_at = Carbon::now();
                        $subjectGrandFather->deleted_at = null;
                        $subjectGrandFather->subject_id = null;
                        $subjectGrandFather->save();
                }

                $subjectFather = App\Subject::where('name', 'like', 'Organização da Administração Pública')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Organização da Administração Pública';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather;
                        $subjectFather->save();
                }

                // Q1
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Administração Indireta')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Administração Indireta';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->year = '2016';
                        $question->original = 1;
                        $question->text = 'As autaquias são entidades da Administração Pública Indireta, sobre as quais é correto afirmar:';
                        $question->scope = '';
                        $question->level = '';
                        $question->group_id = null;
                        $question->answer_type = 'M';
                        $question->state_id = null;
                        $question->city_id = null;
                        $question->created_at = Carbon::now();
                        $question->updated_at = Carbon::now();
                        $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->institution_id = null;
                        $question->office_id = null;
                        $question->subject_id = $subject->id;
                        $question->source_id = null;
                        $question->teacher_id = 2543;
                        $question->note1 = null;
                        $question->note2 = 'Decreto-Lei nº 200/67,arts. 2º, 4º, 5º, 10, § 4º, 11.<br><br>Lei nº 9472/97, art. 8º, § 2º.';
                        $question->note3 = null;
                        $question->count_right = 0;
                        $question->count_wrong = 0;
                        $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As autarquias podem ser classificadas quanto ao grau de poder que possuem para o exercício de sua finalidade, sendo classificadas como meramente administrativas ou políticas.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A definição estrutural da autarquia e âmbito de competência de todos os cargos é totalmente realizada por meio da lei que autoriza a sua criação, independendo de ato administrativo posterior para regulamentar a desconcentração.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As autarquias são pessoas jurídicas de direito público interno que possuem a mesma expressão federativa que o ente que a criou por meio de lei.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As autarquias, entidades da Administração Pública Indireta, são criadas  pelo Estado para exercer atividades para as quais o Estado não está autorizado constitucionalmente.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $group_question = new App\GroupQuestion;
                        $group_question->question_id = $question->id;
                        $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();
                        $group_question->updated_at = Carbon::now();
                        $group_question->deleted_at = null;
                        $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q2

                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->year = '2016';
                        $question->original = 1;
                        $question->text = 'Acerca da organização administrativa do Estado, pode-se afirmar que:';
                        $question->scope = '';
                        $question->level = '';
                        $question->group_id = null;
                        $question->answer_type = 'M';
                        $question->state_id = null;
                        $question->city_id = null;
                        $question->created_at = Carbon::now();
                        $question->updated_at = Carbon::now();
                        $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->institution_id = null;
                        $question->office_id = null;
                        $question->subject_id = $subject->id;
                        $question->source_id = null;
                        $question->teacher_id = 2543;
                        $question->note1 = null;
                        $question->note2 = 'Decreto-Lei nº 200/67, arts. 3º, 4º, 19 e 20.<br><br>Art. 37  da CRFB/88, XIX, art. 175, parágrafo único, I.<br>';
                        $question->note3 = null;
                        $question->count_right = 0;
                        $question->count_wrong = 0;
                        $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O Estado, tendo em vista a limitação decorrente do principio constitucional da legalidade, pode gerir-se internamente, mas não tem autorização legal para criar instituições com personalidade jurídica própria e natureza de direito público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A organização da administração do Estado ocorre por meio de lei, exclusivamente, sendo vedada a possibilidade de delegação contratual de serviços.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A organização da administração pública pode ocorrer internamente, com a criação e extinção de cargos, e externamente, com a criação de novas pessoas jurídicas, autônomas e independentes.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A organização administrativa do Estado, direta ou indireta, submete hierarquicamente todos os órgão e instituições ao ente político a que se vincula.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $group_question = new App\GroupQuestion;
                        $group_question->question_id = $question->id;
                        $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();
                        $group_question->updated_at = Carbon::now();
                        $group_question->deleted_at = null;
                        $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q3
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Administração Indireta - Autarquias')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Administração Indireta - Autarquias';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->year = '2016';
                        $question->original = 1;
                        $question->text = 'Acerca da estrutura jurídica das entidades da Administração Indireta, marque a resposta correta:';
                        $question->scope = '';
                        $question->level = '';
                        $question->group_id = null;
                        $question->answer_type = 'M';
                        $question->state_id = null;
                        $question->city_id = null;
                        $question->created_at = Carbon::now();
                        $question->updated_at = Carbon::now();
                        $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->institution_id = null;
                        $question->office_id = null;
                        $question->subject_id = $subject->id;
                        $question->source_id = null;
                        $question->teacher_id = 2543;
                        $question->note1 = 'Súmula n. 324 STF.';
                        $question->note2 = 'Decreto Lei 200, art. 5º.<br>Lei da Sociedade Anônima, art. 235, §§ 1º e 2º.<br>Lei nº 11.107/2005,  arts. 1º e 6º.<br>Art. 41 do CC/02';
                        $question->note3 = null;
                        $question->count_right = 0;
                        $question->count_wrong = 0;
                        $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As autarquias são previstas, no Decreto-Lei nº 200/67, como a personificação de um serviço típico de estado, ao passo em que não pode se estruturar como fundação, pois esta é a atribuição de personalidade jurídica a um patrimônio.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As sociedades de economia mista podem assumir qualquer forma jurídica prevista em direito.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As fundações públicas, de direito público ou de direito privado, devem fazer a inscrição de seus atos no Registro Público de Pessoas Jurídicas competente.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As autarquias podem assumir a forma de associação pública, situação na qual, todos os entes públicos, integrantes do protocolo de intenções, devem publicar a lei de criação da autarquia em seu respectivo ente federado.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id;
                        $answer->created_at = Carbon::now();
                        $answer->updated_at = Carbon::now();
                        $answer->deleted_at = null;
                        $answer->save();

                        $group_question = new App\GroupQuestion;
                        $group_question->question_id = $question->id;
                        $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();
                        $group_question->updated_at = Carbon::now();
                        $group_question->deleted_at = null;
                        $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q4
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Administração Indireta - Empresas Estatais')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Administração Indireta - Empresas Estatais';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->year = '2016';
                        $question->original = 1;
                        $question->text = 'Sobre as pessoas jurídicas da Administração Indireta de direito privado:';
                        $question->scope = ''; $question->level = '';
                        $question->answer_type = 'M';
                        $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null;
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->note1 = null; $question->note2 = 'Lei 8.666/93, art. 1º<br>CRFB/88, arts. 37, caput, 173, caput e § 2º'; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Podem gozar de privilégios fiscais não extensivos ao setor privado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Quando prestam atividade econômica devem ser sob o fundamento de segurança nacional ou relevante interesse coletivo.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Não estão submetidas aos princípios constitucionais da Administração Pública.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;
                        $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Não se submetem à exigência de prévia licitação para contratar bens, serviços ou obras.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;
                        $answer->save();

                        $group_question = new App\GroupQuestion;
                        $group_question->question_id = $question->id;
                        $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();
                        $group_question->updated_at = Carbon::now();
                        $group_question->deleted_at = null;
                        $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q5
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Administração Direta - Prerrogativas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Administração Direta - Prerrogativas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca dos privilégios da fazenda pública em juízo, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null;
                        $question->note1 = 'Súmula n. 340 STF';
                        $question->note2 = 'Lei 6830/80, art. 29.<br>Novo Código de Processo, art. 183 e 496.<br>CC/2002, arts. 100, 101 e 102.';
                        $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A Fazenda Pública submete-se ao princípio da universalidade da Lei de Falência.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As decisões contra a Fazenda Pública são sempre submetidas à remessa necessária para que se tornem eficazes.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Os bens públicos não são susceptíveis de penhora, arresto ou sequestro.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Os prazos de contestação é recurso da fazenda Pública foram alterado para o dobro, contudo o prazo de contra-razões se mantém simples.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q6
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Prerrogativas da Fazenda Pública em Juízo')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Prerrogativas da Fazenda Pública em Juízo';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca do remessa necessária é possível afirmar:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null;
                        $question->note2 = 'Novo Código De Processo Civil, art. 496';
                        $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Todas as decisões contra a fazenda pública que resultem em obrigação de pagar quantia são submetidas à remessa necessária.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A remessa necessária é condição de validade da sentença condenatória.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O regime de remessa necessária submete-se a restrições exclusivamente econômicas, tendo a lei disposto de valores diferenciados para as entidades políticas da federação.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O exigência da remessa necessária submete-se a restrições quantitativas e qualitativas, ou seja, depende do valor e do conteúdo jurídico da decisão a ser submetida.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q7
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Empresas Estatais prestadoras de serviço público')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Empresas Estatais prestadoras de serviço público';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca das empresas estatais que prestam serviço público, pode-se afirmar:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null;
                        $question->note1 = 'Súmulas n. 324 e 333 STJ.<br>Súmula n. 724, STF.<br>RE nº 215.741/SE e nº 399.307/AgR.';
                        $question->note2 = 'CFRB/88 art. 173, §1º, II.';
                        $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Como pessoa jurídica da Administração Indireta, sujeita-se ao regime jurídico próprio das empresas privadas.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Sendo o serviço público o objeto da atuação empresa pública, os bens afetados ao serviço recebem tratamento derrogatório do direito privado, decorrente do principio da continuidade do serviço público.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A natureza do serviço prestado pela empresa pública não altera a obrigação de pagar impostos, uma vez que está submetida ao regime de direito privado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A Empresa Pública Federal, por se submeter ao regime jurídico de direito privado, não goza de foro privilegiado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Terceiro Setor')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Terceiro Setor';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q8
                if (true) {
                        $subjectFather = App\Subject::where('name', 'like', 'Entes de Cooperação - objeto')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Entes de Cooperação - objeto';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca do Terceiro Setor, é correto afirmar:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null;
                        $question->note1 = 'Súmula  n. 516 STF.';
                        $question->note2 = ''; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Todas as instituições que fazem parte desse grupo são criadas por particulares, independente de autorização legal.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Também chamados de entes de cooperação com o Estado, prestam serviços não exclusivos ou não típicos do Estado por meio de delegação.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Por serem entidades privadas, não incluídas como entes da Administração Pública  pelo Decreto -Lei nº 200/67, não se submetem à fiscalização da Administração Pública ou do Tribunal de Contas, apresentando regime jurídico exclusivamente privado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'À exceção das demais pessoas jurídicas do terceiro setor, as organizações sociais são autorizadas por  Ato Administrativo, normalmente sob a forma de decreto, para desenvolverem atividade privada de interesse público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q9
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto às instituições que formam o denominado Terceiro Setor, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Os serviços sociais autônomos, a despeito de serem autorizados por lei, estão sujeitos à jurisdição da justiça estadual.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As fundações de apoio são instituições públicas, criadas diretamente por servidores públicos, em nome da instituição a ser beneficiária pelo apoio.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Por serem entidades privadas que colaboram com o Estado, podem ter fim lucrativo.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As organizações sociais são instituições privadas qualificadas como tal por meio de ato vinculado do Ministro Correlato à atividade a ser apoiada e do Ministro do Planejamento, Orçamento e Gestão.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////


                // Q10
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca dos serviços sociais autônomos, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São instituições que prestam serviço público delegado pelo Estado, por isso tem autorização para criação determinada por lei.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São instituições criadas diretamente por lei, para desempenharem serviços públicos, enquadrando-se como entidade da Administração Indireta.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São instituições autorizadas por lei, para desempenharem serviço de interesse público, com natureza jurídica de direito privado, mantidas exclusivamente por dotações orçamentárias.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Os serviços sociais autônomos compõe o sistema "S", e tem por característica diferenciadora a delegação de capacidade tributária pelo ente que autoriza a criação, para cobrarem contribuições parafiscais.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q11
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Sobre as Organizações Sociais - OS e as Organizações da Sociedade Civil de Interesse Público - OSCIP, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Segundo a definição legal, as OS são criadas para execução de serviços público não exclusivos do Estado, enquanto a OSCIP são para a prestação de serviços sociais não exclusivos do Estado.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Por serem instituições privadas, não integrantes da Administração Pública, podem ter finalidade lucrativa.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Ambas possuem representantes do Estado no quadro Diretivo da Empresa.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O vínculo jurídico entre o Estado e a organização social é o contrato de gestão, já entre o Estado e a OSCIP é o termo de parceria, ambos conferidos segundo a conveniência e oportunidade da Administração Pública.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Agente Público')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Agente Público';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q12
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto aos agentes públicos, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São agentes públicos todos aqueles que  desempenhem funções públicas, como longa manus do Estado, independente do vínculo jurídico e da natureza temporal.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Somente aqueles que prestam serviço público, tendo ingressado no função por concurso público, podem ser considerado agentes públicos.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Agente político e particular em colaboração com o Estado não podem ser considerados agentes públicos, por isso não se submetem a controle de seus atos por meio de remédios constitucionais.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Só são considerados como agentes públicos aqueles que desempenham a função decorrente de ato de nomeação ou contratação, não se enquadrando como tal aquele que o exerce por designação ou requisição.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q13
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto aos agentes públicos, pode-se afirmar:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São servidores públicos apenas os estatutários, ou seja, aqueles que ocupam cargo público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Servidor público estatutário é aquele que se submete ao regime legal, e ocupa emprego público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Empregado público não é espécie de servidor público, uma vez que não realiza concurso público para ingresso na carreira.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São servidores públicos os estatutários e os celetistas.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q14
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'A Empresa Pública X, publicou Edital de concurso público para seleção de candidatos ao emprego público de analista administrativo. O Edital previu o prazo de validade de 06 meses, tendo sido o mesmo prorrogado. Marque a resposta correta acerca da situação exposta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A validade do concurso pode ser prorrogada por mais dois anos.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O regime de emprego não se submete à exigência de anterior concurso público, sendo o mesmo uma faculdade do Gestor Público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Dentro do prazo de dois anos, contado da homologação do concurso, a validade pode ser prorrogada por mais dois anos.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A validade do concurso público só pode ser prorrogada por mais seis meses, dentro do prazo de seis meses da homologação.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q15
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto aos cargos públicos é errado afirmar:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Trata-se de uma unidade de competência dentro da organização Administrativa.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O cargo de confiança só pode ser ocupado por servidor público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A função de confiança pode ser exercida por qualquer pessoa.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Ocupante de emprego público pode exercer função de confiança.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q16
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'A investidura no cargo se dá por:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'nomeação.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'posse.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'homologação do concurso público pela autoridade competente.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'exercício.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q17
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Maria, após ser demitida de cargo público, ajuizou ação judicial requerendo a anulação do ato por ilegalidade e o seu retorno ao cargo que ocupava. O juiz julgou procedente o pedido e determinou:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a recondução de Maria ao cargo.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a reversão de Maria ao cargo.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a reintegração de Maria ao cargo.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'o aproveitamento de Maria no cargo.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Intervenção do Estado na Propriedade Privada')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Intervenção do Estado na Propriedade Privada';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q18
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca da intervenção do estado na propriedade privada, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Tendo em vista o direito fundamental à propriedade, a intervenção do Estado na propriedade somente se dá na modalidade restritiva, não se podendo falar em supressão da propriedade por meio do Estado, independente de indenização.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A limitação administrativa e o tombamento possuem caráter perpétuo, pois o Estado adquire a propriedade.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A limitação administrativa é uma forma restritiva de atuação do Estado face ao patrimônio particular e se manifesta por ato de polícia.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A servidão administrativa tem natureza de direito real, regendo-se pelo regramento civilista.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q19
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca do tombamento marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Destina-se à proteção do patrimônio que recebe a intervenção, conservando a identidade do bem, que pode ser material ou imaterial.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Refere-se a uma limitação temporária, já que o interesse histórico e artístico do Estado sobre o matrimônio tombado pode se alterar, conforme a conveniência e oportunidade. ';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Não há necessidade de prévio procedimento administrativo a fim de que o bem seja tombado, e este ato só pode ser realizado pela União.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A competência para legislar sobre tombamento é concorrente, já a competência executória pode realizar-se pelos estados e pela União, não cabendo ao município ou Distrito federal a prática de tal ato.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q20
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca da desapropriação, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Não é cabível desapropriação entre bens públicos, tendo em vista a inexistência de "hierarquia federativa".';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A desapropriação é um procedimento administrativo destinado à aquisição originária de bens que possuam valor econômico, e não se encontrem dentre as exceções dispostas na Constituição Federal vigente.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A declaração e a execução da desapropriação podem ser realizadas por entes políticos, pela Administração Indireta e, excepcionalmente, por particulares prestadores de serviço público, neste caso, recebem tal competência por lei ou contrato.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Toda desapropriação requer prévia e justa indenização.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q21
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto a desapropriação sancionatória, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Pode dá-se tanto em imóvel urbano, quanto em rural.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A desapropriação por interesse social da propriedade rural  ocorre para fins de reforma agrária e não sofre restrições quanto ao objeto.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A desapropriação sanção da propriedade urbana ocorre quando, cumulativa e sucessivamente, o proprietário não respeita as disposições do Estatuto da Cidade, não cumpre com a obrigação de parcelamento ou edificação compulsório e para IPTU progressivo no tempo por sanção, por cinco anos.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A desapropriação confiscatória ocorre em razão de tráfico ilícito de entorpecentes e pode ser realizada pelo ente político responsável pela atuação policial investigatória.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q22
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto à desapropriação, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A retrocessão é o instituto por meio do qual ao expropriado é lícito pleitear as consequencias pelo fato de o imóvel não ter sido utilizado para os fins declarados no decreto expropriatório.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Não há direito de o particular reaver o bem caso, demonstrada a tredestinação ilícita, quando ao bem não dada a destinação de interesse público.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Há direito de retrocessão tanto em tredestinação ilícita, quanto lítica.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Em nenhuma hipótese o particular terá direito à retrocessão.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Contratos Administrativos')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Contratos Administrativos';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q23
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Acerca dos contratos, marque a resposta que não corresponde a uma de suas características:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O contrato administrativo pode ser alterado unilateralmente pela Administração Pública, nas cláusulas regulamentares, de serviço e econômicas, desde que respeite o limite quantitativo disposto em lei.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O contrato administrativo tem prazo fixado conforme o orçamento do ente destinado à contratação.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A administração pública pode, segundo a conveniência e oportunidade, exigir garantia contratual, respeitado o limite legal e desde que tenha previsão no edital e no contrato.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Não se aplica integralmente à Administração Pública a exceção do contrato não cumprido.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q24
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Constituem motivos para rescisão unilateral do contrato, salvo:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'decretação de falência pelo contratado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'subcontratação total ou parcial do objeto, sem previa autorização da Administração, e sem previsão no edital e contrato.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'não cumprimento de cláusulas contratuais.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'atraso superior a 90 dias dos pagamento, ainda que em situação de calamidade pública.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q25
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'São características dos contratos administrativos:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a natureza de adesão e a presença de cláusulas exorbitantes.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a liberdade das partes para ajustar o objeto do contrato e as cláusulas exorbitantes.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a faculdade de fiscalização do contrato pela Administração Pública.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'a ausência de pessoalidade a vincular o agente contratado com o objeto a ser prestado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Atos Administrativos')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Atos Administrativos';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q26
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'São atributos do ato administrativo:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'autoexecutoriedade irrestrita e presunção de legitimidade.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'presunção de legitimidade e bilateralidade na formação do ato. ';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'presunção de legitimidade, imperatividade e tipicidade.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'presunção de legitimidade (salvo quanto à veracidade dos fatos alegados) e imperatividade.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q27
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto aos elementos que compõem o ato administrativo, marque a resposta errada:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A forma refere-se à exteriorização da vontade da Administração Pública, submetendo-se ao principio da solenidade.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O mérito administrativo  é localizado no elemento motivo, tratando das razões que autorizam a prática do ato. Uma vez expresso o motivo, pela teoria dos motivos determinantes, a legalidade e existência do motivo vincula o ato administrativo, podendo gerar a nulidade do ato.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O Poder Judiciário pode anular ou revogar o ato administrativo, conforme a situação jurídica o exija.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A Administração Pública pode apenas revogar os atos administrativos, uma vez que a anulação é ato restrito do Poder Judiciário.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Responsabilidade Civil')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Responsabilidade Civil';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q28
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto à responsabilidade extracontratual do Estado, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'De regra a responsabilidade extracontratual do Estado é objetiva, de modo que o requerente deve comprovar apenas a ação, o dano e o nexo existente entre eles.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'Para o STF, a previsão de regresso não impede que o agente público seja acionado imediatamente, independente da ação contra o Estado.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'A ação de regresso do Estado contra o agente que causou o dano pode ser proposta independente do transito em julgado e pagamento da ação principal.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O dano a justificar a indenização é aquele normal, ou seja decorre da própria natureza do ato.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                // Q29
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Sobre a responsabilidade civil do Estado, marque a resposta errada.';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São objetivamente responsáveis, a Administração Pública ou o particular que preste serviço público,  desde que cause dano a terceiro, usuário ou não do serviço.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São causas de exclusão da responsabilidade extracontratual do Estado a culpa exclusiva da vítima em virtude da adoção da teoria do risco administrativo.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O Brasil não adota a teoria do risco integral.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O Estado responde por danos que tenha causado a outrem em razão de conduta lícita ou ilícita.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                $subjectFather = App\Subject::where('name', 'like', 'Licitações')->get()->first();
                if ($subjectFather == null) {
                        $subjectFather = new App\Subject;
                        $subjectFather->name = 'Licitações';
                        $subjectFather->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $subjectFather->created_at = Carbon::now();
                        $subjectFather->updated_at = Carbon::now();
                        $subjectFather->deleted_at = null;
                        $subjectFather->subject_id = $subjectGrandFather->id;
                        $subjectFather->save();
                }

                // Q30
                if (true) {
                        $subject = App\Subject::where('name', 'like', 'Criação de cargos e de pessoas jurídicas')->get()->first();
                        if ($subject == null) {
                                $subject = new App\Subject;
                                $subject->name = 'Criação de cargos e de pessoas jurídicas';
                                $subject->description = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                                $subject->created_at = Carbon::now();
                                $subject->updated_at = Carbon::now();
                                $subject->deleted_at = null;
                                $subject->subject_id = $subjectFather->id;
                                $subject->save();
                        }

                        $question = new App\Question;
                        $question->text = 'Quanto às licitações, marque a resposta correta:';
                        $question->year = '2016';
                        $question->original = 1;
                        $question->answer_type = 'M';
                        $question->scope = ''; $question->level = ''; $question->group_id = null; $question->state_id = null; $question->city_id = null;
                        $question->created_at = Carbon::now(); $question->updated_at = Carbon::now(); $question->deleted_at = null;
                        $question->explanation_url = 'https://vimeo.com/123514879';
                        $question->explanation_text = 'Lorem ipsum dolor sit amet, eu ius graeco melius aliquid. Vis torquatos voluptatum temporibus at, cum dictas percipit sensibus et. Harum mandamus eam ea, at decore graeci vix. Delectus convenire ne eos. Usu prima perpetua ut, exerci meliore volumus ut pri, aliquid graecis indoctum ei sed. <br/><br/> Zril lucilius quo id, eu per admodum luptatum torquatos, id sea ferri quando euripidis. Nam salutandi voluptatum at, vis in nibh platonem. Ad illum accusamus ius, at nam idque accusamus. Id alii graecis omittam eos, vel ut detracto oporteat conceptam, vix ea aperiam albucius. Scaevola constituto necessitatibus quo ad. Duo clita commodo id, duo ex quot efficiendi, enim praesent id cum. Everti nostrud admodum cu quo, ei mea choro euismod eloquentiam. ';
                        $question->subject_id = $subject->id;
                        $question->teacher_id = 2543;
                        $question->institution_id = null; $question->office_id = null; $question->source_id = null; $question->note1 = null; $question->note2 = null; $question->note3 = null;
                        $question->count_right = 0; $question->count_wrong = 0; $question->count_partial = 0;
                        $question->save();

                        $answer = new App\Answer;
                        $answer->choice = 'São modalidades licitatórias a concorrência, a tomada de preço, o convite, o concurso, o leilão, o pregão e a consulta.';
                        $answer->is_right = 1;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'O Regime Diferenciado de Contratação é aplicável a qualquer  contratação e visa  redução dos prazos e a simplificação do procedimento.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As modalidade quantitativas (concorrência, tomada de preço e convite) podem ser substituído desde que da modalidade menos operosa para a modalidade mais onerosa.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null; $answer->save();

                        $answer = new App\Answer;
                        $answer->choice = 'As modalidades licitatórias podem ser combinadas entre si, desde que o licitante mantenha os tipos licitatórios previstos em lei.';
                        $answer->is_right = 0;
                        $answer->question_id = $question->id; $answer->created_at = Carbon::now(); $answer->updated_at = Carbon::now(); $answer->deleted_at = null;$answer->save();

                        $group_question = new App\GroupQuestion; $group_question->question_id = $question->id; $group_question->group_id = $group->id;
                        $group_question->created_at = Carbon::now();$group_question->updated_at = Carbon::now();$group_question->deleted_at = null; $group_question->save();
                }
                ////////////////////////////////////////////////////////////////////////////////

                if(env('DB_DRIVER') == 'mysql')
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}