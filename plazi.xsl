<?xml version='1.0' encoding='utf-8'?>
<xsl:stylesheet version='1.0' 
	xmlns:xsl='http://www.w3.org/1999/XSL/Transform' 
	xmlns:mods="http://www.loc.gov/mods/v3"
	exclude-result-prefixes="mods">

<xsl:output method='html' version='1.0' encoding='utf-8' indent='yes'/>



<xsl:template match="/">
	<head>
		<style>
		body {
			padding:20px;
			font-family:sans-serif;
			line-height:1.5em;
			font-size:1em;
		}
		
.materialsCitation  { background-color: rgba(251,242,64,0.5); padding:1em;}
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

.caption { border:1px solid rgb(192,192,192); padding:1em;border-radius: 12px; background-color: #FFD479; }



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
	
	<form action="." method="get">
	
 		<label for="uri">Treatment bank ID:</label><br/>
 		<input type="text" id="uri" name="uri" size="60" >
 			<xsl:attribute name="value">
 				<xsl:value-of select="/document/@docId" />
 			</xsl:attribute>
		</input><br/>	
		<input type="submit" value="Submit" />
	</form>
	
	
	<xsl:apply-templates />
	</body>
</xsl:template>

<xsl:template match="treatment">
	<xsl:apply-templates />
</xsl:template>

<xsl:template match="mods:mods">
	<!-- eat all the bibliographic metadata -->
</xsl:template>

<xsl:template match="subSubSection">
<section>
	<xsl:apply-templates />
</section>
</xsl:template>



<xsl:template match="paragraph">
	<p>
	<!-- <xsl:value-of select="."/> -->
	<xsl:apply-templates />
	</p>
</xsl:template>

<xsl:template match="heading">
	<h1>
	<xsl:apply-templates />
	</h1>
</xsl:template>



<xsl:template match="taxonomicName">
<b>
	<xsl:apply-templates />
</b>

</xsl:template>



<xsl:template match="treatmentCitationGroup">

<span>
	<xsl:apply-templates />
</span>

</xsl:template>

<xsl:template match="figureCitation">

<span>
	<xsl:apply-templates />
</span>

</xsl:template>

<xsl:template match="caption">
<div class="caption">
	<img>
		<xsl:attribute name="src">
			<xsl:value-of select="@httpUri" />
		</xsl:attribute>
		<xsl:attribute name="width">
			<xsl:text>100%</xsl:text>
		</xsl:attribute>
		
	</img>


	<xsl:apply-templates />
</div>

</xsl:template>


<xsl:template match="materialsCitation">
<div class="materialsCitation">

	<!-- data -->
	<table style="background:rgb(192,192,192);margin-bottom:1em;">
	<tbody style="font-size:0.9em;font-family:monospace;background:white;">
	<tr><th>Key</th><th>Value</th></tr>
	<xsl:for-each select="@*">
		<xsl:choose>
			<xsl:when test="name() = 'box'"></xsl:when>
			<xsl:when test="name() = 'longLatPrecision'"></xsl:when>
			<xsl:when test="name() = 'pageId'"></xsl:when>
			<xsl:when test="name() = 'pageNumber'"></xsl:when>
			<xsl:otherwise>
			 <tr>
			  <td>
			  <xsl:value-of select="name()" />
			  </td>
			  <td>
			  <xsl:value-of select="." />
			  </td>
			  </tr>
			</xsl:otherwise>
		</xsl:choose>
    </xsl:for-each>	
    </tbody>
    </table>

	<xsl:apply-templates />
</div>
</xsl:template>



<xsl:template match="collectingRegion">
<span class="tooltip collectingRegion">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
</span>
</xsl:template>


<xsl:template match="collectingMunicipality">
<span class="tooltip collectingMunicipality">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
</span>
</xsl:template>

<xsl:template match="collectingCounty">
<span class="tooltip collectingCounty">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
</span>

</xsl:template>

<xsl:template match="collectingCountry">
<span class="tooltip collectingCountry">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>

	<xsl:apply-templates />
</span>

</xsl:template>


<xsl:template match="collectorName">
<span class="tooltip collectorName">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
</span>
</xsl:template>

<xsl:template match="date">
<span class="tooltip date">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
</span>

</xsl:template>

<xsl:template match="location">
<span class="tooltip location">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
</span>

</xsl:template>

<xsl:template match="collectionCode">
<span class="tooltip collectionCode">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
		<xsl:apply-templates />
	</span>
</xsl:template>

<xsl:template match="specimenCode">
<span class="tooltip specimenCode">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
		<xsl:apply-templates />
	</span>
</xsl:template>



<xsl:template match="specimenCount">
<span class="tooltip specimenCount">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
	<xsl:apply-templates />
	</span>
</xsl:template>

<xsl:template match="quantity">
<span class="tooltip quantity">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
		<xsl:apply-templates />
	</span>
</xsl:template>

<xsl:template match="typeStatus">
<span class="tooltip typeStatus">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
		<xsl:apply-templates />
	</span>
</xsl:template>

<xsl:template match="geoCoordinate">
<span class="tooltip geoCoordinate">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
		<xsl:apply-templates />
	</span>
</xsl:template>

<xsl:template match="accessionNumber">
<span class="tooltip accessionNumber">
 	<span class="tooltiptext"><xsl:value-of select="local-name()"/></span>
		<xsl:apply-templates />
	</span>
</xsl:template>





<xsl:template match="emphasis">
<i>
	<xsl:apply-templates />
</i>
</xsl:template>

<!-- table -->
<xsl:template match="table">
<table>
	<xsl:apply-templates />
</table>
</xsl:template>

<xsl:template match="tr">
<tr>
	<xsl:apply-templates />
</tr>
</xsl:template>

<xsl:template match="th">
<th>
	<xsl:apply-templates />
</th>
</xsl:template>

<xsl:template match="td">
<td>
	<xsl:apply-templates />
</td>
</xsl:template>






</xsl:stylesheet>