document.addEventListener("DOMContentLoaded", function(event) { 

	var classname = document.getElementsByClassName("kamesen"); 
	
	for (var i = 0; i < classname.length; i++) {
		
		//click gauche
		classname[i].addEventListener('click', kapsuleDcode, false);
		// click central
		classname[i].addEventListener('mousedown', EveryClicks);
		//click droit
		classname[i].addEventListener('contextmenu', myRightFunction);
		
		
	}
	
}); 


	
//fonction du click gauche
var kapsuleDcode = function(event) {
	
	var attribute = this.getAttribute("datasin");  
	var url_decode = decodeURI(window.atob(attribute));
	
	if (url_decode.includes('fnac')) {
		
		url_decode = url_decode.replaceAll('&amp;', '&');
		url_decode = url_decode.replaceAll('%2B', '+');
		url_decode = url_decode.replaceAll('%20', '+');
		url_decode = url_decode.replaceAll(' ', '+');
		
	}
	
	url_decode = url_decode.replaceAll('è', 'e');
	url_decode = url_decode.replaceAll('à', 'a');
	url_decode = url_decode.replaceAll('é', 'e');
	url_decode = url_decode.replaceAll('ê', 'e');
	
	//console.log (url_decode);
	
	/*
	if(event.ctrlKey) { 
	
		var newWindow = window.open(url_decode, '_blank');                    
		newWindow.focus();       
		 
	} else {             
	
		document.location.href = url_decode;
		 
	}*/
	
	var newWindow = window.open(url_decode, '_blank');                    
	newWindow.focus();
	
		
};
	
//fonction du click droit
var myRightFunction = function(event) {
	
	event.preventDefault();
	
	var attribute = this.getAttribute("datasin");  
	var url_decode = decodeURI(window.atob(attribute));
	
	if (url_decode.includes('fnac')) {
		
		url_decode = url_decode.replaceAll('&amp;', '&');
		url_decode = url_decode.replaceAll('%2B', '+');
		url_decode = url_decode.replaceAll('%20', '+');
		url_decode = url_decode.replaceAll(' ', '+');
		
	}
	
	url_decode = url_decode.replaceAll('è', 'e');
	url_decode = url_decode.replaceAll('à', 'a');
	url_decode = url_decode.replaceAll('é', 'e');
	url_decode = url_decode.replaceAll('ê', 'e');

	var newWindow = window.open(url_decode, '_blank');                    
	newWindow.focus(); 
		
}

//fonction déclenché quel que soit le clic
function EveryClicks(event) {
	
	if (event.button === 1)  { // Si c'est molette on ouvre dans un nouvel onglet
	
		event.preventDefault(); // On désactive la réaction par défaut
		var attribute = this.getAttribute("datasin");  
		var url_decode = decodeURI(window.atob(attribute));
		
		if (url_decode.includes('fnac')) {
		
			url_decode = url_decode.replaceAll('&amp;', '&');
			url_decode = url_decode.replaceAll('%2B', '+');
			url_decode = url_decode.replaceAll('%20', '+');
			url_decode = url_decode.replaceAll(' ', '+');
		
		}
	
		url_decode = url_decode.replaceAll('è', 'e');
		url_decode = url_decode.replaceAll('à', 'a');
		url_decode = url_decode.replaceAll('é', 'e');
		url_decode = url_decode.replaceAll('ê', 'e');
		
		var newWindow = window.open(url_decode, '_blank');                    
		newWindow.focus(); 
			
	}	
			 	
};