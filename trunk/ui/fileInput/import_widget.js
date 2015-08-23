function CreateInputFile(obj, import_tip,submit_value,callback){
	var str = "";
	if(CreateInputFile.is_chrome()){
		obj.className = "file-box-fix";
	
		var oFragment = document.createDocumentFragment(),
			label = document.createElement('label'),	   
			file_txt = document.createElement('input'),
			file_btn = document.createElement('input'),
			file_input = document.createElement('input'),
			file_sub = document.createElement('input');
		file_txt.type = 'text';
		file_txt.className = 'file_txt';
		file_txt.setAttribute('readonly',true);

		label.innerHTML = import_tip;
		label.className = "import_tip";

		file_btn.type = "button";
		file_btn.value = "浏览..."
		file_btn.className = "file_browse";

		file_input.type = "file";
		file_input.className = "import_file";


		file_sub.type = "button";
		file_sub.name =  "submit";
		file_sub.value = submit_value;
		file_sub.className = "import_file_btn";

		file_input.onchange = function(){
			file_txt.value = file_input.value;
		}
		file_sub.onclick = function(e){
			file_txt.value = '';
			var e = e || window.event;
			callback(e);
		};

		oFragment.appendChild(label);
		oFragment.appendChild(file_txt);
		oFragment.appendChild(file_btn);
		oFragment.appendChild(file_input);
		oFragment.appendChild(file_sub);

		obj.appendChild(oFragment);

	}else{
		obj.className = "file-box";
		str += "<label class='import_tip'>"+import_tip+"</label>";
		str += "<input name='import_file' type='file' size='22' class='import_file' />";
		str	+= "<input name='submit' type='button' class='import_file_btn' value='"+submit_value+"' onclick="+callback+" />";
		obj.innerHTML = str;
	}
}

CreateInputFile.is_chrome = function(){
	var userAgent = navigator.userAgent.toLowerCase();
	if(userAgent.indexOf('webkit')!=-1){
		return true;
	}
	return false;
}