<?php
$this->breadcrumbs=array(
	'Patrimônios'=>array('index'),
	'Adicionar',
);

$this->menu=array(
	array('label'=>'Termos de Patrimônios', 'url'=>array('patrimoniotermo/index')),
	array('label'=>'Todos os Patrimônios', 'url'=>array('index')),
	array('label'=>'Gerenciar Patrimônios', 'url'=>array('admin')),
);
?>

<h1>Adicionar Patrimônio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>