<tr>
	<td colspan="2" style="padding-left:100px;"> Type chambre :&nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
	<td colspan="2">&nbsp;
	<select name="type" style="font-family:sans-serif;font-size:80%;border:1px solid black;width:250px;" >
		<?php
				 if(!empty($NomType)) { echo "<option value='".$NomType."'>";  echo $NomType;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
				$req = mysqli_query($con,"SELECT * FROM typechambre") or die (mysqli_error($con));	
				while($data=mysqli_fetch_array($req))
				{    
					echo" <option value ='".$data['NomType']."'> ".ucfirst($data['NomType'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
				}
				//mysql_free_result($req);
				//mysql_close();
		?>
	</select>
	<a class='info' href="Tchambre.php"style='color:#B83A1B;' onclick="window.open(this.href, 'Titre','target=_parent, height=400, width=auto'); return false"> <span style='font-size:0.8em;font-style:normal;'>Ajouter un Nouveau Type</span>	<i class='fa fa-plus-square' aria-hidden='true'></i></a>
	</td>
</tr>		