<?php

//----------------------------------------------------------------------------------------
// post
function post($url, $data = null)
{
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	curl_setopt($ch, CURLOPT_HTTPHEADER, 
		array(
			"Content-Type: " . 'application/x-www-form-urlencoded'
			)
		);
		
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

$xslt = new xsltProcessor;

$xslDoc = new DOMDocument(); 
$xslDoc->load('material.xsl', LIBXML_NOCDATA); 
$xslt->importStylesheet( $xslDoc ); 


$test_cases = array(
/*
'<?xml version="1.0" encoding="utf-8"?><paragraph>    <materialsCitation accessionNumber="PSU 13370" collectingDate="2008-01-15" collectorName="Gallireya Reef &amp; Lake &amp; Africa &amp; A. F. Konings &amp; J. R. Stauffer Jr." latitude="-10.500153" longLatPrecision="1" longitude="34.23336" specimenCount="1" typeStatus="holotype">        <typeStatus>Holotype</typeStatus>.         <accessionNumber httpUri="http://www.ncbi.nlm.nih.gov/protein/PSU13370">PSU 13370</accessionNumber>, adult male,         <quantity metricMagnitude="-2" metricUnit="m" metricValue="5.4399999999999995" unit="mm" value="54.4">54.4 mm</quantity>SL, (        <geoCoordinate degrees="10.500153" direction="south" orientation="latitude" precision="1" value="-10.500153">10.500153 S</geoCoordinate>,         <geoCoordinate degrees="34.233362" direction="east" orientation="longitude" precision="1" value="34.23336">34.233362 E</geoCoordinate>),         <collectorName>Gallireya Reef</collectorName>,         <collectorName>Lake</collectorName>Malaŵi, Malaŵi,         <collectorName>Africa</collectorName>,         <date value="2008-01-15">            <collectingDate value="2008-01-15">15 Jan. 2008</collectingDate>        </date>,         <collectorName>A. F. Konings</collectorName>&amp;         <collectorName>J. R. Stauffer Jr.</collectorName>    </materialsCitation></paragraph>'*/

//'<materialsCitation><typeStatus>Holotype</typeStatus>. <specimenCode>PSU 13370</specimenCode>, adult male, 54.4 mmSL, ( <geoCoordinate>10.500153 S</geoCoordinate>, <geoCoordinate>34.233362 E</geoCoordinate>), <location>Gallireya Reef, Lake Malaŵi,</location> <collectingRegion>Malaŵi</collectingRegion>, <collectingCountry>Africa</collectingCountry>, <collectingDate>15 Jan. 2008</collectingDate>, <collectorName>A. F. Konings</collectorName> &amp; <collectorName>J. R. Stauffer Jr.</collectorName></materialsCitation>',

// Epigomphus brillantina sp. nov. https://plazi-tester.herokuapp.com/?uri=03A087FA2319FF86FF3D64CDFD9BBABC
// GBIF ends up without the holotype correctly described 

'<materialsCitation> <collectionCode>CEUA</collectionCode> : <typeStatus>Holotype</typeStatus> <specimenCount>♂</specimenCount>, <specimenCode>CEUA 81502</specimenCode> , <collectingDate>28 May 2014</collectingDate>  , <collectingCountry>COLOMBIA</collectingCountry> , <location>Antioquia Department</location> , <location>Remedios Municipality</location> , <location>La Cruz Township</location> , <location>Finca La Brillantina</location>  <geoCoordinate>6.881105°</geoCoordinate>, <geoCoordinate>-74.569295°</geoCoordinate>; <quantity>558 m</quantity> a.s.l. , Leg : <collectorName>C. Flórez</collectorName> and <collectorName>C. Bota.</collectorName></materialsCitation>'

);

$results = array();

foreach ($test_cases as $input)
{
	$row = array();

	// convert XML to simple text for parsing
	$text = htmlspecialchars_decode(strip_tags($input));
	
	$parameters = array(
		'data' 			=> $text,
		'functionName' 	=> 'MaterialsCitationExtractor.webService',
		'dataFormat' 	=> 'TXT'
	);

	$output = post('http://tb.plazi.org/GgWS/wss/invokeFunction', http_build_query($parameters));

	$xmlDoc = new DOMDocument(); 
	$xmlDoc->loadXML($input); 
	
	$row[] = $xslt->transformToXML( $xmlDoc ); 
	
	// $row[] = $text; 

	$xmlDoc->loadXML($output); 
	$row[] = $xslt->transformToXML( $xmlDoc ); 

	$results[] = $row;
}

?>

<html>
<head>
<style>

body {
padding:2em;
font-family:sans-serif;
}
		
.materialsCitation  { }
.collectingCountry { background-color: rgb(223,1289,32); }
.collectingRegion { background-color: rgb(242,156,36); }
.collectingCountry { background-color: rgb(242,122,29); }
.collectingMunicipality { background-color: rgb(192,192,192); }
.locationDeviation { background-color: rgb(245,233,142); }
.collectingDate  { background-color: rgb(164,238,163); }
.collectingMethod { background-color: rgb(193,238,196); }
.collectorName { background-color: rgb(143,234,139); }
.specimenCount  { background-color: rgb(252,252,137); }
.specimenType { background-color: rgb(192,192,192); }
.typeStatus { background-color: rgb(190,192,242); }
.collectionCode { background-color: rgb(123,134,234); }
.specimenCode { background-color: rgb(155,164,231); }

.geoCoordinate { background-color: rgb(186,252,136); }
.location { background-color: rgb(254,191,132); }
.quantity { background-color: rgb(125,172,252); }
.specimenCode  { background-color: rgb(255,247,136); }
.date  { background-color: rgb(241,135,252); }
.elevation  { background-color: rgb(250,128,159); }

.accessionNumber  { background-color: red; color:white; }


/* https://www.w3schools.com/css/css_tooltip.asp */

/* Tooltip container */
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
 
  /* Position the tooltip text - see examples below! */
  position: absolute;
  z-index: 1;
  
  bottom: 100%;
  left: 50%; 
  margin-left: -60px; /* Use half of the width (120/2 = 60), to center the tooltip */
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
}


	</style>
	</head>
<body>

<h1>Comparison of expected result and results returned by Plazi's web service</h1>

<p>For each material citation the first row ("input") shows the expected markup. This is then stripped from the citation and the raw string is parsed using Plazi's web API and the result is displayed below the input. Ideally the input and output strings will have the same markup.</p>

<?php

foreach ($results as $row)
{
	echo '<table>
	<tr><th></th><th></th></tr>';

	echo '<tr>';
	
	echo '<td>Input</td>';
	echo '<td>' . $row[0] . '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td>Output</td>';
	echo '<td>' . $row[1] . '</td>';
	echo '</tr>';
	
	echo '</table>';

}

?>


</body>
</html>
