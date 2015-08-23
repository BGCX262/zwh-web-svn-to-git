var UI = {
	getStyle:function(elm, name){
		return parseInt(elm.currentStyle ? elm.currentStyle[name] : window.getComputedStyle(elm, null)[name]);
	}
};

UI.TipBox = function(o){
	var _display = false;
	var obj = document.getElementById(o.id);

	var _o = {
		align : 'left',
		width: 150,
		height: 80,
		content: ''
	};

	var tip_box,tip_title,tip_close,tip_content;

	(function(){
		tip_box = document.createElement('div');
		tip_box.id = 'tip_box';
		tip_box.className = 'tip_box ' + 'tip_box_'+(o.align || _o.align);
		tip_box.style.cssText = 'position:absolute;z-index: 9999;display:none;';
		tip_box.style.width = (o.width || _o.width) + 'px';
		tip_box.style.height = (o.height || _o.height) + 'px';

		tip_title = document.createElement('div');
		tip_title.className = 'tip_title';

		tip_close = document.createElement('a');
		tip_close.className = 'tip_close';
		tip_close.href = 'javascript:void(0)';
		tip_close.innerHTML = '×'

		tip_title.appendChild(tip_close);

		tip_content = document.createElement('div');
		tip_content.className = 'tip_content';
		tip_content.innerHTML = (o.content || _o.content);

		tip_box.innerHTML += '<span class="arrow"><b class="arrow_out"></b><b class="arrow_in"></b></span>';
		tip_box.appendChild(tip_title);
		tip_box.appendChild(tip_content);

		obj.appendChild(tip_box);
		
	})()

	function show(){
		if(!_display){
			tip_box.style.display = '';
			_display = true;
		}
		
	}
	function hide(e){
		var e = e || window.event;
		if (! +'\v1') {//ie
			e.cancelBubble = true;
		}else{
			e.stopPropagation();
		}
		
		tip_box.style.display = 'none';
		_display = false;
	}
	obj.onclick = show;
	tip_close.onclick = hide;
};