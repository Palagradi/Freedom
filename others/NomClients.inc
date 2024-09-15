<?php 
	 $sql="SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
	view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.somme AS somme
	FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
	WHERE mensuel_fiche1.numcli_1 = client.numcli
	AND mensuel_fiche1.numcli_2 = view_client.numcli
	AND mensuel_fiche1.numfiche LIKE '".$_SESSION['num']."'
	AND chambre.numch = mensuel_compte.numch
	AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
	AND mensuel_fiche1.etatsortie = 'NON'";
	
	$result=mysqli_query($con,$sql);
/* 	$data=""; $TotalTva=0;$TotalTaxe=0; $i=0;
	if (!$result) {
		printf("Error: %s\n", mysqli_error($con));
		exit();
	} */
	while($row=mysqli_fetch_array($result))
	{ if($row['num1']!=$row['num2'])
	   {//$numcli=substr($row['num1'],0,5)." | ".substr($row['num2'],0,5);
	   $client=strtoupper($row['nom1'])." ".strtoupper($row['prenom1'])." |"." ".strtoupper($row['nom2'])." ".strtoupper($row['prenom2']);}
	}