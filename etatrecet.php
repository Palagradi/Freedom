<?php
include_once'menu.php';

		$_SESSION['excel']='';

/* 		$sql3=mysqli_query($con,"SELECT num_encaisse,ttc_fixe,tarif FROM encaissement");
		while($row_1=mysqli_fetch_array($sql3))
		{  $num_encaisse= $row_1['num_encaisse'];$ttc_fixe= $row_1['ttc_fixe'];
				if($ttc_fixe==12000)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='9322.0339'	 WHERE num_encaisse='".$num_encaisse."'");
				if($ttc_fixe==14000)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='10169.4916' WHERE num_encaisse='".$num_encaisse."'");
				if($ttc_fixe==7500)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='5508.4746'	 WHERE num_encaisse='".$num_encaisse."'");
				if($ttc_fixe==9500)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='6355.9323'	 WHERE num_encaisse='".$num_encaisse."'");
		} */
?>
<html>
	<head>

	</head>
	<body bgcolor='azure' style="font-family:Cambria;">
	<div align="" style="width:1100px;border:2px solid white;background-color:#D0DCE0;border-radius: 5px;-moz-border-radius: 5px;margin:20px auto;">
		<form  action='etatrecet1.php' method='post'>
			<br/>
			<table align='center'style=''>
				<tr>
					<td> <B> <?php $cp=!empty($_GET['cp'])?$_GET['cp']:NULL;
		if($cp!=1) echo"<center> <font color='green' size='5' >CONSULTATION DE L'ETAT DES RECETTES POUR UNE PERIODE </center>"; else echo "<center> <font color='green' size='5' >CORRESPONDANCE ENTRE RECETTE CHAMBRES ET NUITEES PASSEES </center>"; ?></B></td>
				</tr>
			</table>
			<br/>
			<table align='center' style='font-weight:bold;'>

				</tr>
				<tr>
				<td>Période du: &nbsp;&nbsp;</td>
				<td>
					<select name='se1' id='se1' style='font-family:sans-serif;font-size:90%;'>
						<option value='Default'></option>
						<?php
							for ($i=1; $i<32; $i++)
								{
									if ($i<10)
										{
											echo '<option value="0'.$i.'">';
											echo($i);
											echo '</option>';
										} else
										{
											echo '<option value="'.$i.'">';
											echo($i);
											echo '</option>';
										}
								}
						?>
					 </select>
					<select name='se2' id='se2' style='font-family:sans-serif;font-size:90%;'>
							<option value='Default'> </option>
						<option value='01'> Janvier </option>
							<option value='02'> Février </option>
							<option value='03'> Mars </option>
							<option value='04'> Avril </option>
							<option value='05'> Mai  </option>
							<option value='06'> Juin </option>
							<option value='07'> Juillet </option>
							<option value='08'> Août</option>
							<option value='09'> Septembre </option>
							<option value='10'> Octobre </option>
							<option value='11'> Novembre</option>
							<option value='12'> Décembre </option>
						</select>
					<select name='se3'id='se3' style='font-family:sans-serif;font-size:90%;'>
						<option>  </option>
						<?php
							for ($i=2013; $i<date('Y')+10; $i++)
								{
									echo '<option value="'.$i.'">';echo($i);echo '</option>';
								}
						?>
					</select>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Au:&nbsp;&nbsp; </td>
				<td>
				<select name='se4' id='se4' style='font-family:sans-serif;font-size:90%;'>
						<option value='Default'></option>
							<?php
								for ($i=1; $i<32; $i++)
								{
									if ($i<10)
										{
											echo '<option value="0'.$i.'">';
											echo($i);
											echo '</option>';
										} else
										{
											echo '<option value="'.$i.'">';
											echo($i);
											echo '</option>';
										}
								}
							?>
					</select>
					<select name='se5' id='se5' style='font-family:sans-serif;font-size:90%;'>
										<option value='Default'> </option>
										<option value='01'> Janvier </option>
										<option value='02'> Février </option>
										<option value='03'> Mars </option>
										<option value='04'> Avril </option>
										<option value='05'> Mai  </option>
										<option value='06'> Juin </option>
										<option value='07'> Juillet </option>
									<option value='08'> Août</option>
										<option value='09'> Septembre </option>
										<option value='10'> Octobre </option>
										<option value='11'> Novembre</option>
										<option value='12'> Décembre </option>
									</select>
									<select name='se6'id='se6' style='font-family:sans-serif;font-size:90%;'>
										<option>  </option>
								<?php
												for ($i=2013; $i<date('Y')+10; $i++)
												{
													echo '<option value="'.$i.'">';
													echo($i);
													echo '</option>';
												}
								?>
					</select>
				</td>

			</tr>

		</table>
		<table align='center'style='font-size:1.1em;'>
		<?php
		if($cp!=1)
		echo "<tr>
			<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT type='radio' name='check' value='2' checked='checked'> Pour toutes les formes de recettes(Chiffre d'affaire)</td>

			<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT type='radio' name='check' value='1' > Suivant la nuitée réellement passée et payée</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;<br/><INPUT type='radio' name='choix' value='2' checked='checked'> ETAT DETAILLE DES RECETTES <b>(Chambre)</b></td>
			<td>&nbsp;&nbsp;<br/><INPUT type='radio' name='choix' value='3'> ETAT DETAILLE DES RECETTES <b>(Salle)</b></td>

		</tr>";
		?>

	<tr>
			<?php
			//if($cp!=1)
			echo "<td align=''><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='checkbox' name='excel' value='1'>
			<a href='#'><img src='logo/excel.png' alt='Version Excel' title='Version Excel' width='30' height='30' class='noprt' style=''></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' class='bouton2' name='VALIDER' value='Valider' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;' />	</td>";
/* 			else
			echo"<td align='center'><br/>
				<a href='recetteChambre.php'><img src='logo/excel.png' alt='Version Excel' title='Version Excel' width='30' height='30' class='noprt' style=''></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='submit' class='bouton2' name='VALIDER' value='VALIDER' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/>	</td>"; */
			?>
		</tr>				
			<tr> 
				<td> &nbsp;&nbsp;
				</td> 
			</tr> 
		</table>
		</div>
		</form>
	</body>
</html>
