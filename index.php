<?php
require('fpdf/fpdf.php');

 //http://simplehtmldom.sourceforge.net
 include('simplehtmldom/simple_html_dom.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		//Logo
		$this->Image('http://www.fpdf.org/logo.gif',10,8,33);
		//Arial bold 15
		$this->SetFont('Arial','B',15);
		//Move to the right
		$this->Cell(80);
		//Title
		$this->Cell(30,10,'Test PDF',1,0,'C');
		//Line break
		$this->Ln(20);
	}

	//Page footer
	function Footer()
	{
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	
	function breakLine(){
		return $this->Ln(20);
	}
	
	function placeText($text){
		//generates a cell with string length as width and place it on the pdf.
		$cellWidth = $this->GetStringWidth($text) + 4;
		
		//Cell($cellWidth, $cellHeight, $text, $borderOption);
		return $this->Cell($cellWidth, 10, $text, 1);
	}
	
}//ends extended Class pdf

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',26);

$pdf->placeText('Hello World');
$pdf->placeText('Hello World');

$pdf->breakLine();

$pdf->placeText('Hello World');
//$pdf->Output();



function getTextBetweenTags($document, $tagname)
 {
	$html = file_get_html($document);
	$contents = $html->find($tagname);
	return $contents[0]->plaintext;
 }

function getItemCoordinates($document, $tagname){
//returns array. Notably $parsed["left"] and $parse["top"]

	$html = file_get_html($document);
	$element = $html->find($tagname);
	 
	$css = $element[0]->style;

	//inline css parser from
	//http://programmingbulls.com/php-script-parse-inline-css
	$attrs = explode(";", $css);
	
	foreach ($attrs as $attr) {
	   if (strlen(trim($attr)) > 0) {
		  $kv = explode(":", trim($attr));
		  $parsed[trim($kv[0])] = trim($kv[1]);
	   }
	}
 
	//return array
	return $parsed;
	
}
	
	 echo "text between tags: ". getTextBetweenTags("form.html", "b");
	 $coords = getItemCoordinates("form.html", "p");
	 echo "<br/>item coordinates: " ."left: " . $coords["left"] . ", top: " . $coords["top"];

/*header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="downloaded.pdf"');
*/
?>