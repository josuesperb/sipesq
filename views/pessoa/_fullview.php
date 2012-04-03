<?php
$this->breadcrumbs=array(
	'Pessoas'=>array('index'),
	$data->nome,
);

$this->menu=array(
	array('label'=>'Adicionar uma Pessoa', 'url'=>array('create')),
	array('label'=>'Adicionar Projeto Atuante', 'url'=>array('addprojetoatuante', 'id'=>$data->cod_pessoa)),
	array('label'=>'Gerenciar Pessoas', 'url'=>array('admin')),
	array('label'=>'Editar', 'url'=>array('update', 'id'=>$data->cod_pessoa)),
	array('label'=>'Deletar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$data->cod_pessoa),'confirm'=>'Tem certeza que deseja deletar esta pessoa?')),
	
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

<?php 
			Yii::app()->clientScript->registerScript('financeiro', "
		
			$('.fin-detail-btn').toggle(
		
		function(){
				id = $(this).parent().parent('tr').attr('id');
				container = $('#fin-detail');
				$(this).val('-');
				
		
			$.get('/sipesq/index.php/pessoaFinanceiro/view/'	,
					
				{id: id, no_layout: 1},function (data){
						$(container).append(data );
						$(container).focus();
					},
					\"html\"); 
					
			return false;
					
		},
		
		function(){
				 $('#fin-detail').text('');
				 $('.fin-detail-btn').val('+');
				return false;
			}
		);"
		);
?>
			

<?php Yii::app()->clientScript->registerScript('table_financeiro',"

$('.tbl-line-financeiro').hover(
 function(){
 	$(this).addClass('table-line-over');
 }, 
 
 function(){
 	$(this).removeClass('table-line-over');
 }
);

")?>

<h1 align="center"><?php echo $data->nome; ?></h1>
<ul id="menu-tab">
      <li><a name="#info" href="#" class="selected">Informações Gerais</a></li>
      <li><a name="#atividades" href="#">Atividades</a></li>
      <?php if(Yii::app()->user->id || Yii::app()->user->name == $data->login):?>
      <li><a name="#pagamentos" href="#">Pagamentos</a></li>
      <?php endif;?>
</ul>

<div class="tab">
	<a id="info"></a>
	<p align="left"><b>Informações Pessoais</b></p>
	<div class="view">
	<b><?php  echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome_mae')); ?>:</b>
	<?php echo CHtml::encode($data->nome_mae); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('data_nascimento')); ?>:</b>
	<?php echo CHtml::encode(date("d/m/Y",strtotime($data->data_nascimento))); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />
	
	<b><?php echo CHtml::encode("Telefone"); ?>:</b>
	<?php echo CHtml::encode($data->telefone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cpf')); ?>:</b>
	<?php echo CHtml::encode($data->cpf); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rg')); ?>:</b>
	<?php echo CHtml::encode($data->rg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cidade')); ?>:</b>
	<?php echo CHtml::encode($data->cidade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rua_complemento')); ?>:</b>
	<?php echo CHtml::encode($data->rua_complemento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bairro')); ?>:</b>
	<?php echo CHtml::encode($data->bairro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cep')); ?>:</b>
	<?php echo CHtml::encode($data->cep); ?>
	<br />
	
	</div> <!-- Informações Pessoais -->
	
	<p align="left"><b>Informações Bancárias</b></p>
	<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('banco')); ?>:</b>
	<?php echo CHtml::encode($data->banco); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agencia')); ?>:</b>
	<?php echo CHtml::encode($data->agencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conta_corrente')); ?>:</b>
	<?php echo CHtml::encode($data->conta_corrente); ?>
	<br />
	
	<?php if(!empty($data->cod_banco)):?>
		<b><?php echo CHtml::encode($data->getAttributeLabel('cod_banco')); ?>:</b>
		<?php echo CHtml::encode($data->cod_banco); ?>
		<br />
	<?php endif;?>
	</div> <!-- Informações Bancárias -->
	
	<p align="left"><b>Informações Acadêmicas</b></p>
	<div class="view">
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('cartao_ufrgs')); ?>:</b>
	<?php echo CHtml::encode($data->cartao_ufrgs); ?>
	<br />
	
	<b><?php echo CHtml::encode("Projetos em que atua"); ?>:</b>
	<?php for($i=0; $i< count($data->projetos_atuante);$i++):?>
		<?php echo CHtml::encode($data->projetos_atuante[$i]->nome); if($i < count($data->projetos_atuante	) -1) echo ","?>
	<?php endfor;?>
	<br />
	
	<?php if(isset($data->categoria)):?>
		<b><?php echo CHtml::encode($data->getAttributeLabel('categoria')); ?>:</b>
		<?php echo CHtml::encode($data->categoria->nome); ?>
		<br />
	<?php endif;?>
	
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('lattes')); ?>:</b>
	<b><?php echo CHtml::link(CHtml::encode($data->lattes), $data->lattes, array('target'=>'_blank')); ?></b>
	<br />

	
	<?php if(isset($data->cod_vinculo_institucional)):?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('cod_vinculo_institucional')); ?>:</b>
	<?php echo CHtml::encode($data->vinculo_institucional->nome); ?>
	<?php endif;?>
	</div> <!-- Informações Acadêmicas -->

</div> <!-- Fim Tab Informações -->

<div class="tab">
	<a id="atividades"></a>
	<div class="view">
	<p align="left"><b>Atividades</b></p>
	<?php $atividades = Atividade::model()->findAll('cod_pessoa = ' .$data->cod_pessoa);?>
		
		<p align="left"><b>Pela qual é responsável</b></p>
			<?php foreach($atividades as $atividade):?>
				<div class="view <?php echo $atividade->class;?>">
			
				<b><?php echo CHtml::link(CHtml::encode($atividade->nome_atividade), array('atividade/view', 'id'=>$atividade->cod_atividade)); ?></b>
				<br />
			
				<b><?php echo CHtml::encode("Prazo"); ?>:</b>
				<?php echo CHtml::encode("De " .$atividade->data_inicio ." a " .$atividade->data_fim); ?>
				<br />
				
				<b><?php echo CHtml::encode($atividade->getAttributeLabel('status')); ?>:</b>
				<?php echo CHtml::encode($atividade->status); ?>
				<br />
			
				</div>
			<?php endforeach;?>
			<?php if(count($atividades) == 0):?>
			<div class="view verde"><p><b>Não é responsável por nenhuma atividade</b></p></div>
			<?php endif;?>
		
		<p align="left"><b>Da qual participa</b></p>
		<?php foreach($data->atividades as $atividade):?>
			<?php if($atividade->cod_pessoa != $data->cod_pessoa):?>
				<div class="view <?php echo $atividade->class;?>">
			
				<b><?php echo CHtml::link(CHtml::encode($atividade->nome_atividade), array('atividade/view', 'id'=>$atividade->cod_atividade)); ?></b>
				<br />
			
				<b><?php echo CHtml::encode("Prazo"); ?>:</b>
				<?php echo CHtml::encode($atividade->data_inicio) ." a " ."<b>" .CHtml::encode($atividade->data_fim) ."</b>"; ?>
				<br />
				
				<b><?php echo CHtml::encode($atividade->getAttributeLabel('status')); ?>:</b>
				<?php echo CHtml::encode($atividade->status); ?>
				<br />
			
				</div>
				<?php endif;?>
		<?php endforeach;?>
		<?php if(count($data->atividades) == 0):?>
			<div class="view verde"><p><b>Não participa de nenhuma atividade</b></p></div>
		<?php endif;?>

	</div>
	</div> <!-- Fim tab  Atividades -->
<div class="tab">
<a id="pagamentos"></a>
	<div class="view">
	<?php if(count($data->pessoa_financeiro) < 1):?>
	<h4> Não há pagamentos</h4>
	<?php else:?>
	<?php $total_recebido = 0; $total_receber = 0?>
	<table>
	<tr><th>Fonte Pagadora</th><th>Categoria</th><th>Projeto Vinculado</th><th>Valor</th><th>Início</th><th>Fim</th></tr>
	<?php foreach($data->pessoa_financeiro as $pagamento): ?>
	<tr class="tbl-line-financeiro <?php echo $pagamento->class;?>" id="<?php echo $pagamento->cod_financeiro?>">
		<td><?php echo CHtml::encode($pagamento->fontePagadora->nome);?></td>
		<td><?php echo CHtml::encode($pagamento->categoria);?></td>
		<td><?php echo CHtml::encode($pagamento->projeto->nome);?></td>
		<td>R$ <?php echo  CHtml::encode(number_format($pagamento->valor,2,',','.')); ?></td>
		<td><?php echo CHtml::encode($pagamento->data_fim);?></td>
		<td><?php echo CHtml::encode($pagamento->data_relatorio);?></td>
		<?php // <td><?php echo CHtml::submitButton('+', array('submit'=>array('pessoaFinanceiro/view','id'=>$pagamento->cod_financeiro))); </td> ?>
		<td><?php echo CHtml::submitButton('+', array('class'=>'fin-detail-btn')); ?></td>
		<?php $total_recebido += $pagamento->valor_recebido?>
		<?php $total_receber += $pagamento->valor_total?>
	</tr>
	<?php endforeach;?>
	
	<tr class="line-last ">
		<td colspan="2"><b>Total Recebido</b></td>
		<td colspan="5" style="text-align: right;">
			<b><?php  echo CHtml::encode(number_format($total_recebido,2,',','.'));?></b>
		</td>
	</tr>
	<tr class="line-last">
		<td colspan="2"><b>Total</b></td>
		<td colspan="5" style="text-align: right;"><b><?php  echo CHtml::encode(number_format($total_receber,2,',','.'));?></b></td>
	</tr>
	</table>
	<div id="fin-detail">
	</div>
	<?php endif;?>
	</div> <!-- Termina Tab Financeiro -->

</div>