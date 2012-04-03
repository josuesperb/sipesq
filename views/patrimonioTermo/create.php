<?php
$this->breadcrumbs=array(
	'Patrimonio Termos'=>array('index'),
	'Adicionar',
);

$this->menu=array(
	array('label'=>'Listar Termos', 'url'=>array('index')),
	array('label'=>'Gerenciar Termos', 'url'=>array('admin')),
);
?>

<h1>Adicionar Termo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>