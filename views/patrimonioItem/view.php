<?php
$this->breadcrumbs=array(
	'Patrimônios'=>array('index'),
	$model->nro_patrimonio,
);

$this->menu=array(
	array('label'=>'Patrimônios', 'url'=>array('index')),
	array('label'=>'Criar Patrimônio', 'url'=>array('create')),
	array('label'=>'Editar', 'url'=>array('update', 'id'=>$model->cod_item)),
	array('label'=>'Excluir', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cod_item),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gerenciar Patrimônios', 'url'=>array('admin')),
);
?>

<h1>Patrimônio #<?php echo $model->nro_patrimonio; ?></h1>


<div class="view">

	<b><?php echo CHtml::link(CHtml::encode($model->nome), array('view', 'id'=>$model->cod_item)); ?></b>
	<br />

	<b><?php echo CHtml::encode('Termo'); ?>:</b>
	<?php echo CHtml::link(CHtml::encode(PatrimonioTermo::model()->findByPk($model->cod_termo)->nro_termo_responsabilidade), array('patrimoniotermo/view', 'id'=>$model->cod_termo)); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($model->nome); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('nro_patrimonio')); ?>:</b>
	<?php echo CHtml::encode($model->nro_patrimonio); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('valor')); ?>:</b>
	<?php echo CHtml::encode($model->valor); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('descricao')); ?>:</b>
	<?php echo CHtml::encode($model->descricao); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('localizacao')); ?>:</b>
	<?php echo CHtml::encode($model->localizacao); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('data_aquisicao')); ?>:</b>
	<?php echo CHtml::encode($model->data_aquisicao); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('vendedor')); ?>:</b>
	<?php echo CHtml::encode($model->vendedor); ?>
	<br />

</div>
