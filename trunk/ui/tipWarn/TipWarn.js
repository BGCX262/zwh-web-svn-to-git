var UI = {};

UI.TipWarn = (function(){
	var _display = null,
		_uinique = null,
		_init = null;
	var _o = {
		width: 300,
		right: 16,
		bottom: 10,
		html: '',
		_w: ''
	};
	var tip_warn,warn_title,warn_close,warn_wrap;

	var Tween = {
		 easeOut: function(t,b,c,d){
            if ((t/=d) < (1/2.75)) {
                return c*(7.5625*t*t) + b;
            } else if (t < (2/2.75)) {
                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
            } else if (t < (2.5/2.75)) {
                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
            } else {
                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
            }
        },
        Quad: {
        	easeOut: function(t,b,c,d){
            	return -c *(t/=d)*(t-2) + b;
        	}
        }
	};
	function init(){
		tip_warn = document.createElement('div'),
		warn_title = document.createElement('div'),
		warn_close = document.createElement('a'),
	 	warn_wrap = document.createElement('div');

		tip_warn.id = 'tip_warn';
		tip_warn.className = 'tip_warn';
		tip_warn.style.cssText = 'position:absolute;display:none;';

		warn_title.className = 'warn_title';

		warn_close.id = 'warn_close';
		warn_close.className = 'warn_close';
		warn_close.href = 'javascript:void(0)';

		warn_wrap.id = 'warn_wrap';
		warn_wrap.className = 'warn_wrap';

		warn_title.appendChild(warn_close);
		tip_warn.appendChild(warn_title);
		tip_warn.appendChild(warn_wrap);

		warn_close.onclick = function(){
			UI.TipWarn.hide();
		}
	}
	function _show(t,b,c,d){
		tip_warn.style.right =  Math.ceil(Tween.Quad.easeOut(t,b,c,d))+"px";	
		if(t<d){
		   t+=3;
		   function _s(){
		   		return _show(t,b,c,d);
		   }
		   setTimeout(_s,25);
		}
	}

	function _hide(t,b,c,d,setDis){
		tip_warn.style.right =  Math.ceil(Tween.Quad.easeOut(t,b,c,d))+"px";	
		if(t<d){
		   t+=3;
		   function _h(){
		   		return _hide(t,b,c,d,setDis);
		   }
		   setTimeout(_h,25);
		}else{
			setDis();
		}
	}
	
	return {
		append: function(o){
			if(!_init){
				init();
				_init = true;
			}
			if(o){
				o.width && (_o.width = o.width);
				o.right && (_o.right = o.right);
				_o.w = - _o.width -10;
				tip_warn.style.width = _o.width + 'px';
				warn_wrap.innerHTML += o.html ? o.html : _o.html;


				tip_warn.style.right = _o.w + 'px';
				tip_warn.style.bottom = (o.bottom ? o.bottom : _o.bottom) + 'px';
			}
		},
		show: function(so){
			if(!_display){
				tip_warn.style.display = '';
				_display = true;
			}else{
				return; 
			}
			if(!_uinique){
				document.body.appendChild(tip_warn);
				_uinique = true;
			}
			var b,c,d=50,t=0;
			b = _o.w;
			c = _o.right - _o.w;
			if(so){
				d = so.duration ? so.duration : 50; 
			}
			_show(t,b,c,d,function(){});

		},
		hide: function(ho){
			if(!_display){
				return;
			}else{
				_display = false;
			}
			var b,c,d=30,t=0;
			b = _o.right;
			c = -_o.right + _o.w;
			if(ho){
				d = ho.duration ? ho.duration : 30; 
			}
			_hide(t,b,c,d,function(){tip_warn.style.display='none'});
		}
	};
})();