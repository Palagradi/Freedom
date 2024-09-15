
	<td> Taux TVA : </td>
	<td> 
		<select name='combo6' id='combo6' onchange='Aff2();' style='width:165px;font-family:sans-serif;font-size:80%;'>
			<option value=''> </option>
				<?php
/* 					$res=mysql_query('SELECT * FROM tva '); 
					while ($ret=mysql_fetch_array($res)) 
						{
							echo '<option value="'.$ret[0].'">';
							echo 100* $ret[0]."%";
							echo '</option>' ; 
						} */
				$pourcent=100*$TvaD;	
				echo "<option value='".$TvaD."'>".$pourcent."%</option>";		
				?>
		</select>
	</td>
	<td>&nbsp; &nbsp; TVA : </td>
	<td><input type='text' name='edit29' id='edit29' readonly <?php if(!empty($tarifrc)&&(empty($numfiche_1))) {echo "value='";
	//$tva=round($tvaD*$tarifrc*$_SESSION['Nuite'],4); 	
	$tva=$tvaD*$tarifrc*$_SESSION['Nuite'];  echo $tva; 
	echo"'";} if(!empty($numfiche_1)) {echo "value='"; echo 0; echo"'";}?>/> </td>
