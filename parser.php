<?php

error_reporting(E_ALL);

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

$text = 'CHINA . Hubei , Wufeng County , Wufeng Town , Shuitantou Village , epiphytic on tree or moss rocks in the subtropical evergreen broad-leaved forest, elev. 959 m  , 30°6´16˝E , 110°39´6˝N , 21 April 2021, Q. Yan 4001 ( holotype : HIB !)';
$output = '';

if (isset($_GET['text']))
{
	$text = $_GET['text'];
}

if ($text != "")
{
	$xslt = new xsltProcessor;

	$xslDoc = new DOMDocument(); 
	$xslDoc->load('material.xsl', LIBXML_NOCDATA); 
	$xslt->importStylesheet( $xslDoc ); 

	$parameters = array(
		'data' 			=> $text,
		'functionName' 	=> 'MaterialsCitationExtractor.webService',
		'dataFormat' 	=> 'TXT'
	);

	$output = post('http://tb.plazi.org/GgWS/wss/invokeFunction', http_build_query($parameters));

	$xmlDoc = new DOMDocument(); 
	$xmlDoc->loadXML($output); 
	
	$output = $xslt->transformToXML( $xmlDoc ); 

}
?>

<html>
<head>
	<style>
		body {
			padding:20px;
			font-family:sans-serif;
		}
		textarea {
			font-size:1em;
			box-sizing:border-box;width:100%;
		}
		input {
			font-size:1em;
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
	<div><a href="./">Home</a></div>

	<h1>Plazi parser</h1>
	<p>Test the Plazi material citation parser. Paste in a material citation and click "Parse".</p>
	
	
	<h2>Parser</h2>
	<form action="parser.php" method="get">
<textarea id="text" name="text" rows="10" >
<?php echo $text; ?>
</textarea>
		<br/>
		<input type = "submit" name = "submit" value = "Parse">
	</form>
	
<div>
	<?php echo $output; ?>
</div>
	
	
</body>
</html>

