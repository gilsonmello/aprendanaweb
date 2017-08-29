<?php namespace App\Repositories\Frontend\ContentComments;

use App\ContentComment;
use App\Exceptions\GeneralException;


class EloquentContentCommentsRepository implements ContentCommentsContract {


    public function findOrThrowException($id) {
        $contentsComments = ContentComment::withTrashed()->find($id);

        if (! is_null($contentsComments)) return $contentsComments;

        throw new GeneralException('That Comentary does not exist.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $contentsComments = $this->findOrThrowException($id);
        if ($contentsComments->delete())
            return true;

        throw new GeneralException("There was a problem deleting this Comentary. Please try again.");
    }


    public function getCommentsOnContent($content, $order_by = "created_at", $sort = 'desc'){
        $comments = ContentComment::where("contents_id",$content)->where('is_active',1)->join('users', 'users.id', '=', 'content_comments.publisher_id' )->select('content_comments.*','users.photo','users.name as user_name','users.id as user_id')->orderBy($order_by,$sort)->get();

        return $comments;



    }

    public function getCommentsOnLesson($lesson, $order_by = 'created_at', $sort = 'desc'){
        $comments  = ContentComment::contents()->where("lesson_id",$lesson)->join('users', 'users.id', '=', 'contents.id' )->orderBy($order_by,$sort)->get();

        return $comments;


    }


    public function createComment($content,$comment,$publisher){


        $contentComment = new ContentComment();
        $contentComment = new ContentComment();
        $contentComment->comment = $comment['content'];
        $contentComment->publisher()->associate($publisher);
        $contentComment->contents()->associate($content);
        $contentComment->is_active = 0;

        if($contentComment->save()){
          return true;
        }

    }






}