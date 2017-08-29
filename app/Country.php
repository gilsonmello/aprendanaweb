<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

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
    
    /**
     * Retorna os estados via relacionamento
     * @return relationship
     */
    public function states() {
            return $this->hasMany('App\State', 'country_id');
    }
    
    /**
     * Retorna todos os países
     * @return relationship
     */
    public function scopeCountries($query){
            return $query->orderBy('name', 'asc')->get();
    }
}
