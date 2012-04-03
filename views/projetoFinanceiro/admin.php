<?php
$this->breadcrumbs=array(
	'Projeto Financeiros'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProjetoFinanceiro', 'url'=>array('index')),
	array('label'=>'Create ProjetoFinanceiro', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('projeto-financeiro-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Gerenciar Gastos e Verbas de Projetos</h3>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'projeto-financeiro-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'projeto.nome',
		'descricao',
		'tipo',
		'responsavel',
		'valor',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
