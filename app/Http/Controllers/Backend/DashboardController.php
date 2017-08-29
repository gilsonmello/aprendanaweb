<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Ticket\TicketContract;
use App\Repositories\Backend\Article\ArticleContract;
use App\Repositories\Backend\Tag\TagContract;
use App\Repositories\Backend\Order\OrderContract;
use Carbon\Carbon;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller {

	/**
	 * @param TicketContract $tickets
	 */
	public function __construct(TicketContract $tickets, ArticleContract $articles, TagContract $tags, OrderContract $orders) {
		$this->tickets = $tickets;
		$this->articles = $articles;
		$this->tags = $tags;
		$this->orders = $orders;

	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$tickets = null;
		if (access()->hasPermission('tickets')){
			$tickets = $this->tickets->getTicketsPaginated(config('access.users.default_per_page'), null,
				null, null,
				format_datebr(Carbon::now()->addDays(-3)),  format_datebr(Carbon::now()->addDays(7)),
				0, 0);
		}

		$articles = null;
		if (access()->hasPermission('articles')){
			$articles = $this->articles->getArticlesNotActive()->take(8);
		}

		$tags = null;
		if (access()->hasPermission('tags')){
			$tags = $this->tags->getTagsNotActive()->take(8);
		}

		$orders = null;
		if (access()->hasPermission('orders')) {
			$orders = $this->orders->getOrdersPaginated(config('access.users.default_per_page'),
				format_datebr(Carbon::now()->addDays(-7)),
				format_datebr(Carbon::now()->addDays(0)), null, null, 1, null, null,'date_registration', 'desc');
		}

		return view('backend.dashboard')
			->withTickets( $tickets )
			->withArticles( $articles )
			->withTags( $tags )
			->withOrders( $orders );
	}
}