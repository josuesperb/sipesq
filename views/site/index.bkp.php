<?php $this->pageTitle=Yii::app()->name; ?>

<h1><i><?php echo CHtml::encode(Yii::app()->name); ?> - Equipe Cepik</i></h1>
<hr>
<?php 
$dataProvider=new CActiveDataProvider('PassosConstrucao', array('criteria'=>array("order"=>'finalizado, prioridade DESC')));
?>
<h1>Próximos Passos</h1>
<p><?php echo CHtml::link(CHtml::encode("Criar Passo"), array('passosConstrucao/create')); ?></p>
<ul>
<?php foreach($dataProvider->getData() as $data):?>
<li>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'passos-construcao-form',
	'enableAjaxValidation'=>false,
)); ?>
		<?php if($data->finalizado):?>
			<s><?php echo CHtml::link(CHtml::encode($data->nome), array('passosConstrucao/update', 'id'=>$data->id)); ?></s><br>
			<s><?php echo $form->error($data,'finalizado'); ?></s>
		<?php else:?>
			<?php echo CHtml::link(CHtml::encode($data->nome), array('passosConstrucao/update', 'id'=>$data->id)); ?><br>
			<?php echo $form->error($data,'finalizado'); ?>
		<?php endif;?>
		
<?php $this->endWidget(); ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('prioridade')); ?>:</b>
	<?php echo CHtml::encode($data->prioridade); ?>
	<br />
	<hr></li>
<?php endforeach;?>	
</ul>


<?php /*
<div id="noticias"></div>
<!--<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAwtW6REnoXPwabzosDJ1ZbxSf6zeDUL0NX_-81yZ_3MTVk-1i4xQ4nST236nGieybG_Uiv9EE12qxDg"></script>-->
<script type="text/javascript">
google.load("feeds", "1"); //Load Google Ajax Feed API (version 1)
</script>

<script type="text/javascript">

var feedcontainer=document.getElementById("noticias");
var feedlimit=10;
var rssoutput = '<h3>Notícias pelo Mundo</h3>';
var feedurl = "http://news.google.com/news?cf=all&ned=pt-BR_br&hl=pt-BR&output=rss";

function rssfeedsetup(){
var feedpointer=new google.feeds.Feed(feedurl); //Google Feed API method
//document.write(feed);
feedpointer.setNumEntries(feedlimit); //Google Feed API method

feedpointer.load(displayfeed); //Google Feed API method
}

function displayfeed(result){
	if (!result.error){
		var thefeeds=result.feed.entries;
		for (var i=0; i<thefeeds.length; i++)
		rssoutput+="<p><a href='" + thefeeds[i].link + "' target='_blank'> " + thefeeds[i].title + "</a></p>";
		//	rssoutput+="<p>" + thefeeds[i].author + "</p>";
		feedcontainer.innerHTML=rssoutput + '<a href="http://www.google.com/news" target="_blank">Google Notícias</a>';
	}
	else
		feedcontainer.innerHTML="<a href='http://isape.wordpress.com' target='_blank' ><h3>Blog ISAPE</h3></a><p>Veja as notícias do blog</p>";
}

window.onload=function(){
	rssfeedsetup();
};

</script>
*/?>