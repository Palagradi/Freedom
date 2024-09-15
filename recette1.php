<?php
	//session_start(); 
	include_once 'menucp.php'; 
			include 'connexion.php'; 
	
	
?>
<html>
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body bgcolor='azure'>
		<form  action='recette1.php' method='post'>
			
			<table align='center'>
				
				</tr> 
				<tr>
				<td>Période du: </td>
				<td>
					<select name='se1' id='se1'>
						<option value='Default'>Jour</option> 
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
					<select name='se2' id='se2' > 
							<option value='Default'> Mois</option> 
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
							<option value='12'> Decembre </option>
						</select>  
					<select name='se3'id='se3' > 
						<option> Année </option> 
						<?php
							for ($i=date('Y'); $i<date('Y')+10; $i++)
								{
									echo '<option value="'.$i.'">';echo($i);echo '</option>'; 
								}
						?>
					</select> 
				</td>
				<td> AU: </td>
				<td>
				<select name='se4' id='se4'>
						<option value='Default'>Jour</option> 
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
										<select name='se5' id='se5' > "; 
															<option value='Default'> Mois</option> 
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
															<option value='12'> Decembre </option>
														</select>  
														<select name='se6'id='se6' > 
															<option> Année </option> 
													<?php
																	for ($i=date('Y'); $i<date('Y')+10; $i++)
																	{
																		echo '<option value="'.$i.'">';
																		echo($i);
																		echo '</option>'; 
																	}
													?>
															echo"</select>
				</td>
				<td><input type='submit' name='ok' value='OK'/></td> 
			</tr>
		</table>
	</form>
	<?php
		if (isset($_POST['ok'])&& $_POST['ok']=='OK') 
	{
		$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];	
		$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];	
		echo "<br/><table align='center' border='1' > "; 
			echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px;font-weight:bold; '> ";
				echo"<td align='center' width='30%' >Date   </td> ";
				echo"<td align='center'  width='30%' >Référence </td> ";
				echo"<td align='center'  width='30%' >Montant</td> ";
				echo"<td align='center'  width='30%' >Agent</td> ";
			echo"</tr> "; 
		echo"<tr> "; 
		$ref=mysql_query("SELECT * FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss"); 
		while ($rerf=mysql_fetch_array($ref))
		{
				echo"<tr> "; 		
					echo"<td align='center'> "; echo 
					substr($rerf['datencaiss'],8,2).'-'.substr($rerf['datencaiss'],5,2).'-'.substr($rerf['datencaiss'],0,4);echo"</td> ";
					echo"<td> ";echo $rerf['ref'];echo"</td> ";
					echo"<td align='center'> ";echo $rerf['sommen'];echo"</td> ";
					echo"<td> ";echo $rerf['agenten'];echo"</td> ";
				echo "</tr>"; 
		}
	}
	?>
	
</html>