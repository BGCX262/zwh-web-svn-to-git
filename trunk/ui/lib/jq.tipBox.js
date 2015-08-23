(function($){
	$.fn.tipBox = function(){
		function TipBox(obj){
			var _o = {
				align : 'left',
				width: 150,
				height: 80,
				content: ''
			};
			var tip_box,tip_title,tip_close,tip_content;
			var s,o = {};
			
			s = obj.getAttribute('data-widget-config');
			
			if(s){
				o = eval('('+s+')');
			}
				
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

			tip_box.innerHTML += '<span class="arrow"><b class="arrow_out"></b><b class="arrow_in" style="display:none;"></b></span>';
			tip_box.appendChild(tip_title);
			tip_box.appendChild(tip_content);

			obj.appendChild(tip_box);

			
			this.tip_box = tip_box;
			this.tip_close = tip_close;
			this.display = false;

			var self = this;

			$(obj).hover(function(){
				TipBox.show.call(self);
			},function(e){
				TipBox.hide.call(self,e);
			});
			tip_close.onclick = function(e){
				TipBox.hide.call(self,e);
			}

		}

		TipBox.show = function(){
			if(!this.display){
				this.tip_box.style.display = '';
				this.display = true;
			}
		};
		TipBox.hide = function(e){
			var e = e || window.event;
			if (! +'\v1') {//ie
				e.cancelBubble = true;
			}else{
				e.stopPropagation();
			}
			
			this.tip_box.style.display = 'none';
			this.display = false;
		};

		
		new TipBox(this[0]);
	
		
	};

})(jQuery);