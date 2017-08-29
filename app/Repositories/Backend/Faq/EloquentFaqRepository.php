<?php namespace App\Repositories\Backend\Faq;

use App\Faq;
use App\Exceptions\GeneralException;

/**
 * Class EloquentFaqRepository
 * @package App\Repositories\Faq
 */
class EloquentFaqRepository implements FaqContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$faq = Faq::withTrashed()->find($id);

		if (! is_null($faq)) return $faq;

		throw new GeneralException('That faq does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getFaqsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return Faq::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedFaqsPaginated($per_page) {
		return Faq::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllFaqs($order_by = 'id', $sort = 'asc') {
		return Faq::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $faq = $this->createFaqStub($input);
        $faq->faqcategory()->associate($input['faqcategorys'][0]);
        if($faq->save())
            return true;
        throw new GeneralException('There was a problem creating this faq. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $faq = $this->findOrThrowException($id);

        $faq->faqcategory()->associate($input['faqcategorys'][0]);
        unset($input['faqcategorys']);
        if ($faq->update($input)) {

            $faq->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this faq. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $faq = $this->findOrThrowException($id);
        if ($faq->delete())
            return true;

        throw new GeneralException("There was a problem deleting this faq. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createFaqStub($input)
    {
        $faq = new Faq;
        $faq->question = $input['question'];
        $faq->answer = $input['answer'];
        return $faq;
    }

    public function getFaqsForHome(){
        return Faq::
            select('faqs.*')
            ->join('faqcategory', 'faqcategory.id', '=', 'faqs.category_faq_id')
            ->orderBy('faqcategory.description', 'asc')
            ->orderBy('faqs.id', 'asc')
            ->get();
    }

}