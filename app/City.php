<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\City\Traits\CityAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model {

        use CityAttributes,
            SoftDeletes;

        public $timestamps = true;

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'cities';

        /**
         * The attributes that are not mass assignable.
         *
         * @var array
         */
        protected $guarded = ['id'];

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at'];

        public function state() {
                return $this->belongsTo('App\State', 'state_id');
        }

        public function scopeCities($query) {
                return $query->orderBy('name', 'asc')->get();
        }

}
