<?php
include_once 'menu.php'; unset($_SESSION['Nprecedente']);
//include 'difference.php';
unset( $_SESSION['remise']); unset ($_SESSION['NumIFU']); //unset($_SESSION['db']);
unset($_SESSION['req1']);unset($_SESSION['req2']);
unset($_SESSION['cli']);unset($_SESSION['client']); // Insérer le 03.07.2021
$db=isset($_GET['db'])?$_GET['db']:NULL; if(!empty($db)) $_SESSION['db']=$db; unset($_SESSION['impaye']);unset($_SESSION['groupe1']);
$invoice=isset($_GET['invoice'])?$_GET['invoice']:NULL; if(!empty($invoice)) $_SESSION['invoice']=$invoice;unset($_SESSION['avanceA']);

//if(isset($_GET['state'])) echo $_GET['state'];

if(isset($_FILES['cpi'])&&!empty($_FILES['cpi'])) {$style="color:normal;";
if(is_file ($_FILES['cpi']['tmp_name'])) $img_blob = file_get_contents ($_FILES['cpi']['tmp_name']);else $img_blob=NULL;
if(!empty($img_blob)){
$req = "INSERT INTO images SET img_id=NULL,numfiche='',numcli='',img_blob='".addslashes($img_blob)."' ";
$ret = mysqli_query ($con,$req) or die (mysqli_error ($con));}

		if($_FILES['cpi']['size']>150000){
		echo "<script language='javascript'>";
		echo 'alertify.error("Le fichier dépasse la limite autorisée par le serveur: 150 Ko ");';
		echo "</script>";}
		}else {$style="color:white;";
		$req="DELETE FROM  images WHERE numfiche =''";
		$ret = mysqli_query ($con,$req) or die (mysqli_error ($con));
		}

/* 			$ref=mysqli_query($con,"SELECT  numfiche,numcli_2 AS numcli from fiche2");
			while($data2=mysqli_fetch_array($ref))
			{$query=mysqli_query($con,"UPDATE fiche1 SET numcli_2='".$data2['numcli']."' WHERE numfiche='".$data2['numfiche']."'");
			}  */


/*
			$ref=mysqli_query($con,"SELECT  numfiche,numcli_1,numcli_2 from fiche1 where numcli_2=''");
			while($data2=mysqli_fetch_array($ref))
			{$query=mysqli_query($con,"UPDATE fiche1 SET numcli_2='".$data2['numcli_1']."' WHERE numfiche='".$data2['numfiche']."'");
			}  */

	unset($_SESSION['numreservation']);  //if(isset($db)) $_SESSION['recufiche'] =1; else { unset($_SESSION['recufiche']);}

//$_SESSION['recufiche'] =1; if(isset($_SESSION['recufiche']))  echo $_SESSION['recufiche'];

/*DELETE  FROM `mensuel_compte` WHERE numfiche NOT IN (SELECT REF from mensuel_encaissement)
delete FROM `mensuel_encaissement` WHERE datencaiss<'2015-10-25' */

		//$query=mysqli_query($con,"DELETE FROM  mensuel_view_fiche2 WHERE numfiche NOT IN (SELECT  ref  from mensuel_encaissement)");

	unset($_SESSION['num_ch']);	unset($_SESSION['avance']);	unset($_SESSION['advance']);	unset($_SESSION['numero']);  $num_N=!empty($_GET['numero'])?$_GET['numero']:NULL; //$_SESSION['num_N']=$num_N;

	if(!empty($_GET['dir']) && $_GET['dir']!=1)
	{	unset($_SESSION['edit1']);unset($_SESSION['edit2']);unset($_SESSION['edit3']);unset($_SESSION['edit4']);$_SESSION['edit6']='';$_SESSION['edit7']='';$_SESSION['edit8']='';$_SESSION['edit5']='';
		$_SESSION['edit10']='';	$_SESSION['combo2']='';	$_SESSION['edit9']='';	$_SESSION['edit11']='';	$_SESSION['edit12']='';	$_SESSION['edit_9']='';	$_SESSION['edit_13']='';
		$_SESSION['edit_14']='';$_SESSION['edit_15']='';$_SESSION['edit_16']='';$_SESSION['edit17']='';	$_SESSION['se4']='';$_SESSION['se5']='';$_SESSION['se6']='';$_SESSION['ladate']='';	$_SESSION['edit21']='';	$_SESSION['edit19']='';
	}
/* 	$i = 1;
	$mon_tableau=array("");
	$reqse2=mysqli_query($con,"SELECT  DATEDIFF('".date('Y-m-d')."',datdep) AS DiffDate FROM fiche1 ");
	$nbre_result=mysql_num_rows($reqse2);
	while($data2=mysqli_fetch_array($reqse2))
		{	$mon_tableau[$i] = $data2['DiffDate'];
			$i++;
		}	 */
	unset($_SESSION['date_arrive2']);	unset($_SESSION['numresch']);
	$ans_courant=date('Y');$mois_courant=date('m');$jour_courant=date('d');
	$first_letter=substr($jour_courant,0,1);
	if($first_letter==0) $jour_courant=substr($jour_courant,1,1);
	$mois_precedent=$mois_courant-1;$mois_suivant=$mois_courant+1;


	unset($_SESSION['date']);	unset($_SESSION['numreservation']);unset($_SESSION['np_avance']);
	$Recordset1=mysqli_query($con,"SELECT * FROM client_tempon");

		$val="Jour";$se5="Mois";	$se6="Année";	$combo2="";
		$edit9="";		$edit17="";

		if(!empty($_GET['numcli'])) {
		$reqsel=mysqli_query($con,"SELECT * FROM client WHERE numcli ='".$_GET['numcli']."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $rlt1=$data['numcli'];   $rlt2=$data['nomcli'];   $rlt3=$data['prenomcli'];  $rlt4=$data['sexe'];  $rlt5=substr($data['datnaiss'],8,2).'-'.substr($data['datnaiss'],5,2).'-'.substr($data['datnaiss'],0,4);   $rlt6=$data['lieunaiss'];  $rlt8=$data['typepiece'];
			   $rlt9=$data['numiden'];   $rlt10=substr($data['date_livrais'],8,2).'-'.substr($data['date_livrais'],5,2).'-'.substr($data['date_livrais'],0,4);   $rlt11=$data['lieudeliv']; $rlt12=$data['institutiondeliv']; $rlt13=$data['pays']; $rlt14=$data['Telephone'];$Categorie=$data['Categorie'];
			   if(isset($data['NumIFU'])&& $data['NumIFU'] > 0 )$_SESSION['NumIFU']=$data['NumIFU'];
			}
		}
		if(!empty($_GET['numfiche'])) {
			if(isset($_GET['sal']))
				$sql="SELECT datarriv FROM location WHERE numfiche ='".$_GET['numfiche']."' ";
			else 
				$sql="SELECT datarriv FROM mensuel_fiche1 WHERE numfiche ='".$_GET['numfiche']."' ";
			$reqsel=mysqli_query($con,$sql);
			$data=mysqli_fetch_object($reqsel); $rltN=substr($data->datarriv,8,2).'-'.substr($data->datarriv,5,2).'-'.substr($data->datarriv,0,4);
		}
		 if(!empty($_SESSION['numcli'])){
			 $reqselY=mysqli_query($con,"SELECT Categorie FROM client WHERE numcli ='".$_SESSION['numcli']."' ");
			 $dataY=mysqli_fetch_array($reqselY); $Categorie=$dataY['Categorie'];
		 }
