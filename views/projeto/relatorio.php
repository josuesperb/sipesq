<?php Yii::app()->clientScript->registerScript('table_financeiro',"

$('.tbl-line-financeiro').hover(
 function(){
 $(this).addClass('table-line-over');
 }, 
 
 function(){
 	$(this).removeClass('table-line-over');
 }
);

")?>


<!-- INFORMACOES GERAIS -->
<h4>Informações Gerais</h4>
<div class="view">
	<b><?php echo CHtml::encode("Cordenador"); ?>:</b>
	<?php echo CHtml::encode($model->coordenador->nome); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('codigo_projeto')); ?>:</b>
	<?php echo CHtml::encode($model->codigo_projeto); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('data_inicio')); ?>:</b>
	<?php echo CHtml::encode($model->data_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('data_fim')); ?>:</b>
	<?php echo CHtml::encode($model->data_fim); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('data_relatorio')); ?>:</b>
	<?php echo CHtml::encode($model->data_relatorio); ?>
	<br />

<hr>
<div class="info">
<?php echo $model->descricao; ?>
</div>
		<h4>Pessoas Atuantes</h4>
		<ul>
		<?php foreach($model->pessoas_atuantes as $pessoa):?>
			 <li><b><?php echo CHtml::encode($pessoa->nome); ?></b></li>
		<?php endforeach;?>
		</ul>
	

<!--  FINANCEIRO -->

<hr>


<h4>Financeiro</h4>
<?php $valor_total_bolsistas = 0;?>
		<div id="chart_financeiro"></div>
		<hr>
		<table id="tbl_fincaneiro">
		<tr><th>Tipo</th><th>Orçamentado (R$)</th><th>Gasto (R$)</th><th>Saldo (R$)</th></tr>
			<tr class="tbl-line-financeiro">
				<td><b>Custeio</b></td>
				<td><?php echo CHtml::encode(number_format($model->verba_custeio,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->gasto_custeio,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->verba_custeio - $model->gasto_custeio,2,',','.')); ?></td>
			</tr>
			
			<tr class="tbl-line-financeiro">
				<td><b>Capital</b></td>
				<td><?php echo CHtml::encode(number_format($model->verba_capital,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->gasto_capital,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->verba_capital - $model->gasto_capital,2,',','.')); ?></td>
			</tr> 
			
			<tr class="tbl-line-financeiro">
				<td><b>Bolsas</b></td>
				<td><?php echo CHtml::encode(number_format($model->verba_bolsa,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->gasto_bolsa,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->verba_bolsa - $model->gasto_bolsa,2,',','.')); ?></td>
			</tr>
			
			<tr class="tbl-line-financeiro">
				<td><b>Outros</b></td>
				<td><?php echo CHtml::encode(number_format($model->verba_outros,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->gasto_outros,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->verba_outros - $model->gasto_outros,2,',','.')); ?></td>
			</tr>
			
			<tr class="tbl-line-financeiro">
				<td><b>Total</b></td>
				<td><?php echo CHtml::encode(number_format($model->verba_outros + $model->verba_bolsa + $model->verba_capital + $model->verba_custeio,2,',','.')); ?></td>
				<td><?php echo CHtml::encode(number_format($model->gasto_outros + $model->gasto_bolsa + $model->gasto_capital + $model->gasto_custeio,2,',','.')); ?></td>
				<?php $total_saldo = $model->verba_outros + $model->verba_bolsa + $model->verba_capital + $model->verba_custeio - ($model->gasto_outros + $model->gasto_bolsa + $model->gasto_capital + $model->gasto_custeio);?>
				<td><?php echo CHtml::encode(number_format($total_saldo,2,',','.')); ?></td>
			</tr>  
			
	 	</table>
		</div> <!-- Fim div table financeiro e gráficos -->
	
		<?php if(count($model->patrimonio_termos) > 0):?>
			<div class="view">
			<h4>Termos de Patrimônios</h4>
			<ul>
			<?php foreach($model->patrimonio_termos as $termo):?>
				 <li>
				 <b><?php echo CHtml::encode('Termo ' .$termo->nro_termo_responsabilidade .' ( ' .$termo->responsavel .' )'); ?></b>
					 <ul>
					 <?php foreach ( $termo->patrimonio_items as $patrimonio ):?>
					 <li>
					 <?php echo date("d/m/Y", strtotime($patrimonio->data_aquisicao)); ?> - <b><?php echo $patrimonio->nro_patrimonio ." " .$patrimonio->nome?></b> - R$ <?php echo number_format($patrimonio->valor,2,',','.');?>  
					 </li>
					 <?php endforeach;?>
					 </ul>
				 </li>
			<?php endforeach;?>
			</ul>
			<br><label>Total gasto em patrimônios:</label>
			R$<?php echo CHtml::encode(number_format($model->gasto_patrimonios,2,',','.'));?><br><br>
			</div>
		<?php endif;?>
		<?php if(count($model->livros) > 0):?>
		<div class="view">
			<h4>Livros</h4>
			<ul>
			<?php foreach($model->livros as $livro):?>
				 <li><b><?php echo CHtml::encode($livro->titulo); ?></b></li>
			<?php endforeach;?>
			</ul>
			<br><label>Total gasto com livros:</label>
			R$<?php echo CHtml::encode(number_format($model->gasto_livros,2,',','.'));?>
			</div>
		<?php endif;?>
		<div class="view">
		<h4>Pagamentos</h4>
		
		<ul>
		<?php foreach($model->pessoas_recebimento as $bolsista):?>
				<?php 
					$pessoa_bolsista = Pessoa::model()->findByPk($bolsista->cod_pessoa);
					$categoria = FinanceiroCategoria::model()->findByPk($bolsista->cod_categoria);
					$valor_total_bolsistas += $bolsista->valor_total; 
				
				?>
					<li>
						<b><?php echo CHtml::encode($pessoa_bolsista->nome); ?></b>
						<ul>
							 <li>Prazo: <?php echo CHtml::encode(date("d/m/Y", strtotime($bolsista->data_inicio))) . ' a ' .CHtml::encode(date("d/m/Y", strtotime($bolsista->data_fim)));?> </li>
							 <li>Valor: R$ <?php echo CHtml::encode(number_format($bolsista->valor,2,',','.'));?></li>
							 <li>Categoria: <?php echo CHtml::encode($categoria->nome);?></li>
							 <li>Fonte: <?php echo CHtml::encode($bolsista->fontePagadora->nome)?> </li>
							 <li>Relatório: <?php echo CHtml::encode(date("d/m/Y", strtotime($bolsista->data_relatorio)));?></li>
						</ul>
						
					</li>
		<?php endforeach;?>
		</ul>
	</div>
	
	<!-- RELATORIO ATIVIDADES -->
	
	<div class="view">
	<h4>Atividades</h4>
	<?php if(count($model->atividades) < 1):?>
	<div class="view">Não há atividades cadastradas neste projeto</div>
	<?php endif;?>
	<?php foreach ($model->atividades as $atividade):?>
	
			<div class="view atividade <?php echo $atividade->class;?>">
		
				<b><?php echo CHtml::encode($atividade->nome_atividade); ?></b>
				 ( <?php echo CHtml::encode($atividade->data_inicio);?> a <?php echo CHtml::encode($atividade->data_fim);?> )
				<br />
			
				<b><?php echo CHtml::encode($atividade->getAttributeLabel('cod_pessoa')); ?>:</b>
				<?php echo CHtml::encode($atividade->responsavel->nome); ?>
				<br />
				
				
				<b>Categoria:</b>
				<?php if(is_object($atividade->categoria)):?>
				<?php if($atividade->categoria->categoriaPai->cod_categoria != $atividade->categoria->cod_categoria ):?>
					<?php echo CHtml::encode($atividade->categoria->categoriaPai->nome);?> <b>&gt;</b> 
				<?php endif;?>
				 <?php echo CHtml::encode($atividade->categoria->nome);?>
				<?php endif;?>
					
				<br />
			
				<b>Pessoas:</b>
				<?php foreach($atividade->pessoas as $pess):?>
					<?php echo CHtml::encode($pess->nome)?>, 
				<?php endforeach;?>
				<br />
				
				<b>Projetos:</b>
				<?php foreach($atividade->projetos as $proj):?>
					<?php echo CHtml::encode($proj->nome)?>, 
				<?php endforeach;?>
				<br />
			
				<b><?php echo CHtml::encode($atividade->getAttributeLabel('status')); ?>:</b>
				<?php echo CHtml::encode($atividade->status); ?>
				<br />
		
			</div> 
	<?php endforeach;?>	

	</div>
	
	
