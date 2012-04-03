<?php
$this->breadcrumbs=array(
	'Contatos',
);

$this->menu=array(
	array('label'=>'Adicionar Contato', 'url'=>array('create')),
	array('label'=>'Gerenciar Contatos', 'url'=>array('admin')),
);
?>

<h4>Contatos</h4>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
