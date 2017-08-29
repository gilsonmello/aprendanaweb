
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ratingModalLabel" style="color: #08C">Ajude-nos avaliando esse curso!</h4>
            </div>
            <div class="modal-body">
                @foreach($criteria as $criterion)
                <div data-criteria={{ $criterion->id }} class="stars" style="color: #08C">
                    <span>{{ $criterion->description }}</span>
                    <span class="fa fa-star-o rate-star"></span>
                    <span class="fa fa-star-o rate-star"></span>
                    <span class="fa fa-star-o rate-star"></span>
                    <span class="fa fa-star-o rate-star"></span>
                    <span class="fa fa-star-o rate-star"></span>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>




