<?php namespace App\Repositories\Backend\Notification;


use App\Exceptions\GeneralException;
use App\NotificationMessage;
use App\NotificationUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentFaqCategoryRepository
 * @package App\Repositories\FaqCategory
 */
class EloquentNotificationRepository implements NotificationContract {


    /**
     * @param $id
     * @return mixed
     */

    public function save_notification($message, $url, $icon)
    {
        $note = new NotificationMessage();

        $note->message = $message;
        $note->route = $url;
        $note->icon = $icon;

        if($note->save()){
            return $note;
        }



    }

    public function broadcast($note_message, $users)
    {
        foreach($users as $user){
            $note_user = new NotificationUser();
            $note_user->user()->associate($user);
            $note_user->notificationMessage()->associate($note_message);
            $note_user->save();
        }

    }


    public function save_and_broadcast($users, $message,$url, $icon = ''){
        $notification =  $this->save_notification($message,$url,$icon);
        $this->broadcast($notification,$users);

    }

    public function remove_by_time($days, $is_read){
        $notifications = NotificationUser::withTrashed()->where('is_read',$is_read)->whereDate('updated_at','<', Carbon::today()->subDays($days))->get();


        foreach($notifications as $notification){
            $notification->delete();
        }

    }

    public function read_notification($id){
        $notification = NotificationUser::find($id);
        $notification->is_read = 1;
        $notification->save();

    }


}