/* 	//Défalcation automatique si le client ayant reservé ne vient pas ou ne demande pas une modification de sa reservation
		$datej=date('Y-m-d');
		$i = 1; $reserv=array("");
		$sql=mysqli_query($con,"SELECT num_reserv FROM reservation_tempon");
		$nbre=mysql_num_rows($sql);
		while($result = mysqli_fetch_array($sql))
		{$reserv[$i] = $result['num_reserv'];
		 $i++;
		 } */
		/* $or="SELECT distinct reservationch.numresch,chambre.typech,reservationch.nomdemch,reservationch.datarrivch,reservationch.prenomdemch,reservationch.codegrpe,reserverch.avancerc,reserverch.typeoccuprc  FROM chambre,reservationch,reserverch WHERE reservationch.numch=chambre.numch AND reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch NOT IN(SELECT num_reserv FROM reservation_tempon)";
		$or1=mysql_query($or);
		if($or1)
		{ while ($roi= mysqli_fetch_array($or1))
			{  $numresch=$roi['numresch'];
			   $typech=$roi['typech'];
			   $avancerc=$roi['avancerc'];
			   $typeoccuprc=$roi['typeoccuprc'];
			   $date=$roi['datarrivch'];
			  $d=substr($date,8,2);
			  $m=substr($date,5,2);
			  $y=substr($date,0,4);
			  $day=date("Y-m-d");
			   $dat=date('H:i');
			   //if($dat>='23:58')
				//{	 echo "<br/>".$dat;
				// for($j=0;j<$nbre;$j++)
						//{
						//if(($numresch)!=($reserv[$i]))
							//{
							if(($typeoccuprc=='individuelle')&&($typech=='V'))
									{//$ri=mysqli_query($con,"UPDATE reservationch SET avancerc=avancerc-7500 WHERE numresch='$numresch'");
									 //$ri=mysqli_query($con,"UPDATE reserverch SET avancerc=avancerc-7500 WHERE numresch='$numresch'");
									 $defalquer=7500;
									}
								 if(($typeoccuprc=='individuelle')&&($typech=='CL'))
									{//$ri=mysqli_query($con,"UPDATE reservationch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 //$ri=mysqli_query($con,"UPDATE reserverch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 $defalquer=12000;
									}
								if(($typeoccuprc=='double')&&($typech=='V'))
									{//$ri=mysqli_query($con,"UPDATE reservationch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 //$ri=mysqli_query($con,"UPDATE reserverch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 $defalquer=9500;
									}
								if(($typeoccuprc=='double')&&($typech=='CL'))
									{//$ri=mysqli_query($con,"UPDATE reservationch SET avancerc=avancerc-14000 WHERE numresch='$numresch'");
									 //$ri=mysqli_query($con,"UPDATE reserverch SET avancerc=avancerc-14000 WHERE numresch='$numresch'");
									 $defalquer=14000;
									}
							//}
							$ret="INSERT INTO reservation_tempon2 VALUES('$day','$numresch','$defalquer','NON')";
							$req=mysql_query($ret);
						//}
				//}
			}
		} */
