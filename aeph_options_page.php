<div class="wrap" style="max-width:950px !important;">
	<h2>AEPH Plugin</h2>
	<div id="poststuff" style="margin-top:10px;">
		<div id="mainblock" style="width:710px">
			<div class="dbx-content">
				<form action="<?php echo $action_url ?>" method="post">
					<input type="hidden" name="submitted" value="1" />
					<?php wp_nonce_field('aeph-nonce'); ?>
					<h3>Uso</h3>
					<p>En esta pagina esta la configuracion del plugin desarrollado por la asociacion.</p>
					<br />
					
					<h3>Email receptor del Log</h3>
					<p>Aqui puedes escribir cual sera el email que recibira todos los cambios que sucedan en las membresias de usuarios.</p>
					<input type="text" name="email" size='40' value=<?php echo $email ?>/>
					<label for="email"> Direccion de e-mail</label> <br />
					<br /><br />
					
					<h3>Mensajes</h3>
					<p>Estos son los mensajes que recibirán los usuarios en distintos momentos cercanos al fin de su membresia.</p>
					<textarea name="mensaje30" rows="10" cols="80"><?php echo $mensaje30 ?></textarea><br>
					<label for="mensaje30">Mensaje cuando le quedan 30 dias de membresía.</label><br/><br />
					
					<textarea name="mensaje15" rows="10" cols="80"><?php echo $mensaje15 ?></textarea><br>
					<label for="mensaje15">Mensaje cuando le quedan 15 dias de membresía.</label><br/><br />
					
					<textarea name="mensaje7" rows="10" cols="80"><?php echo $mensaje7 ?></textarea><br>
					<label for="mensaje7">Mensaje cuando le quedan 7 dias de membresía.</label><br/><br />
					
					<textarea name="mensaje0" rows="10" cols="80"><?php echo $mensaje0 ?></textarea><br>
					<label for="mensaje0">Mensaje cuando le quedan 0 dias de membresía.</label><br/><br />

					<div class="submit"><input type="submit" name="Submit" value="Update" /></div>
				</form>
			
				<form action="" method="post">
				<input type="hidden" name="renovar" value="1" />
				<?php wp_nonce_field('aeph-nonce'); ?>
				Renovar Membresia de un usuario<br>
				<input type="text" width=4 name="IdUsuario"><input type="submit" value="Renovar">
				<label for="IdUsuario">ID del Usuario</label>
				</form>
				<br><br>
				<table class="widefat fixed" cellspacing="0">
				<tr>
					<th>ID</th>
					<th>Asunto</th>
					<th>Evento</th>
					<th>Estado</th>
					<th>Fecha</th>
				</tr>
				<?php
					global $wpdb;
					$todos=$wpdb->get_results('select * from aeph_log order by fecha desc limit 30');
					
					foreach ( $todos as $uno ){

						echo "<tr><td>".$uno->id."</td><td>".$uno->subject."</td><td>".$uno->event."</td><td>".$uno->status."</td><td>".$uno->fecha."</td></tr>";
					}
				?>
				</table>
			</div>
		</div>
	</div>
</div>