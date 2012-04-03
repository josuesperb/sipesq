<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projeto-financeiro-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php if(isset($model->cod_projeto)):?>
		<h4> Gasto / Verba do projeto <?php echo Projeto::model()->findByPk($model->cod_projeto)->nome?></h4>
	<?php endif;?>
	
	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>
  <?php if(!isset($model->cod_projeto)):?>
	<div class="row">
		<?php echo $form->labelEx($model,'cod_projeto'); ?>
		<?php $projetos["null"] = "Selecione um projeto";?>
		<?php $projetos = $projetos + CHtml::listData(Projeto::model()->findAll(array('order'=>'nome')), 'cod_projeto', 'nome')?>
		<?php  echo $form->dropDownList($model,'cod_projeto', $projetos); ?>
		<?php echo $form->error($model,'cod_projeto'); ?>
	</div>
  <?php endif;?>



	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		
		<?php $tipos["null"] = "Selecione uma categoria";?>
		<?php $tipos = $tipos + CHtml::listData(ProjetoFinanceiroCategoria::model()->findAll(array('order'=>'nome')), 'cod_categoria', 'nome_exibicao')?>
		<?php  echo $form->dropDownList($model,'tipo', $tipos); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'responsavel'); ?>
		<?php echo $form->textField($model,'responsavel'); ?>
		<?php echo $form->error($model,'responsavel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor'); ?>
		<?php echo $form->textField($model,'valor'); ?><span class="hint"> Valor em reais.</span>
		<?php echo $form->error($model,'valor'); ?>
	</div>
	
		<div class="row">
		<?php echo $form->labelEx($model,'descricao'); ?>
		<?php $this->widget('application.extensions.tinymce.ETinyMce', array('htmlOptions'=>array('cols'=>'2', 'rows'=>'2'),'value'=>$model->descricao,'name'=>'ProjetoFinanceiro[descricao]','editorTemplate'=>'simple', 'height'=>'150px', 'width'=>'60%')); ?>
		<?php echo $form->error($model,'descricao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Adicionar' : 'Salvar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->