<?php
require("config.php");

 mysqli_query($con,"SET NAMES 'utf8'");
//recherche des résultats dans la base de données
$result =   mysqli_query($con, 'SELECT *
                          FROM boisson
                          WHERE  designation LIKE \'' . safe( $_GET['q'] ) . '%\' OR Categorie LIKE \'' . safe( $_GET['q'] ) . '%\' OR Conditionne LIKE \'' . safe( $_GET['q'] ) . '%\' OR Prix LIKE \'' . safe( $_GET['q'] ) . '%\'
                          LIMIT 0,20' );

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

			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?&trie=1' style='text-decoration:none;color:white;' title="">Catégorie menu<span style='font-size:0.8em;'></span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=2' style='text-decoration:none;color:white;' title=''>Catégorie plat<span style='font-size:0.8em;'></span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=3' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'></span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=4' style='text-decoration:none;color:white;' title=''>Nbre pers.<span style='font-size:0.8em;'></span></a></td>
			<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?&trie=5' style='text-decoration:none;color:white;' title=''>Prix de vente<span style='font-size:0.8em;'></span></a></td>
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

    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->CategorieMenu; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->CategoriePlat; ?></td>
				<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->designation; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->NbrePers; ?></td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->prix; ?></td>
				<?php
				echo "<td align='center' style=''> <a class='info' href='frameFood.php?fd=".$data->designation."&NbrePers=".$data->NbrePers."&prix=".$data->prix."'  style='color:#FC7F3C;'><span style='color:#FC7F3C;'>Ajouter</span><i style='font-size:1.4em;' class='fas fa-cart-plus'></i></a></td>";
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