/* 		$date_jour=date("Y-m-d");
		$heure=date('H:i');
		$or="SELECT * FROM reservation_tempon2";
		$or1=mysql_query($or);
		if($or1)
		{ while ($roi= mysqli_fetch_array($or1))
			{   $date=$roi['jour'];
				$d=substr($date,8,2);
				$m=substr($date,5,2);
				$y=substr($date,0,4);
			    $num_reserv=$roi['num_reserv'];
			    $defalquer=$roi['defalquer'];
				$Etat=$roi['Etat'];
			    $date_suivant=date("Y-m-d", mktime(0,0,0,$m,$d+1,$y));
				if($date!=$date_jour)
					{	if(($heure>'11:59')&&($date_jour==$date_suivant))
							{	if($Etat=='NON')
									{ 		$or="SELECT * FROM reservation_tempon WHERE num_reserv='$num_reserv'";
											$or1=mysql_query($or);$nbre=mysql_num_rows($or1);
											if($nbre<=0)
											{ $or1=mysqli_query($con,"SELECT avancerc FROM reservationch WHERE numresch='$num_reserv'");
												 while($roi= mysqli_fetch_array($or1))
												 {  $avancerc=(int)$avancerc=$roi['avancerc'];
													 if($avancerc>0)
													 { $ri=mysqli_query($con,"UPDATE reservationch SET avancerc=avancerc-'$defalquer' WHERE numresch='$num_reserv'");
													   $ri=mysqli_query($con,"UPDATE reserverch SET avancerc=avancerc-'$defalquer',nuite_payee=-1+nuite_payee WHERE numresch='$num_reserv'");
													   $ri=mysqli_query($con,"UPDATE reservation_tempon2 SET jour='$date_jour',Etat='OUI' WHERE num_reserv='$num_reserv'");
													 }
												 }
											}
									}
							}
					}
				}
		}
		 */
		if(!empty($_GET['numero'])) {
		$reqsel=mysqli_query($con,"SELECT * FROM client,fiche1,chambre,compte WHERE fiche1.numcli_1=client.numcli AND fiche1.numfiche=compte.numfiche AND compte.numch=chambre.numch AND compte.numfiche ='".$_GET['numero']."' ");
		while($data=mysqli_fetch_array($reqsel))
			{  $rlt_1=$data['numcli'];   $rlt_2=$data['nomcli'];  $rlt_3=$data['prenomcli'];  $rlt_4=$data['sexe'];  $rlt_5=$data['datnaiss'];  $rlt_6=$data['lieunaiss']; $rlt_8=$data['typepiece'];$Categorie=$data['Categorie'];
			   $rlt_9=$data['numiden'];  $rlt_10=$data['date_livrais'];  $rlt_11=$data['lieudeliv'];  $rlt_12=$data['institutiondeliv']; $rlt_13=$data['pays'];   $rlt_14=$data['adresse'];  $advance=-$data['due'];
			}
			  $numero=$_GET['numero'];
		}
	if (isset($_POST['ok'])&& $_POST['ok']=='VALIDER')
		{  	echo $_SESSION['advance']=$_POST['advance'];$_SESSION['numero']=trim($_POST['numero']);
		    $date1=$Jour_actuel ;  	//$date1=date("Y-m-d");;
			//echo $date2=substr($_POST['ladate'],0,4).'-'.substr($_POST['ladate'],5,2).'-'.substr($_POST['ladate'],5,2);
		  $date2=$_POST['ladate'];
			if($date1==$date2) $date2=date("Y-m-d", mktime(0, 0, 0,date($month),date($datej)+1,date($year)));
		//	echo "SELECT DATEDIFF('$date2','$date1') AS DiffDate";
			$exec=mysqli_query($con,"SELECT DATEDIFF('".$date2."','".$date1."') AS DiffDate");
			$row_Recordset1 = mysqli_fetch_assoc($exec);
			$row_Recordset=$row_Recordset1['DiffDate'];

			$heure=$Heureh;
			$jour=$datej;$mois=$month;$ans=$year; //$jour=date("d");$mois=date("m");$ans=date("Y");
			if(($heure>=00)&&($heure<07))
				{ //$_SESSION['Nprecedente']=1;
					$datarriv=date("Y-m-d", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
				}
			else
				$datarriv=addslashes($_POST['edit18']);

			//(date('H'));	//echo abs($row_Recordset);
			if(($row_Recordset>0)||(abs($row_Recordset)==0))
			//if(($row_Recordset>0)|| ((($heure>=00)&&($heure<=05))&&(abs($row_Recordset)==0)))
			{  $heure=$Heureh; //(date('H'));
				 $minuite=(date('i'));
			// if(($heure<=04)&&($minuite<59))
			// 	$_SESSION['Nuite']= $row_Recordset+1;
			// else
			// 	$_SESSION['Nuite']= $row_Recordset;
			if($row_Recordset==0)	$row_Recordset++;
			//if($_SESSION['Nuite']==0) $_SESSION['Nuite']=1;
			$_SESSION['Nuite']=$row_Recordset;

			$_SESSION['num']=$_POST['edit1']; $_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];  $_SESSION['Numclt']=$_POST['edit2'];


		//$datdep=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2)	;


		   if($_SESSION['Nuite']>$limite_jrs) {
			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{	//vérification d'unicité de numéro de fiche
					$Recordset1=mysqli_query($con,"SELECT * FROM fiche1 WHERE numfiche='".$_SESSION['num']."'");
					if (!$Recordset1)
					{   //$_SESSION['numerof']=addslashes($_POST['edit1']);
				//echo 123;
						mysqli_query($con,"SET NAMES 'utf8' ");
						//vérification de disponibilité de chambre
							$datdeliv=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];

							$etat='RAS';
							$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
							$p6=!empty($_POST['edit11'])?$_POST['edit11']:0;$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
							$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p18=addslashes($_POST['edit21']);
							if(($p1!='')AND($p2!='')AND($p3!='')AND($p4!='')AND($p5!='')AND($p7!='')AND($p8!='')AND($p9!='')AND($p10!='')AND($p11!='')AND($p12!='')AND($p17!='')AND($p18!='')AND($_POST['ladate']!='')){
							if ($req)
							{ header('location:occup.php');
							}
							}else {
									}
				    }
				}
				$_SESSION['edit1']=$_POST['edit1'];$_SESSION['edit2']=$_POST['edit2'];$_SESSION['edit3']=$_POST['edit3'];$_SESSION['edit4']=$_POST['edit4'];$_SESSION['edit6']=$_POST['edit6'];
				$_SESSION['edit7']=$_POST['edit7'];	$_SESSION['edit8']=$_POST['edit8'];$_SESSION['edit5']=$_POST['edit5'];$_SESSION['edit10']=$_POST['edit10'];	$_SESSION['combo2']=$_POST['combo2'];
				$_SESSION['edit9']=$_POST['edit9'];$_SESSION['edit11']=$_POST['edit11'];$_SESSION['edit12']=$_POST['edit12'];$_SESSION['edit_9']=$_POST['edit_9'];$_SESSION['edit_13']=$_POST['edit_13'];
				$_SESSION['edit_14']=$_POST['edit_14'];	$_SESSION['edit_15']=$_POST['edit_15'];	$_SESSION['edit_16']=$_POST['edit_16'];$_SESSION['edit17']=$_POST['edit17'];$_SESSION['edit18']=$_POST['edit18'];
				$_SESSION['rad']=$_POST['rad'];	$_SESSION['se4']=$_POST['se4'];$_SESSION['se5']=$_POST['se5'];$_SESSION['se6']=$_POST['se6'];$_SESSION['ladate2']=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
				$_SESSION['edit21']=$_POST['edit21'];$_SESSION['edit19']=$_POST['edit19'];
				header('location:avertissement.php?menuParent=Hébergement');
				}
		     else if ($_SESSION['Nuite']<= $limite_jrs)
			   {  if (empty($_POST['edit_03'])){
						$_SESSION['num']=$_POST['edit1'];
						$_SESSION['cli']=$_POST['edit3'].' '.$_POST['edit4'];

						$datdeliv=isset($_POST['se3'])?$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1']:NULL;
						$heure=(date('H')); $minuite=(date('i'));
						$jr=isset($_POST['edit18'])?substr($_POST['edit18'],8,2):NULL;
						$mois=isset($_POST['edit18'])?substr($_POST['edit18'],5,2):NULL;
						$ans=isset($_POST['edit18'])?substr($_POST['edit18'],0,4):NULL;
						//if(($heure<=04)&&($minuite<59))
						//$datarriv=date("Y/m/d", mktime(0,0,0,date($mois),date($jr)-1,date($ans)));
						//else
						//$datarriv=isset($_POST['edit18'])?$_POST['edit18']:NULL;
						$datdep=$_POST['ladate'];

						$etat='NON'; $_SESSION['re']=!empty($_SESSION['re'])?$_SESSION['re']:NULL;
						$p1=addslashes($_POST['edit1']);$p2=addslashes($_POST['edit2']);$p2=trim($p2);$p3=addslashes($_POST['combo2']);$p4=addslashes($_POST['edit9']);$p5=addslashes($_POST['edit10']);
						$p6=!empty($_POST['edit11'])?$_POST['edit11']:0;$p7=addslashes($_POST['edit12']);$p8=addslashes($_POST['edit_9']);$p9=addslashes($_POST['edit_13']);$p10=addslashes($_POST['edit_14']);
						$p11=addslashes($_POST['edit_15']);$p12=addslashes($_POST['edit_16']);$p17=addslashes($_POST['edit17']);$p18=addslashes($_POST['edit19']);$p1_8=addslashes($_POST['edit21']);

						if(isset($_GET['change']))
						{   $pre="SET numcli_1='$p2',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',provenance='$p18',destination='$p18',modetransport='".$_POST['rad']."' WHERE numfiche='".$p1."' ";
								echo "UPDATE fiche1 ".$pre;
								$update=mysqli_query($con,"UPDATE fiche1 ".$pre ); $update=mysqli_query($con,"UPDATE mensuel_fiche1 ".$pre );

						if ($update)
									{header('location:loccup.php?menuParent=Consultation');
									}
						}else

			if (isset($_SESSION['num']) && !empty($_SESSION['num']))
				{
			//vérification d'unicité de numéro de fiche
					if(empty($_SESSION['db']))
						{$Recordset1=mysqli_query($con,"SELECT * FROM fiche1 WHERE numfiche='".$_SESSION['num']."'"); $nbRq=mysqli_num_rows($Recordset1);}
					else $nbRq=0;
					if ($nbRq<=0)
					{ 	mysqli_query($con,"SET NAMES 'utf8' ");
						//vérification de disponibilité de chambre

							$Query=mysqli_query($con,"SELECT * FROM fiche1 WHERE numfiche='".$p1."'");
							 if( mysqli_num_rows($Query)<=0){


							if(($p1!='')AND($p2!='')AND($p3!='')AND($p4!='')AND($p5!='')AND($p7!='')AND($p8!='')AND($p9!='')AND($p10!='')AND($p11!='')AND($p12!='')AND($p17!='')AND($p18!='')AND($_POST['ladate']!=''))
							{
								if(isset($_FILES['cpi']))
								$fichier=mysqli_real_escape_string($con,htmlentities($_FILES['cpi']['name']));

						 	$Query1=mysqli_query($con,"SELECT MAX(Periode) AS Periode FROM fiche1 WHERE numcli_1='".$p2."' AND codegrpe=''");
							$data1=mysqli_fetch_object($Query1); $data1->Periode;
							$periode=isset($data1->Periode)?(1+$data1->Periode):1;							
							
							$ret="INSERT INTO fiche1 VALUES('$p1','','$p2','$p2','".$periode."','','$p3','$p4','$p5','$p6','$p17','".$datarriv."','".$datarriv."','$p18','$datdep','$datdep','$Heure_actuelle','$p1_8','".$_POST['rad']."','".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')";
								$req=mysqli_query($con,$ret);
								if ($req)
									{
										$req2=mysqli_query($con,"INSERT INTO mensuel_fiche1 VALUES('$p1','','$p2','$p2','".$periode."','','$p3','$p4','$p5','$p6','$p17','".$datarriv."','".$datarriv."','$p18','$datdep','$datdep','$Heure_actuelle','$p1_8','".$_POST['rad']."','".$etat."','".$_SESSION['re']."','','".$_SESSION['login']."','".$_SESSION['login']."','".$_SESSION['Nuite']."','NON')");
										$update=mysqli_query($con,"UPDATE configuration_facture SET num_fiche=num_fiche+1 ");
										$update=mysqli_query($con,"UPDATE client SET Categorie='".$Categorie."'  WHERE numcli='".$p2."'");

												 	//Pour l'insertion de la copie scannée de la piece
												  //	$taille_max = 250000;
													//if(isset($_FILES['cpi'])) {
														//$img_taille = $_FILES['cpi']['size'];
														/*
														if ($img_taille > $taille_max) {
															echo "Trop gros !";
															return false;
														}else{  */
															//$img_blob = file_get_contents ($_FILES['cpi']['tmp_name']);
															//echo $req="INSERT INTO images(img_id,numfiche,img_blob) VALUES(NULL,'".$_POST['edit1']."','".addslashes($img_blob)."') ";
															 $req = "UPDATE images SET numfiche='".$_POST['edit1']."',numcli='".$p2."' WHERE  numfiche=''";
															$ret = mysqli_query ($con,$req) or die (mysqli_error ($con)); $numreserv=isset($_POST['numreserv'])?$_POST['numreserv']:NULL; 
															$avance=$_POST['edit30']; 
													  //}

													//}
													header('location:occup.php?menuParent=Hébergement&numfiche='.$p1.'&avance='.$avance);
										}
									}
								}
									else{  //Ici, on insère le second occupant de la chambre
									$ret="UPDATE fiche1 SET numfiche='$p1',numfichegrpe='0',numcli_2='$p2',codegrpe='',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',datarriv='".$datarriv."',provenance='$p18',datdep='$datdep',datsortie='$datdep',destination='$p18',modetransport='".$_POST['rad']."',numresch='".$_SESSION['re']."',numfact='',agenten='".$_SESSION['login']."',agentmo='".$_SESSION['login']."',nuite='".$_SESSION['Nuite']."' WHERE numfiche='$p1'";
									$req=mysqli_query($con,$ret);
									$rek = "UPDATE images SET numfiche='".$_POST['edit1']."',numcli='".$p2."' WHERE  numfiche=''";
									$re = mysqli_query ($con,$rek) or die (mysqli_error ($con));
									if ($req)
									{ $reqA=mysqli_query($con,"UPDATE mensuel_fiche1 SET numfiche='$p1',numfichegrpe='0',numcli_2='$p2',codegrpe='',etatcivil='$p3',profession='$p4',domicile='$p5',nbenfant='$p6',motifsejoiur='$p17',datarriv='".$datarriv."',provenance='$p18',datdep='$datdep',datsortie='$datdep',destination='$p18',modetransport='".$_POST['rad']."',numresch='".$_SESSION['re']."',numfact='',agenten='".$_SESSION['login']."',agentmo='".$_SESSION['login']."',nuite='".$_SESSION['Nuite']."' WHERE numfiche='$p1'");
									if($_SESSION['somme']<=0)
										{unset($_SESSION['db']);
										 header('location:fiche.php?menuParent=Hébergement');
										}
									else
										{	if(isset($_SESSION['invoice'])&& ($_SESSION['invoice']==1))
												{	$_SESSION['state']=1;
													echo "<iframe src='checkingOK.php?state=1";  echo "' width='1000' height='800' style='margin-left:15%;'></iframe>";
												}
											else if(isset($_SESSION['invoice'])&& ($_SESSION['invoice']==2))
												{	$_SESSION['state']=1;
													echo "<iframe src='checkingOK.php?state=1";  echo "' width='1000' height='800' style='margin-left:15%;'></iframe>";
												}
											else {  $_SESSION['state']=1;
													//header('location:recufiche.php?menuParent=Hébergement');
													$_SESSION['nature'] = 'Hébergement';
													echo "<iframe src='receiptH.php";  echo "' width='600' height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:30%;margin-top:-25px;'></iframe>";
											}
										}
									}
							}

						}else {}







					}
                 }     else	{  $_SESSION['avance_03']=$_POST['edit_03'];
				           header('location:occup_03.php?menuParent=Hébergement');}
					//header('location:warning_date.php?menuParent=Hébergement');
				}
			   else	echo "<script language='javascript'>alert('La date de départ doit être supérieure à la date du jour'); </script>";

	}
}

