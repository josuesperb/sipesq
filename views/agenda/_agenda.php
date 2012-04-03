		<table class="tbl-agenda">
		<thead>
		<tr><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th></tr>
		</thead>
		<tbody>
		<tr>
			<td class="manha segunda">
				<?php $pessoas = Horario::model()->findAll("turno = 'manha' AND dia_semana = 'segunda'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="manha terca">
				<?php $pessoas = Horario::model()->findAll("turno = 'manha' AND dia_semana = 'terca'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="manha quarta">
				<?php $pessoas = Horario::model()->findAll("turno = 'manha' AND dia_semana = 'quarta'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="manha quinta">
				<?php $pessoas = Horario::model()->findAll("turno = 'manha' AND dia_semana = 'quinta'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="manha sexta">
				<b>Reunião Equipe</b>
				<?php $pessoas = Horario::model()->findAll("turno = 'manha' AND dia_semana = 'sexta'")?>
				<?php foreach($pessoas as $p):?>
					<?php //echo $p->pessoa->nome_curto;?><br>
				<?php endforeach;?>
			</td>
		</tr>
		
		<tr class="table-line-over" align="center"><td colspan="5" align="center" >
		<div align="center"><b>Horário de Almoço</b></div>
		</td></tr>
		<tr>
			<td class="tarde segunda">
				<?php $pessoas = Horario::model()->findAll("turno = 'tarde' AND dia_semana = 'segunda'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="tarde terca">
				<?php $pessoas = Horario::model()->findAll("turno = 'tarde' AND dia_semana = 'terca'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="tarde quarta">
				<?php $pessoas = Horario::model()->findAll("turno = 'tarde' AND dia_semana = 'quarta'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="tarde quinta">
				<?php $pessoas = Horario::model()->findAll("turno = 'tarde' AND dia_semana = 'quinta'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
			<td class="tarde sexta">
				<?php $pessoas = Horario::model()->findAll("turno = 'tarde' AND dia_semana = 'sexta'")?>
				<?php foreach($pessoas as $p):?>
					<?php if(!$p->pessoa->isInVacation($p->cod_pessoa)):?>
						<?php echo $p->pessoa->nome_curto; ?><br>
					<?php endif;?>
				<?php endforeach;?>
			</td>
		</tr>
		</tbody>
		
		</table>
