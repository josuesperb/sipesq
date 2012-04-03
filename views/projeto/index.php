<?php
$this->breadcrumbs=array(
	'Projetos',
);

$this->menu=array(
	array('label'=>'Adicionar Projetos', 'url'=>array('create')),
	array('label'=>'Gerenciar Projetos', 'url'=>array('admin')),
);
?>

<h1>Projetos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
