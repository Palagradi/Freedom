<?php
		include 'menu.php';
		$_SESSION['update']=1;		//if(!empty($_GET['update']))
		{//$update=mysqli_query($con,"UPDATE configuration_facture SET num_reserv =num_reserv +1 "); unset($_GET['update']);
		}
		if(isset($_POST['im'])&& ($_POST['im']=='VALIDER') )
		{ $update=mysqli_query($con,"UPDATE configuration_facture SET num_reserv =num_reserv +1 ");
			$reqsel=mysqli_query($con,"SELECT numrecu FROM configuration_facture");
			$data=mysqli_fetch_object($reqsel);
			$NumFact=NumeroFacture($data->numrecu);  //$numFactNorm=NumeroFacture($data->numFactNorm);
			$date=date('Y-m-d');//$_SESSION['exhonerer1']=$_POST['exhonerer1']; $_SESSION['exhonerer_aib']=$_POST['exhonerer_aib'];
			if(isset($_POST['exhonerer1'])&& ($_POST['exhonerer1']==1))
			$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('$date','".$_SESSION['numresch']."')");
			$edit3=isset($_POST['edit3'])?$_POST['edit3']:0;$edit_03=isset($_POST['edit_03'])?$_POST['edit_03']:0;
			$edit4=isset($_POST['edit4'])?$_POST['edit4']:0;$edit_04=isset($_POST['edit_04'])?$_POST['edit_04']:0;
			$_SESSION['mtht']=$edit3+$edit_03;
			$_SESSION['mtttc']=$edit4+$edit_04;
			$_SESSION['avc']=!empty($_POST['edit7'])?$_POST['edit7']:0;
			$_SESSION['avc_salle']=!empty($_POST['edit_7'])?$_POST['edit_7']:0;
			$_SESSION['tn']=isset($_POST['edit5'])?$_POST['edit5']:0;
			$edit6=isset($_POST['edit6'])?$_POST['edit6']:0;$edit_06=isset($_POST['edit_06'])?$_POST['edit_06']:0;
			$_SESSION['tva']=$edit6+$edit_06;

			$_SESSION['MontantTotal'] = isset($_POST['MontantTotal'])?$_POST['MontantTotal']:0;

		//if(!empty($_SESSION['nbch1']))
			
		  {	//if(empty($_POST['edit7'])||($_POST['edit7']==0)) header('location:reservationch2.php?menuParent=Gestion des Réservations&update=1');
			if(isset($_POST['exhonerer1']))
				{/*  $montant=0;
					$ret=mysqli_query($con,'SELECT typeoccuprc,tarifrc  FROM reserverch WHERE  numresch="'. $_SESSION['numresch'].'"');
					 while ($ret1=mysqli_fetch_array($ret))
					 {  if($ret1['typeoccuprc']=='double')
							$montant0=$tarifrc+2000;
						else
							$montant0=$tarifrc+1000;
							$montant+=$montant0;
					 } */
				}
			else
				{$ret=mysqli_query($con,'SELECT sum(ttc) AS montant FROM reserverch WHERE  numresch="'. $_SESSION['numresch'].'"');
				 $ret1=mysqli_fetch_assoc($ret);
				 $montant=$ret1['montant'];
				}
			$nbre_paire= $_SESSION['avc']/$_SESSION['nuite'];  $redirection=0;
			if($_SESSION['avc'] > 0) 
			{
				$sql='SELECT numch,ttc,typeoccuprc,tarifrc FROM reserverch WHERE  numresch="'. $_SESSION['numresch'].'"';
				$ret=mysqli_query($con,$sql);
				while ($ret1=mysqli_fetch_array($ret))
					 { 	  $numch=$ret1['numch'];  $typeoccuprc=$ret1['typeoccuprc'];   $tarifrc=$ret1['tarifrc'];
						// if(isset($_POST['exhonerer1'])){
/* 						if($typeoccuprc=='double')
						  $ttc=$tarifrc+2000;
						  else
						   $ttc=$tarifrc+1000;
						 }
						  else
					   		$ttc=$ret1['ttc']; */
				//if((is_int($_POST['edit7']/$ttc))||((!empty($_POST['edit7'])||($_POST['edit7']!=0))&&(is_int($ttc/$_POST['edit7'])))||($_POST['edit7']==0))
				 // {	if($ttc>0)
						//$np=(int)($_POST['edit7']/$ttc);
						$np=0;
						//echo "<br/>".
						$tr1="UPDATE reserverch SET  avancerc=avancerc+'".$_SESSION['avc']."', nuite_payee='".$np."' WHERE numresch='".$_SESSION['numresch']."' AND numch='".$numch."'";
						//$tre_1=mysqli_query($con,$tr1);
						$tr="UPDATE reservationch SET avancerc=avancerc+'".$_SESSION['avc']."' WHERE numresch='". $_SESSION['numresch']."' AND numch='".$numch."'";
						$tre=mysqli_query($con,$tr);
						if(!empty($_SESSION['avc_salle'])||($_SESSION['avc_salle']!=0))
						$_SESSION['mt']=isset($_POST['edit3'])?$_POST['edit3']:0;$_SESSION['av']=isset($_POST['edit4'])?$_POST['edit4']:0;
						$tre=mysqli_query($con,$tr1);

						if (($_SESSION['avc']!=0)||($_SESSION['avc_salle']!=0))
						{ if ($_SESSION['avc']!=0)
							{   //$avc=$ttc*$np;
								$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','".$numch."','$typeoccuprc','$tarifrc','".$_SESSION['avc']."','$np')");
								 //$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$_SESSION['avc'].'" WHERE login="'.$_SESSION['login'].'"');
								 $type=0; $ttc_fixe=0;$typech="";
								$query="INSERT INTO reeditionfacture2 VALUES (NULL,'1','".$NumFact."','".$_POST['edit1']."','".$numch."','".$typech."','".$type."','','','".$tarifrc."','".$_SESSION['nuite']."',0,'".$tarifrc."')";
								$tu=mysqli_query($con,$query);

								  $redirection=1;
							}

							//echo $redirection;
						}
						else
						{ 	echo $redirection=0;
							//header('location:reservationch2.php?menuParent=Gestion des Réservations&update=1');
						}
						//exit();
					//}
				//}
			}
/* 		if($_POST['edit4']==$_POST['edit7'])
		{ 	 	   $np=$_SESSION['nuite'];
				   $ret=mysqli_query($con,'SELECT numch,ttc,typeoccuprc,tarifrc FROM reserverch WHERE  numresch="'. $_SESSION['numresch'].'"');
				   while ($ret1=mysqli_fetch_array($ret))
				  { $numch=$ret1['numch'];
				    $typeoccuprc=$ret1['typeoccuprc'];
					$tarifrc=$ret1['tarifrc'];
					if(isset($_POST['exhonerer1']))
					{ if($typeoccuprc=='double')
					  $ttc=$tarifrc+2000;
					  else
					   $ttc=$tarifrc+1000;
					}
					else $ttc=$ret1['ttc'];
					$ttc1=$ttc*$np;
					$tr1="UPDATE reserverch SET  avancerc=avancerc+'$ttc1', nuite_payee='$np' WHERE numresch='".$_SESSION['numresch']."' AND numch='$numch'";
					$tre_1=mysqli_query($con,$tr1);
					$tr="UPDATE reservationch SET  avancerc=avancerc+'$ttc1' WHERE numresch='". $_SESSION['numresch']."' AND numch='$numch'";
					$tre=mysqli_query($con,$tr);

					$_SESSION['mt']=$_POST['edit3'];
					$_SESSION['av']=$_POST['edit4'];
					mysqli_query($con,"SET NAMES 'utf8' ");

					$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
					$avc=$ttc*$np;
					$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');

			}
		//$update=mysqli_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
		//header('location:recurc.php?menuParent=Gestion des Réservations&update=1');
		 echo $redirection=1;
		} */
		

}else {
	header('location:reservationch2.php?menuParent=Gestion des Réservations'); 
} 
	if(!empty($_SESSION['nbsal1']))
		{	//$_SESSION['mt']=$_POST['edit3'];
			//$_SESSION['av']=$_POST['edit4'];
			//$_SESSION['mtht']=$_POST['edit3']+$_POST['edit_03'];
			//$_SESSION['mtttc']=$_POST['edit4']+$_POST['edit_04'];
			//$_SESSION['avc']=$_POST['edit7'];
			//$_SESSION['avc_salle']=$_POST['edit_7'];
			//$_SESSION['tn']=$_POST['edit5'];
			//$_SESSION['tva']=$_POST['edit6']+$_POST['edit_06'];
				
			$res=mysqli_query($con,'SELECT nuiterc AS nuiterc FROM reservationsal WHERE numresch="'. $_SESSION['numresch'].'"');
			while ($ret=mysqli_fetch_array($res))
				{$nuiterc=$ret['nuiterc'];
				}
				if(isset($_POST['exhonerer1']))
				{	$ret=mysqli_query($con,'SELECT sum(mtrc) AS sum FROM reserversal,salle WHERE  reserversal.numsalle=salle.numsalle AND numresch="'. $_SESSION['numresch'].'"');
					while ($ret1=mysqli_fetch_array($ret))
					{$sum=$ret1['sum']*$nuiterc;
					}
				}
				else
				{$ret=mysqli_query($con,'SELECT sum((mtrc+0.18*mtrc)+0.1) AS sum FROM reserversal,salle WHERE  reserversal.numsalle=salle.numsalle AND numresch="'. $_SESSION['numresch'].'"');
					while ($ret1=mysqli_fetch_array($ret))
					{$sum=(int)($ret1['sum']*$nuiterc);
					}
				}	//echo $_SESSION['avc_salle']/$sum;
					//if(is_int($_SESSION['avc_salle']/$sum))
					//if(($_SESSION['avc_salle']/$sum)in_array('1','2','3','4','5'))
					//if(strcmp($_SESSION['avc_salle'],$sum)!=1)
					$etat=0;
					if(($_SESSION['avc_salle']/$sum==1)||($_SESSION['avc_salle']/$sum==2))
				    {   echo 520; 
						// Bout de codes commentées ce 15.10.2016 à 15H 02
						$np_sal=(int)($_SESSION['avc_salle']/($sum/$nuiterc));
						$ret=mysqli_query($con,'SELECT reserversal.numsalle,reserversal.mtrc,salle.typesalle FROM reserversal,salle WHERE  reserversal.numsalle=salle.numsalle AND numresch="'. $_SESSION['numresch'].'"');
							while ($ret1=mysqli_fetch_array($ret))
							{ $numsalle=$ret1['numsalle'];
							  $typesalle=$ret1['typesalle'];
							  $mtrc=$ret1['mtrc'];
							  if(isset($_SESSION['exhonerer2']))
								$ttc=$ret1['mtrc'];
							 else
								$ttc=(int)(($ret1['mtrc']+0.18*$ret1['mtrc'])+0.1);
							//echo"<br/>".
							$tr1="UPDATE reserversal SET  avancerc=avancerc+'".$ttc."', nuite_payee ='$np_sal' WHERE numresch='". $_SESSION['numresch']."' AND numsalle='$numsalle'";
							$tre1=mysqli_query($con,$tr1);
							//echo"<br/>".
							$tr="UPDATE reservationsal SET montantrc='".$_POST['edit_04']."', avancerc=avancerc+'".$ttc*$np_sal."' WHERE numresch='". $_SESSION['numresch']."' AND numsalle='$numsalle'";
							$tre1=mysqli_query($con,$tr);
							$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$mtrc','$ttc','$np_sal')");
							$avc=$ttc*$np_sal;
							//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
							}  $etat=1;
							//header('location:recurc.php');
					//echo $redirection=1;
					}else if(($_SESSION['avc_salle']!=0)&&($etat!=1))
							{	echo 125;
								$ret=mysqli_query($con,'SELECT reserversal.numsalle,reserversal.mtrc,salle.typesalle FROM reserversal,salle WHERE  reserversal.numsalle=salle.numsalle AND numresch="'. $_SESSION['numresch'].'"');
									while ($ret1=mysqli_fetch_array($ret))
									{ $numsalle=$ret1['numsalle'];
									  $typesalle=$ret1['typesalle'];
									  $mtrc=$ret1['mtrc'];
									if($_POST['exhonerer1']!=1)
										echo $ttc=(int)(($ret1['mtrc']+$TvaD*$ret1['mtrc'])+0.1);
									else
										$ttc=$ret1['mtrc'];
									 //if((is_int($_SESSION['avc_salle']/$ttc))||(is_int($ttc/$_SESSION['avc_salle'])))
									  {		
											if($ttc>0)
											$np_sal=(int)$_SESSION['avc_salle']/$ttc;
											echo"<br/>". $tr1="UPDATE reserversal SET  avancerc=avancerc+'".$_SESSION['avc_salle']."', nuite_payee ='$np_sal' WHERE numresch='". $_SESSION['numresch']."' AND numsalle='$numsalle'";
											$tre1=mysqli_query($con,$tr1);
											echo"<br/>". $tr="UPDATE reservationsal SET montantrc='".$_POST['edit_04']."', avancerc=avancerc+'".$_SESSION['avc_salle']."' WHERE numresch='". $_SESSION['numresch']."' AND numsalle='$numsalle'";
											$tre1=mysqli_query($con,$tr);
											$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$mtrc','$ttc','$np_sal')");
											$avc=$ttc*$np_sal;
											//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
											//$update=mysqli_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
											//if(empty($_SESSION['groupe']))
												//header('location:recurc.php?menuParent=Gestion des Réservations&update=1');


											echo $redirection=1;
											//else
												//header('location:facture_reservation.php');
										}
									}//echo 132;
							}else
								{//header('location:reservationch2.php?menuParent=Gestion des Réservations');
								 $redirection=0;
								}
		} 
	if($redirection==1)
		{ //echo 12;
			//header('location:recurc.php?menuParent=Gestion des Réservations&update=1');

			$TotalTaxe=0;$TotalTva=0;//$Mtotal=0;

			 if(!empty($_SESSION['nbch1'])AND(!empty($_SESSION['nbsal1']))) $_SESSION['nature'] = 'Réservation';
			 else if(!empty($_SESSION['nbch1'])AND(empty($_SESSION['nbsal1']))) $_SESSION['nature'] = 'Réservation de chambres';
			 else $_SESSION['nature'] = 'Réservation de salles';

			$client=!empty($_SESSION['groupe'])?$_SESSION['groupe']:$_SESSION['client']; $state=4;
			$d=substr($_SESSION['debut'],8,2).'/'.substr($_SESSION['debut'],5,2).'/'.substr($_SESSION['debut'],0,4) ;
			$dp=substr($_SESSION['fin'],8,2).'/'.substr($_SESSION['fin'],5,2).'/'.substr($_SESSION['fin'],0,4) ;

			if($RegimeTVA==2) $Tps=1; else $Tps=0;
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','".$NumFact."','0','0','0','".$client."','".$_SESSION['nature']."','".$d."','".$dp."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['MontantTotal']."','0','0','".$_SESSION['avc']."','".$Tps."')";
			$tu=mysqli_query($con,$query);

			$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$_SESSION['avc'].'" WHERE login="'.$_SESSION['login'].'"');

			$_SESSION['cli'] = $client; $_SESSION['avanceA'] = $_SESSION['avc']; $_SESSION['Numreserv'] = $NumFact;
			$_SESSION['remise']=0; $_SESSION['cli'] = $client; //$_SESSION['etat'] = 1;
			$update=mysqli_query($con,"UPDATE configuration_facture SET numrecu=numrecu+1 ");
			//$_SESSION['nature'] = 'Réservation';//$_SESSION['ttc_fixe'] = $ttc_fixe;
			echo "<center><iframe src='receiptHi.php";  echo "' width='600' height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-top:-25px;'></iframe></center>";

		}
	 else
	   {if(!empty($_SESSION['nbch1']))
		   { //echo 21;
			   //header('location:reservationch2.php?menuParent=Gestion des Réservations&update=1');
		   }
	    else
			header('location:reservationsal.php?menuParent=Gestion des Réservations&update=1');
			}
		}
		
	}

