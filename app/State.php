<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Newsletter\Traits\NewsletterAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model {

        use NewsletterAttributes, SoftDeletes;

        public $timestamps = true;

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'states';

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

        public function country() {
                return $this->belongsTo('App\Country', 'country_id');
        }
        
        public function cities(){
                return $this->hasMany('App\City');
        }
        
        public function scopeStates($query) {
                return $query->orderBy('name', 'asc')->get();
        }

}
