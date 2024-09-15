<?php
	include_once'admin.php';
	include 'connexion.php'; 
	if (isset($_POST['ok']) and $_POST['ok']=='MODIFIER') 
	{
		if ( (isset($_POST['edit1']) && $_POST['edit1']!='Default') or (isset($_POST['edit2']) && $_POST['edit2']!='') or 
			(isset($_POST['edit3']) && $_POST['edit3']!='')or (isset($_POST['combo1']) && $_POST['combo1']!='Default') )  
			{
				$rez=mysql_query("UPDATE chambre SET typech='".$_POST['combo1']."', tarifsimple='".$_POST['edit2']."',tarifdouble='".$_POST['edit3']."' WHERE numch='".$_POST['edit1']."'");
				if ($rez)
					{
					echo "<script language='javascript'>"; 
						echo " alert('La Chambre a été modifié.');";
					echo "</script>";
					}
				else 
				{
					echo "<script language='javascript'>"; 
						echo " alert('Modification non effectuée .');";
					echo "</script>"; 
				}
			}
	}
?>
<html> 
	<head> 
		<title> SYGHOC </title> 
	</head>
	<body>
		<table align='center'>
			<tr>
				<td align='center'> 
				<fieldset> 
					<legend align='center'> ENREGISTEMENT DES CHAMBRES </legend>
					<form action='modifchambre.php' method='post'>
						<table>
							<tr>
								<td> Code Chambre: </td>
								<td> 
									<select name='edit1'> 
										<option value='Default'> --Choix- </option> 
										<?php
													$res=mysql_query('SELECT numch FROM chambre '); 
													while ($ret=mysql_fetch_array($res)) 
														{
															echo '<option value="'.$ret[0].'">';
															echo($ret[0]);
															echo '</option>' ; 
														}
														
												?>
									</select>  
								</td>
							</tr>
							<tr>
								<td> Type de Chambre: </td>
								<td>
									<select name='combo1'> 
										<option value='Default'> --Choix du Type-- </option> 
										<option value='V'> Ventillée  </option>
										<option value='CL'> Climatisée </option>
									</select>  
								</td>
							</tr>
							<tr>
								<td> Tarif Simple : </td>
								<td> <input type='text' name='edit2'/> </td>
							</tr>
							<tr>
								<td> Tarif Double: </td>
								<td> <input type='text' name='edit3'/> </td>
							</tr>
							<tr> 
								<td colspan='2' align='center' > <input type='submit' name='ok' value='MODIFIER'/> </td>
							</tr>
						</table>
					</form>
				</fieldset>
				</td>
			</tr>
		</table>
	</body> 
</html> 