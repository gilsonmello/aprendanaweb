<div class="card exam-rating-card">
    <div class="exam-rating">
        <div class="row">
            <div class="col-md-6" style="color:black;font-size: 20px; font-weight: 700;">
        Avalie esse SAAP!
            </div>
        <div class="col-md-6 text-right exam-rating" style="color:black;font-size: 20px">
            <i class="fa fa-star-o rating-star"></i>  <i class="fa fa-star-o rating-star"></i>  <i class="fa fa-star-o rating-star"></i>  <i class="fa fa-star-o rating-star"></i>  <i class="fa fa-star-o rating-star"></i>
        </div>
        </div>
    </div>
    <div class="teachers-rating" style="display:none">
      @foreach(  get_questions_from_exam($execution->enrollment->exam) as $unique_teacher)
            <div class="teacher-rating" data-teacher="{{ $unique_teacher->id }}">
                @if($unique_teacher != null)

                <div class="row" style="padding-top: 0px">
                    <div class="col-md-1 text-right" >

                        <div class="profile-picture">
                            <img width="40" src="{{ imageurl('users/',$unique_teacher->id, $unique_teacher->photo, 100, 'generic.png', true) }}" class="img-circle" data-lock-picture="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100) }}">
                        </div>

                    </div>
                    <div class="col-md-3 text-left teacher-rating"><strong>{{ $unique_teacher->name }}</strong></div>
                    <div class="col-md-2 teacher-rating">
                        Didática
                    </div>
                    <div class="col-md-2 teacher-rating" data-type="teaching">
                        <i class="fa fa-thumbs-o-down rating-thumb"></i>&nbsp;&nbsp;<i class="fa fa-thumbs-o-up rating-thumb" ></i>
                    </div>
                    <div class="col-md-2 teacher-rating">
                       Conteúdo
                    </div>
                    <div class="col-md-2  teacher-rating" data-type="content">
                      <i class="fa fa-thumbs-o-down rating-thumb"></i> &nbsp;&nbsp;<i class="fa fa-thumbs-o-up rating-thumb"></i>
                    </div>
                </div>
                @endif
            </div>

        @endforeach
        <div class="row comment-rating-form" style="padding: 30px;">
          <div class="form-group">
              <label for="comment">Deixe sua opinião:</label>
              <textarea class="form-control" rows="5" id="rating-comment"></textarea>
          </div>
            <div class="form-group">
                <a id="send-rating-comment" role="button" class="btn btn-default">Enviar comentário</a>
            </div>
        </div>
    </div>
</div>