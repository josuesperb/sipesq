<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nome), array('view', 'id'=>$data->cod_contato)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefone')); ?>:</b>
	<?php echo CHtml::encode($data->telefone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

</div>