<?php
require("../config.php");
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
                          FROM boisson
                          WHERE  Depot = \'1\' AND (Categorie LIKE \'%' . safe( $_GET['q'] ) . '%\'  OR designation LIKE \'%' . safe( $_GET['q'] ) . '%\' OR Conditionne LIKE \'%' . safe( $_GET['q'] ) . '%\' OR prix LIKE \'%' . safe( $_GET['q'] ) . '%\' OR Qte LIKE \'%' . safe( $_GET['q'] ) . '%\')
                          ORDER BY numero2 LIMIT 0,20' );

// affichage d'un message "pas de résultats"
if( mysqli_num_rows( $result ) == 0 )
{
?>
    <h5 style="text-align:center; margin:10px 0;color:teal;">Aucune boisson ne correspond à cette recherche</h5>
<?php
}
else
{
	echo "<table align='center' width='80%' border='0' cellspacing='0' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>";?>

      <td style="border-right: 2px solid #ffffff" align="center" >✔</td>
  		<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=1' style='text-decoration:none;color:white;' title="">

  			<input checked type='checkbox' name='1' id='1' value='<?php echo 1; ?>' >
  			<label for='1' style=''>N° d'Enrég.</label><span style='font-size:0.8em;'></span></a></td>
  			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=1' style='text-decoration:none;color:white;' title="">
  			<input checked type='checkbox' name='2' id='2' value='<?php echo 2;?>' ><label for='2' style=''>Catégorie</label>
  			<span style='font-size:0.8em;'></span></a></td>
  			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=2' style='text-decoration:none;color:white;' title=''><input checked type='checkbox' name='3' id='3' value='3' ><label for='3' style=''>Désignation</label><span style='font-size:0.8em;'></span></a></td>
  			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=3' style='text-decoration:none;color:white;' title=''><input checked type='checkbox' name='5' id='5' value='5' ><label for='5' style=''>Conditionnement</label><span style='font-size:0.8em;'></span></a></td>
  			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=4' style='text-decoration:none;color:white;' title=''><input checked type='checkbox' name='6' id='6' value='6' ><label for='6' style=''>Quantité <br/>indiquée (Qi)</label> <span style='font-size:0.8em;'></span></a></td>
  			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=5' style='text-decoration:none;color:white;' title=''><input checked type='checkbox' name='7' id='7' value='7' ><label for='7' style=''>Quantité <br/>en Stock (Qs)</label> <span style='font-size:0.8em;'></span></a></td>
  			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&trie=6' style='text-decoration:none;color:white;' title=''><input checked type='checkbox' name='8' id='8' value='8' ><label for='8' style=''>Prix de vente</label> <span style='font-size:0.8em;'></span></a></td>
  			<td align="center" >Actions</td>

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
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;  $Nbre=$data->numero2;
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>

        <?php echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <a class='info2' href='DpInterne.php?menuParent=".$_SESSION['menuParenT']."&ap=".$Nbre."'  style='color:red;'><i class='fas fa-coffee fa-xs'></i><span style='color:red;font-size:1em;'>Approvisionner<br/> le Bar</span></a></td>";?>
			  <td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Categorie; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->designation ; ?></td>
				<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Conditionne; ?></td>
				<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->Qte; ?></td>
				<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->Qte_Stock; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' class='info1' ><?php echo $data->Prix." <small>".substr($devise,0,1); echo "</small>&nbsp;<span style='font-size:0.7em;'>".$data->Prix." ".$devise."</span>"; ?></a></td>
				<?php
				echo "<td align='center' style=''> <a class='info' href='DpInterne.php?menuParent=Restauration&update=".$Nbre."'  style='color:#FC7F3C;'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.8em;'>Modifier</span></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='info' href='DpInterne.php?menuParent=Restauration&delete=".$Nbre."'  style='color:#B83A1B;'><i class='fa fa-trash-alt'</i><span style='color:#B83A1B;font-size:0.8em;'>Supprimer</span></a></td>";
				?>

	</tr>

    <?php
    }
}

/*****
fonctions
*****/
function safe($var)
{	require("../connexion.php");
	$var = mysqli_real_escape_string($con,$var);
	$var = addcslashes($var, '%_');
	$var = trim($var);
	$var = htmlspecialchars($var);
	return $var;
}
?>
