<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="">{{app_name()}}</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">

			</ul>

			<ul class="nav navbar-nav navbar-right">
				@if (Auth::guest() || !Auth::user()->is("Aluno"))
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Login<span class="caret"></span></a>

						<ul class="login-menu dropdown-menu" role="menu">

							{!! Form::open(['url' => 'auth/login', 'class' => 'form-horizontal', 'role' => 'form']) !!}

							<div class="form-group">
								{!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::input('email', 'email', old('email'), ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('password', trans('validation.attributes.password'), ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<div class="checkbox">
										<label>
											{!! Form::checkbox('remember') !!} {{ trans('labels.remember_me') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{!! Form::submit(trans('labels.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) !!}

									{!! link_to('password/email', trans('labels.forgot_password')) !!}
								</div>
							</div>

							{!! Form::close() !!}
							<div class="row text-center">
								{!! link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Facebook']), 'facebook') !!}&nbsp;|&nbsp;
								{!! link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Google']), 'google') !!}
							</div>

						</ul>

					</li>
				@elseif(Auth::user()->is("Aluno"))
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							@permission('view_backend')
							{{-- This can also be @role('Administrador') instead --}}
							<li>{!! link_to_route('backend.dashboard', trans('navs.administration')) !!}</li>
							@endpermission

							<li>{!! link_to_route('profile.edit',trans('navs.profile'),Auth::user()->id) !!} </li>
							<li>{!! link_to('auth/logout', trans('navs.logout')) !!}</li>
						</ul>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>