<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\SurveySimpleResponse;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class SurveyController extends Controller {

    /**
     * @param ArticleContract $articles
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function survey1() {

        if (access()->hasPermission('userstudents')){
            $surveys = SurveySimpleResponse::where("survey_id", "=", "1")->get();

            $totalAnswereds = 0;
            $totalAnswers = 0;
            $totalQst1 = 0;
            $totalQst2 = 0;
            $totalQst3 = 0;
            $totalQst4 = 0;
            $totalQst5 = 0;

            $html = "<table class='table table-striped table-bordered table-hover'>";
            $html = $html . "<tr>";
            $html = $html . "<td width='20%'><b>Aluno</b></td>";
            $html = $html . "<td width='10%'><b>Facilidade em localizar as informações (quadro de avisos, calendário, evolução do curso, resultados dos SAAP's)</b></td>";
            $html = $html . "<td width='10%'><b>Facilidade em localizar as funcionalidades (acesso às aulas e SAAP's, anotações, avaliações, fale conosco)</b></td>";
            $html = $html . "<td width='10%'><b>Qualidade na exibição dos vídeos</b></td>";
            $html = $html . "<td width='10%'><b>Aparência e design</b></td>";
            $html = $html . "<td width='10%'><b>Você indicaria o Brasil Jurídico aos seus amigos?</b></td>";
            $html = $html . "<td width='30%'><b>Qual a sua opinião a respeito da nossa plataforma? Deixe aqui suas sugestões e críticas.</b></td>";
            $html = $html . "</tr>";
            foreach ($surveys as $survey){
                if (($survey->response != null) && ($survey->response != "") && ($survey->response != "-")){

                    $qsts = str_getcsv( $survey->response, ",", "\"");

                    $qst1 = $qsts[0];
                    $qst2 = $qsts[1];
                    $qst3 = $qsts[2];
                    $qst4 = $qsts[3];
                    $qst5 = $qsts[4];
                    $qst6 = $qsts[5];

                    $totalQst1 = $totalQst1 + $qst1;
                    $totalQst2 = $totalQst2 + $qst2;
                    $totalQst3 = $totalQst3 + $qst3;
                    $totalQst4 = $totalQst4 + $qst4;
                    $totalQst5 = $totalQst5 + $qst5;

                    $totalAnswereds = $totalAnswereds + 1;

                    $html = $html . "<tr>";
                    $html = $html . "<td><a href='userstudents/" .$survey->user->id . "/edit'>" . ($survey->user->name != null ? $survey->user->name : $survey->user->email) . "</a></td>";
                    $html = $html . "<td>" . $qst1 . "</td>";
                    $html = $html . "<td>" . $qst2 . "</td>";
                    $html = $html . "<td>" . $qst3 . "</td>";
                    $html = $html . "<td>" . $qst4 . "</td>";
                    $html = $html . "<td>" . ($qst5 == "1" ? "Sim" : "<span style='color: red'>Não</span>") . "</td>";
                    $html = $html . "<td>" . $qst6 . "</td>";
                    $html = $html . "</tr>";

                }
                $totalAnswers = $totalAnswers + 1;
            }
            $html = $html . "<tr>";
            $html = $html . "<td><b>Resumo</b></td>";
            $html = $html . "<td><b>" . number_format( ($totalQst1 / $totalAnswereds), 2, ',', '.') . "</b></td>";
            $html = $html . "<td><b>" . number_format( ($totalQst2 / $totalAnswereds), 2, ',', '.') . "</b></td>";
            $html = $html . "<td><b>" . number_format( ($totalQst3 / $totalAnswereds), 2, ',', '.') . "</b></td>";
            $html = $html . "<td><b>" . number_format( ($totalQst4 / $totalAnswereds), 2, ',', '.') . "</b></td>";
            $html = $html . "<td><b>" . number_format( ($totalQst5 / $totalAnswereds) * 100, 0, ',', '.') . "%</b></td>";
            $html = $html . "<td></td>";
            $html = $html . "</tr>";
            $html = $html . "</table>";
            $html = $html . "<br>";
            $html = $html . "<br>";
            $html = $html . "Respostas efetivadas: " . $totalAnswereds;
            $html = $html . "<br>";
            $html = $html . "Rejeições: " . ($totalAnswers - $totalAnswereds);
            $html = $html . "<br>";
            $html = $html . "Total: " . $totalAnswers;
        }


        return view('backend.surveys.survey1')
            ->withhtml( $html );
    }


}