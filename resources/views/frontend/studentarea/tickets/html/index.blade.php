@extends('frontend.layouts.master-classroom')

@section('content')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Fale com o BJ</h2>
	
		<div class="right-wrapper pull-right">
			<ol class="breadcrumbs">
				<li>
					<a href="index.html">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li><span>Fale com o BJ</span></li>
				<li><span>Tickets</span></li>
			</ol>
	
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
		</div>
	</header>
	<!-- start: page -->
	<section class="content-with-menu mailbox">
		<div class="content-with-menu-container" data-mailbox data-mailbox-view="folder">
			<div class="inner-menu-toggle">
				<a href="#" class="inner-menu-expand" data-open="inner-menu">
					Show Menu <i class="fa fa-chevron-right"></i>
				</a>
			</div>
			
			<menu id="content-menu" class="inner-menu" role="menu">
				<div class="nano">
					<div class="nano-content">
			
						<div class="inner-menu-toggle-inside">
							<a href="#" class="inner-menu-collapse">
								<i class="fa fa-chevron-up visible-xs-inline"></i><i class="fa fa-chevron-left hidden-xs-inline"></i> Fechar Menu
							</a>
			
							<a href="#" class="inner-menu-expand" data-open="inner-menu">
								Abrir Menu <i class="fa fa-chevron-down"></i>
							</a>
						</div>
			
						<div class="inner-menu-content">
							<a href="ticket-new.php" class="btn btn-block btn-primary btn-md pt-sm pb-sm text-md">
								<i class="fa fa-envelope mr-xs"></i>
								Abrir Ticket
							</a>
			
							<div class="sidebar-widget m-none  mt-xl pt-md">
								<div class="widget-header">
									<h6 class="title">Visualizar</h6>
									<span class="widget-toggle">+</span>
								</div>
								<div class="widget-content">
									<ul class="list-unstyled mailbox-bullets">
										<li>
											<a href="#" class="menu-item">Aberto <span class="ball blue"></span></a>
										</li>
										<li>
											<a href="#" class="menu-item">Respondido <span class="ball green"></span></a>
										</li>
										<li>
											<a href="#" class="menu-item">Fechado <span class="ball red"></span></a>
										</li>
									</ul>
			
							</div>
			
							</div>
						</div>
					</div>
				</div>
			</menu>
			<div class="inner-body mailbox-folder">
				<!-- START: .mailbox-header -->
				<header class="mailbox-header">
					<div class="row">
						<div class="col-sm-6">
							<h1 class="mailbox-title text-light m-none">
								<a id="mailboxToggleSidebar" class="sidebar-toggle-btn trigger-toggle-sidebar">
									<span class="line"></span>
									<span class="line"></span>
									<span class="line"></span>
									<span class="line line-angle1"></span>
									<span class="line line-angle2"></span>
								</a>
			
								Inbox
							</h1>
						</div>
						<div class="col-sm-6">
							<div class="search">
								<div class="input-group input-search">
									<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</header>
				<!-- END: .mailbox-header -->
			
				<!-- START: .mailbox-actions -->
				<div class="mailbox-actions">
					<ul class="list-unstyled m-none pt-lg pb-lg">
						
						<li class="ib mr-sm">
							<a class="item-action fa fa-refresh" href="#"></a>
						</li>
						
						<li class="ib">
							<a class="item-action fa fa-times text-danger" href="#"></a>
						</li>
					</ul>
				</div>
				<!-- END: .mailbox-actions -->
			
				<div id="mailbox-email-list" class="mailbox-email-list">
					<div class="nano">
						<div class="nano-content">
							<ul id="" class="list-unstyled">
								<li>
									<a href="ticket-view.php">
										<i class="mail-label" style="border-color: #EA4C89"></i>
			
										<div class="col-sender">
											<div class="checkbox-custom checkbox-text-primary ib">
												<input type="checkbox" id="mail2">
												<label for="mail2"></label>
											</div>
											<p class="m-none ib">Financeiro</p>
										</div>
										<div class="col-mail">
											<p class="m-none mail-content">
												<span class="subject">Estornar cartão de credito</span>
											</p>
											<i class="mail-attachment fa fa-paperclip"></i>
											<p class="m-none mail-date">13:40</p>
										</div>
									</a>
								</li>
								<li>
									<a href="ticket-view.php">
										<i class="mail-label" style="border-color: #EA4C89"></i>
			
										<div class="col-sender">
											<div class="checkbox-custom checkbox-text-primary ib">
												<input type="checkbox" id="mail2">
												<label for="mail2"></label>
											</div>
											<p class="m-none ib">Suporte ao Aluno</p>
										</div>
										<div class="col-mail">
											<p class="m-none mail-content">
												<span class="subject">Estornar cartão de credito</span>
											</p>
											<i class="mail-attachment fa fa-paperclip"></i>
											<p class="m-none mail-date">13:40</p>
										</div>
									</a>
								</li>
								<li>
									<a href="ticket-view.php">
										<i class="mail-label" style="border-color: #EA4C89"></i>
			
										<div class="col-sender">
											<div class="checkbox-custom checkbox-text-primary ib">
												<input type="checkbox" id="mail2">
												<label for="mail2"></label>
											</div>
											<p class="m-none ib">TI</p>
										</div>
										<div class="col-mail">
											<p class="m-none mail-content">
												<span class="subject">Estornar cartão de credito</span>
											</p>
											<i class="mail-attachment fa fa-paperclip"></i>
											<p class="m-none mail-date">13:40</p>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end: page -->
</section>

@endsection