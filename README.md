# Plazi tester

The goal of this project is to understand how accurately [Plazi](http://plazi.org) is marking up material citations in documents. The site takes a Plazi treatment in XML form displays the XML as a marked up web page. In other words, it displays the tags assigned to the text by Plazi. These tags are colour-coded, and there is a tooltip to show the corresponding tag name. 

To use the web site simply paste in the Plazi treatment id (typically a UUID) and the site will display the marked up document.


## Notes

There is a web service for parsing material citations here: https://tb.plazi.org/GgWS/wss/test

To call this send a `x-www-form-urlencoded` POST request to `http://tb.plazi.org/GgWS/wss/invokeFunction` with the following parameters:

Key | Value
--|--
data | text of material citation to be parsed
functionName | `MaterialsCitationExtractor.webService`
dataFormat | `TXT` 


