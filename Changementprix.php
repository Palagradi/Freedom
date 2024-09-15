<?php
//include 'menu.php';
	require("configuration.php");
		// automatisation du numéro
		$numfiche = $_GET['numfiche'];
	if(!empty($_POST['choix'])){
		//on déclare une variable
		$choix ='';
		//on boucle
		for ($i=0;$i<count($_POST['choix']);$i++)
		{
		//on concatène
		//$choix .= $_POST['choix'][$i];
		$choix .= $_POST['choix'][$i].'|';
		$explore = explode('|',$choix);
		}
 		//echo $choix;
		 foreach($explore as $valeur){
			if(!empty($valeur)){
			//echo $valeur.'<br/>';
			}
		}echo 12;
	}
			 $id1=1;
			if(!empty($_POST['typeC']) )
				{$pre_sql1="INSERT INTO typechambre VALUES('".$_POST['numero']."','".$_POST['typeC']."')";
				$req1 = mysql_query($pre_sql1) or die (mysql_error());	
				$submit=TRUE;
				}
	
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"

	<head>
		<title><?php echo $title; ?></title>
<script type="text/javascript">

 window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
		window.close();
    }

</script>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" type="text/css" media="screen, print" href="style.css"> 
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>	
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript"> 
		function Aff55()
		{
			if ((document.getElementById("edit2").value!=''))
			{	document.getElementById("edit3").value=document.getElementById('edit2').value*document.getElementById('MontantUnites').value;
			}			
		}
		function Aff54()
		{
			if ((document.getElementById("edit3").value!='')&&(document.getElementById("MontantUnites").value!=0))
			{	document.getElementById("edit2").value=document.getElementById('edit3').value/document.getElementById('MontantUnites').value;
			}			
		}
		</script>
	</head>
	 <?php	
	 if($submit==TRUE) echo '<body onLoad="refreshParent()"  bgcolor="#FFDAB9"> '; else echo '<body bgcolor="#FFDAB9">'
	 ?>
	<div align="" style="">
		<form method="post" action="popup.php" onSubmit="refreshParent()">
		<table align='center' style='margin-top:-2%' style='background-color:#D0DCE0;'>
		 <?php	

					   echo "								
								<tr>
									<td>
										<fieldset style='background-color:#D0DCE0;'> 
											<legend align='center' style='color:#3EB27B;'><b> CHANGEMENT DU PRIX DES CHAMBRES</b></legend> 
											<table style='font-size:1.1em;'> 
												<tr> 
													<td>  Tarif simple : </td><input type='hidden' name='numero' value='' /><input type='hidden' name='' id='' value='' />
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' id='edit1'  value=''  onkeypress='testChiffres(event);'/> </td>		
												</tr> 
												<tr> 
													<td> Tarif double : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='typeC' style='' name='edit2' id='edit2'  value='' required='required' /> </td>
												</tr>
						
											</table> 
										</fieldset> 
									</td>
								</tr> <br/> ";

				    ?>			
				</table>
				<div align='center'><br/><input type="submit" value="<?php if($supp==1) echo 'SUPPRIMER'; else if($modif==1) echo 'MODIFIER'; else echo 'ENREGISTRER';?>" id="" class="les_boutons"  name="<?php if($supp==1) echo 'SUPPRIMER'; else if($modif==1) echo 'MODIFIER'; else echo 'ENREGISTRER';?>" style="<?php if($supp==1) echo 'color:red;font-weight:bold;'; else if($modif==1) echo'color:#9B810B;font-weight:bold;';  echo'#8F0059';?>;margin-bottom:5px;border:2px solid <?php if($supp==1) echo '#D10808'; else if($modif==1) echo'#103550';  echo'#8F0059';?>;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"  <?php if($supp==1) echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; ?>/>
				</div>
			</form>
         <?php //include ("footer.inc.php");?>
		</div>
	</body>
</html>
<?php
			//include ("footer.inc.php");
?>