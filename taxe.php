<?php
	include_once'admin.php';
	include 'connexion.php'; 
	//enregistrement de la taxe   
	if (isset($_POST['ok']) && $_POST['ok']=='OK')
	{
		
		if (isset($_POST['edit1'])&& !empty($_POST['edit1']))
		{
			//echo 'eee';
			$re="INSERT INTO taxenuite VALUES('".$_POST['edit1']."')"; 
					$req=mysql_query($re);
					if ($req)
						{
							echo "<script language='javascript'>"; 
							echo " alert('Cette taxe a été enrégistrée avec succès');";
							echo "</script>"; 
						} else 
						{
							echo "<script language='javascript'>"; 
							echo " alert('Echec d'enregistrement');";
							echo "</script>"; 
						}
		} else 
		{
			echo "<script language='javascript'>"; 
			echo " alert('Un champ est vide');";
			echo "</script>"; 
		}
	}
	//enregistrement de la tva
	if (isset($_POST['ok1']) && $_POST['ok1']=='VALIDER')
	{
		//echo 'eee';
		if (isset($_POST['edit2'])&& !empty($_POST['edit2']))
		{
			$re="INSERT INTO tva VALUES('','".$_POST['edit2']."')"; 
					$req=mysql_query($re);
					if ($req)
						{
							echo "<script language='javascript'>"; 
							echo " alert('Cette TVA a été enrégistrée avec succès');";
							echo "</script>"; 
						} else 
						{
							echo "<script language='javascript'>"; 
							echo " alert('Echec d'enregistrement');";
							echo "</script>"; 
						}
		} else 
		{
			echo "<script language='javascript'>"; 
			echo " alert('Un champ est vide');";
			echo "</script>"; 
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
					<legend align='center'> ENREGISTEMENT DU TAUX DE LA TAXE SUR NUITE </legend>
					<form action='taxe.php' method='post'>
						<table>
							<tr>
								<td> Taxe sur nuité: </td>
								<td> <input type='text' name='edit1'/> </td>
							</tr>
							<tr> 
								<td colspan='2' align='center' > <input type='submit' name='ok' value='OK'/> </td>
							</tr>
						</table>
					</form>
				</fieldset>
				</td>
				<td align='center'> 
				<fieldset> 
					<legend align='center'> ENREGISTEMENT DU TAUX DE LA TVA</legend>
					<form action='taxe.php' method='post'>
						<table>
							<tr>
								<td> Taux TVA: </td>
								<td> <input type='text' name='edit2'/> </td>
							</tr>
							<tr> 
								<td colspan='2' align='center' > <input type='submit' name='ok1' value='VALIDER'/> </td>
							</tr>
						</table>
					</form>
				</fieldset>
				</td>
				</td>
			</tr>
		</table>
	</body> 
</html> 