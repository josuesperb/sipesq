<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'cod_atividade'); ?>
		<?php echo $form->textField($model,'cod_atividade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cod_pessoa'); ?>
		<?php echo $form->textField($model,'cod_pessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_vinculo'); ?>
		<?php echo $form->textField($model,'tipo_vinculo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nome_atividade'); ?>
		<?php echo $form->textField($model,'nome_atividade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descricao'); ?>
		<?php echo $form->textArea($model,'descricao',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_inicio'); ?>
		<?php echo $form->textField($model,'data_inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_fim'); ?>
		<?php echo $form->textField($model,'data_fim'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'turnos_trabalho'); ?>
		<?php echo $form->textField($model,'turnos_trabalho'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estagio'); ?>
		<?php echo $form->checkBox($model,'estagio'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->