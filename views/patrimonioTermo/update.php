<?php
$this->breadcrumbs=array(
	'Patrimonio Termos'=>array('index'),
	$model->cod_termo=>array('view','id'=>$model->cod_termo),
	'Editar',
);

$this->menu=array(
	array('label'=>'List PatrimonioTermo', 'url'=>array('index')),
	array('label'=>'Create PatrimonioTermo', 'url'=>array('create')),
	array('label'=>'View PatrimonioTermo', 'url'=>array('view', 'id'=>$model->cod_termo)),
	array('label'=>'Manage PatrimonioTermo', 'url'=>array('admin')),
);
?>

<h1>Editar Termo <?php echo $model->cod_termo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>