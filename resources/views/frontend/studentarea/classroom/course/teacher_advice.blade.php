



<div class="mt-widget-2" style="margin-top: 15px;">
    <div class="col-xs-6" style="padding:0;margin-top:0;">
        <img class="img-responsive userpic" src="{{ imageurl('users/',$teacher->id, $teacher->photo, 400, 'generic.png', true) }}">
    </div>
    <div class="mt-head-user-info col-xs-6 " style="margin-top:0;">
                                                 <span class="label-big pull-right
                                        @if( $enrollment->views->isEmpty() || count($enrollment->views) == 0)
                                                         label-primary
                                                        @elseif(abs($actual - $ideal) < 10 )
                                                         label-warning
                                                         @elseif($actual - $ideal > 10)
                                                         label-success
                                                 @else
                                                         label-danger  @endif" >
                                                @if( $enrollment->views->isEmpty() || count($enrollment->views) == 0)
                                                         BEM VINDO!
                                                     @elseif(abs($actual - $ideal) < 10 )
                                                         MANTENHA O RITMO!
                                                     @elseif($actual - $ideal > 10)
                                                         CONTINUE NESTE RITMO
                                                     @else
                                                         MANTENHA O RITMO!
                                                     @endif
                                                </span>
    </div>
    <div class="clearfix"></div>
</div>
