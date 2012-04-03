<?php
$this->breadcrumbs=array(
	'Patrimônios'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Termos de Patrimônios', 'url'=>array('patrimoniotermo/index')),
	array('label'=>'Todos os Patrimônios', 'url'=>array('index')),
	array('label'=>'Criar Patrimônio', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('patrimonio-item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar Patrimônios
<?php if(isset($model->cod_termo)):?>
 do Termo #<?php echo PatrimonioTermo::model()->findByPk($model->cod_termo)->nro_termo_responsabilidade;?>
<?php endif;?>
</h1>

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'patrimonio-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nome',
		'nro_patrimonio',
		'valor',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
