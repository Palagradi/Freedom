<?php
require("config.php");
$_SESSION['Val']=$_GET['QteAj'];
 mysqli_query($con,"SET NAMES 'utf8'");
$result =   mysqli_query($con, 'DELETE FROM  QteLigneT' );
$result =   mysqli_query($con, 'INSERT INTO QteLigneT SET Qte = \'' . safe( $_GET['QteAj'] ) . '\' ' );

// affichage d'un message "pas de résultats"
if( isset( $result ))
{ //echo $lool=12;
?>
    <h4 style="text-align:center; margin:10px 0;"> <?php 
                            ?> </h4>
<?php
}
else
{ //echo "<input type='text' value='"; if(isset($Qte)) echo $Qte; echo "' id='Qte' />   <input type='text' value='"; if(isset($Qte_Stock)) echo $Qte_Stock; echo "' id='Qte_Stock' />";
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