<script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});

      google.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Origem');

        data.addColumn('number', 'Orçamentado');

        data.addColumn('number', 'Gasto');

        data.addColumn('number', 'Saldo');

        data.addRows(4);



        data.setValue(0, 0, 'Bolsas');

        data.setValue(0, 1, <?php echo (int)$model->verba_bolsa;?>);

        data.setValue(0, 2, <?php echo (int)$model->gasto_bolsa;?>);

        data.setValue(0, 3, <?php echo (int)($model->verba_bolsa - $model->gasto_bolsa);?>);

        



		data.setValue(1, 0, 'Custeio');

        data.setValue(1, 1, <?php echo (int)$model->verba_custeio;?>);

        data.setValue(1, 2, <?php echo (int)$model->gasto_custeio;?>);

        data.setValue(1, 3, <?php echo (int)($model->verba_custeio - $model->gasto_custeio);?>);

        

	

		data.setValue(2, 0, 'Capital');

        data.setValue(2, 1,<?php echo (int)$model->verba_capital;?>);

        data.setValue(2, 2,<?php echo (int)$model->gasto_capital;?>);

        data.setValue(2, 3,<?php echo (int)($model->verba_capital - $model->gasto_capital);?>);

        

        data.setValue(3, 0, 'Outros');

        data.setValue(3, 1,<?php echo (int)$model->verba_outros; ?>);

        data.setValue(3, 2,<?php echo (int)$model->gasto_outros; ?>);

        data.setValue(3, 3,<?php echo (int)($model->verba_outros - $model->gasto_outros); ?>);

        
        var formatter = new google.visualization.NumberFormat(
        	      {prefix: 'R$', negativeColor: 'red', negativeParens: true});
        		formatter.format(data, 0); 
  	  			formatter.format(data, 1); 
        	  	formatter.format(data, 2); 
        	  	formatter.format(data, 3); 


        var chart = new google.visualization.ColumnChart(document.getElementById('chart_financeiro'));

		
		var chartOptions = {width: 650, height: 280, title: 'Projeto <?php echo $model->nome?>',
				colors: ['blue', 'red', 'green'],
                hAxis: {title: 'Origem da verba', titleTextStyle: {color: 'red'}},
                vAxis: {title: 'Gastos em R$', titleTextStyle: {color: 'red'}},
                legend: 'top'
                
               };

		//Desenha o chart.
        chart.draw(data, chartOptions);

      }
 </script>
