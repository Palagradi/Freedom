<?php
include 'connexion.php'; 
if(($_POST['continent']))
{

			$sql=mysql_query("SELECT libpays FROM pays WHERE continent='".$_POST['continent']."'");
			//$ret1=mysql_fetch_array($s);
	  		while($ret1=mysql_fetch_array($sql))
			{ $pays=$ret1['libpays ']; 
             }	
			 $pays=1;
		   echo "<option value='1'> ".$pays; echo"</option>";

}
?>