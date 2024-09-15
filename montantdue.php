<?php
include 'connexion.php'; 
if(($_POST['nom'])&&($_POST['date1'])&&($_POST['date2']))
{	mysql_query("SET NAMES 'utf8' ");
	$sql2=mysql_query("SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
	view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.tva,compte.ttc_fixe, compte.taxe,compte.typeoccup, compte.ttc, fiche2.datarriv,compte.nuite,compte.np
	FROM client, fiche2, chambre, compte, view_client
	WHERE fiche2.numcli_1 = client.numcli
	AND fiche2.numcli_2 = view_client.numcli
	AND fiche2.codegrpe = '".$_POST['nom']."'
	AND chambre.numch = compte.numch
	AND compte.numfiche = fiche2.numfiche
	AND fiche2.etatsortie = 'NON'
	LIMIT 0 , 30" );
		$som1=0;$som2=0;$i=1;
  		while($row=mysql_fetch_array($sql2))
			{  $nomch=$row['nomch'];  
				$tarif=$row['tarif']; 
                $type=$row['typeoccup'];
				$n=(int)(strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400;
				$dat=(date('H')+1); 
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;}  $n=(int)$n;
				$mt=$row['ttc_fixe']*$n;
				$mt1=$row['ttc_fixe']*$row['np'];
			$som1=$som1+$mt;
			$som2=$som2+$mt1;
			$i++;
			}			
	//$query_Recordset1 = "select view_fiche2.numfiche AS numero,compte.somme as somme,view_fiche2.codegrpe as codegrpe,client.adresse AS adresse,client.nomcli AS nom,client.prenomcli AS prenoms,chambre.nomch AS nomch, view_fiche2.datarriv AS Arrivee,view_fiche2.datsortie AS Sortie,
	//compte.due AS due from view_fiche2,compte,client,chambre WHERE view_fiche2.numfiche=compte.numfiche AND etatsortie='OUI' AND view_fiche2.numcli=client.numcli and view_fiche2.codegrpe = '".$_POST['nom']."' AND chambre.numch=compte.numch AND compte.due>0";
	
	$query_Recordset1 = "select sum(compte.due) AS due FROM  view_fiche2,compte,client,chambre WHERE view_fiche2.numfiche=compte.numfiche AND etatsortie='OUI' AND view_fiche2.numcli=client.numcli and view_fiche2.codegrpe = '".$_POST['nom']."' AND chambre.numch=compte.numch AND compte.due>0";
	$Recordset_2 = mysql_query($query_Recordset1);
		while($row=mysql_fetch_array($Recordset_2))
		{ $due=$row['due']; 
		}
	echo $som1-$som2;
}
?>