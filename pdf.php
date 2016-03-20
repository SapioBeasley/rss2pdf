<?php

require 'vendor/autoload.php';

class urlToPDF extends FPDF
{
	protected $B = 0;
	protected $I = 0;
	protected $U = 0;
	protected $HREF = '';

	public function displayPdf($url)
	{
		// Instanciate Guzzle
		$client = new GuzzleHttp\Client();

		// Request data from posted URL
		$xml = $client->request('GET', $url);

		// Check request status
		switch ($xml->getStatusCode()) {
			case '200':
				$xml = $xml->getBody()->getContents();
				$data = $this->xml2Json($xml);
				$items = $this->getItems($data);

				// Check if an error returned
				if (isset($items['status']) && $items['status'] == 'error')
					return $items['message'];
				break;

			default:
				echo 'Your request did not return a valid response code';
				break;
		}

		// Loop news
		foreach ($items as $page) {
			$this->printPage($page);
		}

		$this->Output();
	}

	public function xml2Json($xml)
	{
		$xml = simplexml_load_string($xml);
		$xml2Json = json_encode($xml);
		$jsonData = json_decode($xml2Json,TRUE);

		return $jsonData;
	}

	public function getItems($data)
	{
		// Loop data in returned
		foreach ($data as $jsonDataKey => $jsonDataValue) {

			// Only select channel data
			if ($jsonDataKey == 'channel') {

				// Check for items
				switch (true) {
					case ! isset($jsonDataValue['item']):
						$items = [
							'status' => 'error',
							'message' => 'There was a code 200 but no items were returned. Refresh to try again.'
						];
						break;

					default:

						// create an items array
						foreach ($jsonDataValue['item'] as $itemValue) {
							$items[] = $itemValue;
						}
						break;
				}
			}
		}

		return $items;
	}

	function OpenTag($tag, $attr)
	{
		// Opening tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
	}

	function CloseTag($tag)
	{
		// Closing tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}

	public function printPage($item)
	{
		// Create new page
		$this->AddPage();
		$this->SetFont('Arial','',10);
		$this->WriteHTML($item['description']);
	}

	function SetStyle($tag, $enable)
	{
		// Modify style and select corresponding font
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s) {
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
		// Put a hyperlink
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}

	function WriteHTML($html)
	{
		// HTML parser
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e) {
			switch ($i%2) {
				case 0:
					// Text
					if($this->HREF)
						$this->PutLink($this->HREF,$e);
					else
						$this->Write(5,$e);
					break;

				default:
					// Tag
					if($e[0]=='/')
						$this->CloseTag(strtoupper(substr($e,1)));
					else {
						// Extract attributes
						$a2 = explode(' ',$e);
						$tag = strtoupper(array_shift($a2));
						$attr = array();
						foreach($a2 as $v) {
							if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
								$attr[strtoupper($a3[1])] = $a3[2];
						}
						$this->OpenTag($tag,$attr);
					}
					break;
			}
		}
	}
}

$pdf = new urlToPDF();
$pdf->displayPdf($_GET['url']);
