<?php
$this->breadcrumbs=array(
	'Projetos'=>array('index'),
	'Criar',
);

$this->menu=array(
	array('label'=>'Listar Projetos', 'url'=>array('index')),
	array('label'=>'Gerenciar Projetos', 'url'=>array('admin')),
);
?>

<h1>Criar Projeto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>