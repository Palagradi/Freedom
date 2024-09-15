<?php
require("config.php");
//connexion à la base de données
define('DB_NAME', 'base');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

//$link   =   mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
//mysql_select_db( DB_NAME , $link );

//$groupe=$_SESSION['groupeA']; $fiche=$_SESSION['fiche'];$fiche1=$_SESSION['fiche1'];	$sal=$_SESSION['sal'];$numresch=$_SESSION['numresch'];

 mysqli_query($con,"SET NAMES 'utf8'");
//recherche des résultats dans la base de données
$result =   mysqli_query($con, 'SELECT *
                          FROM boissonb
                          WHERE  designation LIKE \'' . safe( $_GET['q'] ) . '%\' OR Categorie LIKE \'' . safe( $_GET['q'] ) . '%\' OR Prix LIKE \'' . safe( $_GET['q'] ) . '%\' OR Qte LIKE \'' . safe( $_GET['q'] ) . '%\' OR Conditionne LIKE \'' . safe( $_GET['q'] ) . '%\'
                          ORDER BY numero2 LIMIT 0,20' );

// affichage d'un message "pas de résultats"
if( mysqli_num_rows( $result ) == 0 )
{ 
?>
    <h4 style="text-align:center; margin:10px 0;">Pas de r&eacute;sultats pour cette recherche</h4>
<?php
}
else
{
	echo "<table align='center' width='60%' border='0' cellspacing='0' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
		"?>

			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">N° d'Enrég.<span style='font-size:0.8em;'></span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">Catégorie<span style='font-size:0.8em;'>Trier par Catégorie</span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?menuParent=Restauration&trie=2' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'>Désignation</span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?menuParent=Restauration&trie=3' style='text-decoration:none;color:white;' title=''>Conditionnement<span style='font-size:0.8em;'>Conditionnement</span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?menuParent=Restauration&trie=4' style='text-decoration:none;color:white;' title=''>Qté indiquée<span style='font-size:0.8em;'>Quantité</span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?menuParent=Restauration&trie=4' style='text-decoration:none;color:white;' title=''>Qté stock<span style='font-size:0.8em;'></span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Prix de vente<span style='font-size:0.8em;'>Prix</span></a></td>

		<?php echo "</tr>";

	$cpteur=1;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    {
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";
			}
	$nbre=$data->numero2;		
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				 <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
				 <td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Categorie; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->designation; ?></td>
				<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Conditionne; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data->Qte; ?></td>
				<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Qte_Stock; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $data->Prix; echo "&nbsp;<span style='font-size:0.7em;'>".$devise."</span>";?></td>
				<?php
				//echo "<td align='center' style=''> <a class='info' href=''  style='color:#FC7F3C;'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.8em;'>Modifier</span></a>";
				//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='info' href=''  style='color:#B83A1B;'><i class='fa fa-trash-alt'</i><span style='color:#B83A1B;font-size:0.8em;'>Supprimer</span></a></td>";
				?>
				
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
