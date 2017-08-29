<?php

namespace App\Repositories\Frontend\Package;

use App\Package;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentPackageRepository
 * @package App\Repositories\Package
 */
class EloquentPackageRepository implements PackageContract {
//	public function __construct() {
//
//	}

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
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
    public function findBySlug($slug) {

        $package = Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('slug', $slug)->first();
        if (!is_null($package))
            return $package;
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->paginate($per_page);
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
        return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getBySearch($term) {
        return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->whereRaw(
                        "MATCH(title,description,tags) AGAINST(? IN BOOLEAN MODE)", array($term)
                )->get();
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getPackageByTags($term) {
        return Package::where('is_active', 1)
                        ->where('activation_date', '<=', Carbon::now())
                        ->where('tags', 'like', '%' . $term . '%')
                        ->get();
    }

    public function getRelatedPackages($package, $limit = 5) {
        $subsection = $package->subsection;

        $related = Package::where('id', '<>', $package->id)
                ->where('is_active', 1)
                ->where('activation_date', '<=', Carbon::now());

        $arrTags = explode(";", $package->tags);

        $i = 0;
        foreach ($arrTags as $value => $tag) {
            if ($i == 0) {
                $related->where('tags', 'like', '%' . $tag . '%');
            } else {
                $related->orWhere('tags', 'like', '%' . $tag . '%');
            }
            $i++;
        }

        $related = $related->get()
                ->shuffle()
                ->take(4);

        if ($related->isEmpty()) {
            $section = $subsection->section;

            $related = Package::where('packages.id', '<>', $package->id)->where('is_active', 1)->where('activation_date', '<=', Carbon::now())->join('subsections', 'subsection_id', '=', 'subsections.id')->where('subsections.section_id', $section->id)->get();

            if ($related->isEmpty()) {

                $tags = $package->tags;
                if ($tags != null && $tags != '') {
                    $tags = explode(";", $tags);
                }


                $packages_remaining = 5;
                $related = Collect([]);

                if ($tags != '') {
                    foreach ($tags as $tag) {
                        if ($packages_remaining > 0) {
                            $related = $related->merge($this->getBySearch($tag)->diff($related));

                            $packages_remaining = $packages_remaining - $related->count();
                        }
                    }
                }
            }
        }
        return $related->shuffle()->take($limit);
    }

    public function incrementClick($package, $count = 1) {
        $package->indication_count = $package->indication_count + $count;
        $package->save();
    }

}
