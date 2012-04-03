<?php
$this->breadcrumbs=array(
	'Atividades'=>array('index'),
	$model->nome_atividade,
);

$this->menu=array(
	array('label'=>'Listar Atividades', 'url'=>array('index')),
	array('label'=>'Adicionar Atividade', 'url'=>array('create')),
	array('label'=>'Editar Atividade', 'url'=>array('update', 'id'=>$model->cod_atividade)),
	array('label'=>'Deletar Atividade', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cod_atividade),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gerenciar Atividades', 'url'=>array('admin')),
);
?>


<div class="view <?php echo $model->class;?>">
<h4 align="center"><b><?php echo $model->nome_atividade; ?></b></h4>
	
	<b>Categoria:</b>
	<?php if(is_object($model->categoria)):?>
	<?php if($model->categoria->categoriaPai->cod_categoria != $model->categoria->cod_categoria ):?>
		<?php echo CHtml::encode($model->categoria->categoriaPai->nome);?> <b>&gt;</b> 
	<?php endif;?>
	 <?php echo CHtml::encode($model->categoria->nome);?>
	<?php endif;?>
		
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('responsavel')); ?>:</b>
	<?php echo CHtml::encode($model->responsavel->nome); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('tipo_vinculo')); ?>:</b>
	<?php echo CHtml::encode($model->tipo_vinculo); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('data_inicio')); ?>:</b>
	<?php echo CHtml::encode($model->data_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('data_fim')); ?>:</b>
	<?php echo CHtml::encode($model->data_fim); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('turnos_trabalho')); ?>:</b>
	<?php echo CHtml::encode($model->turnos_trabalho); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($model->status); ?>
	<br />

</div>
	
<div class="info">
	<?php echo $model->descricao; ?>
</div>

<div class="view">
	<label><b>Participantes</b></label><br>
	<?php foreach($model->pessoas as $pessoa):?>
		<?php echo CHtml::encode($pessoa->nome); ?>
		<br />
	<?php endforeach;?>
</div>

<div class="view">
	<label><b>Projetos</b></label><br>
	<?php foreach($model->projetos as $projeto):?>
		<?php echo CHtml::encode($projeto->nome); ?>
		<br />
	<?php endforeach;?>
</div>

<div class="view">
	<label><b>Bolsas</b></label><br>
	<?php foreach($model->bolsas as $bolsa):?>
		<?php echo CHtml::encode($bolsa->categoria .' (' .$bolsa->pessoa->nome .')'); ?>
		<br />
	<?php endforeach;?>
</div>



