<script>
function filtraAtividade (){
    	var url = '?';

		var projeto = $('#dropDownProjeto').val();

		if(projeto){
    	 url += 'projeto=' + projeto; 
    	}
    	
    	var pessoa = $('#dropDownPessoa').val();
    	if(pessoa){
        	url += '&pessoa=' + pessoa;
    	}

    	var categoria = $('#dropDownCategoria').val();
    	if(categoria){
        	url += '&categoria=' + categoria;
    	}

    	var finalizado = document.getElementById('checkBoxFinalizado').checked;
    	if(finalizado)
    		url += '&finalizado=1';
    	else
    		url += '&finalizado=0';
		
			
    	
    	location.href = url;
	}
</script>
<?php
$this->breadcrumbs=array(
	'Atividades',
);

$this->menu=array(
	array('label'=>'Adicionar Atividade', 'url'=>array('create')),
	array('label'=>'Gerenciar Atividades', 'url'=>array('admin')),
);
?>

<h1>Atividades</h1>

	<?php echo CHtml::dropDownList('dropDownProjeto',$projeto,CHtml::listData(Projeto::model()->findAll(array('order'=>'nome')), 'cod_projeto', 'nome'), array('prompt'=>"Selecione um Projeto",'onchange'=>'filtraAtividade();',));?>
	<?php echo CHtml::dropDownList('dropDownPessoa',$pessoa,CHtml::listData(Pessoa::model()->findAll(array('order'=>'nome')), 'cod_pessoa', 'nome'), array('prompt'=>"Selecione uma Pessoa",'onchange'=>'filtraAtividade();',));?>
	<?php echo CHtml::dropDownList('dropDownCategoria',$categoria, CHtml::listData(AtividadeCategoria::model()->findAll(array('order'=>'nome', 'condition'=>'cod_categoria_pai = cod_categoria')), 'cod_categoria', 'nome'), array('prompt'=>'Selecione uma Categoria', 'onchange'=>'filtraAtividade();')); ?><br>
	<?php echo CHtml::checkBox('checkBoxFinalizado',$finalizado,array('onchange'=>'filtraAtividade();',));?><b> Mostrar Atividades Finalizadas</b>
	<?php //echo CHtml::button('Filtrar',array('onclick'=>'filtraAtividade()')); ?> 
	<?php echo CHtml::submitButton('Limpar', array('submit'=>$this->createUrl('index'))); ?>
	


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'sortableAttributes'=>array(
      'data_fim', 'estagio',),
)); ?>
