<?php namespace App\Repositories\Backend\FaqCategory;

use App\FaqCategory;
use App\Exceptions\GeneralException;

/**
 * Class EloquentFaqCategoryRepository
 * @package App\Repositories\FaqCategory
 */
class EloquentFaqCategoryRepository implements FaqCategoryContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$faqCategory = FaqCategory::withTrashed()->find($id);

		if (! is_null($faqCategory)) return $faqCategory;

		throw new GeneralException('That FAQ Category does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getFaqCategoryPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return FaqCategory::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedFaqCategoryPaginated($per_page) {
		return FaqCategory::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllFaqCategory($order_by = 'id', $sort = 'asc') {
		return FaqCategory::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $faqCategory = $this->createFaqcategoryStub($input);
        if($faqCategory->save())
            return true;
        throw new GeneralException('There was a problem creating this FAQ Category. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $faqCategory = $this->findOrThrowException($id);

        if ($faqCategory->update($input)) {
            $faqCategory->description  = $input['description'];
            $faqCategory->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this FAQ Category. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $faqCategory = $this->findOrThrowException($id);
        if ($faqCategory->delete())
            return true;

        throw new GeneralException("There was a problem deleting this FAQ Category. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createFaqCategoryStub($input)
    {
        $faqCategory = new FaqCategory();
        $faqCategory->description = $input['description'];
        return $faqCategory;
    }

    public function getFaqCategoryForHome() {
        return FaqCategory::orderBy('description', 'asc')->get();
    }
}