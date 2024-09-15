<?php

	include 'menu.php';//$etat_taxe=2;$taxe=1000;$TvaD=0.18;
		if( isset($_POST['excel']) &&  $_POST['excel']==1)
			{header("Content-type: application/vnd.ms-excel");
			 echo "	<table align='center' style='margin-left:15%'>
				<tr>
					<td colspan='10' style='font-size:1.3em;'>
						<B>TABLEAU RECAPITULATIF DES RECETTES DE LA PERIODE du </B>&nbsp;&nbsp;".$_SESSION['se1']."/".$_SESSION['se2']."/".$_SESSION['se3']."&nbsp;&nbsp;<b>au</b>&nbsp;&nbsp;".$_SESSION['se4']."/".$_SESSION['se5']."/".$_SESSION['se6']."
					</td>
				</tr>
					</table>";
			}else{
				 echo "	<table align='center' style='float:left;margin-left:15%;margin-top:-20px;color:#444739;'>
					<tr>
						<td style='font-size:1.3em;'>
							<B>TABLEAU RECAPITULATIF DES RECETTES ";   if($_POST['choix']==2) echo "&nbsp;CHAMBRES&nbsp;"; else echo "&nbsp;SALLES&nbsp;"; echo "POUR LA PERIODE du </B>&nbsp;&nbsp;".$_POST['se1']."/".$_POST['se2']."/".$_POST['se3']."&nbsp;&nbsp;<b>au</b>&nbsp;&nbsp;".$_POST['se4']."/".$_POST['se5']."/".$_POST['se6']."
						</td>
					</tr>
				</table>";
			}
	$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];
	$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];

		echo "<table align='center'  border='1' cellpadding='0' cellspacing='0' style='border:1px solid gray;font-family:Cambria;margin-top:-40px;'>
			<tr bgcolor='#FDF5E6' style='color:purple; font-size:16px; '> ";
				echo"<td rowspan='2' align='center' > DATE </td> ";
			    echo"<td colspan='4' align='center' >MONTANT HT</td> ";
				echo"<td colspan='4' align='center' bgcolor='white' >TVA </td> ";
				echo"<td colspan='4' align='center' >TAXE DE SEJOUR	 </td> ";
				echo"<td colspan='4' rowspan='2' align='center'>TOTAL </td>
			</tr>
			<tr bgcolor='#f5f5dc' style='color:purple; font-size:16px; '> ";

			mysqli_query($con,"SET NAMES 'utf8'");
			$ref=mysqli_query($con,"SELECT DISTINCT DesignationType FROM chambre ");
			$i=0; $tab=array("");
			while ($rerf=mysqli_fetch_array($ref))
			{  $tab[$i]=strtoupper($rerf['DesignationType']." "."simple");$i++;
		       $tab[$i]=strtoupper($rerf['DesignationType']." "."double");$i++;
			}
			for($k=0;$k<3;$k++){
			for($j=0;$j<$i;$j++){
				echo"<td align='CENTER' style='color:#444739;'>". $tab[$j] ."</td> ";
			}
			echo "<br/>";
			}
/* 			mysqli_query($con,"SET NAMES 'utf8'");
			$ref=mysqli_query($con,"SELECT DISTINCT typech FROM chambre ");
			$i=0; $typech=array("");$Ntypech=mysqli_num_rows($ref);
			while ($rerf=mysqli_fetch_array($ref))
			{  $typech[$i]=$rerf['typech'];$i++;
			} 

/* 			mysqli_query($con,"SET NAMES 'utf8'");
			$ref=mysqli_query($con,"SELECT typeoccuprc AS typeoccup FROM Typeoccupation ORDER BY Nbpers ");
			$i=0; $typeoccup=array("");
			while ($rerf=mysqli_fetch_array($ref))
			{  $typeoccup[$i]=$rerf['typeoccup'];$i++;
			} $Ntypeoccup=mysqli_num_rows($ref); */