$idr  = isset($_POST['s1'])?$_POST['s1']:NULL; 
$idr  = isset($_GET['idr'])?$_GET['idr']:$idr; 
if(isset($idr))
{	$sql="SELECT * FROM reservationch WHERE numresch LIKE '".$idr."'";
	$req = mysqli_query($con,$sql) or die (mysqli_error($con));
	$dataT=mysqli_fetch_object($req);  //echo $dataT->nomdemch;    //prenomdemch  contactdemch  codegrpe  avancerc
	
	echo "<script language='javascript'>";
	if(!isset($_GET['idr']))
		echo 'alertify.success("Veuillez Cliquer sur le lien Informations Complémentaires ! pour complèter les informations liées au client");';
	echo "</script>";
}
?>

<html>
	<head>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<style>
		.alertify-log-custom {
				background: blue;
			}
				td {
				  padding: 8px 0;
				}
	
		/* Big box with list of options */
			#ajax_listOfOptions
			{
				position:absolute;	/* Never change this one */
				width:250px;	/* Width of box */
				height:100px;	/* Height of box */
				overflow:auto;	/* Scrolling features */
				border:1px solid #317082;	/* Dark green border */
				background-color:#FFF;	/* White background color */
				text-align:left;
				font-size:1.1em;
				z-index:100;
			}
			#ajax_listOfOptions div
			{	/* General rule for both .optionDiv and .optionDivSelected */
				margin:1px;
				padding:1px;
				cursor:pointer;
				font-size:0.9em;
			}
			#ajax_listOfOptions .optionDiv
			{	/* Div for each item in list */

			}
			#ajax_listOfOptions .optionDivSelected
			{ /* Selected item in the list */
				background-color:#317082;
				color:#FFF;
			}
			/*#ajax_listOfOptions_iframe
			{
				background-color:#F00;
				position:absolute;
				z-index:5;
			}*/

			form
			{
				display:inline;
			}
			input, select
			{
				/*border:1px solid; */
			}

			.bouton:hover
			{
				cursor:pointer;
			}

			.alertify-log-custom {
				background: blue;
			}
			
		<?php
		if(!empty($_GET['zoom']))
			echo "
			select, input[type=text]{
			 font-family:cambria;
			}";
		if(isset($_SESSION['db'])) {
		?>
			td {
			  padding: 3px 0;
			}
		<?php
		}else {
		?>
			td {
			  padding: 2px 0;
			}
		<?php
		}
		?>
		</style>
	</head>
	<body style='background-color:#84CECC;'>
	<div align="" style="<?php if(empty($_SESSION['db'])) { echo "margin-top:-25px;";} else { echo "margin-top:25px;";}  ?>">
	<form action='fiche.php?menuParent=Hébergement<?php if(isset($_GET['numcli'])) echo "&numcli=".$_GET['numcli'];else if(!empty($_SESSION['numcli'])) echo "&numcli=".$_SESSION['numcli']; else { }  if(isset($_GET['change'])) echo "&change=".$_GET['change']; if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($_GET['idr'])) echo "&idr=".$_GET['idr']; //echo getURI();	?>' method='post' name='fiche' id='form1' enctype='multipart/form-data'>
	<?php if(isset($_SESSION['state'])) {
	}
	else
	{ //unset($_SESSION['state']);
	?>
		<table align='center'  id="tab" >
			<?php //if(empty($_SESSION['db']))
					//include('ReservEncours.php');
						//if(isset($_GET['numreserv'])){
							if(isset($dataT->nomdemch)){
							//if(isset($_SESSION['numreserv'])){
							echo "<tr>
								<td><fieldset style='border:1px solid white;font-family:Cambria;padding:10px;'><legend align='center' style='color:#046380;font-size:110%;'><b>RESERVATION DE CHAMBRE(S) EN COURS </b> </legend>
								<table align='center'>";
								$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$idr."'");
								$ret=mysqli_fetch_assoc($res);
								$numfiche_1=$ret['numfiche'];
							/* 	    if(empty($idr))
									{ $or="SELECT distinct reserverch.nuite_payee,reserverch.ttc,reservationch.numresch,reservationch.nomdemch,reservationch.nuiterc AS nuiterc,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$idr."'";
									 $or1=mysqli_query($con,$or);
									 if(empty($numfiche_1))
										$sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,ttc AS ttc FROM reserverch WHERE numresch='".$idr."'");
									 else
									 	 $sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,tarifrc AS ttc FROM reserverch WHERE numresch='".$idr."'");
									 }
									else
									{	if(empty($numfiche_1))
										$or="SELECT distinct reserverch.nuite_payee,reserverch.ttc,reserverch.avancerc,reservationch.numresch,reservationch.nuiterc,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$idr."'";
										else
										$or="SELECT distinct reserverch.nuite_payee,reserverch.tarifrc AS ttc,reserverch.avancerc,reservationch.numresch,reservationch.nuiterc,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$idr."'";$or1=mysqli_query($con,$or);
										$sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,ttc AS ttc,reserverch.avancerc FROM reserverch WHERE numresch='".$idr."'");
									} */

									//if(!empty($idr))
									{	$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$idr."'");
										$ret=mysqli_fetch_assoc($res);
										 $numfiche_1=$ret['numfiche'];
										  $or="SELECT distinct reserverch.nuite_payee,reservationch.nuiterc,reserverch.ttc,reservationch.numresch,reservationch.nomdemch,reservationch.prenomdemch,reservationch.contactdemch,reservationch.numch,reservationch.datdepch,reservationch.avancerc,reservationch.montantrc FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$idr."'";
										 $or1=mysqli_query($con,$or);
										 
										 $sql=mysqli_query($con,"SELECT DISTINCT nuite_payee,reserverch.avancerc,ttc AS ttc FROM reserverch WHERE numresch='".$idr."'");
									 }

									if (isset($or1))
									{while ($roi= mysqli_fetch_array($or1))
										{	$numresch=$roi['numresch'];	$nom=$roi['nomdemch'];$prenoms=$roi['prenomdemch'];$contact=$roi['contactdemch'];$numch=$roi['numch'];
											$date_depart=substr($roi['datdepch'],8,2).'-'.substr($roi['datdepch'],5,2).'-'.substr($roi['datdepch'],0,4);//$date_depart=!empty($date_depart)?$date_depart:NULL;
											$avance=$roi['avancerc'];$nuiterc=$roi['nuiterc'];$nuite_payee=(int)$roi['nuite_payee']; //$nuite_payee=!empty($nuite_payee)?$nuite_payee:0;
										}

										$somme_avance=array("");$somme_montant=array("");$i=0;$somme_tva=array("");
										while($result= mysqli_fetch_array($sql))
										{if(empty($numfiche_1))
											{$somme_avance[$i]=$result['ttc']*$result['nuite_payee']; $somme_montant[$i]=$result['ttc'];}
										  else
											{$somme_avance[$i]=$result['avancerc']*$result['nuite_payee'];
										     $somme_montant[$i]=$result['ttc']*$result['nuite_payee'];
											 $somme_tva[$i]=$result['ttc']*$result['nuite_payee']*$TvaD;
											}
										 $i++;
										}
										//$avance=array_sum($somme_avance);
										 $montantrc=array_sum($somme_montant);	$somme_tva=array_sum($somme_tva);
										//if(empty($numfiche_1)) $somme_due=$montantrc-$avance; else if(!empty($avance)) $somme_due=0;
									}
								if(empty($numresch))
									$orA="SELECT DISTINCT SUM(reserverch.avancerc)/SUM(reserverch.mtrc) AS nuite FROM reserverch,reservationch where reservationch.numresch=reserverch.numresch AND reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$idr."'";
									else
									$orA="SELECT DISTINCT SUM(reserverch.avancerc)/SUM(reserverch.mtrc) AS nuite FROM reserverch,reservationch where reservationch.numresch=reserverch.numresch AND reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch='".$idr."'";
									$orB=mysqli_query($con,$orA);
									if ($orB)
									{
										while ($roiB= mysqli_fetch_array($orB))
										{
                          $nuite=(int)$roiB['nuite'];
										}
									}
								echo "<tr>
									<td> &nbsp;&nbsp;&nbsp;&nbsp;N° de la r&eacute;servation : &nbsp;&nbsp;</td>
									<td>
										<input type='text' name='numreserv' id='' readonly value='"; if(isset($idr)) echo $idr; else echo $_SESSION['numreserv']; echo" '>";

									echo "</td>
							
									<td>  &nbsp;&nbsp;&nbsp;&nbsp;Montant TTC : &nbsp;&nbsp;</td>
									 <td> <input type='text' name='edit26' id='edit26' readonly value='".$montantrc."' /> </td>
									<td> &nbsp;&nbsp;&nbsp;Avance Remise : &nbsp;&nbsp;</td>
									<td> <input type='text' name='edit30' id='edit30' readonly value='"; echo $avance; echo "'/> </td>
							</tr>
								<tr><td>&nbsp;</td></tr>
							</table></fieldset></td></tr>";	//}
						}else if (isset($_GET['change'])){
							//echo 12;
						}

						else {if(empty($_SESSION['db'])) include('ReservEncours.php'); }
			?>
			<tr>
				<td>
					<fieldset style='border:0px solid white;font-family:Cambria; <!-- padding:10px; !--> '>
						<legend align='' style='color:#046380;font-size:110%;'><b>
							<?php
							if (isset($_GET['change']))
								$titre="CHANGEMENT DU NOM DE L'OCCUPANT DE LA CHAMBRE";
							else
								$titre="FICHE DE RENSEIGNEMENT";
								echo $titre;
							?>
						</b> </legend>
							<table style=''>
								<tr>
									<td width=''> Numéro de Fiche :  &nbsp;<input type='text' name='edit1' readonly value="<?php
