<?php $this->pageTitle=Yii::app()->name; ?>

<h1><i>Sistema de Apoio ao Pesquisador</i></h1>
<p>
<b>A Equipe Cepik:</b>
É uma equipe de trabalho formada por orientandos de pós-graduação, graduação, bolsistas de Iniciação Cientifica e orientandos de outra natureza que estudam na UFRGS sob a supervisão do Prof. Marco Cepik.

</p>
<hr>
<?php if(Yii::app()->user->isGuest):?>
	<div class="view">
	
	<?php 
		$model=new LoginForm;
		$this->renderPartial("_login", array('model'=>$model)); 
	?>
	</div>
<?php endif;?>

<div class="centro">
<div class="agenda">
<h4><b>Horário dos Bolsistas</b></h4>
	<?php  $this->renderPartial("/agenda/_agenda"); ?>
	</div>
	<hr>
	<?php if(!Yii::app()->user->isGuest):?>
	<?php  $this->renderPartial("_pendencias"); ?>
	<?php endif;?>
</div><!--  CENTRO -->

	
