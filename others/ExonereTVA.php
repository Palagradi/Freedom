<?php
	 session_start(); include '../connexion.php';
	 
	$date = new DateTime("now"); // 'now' n'est pas n�c�ssaire, c'est la valeur par d�faut
	$tz = new DateTimeZone('Africa/Porto-Novo');
	$date->setTimezone($tz);
	$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
	$Jour_actuel= $date->format("Y") ."-". $date->format("m")."-". $date->format("d");
	
	if(isset($_SESSION['codegrpe'])){	
	$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	mysqli_query($con,"SET NAMES 'utf8'");
	//if($sal==1)
	//$re=mysqli_query($con,"SELECT * FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche AND location.etatsortie='NON'");
	//else
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'  AND mensuel_fiche1.codegrpe='".$_SESSION['codegrpe']."' ORDER BY nomch ASC");
	
	//$query_Recordset1 = "SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'   ORDER BY $trie ASC";

/* 		if(isset($_POST['SUPPRIMER']) && !empty($_POST['choix'])){
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
					$ras=mysqli_query($con,"SELECT * FROM fiche1,client,mensuel_compte,chambre WHERE chambre.numch=mensuel_compte.numch AND fiche1.numcli_1=client.numcli and fiche1.numfiche=mensuel_compte.numfiche and  etatsortie='NON' AND mensuel_fiche1.codegrpe='".$_SESSION['codegrpe']."' and nomch='".$valeur."'");
					$rat=mysqli_fetch_array($ras);
					$numfiche= $rat['numfiche']; $numch= $rat['numch'];
					if(($rat['somme']==0)&&($rat['due']==0))
						{
							$ras1=mysqli_query($con,"DELETE FROM fiche1 WHERE numfiche='$numfiche'");
							$ras2=mysqli_query($con,"DELETE FROM mensuel_compte WHERE numfiche='$numfiche'");
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
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' AND mensuel_fiche1.codegrpe='".$_SESSION['codegrpe']."' ORDER BY nomch ASC");
} */
	if(isset($_POST['VALIDER']) && !empty($_POST['choix'])){
		$req="DELETE FROM ExonereTVA WHERE groupe='".$_SESSION['codegrpe']."'";
		$sql=mysqli_query($con,$req);
		
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
				//echo $valeur;				
				 $sql = "SELECT * FROM mensuel_fiche1,client,mensuel_compte,chambre WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli and mensuel_fiche1.numfiche=mensuel_compte.numfiche and  etatsortie='NON' AND mensuel_fiche1.codegrpe='".$_SESSION['codegrpe']."' and nomch='".$valeur."'";
				$ras=mysqli_query($con,$sql); 	$rat=mysqli_fetch_array($ras);	$numfiche= $rat['numfiche']; //$ttc_fixe= $rat['ttc_fixe'];
				$n=round((strtotime($Jour_actuel)-strtotime($rat['datarriv']))/86400);
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;} $n=(int)$n;
				$ttc_fixe=$rat['ttc_fixe']; $mt=$rat['ttc_fixe']*$n; //$mt=$rat['ttc_fixe']; 
				$var1=$rat['somme'] ;
				$var = $mt-$var1;	
				
				if($ttc_fixe<=20000) $taxe = 500;else if(($ttc_fixe>20000) && ($ttc_fixe<=100000))	$taxe = 1500;else $taxe = 2500;
				$taxe*=$n;
				$var-=$taxe;  $varT=$var; 
				$var/=1.18;   //$var=round($var);	
				$var=$varT-$var;  //echo $var=round($var);
				 //echo $var*=0.18;	
				 echo $var=round($var);
				
				$res=mysqli_query($con,'CREATE TABLE IF NOT EXISTS ExonereTVA (date DATE NOT NULL,
				groupe VARCHAR(25) NOT NULL, numfiche VARCHAR(25) NOT NULL, Exonere int(11),ValeurTVA double NOT NULL
				) ENGINE = InnoDB ');
				$req="INSERT INTO ExonereTVA VALUES('".$Jour_actuel."','".$_SESSION['codegrpe']."','".$numfiche."','1','".$var."')";
				$sql=mysqli_query($con,$req);

				$sql = "SELECT * FROM mensuel_fiche1,client,mensuel_compte,chambre WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli and mensuel_fiche1.numfiche=mensuel_compte.numfiche and  etatsortie='NON' and mensuel_fiche1.codegrpe='".$_SESSION['codegrpe']."' and nomch='".$valeur."'";
				$ras=mysqli_query($con,$sql);
			  	$rat=mysqli_fetch_array($ras);
				$numfiche= $rat['numfiche']; $numch= $rat['numch'];

     				echo "<script language='javascript'>";
				 	echo "var timeout = setTimeout(
				 	function() {
				 		window.opener.location.reload();
						window.close();
				 		}
					,60);";
				 echo "</script>";   
		}
	}
