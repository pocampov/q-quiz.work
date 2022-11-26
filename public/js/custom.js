/* 	function nobackbutton()
	{
	   window.location.hash="no-back-button";
	   window.location.hash="Again-No-back-button";
	   window.onhashchange=function(){window.location.hash="#";}   
	}
*/
	function copyToClipBoard()
	{
		const range = document.createRange();
		var url = document.getElementById("token");
		var contenido = document.getElementById("token").innerHTML;
		url.innerHTML = window.location.host+"/participa/"+url.innerHTML
		range.selectNode(url);
		range.setStart(url, 0)
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand("copy");
		window.getSelection().removeAllRanges();
		document.getElementById('symbol').innerHTML = 'add_task';
		document.getElementById("token").innerHTML = contenido;
	}
	