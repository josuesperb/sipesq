<?php
$this->breadcrumbs=array(
	'Atividades'=>array('index'),
	$model->nome_atividade=>array('view','id'=>$model->cod_atividade),
	'Editar',
);

$this->menu=array(
	array('label'=>'Listar Atividades', 'url'=>array('index')),
	array('label'=>'Adicionar Atividade', 'url'=>array('create')),
	array('label'=>'Ver esta Atividade', 'url'=>array('view', 'id'=>$model->cod_atividade)),
	array('label'=>'Gerenciar Atividades', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->nome_atividade; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>