/* 									if($etat_facture=='AA')
									{   $chaine1 = substr(random($Nbre_char,''),0,3);
										$chaine2 = substr(random($Nbre_char,''),5,3);
										$year=(substr(date('Y'),3,1)+substr(date('Y'),2,1))-5;
										echo $chaine = $initial_fiche.$year.$chaine1.$chaine2;
									}
									if(($etat_facture=='AI'))
									{ */
								if((isset($_GET['change']))	&& (isset($_GET['numfiche'])))
										echo $_GET['numfiche'];
								else if(!empty($_SESSION['db'])) {
										if(isset($_SESSION['num']))
											echo $_SESSION['num'];
								}else{
										echo $Num_fiche ;
									}
									?>"  style='width:150px;'/> </td>
						            <td style=''>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php //if(!isset($dataT->nomdemch)) 
									{?>
									 	<span style="font-size:0.9em;color:black;"><a class='info' href='selection_client.php?menuParent=Hébergement&fiche=1<?php if(isset($dataT->nomdemch)) echo "&idr=".$dataT->numresch; if(!empty($numero)) echo "&numero=".$numero; if(isset($_GET['invoice'])) echo "&invoice=".$_GET['invoice']; if(isset($_GET['change'])) echo "&change=".$_GET['change'];  if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($_GET['sal'])) echo "&sal=".$_GET['sal'];?>' style='text-decoration:none;color:#d10808;font-size:1.1em;font-weight:bold;'>Rechercher
										<img src="logo/b_search.png" alt="" width='22' title=''/><span style='font-size:0.9em;color:maroon;'>Rechercher Client</span></span> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span style="font-size:0.9em;color:black;">
									<?php } ?>
										<a class='info' href='
									<?php	echo "client.php?menuParent=Hébergement&etat=1&fiche=1";  if(isset($dataT->nomdemch)) echo "&cham=1"; if(isset($_GET['invoice'])) echo "&invoice=".$_GET['invoice']; if(isset($dataT->nomdemch)) echo "&reservation=".$dataT->numresch; //if(isset($idr)) echo "&idr=".$idr."&name=".$dataT->nomdemch."&surname=".$dataT->prenomdemch."&address=".$dataT->contactdemch;?>
										'style='text-decoration:none;color:#d10808;font-size:1.1em;font-weight:bold;'><?php if(isset($dataT->nomdemch)) echo "Informations Complémentaires "; else echo "Nouveau";?>
										<img src="logo/edit.png" alt="" title=''/><span style='font-size:0.9em;color:maroon;'><?php if(isset($dataT->nomdemch)) echo "Complément info !"; else echo "Nouveau Client";?></span></span></a>
									<?php
									//echo "Pour une arriv&eacute;e en groupe, <a href='fiche_groupe.php?etat_1=1' style='text-decoration:none;font-weight:bold;'>Cliquez ici</a>";
									if((!empty($_GET['numcli']))||(!empty($_SESSION['numcli'])))
											{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
												include ('others/categorie.php');
											}
										//else
											//echo "&nbsp;&nbsp;&nbsp;&nbsp;Pour consulter les notifications, <a href='notification.php' style='text-decoration:none;font-weight:bold;'>Cliquez ici</a>";

										$etat_2=!empty($etat_2)?$etat_2:NULL; $etat1=!empty($etat1)?$etat1:NULL; $etat2=!empty($etat2)?$etat2:NULL; $rlt_2=!empty($rlt_2)?$rlt_2:NULL;  $rlt_3=!empty($rlt_3)?$rlt_3:NULL;
										$edit2=!empty($edit2)?$edit2:NULL; $edit3=!empty($edit3)?$edit3:NULL; $edit4=!empty($edit4)?$edit4:NULL; $edit5=!empty($edit5)?$edit5:NULL; $edit6=!empty($edit6)?$edit6:NULL; $edit7=!empty($edit7)?$edit7:NULL;
										$edit8=!empty($edit8)?$edit8:NULL; $edit10=!empty($edit10)?$edit10:NULL;  $edit12=!empty($edit12)?$edit12:NULL;$edit13=!empty($edit13)?$edit13:NULL; $edit14=!empty($edit14)?$edit14:NULL; $edit15=!empty($edit15)?$edit15:NULL;
										$edit16=!empty($edit16)?$edit16:NULL; $edit17=!empty($edit17)?$edit17:NULL; $edit18=!empty($edit18)?$edit18:NULL;  $edit19=!empty($edit19)?$edit19:NULL;  $edit20=!empty($edit20)?$edit20:NULL; $edit_13=!empty($edit_13)?$edit_13:NULL;
										$edit_14=!empty($edit_14)?$edit_14:NULL; $edit21=!empty($edit21)?$edit21:NULL;$edit_15=!empty($edit_15)?$edit_15:NULL;
									?></td>
									<td>
								</tr>

							</table>
							<table>
								<tr>
									<td>
										<fieldset style='border:2px solid white;'>
											<?php
												if(empty($_SESSION['db']))
													echo "<legend align='' style='color:#046380;font-size:110%;'><b> INFORMATIONS SUR L'IDENTITE DU CLIENT</b></legend>";
												else
													echo "<legend align='' style='color:#046380;font-size:110%;'><b> <br/>INFORMATIONS SUR L'IDENTITE DU <span style='color:#DA4E39;'>SECOND OCCUPANT</span> DE LA CHAMBRE</b></legend> ";
											?>
											<table style=''>
												<tr>
													<td> Numéro du Client : </td>
														<input type='hidden' name='advance' id='advance'   value=" <?php if(!empty($advance)) echo $advance; ?>"  >
														<input type='hidden' name='numero' id='numero' value=" <?php if(!empty($numero)) echo $numero; ?>" />
													<td> <input type='text' name='edit2' id='edit2' readonly style='<?php if($etat_2==1)echo"background-color:#FDF1B8;";?>' readonly value=" <?php if(!empty($rlt_1)) echo $rlt_1; if(!empty($_GET['numcli'])) echo $rlt1; if($etat_2!=1) echo $edit2; if(!empty($_SESSION['numcli'])) echo $_SESSION['numcli'];  ?>" required />  </td>
													<td> &nbsp;&nbsp;&nbsp;Nom : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<span style="font-size:0.9em;"><a class='info2' id='info' href='fiche.php?fiche=1&<?php if(!empty($numero)) echo "numero=".$numero; ?>' style='text-decoration:none;'>
													<!-- <input id='file' type='file' accept='image/*' name='cpi' onchange="document.forms['form1'].submit();">
													<a class='info2' id='info' href='fiche.php?menuParent=Hébergement&<?php if(!empty($numero)) echo "numero=".$numero; ?>' style='text-decoration:none;'>
													<span style='font-size:0.9em;color:maroon;'> JOINDRE UNE COPIE DE LA PIECE D'IDENTITE</span>
													<label for="file" id="label-file"><i class="fas fa-id-card" style='font-size:1.8em;<?=$style; ?>' ></i></label></a> !-->
												<?php
												include 'others/cni.php';
												?>
												</td>
													<td> <input type='text' name='edit3' id='edit3' style='<?php if($etat1==1)echo"background-color:#FDF1B8;";?>'readonly value=" <?php if($rlt_2!='') echo $rlt_2; if(!empty($_GET['numcli'])) echo $rlt2; if($etat1!=1) echo $edit3; if(!empty($_SESSION['numcli'])) echo $_SESSION['nomcli'];  ?>" /> </td>

													<input type='hidden' name='edit_03' id='edit_03' readonly />
													<td> &nbsp;&nbsp;&nbsp;Pr&eacute;noms : </td>
													<td> <input type='text' name='edit4'id='edit4' style='<?php if($etat2==1)echo"background-color:#FDF1B8;";?>' readonly value=" <?php if($rlt_3!='') echo $rlt_3; if(!empty($_GET['numcli'])) echo $rlt3;  if($etat2!=1) echo $edit4; if(!empty($_SESSION['numcli'])) echo $_SESSION['prenomcli']; ?>" /> </td>
												</tr>

												<tr>
													<td> Date de naissance : </td>
													<td> <input type='text' name='edit6' id='edit6' readonly value=" <?php if(!empty($rlt_5)) echo $rlt_5; if(!empty($_GET['numcli'])) echo $rlt5; if(!empty($etat6) && $etat6 !=1) echo $edit6;  if(!empty($_SESSION['numcli'])) echo substr($_SESSION['datenais'],8,2)."-".substr($_SESSION['datenais'],5,2)."-".substr($_SESSION['datenais'],0,4);  ?>"/> </td>
													<td> &nbsp;&nbsp;&nbsp;Lieu de naissance : </td>
													<td> <input type='text' name='edit7' id='edit7' readonly value=" <?php if(!empty($rlt_6)) echo $rlt_6; if(!empty($_GET['numcli'])) echo $rlt6; if(!empty($etat7) && $etat7!=1) echo $edit7;  if(!empty($_SESSION['numcli'])) echo $_SESSION['lieu'];   ?>"/> </td>

													<td> &nbsp;&nbsp;&nbsp;Pays d'origine: </td>
													<td> <input type='text' name='edit8' id='edit8' readonly value=" <?php if(!empty($rlt_13)) echo $rlt_13; if(!empty($_GET['numcli'])) echo $rlt13;if(!empty($etat8) && $etat8!=1) echo $edit8;  if(!empty($_SESSION['numcli'])) echo $_SESSION['pays'];  ?>"/> </td>
												</tr>
												<tr>
													<td> Sexe : </td>
													<td> <input type='text' name='edit5' id='edit5' readonly value=" <?php if(!empty($rlt_4)) echo $rlt_4; if(!empty($_GET['numcli'])) echo $rlt4;  if(!empty($etat5) && $etat5!=1) echo $edit5; if(!empty($_SESSION['numcli'])) echo $_SESSION['sexe'];  ?>"/> </td>
													<td> &nbsp;&nbsp;&nbsp;Etat-civil : </td>
													<td>
														<select name='combo2' required style='<?php if(!empty($etat11) && $etat11==1)echo"background-color:#FDF1B8;";?>'>
															<option value='<?php if(isset($combo2) && !empty($combo2)) echo $combo2;   else echo "";?>'>  <?php echo $combo2; ?></option>
															<option value='Célibataire'>Célibataire</option>
															<option value=''></option>
															<option value='Marié'>Marié</option>
														</select>
													</td>
													<td> &nbsp;&nbsp;&nbsp;Profession : </td>
													<td>
														<select name='edit9' required style='<?php if(!empty($etat12) && $etat12==1)echo"background-color:#FDF1B8;";?>'>
															<option value='<?php if(!empty($edit9)) echo $edit9;  ?>'> <?php echo $edit9;  ?></option>
															<option value='Libérale'>Libérale</option>
															<option value=''></option>
															<option value='Ouvrier'>Ouvrier</option>
															<option value=''></option>
															<option value='Employé'>Employé</option>
															<option value=''></option>
															<option value='Cadre'>Cadre</option>
															<option value=''></option>
															<option value='Inactif'>Inactif</option>
															<option value=''></option>
															<option value='Divers'>Divers</option>
														</select>
													</td>
												</tr>
												<tr>
													<td> Domicile habituel : </td>
													<td> <input required type='text' name='edit10'onkeyup='this.value=this.value.toUpperCase()' style='<?php $etat10=(!empty($etat10)&&($etat10==1))?$etat10:NULL;  //echo"background-color:#FDF1B8;";?>' value="<?php if($etat10!=1) echo $edit10;  ?>" /> </td>
													<td> &nbsp;&nbsp;&nbsp;Nombre d'enfant(s) de moins de 15 ans accompagnant(s) : </td>
													<td> <input type='text' name='edit11' placeholder='0' style='<?php   $etat13=(!empty($etat13)&&($etat13==1))?$etat13:NULL; //echo"background-color:#FDF1B8;";?>'  onkeypress="testChiffres(event);"/> </td>
															<td>&nbsp;&nbsp;&nbsp; Contact : </td>
													<td> <input type='text' name='edit12'style='<?php $etat14=(!empty($etat14)&&($etat14==1))?$etat14:NULL; //echo"background-color:#FDF1B8;";?>' value="<?php if(!empty($rlt_14)) echo $rlt_14; if(!empty($_GET['numcli'])) echo $rlt14;if($etat14!=1) echo $edit12; if(!empty($_SESSION['numcli'])) echo $_SESSION['contact'];  ?>" onkeypress="testChiffres(event);"/> </td>
												</tr>

											</table>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td>
										<fieldset style='border:2px solid white;font-family:Cambria;'>
											<legend style='color:#046380;font-size:110%;'><b> TYPE DE PIECE D'IDENTITE </b></legend>
											<table style=''>
												<tr>
													<td> Type de pièce :&nbsp; </td>
													<td> <input type='text' name='edit_9'  id='edit_9' size='25' readonly value=" <?php if(!empty($rlt_8)) echo $rlt_8; if(!empty($_GET['numcli'])) echo strtoupper($rlt8);if(!empty($etat15) && $etat15!=1) echo $edit_9; if(!empty($_SESSION['numcli'])) echo $_SESSION['piece']; ?>" />  </td>
													<td> &nbsp;&nbsp;&nbsp;Numéro de pièce :&nbsp; </td>
													<td> <input type='text' name='edit_13'   id='edit_13' size='25' readonly value=" <?php  if(!empty($rlt_9)) echo $rlt_9; if(!empty($_GET['numcli'])) echo $rlt9;if(!empty($etat16) && $etat16!=1) echo $edit_13; if(!empty($_SESSION['numcli'])) echo $_SESSION['numpiece'];  ?>" /> </td>
													<td> &nbsp;&nbsp;&nbsp;Délivrée le :&nbsp; </td>
													<td> <input type='text' name='edit_14'  id='edit_14' size='25' readonly value=" <?php if(!empty($rlt_10)) echo $rlt_10; if(!empty($_GET['numcli'])) echo $rlt10;if(!empty($etat17) && $etat17!=1) echo $edit_14; if(!empty($_SESSION['numcli'])) echo $_SESSION['le']; ?>" /> </td>
												</tr>

												<tr>
													<td> à : </td>
													<td> <input type='text' name='edit_15'    id='edit_15' size='25' readonly value=" <?php if(!empty($rlt_11))  echo $rlt_11; if(!empty($_GET['numcli'])) echo $rlt11;if(!empty($etat18) && $etat18!=1) echo $edit_15; if(!empty($_SESSION['numcli'])) echo $_SESSION['a']; ?>" onKeyup="ucfirst(this)"/> </td>
													<td> &nbsp;&nbsp;&nbsp;Par : </td>
													<td> <input type='text' name='edit_16'   id='edit_16' size='25' readonly value=" <?php  if(!empty($rlt_12)) echo $rlt_12; if(!empty($_GET['numcli'])) echo $rlt12;if(!empty($etat19) && $etat19!=1) echo $edit_16; if(!empty($_SESSION['numcli'])) echo $_SESSION['par'];  ?>" onKeyup="ucfirst(this)"/> </td>
													<td> <input type='hidden' name='edit18' id='edit18' value="<?php echo $Jour_actuel; //date('Y-m-d') ?>" readonly /> </td>
												</tr>
											</table>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td>
										<fieldset style='border:2px solid white;font-family:Cambria;'>
											<legend style='color:#046380;font-size:110%;'><b>INFORMATIONS SUR LE SEJOUR </b></legend>
											<table style=''>
												<tr>
													<td> Motif du Séjour : </td>
													<td colspan=''>

														<select required name='edit17'style='<?php $etat20=(!empty($etat20)&&($etat20==1))?$etat20:NULL; //echo"background-color:#FDF1B8;";?>'>
															<option value='<?php if(!empty($edit17)) echo $edit17;?>'> <?php echo $edit17;?></option>
															<option value='Vacances/Loisirs'>Vacances/Loisirs</option>
															<option value=''></option>
															<option value='Affaires'>Affaires</option>
															<option value=''></option>
															<option value='Parents et Amis'>Parents et Amis </option>
															<option value=''></option>
															<option value='Professionnel'>Professionnel</option>
															<option value=''></option>
															<option value='Autre'>Autre but</option>
														</select>
													</td>
												    <td> &nbsp;&nbsp;&nbsp;Date d'arrivée : &nbsp;</td>
													<td> <input type='text' name='edit_2' id='edit_2' value="<?php if(isset($rltN)) echo $rltN; else
													echo $Date_actuel2; ?>" readonly /> </td>
													<td> &nbsp;&nbsp;&nbsp;Venant de : </td>
													<td> <input required type='text' name='edit19' onkeyup='this.value=this.value.toUpperCase()'  style='<?php $etat1_40=(!empty($etat1_40)&&($etat1_40==1))?$etat1_40:NULL; //echo"background-color:#FDF1B8;";?>' value="<?php if($etat1_40!=1) echo $edit21; ?>"/> </td>
												</tr>

												<tr>
													<td> Date de sortie : </td>
												  <td style=" border: 0px solid black;"><input required type="date" name="ladate" id="ladate" size="20"  style='<?php $etat1_4=(!empty($etat1_4)&&($etat1_4==1))?$etat1_4:NULL; ?>' value="<?php if($etat1_4!=1) if(!empty($ladate)) echo $ladate; ?>" />
													   <!--<a class='info'  href="javascript:show_calendar('fiche.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
														 <img src="logo/cal.gif" style="border:1px solid yellow;" alt="Calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a> !-->
												  </td>
													<input type='hidden' name='nui' id='nui'/>
													<td> &nbsp;&nbsp;&nbsp;Allant à : </td>
													<td> <input required type='text' name='edit21' id='edit21' onblur="ucfirst(this);" onkeyup='this.value=this.value.toUpperCase()' style='<?php if($etat1_40==1)echo"background-color:#FDF1B8;";?>' value="<?php $etat1_40=(!empty($etat1_40)&&($etat1_40!=1))?$etat1_40:NULL; echo $edit21; ?>"/> </td>
													<td> &nbsp;&nbsp;&nbsp;Mode de transport : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" id="button_checkbox_1"  onClick="verifyCheckBoxes1();" value='air' name='rad'><label for="button_checkbox_1" >A&eacute;rien	</label></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='checkbox'  id="button_checkbox_2"  onClick="verifyCheckBoxes2();" value='mer' name='rad'><label for="button_checkbox_2">Maritime</label></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type='checkbox'  id="button_checkbox_3"  onClick="verifyCheckBoxes3();" value='terre' name='rad' checked="checked" ><label for="button_checkbox_3">Terrestre</label></td>

												</tr>
											</table>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td align='center'> <br/><input type='submit' name='ok' class='bouton2' value='VALIDER' style=''/></td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
		</table>
		<?php if(!empty($msg_1)) echo $msg_1;
		$_SESSION['numcli']='';	$_SESSION['nomcli']='';	$_SESSION['prenomcli']='';$_SESSION['ladate']='';$_SESSION['lieu']='';$_SESSION['pays']='';$_SESSION['sexe']='';
		$_SESSION['piece']='';  $_SESSION['numpiece']='';$_SESSION['le']='';$_SESSION['a']='';$_SESSION['par']='';$_SESSION['contact']='';

		$test = "DELETE FROM chambre_tempon";
		$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));

		$test = "DELETE FROM avance_tempon";
		$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));

