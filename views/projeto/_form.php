<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projeto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>
	
	<?php $listDataPessoas = CHtml::listData(Pessoa::model()->with('categoria')->findAll(array('order'=>'equipe_atual DESC, t.nome')), 'cod_pessoa', 'nome', 'categoria.nome');?>
	<?php $listDataEquipe = CHtml::listData(Pessoa::model()->findAll(array('order'=>'equipe_atual DESC, nome')), 'cod_pessoa', 'nome', 'equipe'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome'); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'finalizado'); ?>
		<?php echo $form->checkBox($model,'finalizado'); ?>
		<?php echo $form->error($model,'finalizado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo_projeto'); ?>
		<?php echo $form->textField($model,'codigo_projeto'); ?>
		<?php echo $form->error($model,'codigo_projeto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_inicio'); ?>
		<?php //echo $form->textField($model,'data_inicio'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'name'=>'Projeto[data_inicio]',
				'value'=>isset($model->data_inicio) ? date("Y-m-d",strtotime($model->data_inicio)) : date("Y-m-d"),
				'language'=>'pt-BR',
			    // additional javascript options for the date picker plugin
    			'options'=>array('showAnim'=>'drop','dateFormat'=>'yy-mm-dd'),
			    'htmlOptions'=>array('style'=>'height:15px;'),));
		?>
		<?php echo $form->error($model,'data_inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_fim'); ?>
		<?php //echo $form->textField($model,'data_fim'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'name'=>'Projeto[data_fim]',
				'value'=>isset($model->data_fim) ? date("Y-m-d",strtotime($model->data_fim)) : date("Y-m-d"),
				'language'=>'pt-BR',
			    // additional javascript options for the date picker plugin
    			'options'=>array('showAnim'=>'drop',),
			    'htmlOptions'=>array('style'=>'height:15px;'),));
		?>
		<?php echo $form->error($model,'data_fim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_relatorio'); ?>
		<?php //echo $form->textField($model,'data_relatorio'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'name'=>'Projeto[data_relatorio]',
				'value'=>isset($model->data_relatorio) ? date("Y-m-d",strtotime($model->data_relatorio)) : date("Y-m-d"),
				'language'=>'pt-BR',
			    // additional javascript options for the date picker plugin
    			'options'=>array('showAnim'=>'drop',),
			    'htmlOptions'=>array('style'=>'height:15px;'),));
		?>
		<?php echo $form->error($model,'data_relatorio'); ?>
	</div>
   
	<div class="row">
		<?php echo $form->labelEx($model,'cod_professor');?>
		<?php  echo $form->dropDownList($model,'cod_professor', $listDataPessoas, array('prompt'=>"Selecione um Professor")); ?>
		<?php echo $form->error($model,'cod_professor'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'cod_pos_grad');?>
		<?php  echo $form->dropDownList($model,'cod_pos_grad', $listDataPessoas, array('prompt'=>"Selecione um Pós-Graduando")); ?>
		<?php echo $form->error($model,'cod_pos_grad'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'cod_grad');?>
		<?php  echo $form->dropDownList($model,'cod_grad', $listDataPessoas, array('prompt'=>"Selecione um Graduando")); ?>
		<?php echo $form->error($model,'cod_grad'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pessoas_atuantes'); ?>
		<?php echo $form->listBox($model,'pessoas_atuantes', $listDataEquipe, array("multiple"=>"multiple", "size"=>"10",)  ); ?>
		<?php echo $form->error($model,'pessoas_atuantes'); ?>
		<div class="hint">Segure a tecla <b>CTRL</b> para selecionar mais de uma pessoa.</div><br>
	</div>
	
		
	<div class="row">
		<label><b>Tipo de Projeto</b></label>
		<?php  echo $form->dropDownList($model,'cod_categoria', CHtml::listData(ProjetoCategoria::model()->findAll(array('order'=>'nome')), 'cod_categoria', 'nome'), array('prompt'=>"Selecione uma Categoria")); ?>
		<?php echo $form->error($model,'cod_categoria'); ?>
	</div>
		
	<div class="row">
		<?php echo $form->labelEx($model,'verba_custeio'); ?>
		<?php echo $form->textField($model,'verba_custeio'); ?>
		<?php echo $form->error($model,'verba_custeio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verba_capital'); ?>
		<?php echo $form->textField($model,'verba_capital'); ?>
		<?php echo $form->error($model,'verba_capital'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verba_bolsa'); ?>
		<?php echo $form->textField($model,'verba_bolsa'); ?>
		<?php echo $form->error($model,'verba_bolsa'); ?>
	</div>
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'descricao'); ?>
		<?php $this->widget('application.extensions.tinymce.ETinyMce', array('htmlOptions'=>array('cols'=>'2', 'rows'=>'2'),'value'=>$model->descricao,'name'=>'Projeto[descricao]','editorTemplate'=>'full', 'height'=>'250px', 'width'=>'100%')); ?>
		<?php echo $form->error($model,'descricao'); ?>
	</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Adicionar' : 'Salvar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->