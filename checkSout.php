<?php
	include 'menu.php';
	$sal=!empty($_GET['sal'])?$_GET['sal']:1;
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	mysqli_query($con,"SET NAMES 'utf8'");
	if($sal==1)
	$re=mysqli_query($con,"SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");
	else
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'  ORDER BY nomch ASC");
	$query_Recordset1 = "SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'   ORDER BY $trie ASC";

	 $_SESSION["path"] = getURI(); 

	 if(isset($_POST['SUPPRIMER']) && !empty($_POST['choix'])){
		//on déclare une variable
		$choix ='';
		//on boucle
		for ($i=0;$i<count($_POST['choix']);$i++)
		{
		$choix .= $_POST['choix'][$i].'|';
		$explore = explode('|',$choix);
		}
		 foreach($explore as $valeur){
			if(!empty($valeur)){
			//echo $valeur.'<br/>';
			$_SESSION['edit12']=$valeur;
			if($i==1)
				{	//header('location:loccup2.php');
					$sql="SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche=compte1.numfiche AND location.etatsortie='NON' and numsalle='".$valeur."'";
					$ras=mysqli_query($con,$sql);
					$rat=mysqli_fetch_array($ras);
					$numfiche= $rat['numfiche']; $numch= $rat['numch'];
					if(($rat['somme']==0)&&($rat['due']==0))
						{
							$ras1=mysqli_query($con,"DELETE FROM fiche1 WHERE numfiche='$numfiche'");
							$ras2=mysqli_query($con,"DELETE FROM compte WHERE numfiche='$numfiche'");
							$ras3=mysqli_query($con,"DELETE FROM mensuel_fiche1 WHERE numfiche='$numfiche'");
							$ras4=mysqli_query($con,"DELETE FROM mensuel_compte WHERE numfiche='$numfiche'");
						}
					else
						{
							echo $msg='Vous ne pouvez pas supprimer une entrée dont le montant a déjà été encaissé. ';
						}


				}
			else
				{ echo $msg='Vous ne pouvez pas supprimer plus ';

			}
		}
	}
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' ORDER BY nomch ASC");
}
	
	
	if(isset($_POST['date2'])) 
	   {  //$NumficheN=1;   
   			echo "<script language='javascript'>"; //echo $impaye;  
			echo "</script>";	
			
		//on déclare une variable
		$date2 ='';
		//on boucle
		for ($i=0;$i<count($_POST['date2']);$i++)
		{
		//on concatène
		$date2 .= $_POST['date2'][$i].'|';
		$explore = explode('|',$date2);
		//echo $i;
		//echo "<br>";$explore[$i];
		}		
 		//echo $choix;
		 //foreach($explore as $valeur)
		for ($i=0;$i<count($explore);$i++)
		 { 
			//echo "<br>";echo $explore[$i]; 
			$j=1+$i;
			if($j%2==0){
				//echo "<br>";
				$sql="UPDATE location SET datarriv1='".$explore[$i]."' WHERE numfiche='".$explore[$i-1]."'";
				$fet1=mysqli_query($con,$sql); 
				
				//$sql="UPDATE fiche1 SET datarriv1='".$explore[$i]."' WHERE numfiche='".$explore[$i-1]."'";
				//$fet1=mysqli_query($con,$sql);
				
				$_SESSION["NumficheN"]=$explore[$i-1];

				$re=mysqli_query($con,"SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");
				//break;
			}
		 }
	   }
	   	

	  if(isset($_POST['date'])) 
	   { //unset($_SESSION["NumficheN"]);
		//on déclare une variable
		$date ='';
		//on boucle
		for ($i=0;$i<count($_POST['date']);$i++)
		{
		//on concatène
		$date .= $_POST['date'][$i].'|';
		$explore = explode('|',$date);
		//echo $i;
		//echo "<br>";$explore[$i];
		}		
 		//echo $choix;
		 //foreach($explore as $valeur)
		for ($i=0;$i<count($explore);$i++)
		 { 
			//echo "<br>";echo $explore[$i]; 
			$j=1+$i;
			if($j%2==0){			
				
				$var="SELECT numfiche FROM location WHERE datsortie <> '".$Jour_actuel."' AND numfiche='".$explore[$i-1]."'";
				$reqsel=mysqli_query($con,$var);
				$data=mysqli_fetch_object($reqsel);		//$NumFact=NumeroFacture($data->num_fact);
				//if(mysqli_num_rows($reqsel)>0)
				if($explore[$i]!=$Jour_actuel)
				{
				$sql="UPDATE location SET datsortie = '".$explore[$i]."' WHERE numfiche='".$explore[$i-1]."'";
				$fet1=mysqli_query($con,$sql);	
				}
				//$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' ORDER BY nomch ASC");
				$re=mysqli_query($con,"SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");	
			}
		 }
	   }
	
	if(isset($_POST['LIBERER']) && !empty($_POST['choix'])){ //echo 125;
	//if(isset($_POST['choix'])) 
	   //{ 
		unset($_SESSION["NumficheN"]);
 
 	if(!isset($_GET['Numfiche'])) 
	   {
		//on déclare une variable
		$choix ='';
		//on boucle
		for ($i=0;$i<count($_POST['choix']);$i++)
		{
		$choix .= $_POST['choix'][$i].'|';
		$explore = explode('|',$choix);
		}
		if(count($_POST['choix'])==1){
 		 foreach($explore as $valeur){
			if(!empty($valeur)){ 
				 $sql="SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche=compte1.numfiche AND location.etatsortie='NON' and compte1.numsalle='".$valeur."'";
				$ras=mysqli_query($con,$sql); $nbre=mysqli_num_rows($ras);
			  	$rat=mysqli_fetch_array($ras);
				$numfiche= $rat['numfiche']; $numsalle= $rat['numsalle'];
				
				if($rat['ttc_fixeR']!=0) $ttc_fixe=$rat['ttc_fixeR']; else  $ttc_fixe=$rat['ttc_fixe'];

				$arrhes=$rat['somme']-($ttc_fixe*$rat['np']);

 				if($arrhes>0) { $Rnp=$arrhes/$ttc_fixe; if(is_int($Rnp)) {
						echo "<script language='javascript'>";
						echo 'alertify.error("Vous devez d\'abord éditer la facture du client !");';
						echo "</script>";
					}
					exit();
				} 
				$date=$valeur;	$heure=$Heure_actuelle;
				$sql="SELECT * FROM location WHERE numfiche='".$numfiche."'";
				$s=mysqli_query($con,$sql);$nbre_result=mysqli_num_rows($s);
 			   if($nbre_result>0)
			    {  
					$date ='';
					//on boucle
					for ($i=0;$i<count($_POST['date']);$i++)
					{
					$date .= $_POST['date'][$i].'|';
					$explore = explode('|',$date);
					}
					for ($i=0;$i<count($explore);$i++)
					 {
						$j=1+$i;
						if($j%2==0){
							if($numfiche==$explore[$i-1]){
							$sql="UPDATE location SET datsortie='".$explore[$i]."' WHERE numfiche='".$explore[$i-1]."'";						
						
							echo $n=round((strtotime($explore[$i])-strtotime($rat['datarriv']))/86400);
							$dat=(date('H')+1);
							settype($dat,"integer");
							if ($dat<14){$n=$n;}else {$n= $n+1;}
							if ($n==0){$n= $n+1;} $n=(int)$n;
							if($rat['ttc_fixeR']!=0)
								$mt=$rat['ttc_fixeR']*$n;
							else 
								$mt=$rat['ttc_fixe']*$n;
							$var1=$rat['somme'] ;
							$due = $mt-$var1;
							$N_reel=$n-$rat['np'] ;
							echo $n;		
							if($n<0){
								echo "<script language='javascript'>";	echo "var due = '".$due."';"; echo "var n = '".$N_reel."';"; echo "var numfiche = '".$numfiche."';";  
									echo 'alertify.error("La date de départ ne doit pas être inférieure à la date d\'arrivée.");';
								echo "</script>";	
							}else {
								echo '<meta http-equiv="refresh" content="0; url=checkSout.php?menuParent='.$_SESSION['menuParenT'].'&confirm=1&numfiche='.$numfiche.'&due='.$due.'&n='.$N_reel.'&begin='.$rat['datarriv'].'&end='.$explore[$i].'" />';
							}
							$re=mysqli_query($con,"SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");
							}
						}
						}
					 }					
				}
			}
		}else {
			echo "<script language='javascript'>";
			echo 'alertify.error("Vous ne pouvez faire le check-out conditionnel de plusieurs salles");';
			echo "</script>";	
		}
	   }
	 }

	//$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' ORDER BY nomch ASC");

