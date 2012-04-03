<div class="view">

	<b><?php echo CHtml::link(CHtml::encode($data->titulo), array('view', 'id'=>$data->cod_livro)); ?></b>
	<br />
	<?php if($data->subtitulo != ''):?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('subtitulo')); ?>:</b>
	<?php echo CHtml::encode($data->subtitulo); ?>
	<br />
	<?php endif;?>
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('autor')); ?>:</b>
	<?php echo CHtml::encode($data->autor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ano')); ?>:</b>
	<?php echo CHtml::encode($data->ano); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('isbn')); ?>:</b>
	<?php echo CHtml::encode($data->isbn); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('cod_projeto')); ?>:</b>
	<?php echo CHtml::encode($data->projeto->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('editora')); ?>:</b>
	<?php echo CHtml::encode($data->editora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cidade_publicacao')); ?>:</b>
	<?php echo CHtml::encode($data->cidade_publicacao); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_edicao')); ?>:</b>
	<?php echo CHtml::encode($data->nro_edicao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_patrimonio')); ?>:</b>
	<?php echo CHtml::encode($data->nro_patrimonio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor')); ?>:</b>
	<?php echo CHtml::encode($data->valor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('local_compra')); ?>:</b>
	<?php echo CHtml::encode($data->local_compra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_nota_fiscal')); ?>:</b>
	<?php echo CHtml::encode($data->nro_nota_fiscal); ?>
	<br />

	*/ ?>

</div>