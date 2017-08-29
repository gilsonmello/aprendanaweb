<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\AskTheTeacher\Traits\AskTheTeacherAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class AskTheTeacher extends Model {

    use AskTheTeacherAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ask_the_teacher';

    public function questionObj()
    {
        return $this->belongsTo('App\Question');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function userStudent()
    {
        return $this->belongsTo('App\User', 'user_student_id');
    }

    public function userTeacher()
    {
        return $this->belongsTo('App\User', 'user_teacher_id');
    }

    public function workshop()
    {
        return $this->belongsTo('App\Workshop');
    }
    
    public function getLessonNameAttribute(){
        $lesson_name = "";
        if($this->lesson->title != '' && $this->lesson->title != null){
            $lesson_name = ": " . $this->lesson->title;
        }
        return $this->lesson->module->name . ' - Aula ' . $this->lesson->sequence . $lesson_name;
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

    public function scopeAllIfOwner($query) {
        if(access()->hasRoles(['Administrador'])) return $query;
        return $query->where('user_teacher_id', auth()->id() );
    }

    /**
     * @return string
     */
    public function getIsRepliedLabelAttribute() {
        if (($this->answer != null) && ($this->answer != ''))
            return "<label class='label label-success'>Sim</label>";
        return "<label class='label label-danger'>Não</label>";
    }
}
