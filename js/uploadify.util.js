var DOC = DOC || {};
DOC.uploadUtil = (function(){
	var dictionary = {
		pic : ['.png','.bmp','.jpg','.jpeg','.tiff','.gif','.pcx','.tga','.exif','.fpx','.svg','.cdr','.pcd','.dxf','.ufo','.eps','.ai','.raw'],
		doc : ['.doc','.docx','.docm','.dot','.dotx','.dotm'],
		xsl : ['.xls','.xlsx','.xlsm','.xltx','.xltm','.xlsb','.xlam'],
		ppt : ['.ppt','.pptx','.pptm','.ppsx','.ppsx','.potx','.potm','.ppam'],
		music : ['.wav','.aif','.au','.mp3','.ram','.wma','.mmf','.amr','.aac','.flac','.ra','mid'],
		zip : ['.zip','.rar','.gz','.z','.arj'],
		video : ['.avi','.rmvb','.swf','.rm','.asf','.divx','.mpg','.mpeg','.mpe','.wmv','.mp4','.mkv','.vob'],
		dll : ['.dll'],
		html : ['.htm','.html'],
		pdf : ['.pdf'],
		txt : ['.txt']
	}
	var _count=0;
	//var _countS = 0;
	var _uploadSuccessCount=0;
	var _successCallback=null;
	function createUploader(successCallback){
		_successCallback=successCallback;
		$('#add-uploadfile').uploadify({
		       'uploader': '/admin/document/uploadFileSave',
	           'swf': '/media/tools/uploadify.swf',
	           'queueID': 'fileQueue',
	           'multi': true,
	  
	           'auto': false,
	           'buttonText' : '',
	           'width': 72,
	           'height': 62,
	           'removeCompleted' : false,
	           'buttonImage' : '/skin/adminhtml/default/default/images/document/add-file.png',
	           'fileSizeLimit' : '100MB',
	           'itemTemplate' : '<li class="file-item pr" id="${fileID}">\
									<div class="cancel">\
        								<a href="javascript:$(\'#${instanceID}\').uploadify(\'cancel\', \'${fileID}\')">X</a>\
    								</div>\
									<div class="upload-file"></div>\
										<div class="upload-file-filename break">${fileName} (${fileSize})</div>\
										<span class="data"></span>\
										<div class="uploadify-progress">\
										<div class="uploadify-progress-bar"></div>\
									</div>\
								</li>',
				//没有兼容的FLASH时触发
		        'onFallback':function(){
		            layer.alert("您未安装FLASH控件，无法上传文件！请安装FLASH控件后再试",-1);
		        },
	           'formData': { 'fid': 1,'accesstype': '04','form_key':FORM_KEY},
	           'onSelect': function (file) {
	           		_count++;
	           		// _countS++;
	           		var filetype = witchType(file.type);
	           		$('#'+file.id).find('.upload-file').addClass('icon-'+filetype);
	           		// $("#dialog-chosed-file-num").text(_countS);
	           },
	           'onQueueComplete': function () {
	              // _countS = 0;
	              // $('#add-uploadfile').uploadify('cancel', '*');
	           },
	           'onSelectError':function(file, errorCode, errorMsg){
                   switch(errorCode) {
                       case -100:
                           layer.alert("上传的文件数量已经超出系统限制的"+$('#add-uploadfile').uploadify('settings','queueSizeLimit')+"个文件！",-1);
                           break;
                       case -110:
                           layer.alert("文件 ["+file.name+"] 大小超出系统限制的"+$('#add-uploadfile').uploadify('settings','fileSizeLimit')+"！",-1);
                           break;
                       case -120:
                           layer.alert("文件 ["+file.name+"] 大小异常！",-1);
                           break;
                       case -130:
                           layer.alert("文件 ["+file.name+"] 类型不正确！",-1);
                           break;
                           default:
                               layer.alert("文件 ["+file.name+"] 异常！",-1);
                   }
               },
	           'onUploadStart': function (file) {
	               var fid = $('.btn-chose-path').attr('data-id');
	               //$("#add-uploadfile").uploadify("settings", "formData", {"fid":fid});
	               var auth = $.cookie('MY_TOKEN_NAME_DOCMANAGEMENT');
	               var SessionId = $.cookie('PHPSESSID');
	               $("#add-uploadfile").uploadify("settings", "formData", {"fid":fid,"MY_TOKEN_NAME_DOCMANAGEMENT":auth,'accesstype': '04',"PHPSESSID":SessionId});
	               $('#' + file.id).find('.data').hide();
	           },
	           'onUploadSuccess' : function(file, data, response) {
	           		console.log(data);
		            $('#' + file.id).find('.data').html('完成').show();
		            $('#' + file.id).find('.cancel').hide();
		            var num = $("#dialog-chosed-file-num").text()-1;
		            $("#dialog-chosed-file-num").text(num);
		        },
		        'onUploadComplete':function(p1,p2)
		        {
	               _uploadSuccessCount++;
	               //console.log("上载完成！"+_uploadSuccessCount+","+_count);
	               if(_uploadSuccessCount>=_count)
	               {
	               	  if(typeof(_successCallback)=="function")
	               	  {
	               	  	 //console.log("执行回调");
	               	  	 _successCallback();//回调
	               	  }
	               }
		        },
		        'onCancel' : function(file) {
		            // --_countS;
		            // if (_countS < 0) {_countS = 0;};
		            // $("#dialog-chosed-file-num").text(_countS);
		        }
		});
	}
	function witchType(type){
		var filetype = 'default';
		$.each(dictionary,function(key, el) {
			var isFind = $.inArray(type, el);
			if (isFind != -1) {
				filetype = key;
				return false;
			}
		});
		return filetype;
	}
	function upload(){
		if(_count<=0)
		{
			layer.alert("请至少选择一个文件在开始上传！",-1);
			return ;
		}
		$('#add-uploadfile').uploadify('upload','*');
	}
	return {
		createUploader:createUploader,
		upload:upload
	}
})();