?>
<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		
		<script src="js/sweetalert.min.js"></script>
		<script src="js/sweetalert2/sweetalert2@10.js"></script>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/sweetalert2/sweetalert.min.js"></script>
		
		<script src="js/jquery.min.js"></script>
		
		<script type="text/javascript" > 
				function alertmsg() {
					alertify.success("Si vous différez la date de départ du client, vous devez systématiquement procéder au Check-out pour la prise en compte réelle de la modification.");
				}

		function confirmation(){ //alert ('ffff');
					//var somme = document.getElementById("choixZ").value;
					alertify.confirm("Vous êtes sur le point de faire un Check-out. Veuillez noter que cette action est irréversible. Voulez-vous vraiment continuer ?",function(e){
						if(e) {
							var path = '<?php echo utf8_encode($_SESSION["path"]); ?>';
							path+="&submit=1";
							var menu = path;
							//document.location.href=menu+'&hour='+value; 
						$('#form').submit();
						return true;
					} else {
						return false;
					} 

				});
				
		}
		function soumission(){
					  var dateZ = document.getElementById("dateZ").value;
						//$('#form').submit();				
		}
		function JSalert(){
				var path = '<?php echo utf8_encode($_SESSION["path"]); ?>';
				path+="&Numfiche="+document.getElementById('NumficheN').value;
				var menu = path;
				document.location.href=menu;   
				//$('#form').submit();				
		}
		</script>
		<style>
		.alertify-log-custom {
				background: blue;
			}
		#lien1:hover {
			text-decoration:underline;background-color: gold;font-size:1.1em;
		}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: white;
			border:2px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}
		.bouton5 {
			border-radius:12px 0 12px 0;
			background: #d34836;
			border:none;
			color:#fff;
			font:bold 12px Verdana;
			padding:6px ;font-family:cambria;font-size:1em;
		}
		.bouton5:hover{
			cursor:pointer;background-color: white; color:black;
		}
		.bouton13 {
			border:none;
			padding:6px 0 6px 0;
			border-radius:8px;
			background:#d34836;
			font:bold 13px Arial;
			color:#fff;
		}
		</style>
	</head>
	<body>
	<?php  
	
		if((isset($_GET['px']))&&($_GET['px']=='true')){ 
			$sql="UPDATE location SET datsortie='".$_GET['end']."',etatsortie='OUI' WHERE numfiche='".$_GET['numfiche']."'";
			$fet2=mysqli_query($con,$sql);					
			$update = "UPDATE compte1 SET  due='".$_GET['due']."',N_reel='".$_GET['n']."' WHERE CONVERT( `compte1`.`numfiche` USING utf8 ) = '".$_GET['numfiche']."' " ;
			$fet1=mysqli_query($con,$update);
			echo "<script language='javascript'>";
			echo 'alertify.success("Check-out effectué avec succès");';
			echo "</script>";
			echo '<meta http-equiv="refresh" content="1; url=checkSout.php?menuParent=Location" />';

		}
		if((isset($_GET['px']))&&($_GET['px']=='null'))		
			{
			echo "<script language='javascript'>";
			echo 'alertify.error("L\'opération a été annulée");';
			echo "</script>";
			}
		if((isset($_GET['confirm']))&&($_GET['confirm']==1)){ 
			echo "<script language='javascript'>";
			echo "var due = '".$_GET['due']."';"; echo "var n = '".$_GET['n']."';"; echo "var numfiche = '".$_GET['numfiche']."';"; echo "var begin = '".$_GET['begin']."';"; echo "var end = '".$_GET['end']."';";
			echo "var begin0 = '".substr($_GET['begin'],8,2).'-'.substr($_GET['begin'],5,2).'-'.substr($_GET['begin'],0,4)."';"; 
			echo "var end0 = '".substr($_GET['end'],8,2).'-'.substr($_GET['end'],5,2).'-'.substr($_GET['end'],0,4)."';";			
			echo 'swal("Période du : "+begin0+"  au "+end0+ " \n Fiche N° : "+numfiche+"  | Nuitée due : "+n+" | Montant dû : "+due+" \n Veuillez noter que cette action est irréversible. \nVoulez-vous vraiment continuer ?", {
				dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="checkSout.php?menuParent=Location&px="+Es+"&numfiche="+numfiche+"&begin="+begin+"&end="+end+"&due="+due+"&n="+n;
			}); ';
			echo "</script>";
		}
							
							
			$PourcentAIB=1;
			$NumficheN=isset($_SESSION["NumficheN"])?$_SESSION["NumficheN"]:NULL;
			//$heure=isset($heure)?$heure:NULL;
			echo "<input type='hidden' value='".$NumficheN."' id='NumficheN' name='' style='text-align:right;'>";
			//echo "<input type='hidden' value='".$heure."' id='heure' name='' style='text-align:right;'>";

	if(isset($_SESSION["NumficheN"])){
			echo "<script language='javascript'>";   
			echo "JSalert();";
			$path=utf8_encode($_SESSION["path"])."&NumficheN=".$_SESSION["NumficheN"];			
			echo "var path = '".$path."';";
			//echo 'swal("Vous n\'êtes pas connectez à Internet. Par conséquent, la connexion avec eMECeF est impossible.","","error")';
			echo "</script>";
			//echo '<meta http-equiv="refresh" content="2; url='.$path.'" />';  //Commentaire du 12.01.2022
			unset($_SESSION["NumficheN"]);
		}

	if(isset($_GET['Numfiche'])) {
	
		$sql="UPDATE location SET datarriv=datarriv1 WHERE datarriv<>datarriv1";
		$fet1=mysqli_query($con,$sql);
		echo "<script language='javascript'>";
		echo 'alertify.success("Modification effectuée avec succès");';
		echo "</script>";
		echo '<meta http-equiv="refresh" content="0; url=checkSout.php?menuParent=Location" />';
	}
	?>
	<div align="" style="margin-top:0px;">
	<form name="checkout.php" method="post" id='form'> 
		<table align='center'>
			<tr>
				<td><hr noshade size=3> <div align="center"><B>
				
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; LISTE JOURNALIERE <?php if($sal==1) echo"DES OCCUPATIONS DE SALLES"; else echo"DES OCCUPANTS "; ?> </FONT></B><B> <span style='font-style:italic;'>(En date du <?php echo gmdate('d-m-Y');?>)</span></B>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					<FONT SIZE=4 COLOR="0000FF"> </FONT> 

					<input type='submit' class='bouton5' name='<?php  echo "LIBERER";   ?>' value='<?php echo "LIBERER";  ?>'
					<?php  //echo 'onclick="confirmation();"'; //unset($_SESSION["NumficheN"]); unset($NumficheN); //echo 'onclick="if(!confirm(\'Cette action est irréversible. Voulez-vous vraiment continuer?\')) return false;"'; ?>  
					style='float:right;border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>

					</div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td>
					<table  border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>

						<tr bgcolor='<?php if($_SESSION['poste']=="agent") echo "#CD5C5C"; else echo "black";?>'align="center" <?php if($_SESSION['poste']!="agent") echo "style='color:white;'";?>>
							<td> N° FICHE</td>
							<td > NOM ET PRENOMS </td>
							<td > NOM DU GROUPE</td>
							<td> PIECE N°</td>
							<td> ARRIVE LE </td>
							<td> DEPART LE </td>
							<td> <?php if($sal==1) echo "SALLE"; else echo "CHAMBRE";?> </td>
							<td> <?php if($sal==1) echo "MOTIF DE LA LOCATION"; else echo "TYPE OCCUPATION";?> </td>
							<td> CONTACT</td>
							<td> MONTANT</td>
							<td> SOMME PAYEE</td>
							<td> SOMME DUE</td>
							<td> &nbsp;&nbsp;&nbsp;✔&nbsp;&nbsp;&nbsp; </td>
						</tr>
					<?php
						$i=1; $cpteur=1;
						while($ret1=mysqli_fetch_array($re))
						{ if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#acbfc5";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
										$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
										$dat=(date('H')+1);
										settype($dat,"integer");
										if ($dat<14){$n=$n;}else {$n= $n+1;}
										if ($n==0){$n= $n+1;} $n=(int)$n;
										if($ret1['ttc_fixeR']!=0)
											$mt=$ret1['ttc_fixeR']*$n;
										else 
											$mt=$ret1['ttc_fixe']*$n;
										$due = $mt-$ret1['somme']; if($due<0) $due=-$due;


										if($ret1['codegrpe']!='')
										{//Ici, pour un groupe en impayés, on va selectionner ce qu'il devait et on additionne à ce qu'il doit à la date du jour
										$sql2=mysqli_query($con,"SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
										view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.ttc_fixe, compte.typeoccup, fiche1.datarriv,compte.nuite,compte.np,compte.due AS due
										FROM client, fiche1, chambre, compte, view_client
										WHERE fiche1.numcli_1 = client.numcli
										AND fiche1.numcli_2 = view_client.numcli
										AND fiche1.codegrpe = '".$ret1['codegrpe']."'
										AND chambre.numch = compte.numch
										AND compte.numfiche = fiche1.numfiche
										AND fiche1.etatsortie = 'OUI' AND compte.due>0
										LIMIT 0 , 30");
										$somme_due=0;$datarriv=array("");
										while($row=mysqli_fetch_array($sql2))
											{  	//$N_reel=$row['N_reel'];
												$due2=$row['due'];//$ttc=$row['ttc'];
												//if($datarriv==$row['datarriv'])
												$somme_due+=$due2;
												//$i++;
											}
										}
										if(!empty($somme_due))
										$due=$due+$somme_due;

										echo"<tr class='rouge1' bgcolor='".$bgcouleur."'>";?>

											<?php
											//if($_SESSION['poste']=="agent")
											//{
											echo"<td align='center'>";
											if($ret1['codegrpe']!='') echo substr($ret1['numfiche'],0,8);
											else echo "&nbsp;".$ret1['numfiche'];
											echo "</td>";
											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;";
											echo substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>";
											echo"</td>";
											if($sal!=1)
												{ if(!empty($somme_due)) {echo"<td align='center'>"; if($ret1['codegrpe']!='') echo " <a href='encaissement.php?codegrpe=".$ret1['codegrpe']."&impaye=1' style='color:#800012;text-decoration:none;' title='Encaisser pour&nbsp;:&nbsp;&nbsp;".$ret1['codegrpe']."(+Impayé:&nbsp;".$somme_due.")'>".$ret1['codegrpe']."</a>"; else echo" - "; echo  "</td>";}
												else{ echo"<td align='center'>"; if($ret1['codegrpe']!='') echo $ret1['codegrpe']; else echo" - "; echo  "</td>";}
												}
											else
												{echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo $ret1['codegrpe'];} else echo" - "; echo  "</td>";}
											//}
											//else
											//{
											//echo"<td align=''>"; echo " <a id='container' class='container' href='"; echo "reajuster.php?"; if($sal!=1) echo"fiche=1"; else echo"sal=1"; echo "&numfiche=".$ret1['numfiche']."&due=".$due."&somme=".$ret1['somme']."'  title='Réajustement du séjour&nbsp;&nbsp;&nbsp;"; echo"' style='text-decoration:none;color:#800000;'>".substr($ret1['numfiche'],0,8)."</a>"; echo "</td>";
											//echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;"; echo " <a  "; echo"style='color:black;text-decoration:none;' title='Réajustement du séjour'>".substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>"; echo"</td>";
											//echo"<td align='center'>"; if($ret1['codegrpe']!='') { echo $ret1['codegrpe'];} else echo" - "; echo  "</td>";
											//}
											echo"<td align=''>"; echo "&nbsp;".$ret1['numiden']; echo"</td>";
											echo"<td align='center' "; if($n>=15) echo "style=''"; echo ">"; 
											
											//echo "&nbsp;".substr($ret1['datarriv'],8,2).'-'.substr($ret1['datarriv'],5,2).'-'.substr($ret1['datarriv'],0,4); 
											echo "<input type='hidden' value='".$ret1['numfiche']."' id='dateZ' name='date2[]' style='text-align:right;'>";
											echo "<input type='date' value='".$ret1['datarriv1']."' id='dateZ' name='date2[]' style='text-align:center;'";?>  
											onchange="document.forms['form'].submit();" <?php  echo ">";
											
											echo "</td>";
											echo"<td align='center'";  if($n>=15) echo " style=''"; echo">";
											
											echo "<input type='hidden' value='".$ret1['numfiche']."' id='dateZ' name='date[]' style='text-align:right;'>";											
											echo "<input type='date' value='".$Jour_actuel."' id='dateZ' name='date[]' style='text-align:center;'";?>  
											onchange="alertmsg();" <?php  echo ">";
											
											//echo "&nbsp;".substr($ret1['datsortie'],8,2).'-'.substr($ret1['datsortie'],5,2).'-'.substr($ret1['datsortie'],0,4);

											echo"</td>";
											//if($sal!=1)
											//if($_SESSION['poste']=="agent")
											//{
											echo"<td align='center'>"; if($sal!=1) echo $ret1['nomch']; else echo $ret1['codesalle']; echo "</a></td>";
											//if($sal!=1)
											{
												//echo"<td align='center'>"; if($sal!=1) echo $ret1['nomch']; else echo $ret1['codesalle']; echo "</a></td>
											 echo "<td align='center'>"; //if($sal!=1) echo $typeoccup=ucfirst($ret1['typeoccup']);
											 //else echo 
											 echo $motifsejoiur=ucfirst($ret1['motifsejoiur']);
											 }
									/* 		 else{
											 echo"<td align='center'>"; if(isset($ret1['codesalle'])) echo $ret1['codesalle']; if(isset($ret1['nomch'])) echo $ret1['nomch']; echo"</td>
											<td align='center'>"; if($sal!=1) echo $typeoccup=ucfirst($ret1['typeoccup']);
											 else echo $motifsejoiur=ucfirst($ret1['motifsejoiur']);
											 } */
											 
											 echo"</td>
											<td align=''>&nbsp;". $ret1['adresse']."</td>
											<td align='center'>";
												$n=round((strtotime($Jour_actuel)-strtotime($ret1['datarriv']))/86400);
												$dat=(date('H')+1);
												settype($dat,"integer");
												if ($dat<14){$n=$n;}else {$n= $n+1;}
												if ($n==0){$n= $n+1;} $n=(int)$n;
												if($ret1['ttc_fixeR']!=0)
													$mt=$ret1['ttc_fixeR']*$n;
												else 
													$mt=$ret1['ttc_fixe']*$n;												
												
											$Rnumfiche = $ret1['numfiche'] ;
											if(!empty($ret1['codegrpe'])){
												$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".$ret1['codegrpe']."'";
												$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
												$datap=mysqli_fetch_object($req0);
												$Rnumfiche = $datap->code_reel;
											}

											$s=mysqli_query($con,"SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."' AND Ferme='NON'");
											$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotal=0;
											if($nbreresult=mysqli_num_rows($s)>0)
												{	while($retA=mysqli_fetch_array($s))
														{ 	$ListeConnexe[$i]=$retA['code'];
															$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
															$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
															//$MontantPaye =$retA['MontantPaye'];
															$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
															$Ttotal+=$Ttotali;
														}$mt+=$Ttotal;
												}												
														
											echo $mt;
											echo "</td>"; $var1=$ret1['somme'] ;
											echo "<td align='center'>"; echo $ret1['somme']; echo  "</td>";
											 $var = $mt-$var1;
									 if($var<=0) {echo"<td align='center' style='' >"; echo $var;echo"</td>";}
									 else {echo"<td align='center' style='background-color:red;'>"; echo $var;echo"</td>";}   ?>

									 <td align='center'>
									<input type="checkbox" name="choix[]" value="<?php if(isset($ret1['nomch'])) echo $ret1['nomch']; if(isset($ret1['numsalle'])) echo $ret1['numsalle']; ?>"/>
									</td>

									<?php
									echo"</tr>";
									$i=$i+1;
							if($n>=15) $trouver=1;
						}
					?>
					</table>
				</td>
			</tr>
		</table>
		 </form>
		 </div>
	</body>
</html>