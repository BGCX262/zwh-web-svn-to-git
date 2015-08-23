var Util = {
	hasClass : function(o,n){
		return new RegExp('\\b' + n + '\\b').test(o.className);
	},
	removeClass : function(o, n){
		o.className = o.className.replace(new RegExp('\\b' + n + '\\b'),'');
	},
	addClass : function(o, n){
		if (!o.className) {
			o.className = n;
		}
		else if (this.hasClass(o,n)) {
			return false;
		}
		else {
			o.className += ' ' + n;
		}
	}
};

function Dialog(){
	if(typeof Dialog.instance === "object"){
		return Dialog.instance;
	}

	this.config = {
		w : 300,
		h : 200
	};
	Dialog.init.call(this);

	var self = this;
	this.cl.onclick=function(){
		self.hide();
	};

	window.onresize = function(){
		Dialog.resize.call(self);
	}

	Drag(this.dl, this.tl);

	Dialog.instance = this;
};

Dialog.init = function(){
	this.outer = document.createElement('div');
	this.bg = document.createElement('div');
	this.dl = document.createElement('div');
	this.tl = document.createElement('div');
	this.ct = document.createElement('div');
	this.cl = document.createElement('a');

	this.outer.className = "Dialog_Widget hide";

	this.dl.className = "dialog";
	this.bg.className = "bg"
	this.tl.className = "title";
	this.ct.className = "content";

	
	this.outer.appendChild(this.bg);

	this.cl.href="javascript:void(0)";

	this.cl.innerHTML = "×";
	this.tl.appendChild(this.cl);
	this.dl.appendChild(this.tl);
	this.dl.appendChild(this.ct);

	this.outer.appendChild(this.dl);

	//最顶层document  添加dialog
	document.body.appendChild(this.outer);
};

Dialog.getScrollWidth = function(){
	
};

Dialog.getClientWidth = function(){
	return document.documentElement.clientWidth;
};

Dialog.getClientHeight = function(){
	return document.documentElement.clientHeight;
};
Dialog.resize = function(){
	var cw = Dialog.getClientWidth(),
		ch = Dialog.getClientHeight(),
		ol = parseFloat(this.dl.style.left),
		ot = parseFloat(this.dl.style.top);
	this.bg.style.cssText = 'width:'+cw+'px;height:'+ch+'px;';
	this.dl.style.left = ol+(cw-this.cw)/2+'px';
	this.dl.style.top = ot+(ch-this.ch)/2+'px';
	this.cw = cw;
	this.ch = ch;
}
Dialog.prototype.show = function(){
	this.dl.style.width = this.config.w+'px';
	this.dl.style.height = this.config.h+'px';

	//初始化背景，dialog位置
	this.cw = Dialog.getClientWidth();
	this.ch = Dialog.getClientHeight();
	this.dl.style.left = (this.cw-this.config.w)/2+'px';
	this.dl.style.top = (this.ch-this.config.h)/2+'px';
	this.bg.style.cssText = 'width:'+this.cw+'px;height:'+this.ch+'px;';
	Util.removeClass(this.outer,'hide');
};

Dialog.prototype.hide = function(){
	Util.addClass(this.outer,'hide');
};


function Drag(obj, trigger){
	trigger.onmousedown = function(evt){
		Drag.drag.call(obj,evt);
	};
}
Drag.drag = function(evt){
	var evt = evt || window.event;
	if(document.selection && document.selection.empty){
		document.selection.empty(); //ie
	}else if(window.getSelection){
		window.getSelection().removeAllRanges(); //w3c
	}
	document.onmouseup = Drag.stop;
	
	var _self = this;
	document.onmousemove = function(evt){
		Drag.move.call(_self, evt);
	}
	this.offset = {
		x: evt.offsetX || evt.layerX,
		y: evt.offsetY || evt.layerY
	};
	return false;
}
Drag.stop = function(){
	document.onmouseup = null;
	document.onmousemove = null;
}
Drag.move = function(evt){
	var evt = evt || window.event;
	var posX = evt.clientX - this.offset.x;
	var posY = evt.clientY - this.offset.y;
	var cx = document.documentElement.clientWidth;
	var cy = document.documentElement.clientHeight;
	var cw = parseFloat(this.style.width);
	var ch = parseFloat(this.style.height);
	if(posX<=0){
		this.style.left = 0;
	}else if(posX>=cx-cw-2){
		this.style.left = cx - cw -2+ 'px';
	}else{
		this.style.left = posX + 'px';
	}
	if(posY<=0){
		this.style.top = 0;
	}else if(posY>=cy-ch-2){
		this.style.top = cy - ch -2+ 'px';
	}else{
		this.style.top = posY + 'px';
	}
	//alert(this);
	return false;
}
