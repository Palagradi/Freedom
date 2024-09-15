<?php
require("config.php");
//connexion à la base de données
define('DB_NAME', 'dbmecef');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

//$link   =   mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
//mysql_select_db( DB_NAME , $link );

$groupe=!empty($_SESSION['groupeA'])?$_SESSION['groupeA']:NULL; $fiche=!empty($_SESSION['fiche'])?$_SESSION['fiche']:NULL;$fiche1=!empty($_SESSION['fiche1'])?$_SESSION['fiche1']:NULL;	$sal=!empty($_SESSION['sal'])?$_SESSION['sal']:NULL;$numresch=!empty($_SESSION['numresch'])?$_SESSION['numresch']:NULL;

 mysqli_query($con,"SET NAMES 'utf8'");
//recherche des résultats dans la base de données
$result =   mysqli_query($con, 'SELECT *
                          FROM client
                          WHERE  numcli <> "" AND nomcli LIKE \'' . safe( $_GET['q'] ) . '%\' OR prenomcli LIKE \'' . safe( $_GET['q'] ) . '%\'
                          LIMIT 0,20' );

// affichage d'un message "pas de résultats"
if( mysqli_num_rows( $result ) == 0 )
{
?>
    <h3 style="text-align:center; margin:10px 0;">Pas de r&eacute;sultats pour cette recherche</h3>
<?php
}
else
{ 			
		echo "		<h3 style='text-align:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#444739;'> LISTE DE CLIENTS RECHERCHES </h3>
		<table align='center' width='' border='0' cellspacing='0' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>

			<tr  style=' background-color:#66858D;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>
			<a class='info' href='#' style='color:white;'>Info<span style='font-size:0.8em;'>Informations complémentaires</span></a>
			</td>"?>

						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=1' style='text-decoration:none;color:white;' title="">Num&eacute;ro<span style='font-size:0.8em;'>Trier par Numéro</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=2' style='text-decoration:none;color:white;' title=''>Nom et Pr&eacute;noms<span style='font-size:0.8em;'>Trier par Nom et Prénoms</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=3' style='text-decoration:none;color:white;' title=''>Sexe<span style='font-size:0.8em;'>Trier par Sexe</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=4' style='text-decoration:none;color:white;' title=''>Date de naissance<span style='font-size:0.8em;'>Trier par Date de naissance</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=5' style='text-decoration:none;color:white;' title=''>Lieu de naissance<span style='font-size:0.8em;'>Trier par Lieu de naissance</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=6' style='text-decoration:none;color:white;' title=''>Type de pi&egrave;ce<span style='font-size:0.8em;'>Trier par Type de pièce</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=7' style='text-decoration:none;color:white;' title=''>N° de la pi&egrave;ce<span style='font-size:0.8em;'>Trier par N° de la pièce</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=8' style='text-decoration:none;color:white;' title=''>D&eacute;livr&eacute; le<span style='font-size:0.8em;'>Trier par Date de livraison</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=9' style='text-decoration:none;color:white;' title=''>Lieu de délivrance<span style='font-size:0.8em;'>Trier par Lieu de délivrance</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=10' style='text-decoration:none;color:white;' title=''>D&eacute;livr&eacute; par<span style='font-size:0.8em;'>Trier par institution de livraison</span></a></td>
						<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='selection_client.php?
						<?php if(!empty($_GET['fiche'])) echo 'fiche='.$_GET['fiche']; if(!empty($_GET['groupe'])) echo 'groupe='.$_GET['groupe'];
						if(!empty($_GET['numresch'])) echo 'numresch='.$_GET['numresch'];?>&trie=11' style='text-decoration:none;color:white;' title="">Pays d'origine<span style='font-size:0.8em;'>Trier par Pays d'origine</span></a></td>
						<td align="center" >Actions</td>


		<?php echo "</tr>";

	$cpteur=1;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    {	if($cpteur == 1)
								{
			$cpteur = 0;
			$bgcouleur = "#acbfc5";
		}
		else
		{
			$cpteur = 1;
			$bgcouleur = "#dfeef3";
		}

		$query_Recordset1 = "SELECT  max(datarriv) AS date FROM fiche1 WHERE numcli_1='".$data->numcli."'";
		$queryA=mysqli_query($con,$query_Recordset1);$resultA=mysqli_fetch_assoc($queryA);$Dvisite=substr($resultA['date'],8,2).'-'.substr($resultA['date'],5,2).'-'.substr($resultA['date'],0,4);
		if(empty($resultA['date']))
		{	$query_Recordset1 = "SELECT  max(datarriv) AS date FROM fiche1 WHERE numcli_2='".$data->numcli."'";
			$queryA=mysqli_query($con,$query_Recordset1);$resultA=mysqli_fetch_assoc($queryA);$Dvisite=substr($resultA['date'],8,2).'-'.substr($resultA['date'],5,2).'-'.substr($resultA['date'],0,4);
		}
		$queryRecordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  numcli_1='".$data->numcli."'";
		$queryB=mysqli_query($con,$queryRecordset1);$resultB=mysqli_fetch_assoc($queryB);$nbre=$resultB['nbre'];
		if($nbre<=0)
			 {	$query_Recordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$data->numcli."'";
				$queryB=mysqli_query($con,$query_Recordset1);$resultB=mysqli_fetch_array($queryB); $nbre=$resultB['nbre'];
			 }
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
			 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> 	<a class='info' href='#'>
				<img src='logo/logo5.png' alt='' title='' width='16' height='16' border='0'><span style='color:maroon;margin-left:-5%;'>
				Nbre de visite:&nbsp; <?php echo $nbre; ?> | Dernière visite:&nbsp;<?php echo $Dvisite; ?><span style='color:red;margin-left:-5%;'>
				Catégorie de client:&nbsp; <?php echo $categorie  ?></span></span></a>
			</td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->numcli; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo utf8_encode($data->nomcli." ".$data->prenomcli); ?></td>
				<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->sexe; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->datnaiss; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->lieunaiss; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->typepiece; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->numiden; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->date_livrais; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->lieudeliv; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->institutiondeliv; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->pays; ?></td>
				<td align='center' style='border-top: 2px solid #ffffff'>

				<?php
        !empty($groupe)?$groupe=$groupe:NULL;  !empty($fiche)?$fiche=$fiche:NULL;  !empty($sal)?$sal=$sal:NULL;  !empty($fiche1)?$fiche1=$fiche1:NULL;
        if(($groupe==1)||($fiche==11))
				    $fiche="fiche_groupe2.php";
				if((!empty($_GET['numresch']))&& ($_GET['sal']!=2))
				    $fiche="info_reservation2.php";
				if(!empty($numresch)||($fiche==3))
				    $fiche="info_reservation.php";
				if(($fiche==1)||($fiche==5)||($fiche1==5))
				    $fiche="fiche.php";
				if($sal==1)
				    $fiche="FicheS.php";
				if($fiche==2)
				$fiche="fiche2.php";
        ?>

				<?php echo "<a class='info2' href='"; echo $fiche; echo"?menuParent=".$_SESSION['menuParenT']."&numcli=".$data->numcli; if(isset($_SESSION['numreserv'])) echo "&numreserv=".$_SESSION['numreserv'];  echo"'>
				<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'>
				<span style='font-size:0.9em;color:maroon;'>Ajouter le client</span></a>";
				?>
				</td>
	</tr>

    <?php
    }
}

/*****
fonctions
*****/
function safe($var)
{	require("connexion.php");
	$var = mysqli_real_escape_string($con,$var);
	$var = addcslashes($var, '%_');
	$var = trim($var);
	$var = htmlspecialchars($var);
	return $var;
}
?>