/* 		$test = "DELETE FROM encaissement WHERE encaissement.ttc_fixe=0";
		$reqsup = mysql_query($test) or die(mysql_error()); */

/* 		$test = "DELETE FROM fiche2 WHERE fiche2.numcli_2=''";
		$reqsup = mysql_query($test) or die(mysql_error()); */


/* 		$sql3=mysqli_query($con,"SELECT num_encaisse,ttc_fixe,tarif FROM encaissement"); // A effacer après tout reajustement
		while($row_1=mysqli_fetch_array($sql3))
		{  $num_encaisse= $row_1['num_encaisse'];$ttc_fixe= $row_1['ttc_fixe'];
				if($ttc_fixe==12000)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='9322.0339'	 WHERE num_encaisse='".$num_encaisse."'");
				if($ttc_fixe==14000)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='10169.4916' WHERE num_encaisse='".$num_encaisse."'");
				if($ttc_fixe==7500)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='5508.4746'	 WHERE num_encaisse='".$num_encaisse."'");
				if($ttc_fixe==9500)
					$req=mysqli_query($con,"UPDATE encaissement SET tarif='6355.9323'	 WHERE num_encaisse='".$num_encaisse."'");
		} */
		?>
		<!-- <table align='center'style='margin-top:80px;'>
			<tr>
				<td style='color:#76A2AC;'><i><u>Attention</u>: Pour les reservations en cours, le système opère une défalcation automatique de l'avance quand le client ne se présente pas.</i> </td>
			</tr>
		</table> !-->
	</div> <?php } ?>
	</body>
	<script type="text/javascript">

	    function capitalizeFLetter() {
          var input = document.getElementById("input");
          var x = document.getElementById("div");
          var string = input.value;
          x.innerHTML = string[0].toUpperCase() +
            string.slice(1);
        }


		function ucfirst(string)
		{

return string.charAt(0).toUpperCase() + string.slice(1);

		}

	var = document.getElementById("file").value;
	if(!empty(var)){alert('Un champ est vide');
	document.getElementById('hidden').style.visibility='hidden';
	}

		function VerifForm()
		{
			if ((document.form1.edit1.value=='')|| (document.form1.edit2.value=='')||(document.form1.edit3.value=='')||(document.form1.edit4.value=='')||(document.form5.edit1.value=='')||(document.form1.edit6.value=='')||(document.form1.edit7.value=='')||(document.form1.edit8.value=='')||(document.form1.combo1.value=='Default')||(document.form1.combo2.value=='Default')||(document.form1.edit9.value=='')||(document.form1.edit10.value=='')||(document.form1.edit11.value=='')||(document.form1.edit12.value=='')||(document.form1.edit13.value=='')||(document.form1.se1.value=='Default')||(document.form1.se2.value=='Default')||(document.form1.se3.value=='Default')||(document.form1.se4.value=='Default')||(document.form1.se5.value=='Default')||(document.form1.se6.value=='Default')||(document.form1.edit21.value=='')||(document.form1.combo3.value=='Default')||(document.form1.edit22.value=='')||(document.form1.combo4.value=='Default')||(document.form1.edit23.value=='')||(document.form1.edit24.value=='')||(document.form1.edit25.value=='')||(document.form1.edit26.value=='')||(document.form1.edit27.value=='')||(document.form1.edit28.value==''))
			{
				alert('Un champ est vide');
			}
		}

		function Nuite()
			{
				var d1=document.getElementById("edit18").value;
				var d2=document.getElementById('se6').options[document.getElementById('se6').selectedIndex].value+'-'+document.getElementById('se5').options[document.getElementById('se5').selectedIndex].value+'-'+document.getElementById('se4').options[document.getElementById('se4').selectedIndex].value;
				var date1= new Date(d1);
				var date2= new Date(d2);
				var nuite=(date2-date1)/86400000;
				//alert (nuite);
				if (nuite==0)
				{nuite=nuite+1}
				document.getElementById("nui").value=nuite;
			}

			function CalculMt()
			{
				var montant=(document.getElementById("edit23").value* document.getElementById("edit24").value);
				document.getElementById("edit25").value=montant;
			}

			function CalculSD()
			{
				var due=(document.getElementById("edit25").value- document.getElementById("edit26").value);
				document.getElementById("edit27").value=due;

				var nt=(document.getElementById("edit26").value/ document.getElementById("edit24").value);
				document.getElementById("edit28").value=nt;
			}


		// fonction pour selectionner le nom du client
	   function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
					//id du champ qui receptionne le résultat
						document.getElementById('edit3').value = leselect;

					}
				}
				//nom du fichier qui exécute la requete
				xhr.open("POST","others/fnomcli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				//id du numcli
				sel = document.getElementById('edit2').value;
				//affectation de la valeur saisie a la requete php
				xhr.send("numcli="+sel);
		}

				// fonction pour savoir si le codiam le doit
	   function action_03(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
					//id du champ qui receptionne le résultat
						document.getElementById('edit_03').value = leselect;

					}
				}
				//nom du fichier qui exécute la requete
				xhr.open("POST","valoir.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				//id du numcli
				sel = document.getElementById('edit2').value;
				//affectation de la valeur saisie a la requete php
				xhr.send("numcli="+sel);
		}


		// fonction pour selectionner le prenom du client
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit4').value=leselect;

					}
				}
				xhr.open("POST","others/fprenomcli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		//fonction pour selectionner le sexe du client
		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit5').value = leselect;

					}
				}
				xhr.open("POST","others/fsexecli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner la date de naissance du client
		function action3(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit6').value = leselect;

					}
				}
				xhr.open("POST","others/fdatnaisscli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}

				// fonction pour selectionner le type de piece du client
		function action8(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_9').value = leselect;

					}
				}
				xhr.open("POST","others/typepiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}

		 // fonction pour selectionner le numero de la piece du client
		function action9(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_13').value = leselect;

					}
				}
				xhr.open("POST","others/numeropiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}

				 // fonction pour selectionner la date de delivrance de la piece du client
		function action10(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_14').value = leselect;

					}
				}
				xhr.open("POST","others/datepiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le lieu de delivrance de la piece du client
		function action11(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_15').value = leselect;

					}
				}
				xhr.open("POST","others/lieupiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
				// fonction pour selectionner le delivreur de la piece du client
		function action12(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_16').value = leselect;

					}
				}
				xhr.open("POST","others/livreurpiece.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}


		// fonction pour selectionner le lieu de naissance du client
		function action4(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit7').value = leselect;

					}
				}
				xhr.open("POST","others/flieucli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le pays du client
		function action5(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit8').value = leselect;

					}
				}
				xhr.open("POST","others/fpayscli.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit2').value;
				//idpays = sel.options[sel.selectedIndex].value;
				xhr.send("numcli="+sel);
		}
		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit_9').value = leselect;
					}
				}
				xhr.open("POST","others/ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
		}
		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit24').value = leselect;
					}
				}
				xhr.open("POST","others/ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo4');
				sel1 = document.getElementById('combo3');
				sh1=sel1.options[sel.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
		}

		//affichage des informations concernant le client
		var momoElement = document.getElementById("edit2");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("blur", action, false);
		  momoElement.addEventListener("keyup", action, false);
		   momoElement.addEventListener("blur", action1, false);
		  momoElement.addEventListener("keyup", action1, false);
		  momoElement.addEventListener("blur", action2, false);
		  momoElement.addEventListener("keyup", action2, false);
		  momoElement.addEventListener("blur", action3, false);
		  momoElement.addEventListener("keyup", action3, false);
		  momoElement.addEventListener("blur", action4, false);
		  momoElement.addEventListener("keyup", action4, false);
		  momoElement.addEventListener("blur", action5, false);
		  momoElement.addEventListener("keyup", action5, false);
		  momoElement.addEventListener("blur", action8, false);
		  momoElement.addEventListener("keyup", action8, false);
		  momoElement.addEventListener("blur", action9, false);
		  momoElement.addEventListener("keyup", action9, false);
		  momoElement.addEventListener("blur", action10, false);
		  momoElement.addEventListener("keyup", action10, false);
		  momoElement.addEventListener("blur", action11, false);
		  momoElement.addEventListener("keyup", action11, false);
		  momoElement.addEventListener("blur", action12, false);
		  momoElement.addEventListener("keyup", action12, false);
		  momoElement.addEventListener("blur", action_03, false);
		  momoElement.addEventListener("keyup", action_03, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onblur", action);
		  momoElement.attachEvent("onkeyup", action);
		  momoElement.attachEvent("onblur", action1);
		  momoElement.attachEvent("onkeyup", action1);
		   momoElement.attachEvent("onblur", action2);
		  momoElement.attachEvent("onkeyup", action2);
		   momoElement.attachEvent("onblur", action3);
		  momoElement.attachEvent("onkeyup", action3);
		   momoElement.attachEvent("onblur", action4);
		  momoElement.attachEvent("onkeyup", action4);
		   momoElement.attachEvent("onblur", action5);
		  momoElement.attachEvent("onkeyup", action5);
		  momoElement.attachEvent("onblur", action8);
		  momoElement.attachEvent("onkeyup", action8);
		  momoElement.attachEvent("onblur", action9);
		  momoElement.attachEvent("onkeyup", action9);
		  momoElement.attachEvent("onblur", action10);
		  momoElement.attachEvent("onkeyup", action10);
		   momoElement.attachEvent("onblur", action11);
		  momoElement.attachEvent("onkeyup", action11);
		   momoElement.attachEvent("onblur", action12);
		  momoElement.attachEvent("onkeyup", action12);
		  momoElement.attachEvent("onblur", action_03);
		  momoElement.attachEvent("onkeyup", action_03);
		 // momoElement.attachEvent("onchange", action8);
		}

		var momoElement1 = document.getElementById("combo3");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action6, false);
		 // momoElement1.addEventListener("change", action7, false);
		  //momoElement1.addEventListener("change", Verif, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action6);
		 // momoElement1.attachEvent("onchange", action7);
		  //momoElement1.attachEvent("onchange", verif);
		}

		var momoElement2 = document.getElementById("combo4");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("change", action7, false);

		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onchange", action7);

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
			}
	</script>
</html>
