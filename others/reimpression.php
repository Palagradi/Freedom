<?php	
	//session_start(); 
	//ob_start();
	//include ('../config.php'); 
	$numrecu=!empty($_GET['numrecu'])?$_GET['numrecu']:NULL;$num_facture=!empty($_GET['num_facture'])?$_GET['num_facture']:NULL;
/* 	mysqli_query($con,"SET NAMES 'utf8'");	
	$sql=mysqli_query($con,"SELECT * FROM reeditionfacture2,reedition_facture WHERE reedition_facture.numrecu=reeditionfacture2.numrecu AND reedition_facture.date_emission>='2014-08-01' AND reedition_facture.date_emission<='2014-03-18'");
	while($row=mysqli_fetch_array($sql))
		{ $numrecu=$row['numrecu']; 
		$sql1=mysqli_query($con,"UPDATE numrecu SET numrecu=numrecu-100 WHERE reedition_facture.numrecu='$numrecu'");
		$sql2=mysqli_query($con,"UPDATE numrecu SET numrecu=numrecu-100 WHERE reeditionfacture2.numrecu='$numrecu'");
				//echo "UPDATE numrecu SET numrecu=numrecu-100 WHERE reedition_facture.numrecu='$numrecu'";
		} */
		//$sql=mysqli_query($con,"UPDATE numrecu SET numrecu=numrecu-100 WHERE reedition_facture.numrecu=reeditionfacture2.numrecu AND reedition_facture.date_emission>='2014-08-01' AND reedition_facture.date_emission<='2014-03-18'");
		
	$query="SELECT reeditionfacture2.numfiche AS numfiche,date_emission,reedition_facture.nom_client AS nom_client,reedition_facture.num_facture AS num_facture,reedition_facture.du AS du,reedition_facture.au AS au,reedition_facture.montant_ttc AS montant_ttc,reedition_facture.somme_paye AS somme_paye,chambre.nomch,reeditionfacture2.tarif,reeditionfacture2.nuite,reeditionfacture2.montant,reeditionfacture2.occupation,reedition_facture.Remise FROM reedition_facture, reeditionfacture2,chambre WHERE chambre.numch=reeditionfacture2.designation AND reedition_facture.num_facture=reeditionfacture2.numrecu AND reedition_facture.num_facture='".$numrecu."'";
	$sql2=mysqli_query($con,$query);
		$data="";
 		while($row=mysqli_fetch_array($sql2))
			{ //echo $row['num_facture'];
			  $_SESSION['initial_fiche']=$row['num_facture'];
			  $_SESSION['groupe1']=$row['nom_client'];  $_SESSION['debut']=$row['du']; $_SESSION['fin']=$row['au'];
			  $_SESSION['montant']=$row['montant_ttc']; $_SESSION['date_emission']=$row['date_emission'];
			  $_SESSION['avanceA']=$row['somme_paye']; $numfiche=$row['numfiche']; $_SESSION['remise']=$row['Remise'];
			  
	    $sql_2=mysqli_query($con,"SELECT numfiche as numfiche_1 FROM  exonerer_tva WHERE numfiche='$numfiche'");
 		while($row_2=mysqli_fetch_array($sql_2))
			{ $numfiche_1=$row_2['numfiche_1'];  $_SESSION['exonorer_tva']==1;
			}
		//if(empty($numfiche_1))
		//{
		$sql_2=mysqli_query($con,"SELECT numfiche as numfiche_1 FROM  exonerer_aib WHERE numfiche='$numfiche'");
 		while($row_2=mysqli_fetch_array($sql_2))
			{ $numfiche_2=$row_2['numfiche_1'];  $_SESSION['exonerer_AIB']=1;
			}
		//}
		//echo "SELECT numfiche as numfiche_1 FROM  `exonerer_tva` WHERE numfiche='$numfiche'";
		//echo "<br/>SELECT numfiche as numfiche_1 FROM  `exonerer_tva` WHERE numfiche='$numfiche'";
//echo "SELECT client.numcli AS num1, view_client.numcli AS num2, client.nomcli AS nom1, view_client.nomcli AS nom2, client.prenomcli AS prenom1, view_client.prenomcli AS prenom2 FROM client, fiche1, view_client FROM client,fiche1 WHERE fiche1.numfiche='$numfiche' AND fiche1.numcli_1=client.numcli AND fiche1.numcli_2=view_client.numcli";	

echo $query="SELECT client.numcli AS num1, view_client.numcli AS num2, client.nomcli AS nom1, view_client.nomcli AS nom2, client.prenomcli AS prenom1, view_client.prenomcli AS prenom2 FROM client, fiche1, view_client WHERE fiche1.numfiche='".$numfiche."' AND fiche1.numcli_1=client.numcli AND fiche1.numcli_2=view_client.numcli";	
	  
			  $sql=mysqli_query($con,$query);
				while($row1=mysqli_fetch_array($sql))
				{if($row1['num1']!=$row1['num2']) 
				   {echo $numcli=$row1['num1']." | ".$row1['num2'];
					echo $client=substr(strtoupper($row1['nom1'])." ".strtoupper($row1['prenom1'])." |"." ".strtoupper($row1['nom2'])." ".strtoupper($$row1['prenom2']),0,35);    //if(!empty($row1['codegrpe']))  $_SESSION['client']=$row1['codegrpe'];
				   }
				  else
					{ echo $numcli=$row1['num1'];
					  echo $client=strtoupper($row1['nom1'])." ".strtoupper($row1['prenom1']); if(!isset($_SESSION['client'])) $_SESSION['client']=$client;
					 }	
				} //unset($_SESSION['groupe1']);		$_SESSION['client']=12;		 
			  $nomch=$row['nomch']; 
			  $nuite=$row['nuite'];				  
			  //$np=$row['np'];
			  $occupation=$row['occupation'];
			  $montant_ht=$nuite*$row['tarif'];
			  $tarif=$row['tarif'];
			  if(!empty($numfiche_2))
			  $tarif=$tarif-$tarif*0.01;
			  
/* 			if(($typeoccup!='individuelle')||($etat_taxe=1)) $taxe*=$etat_taxe;	
			$taxe=$nuite*1000;
			if(($occupation=='individuelle')||($etat_taxe=1))
			{
			}else
				$taxe*=2; */
			if($tarif<=20000) $taxe = 500;
			else if(($tarif>20000) && ($tarif<=100000))	$taxe = 1500;
			else $taxe = 2500;	
			
			$tva=0.18*($montant_ht+$taxe);
			$aib=0.01*$montant_ht;
			$nomch=$row['nomch'];	
			$montant=$montant_ht+$taxe;			  
			  //$montant=$row['montant'];

			if((empty($numfiche_1)))
				$montant+=$tva;
			  //$type=$row['type'];
			if((!empty($numfiche_2)))
				$montant-=$aib;
			  $nomch=$row['nomch'];
			
			
			$ecrire=fopen('txt/facture.txt',"w");			
			
			if((empty($numfiche_1))&&(empty($numfiche_2)))
				$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$tva.';'.$taxe.';'.$montant."\n";
			else if((!empty($numfiche_1))&&(empty($numfiche_2)))
				$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$taxe.';'.$montant."\n";
			else if((!empty($numfiche_1))&&(!empty($numfiche_2)))
				$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$aib.';'.$taxe.';'.$montant."\n";
			else
				$data.=$numcli.';'.$client.';'.$nomch.';'.$nuite.';'.$montant_ht.';'.$tva.';'.$aib.';'.$taxe.';'.$montant."\n";
			$ecrire2=fopen('txt/facture.txt',"a+");
			fputs($ecrire2,$data);
			}
		//echo $_SESSION['client']=12;		
		
		
/*  		if((empty($numfiche_1))&&(empty($numfiche_2)))
			header('location:Facture.php?d=1');
		else if((!empty($numfiche_1))&&(!empty($numfiche_2)))
			header('location:facture_de_groupe3.php?d=1');
		else if((empty($numfiche_1))&&(!empty($numfiche_2)))
			header('location:facture_de_groupe2.php?d=1');	
		else	
			header('location:facture_de_groupe1.php?d=1');  */ 
		
		header('location:Facture.php');	
?>