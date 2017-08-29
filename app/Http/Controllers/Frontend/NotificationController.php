<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Notification\NotificationContract;

/**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class NotificationController extends Controller {

    /**
     * @param CourseContract $courses
     */
    public function __construct(NotificationContract $notifications) {
        $this->notifications = $notifications;
    }

    /**
     * @return mixed
     */

    public function readNotification() {
        $this->notifications->read_notification($_POST['notification']);
    }

}