<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pessoa-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome'); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'cod_categoria'); ?>
		<?php  echo $form->dropDownList($model,'cod_categoria', CHtml::listData(PessoaCategoria::model()->findAll(array('order'=>'nome')), 'cod_categoria', 'nome'), array('prompt'=>"Selecione uma Função")); ?>
		<?php echo $form->error($model,'cod_categoria'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'equipe_atual'); ?>
		<?php echo $form->checkBox($model,'equipe_atual'); ?>
		<?php echo $form->error($model,'equipe_atual'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nome_mae'); ?>
		<?php echo $form->textField($model,'nome_mae'); ?>
		<?php echo $form->error($model,'nome_mae'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'data_nascimento'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'name'=>'Pessoa[data_nascimento]',
				'value'=>isset($model->data_nascimento) ? date("Y-m-d",strtotime($model->data_nascimento)) : date("Y-m-d", strtotime("1980-01-01")),
				'language'=>'pt-BR',
			    // additional javascript options for the date picker plugin
    			'options'=>array('showAnim'=>'drop','dateFormat'=>'yy-mm-dd'),
			    'htmlOptions'=>array('style'=>'height:15px;'),));
		?>
		<?php echo $form->error($model,'data_nascimento'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'telefone'); ?>
		<?php echo $form->textField($model,'telefone'); ?>
		<?php echo $form->error($model,'telefone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cpf'); ?>
		<?php echo $form->textField($model,'cpf'); ?>
		<?php echo $form->error($model,'cpf'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rg'); ?>
		<?php echo $form->textField($model,'rg'); ?>
		<?php echo $form->error($model,'rg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cartao_ufrgs'); ?>
		<?php echo $form->textField($model,'cartao_ufrgs'); ?>
		<?php echo $form->error($model,'cartao_ufrgs'); ?>
	</div>
	
	
	<div class="row">
	<?php echo $form->labelEx($model,'projetos_atuante'); ?>
		<div class="checkboxlist">
		<?php echo $form->listBox($model,'projetos_atuante', CHtml::listData(Projeto::model()->findAll(array('order'=>'nome')), 'cod_projeto', 'nome'), array("multiple"=>"multiple", "size"=>"10",)  ); ?>
		</div>
	</div>
	<div class="hint">Segure a tecla <b>CTRL</b> para selecionar mais de um projeto.</div><br>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cidade'); ?>
		<?php echo $form->textField($model,'cidade'); ?>
		<?php echo $form->error($model,'cidade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rua_complemento'); ?>
		<?php echo $form->textField($model,'rua_complemento'); ?>
		<?php echo $form->error($model,'rua_complemento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bairro'); ?>
		<?php echo $form->textField($model,'bairro'); ?>
		<?php echo $form->error($model,'bairro'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cep'); ?>
		<?php echo $form->textField($model,'cep'); ?>
		<?php echo $form->error($model,'cep'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'banco'); ?>
		<?php echo $form->textField($model,'banco'); ?>
		<?php echo $form->error($model,'banco'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agencia'); ?>
		<?php echo $form->textField($model,'agencia'); ?>
		<?php echo $form->error($model,'agencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conta_corrente'); ?>
		<?php echo $form->textField($model,'conta_corrente'); ?>
		<?php echo $form->error($model,'conta_corrente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lattes'); ?>
		<?php echo $form->textField($model,'lattes'); ?>
		<?php echo $form->error($model,'lattes'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'cod_vinculo_institucional'); ?>
		<?php  echo $form->dropDownList($model,'cod_vinculo_institucional', CHtml::listData(VinculoInstitucional::model()->findAll(array('order'=>'nome')), 'cod_vinculo_institucional', 'nome'), array('prompt'=>"Selecione uma Instituição")); ?>
		<?php echo $form->error($model,'cod_vinculo_institucional'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cod_banco'); ?>
		<?php echo $form->textField($model,'cod_banco'); ?>
		<?php echo $form->error($model,'cod_banco'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Adicionar' : 'Salvar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->