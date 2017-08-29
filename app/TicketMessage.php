<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\TicketMessage\Traits\TicketMessageAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model {

    use TicketMessageAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticket_messages';

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
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

}
