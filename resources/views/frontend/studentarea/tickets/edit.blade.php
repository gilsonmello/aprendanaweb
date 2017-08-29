@extends('frontend.layouts.master-classroom')

@section('content')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Fale Conosco</h2>
	</header>
	<!-- start: page -->

<div class="row" >
<div class="col-md-1"> </div>

<div class="col-md-3">
	<div class="inbox-sidebar">
		<a href="{{route('student.ticketstudents.index')}}" data-title="Compose" class="btn red compose-btn btn-block">
                        <i class="fa fa-inbox"></i> Caixa de Entrada </a>
			<p class="text-center"> <br>
				Atendimento <br> 
				<h4 class="text-center"> <strong>{!! $ticket->id !!}</strong></h4> 
			</p>

			<p class="text-center">	
				Assunto <br> 
				<h4 class="text-center"><strong>{!! $ticket->sector->name !!}</strong></h4> 
			</p>
			
	</div>
</div>



		<div class="col-md-7">
				@foreach ($messages as $message)

			<div class="row">
				<div class="col-md-2">
					<div class="text-right"> <br>
						<img height="80"  src="{{ imageurl('users/',$message->user->id, $message->user->photo, 100 , 'generic.png',true) }}"
							 class="img-circle no-padding" data-lock-picture="{{ imageurl('users/',$message->user->id, $message->user->photo, 100 , 'generic.png',true) }}">
					</div>
				</div>

				<div class="col-md-10">
					<div class="card" style="position: relative;">
					<div class="arrow">
						<div class="left"></div>
					</div>

						<a class="timeline-body-title font-blue-madison" href="javascript:;"><strong class="atendimento-Usuario">{!! $message->user->name !!} </strong> &nbsp;&nbsp;</a>
						<span class="timeline-body-time font-grey-cascade">
							@if ( $message->user->id === auth()->id() )
							enviado
							@else
							respondido
							@endif
							 em <strong>{!!  format_datetimebr($message->created_at) . ' (' . diff_time( $message->created_at ) . ')' !!}</strong>
						</span>
						<br>
						<br>
						<span class="font-grey-cascade atendimento-Card-Mensagem"> 
							{!! nl2br($message->message) !!}
						</span>
					</div>
				</div>
			</div>
		@endforeach

		<div class="row">
			<div class="col-md-2">
				<div class="text-right hidden-xs hidden-sm"> <br>
					<img height="80"  src="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 100 , 'generic.png',true) }}" class="img-circle hidden-sm hidden-xs no-padding" data-lock-picture="{{ imageurl('users/',Auth::user()->id, Auth::user()->photo, 200) }}">
				</div>
			</div>

			<div class="col-md-10">
				<div class="card position-Relative">
					<div class="arrow">
						<div class="left"></div>
					</div>

					<a class="timeline-body-title font-blue-madison" href="javascript:;"><strong class="atendimento-Usuario">{!! $ticket->userStudent->name !!} </strong> &nbsp;&nbsp;</a>
					<span class="timeline-body-time font-grey-cascade">
						aberto em <strong>{!!  format_datetimebr($ticket->created_at) . ' (' . diff_time( $ticket->created_at ) . ')' !!}</strong>
					</span>
					<br>
					<br>
					<span class="font-grey-cascade atendimento-Card-Mensagem"> 
						{!! nl2br($ticket->message) !!}
					</span>
				</div>
			</div>

		@if ($ticket->is_finished != 1)
		<div class="col-md-2"></div>
		<div class="col-md-10">
			<div class="atendimento-Resposta" style="padding-top: 20px; padding-bottom: 20px;">
				<div class="portlet-title">

				</div> 


						{!! Form::open(array('route' => array('student.ticketstudents.message.store'), 'method' => 'post'))  !!}
						{!! Form::hidden('ticket_id', $ticket->id  ) !!}

						<div class="form-group">
							

								{!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Digite aqui a sua resposta']) !!}

						</div>
						<!--form control-->


						<div class="pull-left">
							<input type="submit" class="btn green" value="{{ trans('strings.send') }}"/>
						</div>

						<div>&nbsp;
							<a href="{{route('student.ticketstudents.index', ['page' => Session::get('lastpage', '1')])}}"
							class="btn default">{{ trans('strings.cancel_button') }}</a>
						</div>

						<div class="clearfix"></div>

						{!! Form::close() !!}

			</div>
		@endif
		</div>
	</div>		


<!-- <h3 class="mailbox-email-subject m-none text-light">	Atendimentos: {!! $ticket->id !!}</h3>-->							

		</div>
	</div>
</div>


	<!-- end: page -->
</section>

<div class="col-md-1">
	
</div>

@endsection