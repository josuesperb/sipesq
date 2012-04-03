<?php 
			Yii::app()->clientScript->registerScript('pagamentos', "
						
		$('.detalhe_pagamento_btn').toggle(
			function(){
				a = $(this).parent();
				$(this).text('Ocultar Detalhes');
				b = a.children('div');
				b.show('fast');
				return false;
			},
			function(){
				a = $(this).parent();
				$(this).text('Detalhes');
				b = a.children('div');
				b.hide('fast');
				return false;
			}
		);
		
		$('#all_pagamento_fechado_btn').toggle(
			function(){
				$(this).text('Ocultar Pagamentos Fechados');
				$('.detalhe_pagamento').hide();
				$('.verde').show('fast');
				$('.detalhe_pagamento_btn').toggle();
				return false;
			},
			
			function(){
				$(this).text('Pagamentos Fechados');
				$('.verde').hide('fast');
				$('.detalhe_pagamento_btn').toggle('slow');
				return false;
			}
		
		);
		
		$('#all_pagamento_aberto_btn').toggle(
			function(){
				$(this).text('Ocultar Pagamentos Abertos');
				$('.detalhe_pagamento').hide();
				pagamentos = 
				$('.amarelo').show('fast');
				$('.detalhe_pagamento_btn').toggle();
				return false;
			},
			
			function(){
				$(this).text('Pagamentos Abertos');
				$('.amarelo').hide('fast');
				$('.detalhe_pagamento_btn').toggle('slow');
				return false;
			}
		
		);
		
		$('#all_detalhe_pagamento_btn').toggle(
			function(){
				$(this).text('Ocultar Pagamentos');
				$('.detalhe_pagamento').show('fast');
				$('.detalhe_pagamento_btn').toggle();
				return false;
			},
			
			function(){
				$(this).text('Mostrar Pagamentos');
				$('.detalhe_pagamento').hide('fast');
				$('.detalhe_pagamento_btn').toggle('slow');
				return false;
			}
		
		);
		
		");
?>

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

<?php $valor_total_bolsistas = 0;?>
<h4>Informações Financeiras</h4>
	<div class="view">
		<div id="chart_financeiro"></div>
		<?php if($model->ultima_modificacao != null):?>
			<p>Última Modificação: <?php echo date("Y-m-d", strtotime($model->ultima_modificacao))?></p>
		<?php endif;?>
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
	 		<?php echo CHtml::submitButton('Criar Gasto / Verba', array('submit'=>array('projetoFinanceiro/create','id'=>$model->cod_projeto))); ?>
	 		<?php echo CHtml::submitButton('Gerenciar Gastos / Verbas', array('submit'=>array('projetoFinanceiro/admin','id'=>$model->cod_projeto))); ?>
		</div> <!-- Fim div table financeiro e gráficos -->
	
		<?php if(count($model->patrimonio_termos) > 0):?>
			<div class="view">
			<h4>Termos de Patrimônios</h4>
			<ul>
			<?php foreach($model->patrimonio_termos as $termo):?>
				 <li><b><?php echo CHtml::link(CHtml::encode('Termo ' .$termo->nro_termo_responsabilidade .' ( ' .$termo->responsavel .' )'), array('patrimoniotermo/view', 'id'=>$termo->cod_termo)); ?></b></li>
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
				 <li><b><?php echo CHtml::link(CHtml::encode($livro->titulo), array('livro/view', 'id'=>$livro->cod_livro)); ?></b></li>
			<?php endforeach;?>
			</ul>
			<br><label>Total gasto com livros:</label>
			R$<?php echo CHtml::encode(number_format($model->gasto_livros,2,',','.'));?>
			</div>
		<?php endif;?>
		<div class="view">
		<h4>Pagamentos</h4>
		
		<?php if(!Yii::app()->user->isGuest):?>	
		<b><?php echo CHtml::link('Mostrar Pagamentos','#',array('id'=>'all_detalhe_pagamento_btn')); ?> ::</b>
		<b><?php echo CHtml::link('Mostrar Pagamentos Abertos','#',array('id'=>'all_pagamento_aberto_btn')); ?> ::</b> 
		<b><?php echo CHtml::link('Mostrar Pagamentos Fechados','#',array('id'=>'all_pagamento_fechado_btn')); ?></b> <hr>
		<?php endif;?> 
		
		<ul>
		<?php foreach($model->pessoas_recebimento as $bolsista):?>
				<?php 
					$pessoa_bolsista = Pessoa::model()->findByPk($bolsista->cod_pessoa);
					$categoria = $bolsista->categoria;
					$valor_total_bolsistas += $bolsista->valor_total; 
				
				?>
					<li>
						 <b><?php echo CHtml::link(CHtml::encode($categoria . ' - ' .$pessoa_bolsista->nome), array('pessoaFinanceiro/view', 'id'=>$bolsista->cod_financeiro)); ?></b>
						 
						 
							<?php $this->renderPartial('_detalhe_pagamento',array(
								'pagamento'=>$bolsista,
							)); ?>
				
							<?php if(!Yii::app()->user->isGuest):?>
								<br><?php echo CHtml::link('Detalhes','#',array('class'=>'detalhe_pagamento_btn')); ?>
							<?php endif;?> 
					</li>
		<?php endforeach;?>
		</ul>
				
	</div><!-- Fim Info Financeiro -->
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