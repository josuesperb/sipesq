<?php
$this->breadcrumbs=array(
	'Patrimônios'=>array('index'),
	$model->nro_patrimonio=>array('view','id'=>$model->cod_item),
	'Editar',
);

$this->menu=array(
	array('label'=>'Termos de Patrimônios', 'url'=>array('patrimoniotermo/index')),
	array('label'=>'Todos os Patrimônios', 'url'=>array('index')),
	array('label'=>'Adicionar Patrimônio', 'url'=>array('create')),
	array('label'=>'Ver Patrimônio', 'url'=>array('view', 'id'=>$model->cod_item)),
	array('label'=>'Gerenciar Patrimônios', 'url'=>array('admin')),

);
?>

<h1>Editar Patrimônio  <?php echo $model->nro_patrimonio; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>