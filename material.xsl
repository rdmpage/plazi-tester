<?xml version='1.0' encoding='utf-8' ?>
<xsl:stylesheet version='1.0' 
	xmlns:xsl='http://www.w3.org/1999/XSL/Transform' 
	xmlns:mods="http://www.loc.gov/mods/v3"
	exclude-result-prefixes="mods">

<xsl:output method='html' version='1.0' encoding='utf-8' indent='no'/>



<xsl:template match="/">
	<xsl:apply-templates />
</xsl:template>


<xsl:template match="materialsCitation">
<div class="materialsCitation">

	<!-- data -->
	<!--
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
    -->

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

</xsl:stylesheet>