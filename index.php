<?php

error_reporting(E_ALL);

// Date timezone
date_default_timezone_set('UTC');

$uri = 'D50C9F64454CFFDBA6B9F8F0FDBE4B1B';
$uri = '';

if (isset($_GET['uri']))
{
	$uri = $_GET['uri'];
}


//----------------------------------------------------------------------------------------
function get($url, $accept ='')
{
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	
	if ($accept != '')
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
		array(
			"Accept: " . $accept 
			)
		);
	}
	  	
	$response = curl_exec($ch);
	if($response == FALSE) 
	{
		$errorText = curl_error($ch);
		curl_close($ch);
		die($errorText);
	}
	
	$info = curl_getinfo($ch);
	$http_code = $info['http_code'];
	
	curl_close($ch);
	
	return $response;
}

//----------------------------------------------------------------------------------------

if ($uri != '')
{
	$uri = str_replace('-', '', $uri);

	$url = 'https://tb.plazi.org/GgServer/xml/' . $uri;


	$xml = get($url);


	$xmlDoc = new DOMDocument(); 
	$xmlDoc->loadXML($xml); 


	$xslt = new xsltProcessor;

	$xslDoc = new DOMDocument(); 
	$xslDoc->load( 'plazi.xsl', LIBXML_NOCDATA); 
	$xslt->importStylesheet( $xslDoc ); 

	echo $xslt->transformToXML( $xmlDoc ); 
}
else
{
?>

<html>
<head>
	<style>
		body {
			padding:20px;
			font-family:sans-serif;
		}
		input {
			font-size:1em;
		}
		input {
			font-size:1em;
		}
		

	</style>	
</head>
<body>
	<h1>Plazi Markup Viewer</h1>
	<form action="." method="get">
	
 		<label for="uri">Treatment bank ID:</label><br>
 		<input type="text" id="uri" name="uri" value="252C87918B362C05FF20F8C5BFCB3D4E" placeholder="D50C9F64454CFFDBA6B9F8F0FDBE4B1B" size="60"><br>	
		  <input type="submit" value="Submit">
	</form>
	
	<h2>What is this?</h2>
	<p>The goal of this project is to understand how accurately <a href="http://plazi.org">Plazi</a> is marking up material citations in documents. The site takes a Plazi treatment in XML form and displays the XML as a marked up web page. In other words, it displays the tags assigned to the text by Plazi. These tags are colour-coded, and there is a tooltip to show the corresponding tag name. The interpretation of the markup by Plazi is shown as a table of key-value pairs.</p>

	<p>To use the web site simply paste in the Plazi treatment id (typically a UUID) and the site will display the marked up document.</p>
	
	<p>Parsing specimen information in publications is a challenging problem. One concern is that automated extraction methods can easily generate data from publications without any obvious way to check whether that data makes sense. Below I have listed some examples where Plazi appears to have failed to correctly extract specimen data.</p>
	
	<table>
	<tr><th>Treatment ID</th><th>Issue</th></tr>
	
	<tr><td><a href="?uri=74CF9B715E205704A730270742F139CA">74CF9B715E205704A730270742F139CA</a></td><td>Misses specimen</td></tr>
	<tr><td><a href="?uri=9319C4492C272A7EFF288BEBFC1849AB">9319C4492C272A7EFF288BEBFC1849AB</a></td><td>Splits one specimen into two</td></tr>
	<tr><td><a href="?uri=03F33310DA38FF875DB5FDF3FC2AF8CD">03F33310DA38FF875DB5FDF3FC2AF8CD</a></td><td>Specimen code interpreted as GenBank accession number</td></tr>
	<tr><td><a href="?uri=03FC87E61268FFD6D3E36CD2FE12DF29">03FC87E61268FFD6D3E36CD2FE12DF29</a></td><td>Cruise interpreted as collector, depth treated as elevation</td></tr>
	<tr><td><a href="?uri=DD4987C1FF96247CFF3DFC385F30FE6F">DD4987C1FF96247CFF3DFC385F30FE6F</a></td><td>Collector treated as locality, datum WGS84 interpreted as speicmen code</td></tr>
	<tr><td><a href="?uri=704ECD36FFF12173FD03EF56CEA6D97D">704ECD36FFF12173FD03EF56CEA6D97D</a></td><td>Specimen split, only first part parsed</td></tr>
	<tr><td><a href="?uri=023487907016FF9EDAC8FF48FAC1DA10">023487907016FF9EDAC8FF48FAC1DA10</a></td><td>Specimen split in two</td></tr>
	<tr><td><a href="?uri=C51DEB611E4C5421FF13F9ABA73729F7">C51DEB611E4C5421FF13F9ABA73729F7</a></td><td>Failed to parse specimen citation</td></tr>
	<tr><td><a href="?uri=03E787D0FFB0FFDA7B8BD57CB2FE779E">03E787D0FFB0FFDA7B8BD57CB2FE779E</a></td><td>Station treated as colelctor, depth treated as elevation</td></tr>
	<tr><td><a href="?uri=03EB1A42265CFFE3FF1EF9B71C5AF92C">03EB1A42265CFFE3FF1EF9B71C5AF92C</a></td><td>Missed most information, confused collectors with places</td></tr>
	<tr><td><a href="?uri=6FE5DF2540375B7184495C6134814F7F">6FE5DF2540375B7184495C6134814F7F</a></td><td>Biodiversity Data Journal paper with structured data misinterpeted (origjnal paper <a href="https://doi.org/10.3897/BDJ.9.e64505">doi:10.3897/BDJ.9.e64505</a>)</td></tr>
	<tr><td><a href="?uri=252C87918B362C05FF20F8C5BFCB3D4E">252C87918B362C05FF20F8C5BFCB3D4E</a></td><td>Collector initial interpeted as collection code, specimen code treated as accession number</td></tr>
	<tr><td><a href="?uri=6CA445F8-9162-4F8F-86D8-9A7580F879D4">6CA445F891624F8F86D89A7580F879D4</a></td>No specimens found<td></td></tr>
	<tr><td><a href="?uri=71F7952EADCA5025A7A45AE1C2811C3D">71F7952EADCA5025A7A45AE1C2811C3D</a></td><td>No specimens found</td></tr>
	<tr><td><a href="?uri=03FCA61B9A735210FF52F99DFCC38B27">03FCA61B9A735210FF52F99DFCC38B27</a></td><td>Missed lat lon</td></tr>
	<tr><td><a href="?uri=03A087FA2319FF86FF3D64CDFD9BBABC">03A087FA2319FF86FF3D64CDFD9BBABC</a></td><td>Split one record into two, missed lat lon, duplicates in GBIF</td></tr>
	</table>






</body>
</html>


<?php
}
?>