/* 			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";

			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";

			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> "; */
		echo"</tr> ";
		echo"<tr> ";

		//$ref=mysqli_query($con,"SELECT DISTINCT datencaiss FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss ");

		$sql="SELECT DISTINCT date_emission FROM reedition_facture,reeditionfacture2 WHERE reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission>='".$debut."' and date_emission<='".$fin."' AND state='2' ORDER BY date_emission";
		$ref=mysqli_query($con,$sql);//$dataR=mysqli_fetch_object($query);
			
			
		while ($rerf=mysqli_fetch_array($ref))
		{		echo"<tr bgcolor='white'> ";
					echo"<td> "; echo substr($rerf['date_emission'],8,2).'-'.substr($rerf['date_emission'],5,2).'-'.substr($rerf['date_emission'],0,4); echo"</td> ";
					$var=0;$somme=array("");$i=0;
			 		for($k=0;$k<$Ntypech;$k++){
						for($j=0;$j<$Ntypeoccup;$j++){ // Pour afficher les montants HT
							$req="SELECT SUM(tarif*nuite) AS tarif FROM reedition_facture,reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission='".$rerf['date_emission']."' and chambre.typech='".$typech[$k]."' and reeditionfacture2.occupation='".$typeoccup[$j]."' AND state='2'";
							$res=mysqli_query($con,$req);
							$rers=mysqli_fetch_array($res); $somme[$i]=round($rers['tarif'],4);
							echo"<td align='right'>".$somme[$i]."</td> "; $i++;
						}
					}
					for($k=0;$k<$Ntypech;$k++){
						for($j=0;$j<$Ntypeoccup;$j++){	// Pour afficher les TVA         ---Attention tenir ici compte de la TVA exoneree ----Voir la requete
							$req="SELECT SUM(tva) AS tva FROM reedition_facture,reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission='".$rerf['date_emission']."' and chambre.typech='".$typech[$k]."' and reeditionfacture2.occupation='".$typeoccup[$j]."' AND state='2' ";
							$res=mysqli_query($con,$req);
							$rerf1=mysqli_fetch_array($res) ;  $somme[$i]=round($rerf1['tva'],4); //$somme[$i]=round($TvaD*$rerf1['tva'],4);
							echo"<td align='right'>".$somme[$i]."</td> "; $i++;
						}
					}
 					for($k=0;$k<$Ntypech;$k++){
						for($j=0;$j<$Ntypeoccup;$j++){	// Pour afficher les Taxes sur nuitees
							 //echo "<br/>".
							$req="SELECT SUM(taxe) AS taxe FROM reedition_facture,reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission='".$rerf['date_emission']."' and chambre.typech='".$typech[$k]."' and reeditionfacture2.occupation='".$typeoccup[$j]."' AND state='2' ";
							$res=mysqli_query($con,$req);
							$rers=mysqli_fetch_array($res) ;  $somme[$i]=round($rers['taxe'],4);
							echo"<td align='right'>".$somme[$i]."</td> "; $i++;
						}
					}
						
				    //$var=0;
					
					//echo var_dump($somme);
					for($i=0;$i<count($somme);$i++){
					$var+=$somme[$i];
					}
					//Arrondir à la dizaine superieur et inferieur : round($chiffre_a_arrondir, -1);
					//if(empty($exonerer_tva)&& empty($exonerer_aib))
					//		{echo"<td align='right'>"; echo $var0=round((int)($var),-1); echo"</td> ";}
					//	else
						{
							echo"<td align='right'> "; echo $var0=($var); echo"</td> ";
						}
				//$var=0;
			}
				echo"</tr> ";
				$somme0=0;
					echo"<tr bgcolor='#faebd7' style='font-weight:bold; font-size:16px; '> ";
					echo"<td align='center'>  Total </td>";

					$somme=array("");$i=0;

			 		for($k=0;$k<$Ntypech;$k++){
						for($j=0;$j<$Ntypeoccup;$j++){ // Pour afficher les montants HT
							$req="SELECT sum(tarif*nuite) AS som FROM reedition_facture,reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission>='".$debut."' AND date_emission<='".$fin."' and chambre.typech='".$typech[$k]."' and reeditionfacture2.occupation='".$typeoccup[$j]."' AND state='2'";
							$res=mysqli_query($con,$req);
							$rers=mysqli_fetch_array($res); $somme[$i]=round($rers['som'],4);
							echo"<td align='right'>".$somme[$i]."</td> "; $i++; //$var+=$somme5; echo $rerf['datencaiss'].$typech[$k].$typeoccup[$j];
						}
					}
					for($k=0;$k<$Ntypech;$k++){
						for($j=0;$j<$Ntypeoccup;$j++){ // Pour afficher les TVA
							$req="SELECT sum(tva) AS tva FROM reedition_facture,reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission>='".$debut."' AND date_emission<='".$fin."' and chambre.typech='".$typech[$k]."' and reeditionfacture2.occupation='".$typeoccup[$j]."' AND state='2'";
							$res=mysqli_query($con,$req);
							$rers=mysqli_fetch_array($res); $somme[$i]=round($TvaD*$rers['tva'],4); //$tva=round($rerf1['tva'],4); $somme5=round($tva,4);
							echo"<td align='right'> ".$somme[$i]."</td> "; $i++; //$var+=$somme5; echo $rerf['datencaiss'].$typech[$k].$typeoccup[$j];
						}
					}
					for($k=0;$k<$Ntypech;$k++){
						for($j=0;$j<$Ntypeoccup;$j++){ //  Pour afficher les Taxes sur Nuitee
							$req="SELECT sum(taxe) AS taxe FROM reedition_facture,reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.numFactNorm=reeditionfacture2.numrecu AND date_emission>='".$debut."' AND date_emission<='".$fin."' and chambre.typech='".$typech[$k]."' and reeditionfacture2.occupation='".$typeoccup[$j]."' AND state='2'";
							$res=mysqli_query($con,$req);
							$rers=mysqli_fetch_array($res); $somme[$i]=$rers['taxe'];
		/* 			 		if($etat_taxe==2){ //La taxe sur nuitée est appliquée par occupant
									if($typeoccup[$j]=="double")  $somme[$i]*=2;
 								} */
							echo"<td align='right'> ".$somme[$i]."</td> "; $i++; //$var+=$somme5; echo $rerf['datencaiss'].$typech[$k].$typeoccup[$j];
						}
					}
						$exoneree_tva=0;

						//echo"<td>  ";if($rers){echo $somme12=2000*$rers['np'];$somme12=($somme0+$somme12);} else {echo '-';} echo"</td> ";
						/* 	$res=mysqli_query($con,"SELECT * FROM exonerer_tva WHERE date>='".$debut."' and date<='".$fin."'");
						$rers=mysqli_fetch_array($res);  $exonerer_tva=$rers['date'];
						$res=mysqli_query($con,"SELECT * FROM exonerer_aib WHERE date>='".$debut."' and date<='".$fin."'");
						$rers=mysqli_fetch_array($res);  $exonerer_aib=$rers['date']; */

				    $var=0;
					for($i=0;$i<count($somme);$i++){
					//echo var_dump($somme[$i]);
					$var+=$somme[$i];	 //$var=$somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
					}
						echo"<td align='right'>";
