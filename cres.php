<?php
	//session_start(); 
	ob_start();
	include_once 'menuprin1.php'; 
	include 'connexion.php'; 
	if (isset($_POST['im'])&& $_POST['im']=='OK') 
		{ 
			$_SESSION['mt']=$_POST['edit3']; 
			$_SESSION['av']=$_POST['edit4']; 
			mysql_query("SET NAMES 'utf8' ");
			$tr="UPDATE reservationsalle SET montantsal='".$_POST['edit3']."', avancesal='".$_POST['edit4']."'  WHERE numressal='". $_SESSION['numres']."'";
			//echo $tr;
			
			$tre=mysql_query($tr); 
			if ($_POST['edit4']!=0)
			{
				$tu=mysql_query("INSERT INTO encaissement VALUES ('".date('d-m-Y')."','".$_POST['edit1']."','".$_POST['edit4']."','".$_SESSION['login']."')");
			}
			
			echo "<script language='javascript'>"; 
			echo " alert('Réservation de salle fait avec succès ');";
			echo "</script>"; 
			if ($_POST['edit4']!=0)
				{
					header('location:recurs.php');
				} else {
			header('location:reservationsal.php');}
		}
?>
<html>
	<head>
	</head> 
	<body>
			<form action='cres.php' method='post'>
				<table align='center'>
					<tr> 
						<td> Réservation N°: </td>
						<td> <input type='text' name='edit1' id='edit1' value=<?php echo $_SESSION['numresch']; ?> /> </td>
						<td> Date: </td>
						<td> <input type='text' name='edit2' value="<?php echo date('Y-m-d') ?>" readonly /> </td>
					</tr> 
					<tr> 
						<td> Salle: </td>
						<td> Objet: </td>
						<td> Tarif: </td>
						<td> Montant: </td>
					</tr>
						<?php
							$mont=0; 
							$ret=mysql_query('SELECT * FROM reserversal WHERE numressal="'. $_SESSION['numresch'].'"');
							while ($ret1=mysql_fetch_array($ret))
								{
									echo "<tr>"; 
										echo "<td>"; echo($ret1[1]); echo "</td>"; 
										echo "<td>"; echo($ret1[2]); echo "</td>"; 
										echo "<td>"; echo($ret1[3]); echo "</td>"; 
										echo "<td>"; echo($ret1[4]); echo "</td>"; 
									echo "</tr>"; 
									$mont=$mont+$ret1[4]; 
								}
						?> 
						<tr> 
						<td> Montant: </td>
						<td> <input type='text' name='edit3' id='edit3' value="<?php echo $mont;?>" readonly /> </td>
						<td> Avance: </td>
						<td> <input type='text' name='edit4' /> </td>
					</tr>
					<tr> 
						<td colspan='4' align='center'> <input type='submit' name='im' value='OK'/> </td>
					</tr> 
				</table>
			</form>
	</body>
</html> 