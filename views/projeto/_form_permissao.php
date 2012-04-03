<?php
 $this->breadcrumbs=array(
	'Projetos'=>array('index'),
 	$projeto->nome=>array('view', 'id'=>$projeto->cod_projeto),	
	'Gerenciar Permissões',
);

$this->menu=array(
	array('label'=>'Ver Projeto', 'url'=>array('view', 'id'=>$projeto->cod_projeto)),
);

?>
<h4><b><?php echo CHtml::encode($projeto->nome);?></b></h4>
<h4>Cadastradar Pessoa</h4>
<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'permissao-projeto-form',
		'enableAjaxValidation'=>false,
	)); ?>
	<?php echo $form->errorSummary($model); ?>
	<?php  echo CHtml::dropDownList("PermissaoProjeto[cod_pessoa]",'', CHtml::listData(Pessoa::model()->findAll(array('order'=>'nome')), 'cod_pessoa', 'nome', 'equipe'), array('class'=>'dropPessoa', 'prompt'=>"Selecione uma Pessoa")); ?>
	<?php  echo CHtml::dropDownList("PermissaoProjeto[nivel_permissao]",'', array('1'=>"Leitura", '2'=>"Leitura e Escrita", '3'=>"Administrador"), array('class'=>'dropNivel', 'prompt'=>"Selecione a Permissão")); ?>
	<?php echo CHtml::submitButton('Adicionar'); ?>
</div>
<?php $this->endWidget(); ?>

<br><br>
<h4>Pessoas Cadastradas</h4>

<div id="pessoas-permitidas">
	<table>
	<tr>
	<th>Pessoa</th><th>Nível de Permissão</th><th>Remover</th>
	</tr>
	<?php foreach ($data as $p):?>
	<tr class="permissoes">
			<td>
				<?php echo CHtml::link(CHtml::encode($p->pessoa->nome), array('pessoa/view', 'id'=>$p->cod_pessoa)); ?>
			</td>
			
			<td>
				<?php echo CHtml::encode($p->nivel); ?>
			</td> 
			<td>
				<?php echo CHtml::submitButton('Remover', array('submit'=>array('deletePermissao','cod_projeto'=>$p->cod_projeto, 'cod_pessoa'=>$p->cod_pessoa,'returnUrl'=>array($this->route, 'id'=>$p->cod_projeto)) ,'confirm'=>'Deseja remover esta permissão?')); ?>
			</td>
	</tr>
	<?php endforeach;?>
	</table>
</div>