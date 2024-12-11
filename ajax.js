var xmlHttp;
function showMeja(str){
	xmlHttp = GetXmlHttpObject()
	if (xmlHttp == null){
		alert("Tidak support request")
		return;
	}
	var url = "get_meja.php?meja="+str
	xmlHttp.onreadystatechange = tableChanged
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function tableChanged(){
	if(xmlHttp.readyState == 4 || xmlHttp.readyState == "complete"){
		document.getElementById("meja").innerHTML = xmlHttp.responseText
	}
}
/* END OF OPTIONS*/

function GetXmlHttpObject(){
	var xmlHttp = null
	try{
		xmlHttp = new XMLHttpRequest()
	}catch(e){
		try{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP")
		}catch(e){
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP")
		}
	}
	return xmlHttp
}
