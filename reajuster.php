<?php
    //session_start();
	//ob_start();
	include_once 'menu.php';
	//include 'connexion.php'; 
/* 
	$_SESSION['tva']=''; $_SESSION['exhonerer1']='';$_SESSION['exhonerer2']='';
	$reqsel=mysql_query("SELECT * FROM configuration_facture");
	while($data=mysql_fetch_array($reqsel))
		{  $num_reserv=$data['num_reserv'];
		   $num_fact=$data['num_fact'];
		   $etat_facture=$data['etat_facture'];
		   $initial_grpe=$data['initial_grpe'];
		   $initial_reserv=$data['initial_reserv'];
		   $initial_fiche=$data['initial_fiche']; 
		   $Nbre_char=$data['Nbre_char'];
		} */
$numfiche=$_GET['numfiche'];


		if(isset($_POST['Confirmer']) && $_POST['Confirmer'] == "Confirmer")
		{ 			
			$reference=$_POST['reference'];$somme=$_POST['somme'];
			if($somme<=0){
			$test = "DELETE FROM compte WHERE numfiche ='$reference'";	
			$exec=mysql_query($test);
			$test = "DELETE FROM mensuel_compte WHERE numfiche ='$reference'";
			$exec=mysql_query($test);
			$test = "DELETE FROM fiche WHERE numfiche='$reference'";
			$exec=mysql_query($test);
			$test = "DELETE FROM mensuel_fiche WHERE numfiche='$reference'";
			$exec=mysql_query($test);
			header('location:loccup1.php');}else {
				echo "<script language='javascript'>"; 
				echo " alert('Vous ne pouvez pas supprimer cette fiche. Un encaissement est déjà opéré pour le compte du client');";
				echo "</script>";
				}
		}				
		if(isset($_POST['annuler']) && $_POST['annuler'] == "Annuler")
		{ header('location:loccup1.php');
		}
?>
<html>
	<head> 
		<title> SYGHOC </title>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>		

	</head>
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;"><br/>
	<div align="" style="">
		<table align='center' > <tr> <td> 

	<form action="reajuster.php<?php if($sal!='') echo "?sal=2"; if($cham!='') echo "?cham=2";?>" method="POST" name="reservation_modification">
				<table width="700" height="200" border="0" cellpadding="2" cellspacing="0" style="margin-top:50px; border:2px solid; font-family:Cambria;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:#a4660d;">CONFIRMATION DE LA SUPPRESSION</h2>
						</td>
					</tr>
							  <tr>
						<td colspan="4">
							<h4 style="text-align:center; font-family:Cambria;color:blue;">Voulez vous vraiment supprimer cette fiche?</h4>
						</td>
				</tr>
				<tr>
					<td colspan="2" align="right" style="padding-right: 20px;"> <br/><input type="submit" class="les_boutons" value="Confirmer" id="" name="Confirmer" style="border:2px solid #317082;margin-bottom:20px;"/> </td>
					<td colspan="2">  <br/><input type="submit" name="annuler" class="les_boutons" value="Annuler"/ style="border:2px solid #317082;margin-bottom:20px;"> </td>
				</tr>
					<input type="hidden" id="" name="somme" value="<?php echo $_GET['somme']; ?>" />
<tr>   <td colspan="2"> <input type="hidden" id="" name="reference" value="<?php echo $_GET['numfiche']; ?>" onFocus="this.blur()" style="width:75px;" /> </td></tr>

				</table>
			</form>

		</td> </tr> </table> <?php echo "<h4 align='center'>";echo $msg1."</h4>" ; ?>
	</div>
	</body>

</html> 