<?php Yii::app()->clientScript->registerScript('drop_categoria_pai',"

	$('#drop_categoria_pai').change(
	function(){
	 pai = $('#drop_categoria_pai').val();
	 $.get('/sipesq/index.php/atividadeCategoria/listChildren/'	,
					
				{id: pai},function (data){
						$('#Atividade_cod_categoria').html(data);
					},
					\"html\"); 
	}
	);
");
?>


<?php 
	if($model->isNewRecord){
	Yii::app()->clientScript->registerScript('get_description',"

		$('#Atividade_cod_categoria').change(
		function(){
		 id = $('#Atividade_cod_categoria').val();
		 $.get('/sipesq/index.php/atividadeCategoria/getDescription/'	,
						
					{id: id},function (data){
							$('#Atividade_descricao').html(data);
						},
						\"html\"); 
		}
		);
	");
	}
	
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'atividade-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>
	
		<div class="row">
		<?php echo $form->labelEx($model,'nome_atividade'); ?>
		<?php echo $form->textArea($model,'nome_atividade', array('rows'=>5, 'cols'=>50)); ?>
		<?php echo $form->error($model,'nome_atividade'); ?>
	</div>
	<div class="row">
	<label><b>Categoria Primária</b></label>
	<?php $cPai = ''?>
	<?php if(is_object($model->categoria) && is_object($model->categoria->categoriaPai)) $cPai = $model->categoria->categoriaPai->cod_categoria?>
	<?php  echo CHtml::dropDownList('drop_categoria_pai',$cPai, CHtml::listData(AtividadeCategoria::model()->findAll(array('order'=>'nome', 'condition'=>'cod_categoria_pai = cod_categoria')), 'cod_categoria', 'nome')); ?><br>
	<label><b>Categoria Secundária</b></label>
	<?php  echo $form->dropDownList($model,'cod_categoria', CHtml::listData(AtividadeCategoria::model()->findAll(array('condition'=>'cod_categoria = ' .$model->cod_categoria)),'cod_categoria','nome')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'estagio'); ?>
		<?php echo $form->checkBox($model,'estagio'); ?>
		<?php echo $form->error($model,'estagio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cod_pessoa');?>
		<?php  echo $form->dropDownList($model,'cod_pessoa', CHtml::listData(Pessoa::model()->findAll(array('order'=>'equipe_atual DESC, nome')), 'cod_pessoa', 'nome', 'equipe')); ?>
		<?php echo $form->error($model,'cod_pessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo_vinculo'); ?>
		<?php echo $form->textField($model,'tipo_vinculo'); ?>
		<?php echo $form->error($model,'tipo_vinculo'); ?>
	</div>


	<div class="row">
		
		<?php echo $form->labelEx($model,'descricao'); ?>
		<?php $this->widget('application.extensions.tinymce.ETinyMce', array('htmlOptions'=>array('cols'=>60, 'rows'=>20),'name'=>'Atividade[descricao]','editorTemplate'=>'simple',  'value'=>$model->descricao)); ?>
		<br><?php echo $form->error($model,'descricao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_inicio'); ?>
		<?php //echo $form->textField($model,'data_inicio'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'name'=>'Atividade[data_inicio]',
				'value'=>isset($model->data_inicio) ? $model->data_inicio : date('Y-m-d'),
				'language'=>'pt-BR',
			    // additional javascript options for the date picker plugin
    			'options'=>array('showAnim'=>'drop','dateFormat'=>'yy-mm-dd'),
			    'htmlOptions'=>array('style'=>'height:15px;'),));
		?>
		<?php echo $form->error($model,'data_inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_fim'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'name'=>'Atividade[data_fim]',
				'value'=>isset($model->data_fim) ? $model->data_fim : date('Y-m-d'),
				'language'=>'pt-BR',
			    // additional javascript options for the date picker plugin
    			'options'=>array('showAnim'=>'drop','dateFormat'=>'yy-mm-dd'),
			    'htmlOptions'=>array('style'=>'height:15px;'),));
		?>
		<?php echo $form->error($model,'data_fim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'turnos_trabalho'); ?>
		<?php //echo $form->textField($model,'turnos_trabalho'); ?>
		<?php echo $form->error($model,'turnos_trabalho'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'projetos'); ?>
		<?php echo $form->listBox($model,'projetos', CHtml::listData(Projeto::model()->findAll(array('order'=>'nome')), 'cod_projeto', 'nome'), array("multiple"=>"multiple", "size"=>"10",)  ); ?>
		<?php echo $form->error($model,'projetos'); ?>
	<div class="hint">Segure a tecla <b>CTRL</b> para selecionar mais de um projeto.</div><br>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pessoas'); ?>
		<?php echo $form->listBox($model,'pessoas', CHtml::listData(Pessoa::model()->findAll(array('order'=>'equipe_atual DESC, nome')), 'cod_pessoa', 'nome', 'equipe'), array("multiple"=>"multiple", "size"=>"10",)  ); ?>
		<?php echo $form->error($model,'pessoas'); ?>
		<div class="hint">Segure a tecla <b>CTRL</b> para selecionar mais de uma pessoa.</div><br>
	</div>
	
	
	<div class="row">	
		<?php echo $form->labelEx($model,'bolsas'); ?>
		<?php echo $form->listBox($model,'bolsas', CHtml::listData(PessoaFinanceiro::model()->with('pessoa')->findAll(array('order'=>'pessoa.nome')), 'cod_financeiro', 'resumo', 'pessoa.nome'), array("multiple"=>"multiple", "size"=>"10",)  ); ?>
		<div class="hint">Segure a tecla <b>CTRL</b> para selecionar mais de uma bolsa.</div><br>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Adicionar' : 'Salvar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

