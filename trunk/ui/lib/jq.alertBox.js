(function($){
	window.alert = function(txt){
		if(!window.alert.init){
			var box = document.createElement('div'),
				bg = document.createElement('div'),
				body = document.createElement('div'),
				title = document.createElement('div'),
				content = document.createElement('div');
				w = document.documentElement.clientWidth+17;
				h = document.documentElement.clientHeight+17;

			box.className = "alertBox";
			box.style.cssText = "position:absolute;left:0;top:0;z-index:9998;";


			bg.style.cssText = "background-color:rgba(0,0,0,0.3);position:absolute;z-index:9998;left:0;top:0;width:"+w+"px;height:"+h+"px;";
			bg.className = "alertBg";

			body.className = "alertBody";
			body.style.cssText = "position:absolute;z-index:9999;"
			title.className = 'alertTitle';
			content.className = 'alertContent';
			content.innerHTML = txt;	

			box.appendChild(bg);
			box.appendChild(body);
			body.appendChild(title);
			body.appendChild(content);

			document.documentElement.className+=" alert";
			document.body.className+=" alert";
			document.body.appendChild(box);

		}
		function resizeDiv() {
		    bg.style.height = document.documentElement.clientHeight + "px";
		}
		window.onresize = function() {
		    bg.style.height = document.documentElement.clientHeight + "px";
		    //throttle(resizeDiv);
		};
		

	}

	window.alert.init = false;
	window.alert.display = false;

})(jQuery)

function throttle(method, context) {
    clearTimeout(method.tId);
    method.tId = setTimeout(function() {
      method.call(context);
    }, 100);
}

function resizeDiv() {
    var div = document.getElementById("myDiv");
    div.style.height = div.offsetWidth + "px";
}
 