/* 						$res=mysqli_query($con,"SELECT sum(ttc_fixe*np) AS ttc_fixe FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."'");
						while ($ret=mysqli_fetch_array($res))
							{			//$var=$ret['ttc_fixe'];
							}
					if(empty($exonerer_tva)&& empty($exonerer_aib))
							{echo $var=round((int)($var),-1);}
						else */
						{ 
						echo $var=round($var,4);
						}

					echo"</td>";
				echo"</tr> ";
		echo"</table> ";$aib=0;
	    $ref1=mysqli_query($con,"SELECT DISTINCT encaissement.numch AS numch,encaissement.typeoccup AS typeoccup,np AS np FROM exonerer_aib,encaissement,chambre  WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' AND numfiche=encaissement.ref");
		while($row_1=mysqli_fetch_array($ref1))
			{  $numch=$row_1['numch'];
			   $typeoccup=$row_1['typeoccup'];
			   $np=$row_1['np'];
			   if($typeoccup=='individuelle')
			   { $ref2=mysqli_query($con,"SELECT tarifsimple FROM chambre  WHERE numch='$numch'");
					while($row_2=mysqli_fetch_array($ref2))
						{$tarifsimple=$np*$row_2['tarifsimple'];
						}
			   }
			   else
			   { $ref2=mysqli_query($con,"SELECT tarifdouble FROM chambre  WHERE numch='$numch'");
					while($row_2=mysqli_fetch_array($ref2))
						{$tarifdouble=$np*$row_2['tarifdouble'];
						}
			   }
			   $aib=$tarifsimple+$tarifdouble;
			}
			$aib=round((0.01*$aib),4);
		if(!empty($aib)) {echo"<br/>Total AIB Exoneré au cours de la période :&nbsp;<b> ".$aib." </b> ";}

		$ref3=mysqli_query($con,"SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND objet IN ('Hébergement','Hebergement','Facture de groupe')");
		$data=mysqli_fetch_assoc($ref3);$remise=$data['Remise'];

		if(!empty($remise)) {echo"<br/><span style='font-size:1.1em;'>Total des Remises accordées durant la période :&nbsp;<b> ".$remise."&nbsp;F CFA</b> </span>";}
?>
<script type='text/javascript'>
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>
