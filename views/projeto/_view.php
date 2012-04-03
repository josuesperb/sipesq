<div class="view">
	
	<h1><?php echo CHtml::link(CHtml::encode($data->nome), array('view', 'id'=>$data->cod_projeto)); ?></h1>
	<br />
	
	<b><?php echo CHtml::encode("Professor Responsável"); ?></b>
	<?php echo CHtml::encode($data->professor->nome); ?>
	<br />
	
	<b><?php echo CHtml::encode("Pós-Graduando Responsável"); ?>:</b>
	<?php if(is_object($data->pos_graduando)):?>
		<?php echo CHtml::encode($data->pos_graduando->nome); ?>
	<?php else:?>
	Não há pós-graduando responsável
	<?php endif;?>
	<br />
	
	<b><?php echo CHtml::encode("Graduando Responsável"); ?>:</b>
	<?php if(is_object($data->graduando)):?>
		<?php echo CHtml::encode($data->graduando->nome); ?>
	<?php else:?>
	Não há graduando responsável
	<?php endif;?>
	<br />
	
	<b><?php echo CHtml::encode("Tipo do Projeto"); ?>:</b>
	<?php echo CHtml::encode($data->categoria->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_projeto')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_projeto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_inicio')); ?>:</b>
	<?php echo CHtml::encode($data->data_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_fim')); ?>:</b>
	<?php echo CHtml::encode($data->data_fim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_relatorio')); ?>:</b>
	<?php echo CHtml::encode($data->data_relatorio); ?>
	<br />


</div>