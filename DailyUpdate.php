<?php
require("connexion.php");
$result=mysqli_query($con,"SELECT * FROM plat,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu");
while($data = mysqli_fetch_object($result))
{
	if (isset($data->NbreJP) && isset($data->NbreJ) && isset($Jour_actuelp) && isset($data->Begin) && isset($data->End)) {
	if (($data->NbreJP > 0) && ($data->NbreJ <= 0) && ($Jour_actuelp >= $data->Begin) && ($Jour_actuelp <= $data->End)) {
		$rek="UPDATE plat SET NbreJ='".$data->NbreJP."' WHERE numero='".$data->numero."' ";
		$query = mysqli_query($con,$rek) or die (mysqli_error($con));
		}
	} 
}
$sql="SELECT designation,TypeMenu,catPlat,plat.numero,NbreJ,NbreC,Nbre,Begin,NbreJP,End,libellePortion,NbreJJp,NbreCp,Nbrep,Beginp,NbreJPp,Endp,portion.id AS portion_id FROM plat,portion,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu AND plat.numero = portion.numPlat";
$result=mysqli_query($con,$sql);
while($data = mysqli_fetch_object($result))
{
	if (isset($data->NbreJPp) && isset($data->NbreJJp) && isset($Jour_actuelp) && isset($data->Begin) && isset($data->End))
		{
		if (($data->NbreJPp > 0) && ($data->NbreJJp <= 0) && ($Jour_actuelp >= $data->Begin) && ($Jour_actuelp <= $data->End))
			{
			$rek="UPDATE portion SET NbreJJp='".$data->NbreJPp."' WHERE id='".$data->portion_id."' ";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con));
			}
			
		if(($data->NbreJPp == 0)&& ($data->NbreJJp <= 0)) {
			if (isset($data->NbreJP) && isset($data->NbreJ) && isset($Jour_actuelp) && isset($data->Begin) && isset($data->End)) {
			//if (($data->NbreJP > 0) && ($data->NbreJ <= 0) && ($Jour_actuelp >= $data->Begin) && ($Jour_actuelp <= $data->End)) {
				$rek="UPDATE portion SET NbreJJp='".$data->NbreJP."' WHERE id='".$data->portion_id."' ";
				$query = mysqli_query($con,$rek) or die (mysqli_error($con));
				//}
/* 			if (($data->NbreJP == 0) && ($data->NbreJ > 0) && ($Jour_actuelp >= $data->Begin) && ($Jour_actuelp <= $data->End)) {
				$rek="UPDATE portion SET NbreJJp='".$data->NbreJ."',Nbrep='".$data->NbreJ."' WHERE id='".$data->portion_id."' ";
				$query = mysqli_query($con,$rek) or die (mysqli_error($con));
				} */
			}
		}			
		}
}
 
