<?php
$this->breadcrumbs=array(
	'Projetos'=>array('index'),
	$model->nome=>array('view','id'=>$model->cod_projeto),
	'Editar',
);

$this->menu=array(
	array('label'=>'Listar Projetos', 'url'=>array('index')),
	array('label'=>'Criar Novo Projeto', 'url'=>array('create')),
	array('label'=>'Ver este Projeto', 'url'=>array('view', 'id'=>$model->cod_projeto)),
	array('label'=>'Gerenciar Projetos', 'url'=>array('admin')),
);
?>

<h1> <?php echo $model->nome; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>