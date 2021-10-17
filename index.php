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
 		<input type="text" id="uri" name="uri" value="" placeholder="D50C9F64454CFFDBA6B9F8F0FDBE4B1B" size="60"><br>	
		  <input type="submit" value="Submit">
	</form>
</body>
</html>


<?php
}
?>