//echo $_SESSION['client'];
?>
<html>
	<head>
	<link rel="Stylesheet" href='css/table.css' />
	<link rel="Stylesheet" type="text/css"  href='css/input.css' />
	<script type="text/javascript">
		function Aff()
		{    document.getElementById("edit5").value=document.getElementById("edit_05").value;
		}
		function Aff1()
		{	document.getElementById("edit6").value=(document.getElementById("edit3").value*document.getElementById('combo2').options[document.getElementById('combo2').selectedIndex].value).toFixed(4);
		}

		function Aff2()
		{
			if (document.getElementById("edit25").value!='')
			{
				document.getElementById("edit29").value=document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value;
				document.getElementById("edit26").value=parseInt(document.getElementById("edit28").value)+parseInt(document.getElementById("edit29").value)+parseInt(document.getElementById("edit25").value);
			}
		}
		function Aff3()
		{
			if ((document.getElementById("edit5").value!='') && (document.getElementById("edit6").value!=''))
			{ if ((document.getElementById("aib1").value!=''))
				document.getElementById("edit4").value=(Math.round(parseFloat(document.getElementById('edit6').value)+parseFloat(document.getElementById('edit3').value)+parseFloat(document.getElementById('edit5').value)-parseFloat(document.getElementById('aib1').value))).toFixed(4);
			  else
				document.getElementById("edit4").value=Math.round(parseFloat(document.getElementById('edit6').value)+parseFloat(document.getElementById('edit3').value)+parseFloat(document.getElementById('edit5').value));
			}
		}

		function Aff4()
		{document.getElementById("edit_06").value=(document.getElementById("edit_03").value*document.getElementById('combo_02').options[document.getElementById('combo_02').selectedIndex].value).toFixed(4);
		 //document.getElementById("edit_04").value=document.getElementById("edit_03").value+document.getElementById("edit_06").value;
		}
		function Aff5()
		{
			//if (!empty(document.getElementById("edit_06").value))
			//{
			/* 	if ((document.getElementById("aib2").value!=''))
					document.getElementById("edit_04").value=(Math.round(parseFloat(document.getElementById('edit_06').value)+parseFloat(document.getElementById('edit_03').value)-parseFloat(document.getElementById('aib2').value))).toFixed(4);
				else */
					document.getElementById("edit_04").value=Math.round(parseFloat(document.getElementById('edit_06').value)+parseFloat(document.getElementById('edit_03').value));
			//}
		}
		function Aff44()
		{document.getElementById("edit_06").value=(document.getElementById("edit_03").value*document.getElementById('combo_023').options[document.getElementById('combo_023').selectedIndex].value);
		}
		function Aff55()
		{
			if ((document.getElementById("edit_06").value!=''))
			{	if ((document.getElementById("aib2").value!=''))
					document.getElementById("edit_04").value=(parseFloat(document.getElementById('edit_06').value)+parseFloat(document.getElementById('edit_03').value)-parseFloat(document.getElementById('aib2').value)).toFixed(4);
				else
					document.getElementById("edit_04").value=parseFloat(document.getElementById('edit_06').value)+parseFloat(document.getElementById('edit_03').value);
			}
		}
		function Aff11()
		{   document.getElementById("edit6").value=(document.getElementById("edit3").value*document.getElementById('combo02').options[document.getElementById('combo02').selectedIndex].value).toFixed(4);
		}
		function Aff33()
		{
			if ((document.getElementById("edit6").value!=''))
			{if ((document.getElementById("aib1").value!=''))
				document.getElementById("edit4").value=(parseFloat(document.getElementById('edit6').value)+parseFloat(document.getElementById('edit3').value)+parseFloat(document.getElementById('edit5').value)-parseFloat(document.getElementById('aib1').value)).toFixed(4);
			 else
				document.getElementById("edit4").value=parseFloat(document.getElementById('edit6').value)+parseFloat(document.getElementById('edit3').value)+parseFloat(document.getElementById('edit5').value);
			}
		}


		</script>
	<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<style>

			td {
			  padding: 5px 0;
			}

		</style>
	</head>
	<body bgcolor='azure' style="">
		<?php
	if(!isset($_GET['p'])) {
	?>
	<div class="container" align="" style="">
			<form action='cresch.php?menuParent=Gestion des Réservations&p=1' method='post'>
				<table align='center' width='700' id="tab" style="">
					<tr>
						<td colspan='4'> &nbsp; </td>
					</tr>
					<tr align='center' >
						<td style="font-weight:bold;color:maroon;"> <h5>Réf. Réservation: </h5></td>
						<td> <input type='text' name='edit1' id='edit1' readonly value='<?php if(isset($_SESSION['numresch'])) echo $_SESSION['numresch']; ?>' style='border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;text-align:center;'  /> </td>
						<td style="font-weight:bold;color:maroon;"> <h5>Date : </h5></td>
						<td> <input type='text' name='edit2' value="<?php echo date('d-m-Y') ?>" readonly  style='border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;text-align:center;'/> </td>
					</tr>
										<tr>
						<td colspan='4'> &nbsp; </td>
					</tr>


					<?php
					if(!empty($_SESSION['nbch1'])){
					echo "<tr align='right' style='background-color:white;'>
						<td style='color:#046380;font-size:1.1em;font-weight:bold;'>CHAMBRE&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  </td>
						<td style='color:#046380;font-size:1.1em;font-weight:bold;'>&nbsp; &nbsp;&nbsp;  TYPE D'OCCUPATION&nbsp; &nbsp; &nbsp; &nbsp;</td>
						<td style='color:#046380;font-size:1.1em;font-weight:bold;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TARIF </td>
						<td style='color:#046380;font-size:1.1em;font-weight:bold;'> MONTANT &nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>";
							$mt=0;
							if($_SESSION['nuite']==0) $_SESSION['nuite']=1;
							mysqli_query($con,"SET NAMES 'utf8' ");
							if(isset($_SESSION['numresch'])){$ret=mysqli_query($con,'SELECT * FROM reserverch,chambre WHERE  EtatChambre="active" AND chambre.numch= reserverch.numch AND  numresch="'. $_SESSION['numresch'].'"');
							while ($ret1=mysqli_fetch_array($ret))
								{
									echo "<tr align='right'>";
										echo "<td>"; echo($ret1['nomch']); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
										echo "<td>&nbsp; &nbsp;&nbsp;"; echo(ucfirst($ret1['typeoccuprc'])); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
										echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; echo($ret1['tarifrc']); echo "</td>";
										echo "<td>"; echo($_SESSION['nuite']*$ret1['tarifrc']); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
									echo "</tr>";
									$mt=$mt+$ret1['tarifrc']*$_SESSION['nuite'];
								}
							}

					echo "<tr align='right' style='background-color:white;'>
						<td colspan='3' style='color:maroon;font-size:1.1em;'> MONTANT TOTAL : </td>
						<td colspan='3' style='color:maroon;font-size:1.1em;'> ".$mt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>";

					echo "<input type='hidden' name='MontantTotal' id='' value='"; if(isset($mt)) echo $mt; echo"'readonly />";

					//echo "<input type='hidden' name='client' id='' value='"; if(isset($_SESSION['client'])) echo $_SESSION['client']; echo"'readonly />";

	/* 				echo "<tr align='center'>
						<td  style='color:maroon;font-size:1.1em;'> <br/> Montant HT : </td>
						<td> <br/> <input type='text' name='edit3' id='edit3' value='"; echo $mont=!empty($mont)?$mont:NULL; echo $mt+$mont; echo"'readonly /> </td>
						<input type='hidden' name='aib1' id='aib1' value='"; if(!empty($_SESSION['exhonerer_aib'])) echo 0.01*($mt+$mont); echo "' readonly /> </td>
						<td  style='color:maroon;font-size:1.1em;'>  <br/>
						Tva:";
								//if(isset($_SESSION['exhonerer1']) && $_SESSION['exhonerer1']!=1)
								//{
									echo "<select name='combo2' id='combo2' onchange='Aff();Aff1();Aff3()' style='font-family:sans-serif;font-size:80%;'>
								<option value=''>  </option>";
								//mysqli_query($con,"SET NAMES 'utf8' ");
									//$ret=mysqli_query($con,"SELECT * FROM taxes WHERE NomTaxe='TVA'");
									//while ($ret1=mysqli_fetch_array($ret))
										//{
											echo "<option value='".$TvaD."'>"; echo($TvaD*100); echo "%</option>";
										//}
/* 								}
								else
								{echo"<select name='combo02' id='combo02' onchange='Aff();Aff11();Aff33()' style='font-family:sans-serif;font-size:80%;'>
								<option value=''>  </option>";
								echo "<option value='0'>"; echo 0; echo "</option>";
								} */

/* 							echo "</select></td>
						<input type='hidden' name='edit8' id='edit8' value='"; echo $_SESSION['nuite'];  echo "' readonly />
						<td> <br/><input type='text' name='edit6' id='edit6' readonly /></td>";
							$s=mysqli_query($con,'SELECT count(numch) as nb FROM reserverch WHERE numresch="'. $_SESSION['numresch'].'"');
							$ez=mysqli_fetch_array($s);
						echo "<td> <input type='hidden' name='edit9' id='edit9' value='"; echo $ez['nb']; echo "' readonly /> </td>
					</tr>
					<tr align='center'>
						<td  style='color:maroon;font-size:1.1em;'>
							Taxe:
							<select name='combo1' id='combo1' onchange='Aff();Aff3();Aff33() ' style='font-family:sans-serif;font-size:80%;'>
								<option value='Default'> </option>";
									$ret=mysqli_query($con,'SELECT * FROM taxenuite');
									while ($ret1=mysqli_fetch_array($ret))
										{
											echo "<option value='"; if(empty($_SESSION['nbch1'])) echo 0; else echo $ret1[0]; echo"'>";
											if(empty($_SESSION['nbch1']))echo 0; else echo($ret1[0]); echo "</option>";
										}
							echo "
							</select>
							<input type='hidden' name='edit_05' id='edit_05' value='"; if(empty($_SESSION['nbch1'])) echo 0; else echo $_SESSION['taxe']*$_SESSION['nuite']; echo "' readonly />
							<td> <input type='text' name='edit5' id='edit5' value='' readonly /></td>
						</td>
						<td  style='color:maroon;font-size:1.1em;'> Montant TTC: </td>
						<td> <input type='text' name='edit4'  id='edit4' readonly /> </td>
					</tr>"; */
				}

			if(!empty($_SESSION['nbsal1'])){
				   echo "<tr align=''>
						<td style='color:#046380;font-size:1.1em;'><hr/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Désignation Salle </td>
						<td style='color:#046380;font-size:1.1em;'> <hr/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Motif de la location </td>
						<td style='color:#046380;font-size:1.1em;'> <hr/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Tarif </td>
						<td style='color:#046380;font-size:1.1em;'><hr/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp; Montant </td>
					</tr>";
							$mont1=0;
							mysqli_query($con,"SET NAMES 'utf8' ");
							if(isset($_SESSION['numresch'])) $ret=mysqli_query($con,'SELECT * FROM reserversal WHERE numresch="'. $_SESSION['numresch'].'"');
							while ($ret1=mysqli_fetch_array($ret))
								{
									echo "<tr align='center'>";
										echo "<td>"; echo($ret1['codesalle']); echo "</td>";
										echo "<td>"; echo ucfirst($codesalle=$ret1['typeoccuprc']); echo "</td>";
										echo "<td>"; echo($ret1['mtrc']); echo "</td>";
										echo "<td>"; echo($ret1['mtrc']*$_SESSION['nuiteA']); echo "</td>";
									echo "</tr>";
									$mont1=$mont1+$ret1['mtrc']*$_SESSION['nuiteA'];
								}
						echo "
						<input type='hidden' name='aib2' id='aib2' value="; if(!empty($_SESSION['exhonerer_aib'])) echo 0.01*$mont1; ; echo" readonly /> 
						
						<tr align='left'>
						<td  style='align:left;' style='color:maroon;font-size:1.1em;'> <br/> Montant HT : </td>
						<td> <br/> <input type='text' name='edit_03' id='edit_03' value="; echo $mont1; echo " readonly /> </td>
						</td>
						<td  style='color:maroon;font-size:1.1em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						% Tva :&nbsp; ";

								//if(isset($_SESSION['exhonerer2']) &&$_SESSION['exhonerer2']!=1)
								//{
							echo "<select name='combo_02' id='combo_02' onchange='Aff4();Aff5();' style='font-family:sans-serif;font-size:80%;'>
								<option value=''>  </option>";

								//$ret=mysqli_query($con,"SELECT * FROM taxes WHERE NomTaxe='TVA'");
									//while ($ret1=mysqli_fetch_array($ret))
										//{
											//echo "<option value='".$TvaD."'>"; echo($TvaD*100); echo "%</option>";
											
											echo "<option value='0'>"; echo 0; echo "%</option>";
											
											
										//}
								//}
/* 								else
								{echo "<select name='combo_023' id='combo_023' onchange='Aff44();Aff55()' style='font-family:sans-serif;font-size:80%;'>
								<option value=''>  </option>";
								echo "<option value='0'>"; echo 0; echo "</option>";
								} */
							echo "
							</select></td>
						<input type='hidden' name='edit_08' id='edit_08' value=".$_SESSION['nuiteA']." readonly />
						<td style='color:maroon;font-size:1.1em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TVA<br/><input type='text' name='edit_06' id='edit_06' readonly /></td>";

							$s=mysqli_query($con,'SELECT count(numch) as nb FROM reserverch WHERE numresch="'. $_SESSION['numresch'].'"');
							$ez=mysqli_fetch_array($s);
					echo "
					<td> <input type='hidden' name='edit_09' id='edit_09' value=". $ez['nb']." readonly /> </td>
					</tr>
					<tr align='center'>
						<td  style='font-weight:bold;'>
							<td> <input type='hidden' name='edit_05' id='edit_05'  readonly /></td>
						</td>
						<td  style='color:maroon;font-size:1.1em;'> Montant TTC: </td>
						<td> <input type='text' name='edit_04'  id='edit_04' readonly /> </td>

					</tr>";
			}
		echo "<tr>
				<td colspan='4' align=''> <hr/> &nbsp;&nbsp; &nbsp;<input disabled style='float:left;' type='checkbox' id='test1' name='exhonerer1'  value='1'/> <label for='test1' ><span style='font-style:italic;'>Exhonérer de la TVA</span></label>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<input  disabled style='float:right;' type='checkbox' id='test2'  name='exhonerer_aib'   value='1'/> <label for='test2' ><span style='font-style:italic;'>Exhonérer de AIB </span></label></td>
			</tr>";
					echo "<tr align='center'>
						<td colspan='4' align='center' >";
						if(!empty($_SESSION['nbch1']))
						{	echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;<hr style='margin-top:-10px;'/>Avance  [Chambre]:
							<input type='text' name='edit7' onkeypress='testChiffres(event);' style='width:150px;text-align:center;font-size:1.1em;'  /> ";
						}
					?>


					<?php if(!empty($_SESSION['nbsal1']))
					echo"&nbsp;&nbsp;<hr style=''/>Avance [Salle]: &nbsp;&nbsp;&nbsp;
					 <input type='text' name='edit_7' onkeypress='testChiffres(event);' style='width:150px;text-align:center;font-size:1.1em;'/>  ";
					?>
					</td></tr>
					<tr align='center'>
						<td colspan='4' align='center'> <br/><br/><input class='bouton2' type='submit' name='im' value='VALIDER' style="" <?php echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; ?>/><br/>&nbsp; </td>
					</tr>
				</table>
			</form>
	</div>
	<?php
	}
	?>
	</body>
	<script type="text/javascript">



		// fonction pour calculer
		/*function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit5').value = leselect;
					}
				}
				xhr.open("POST","clnuit.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("taxe="+sh);
		}


		//affichage des informations concernant le client


		var momoElement1 = document.getElementById("combo1");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action6, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action6);
		}


		//fonction standard
		function getXhr(){
			xhr=null;
				if(window.XMLHttpRequest){
					xhr=new XMLHttpRequest();
				}
				else if(window.ActiveXObject){
					try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else{
					alert("votre navigateur ne suporte pas les objets XMLHttpRequest");
				}
				return xhr;
			}*/
	</script>
</html>
