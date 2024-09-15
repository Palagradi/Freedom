<?php
@require('../connexion.php');
$ecrire2=fopen('facture.txt',"w");
$sql2=mysql_query("SELECT num1,num2,nom1,nom2,prenom1,prenom2,nomch,tarif,np,typeoccup,ttc_fixe,datarriv FROM view_temporaire");
$data="";
 		while($row=mysql_fetch_array($sql2))
			{//$pdf->SetFont('Arial','I',10);
			  if($row['num1']!=$row['num2'])
			   {$numcli=$row['num1']." | ".$row['num2'];
			   $client=$row['nom1']." ".$row['prenom1']." |"." ".$row['nom2']." ".$row['prenom2'];}
			  else
				{ $numcli=$row['num1'];
				  $client=$row['nom1']." ".$row['prenom1'];
				 }			 
				  $nomch=$row['nomch'];  
				 // $tarif=$row['ttc_fixe'];  
				  $np=$row['np'];
				  $type=$row['typeoccup'];
			$n=(strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400;
				$dat=(date('H')+1); 
				settype($dat,"integer");
				if ($dat<12){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;}			  
			$nuite=$n;  $n_p=$n-$np; 
			$tva=round(0.18*$tarif*$n_p,4);
			if($type=='double')
			$taxe=2000*$n;
			else
			$taxe=1000*$n;
			$montant=$tarif*$n_p;
          //else $n_p=$np-$n;			 
$data=$numcli.';'.$client.';'.$nomch.';'.$n.';'.$row['ttc_fixe'].';'.$tva.';'.$taxe.';'.$montant."\n";
$ecrire2=fopen('facture.txt',"a+");
fputs($ecrire2,$data);
echo $data;
}
?>