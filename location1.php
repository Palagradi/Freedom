<?php 
	//$A=mysql_query("SELECT num_fact  FROM configuration_facture");
	//$data=mysql_fetch_assoc($A);
	//echo $num_fact=$data['num_fact'];
	$_SESSION['update']=1;
	$s=mysql_query("SELECT compte1.somme,compte1.ttc,compte1.ttc_fixe,compte1.np,compte1.tarif AS tarif1,nomcli,prenomcli,codesalle,datarriv FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche and location.numfiche='".$_POST['edit2']."'");
	while($ez=mysql_fetch_array($s))
	{$_SESSION['tarif1']=$ez['tarif1'];
	$_SESSION['montant_ttc']=$ez['ttc'];
	$somme=$ez['somme']+ $_POST['edit5']; 
	$due=$ez['ttc']- $somme; 
	$_SESSION['datarriv']=$ez['datarriv'];
	$_SESSION['datdep']=$ez['datdep'];
	$np=$_POST['edit5']/$ez['ttc_fixe'];
	$_SESSION['np']=$np;					
	$_SESSION['edit2']=$_POST['edit2'];
	$_SESSION['ttc_fixe']=$ez['ttc_fixe'];
	$_SESSION['codesalle']=$ez['codesalle'];
	$np1=$ez['np']+$np;
	$_SESSION['nomclient']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
	}
	$de=mysql_query("UPDATE compte1 SET somme='$somme', due='$due'  WHERE numfiche='".$_POST['edit2']."'");
	$s1=mysql_query("SELECT numsalle,tarif,np,ttax,typeoccup,ttc_fixe,tva FROM compte1 WHERE numfiche='".$_POST['edit2']."'");
	$ez1=mysql_fetch_array($s1);
	$_SESSION['nuit']=$ez1['np'];
	if($ez1['typeoccup']=='double')
	$_SESSION['ttax']=2000; else $_SESSION['ttax']=1000;
	$_SESSION['tva']=round(0.18*$_POST['edit5'],4);
	if(empty($_POST['MTtotal']))
		$_SESSION['somme_paye']=$_POST['edit5'];
	else
		$_SESSION['somme_paye']=$_POST['MTtotal'];
	$_SESSION['somme_due']=$_POST['edit3'];
	$_SESSION['nuite']=$np;   
	$numsalle=$ez1['numsalle'];
	$typeoccup=$ez1['typeoccup'];
	$tarif=$ez1['tarif'];	
	if($_POST['edit5']!='')
	$np=$_POST['edit5']/$ez1['ttc_fixe'];	
	$ttc_fixe=$ez1['ttc_fixe'];	

	$s=mysql_query("SELECT typesalle FROM salle WHERE numsalle='".$numsalle."'");
	while($ez=mysql_fetch_array($s))
	{$typesalle=$ez['typesalle'];
	}
	
	if ($de)
	{  	$en=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Encaissement salle','$typesalle','RAS','$tarif','$ttc_fixe','$np')");
		$rit=mysql_query('UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$_POST['edit5'].'" WHERE login="'.$_SESSION['login'].'"'); 
		echo "<script language='javascript'> alert('Encaissement fait avec succès.'); </script>"; 
		//$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
		$res=mysql_query("DROP TABLE `table_tempon`");	
		header('location:reufiche_sal.php');
	}
?>