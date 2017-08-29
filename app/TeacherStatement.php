<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\TeacherStatement\Traits\TeacherStatementAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherStatement extends Model {

    use TeacherStatementAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_statements';

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

}
