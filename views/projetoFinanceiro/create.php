<?php
$this->breadcrumbs=array(
	'Projetos'=>array('projeto/index'),
	'Adicionar Gasto / Verba',
);

$this->menu=array(
	array('label'=>'Listar Finanças', 'url'=>array('index')),
	array('label'=>'Gerenciar Finanças', 'url'=>array('admin')),
);
?>

<h4>Gastos e Verbas de Projetos</h4>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>