<?php
session_start();
//if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
	//require('fpdf17/fpdf.php');
//else
	require('fpdf17/fpdf2.php');
@include('connexion.php');  include 'chiffre_to_lettre.php'; //include 'fpdf2/code128.php';
		
class PDF extends FPDF
{ 
	//if(isset($_GET['d'])&& ($_GET['d']==1)) $this->temporaire( "Duplicata" );
	function Header()
	{  	//Affiche le filigrane
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(255,192,203);
		//$this->RotatedText(35,190,'W a t e r m a r k   d e m o',45);
		
		//$this->temporaire( "Duplicata" );
	
	if($this->PageNo()==1)
	    {	
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//Titre encadré
		$this->SetTextColor(100,150,255);
		//$sDateReturn=substr(date("Y-m-d")).'-'.substr(date("Y-m-d")).'-'.substr(date("Y-m-d"));
		if(isset($_SESSION['nomHotel'])) $this->Cell(0,0,$_SESSION['nomHotel'],0,1,'');   
		//$this->Ln('0');
		$this->SetFont('Arial','I',10);
		$this->SetTextColor(0,0,0);
		if(empty($_SESSION['date_emission']))
		$this->Cell(0,0,'                            
		                                                                                                                                  Cotonou le, '.substr(date("Y-m-d"),8,2).'/'.substr(date("Y-m-d"),5,2).'/'.substr(date("Y-m-d"),0,4),0,1,'');
		else
				$this->Cell(0,0,'                            
		                                                                                                                                  Cotonou le, '.substr($_SESSION['date_emission'],8,2).'/'.substr($_SESSION['date_emission'],5,2).'/'.substr($_SESSION['date_emission'],0,4),0,1,'');$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(100,150,255);
		//Titre encadré
		$this->Cell(0,60,'              ',0,1,'');    //CODIAM
		
		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(0,0,0);
		

										
		//Titre encadré
		$this->Cell(0,0,"Facture N°: ".$_SESSION['initial_fiche'],0,1,'C');
		if(isset($_SESSION['logo'])) $this->Image($_SESSION['logo'],10,15,30,20);
		$this->SetFont('Arial','',10);
		
		$this->SetTextColor(0,0,0);
		$this->fact_dev( "Détails de la facture ", "" ); //$_SESSION['modulo']=0;//$_SESSION['avanceA']=0;
		
		
/* 		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addDate($_SESSION['remise']+$_SESSION['modulo']);  */   //Commentaire du 10.08.2020 06:52
		//if(isset($_SESSION['avanceA'])&& ($_SESSION['avanceA']>0))
			//$this->addDate($_SESSION['avanceA']); 
		//else
			//{
				//if(!isset($_SESSION['fiche']))
				//$this->addDate($_SESSION['avanceA']+$_SESSION['modulo']);  //SOMME REMISE = PAYEE
			// else 	
				$this->addDate($_SESSION['avanceA']); //origine : occup.php
		
			//}
		//if($_SESSION['Mtotal']<$_SESSION['avanceA']) $_SESSION['Mtotal']=$_SESSION['avanceA'] ;   Revoir ce commentaire !
		//if($_SESSION['Mtotal']<=$_SESSION['avanceA'])
			//$difference2 = abs($_SESSION['Mtotal']-$_SESSION['remise']);
			$difference = abs($_SESSION['Mtotal']-$_SESSION['avanceA']+$_SESSION['remise']);
		//if($_SESSION['Mtotal']<$_SESSION['avanceA'])
			if($difference<0)
			{$titre="ARRHES";  if($_SESSION['modulo']>0) $difference= $_SESSION['modulo'] ; //else $difference= abs($difference - $_SESSION['modulo']) ; 
		}
		else 
			$titre="RESTE A PAYER"; 
		
		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addClient($titre,abs($_SESSION['Mtotal']-$_SESSION['remise']));  //SOMME encaissee
		else
			$this->addClient($titre,$difference);  //SOMME encaissee
		
		if(($_SESSION['Mtotal']< $_SESSION['avanceA'])&&($_SESSION['modulo'] > 0))  $_SESSION['Mtotal'] = $_SESSION['avanceA'] - $_SESSION['modulo']; 
			
		$this->addPageNumber($_SESSION['Mtotal']);  // TOTAL TTC
		
		
		
		//$this->SetTextColor(0,0,0);
		//$this->addDate2( "Détails ");
		
		
		
		
		//$client=isset($_SESSION['groupe'])?$_SESSION['groupe']:$_SESSION['client'];
		$this->SetTextColor(0,0,0);
		$this->addReglement($_SESSION['client']);
		
		$this->SetTextColor(0,0,0);
		$this->addEcheance( "Hébergement");
		//$_SESSION['fin']="04-04-2014";
		$this->addNumTVA(  "Du"." ".$_SESSION['debut']." "."au"." ".$_SESSION['fin'] );
		$this->Ln('10');	
		}
		
	
		
	}
 	function temporaire( $texte )
	{
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(203,203,203);
		$this->Rotate(45,55,190);
		$this->Text(75,190,$texte);
		$this->Rotate(0);
		$this->SetTextColor(0,0,0);
	} 
	function RotatedText($x, $y, $txt, $angle)
	{
		//Rotation du texte autour de son origine
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}


	// Ajoute une remarque (en bas, a gauche)
		function addRemarque($remarqu,$remarque)
		{
			$this->SetFont( "Arial", "", 10);
			$length = $this->GetStringWidth( "Remarque : " . $remarque );
			$r1  = 10;
			$r2  = $r1 + $length;
			$y1  = $this->h - 45.5;
			$y2  = $y1+5;
			$this->SetXY( $r1 , $y1 );
			$this->Cell($length,4, $remarqu. $remarque);
		}
		
		
	function Footer()
	{ 
	
	//$this->SetLineWidth(0.1); 
	$this->Rect(5, 275, 200, 15, "D");
	        $this->SetXY( 1, 268 ); $this->SetFont('Arial','',7);
        $this->Cell( $this->GetPageWidth(), 7, 'Nous proposons pour votre confort des chambres spacieuses et entièrement équipées. L\'air conditionné étant bien entendu obligatoire. Sentez vous comme chez vous !' , 0, 0, 'C');
/* 
        $y1 = 270;
        //Positionnement en bas et tout centrer
        $this->SetXY( 1, $y1 ); $this->SetFont('Arial','B',10);
        $this->Cell( $this->GetPageWidth(), 5, "REF BANCAIRE : FR76 xxx - BIC : xxxx", 0, 0, 'C');

        $this->SetFont('Arial','',10);

        $this->SetXY( 1, $y1 + 4 );
        $this->Cell( $this->GetPageWidth(), 5, "NOM SOCIETE", 0, 0, 'C');

        $this->SetXY( 1, $y1 + 8 );
        $this->Cell( $this->GetPageWidth(), 5, "ADRESSE 1 + CP + VILLE", 0, 0, 'C');

        $this->SetXY( 1, $y1 + 12 );
        $this->Cell( $this->GetPageWidth(), 5, "Tel + Mail + SIRET", 0, 0, 'C');

        $this->SetXY( 1, $y1 + 16 );
        $this->Cell( $this->GetPageWidth(), 5, "Adresse web", 0, 0, 'C'); */

        // par page de 18 lignes
       // $num_page++; $limit_inf += 18; $limit_sup += 18;
	
//Positionnement à 1,5 cm du bas
		//$this->SetY(-15);
		 $this->SetXY( 1, 274 );
		$this->SetFont('Arial','B',15);
		$this->Cell(0,0,'',0,0,'L');
		//Police Arial italique 8
		$this->SetFillColor(200,220,255);
		$this->SetFont('Arial','I',10);	
		//Numéro et nombre de pages
		if(isset($_SESSION['nomHotel'])&& isset($_SESSION['footer1']))
			$this->Cell(-200,10,' '.$_SESSION['nomHotel'].' '.$_SESSION['footer1'] ,0,0,'C');
		if(isset($_SESSION['footer2']))
			$this->Cell(0,18,$_SESSION['footer2'],0,0,'C');
		$this->Cell(-200,25,'REPUBLIQUE DU BENIN ',0,0,'C');

//$this->addRemarque(" Signature",$_SESSION['chiffre_en_lettre']);

//$this->addCadreEurosFrancs("Détails de la facture",$_SESSION['montant'],$_SESSION['avanceA'],$_SESSION['montant']- $_SESSION['avanceA']);


    $this->SetTextColor(128);
    // Numéro de page
    //$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
	
	}
	
	// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau coloré
function FancyTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(193,229,252);
	 //$this->SetFillColor(255,0,0);
    //$this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    //$this->SetFont('arial','B',7);
    // En-tête
    $w = array(25,65,18,10,22,15,11,25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);

    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
    $fill = false;
    foreach($data as $row)
    {   $this->SetFont('arial','',8);
        $this->Cell($w[0],6,substr($row[0],0,17),'LR',0,'C',$fill);
        $this->Cell($w[1],6,utf8_decode($row[1]),'LR',0,'L',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		//$this->Cell($w[4],6,number_format($row[4],4,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],6,number_format($row[4],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[5],6,number_format($row[5],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[6],6,number_format($row[6],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[7],6,number_format($row[7],0,',',' '),'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}

	function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){

    $wide = $baseline;
    $narrow = $baseline / 3 ; 
    $gap = $narrow;

    $barChar['0'] = 'nnnwwnwnn';
    $barChar['1'] = 'wnnwnnnnw';
    $barChar['2'] = 'nnwwnnnnw';
    $barChar['3'] = 'wnwwnnnnn';
    $barChar['4'] = 'nnnwwnnnw';
    $barChar['5'] = 'wnnwwnnnn';
    $barChar['6'] = 'nnwwwnnnn';
    $barChar['7'] = 'nnnwnnwnw';
    $barChar['8'] = 'wnnwnnwnn';
    $barChar['9'] = 'nnwwnnwnn';
    $barChar['A'] = 'wnnnnwnnw';
    $barChar['B'] = 'nnwnnwnnw';
    $barChar['C'] = 'wnwnnwnnn';
    $barChar['D'] = 'nnnnwwnnw';
    $barChar['E'] = 'wnnnwwnnn';
    $barChar['F'] = 'nnwnwwnnn';
    $barChar['G'] = 'nnnnnwwnw';
    $barChar['H'] = 'wnnnnwwnn';
    $barChar['I'] = 'nnwnnwwnn';
    $barChar['J'] = 'nnnnwwwnn';
    $barChar['K'] = 'wnnnnnnww';
    $barChar['L'] = 'nnwnnnnww';
    $barChar['M'] = 'wnwnnnnwn';
    $barChar['N'] = 'nnnnwnnww';
    $barChar['O'] = 'wnnnwnnwn'; 
    $barChar['P'] = 'nnwnwnnwn';
    $barChar['Q'] = 'nnnnnnwww';
    $barChar['R'] = 'wnnnnnwwn';
    $barChar['S'] = 'nnwnnnwwn';
    $barChar['T'] = 'nnnnwnwwn';
    $barChar['U'] = 'wwnnnnnnw';
    $barChar['V'] = 'nwwnnnnnw';
    $barChar['W'] = 'wwwnnnnnn';
    $barChar['X'] = 'nwnnwnnnw';
    $barChar['Y'] = 'wwnnwnnnn';
    $barChar['Z'] = 'nwwnwnnnn';
    $barChar['-'] = 'nwnnnnwnw';
    $barChar['.'] = 'wwnnnnwnn';
    $barChar[' '] = 'nwwnnnwnn';
    $barChar['*'] = 'nwnnwnwnn';
    $barChar['$'] = 'nwnwnwnnn';
    $barChar['/'] = 'nwnwnnnwn';
    $barChar['+'] = 'nwnnnwnwn';
    $barChar['%'] = 'nnnwnwnwn';

    $this->SetFont('Arial','',10);
    $this->Text($xpos, $ypos + $height + 4, $code);
    $this->SetFillColor(0);

    $code = '*'.strtoupper($code).'*';
    for($i=0; $i<strlen($code); $i++){
        $char = $code[$i];
        if(!isset($barChar[$char])){
            $this->Error('Invalid character in barcode: '.$char);
        }
        $seq = $barChar[$char];
        for($bar=0; $bar<9; $bar++){
            if($seq[$bar] == 'n'){
                $lineWidth = $narrow;
            }else{
                $lineWidth = $wide;
            }
            if($bar % 2 == 0){
                $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
            }
            $xpos += $lineWidth;
        }
        $xpos += $gap;
    }
}
}


$pdf = new PDF(); // $pdf->temporaire( "Duplicata" );
// Titres des colonnes
$header = array('N° Client', 'Nom & Prénoms', 'Chambre', 'Nuité', 'Montant HT','TVA','Taxe','Montant TTC');
// Chargement des données
$data = $pdf->LoadData('txt/facture.txt');
$pdf->AddPage();
$pdf->FancyTable($header,$data);

//$pdf->SetFont('Arial','B',10);
//$pdf->Cell(0,5,'Hello World !',1);

$val=$_SESSION['Mtotal'];  $devise=isset($_GET['devise'])?$_GET['devise']:"Francs CFA"; if($devise=="F CFA") $devise="Francs CFA";

 $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 0,
                  "2"       => 0);
$params1  = "Arrêté la présente facture à la somme de :";
$params2=chiffre_en_lettre($val, $devise1=$devise);
//$pdf->addTVAs( $params1,$params2, $tab_tva, $tot_prods);  // les données des tableaux
//$pdf->addCadreEurosFrancs('logo\signature.png','AKPOVO Jean de Dieu');  //Tableau 2 

$name="Sylvestre SEGOUN";$img="logo\signature.png"; $montant=$params1."".$params2; $signataire="Le Directeur Général";

$x= $pdf->GetX();$y= $pdf->GetY();

	$pdf->SetXY($x-192, $y +5); 	
	$pdf->SetFont( "Arial", "", 10);
	//$pdf->Cell(20,9,"yyyy", 0, 0, "L");
	$pdf->Cell(-20,9,$montant, 0, 0, ""); 
	

	$pdf->SetXY($x-27, $y +15); 	
	$pdf->SetFont( "Arial", "", 9);
	//$pdf->Cell(20,9,"yyyy", 0, 0, "L");
	$pdf->Cell(20,9,$signataire, 0, 0, "C"); 
	
		//$pdf->Image($img,$x-25, $y+20,25,25);
		
		
	$pdf->SetXY($x-48, $y+35 ); 	
	$pdf->Cell(20,4,'', 0, 0, "C"); 
	$pdf->Cell(20,9,$name, 0, 0, "C"); 
	
	//$pdf->Code39($x-150,$y+25,'CODE 39',1,10);
	
	
$pdf->Output('Facture','I');

//$pdf->Output();

//$req=mysql_query("DROP VIEW IF EXISTS view_temporaire");
//$_SESSION['avanceA']=0;
//$_SESSION['montant']=0;
$_SESSION['defalquer_impaye']=0;unset($_SESSION['date_emission']);
?>
