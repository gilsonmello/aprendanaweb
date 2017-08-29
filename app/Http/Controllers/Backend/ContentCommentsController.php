<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ContentsComments\CreateContentsCommentsRequest;
use App\Http\Requests\Backend\ContentsComments\UpdateContentsCommentsRequest;
use App\Repositories\Backend\ContentsComments\ContentsCommentsContract;
use App\Repositories\Backend\Notification\NotificationContract;
use Illuminate\Http\Request;
/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class ContentCommentsController extends Controller {

    /**
     * @param ContentCommentsContract $contentComments
     */
    public function __construct(ContentsCommentsContract $contentComments, NotificationContract $notification) {
        $this->contentcomments = $contentComments;
        $this->notification = $notification;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $request->session()->put('lastpage', $request->only('page')['page']);
        $status = $request->input('status', '');

        $f_submit = $request->input('f_submit', '');
        if (($f_submit != '1') && ($status === ''))
            $status = $request->session()->get('status', '');
        $request->session()->put('status', $status );


        return view('backend.contentscomments.index')
            ->withContentscomments($this->contentcomments->getContentsCommentsPaginated(config('access.users.default_per_page'),$status))
            ->withStatus($status);

    }


    /**
     * @param $id
     * @param $status
     * @return mixed
     */

    public function deactivated($id) {
        $this->contentcomments->deactivated($id);
        $content_comment = $this->contentcomments->findOrThrowException($id);
        $this->notification->save_and_broadcast(array($content_comment->publisher),'Seu comentário foi rejeitado.', '/classroom/'. $content_comment->contents->lesson->module->course->id . '/' . $content_comment->contents->lesson->module->id . '/' . $content_comment->contents->lesson->id . '','fa-comment bg-danger');
        return redirect()->back()->withFlashSuccess(trans("alerts.contentcomments.deactivated"));
    }

    public function activated($id) {
        $this->contentcomments->activated($id);
        $content_comment = $this->contentcomments->findOrThrowException($id);
        $this->notification->save_and_broadcast(array($content_comment->publisher),'Seu comentário foi aprovado.', '/classroom/'. $content_comment->contents->lesson->module->course->id . '/' . $content_comment->contents->lesson->module->id . '/' . $content_comment->contents->lesson->id . '','fa-comment bg-success');
        return redirect()->back()->withFlashSuccess(trans("alerts.contentcomments.activated"));
    }

}