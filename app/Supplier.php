<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Suppliers\Traits\SuppliersAttributes;
use Carbon\Carbon;

class Supplier extends Model {

    use SuppliersAttributes,
        SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

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

    public function scopeSuppliers($query){
        return $query->orderBy('company_name', 'asc')
        ->get();
    }

}
