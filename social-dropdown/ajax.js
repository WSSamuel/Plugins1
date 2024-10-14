
var xmlHttp
var currentobj
var voteobj
var votedisptype

//Javascript Function for JavaScript to communicate with Server-side scripts
function AJAXrequest(scriptURL) {
	xmlHttp=GetXmlHttpObject()
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
	xmlHttp.onreadystatechange=voteChanged;
	xmlHttp.open("GET",scriptURL,true);
	xmlHttp.send(null);
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

function voteChanged() 
{ 
if (xmlHttp.readyState==4)
{ 
	var disp = document.getElementById('dispprev');
	var voteno = xmlHttp.responseText;


disp.innerHTML = voteno;



//return xmlHttp.responseText;
//document.write(xmlHttp.responseText);
}
}
function CallAJAX(val,domainvar) {
	AJAXrequest(domainvar+'/generatebookmarks.php?mode=preview&q='+val);
}
