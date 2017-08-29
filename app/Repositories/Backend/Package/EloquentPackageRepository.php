<?php

namespace App\Repositories\Backend\Package;

use App\Package;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentPackageRepository
 * @package App\Repositories\Package
 */
class EloquentPackageRepository implements PackageContract {

    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $package = Package::withTrashed()->find($id);

        if (!is_null($package))
            return $package;

        throw new GeneralException('That package does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_PackageController_title = '') {
        return Package::where('title', 'like', '%' . $f_PackageController_title . '%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedPackagesPaginated($per_page) {
        return Package::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPackages($order_by = 'id', $sort = 'asc') {
        return Package::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPackagesBySection($id, $order_by = 'id', $sort = 'asc') {
        $section_id = $id;
        return Package::whereHas('subsection', function($query) use ($section_id) {
                    $query->where('section_id', $section_id);
                })->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        if (isset($input['tags'])) {
            $this->tags->createIfNew($input['tags']);
        }

        $package = $this->createPackageStub($input);

        if ($package->save())
            return $package;
        throw new GeneralException('There was a problem creating this package. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $package = $this->findOrThrowException($id);

        if (isset($input['tags'])) {
            $this->tags->createIfNew($input['tags']);
            $input['tags'] = implode(';', $input['tags']);
        } else {
            $input['tags'] = NULL;
        }

        if ($package->update($input)) {
            $package->subsection_id = $input['subsection_id'];
            $package->title = $input['title'];
            $package->slug = $input['slug'];
            $package->description = $input['description'];
            $package->short_description = $input['short_description'];
            $package->price = parsemoneybr($input['price']);
            $package->discount_price = parsemoneybr($input['discount_price']);
            $package->teachers_percentage = $input['teachers_percentage'];
            $package->is_active = isset($input['is_active']) ? 1 : 0;
            //$package->special_offer = isset($input['special_offer']) ? 1 : 0;
            //$package->featured = isset($input['featured']) ? 1 : 0;

            $package->access_time = $input['access_time'];

            if (isset($input['start_special_price']))
                $package->start_special_price = parsebr($input['start_special_price']);
            if (isset($input['end_special_price']))
                $package->end_special_price = parsebr($input['end_special_price']);
            if (isset($input['special_price']))
                $package->special_price = parsemoneybr($input['special_price']);

            if (isset($input['tags']))
                $package->tags = $input['tags'];
            if (isset($input['video_ad_url']))
                $package->video_ad_url = $input['video_ad_url'];
            if (isset($input['activation_date']))
                $package->activation_date = parsebr($input['activation_date']);
            if (isset($input['featured_img']))
                $package->featured_img = $input['featured_img'];

            $package->meta_title = (isset($input['meta_title']) && !empty($input['meta_title'])) ? $input['meta_title'] : NULL;

            $package->meta_description = (isset($input['meta_description']) && !empty($input['meta_description'])) ? $input['meta_description'] : NULL;


            $package->save();

            return $package;
        }

        throw new GeneralException('There was a problem updating this package. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $package = $this->findOrThrowException($id);
        if ($package->delete())
            return true;

        throw new GeneralException("There was a problem deleting this package. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPackageStub($input) {

        $package = new Package;
        $package->subsection_id = $input['subsection_id'];
        $package->title = $input['title'];
        $package->slug = $input['slug'];
        $package->description = $input['description'];
        $package->short_description = $input['short_description'];
        $package->price = parsemoneybr($input['price']);
        $package->discount_price = parsemoneybr($input['discount_price']);
        $package->teachers_percentage = $input['teachers_percentage'];
        $package->is_active = isset($input['is_active']) ? 1 : 0;
        //$package->special_offer = isset($input['special_offer']) ? 1 : 0;
        //$package->featured = isset($input['featured']) ? 1 : 0;

        $package->access_time = $input['access_time'];

        if (isset($input['start_special_price']))
            $package->start_special_price = parsebr($input['start_special_price']);
        if (isset($input['end_special_price']))
            $package->end_special_price = parsebr($input['end_special_price']);
        if (isset($input['special_price']))
            $package->special_price = parsemoneybr($input['special_price']);

        if (isset($input['tags']))
            $package->tags = implode(';', $input['tags']);
        if (isset($input['video_ad_url']))
            $package->video_ad_url = $input['video_ad_url'];
        if (isset($input['activation_date']))
            $package->activation_date = parsebr($input['activation_date']);
        if (isset($input['featured_img']))
            $package->featured_img = $input['featured_img'];

        $package->meta_title = (isset($input['meta_title']) && !empty($input['meta_title'])) ? $input['meta_title'] : NULL;

        $package->meta_description = (isset($input['meta_description']) && !empty($input['meta_description'])) ? $input['meta_description'] : NULL;

        return $package;
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $package = $this->findOrThrowException($id);
        $package->featured_img = $new_file_name;
        if ($package->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

}
