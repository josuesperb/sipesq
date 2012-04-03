
<?php
$this->breadcrumbs=array(
	'Projetos'=>array('index'),
	$model->nome,
);

$this->menu=array(
	array('label'=>'Listar Todos', 'url'=>array('index')),
	array('label'=>'Gerar Relatório', 'url'=>array('relatorio', 'id'=>$model->cod_projeto)),
	array('label'=>'Adicionar Projeto', 'url'=>array('create')),
	array('label'=>'Adicionar Bolsa', 'url'=>array('pessoaFinanceiro/create', 'projeto'=>$model->cod_projeto)),
	array('label'=>'Editar', 'url'=>array('update', 'id'=>$model->cod_projeto)),
	array('label'=>'Excluir', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cod_projeto),'confirm'=>'Tem certeza que deseja excluir este projeto?')),
	array('label'=>'Gerenciar Permissões', 'url'=>array('permissoes', 'id'=>$model->cod_projeto)),
	array('label'=>'Gerenciar Projetos', 'url'=>array('admin')),
	
);
?>


<?php 
Yii::app()->clientScript->registerScript('tab-menu', "

$('document').ready(
	function(){
		$('#info').parent().show('fast');
		return false;
	}
);

$('#menu-tab a').click(
	function(){
	 $('.tab').hide();
	 $($(this).attr('name')).parent().show('fast');
	 $('#menu-tab a').removeClass('selected'); 
	 $(this).addClass('selected');
	 return false;
	});
	
$('#menu-tab a').hover(
	function(){
	 $(this).addClass('hover');
	 return false;
	}, 
	function(){
	 $(this).removeClass('hover');
	 return false;
	}
	);
");
?>

<h1><?php echo $model->nome; ?></h1>

<ul id="menu-tab">
      <li><a name="#info" href="#" class="selected">Informações Gerais</a></li>
      <li><a name="#financeiro" href="#">Financeiro</a></li>
      <li><a name="#atividades" href="#">Atividades</a></li>
</ul>


<div class="tab">
	<a id="info"></a>
	<?php $this->renderPartial("_view_info",array('model'=>$model))?>
</div><!--  fim tab info -->

<?php if(in_array(Yii::app()->user->name, array_merge($model->loginsPermitidos(PermissaoProjeto::READ_WRITE_DELETE_PERMITION) , Yii::app()->params['admins']))):?>
<div class="tab">
<a id="financeiro"></a>
<?php $this->renderPartial("_view_financeiro", array("model"=>$model))?>
</div> <!-- Fim tab financeiro -->
<?php endif;?>

<div class="tab">
<a id="atividades"></a>
<?php $this->renderPartial("_view_atividades",array("model"=>$model))?>
</div> <!-- Fim tab atividades -->


