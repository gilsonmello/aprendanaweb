<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Newsletter\UnsubscribeNewsletterRequest;
use App\Http\Requests\Frontend\Newsletter\SubscribeNewsletterRequest;
use App\Repositories\Frontend\Newsletter\NewsletterContract;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Support\Facades\Mail;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/NewsletterController.php:7
 * @package App\Http\Controllers\Frontend
 */
class NewsletterController extends Controller {

    public function __construct(NewsletterContract $newsletters, UserContract $users) {
        $this->newsletters = $newsletters;
        $this->users = $users;
    }

    public function subscribe(SubscribeNewsletterRequest $request){
        $user = $this->users->getUserByEmail($request['email']);
        if ($user !== null){
            if ($user['is_newsletter_subscriber'] !== NULL){
                return redirect()->route('home')->withFlashDanger("Usuário já inscrito na newsletter");
            } else {
                $this->users->subscribeUnsubscribeUserToNewsletter($user['id'],1);
                return redirect()->route('home')->withFlashSuccess("Inscrição feita com sucesso");
            }
        } else {
            $newsletter = $this->newsletters->getNewsletterByEmail($request['email']);
            if ($newsletter !== null)
                return redirect()->route('home')->withFlashDanger("Email já inscrito na newsletter");
            else{
                $this->newsletters->subscribeToNewsletter($request['name'],$request['email']);
                return redirect()->route('home')->withFlashSuccess("Inscrição feita com sucesso");
            }
        }
    }

    /*public function subscribe(SubscribeNewsletterRequest $request){
        $user = $this->users->getUserByEmail($request['email']);
        if ($user !== NULL){
            if ($user['is_newsletter_subscriber'] !== NULL)
                //É usuário e já está inscrito
                //Retornar json
                $message = '{"status":1,"message":"Usuário já inscrito no newsletter"}';
            else{
                $this->status->subscribeUnsubscribeUserToNewsletter($user['id'],1);
                //Retornar json
                if ($this->status === TRUE)
                    $message = '{"status":1,"message":"Inscrição feita com sucesso"}';
                else
                    $message = '{"status":0,"message":"Houve um problema na sua incrição"}';
            }

        }else{
            $newsletter = $this->newsletters->getNewsletterByEmail($request['email']);
            if ($newsletter !== NULL)
                //Não é usuário mas está inscrito
                //Retornar json
                $message = '{"status":1,"message":"Usuário já inscrito no newsletter"}';
            else{
                $this->status->subscribeToNewsletter($request['name'],$request['email']);
                //Retornar json
                if ($this->status === TRUE)
                    $message = '{"status":1,"message":"Inscrição feita com sucesso"}';
                else
                    $message = '{"status":0,"message":"Houve um problema na sua incrição"}';
            }
        }
        return $message;
    }*/

    public function unsubscribe(UnsubscribeNewsletterRequest $request){
        $user = $this->users->getUserByEmail($request['email']);
        if ($user !== NULL){
            if ($user['is_newsletter_subscriber'] === 1){
                if ($user['name'] === $request['name']){
                    $this->users->subscribeUnsubscribeUserToNewsletter($user['id'],0);
                    return redirect()->route('newsletters.unsubscribe')->withFlashSuccess("E-mail removido da newsletter.");
                }else{
                    return redirect()->route('newsletters.unsubscribe')->withFlashDanger("Nome diferente do informado no cadastro.");
                }
            }else{
                return redirect()->route('newsletters.unsubscribe')->withFlashDanger("E-mail não inscrito na newsletter.");
            }
        }else{
            $newsletter = $this->newsletters->getNewsletterByEmail($request['email']);
            if ($newsletter !== NULL){
                if ($newsletter['name'] === $request['name']){
                    $this->newsletters->unsubscribeNewsletter($newsletter['id']);
                    return redirect()->route('newsletters.unsubscribe')->withFlashSuccess("E-mail removido da newsletter.");
                }else{
                    return redirect()->route('newsletters.unsubscribe')->withFlashDanger("Nome diferente do informado no cadastro.");
                }
            }else{
                return redirect()->route('newsletters.unsubscribe')->withFlashDanger("E-mail não inscrito na newsletter.");
            }
        }
    }

    /**
     * Função que inscreve usuários na tabela newsletters na campanha e-book oab e ética
     *
     * @return string
     *
     **/
    public function subscribeCampaignEbookOabEtica(){
        
        $data = $_POST;
        
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

        $campaing_id = 1;

        $newsletter = $this->newsletters->getNewsletterByEmail($data['email']);

        if(is_null($newsletter)){
            $subscribe = $this->newsletters->subscribeToNewsletter($data['name'], $data['email'], $campaing_id);
            if($subscribe){
                Mail::send('emails.subscribe_oab_e_etica', [
                'email' => $data['email'], 
                'name' => $data['name']
                ], function ($message) use ($data, $protocol) {
                    /*$message->to($_POST['email'], $_POST['name'])*/
                    $message->to($data['email'], $data['name'])
                    ->from("aprendawebunidom@gmail.com", app_name())
                    ->subject('Parabéns! Seu E-book de Ética chegou!')
                    ->attach($protocol.$_SERVER['HTTP_HOST'].'/ebook_etica.pdf');
                });
                return die(json_encode('success'));
            }
            return die(json_encode('error'));
        }else{
            Mail::send('emails.subscribe_oab_e_etica', [
                'email' => $newsletter->email, 
                'name' => $newsletter->name
                ], function ($message) use ($newsletter, $protocol) {
                    /*$message->to($_POST['email'], $_POST['name'])*/
                    $message->to($newsletter->email, $newsletter->name)
                    ->from("aprendawebunidom@gmail.com", app_name())
                    ->subject('Parabéns! Seu E-book de Ética chegou!')
                    ->attach($protocol.$_SERVER['HTTP_HOST'].'/ebook_etica.pdf');
                });
            return die(json_encode('success'));
        }
        
        return die(json_encode('error'));
    }

    /**
     * Função que inscreve usuários na tabela newsletters na campanha e-book oab e ética
     *
     * @return string
     *
     **/
    public function successSubscribedEbookOabEtica(){
        //dd($_SERVER);
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'etica-oab') > 0) {
            return view('frontend.landingpages.success_subscribed_etica_e_oab');
        }
        return redirect()->route('frontend.etica-oab');

    }

}