<h4><b>Agenda Cepik</b></h4>
<div class="view agenda">
<!--		<iframe src="https://www.google.com/calendar/embed?src=gerenciacepik%40gmail.com&ctz=America/Sao_Paulo" style="border: 0" width="100%" height="300" frameborder="0" scrolling="no"></iframe>-->
		<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=455&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=forumstanford%40gmail.com&amp;color=%2329527A&amp;src=gerenciacepik%40gmail.com&ctz=America/Sao_Paulo" style="border: 0" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
	</div><hr>

<h4><b>Pendências</b></h4>
<div class="view-esquerda">

		<!-- Atividades que terminam -->
		<div class="atividades">
			<?php 
					if(!Yii::app()->user->isGuest)
						//Se o usuário estiver logado só mostra as suas atividades
				  		$atividades = Atividade::getLastsByUser(Yii::app()->user->name);
			 		else
			 			//caso contrario mostra as atividades em geral
						$atividades = Atividade::getLasts();
			?>
			
			<?php if(count($atividades) > 0):?>
				<div class="view">
				<h4>Atividades que Terminam Dentro de 6 Meses</h4>
				<?php foreach ($atividades as $a):?>
					<p><?php echo $a->nome_atividade ?> - <?php echo $a->data_fim?></p>
				<?php endforeach;?>
				</div>
			<?php endif;?>
		</div>

		<!--  Projetos que terminan -->
		
		<?php $projetos = Projeto::getLasts();?>
		<?php if(count($projetos) > 0):?>
			<div class="view">
			<h4>Projetos que Terminam Dentro de 6 Meses</h4>
			<?php foreach ($projetos as $p):?>
				<p><?php echo $p->nome?> - <?php echo $p->data_fim?></p>
			<?php endforeach;?>
			</div>
		<?php endif;?>
		
		<!-- Bolsas que terminam -->
		
		<?php $bolsas = PessoaFinanceiro::getLasts();?>
		<?php if(count($bolsas) > 0):?>
			<div class="view">
			<h4>Bolsas que Terminam Dentro de 6 Meses</h4>
			<?php foreach ($bolsas as $b):?>
				<p><?php echo $b->categoria . ' - ' .$b->pessoa->nome?> - <?php echo $b->data_fim?></p>
			<?php endforeach;?>
			</div>
		<?php endif;?>
</div>



	
	