$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' AND mensuel_fiche1.codegrpe='".$_SESSION['codegrpe']."' ORDER BY nomch ASC");
}
	else if(isset($_POST['VALIDER']) && !isset($_POST['choix'])){
		$req="DELETE FROM ExonereTVA WHERE groupe='".$_SESSION['codegrpe']."' AND Exonere='1' AND date LIKE '".$Jour_actuel."'";
		$sql=mysqli_query($con,$req);
 		echo "<script language='javascript'>";
		echo "var timeout = setTimeout(
		function() {
			window.opener.location.reload();
			window.close();
			}
		,60);";
		echo "</script>";  
	}else {
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
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
		</style>
		<script type="text/javascript">

		</script>
	</head><body style="background-color:#84CECC;">
	<div align="" style="margin-top:-25px;">
	<form name="" method="post" ><br/><br/>
		<table align='center'>
			<tr>
				<td><hr noshade size=3> <div align="center"><B>
				<input type='submit' name='<?php  echo "VALIDER";   ?>' value='<?php echo "VALIDER";  ?>'   style='border:2px solid black;font-weight:bold;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>
					<FONT SIZE=6 COLOR="Maroon"> &nbsp; &nbsp; EXONERATION DE LA TVA </FONT></B><B> <span style='font-style:italic;font-size:1.2em;'>( <?php echo $_SESSION['codegrpe'];?> )</span></B>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					<input type="checkbox" name="choixT" value=""/>
					<FONT SIZE=4 COLOR="0000FF"> </FONT> </div> <hr noshade size=3>
				</td>
			</tr>
			<tr>
				<td>
					<table  border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>

						<tr bgcolor='<?php if($_SESSION['poste']=="agent") echo "#CD5C5C"; else echo "black";?>'align="center" <?php if($_SESSION['poste']!="agent") echo "style='color:white;'";?>>
							<td> N° FICHE</td>
							<td > NOM ET PRENOMS </td>	
							<td> <?php if($sal==1) echo "SALLE"; else echo "CHAMBRE";?> </td>							
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
										$n=round((strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400);
										$dat=(date('H')+1);
										settype($dat,"integer");
										if ($dat<14){$n=$n;}else {$n= $n+1;}
										if ($n==0){$n= $n+1;} $n=(int)$n;
										$mt=$ret1['ttc_fixe']*$n;
										$due = $mt-$ret1['somme']; if($due<0) $due=-$due;


										if($_SESSION['codegrpe']!='')
										{//Ici, pour un groupe en impayés, on va selectionner ce qu'il devait et on additionne à ce qu'il doit à la date du jour
										$sql="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
										view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif,mensuel_compte.ttc_fixe,mensuel_compte.typeoccup,mensuel_compte.ttva, fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.due AS due
										FROM client, fiche1, chambre, mensuel_compte, view_client
										WHERE fiche1.numcli_1 = client.numcli
										AND fiche1.numcli_2 = view_client.numcli
										AND fiche1.codegrpe = '".$_SESSION['codegrpe']."'
										AND chambre.numch = mensuel_compte.numch
										AND mensuel_compte.numfiche = fiche1.numfiche
										AND fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0
										LIMIT 0 , 30";
										$sql2=mysqli_query($con,$sql);
										$somme_due=0;$datarriv=array("");
										while($row=mysqli_fetch_array($sql2))
											{  	//$N_reel=$row['N_reel'];
												$due2=$row['due'];$ttva=$row['ttva'];
												//if($datarriv==$row['datarriv'])
												$somme_due+=$due2;
												//$i++;
											}
										}
										if(!empty($somme_due))
										$due=$due+$somme_due;

										echo"<tr class='rouge1' bgcolor='".$bgcouleur."'>";?>

											<?php
										
										$sqlT = "SELECT * FROM ExonereTVA WHERE numfiche='".$ret1['numfiche']."' AND date ='".$Jour_actuel."' ";
										$rasT=mysqli_query($con,$sqlT);
									
											echo"<td align='center'>";
											if($_SESSION['codegrpe']!='') echo substr($ret1['numfiche'],0,8);
											else echo "&nbsp;".$ret1['numfiche'];
											echo "</td>";
											echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;";
											echo substr($ret1['nomcli'],0,25).'	'.substr($ret1['prenomcli'],0,25)."</a>";
											echo"</td>";
											echo"<td align='center'>".$ret1['nomch']."</a></td>
											<td align='center'>";
												$n=round((strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400);
												$dat=(date('H')+1);
												settype($dat,"integer");
												if ($dat<14){$n=$n;}else {$n= $n+1;}
												if ($n==0){$n= $n+1;} $n=(int)$n;
												$mt=$ret1['ttc_fixe']*$n;
												echo $mt;
											echo"</td>"; $var1=$ret1['somme'] ;
											echo"<td align='center'>"; echo $ret1['somme']; echo  "</td>";
											 $var = $mt-$var1;
									 if($var<=0) {echo"<td align='center' style='' >"; echo $var;echo"</td>";}
									 else {echo"<td align='center' style='background-color:red;'>"; echo $var;echo"</td>";}   ?>

									 <td align='center'>
									<input type="checkbox" <?php //if($ret1['ttva']==0) echo "readonly"; ?> name="choix[]" <?php if((mysqli_num_rows($rasT)>0)||($ret1['ttva']==0)) echo "checked disabled"; ?> value="<?php if(isset($ret1['nomch'])) echo $ret1['nomch']; ?>"/>
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
<?php
}
?>						