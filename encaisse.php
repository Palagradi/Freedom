<?php
	include 'menu.php';
	include 'chiffre_to_lettre.php'; 
	$numfiche1=$_GET['numfiche1'];
	$sal=$_GET['sal'];
	$numero=$_GET['numero'];
	$montant=$_GET['montant'];
	$paye=$_GET['paye'];
	$somme=$_GET['somme'];
	//unset( $_SESSION['remise']);
	//$codegrpe=$_GET['codegrpe'];
	$reduce=$_GET['reduce'];$EtatG=$_GET['etatget'];
	//Pour connaitre le montant des occupants de chambre qui sont en impayés		
	$sql2=mysql_query("SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_fiche1.datarriv,
	view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe, mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc,mensuel_compte.ht, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.due,mensuel_compte.N_reel,mensuel_compte.ttc
	FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client,groupe
	WHERE mensuel_fiche1.numcli_1 = client.numcli
	AND mensuel_fiche1.numcli_2 = view_client.numcli AND groupe.codegrpe=mensuel_fiche1.codegrpe
	AND groupe.code_reel = '".$numero."'
	AND chambre.numch = mensuel_compte.numch
	AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
	AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0
	LIMIT 0 , 30" );

	$i=1;$somme_due=0;$ttc0=0;$montant_ht2=0;$montant_ht=0;
	while($row=mysql_fetch_array($sql2))
		{  	$N_reel=$row['N_reel'];
			$datarriv2=$row['datarriv'];
			$ttc=$row['ttc'];
		     $ht=$row['tarif']*$row['N_reel'];
			$ht2=$row['ht'];
			//echo $datarriv."<br/>".$datarriv2;
			$somme_due+=$row['due'];
			 $montant_ht+=$ht;
			$ttc+=$ttc;$montant_ht2+=$ht2;
			$i++;
		}
	//echo $datarriv2."<br/>".$datarriv1;	
	 //$montant_ht=0;
	
		// automatisation du numéro
/* 	function random($car) {
		$string = "F";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		} */
		
		// automatisation du numéro
	function random2($car) {
		$string = "G";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
	
	$date=$_GET['Arrivee'];
	//$_SESSION['date1']=substr($_POST['date'],6,4).'-'.substr($_POST['date'],3,2).'-'.substr($_POST['date'],0,2);
	$_SESSION['date1']=substr($_POST['date'],8,2).'-'.substr($_POST['date'],5,2).'-'.substr($_POST['date'],0,4);
	
	$ans=substr($_POST['date'],0,4);
	$mois=substr($_POST['date'],5,2);
	$jour=substr($_POST['date'],8,2);  
	$groupe=$_GET['groupe'];
	$_SESSION['groupe']=$_POST['groupe'];

	mysql_query("SET NAMES 'utf8'");
	$re=mysql_query("SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND etatsortie='NON' ORDER BY chambre.numch");
	$groupe=$_GET['groupe'];
	if (isset($_POST['VALIDER'])&& $_POST['VALIDER']=='VALIDER') 
		{	$_SESSION['montant']=$_POST['edit3'];
			$_SESSION['exonorer_tva']=$_POST['exonorer_tva']; $_SESSION['exonerer_AIB']=$_POST['exonerer_AIB'];			

			if($_POST['cache']!=1){ 
			$_SESSION['total_tt1']=$total;
			$_SESSION['avanceA']=$_POST['edit5'];
			$_SESSION['groupe1']=$_POST['groupe'];
			$groupe=$_POST['groupe'];$_SESSION['remise']=$_POST['remise'];
			if(($_POST['edit5']!='')&&($_POST['edit5']!=0)){
				if($_POST['groupe']=='')
				 {  $_SESSION['numfiche']=$_POST['edit15'];	
					mysql_query("SET NAMES 'utf8' ");
					$s=mysql_query("SELECT mensuel_compte.typeoccup,chambre.typech,mensuel_compte.somme,mensuel_compte.ttc,mensuel_compte.due,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.tarif AS tarif1,nomcli,prenomcli,nomch,datarriv FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.numfiche='".$_POST['edit2']."'");
					while($ez=mysql_fetch_array($s))
					{echo $_SESSION['tarif1']=$ez['tarif1'];
					$_SESSION['montant_ttc']=$ez['ttc'];
					if(empty($_POST['pourcent']))
						{ $somme=$_POST['edit5'];
						  $edit5=$_POST['edit5'];
						}
					else
						{echo $somme=$_POST['edit5']+$_POST['remise'];	
						 $edit5=$_POST['edit5']+$_POST['remise'];
						 
						}						
					$due=$ez['due']-$somme; 
					$_SESSION['datarriv']=$ez['datarriv'];
					$_SESSION['datdep']=$ez['datdep'];
					//echo 12;
					
					if($ez['ttc_fixe']!=0){
						//if(empty($_POST['pourcent']))
							//$np=$_POST['edit5']/$ez['ttc_fixe'];
						//else
							$np=$edit5/$ez['ttc_fixe'];
					
					}
					$_SESSION['np']=$np;					
					$_SESSION['edit2']=$_POST['edit2'];
					$_SESSION['ttc_fixe']=$ez['ttc_fixe'];
					if($ez['typech']=='V') $_SESSION['tch']='Ventillée'; else $_SESSION['tch']='Climatisée';
					$_SESSION['occup']=$ez['typeoccup'];
					$np1=$ez['np']+$np;
					$_SESSION['nomclient']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
					$somme=$_SESSION['ttc_fixe']*$np1;
					}
					if(empty($_POST['pourcent']))
						$paye=$_POST['edit5'];
					else
						$paye=$edit5;
					if(is_int($np)){
					$de=mysql_query("UPDATE mensuel_compte SET somme='$somme', due='$due',np='$np1' WHERE numfiche='".$_POST['edit2']."'");
					$de1=mysql_query("UPDATE compte SET somme='$somme', due='$due',np='$np1' WHERE numfiche='".$_POST['edit2']."'");
					$s1=mysql_query("SELECT np,ttax,tarif,numch,typeoccup,ttc_fixe,tva FROM mensuel_compte WHERE numfiche='".$_POST['edit2']."'");
					$ez1=mysql_fetch_array($s1);
					$_SESSION['nuit']=$ez1['np'];
					$ttc_fixe=$ez1['ttc_fixe'];
					$tarif=$ez1['tarif'];
					$numch=$ez1['numch'];
					if($ez1['typeoccup']=='double')
					$_SESSION['ttax']=2000; else $_SESSION['ttax']=1000;
					if(empty($_POST['pourcent'])){
					$_SESSION['tva']=round(0.18*$_POST['edit5'],4);
					$_SESSION['somme_paye']=$_POST['edit5'];
					}
					else {
					$_SESSION['tva']=round(0.18*$edit5,4);
					$_SESSION['somme_paye']=$edit5;
					}
					$_SESSION['somme_due']=$_POST['edit3'];
					$_SESSION['nuite']=$np;
					$typeoccup=$ez1['typeoccup'];
					if ($de)
					{  	$en=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_POST['edit10']."','".$_SESSION['login']."','Impayee fiche individuelle','$numch','$typeoccup','$tarif','$ttc_fixe','$np')");
						$en1=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_POST['edit10']."','".$_SESSION['login']."','Impayee fiche individuelle','$numch','$typeoccup','$tarif','$ttc_fixe','$np')");
						$avc=$ttc_fixe*$np;
						$rit=mysql_query('UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
						echo "<script language='javascript'> alert('Encaissement effectué avec succès.'); </script>"; 
						$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1  WHERE num_fact!=''");			
						$reqsel=mysql_query("SELECT * FROM configuration_facture");
						while($data=mysql_fetch_array($reqsel))
							{  $num_fact=$data['num_fact'];
							}
						if(($num_fact>=0)&&($num_fact<=9))
						$initial_fiche="0000".$num_fact."/".substr(date('Y'),2,2);
						if(($num_fact>=10)&&($num_fact <=99))
						$initial_fiche= "000".$num_fact."/".substr(date('Y'),2,2);
						if(($num_fact>=100)&&($num_fact<=999))
						$initial_fiche= "00".$num_fact."/".substr(date('Y'),2,2);
						if(($num_fact>=1000)&&($num_fact<=1999))
						$initial_fiche= "0".$num_fact."/".substr(date('Y'),2,2);
						if($num_fact>1999)
					    $initial_fiche=$num_fact."/".substr(date('Y'),2,2);	
			            header('location:recufiche_impaye.php');
					}
					}else $msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					La somme à encaisser doit correspondance à une certaine nuitée pour le client</span>";
				}
			else
			{
			//Pour connaitre le montant des occupants de chambre qui sont en impayés		
		$sql2=mysql_query("SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
		view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe, mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.due,mensuel_compte.N_reel,mensuel_compte.ttc
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
		WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli
		AND mensuel_fiche1.codegrpe = '".$_POST['groupe']."'
		AND chambre.numch = mensuel_compte.numch
		AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
		AND mensuel_fiche1.etatsortie = 'OUI'
		LIMIT 0 , 30" );
		
		$i=1;$somme_due=0;$ttc=0;$datarriv=array("");
  		while($row=mysql_fetch_array($sql2))
			{  	$N_reel=$row['N_reel'];
				$due=$row['due'];$ttc=$row['ttc'];
				$somme_due+=$due;
				$ttc+=$ttc;
				$i++;
			}
		 $somme_due=$somme_due;	$ttc=$ttc;

			if(!empty($somme_due))
			{ $np='RAS'; 
				 
			}
			else  
			{	if(empty($_POST['pourcent'])){ $edit5=$_POST['edit5'];} else $edit5=$_POST['edit5']+$_POST['remise'];
				if (($somme_jour>=$edit5)AND($edit5!=0)) 
				$np=$somme_jour/$edit5; else if($somme_jour!=0)  $np=$edit5/$somme_jour;
			}
			$nombre=mysql_num_rows($sql2);		
			$_SESSION['numfich']=$_POST['groupe'];
            $_SESSION['numfiche2']=$_POST['edit_15'];		
			$_SESSION['nombre']=$nombre;	
			
			mysql_query("SET NAMES 'utf8' ");
			$_SESSION['date']= date('Y-m-d');

			$res=mysql_query("SELECT client.numcli,client.nomcli,client.prenomcli,chambre.numch,mensuel_compte.typeoccup,mensuel_compte.tarif,mensuel_compte.ttc_fixe,chambre.nomch,mensuel_compte.tarif,mensuel_compte.taxe,mensuel_compte.ttc,mensuel_compte.nuite as nuite FROM client,mensuel_fiche1,chambre,mensuel_compte WHERE mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.codegrpe='".$_SESSION['groupe1']."'AND chambre.numch=mensuel_compte.numch AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND mensuel_fiche1.datarriv
			BETWEEN '".$_SESSION['ladate1']."' AND '".$_SESSION['ladate2']."'"); 
			
			while ($ret=mysql_fetch_array($res)) 
				{	$total=$ret['total'];
					$numch=$ret['numch'];
					$typeoccuprc=$ret['typeoccup']; 
					$tarifrc=$ret['tarif']; 
					$ttc=$ret['ttc_fixe'];
				}
				
		$res1=mysql_query("SELECT min(mensuel_fiche1.datarriv) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='".$_SESSION['groupe1']."'AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND mensuel_fiche1.datarriv
			BETWEEN '".$_SESSION['ladate1']."' AND '".$_SESSION['ladate2']."' AND mensuel_fiche1.etatsortie = 'OUI'"); 		
			while ($ret=mysql_fetch_array($res1)) 
				{	echo $min_date=$ret['min_date'];
				}			
			$ladate1=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
	        $ladate2=substr($_POST['ladate2'],6,4).'-'.substr($_POST['ladate2'],3,2).'-'.substr($_POST['ladate2'],0,2);
			$s=mysql_query("SELECT * FROM mensuel_fiche1, mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.datarriv between'$ladate1' AND '$ladate2' AND mensuel_fiche1.datdep between '$ladate1'  AND '$ladate2'AND mensuel_fiche1.etatsortie='NON'");
			while($ret1=mysql_fetch_array($s)){
			$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
			$dat=(date('H')+1); 
			settype($dat,"integer");
			if ($dat<14){$n=$n;}else {$n= $n+1;}
			if ($n==0){$n= $n+1;}
			$mt=($n*$ret1['ttc'])/$ret1['nuite'];
			$var1=$ret1['somme'];							
			$var = $mt-$var1; 
			$_SESSION['var1']=$var;
			}

			if((is_int($np))||($np=='RAS')){
			$_SESSION['total_ttB']=$_POST['edit_6'];
			$_SESSION['update']='OUI';			
			$_SESSION['date2']=$_POST['ladate2'];
			
			$sql_3=mysql_query("SELECT mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP, mensuel_compte.somme AS SommeP
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.datarriv
			BETWEEN '".$_SESSION['ladate1']."'
			AND '".$_SESSION['ladate2']."'
			AND mensuel_fiche1.etatsortie = 'NON'");
			$Record_set = mysql_fetch_assoc($sql_3);
			$NuiteP=$Record_set['NuiteP'];
			$Nuite_Payee=$np+$NuiteP; 
			$SommeP=$Record_set['SommeP'];	
			
			$sql_3=mysql_query("SELECT max(mensuel_compte.N_reel) AS max_n_reel
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.datarriv
			BETWEEN '".$_SESSION['ladate1']."'
			AND '".$_SESSION['ladate2']."'
			AND mensuel_fiche1.etatsortie = 'NON'");
			$Record_set = mysql_fetch_assoc($sql_3);
			$max_n_reel=$Record_set['N_reel'];
			$Nuite_Payee=$N_reel; 
		
						
			$sql3=mysql_query("SELECT mensuel_compte.numfiche AS numfiche,mensuel_compte.N_reel as N_reel, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'");		

			$i=0; $nombre=array("");
			while($row_1=mysql_fetch_array($sql3))
			{ $nombre= $row_1['numfiche'];
			  $nombre2= $row_1['ttc_fixe'];	
			  $N_reel=$row_1['N_reel'];		  
			  $SommePayee=$N_reel*$nombre2;
			  $req=mysql_query("UPDATE mensuel_compte SET somme=$SommePayee,np=$N_reel WHERE numfiche='".$nombre."'");
			  $req1=mysql_query("UPDATE compte SET somme=$SommePayee,np=$N_reel WHERE numfiche='".$nombre."'");
			   $i++;
			}
			$nbre=mysql_num_rows($sql3);
			$res1=mysql_query("SELECT mensuel_compte.date AS debut FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='".$_POST['groupe']."'AND mensuel_fiche1.etatsortie='OUI' AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND mensuel_compte.due>0"); 	
			while ($ret=mysql_fetch_array($res1)) 
			{	 $date=$ret['debut']; 
			}	
			$res1=mysql_query("SELECT min(mensuel_fiche1.datarriv) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='".$_POST['groupe']."'AND mensuel_fiche1.etatsortie='OUI' AND mensuel_compte.due>0"); 	
			while ($ret=mysql_fetch_array($res1)) 
				{	 echo"<br/>".$min_date=$ret['min_date'];
				}
			
			if(empty($date))
			{$ans=substr($min_date,0,4);
			$mois=substr($min_date,5,2);
			$jour=substr($min_date,8,2);
			$_SESSION['debut']=substr($min_date,8,2).'-'.substr($min_date,5,2).'-'.substr($min_date,0,4);			
			}else
			{$ans=substr($date,6,4);
			$mois=substr($date,3,2);
			$jour=substr($date,0,2); 
			$_SESSION['debut']=substr($date,0,2).'-'.substr($date,3,2).'-'.substr($date,6,4);
			}
			//echo "SELECT max(mensuel_compte.N_reel) AS N_reel FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='".$_POST['groupe']."'AND mensuel_fiche1.etatsortie='OUI' AND mensuel_compte.due>0";
			if($np!='RAS')
				 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$np,date($ans)));
				else{$res1=mysql_query("SELECT max(mensuel_compte.N_reel) AS N_reel FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='".$_POST['groupe']."'AND mensuel_fiche1.etatsortie='OUI' AND mensuel_compte.due>0"); 	
					while ($ret=mysql_fetch_array($res1)) 
					{	  $N_reel=$ret['N_reel'];
					}
					  $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
				}			
			$sql3=mysql_query("SELECT mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe,mensuel_compte.tarif, mensuel_compte.N_reel,mensuel_fiche1.datarriv
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0");			

			$i=0; $nombre=array("");
			while($row_1=mysql_fetch_array($sql3))
			{ $nombre= $row_1['numfiche'];
			  //$ttc_fixe= $row_1['ttc_fixe'];
				 if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']!=1))
					$ttc_fixe=$row_1['ttc_fixe'];
				 else
				    $ttc_fixe=$row_1['tarif'];			  
			  $N_reel=$row_1['N_reel'];
			  $req1=mysql_query("UPDATE compte SET somme=$ttc_fixe*$N_reel,np=$N_reel WHERE numfiche='".$nombre."'");
			  $req=mysql_query("UPDATE mensuel_compte SET somme=$ttc_fixe*$N_reel,np=$N_reel WHERE numfiche='".$nombre."'");
			  if($_POST['exonorer_tva']==1)
					$sql=mysql_query("INSERT INTO exonerer_tva VALUES('".date('Y-m-d')."','".$nombre."')");
			 if($_POST['exonerer_AIB']==1)
					$sql=mysql_query("INSERT INTO exonerer_aib VALUES('".date('Y-m-d')."','".$nombre."')");
			   $i++;
			}			
			$sql2=mysql_query("CREATE OR REPLACE VIEW view_temporaire AS SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
			view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.somme AS somme
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_POST['groupe']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0"); 			

	$sql2=mysql_query("SELECT num1,num2,nom1,nom2,prenom1,prenom2,nomch,mensuel_compte.np AS np,mensuel_compte.nuite,mensuel_compte.N_reel,mensuel_compte.typeoccup,mensuel_compte.ttc_fixe,datarriv,mensuel_compte.tarif FROM view_temporaire,mensuel_compte WHERE view_temporaire.numfiche=mensuel_compte.numfiche");
	/* 	$sql2=mysql_query("SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
			view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.somme AS somme
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_POST['groupe']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0"); */
			$data="";
 		while($row=mysql_fetch_array($sql2))
			{ if($row['num1']!=$row['num2'])
			   {$numcli=$row['num1']." | ".$row['num2'];
			    $client=substr(strtoupper($row['nom1'])." ".strtoupper($row['prenom1'])." |"." ".strtoupper($row['nom2'])." ".strtoupper($row['prenom2']),0,35);}
			  else
				{ $numcli=$row['num1'];
				  $client=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				 }			 
				  $nomch=$row['nomch'];   
				  $np=$row['np'];
				  $type=$row['typeoccup'];
				 if(($_POST['exonorer_tva']==1)||($_POST['exonerer_AIB']==1))
					$tarif=$row['tarif'];
				 else
				    $tarif=$row['ttc_fixe'];
				 if($_POST['exonerer_AIB']==1)
				  $tarif=$tarif-$tarif*0.01;	
				  $N_reel=$row['N_reel'];
			$n=(strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400;
				$dat=(date('H')+1); 
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;}			  
			$nuite=$n;  $n_p= $n-$np; if($n_p<0) $n_p=-$n_p;
			$tva=0.18*$row['tarif'];$aib=0.01*$row['tarif'];
			if($type=='double')
			$taxe=2000;
			if($type=='individuelle')
			$taxe=1000;
	
			 $Nuite_Payee=$N_reel;
			if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']!=1))
			  {	$montant=$tarif*$Nuite_Payee;
			  }
			 else
			 {if($_POST['exonorer_tva']==1)
				echo "<br/>".$montant=($tarif+$taxe)*$Nuite_Payee;
			 else $montant=($tarif+$tva+$taxe)*$Nuite_Payee;
			}
			 $tva=$tva*$Nuite_Payee; $aib=$aib*$Nuite_Payee;//$aib-=;
			 $taxe=$taxe*$Nuite_Payee;
			 $montant_ht=$Nuite_Payee*$row['tarif'];
			if($Nuite_Payee>0)
				{$ecrire=fopen('facture.txt',"w");
				if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']!=1))
					$data.=$numcli.';'.$client.';'.$nomch.';'.$Nuite_Payee.';'.$montant_ht.';'.$tva.';'.$taxe.';'.$montant."\n";
				else if(($_POST['exonorer_tva']==1)&&($_POST['exonerer_AIB']!=1))
					$data.=$numcli.';'.$client.';'.$nomch.';'.$Nuite_Payee.';'.$montant_ht.';'.$taxe.';'.$montant."\n";
				else if(($_POST['exonorer_tva']==1)&&($_POST['exonerer_AIB']==1))
					$data.=$numcli.';'.$client.';'.$nomch.';'.$Nuite_Payee.';'.$montant_ht.';'.$aib.';'.$taxe.';'.$montant."\n";
				//if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']==1))
				else
					$data.=$numcli.';'.$client.';'.$nomch.';'.$Nuite_Payee.';'.$montant_ht.';'.$tva.';'.$aib.';'.$taxe.';'.$montant."\n";
				$ecrire2=fopen('facture.txt',"a+");
				}
			fputs($ecrire2,$data);
			}
			
		$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1  WHERE num_fact!=''");
			
		$reqsel=mysql_query("SELECT * FROM configuration_facture");
		while($data=mysql_fetch_array($reqsel))
			{  $num_fact=$data['num_fact'];
			}
		if(($num_fact>=0)&&($num_fact<=9))
		$initial_fiche="0000".$num_fact."/".substr(date('Y'),2,2);
		if(($num_fact>=10)&&($num_fact <=99))
		$initial_fiche= "000".$num_fact."/".substr(date('Y'),2,2);
		if(($num_fact>=100)&&($num_fact<=999))
		$initial_fiche= "00".$num_fact."/".substr(date('Y'),2,2);
		if(($num_fact>=1000)&&($num_fact<=1999))
		$initial_fiche= "0".$num_fact."/".substr(date('Y'),2,2);
		if($num_fact>1999)
	     $initial_fiche=$num_fact."/".substr(date('Y'),2,2);	
		$_SESSION['initial_fiche']=$initial_fiche;
		
		$recu=substr($initial_fiche, 0, -3);$heure=date('H:i:s');
			$sql3=mysql_query("SELECT mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe, mensuel_compte.N_reel,mensuel_fiche1.datarriv,mensuel_compte.numch,mensuel_compte.typeoccup,mensuel_compte.tarif,chambre.typech,mensuel_fiche1.numfiche AS numfichegrpe, mensuel_compte.date AS date
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0");	
			$i=0; $nombre=array("");$np12=1;
			while($row_1=mysql_fetch_array($sql3))
			{ $nombre= $row_1['numfiche'];$tarif2=$row_1['tarif'];
			 if(($_POST['exonorer_tva']==1)||($_POST['exonerer_AIB']==1))
			  $tarif=$row_1['tarif'];
			else
			 $tarif=$row_1['ttc_fixe'];
			 $ttc_fixe= $row_1['ttc_fixe'];			 
			if($_POST['exonerer_AIB']==1)
				  $tarif=$tarif-$tarif*0.01;	
			//if($_POST['exonorer_tva']==1)
				 // $tarif=$tarif+$tarif*0.18;		
			 $tva=$tarif*0.18;				 
			  $N_reel=$row_1['N_reel'];if($N_reel>$np12) $np12=$N_reel;
				  $numch=$row_1['numch'];   
				  $type=$row_1['typeoccup'];
				  $numfichegrpe=$row_1['numfichegrpe'];
				 if($type=='double')
				$taxe=2000;
				if($type=='individuelle')
				$taxe=1000;
				 if(($_POST['exonorer_tva']==1)||($_POST['exonerer_AIB']==1))
				  $montant=($tarif+$taxe)*$N_reel; 	else $montant=$tarif*$N_reel; 	
				  $typech=$row_1['typech'];if($typech=="V") $typech="Ventillee";if($typech=="CL") $typech="Climatisee";
				  $Aans=substr($row_1['date'],6,4);
				  $Mmois=substr($row_1['date'],3,2);
				  $Jjour=substr($row_1['date'],0,2); 
				   $Ddate=date("d/m/Y", mktime(0, 0, 0,date($Mmois),date($Jjour)+$N_reel,date($Aans)));
			   	if(($_POST['exonorer_tva']==1)||($_POST['exonerer_AIB']==1))
					{$req=mysql_query("UPDATE mensuel_compte SET somme=somme+($tarif+$taxe)*$N_reel,np=np+'".$N_reel."',date='".$Ddate."', due='' WHERE numfiche='".$nombre."'");
				    $req1=mysql_query("UPDATE compte SET somme=somme+($tarif+$taxe)*$N_reel,np=np+'".$N_reel."',date='".$Ddate."', due='' WHERE numfiche='".$nombre."'");
					}
				else
					{$req=mysql_query("UPDATE mensuel_compte SET somme=somme+$tarif*$N_reel,np=np+'".$N_reel."',date='".$Ddate."',due='' WHERE numfiche='".$nombre."'");
					 $req1=mysql_query("UPDATE compte SET somme=somme+$tarif*$N_reel,np=np+'".$N_reel."',date='".$Ddate."',due='' WHERE numfiche='".$nombre."'");
					}				
				
			  //une maniere de faire sortir  client de liste des impayés s'il a tout payer
			 $req=mysql_query("UPDATE mensuel_fiche1 SET etatsortie='RAS' WHERE numfiche='".$nombre."'");
			 $req1=mysql_query("UPDATE fiche1 SET etatsortie='RAS' WHERE numfiche='".$nombre."'");
			 
			 if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']!=1))
			  {	$tarif1=$tarif;
			  }
			 else
			 {if($_POST['exonorer_tva']==1)
				$tarif1=$tarif+$taxe;
			 else $tarif1=$tarif+$tva+$taxe;
			}
			
			 if($N_reel!=0)
			 { if(($_POST['exonorer_tva']==1)||($_POST['exonerer_AIB']==1))
				 {$en=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$nombre."','".$_POST['edit5']."','".$_SESSION['login']."','Facture de groupe','$numch','$type','$tarif','$tarif1','$N_reel')");
				  $en2=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$nombre."','".$_POST['edit5']."','".$_SESSION['login']."','Facture de groupe','$numch','$type','$tarif','$tarif1','$N_reel')");
				 }
				else
				 {$en=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$nombre."','".$_POST['edit5']."','".$_SESSION['login']."','Facture de groupe','$numch','$type','$tarif','$tarif','$N_reel')");
				  $en2=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$nombre."','".$_POST['edit5']."','".$_SESSION['login']."','Facture de groupe','$numch','$type','$tarif','$tarif','$N_reel')");
				 }
			 }
			 if(($_POST['exonorer_tva']==1)||($_POST['exonerer_AIB']==1))
				$tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$initial_fiche','$numfichegrpe','$numch','$typech','$type','$tarif2','$N_reel','$tarif1')");
			 else
				 $tu=mysql_query("INSERT INTO reeditionfacture2 VALUES ('$initial_fiche','$numfichegrpe','$numch','$typech','$type','$tarif2','$N_reel','$montant')");
			   $i++;
			}
		 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$np12,date($ans)));
		$tu=mysql_query("INSERT INTO reedition_facture VALUES ('".date('Y-m-d')."','$heure','".$_SESSION['login']."','$initial_fiche','$initial_fiche','".$_SESSION['groupe1']."','Hebergement','".$_SESSION['debut']."','".$_SESSION['fin']."','$taxe','$tva','".$_POST['edit3']."','".$_POST['remise']."','".$_POST['edit5']."')");

		if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']!=1))
			header('location:facture_de_groupe.php');
		else if(($_POST['exonorer_tva']==1)&&($_POST['exonerer_AIB']!=1))
			header('location:facture_de_groupe1.php');
		else if(($_POST['exonorer_tva']!=1)&&($_POST['exonerer_AIB']==1))
			header('location:facture_de_groupe2.php');
		else if(($_POST['exonorer_tva']==1)&&($_POST['exonerer_AIB']==1))
			header('location:facture_de_groupe3.php');	 	
			}
			else $msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'> La somme à encaisser doit correspondance à une certaine nuitée pour tous les membres du groupe</span>";		
		}
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	}
	else
     {	if(($_POST['edit5']!='')&&($_POST['edit5']!=0)){
		 mysql_query("SET NAMES 'utf8' ");
		$s=mysql_query("SELECT location.datarriv,salle.numsalle,compte1.somme,compte1.ttc,compte1.ttc_fixe,compte1.np,compte1.tarif AS tarif1,nomcli,prenomcli,salle.codesalle,datarriv FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche and location.numfiche='".$_POST['edit2']."'");
		while($ez=mysql_fetch_array($s))
		{$somme=$ez['somme']+ $_POST['edit5']; 
		$due=$ez['ttc']- $somme; 
		$numsalle=$ez['numsalle'];
		$ttc_fixe=$ez['ttc_fixe'];
		$_SESSION['edit2']=$_POST['edit2'];
		$_SESSION['date']=substr($ez['datarriv'],8,2).'/'.substr($ez['datarriv'],5,2).'/'.substr($ez['datarriv'],0,4);
		if($ez['ttc_fixe']!=0)
		$np=$_POST['edit5']/$ez['ttc_fixe'];
		$np1=$ez['np']+$np;
		$_SESSION['np']=$np1;
		$_SESSION['Nuite_sal']=$np; 
		$_SESSION['somme']=$_POST['edit5'];
		$_SESSION['nomclient']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
		}
		$de=mysql_query("UPDATE compte1 SET somme='$somme', due='$somme'-due,np='$np1' WHERE numfiche='".$_POST['edit2']."'");
		if ($de)
		{	$en=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Impayee location de salle','$numsalle','','$tarif','$ttc_fixe','$np')");
			$en2=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Impayee location de salle','$numsalle','','$tarif','$ttc_fixe','$np')");
			echo "<script language='javascript'> alert('Encaissement effectué avec succès.'); </script>"; 
			$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1  WHERE num_fact!=''");
			echo "<script language='javascript'> alert('Encaissement effectué avec succès.'); </script>"; 
			header('location:recusalle2.php');
		}
		}	else $msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Vous devez renseigner le champ Somme à encaisser</span>";
	}		
}
?>
<html>
	<head>
		<title>SYGHOC</title>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	</head>
	<body bgcolor='azure' style="margin-top:2px;"><br/>
		<form action='encaisse.php' method='post' name='encaisse'><br/>
			<table align='center' style='font-size:1.1em;'>
				<tr>
					<td>
						
					</td>
					<td> 
						
					</td> 
				</tr>
				<tr>
					<td>
						<fieldset> 
							<legend align='center'style='color:#DA4E39;'><b> ENCAISSEMENT <?php if(!empty($groupe)) echo 'FACTURE DE GROUPE'; else echo 'FICHE INDIVIDUELLE'; ?></b></legend> 
							<table>
								<tr><input type='hidden' name='cache' id='' value='<?php echo $sal; ?>' /> 
								<input type='hidden' name='groupe' id='' value='<?php echo $groupe; ?>' /> 
									 <span style='font-style:italic;font-size:0.9em;'>Attention: si le client occupe toujours la même chambre, alors encaisser le montant. Dans le cas d'un  </br>changement de chambre, alors faites d'abord le départ du client
									 et procéder encore à une entrée du client.</span>
								</tr>
								<?php
								if($groupe!='')
								{echo"<tr align='center'> 
									<td colspan='4' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  type='checkbox' name='exonorer_tva'  value='1' onclick='Aff2();'/>Exonérer de la TVA&nbsp;(18%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
									<input  type='checkbox' name='exonerer_AIB'  value='1' onclick='Aff3();'/>Exonérer de AIB&nbsp;(1%)  &nbsp; </td>";
								echo "<input type='hidden' name='hidden1' id='hidden1' value='"; echo 0.18*$montant_ht; echo"' />";
								echo "<input type='hidden' name='hidden2' id='hidden2' value='"; echo 0.01*$montant_ht; echo"' />";
								echo "</tr>";
								}
								?>								
								<tr>
									<td></br> Type d'encaisse: </td>
									<td>
										<select name='combo1' id='combo1' style='width:150px;'>
											<option value='<?php if(($numero!='')&&($sal==''))  echo "fiche";if(($numero!='')&&($sal==1)) echo "location";?>'> <?php if(($numero!='')&&($sal=='')) echo "Hébergement"; if(($numero!='')&&($sal==1)) echo "Location";?></option> 
											<option value='fiche'> Hébergement</option> 
											<option value='location'> Location</option> 
										</select> 
									<td></br> &nbsp;&nbsp;Date: </td>
									<td> </br><input type='text' name='edit1' id='edit1' value='<?php echo date('d-m-Y') ?>' readonly /> <td>
								</tr>
								<tr>
									<td> N° de la fiche: </td>
									<td> <input type='text' name='edit2' id='edit2' size='21' value='<?php if($numero!='') echo $numero;?>'/> 
									
									<input type='hidden' name='groupe' id='groupe' value='<?php if($groupe!='') echo $groupe;?>'/>
									<input type='hidden' name='date' id='date' value='<?php if($date!='') echo $date;?>'/>
									
									</td>
									<td> <?php if($sal!=1) echo "&nbsp;&nbsp;Total des Nuités payées:"; else echo "&nbsp;&nbsp;Total payé:"; ?> </td>
									<td> <input type='text' name='edit4' id='edit4' value='<?php if(!empty($paye)) echo $paye; else echo 0;?> ' readonly /> 
									 <td>
								</tr>
								<tr>
								<td>Nuit&eacute;e dû ce jour: </td>
								<td> <input type='text' name='edit3' id='edit3' size='21' value='<?php echo $montant ?>' readonly /> &nbsp;&nbsp;&nbsp;&nbsp;
									<input type='hidden' name='edit3_3' id='edit3_3' value='' onkeypress="testChiffres(event);" /> 
								<?php 
								//if($groupe!='')
									echo"<a href='encaisse.php?numero=".$_POST['edit5']."'>  
										<img src='logo/suivant.png' alt='' title='Encaisser la totalité du montant' width='16' height='16' border='0'>
										</a>";
								?>
								</td>
									<?php if($reduce!=1){ echo "<td>&nbsp;&nbsp;Somme à encaisser: </td>";
									 echo "<td> <input type='text' name='edit5' id='edit5' value='' onkeyup='changer();' onkeypress='testChiffres(event);'/>
									 <input type='hidden' id='t' /><td>";
									 }
									 ?>	
								</tr>
								
								<tr><td style='color:peachpuff'>hidden </td>
									<td> <input type='hidden' name='' id='' value='' /> <td>
								</tr>
								<tr>
							   <p id="">
							   </p>
								</tr>
								<tr> <td colspan='4'><br/><a  id='info_3'  title=' ' target="_blank"  href="popup.php?numfiche=<?php echo $numfiche;?>" onclick="window.open(this.href, 'Titre','target=_parent, height=auto, width=450, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false">
								<img src='logo/plus.png' alt='' title='' width='28' height='25' style='margin-top:0em;float:left;' border='0'><span style='font-size:1em;'>Ajouter des Frais Connexes</span></a>	
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a  id='info_3' href='encaisse.php?reduce=1<?php if($etatget==1) echo "deduce=2&"; if($etatget=1) echo "etatget="; if(!empty($_GET['etatget'])) $etatget=$_GET['etatget']+1; else $etatget=1; echo $etatget; if(!empty($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; 
								if(!empty($_GET['groupe'])) echo "&groupe=".$_GET['groupe']; if(!empty($_GET['codegrpe'])) echo "&codegrpe=".$_GET['codegrpe']; if(!empty($_GET['montant'])) echo "&montant=".$_GET['montant']; if(!empty($_GET['numero'])) echo "&numero=".$_GET['numero']; ?>'>
								<span style='font-size:1em;'><?php  if(!empty($reduce) && ($EtatG%2==0)) echo "Annuler la réduction"; 
								else echo "Réduction sur la facture";?> </span></a>										
								</td><td>	
									</td>
								<?php if($reduce==1){
								 //if($EtatG%2==0) { 
								echo "
								<tr>
									<td><br/> <span style='font-size:1em;'>% de remise accordée:</span> </td>
									<td><br/> <input type='text' name='pourcent' id='pourcent'  value='".$Ttotal."' onblur='AffA();' onchange='AffA();' onkeyup='AffA();'/> </td>

									<td><br/> <span style='font-size:1em;'>Montant à déduire:</span> </td>
									<td><br/> <input type='text' name='remise' id='remise' value='' onblur='AffB();' onchange='AffB();' onkeyup='AffB();' /> </td>
								</tr>
								<tr>
									<td><br/> <span style='font-size:1em;'>Net à payer:</span> </td>
									<td><br/> <input type='text' name='Mtotal' id='Mtotal' value='' readonly /> </td>
									</td>";
								echo "<td></br>"; if(($Ttotal>0))  
								echo "<span style='color:red;font-size:1em;'>Somme à encaisser:</span>"; else echo "<span style='font-size:1em;'>Somme à encaisser:</span>";
								echo "</td>";
								echo "<td>";
								if(($Ttotal>0)){
												echo "<input type='hidden' name='Ttotal' id='Ttotal' value='".$Ttotal."'  />";												
											if(($montantAuto=='OUI'))
												{  	echo "</br> <select name='edit5' id='edit5' style='width:150px;'>";
													$res=mysql_query("SELECT DISTINCT montant FROM table_tempon order BY montant DESC ");
													$NbreR=mysql_num_rows($res);$dueT=$due+$Ttotal;
													//if($NbreR<0)
														echo"<option value='".$dueT."'>".$dueT."</option>";
													 while ($ret= mysql_fetch_array($res))
														{$MTtotal=$ret['montant']+$Ttotal;
														echo '<option value="'.$MTtotal.'">';echo($MTtotal);echo '</option>';
														}
													echo"</select>";  
												}											
											else
												include 'saisieManuel.php'; 
											}else{
											if(($montantAuto=='OUI'))
												include 'montantAuto.php'; 
											else
												include 'saisieManuel.php'; 
											}
											
								echo "</td>	
								
								</tr>";
								}
								?>
								<tr> 
									<td colspan='4' align='center'> <input type='submit' class='mybutton' name='VALIDER' value='VALIDER' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;padding:0px 4px 0px 4px;' <?php echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; ?>/> </td>
								</tr> 
							</table>
						</fieldset> 
			
		</form> 

<script type="text/javascript">

function AffA()
{
	if (document.getElementById("pourcent").value!='') 
	{
		document.getElementById("remise").value= 0.01*document.getElementById("pourcent").value*document.getElementById("edit3").value  ; 		
		document.getElementById("Mtotal").value= document.getElementById("edit3").value-(0.01*document.getElementById("pourcent").value*document.getElementById("edit3").value)  ; 
	}
}
 function AffB()
{
	if (document.getElementById("remise").value!='') 
	{
		document.getElementById("pourcent").value= (100*document.getElementById("remise").value/document.getElementById("edit3").value).toFixed(2)  ; 		
		document.getElementById("Mtotal").value= document.getElementById("edit3").value-document.getElementById("remise").value ; 
	}
}

		function Aff2()
		{	/* if((document.getElementById("exonorer_tva").checked == false) || (document.getElementById("exonerer_AIB").checked == false))
				{ */
				document.getElementById("edit3").value=(document.getElementById("edit3").value-document.getElementById("hidden1").value).toFixed(4);
/* 				}
			else
				{document.getElementById("edit9").value=document.getElementById("edit9").value-document.getElementById("hidden3").value);
				} */
		}
		function Aff3()
		{	/* if((document.getElementById("exonorer_tva").value!=1)||(document.getElementById("exonerer_AIB").value!=1))
				{ */
				document.getElementById("edit3").value=(document.getElementById("edit3").value-document.getElementById("hidden2").value).toFixed(4);
/* 				}
			else
				{document.getElementById("edit9").value=document.getElementById("edit9").value-document.getElementById("hidden3").value);
				}	 */

		}
 
var res, plus, diz, s, un, mil, mil2, ent, deci, centi, pl, pl2, conj;
 
var t=["","un","deux","trois","quatre","cinq","six","sept","huit","neuf"];
var t2=["dix","onze","douze","treize","quatorze","quinze","seize","dix-sept","dix-huit","dix-neuf"];
var t3=["","","vingt","trente","quarante","cinquante","soixante","soixante","quatre-vingt","quatre-vingt"];
 
 
 
//window.onload=calcule
 
function calcule(){
    document.getElementById("t").onchange=function()
{
/*         document.getElementById("lettres").firstChild.data=trans(this.value)
		document.getElementById("lettre").value=document.getElementById("lettres").firstChild.data=trans(this.value) */
 }
}
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des deux parties du nombre;
function decint(n){
 
    switch(n.length){
        case 1 : return dix(n);
        case 2 : return dix(n);
        case 3 : return cent(n.charAt(0)) + " " + decint(n.substring(1));
        default: mil=n.substring(0,n.length-3);
            if(mil.length<4){
                un= (mil==1) ? "" : decint(mil);
                return un + mille(mil)+ " " + decint(n.substring(mil.length));
            }
            else{    
                mil2=mil.substring(0,mil.length-3);
                return decint(mil2) + million(mil2) + " " + decint(n.substring(mil2.length));
            }
    }
}
 
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des nombres entre 0 et 99, pour chaque tranche de 3 chiffres;
function dix(n){
    if(n<10){
        return t[parseInt(n)]
    }
    else if(n>9 && n<20){
        return t2[n.charAt(1)]
    }
    else {
        plus= n.charAt(1)==0 && n.charAt(0)!=7 && n.charAt(0)!=9 ? "" : (n.charAt(1)==1 && n.charAt(0)<8) ? " et " : "-";
        diz= n.charAt(0)==7 || n.charAt(0)==9 ? t2[n.charAt(1)] : t[n.charAt(1)];
        s= n==80 ? "s" : "";
 
        return t3[n.charAt(0)] + s + plus + diz;
    }
}
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des mots "cent", "mille" et "million"
function cent(n){
return n>1 ? t[n]+ " cent" : (n==1) ? " cent" : "";
}
 
function mille(n){
return n>=1 ? " mille" : "";
}
 
function million(n){
return n>=1 ? " millions" : " million";
}
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// conversion du nombre
function trans(n){
 
    // vérification de la valeur saisie
    if(!/^\d+[.,]?\d*$/.test(n)){
        return "L'expression entrée n'est pas un nombre."
    }
 
    // séparation entier + décimales
    n=n.replace(/(^0+)|(\.0+$)/g,"");
    n=n.replace(/([.,]\d{2})\d+/,"$1");
    n1=n.replace(/[,.]\d*/,"");
    n2= n1!=n ? n.replace(/\d*[,.]/,"") : false;
 
    // variables de mise en forme
    ent= !n1 ? "" : decint(n1);
    deci= !n2 ? "" : decint(n2);
    if(!n1 && !n2){
        return  "Zéro Francs CFA. (Mais, de préférence, entrez une valeur non nulle!)"
    }
    conj= !n2 || !n1 ? "" : "  et ";
    euro= !n1 ? "" : !/[23456789]00$/.test(n1) ? " Francs CFA" : " Francs CFA";
    centi= !n2 ? "" : " centime";
    pl=  n1>1 ? "" : "";
    pl2= n2>1 ? "" : "";
 
    // expression complète en toutes lettres
    return (ent + euro + pl + conj + deci + centi + pl2).replace(/\s+/g," ").replace("cent s E","cents E");
 
}
 
</script>
	</body>
	<script type="text/javascript">
	
	
			function Aff()
		{document.getElementById('edit1_0').value=document.getElementById('edit9').value;
		}
		
		
		
		function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit3').value = leselect;	
					}
				}
				xhr.open("POST","enmontant.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sel1 = document.getElementById('groupe');
				sh1=sel1.value;
				sh = sel.options[sel.selectedIndex].value;
				xhr.send("type="+sh+"&num="+sh1);
		}
		
	
	
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit4').value = leselect;	
					}
				}
				xhr.open("POST","endue.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sel1 = document.getElementById('groupe');
				sh1=sel1.value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("type="+sh+"&num="+sh1);
		}
		
		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit9').value = leselect;	
					}
				}
				xhr.open("POST","montantdue.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit6');
				sh2=sel.options[sel.selectedIndex].value;
				sel1 = document.getElementById('ladate');
				sh1=sel1.value;
				sh_1 = document.getElementById('ladate2');
				sh = sh_1.value;
				xhr.send("nom="+sh2+"&date1="+sh1+"&date2="+sh);
		}		
		
		var momoElement = document.getElementById("groupe");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("blur", action, false);
		  momoElement.addEventListener("keyup", action, false);
		  momoElement.addEventListener("blur", action1, false);
		  momoElement.addEventListener("keyup", action1, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onblur", action);
		  momoElement.attachEvent("onkeyup", action);
		  momoElement.attachEvent("onblur", action1);
		  momoElement.attachEvent("onkeyup", action1);

		}			

		var momoElement2 = document.getElementById("edit6");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("blur", action2, false);
		  momoElement2.addEventListener("keyup", action2, false);
		  momoElement2.addEventListener("change", action2, false);
		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onblur", action2);
		  momoElement2.attachEvent("onkeyup", action2);
		  momoElement2.attachEvent("change", action2);
  
		}
		
		
		function changer()
		{
			if (document.getElementById("edit9").value!='') 
			{
				document.getElementById("t").value=parseInt(document.getElementById("edit9").value); 
			}
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