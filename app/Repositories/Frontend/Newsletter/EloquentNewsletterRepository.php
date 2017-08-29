<?php namespace App\Repositories\Frontend\Newsletter;

use App\Newsletter;
use App\Video;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentNewsletterRepository
 * @package App\Repositories\Newsletter
 */
class EloquentNewsletterRepository implements NewsletterContract {


//	public function __construct() {
//	}

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
	public function findOrThrowException($id) {
		$newsletter = Newsletter::whereId($id)->first();

		if (! is_null($newsletter)) return $newsletter;

		throw new GeneralException('That newsletter does not exist.');
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllNewsletters($order_by = 'id', $sort = 'asc') {
		return Video::isActivatedAndPublished()->orderBy($order_by, $sort)->get();
	}

	public function getNewsletterByEmail($email){
		$newsletter = Newsletter::where('email', $email)->first();
		return $newsletter;
	}

	public function subscribeToNewsletter($name, $email, $campaign = NULL){
		$newsletter = new Newsletter;
		$newsletter->name = $name;
		$newsletter->email = $email;
		$newsletter->campaign_id = (isset($campaign) && !empty($campaign)) ? $campaign : NULL;
		if($newsletter->save())
			return TRUE;
		return FALSE;

	}

	public function unsubscribeNewsletter($id){
		$newsletter = Newsletter::find($id);
		if ($newsletter->delete())
			return true;
		return false;
	}
}