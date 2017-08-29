<?php include('includes/header.php'); ?>

	
	<section role="main" class="content-body">
					<header class="page-header">
						<h2>Novo Ticket</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Fale com BJ</span></li>
								<li><span>Tickets</span></li>
								<li><span>Novo</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<section class="content-with-menu content-with-menu-has-toolbar mailbox">
						<div class="content-with-menu-container" data-mailbox data-mailbox-view="compose">
							<div class="inner-menu-toggle">
								<a href="#" class="inner-menu-expand" data-open="inner-menu">
									Show Menu <i class="fa fa-chevron-right"></i>
								</a>
							</div>
							
							
							<div class="inner-body">
								<div class="inner-toolbar clearfix">
									<ul>
										<li>
											<a href="#"><i class="fa fa-send-o mr-sm"></i> Enviar Ticket</a>
										</li>
										<li>
											<a href="#"><i class="fa fa-times mr-sm"></i> Cancelar</a>
										</li>
										
									</ul>
								</div>
								<div class="mailbox-compose">
									<form class="form-horizontal form-bordered form-bordered">
							
										<div class="form-group form-group-invisible">
											<label for="to" class="control-label-invisible">Setor:</label>
											<div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
												<select class="form-control form-control-invisible">
														<option value="">Escolha o setor</option>
														<option>Financeiro</option>
														<option>TI</option>
														<option>Outro setor</option>
													</select>
											</div>
										</div>							
								
										<div class="form-group form-group-invisible">
											<label for="subject" class="control-label-invisible">Assunto:</label>
											<div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
												<input id="subject" type="text" class="form-control form-control-invisible" value="">
											</div>
										</div>
										<div class="form-group form-group-invisible">
											<label for="to" class="control-label-invisible">Setor:</label>
											<div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
												<select class="form-control form-control-invisible">
																<option>Alta</option>
														<option selected="">Média</option>
														<option>Baixa</option>
													</select>
											</div>
										</div>	
										<div class="form-group form-group-invisible">
											<label for="to" class="control-label-invisible">Anexo:</label>
											<div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
												<input id="subject" type="file" class="form-control form-control-invisible" value="">
												(.pdf, .jpeg, .png)
											</div>
										</div>	

										
							
										<div class="form-group">
											<textarea class="form-control" rows="10" id="textareaDefault"></textarea>	
										</div>

										<div class="text-right mt-md">
											<a href="#" class="btn btn-lg btn-primary">
												<i class="fa fa-send  mr-xs"></i>
												Enviar
											</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
					<!-- end: page -->
				</section>

<?php include('includes/footer-ticket.php'); ?>