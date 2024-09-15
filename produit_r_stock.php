<?php
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/mysql_table.php');


class PDF extends PDF_MySQL_Table
{
	function Header()
	{
		global $mydate;
		
				$this->SetFont('Arial','B',15);
		//Titre encadré
		$this->Cell(0,5,'ARCHEVECHE DE COTONOU ',0,1,'C');
		
						$this->SetFont('Arial','B',15);
		//Titre encadré
		$this->Cell(0,20,'CODIAM',0,1,'C');

		$this->Image('logo/codi.jpg',10,10,30,20);
		$this->SetFont('Arial','',10);
		$this->Cell(70);

		$dateAff = $mydate;
		$this->Cell(380,6,$sDateReturn=substr(date("Y-m-d"),8,2).'-'.substr(date("Y-m-d"),5,2).'-'.substr(date("Y-m-d"),0,4),0,0,'C');
		//Saut de ligne	
		$this->Ln(10);

		//Police Arial gras 15
		$this->SetFont('Arial','B',15);
		//Titre encadré
		$this->Cell(0,30,'LISTE DES DISPONIBILITES DES PRODUITS  ',0,1,'C');
	}

	function Footer()
	{
		//Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		$this->SetFont('Arial','B',10);
		$this->Cell(0,0,'-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,0,'L');
		//Saut de ligne	
		$this->Ln(3);
		$this->Cell(0,0,'                                        SYGHOC - CODIAM                                         Logiciel de gestion hotelliere',0,0,'L');

		//Police Arial italique 8
		$this->SetFont('Arial','I',8);	
		//Numéro et nombre de pages
		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
		
	}

}


$pdf = new PDF('L');
$pdf->Open();

@require('connexion.php');
//$connecter = new Connexion_2;
$pdf->AddPage();
		$sql2 ="select * from entree_sortie";
			$pdf->Table($sql2);
			$pdf->Ln(10);
			$pdf->AddCol('reference',40,'reference','L');
			$pdf->AddCol('designation',100,'designation','L');
			$pdf->AddCol('seuil',40,'seuil','L');
			$pdf->AddCol('quantite',50,'quantite','L');
			$pdf->AddCol('date_entree',50,'date_entree','L');
			$pdf->AddCol('date_modification',50,'date_modification','L');
			$prop=array('HeaderColor'=>array(255,150,100),
						'color1'=>array(210,245,255),
						'color2'=>array(255,255,210),
						'padding'=>2);

		//}
$pdf->Output();

?>
