@extends('frontend.layouts.master-classroom')

@section('content')

<section role="main" class="content-body">
	<header class="page-header">
		<h2>Ticket</h2>
	
		<div class="right-wrapper pull-right">
			<ol class="breadcrumbs">
				<li>
					<a href="index.html">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li><span>Fale com BJ</span></li>				
				<li><span>Ticket</span></li>
			</ol>
	
			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
		</div>
	</header>

	<!-- start: page -->
	<section class="content-with-menu mailbox">
		<div class="content-with-menu-container" data-mailbox data-mailbox-view="email">
			<div class="inner-menu-toggle">
				<a href="#" class="inner-menu-expand" data-open="inner-menu">
					Show Menu <i class="fa fa-chevron-right"></i>
				</a>
			</div>
			
			
			<div class="inner-body mailbox-email">
				<div class="mailbox-email-header mb-lg">
					<h3 class="mailbox-email-subject m-none text-light">
						Estorno de Cartão De Crédito
					</h3>
			
					<p class="mt-lg mb-none text-md">10 de Novembro de 2015</p>
				</div>
				<div class="mailbox-email-container">
					<div class="mailbox-email-screen">
						<div class="panel">
							<div class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-mail-reply"></a>
								</div>
			
								<p class="panel-title">Brasil Jurídico <i class="fa fa-angle-right fa-fw"></i> Você</p> <p class="m-none"><small>14 de Novembro de 2015, 10:43</small></p>
							</div>
							<div class="panel-body" style="font-size:1.3em;">
								<p>Entramos em contato com o cartão de crédito e o PagSeguro e o seu valor está aguardando os tramites legais do cartão.</p>
								<p>Att, Adhemar Fontes.</p>							
							</div>
							<div class="panel-footer">
								Seu problema foi resolvido? 
								<button class="btn btn-success"><i class="fa fa-thumbs-up mr-xs"></i> Sim</button>
								<button class="btn btn-danger"><i class="fa fa-thumbs-down mr-xs"></i> Não</button>
							</div>
						</div>
						<div class="panel">
							<div class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-up"></a>
									<a href="#" class="fa fa-mail-reply"></a>
								</div>
			
								<p class="panel-title">Você <i class="fa fa-angle-right fa-fw"></i> Brasil Jurídico</p> <p class="m-none"><small>14 de Novembro de 2015, 10:43</small></p>
							</div>
							<div class="panel-body" style="font-size:1.3em; display:none;">
								<p>Eu efetuei um pedido para assistir as aulas do <strong>Curso de Carreira</strong>, porém o valor foi cobrado duplicado. Queria que um dos valores de R$ 420,50 fosse estornado.</p>
								<p>Abs. Pedro Cordier.</p>							
							</div>
							
						</div>
			
						
					<div class="compose">
						
						<div class="text-right mt-md">
							<a href="#" class="btn btn-primary">
								<i class="fa fa-send mr-xs"></i>
								Enviar
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end: page -->
</section>
@endsection