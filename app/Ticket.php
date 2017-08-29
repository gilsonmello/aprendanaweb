<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Ticket\Traits\TicketAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model {

    use TicketAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tickets';

    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }

    public function userStudent()
    {
        return $this->belongsTo('App\User', 'user_student_id');
    }

    public function content()
    {
        return $this->belongsTo('App\Content');
    }

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

    public function scopeAllIfResponsible($query) {
        return $query->whereHas('sector', function ($subquerySector){
                    $subquerySector->whereHas('users', function ($subquery) {
                        $subquery->where('user_id', auth()->id());
                    });
        });
    }

    /**
     * @return string
     */
    public function getIsRepliedLabelAttribute() {
        if ($this->is_replied == 1)
            return "<label class='label label-success'>Sim</label>";
        return "<label class='label label-danger'>Não</label>";
    }

    /**
     * @return string
     */
    public function getIsFinishedLabelAttribute() {
        if ($this->is_finished == 1)
            return "<label class='label label-success'>Sim</label>";
        return "<label class='label label-danger'>Não</label>";
    }


}
