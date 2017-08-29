
	<!-- start: sidebar -->
	<aside id="sidebar-left" style="background:#FFF;box-shadow:-5px 0 0 #e2e3e6 inset" class="sidebar-left">

		<div class="sidebar-header">
			<div class="sidebar-title">
				Navegação
			</div>
			<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
			</div>
		</div>

		<div class="nano">
			<div class="nano-content" id="nano-content-element">
				<nav id="menu" class="nav-main" role="navigation">
					<ul class="nav nav-main">
						<li>
							<a href="{{ Route('frontend.dashboard') }}">
								<i class="fa fa-home" aria-hidden="true"></i>
								<span>Meus Cursos</span>
							</a>
																																																									</li>
						<li>
							<a href="{!! Route('profile.edit', Auth::user()->id) !!}">
								<i class="fa fa-user" aria-hidden="true"></i>
								<span>Meus Dados</span>
							</a>
						</li>
						<li>
							<a href="{{ Route('student.ticketstudents.index') }}">
								<i class="fa fa-envelope" aria-hidden="true"></i>
								<span>Fale com o Brasil Jurídico</span>
							</a>
						</li>
						<li>
							<a href="{{ Route('student.orders') }}">
								<i class="fa fa-shopping-cart" aria-hidden="true"></i>
								<span>Meus Pedidos</span>
							</a>
						</li>

					</ul>
				</nav>

			</div>

		</div>

	</aside>
	<!-- end: sidebar -->