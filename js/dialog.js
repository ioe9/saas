var MIO = MIO || {};
MIO.dialog =(function(){
	function createLayer(title,html,width,callbacks,selector,isFix){
		$.layer({
			type : 1,
			fix : isFix||false,
			move: false,
			title : [title],
			area : [width, 'auto'],
			page :{
				html:html
			},
			success: function(layero,index){
				if (callbacks!=undefined) {
					callbacks.fireWith(layero,[index]);
					callbacks.empty();
				};
				layer.autoArea(index);
				$(".xubox_main").css("height", "auto");
				$(layero).find('.xubox_close').focus();
				//绑定取消按钮
				$(layero).find(".btn-cancel").click(function(){
					layer.close(index);
				});
				//弹出框解除
				selector && $.enable(selector);
			}
		});
	}
	
	//保存弹窗index
	function saveLayerIndex(index,save,cancel){
		$(save).attr("dialog-index",index);
		$(cancel).attr('dialog-index', index);
	}
	function openDialog(url,title,width,callbacks,selector,isFix){
		$.ajax({
				url: url,
				type: 'GET',
				async: false
			}).done(function(data){
				 if (SimpleTool.hasAjaxException(data,null))
					{
						// 如果出现了ajax异常
						return;
					}//cj
					var dialogHtml = data;
					createLayer(title,dialogHtml,width+'px',callbacks,selector,isFix);
			});
	}
	function closeDialog(index) {
		layer.close(index);
	}
	//图片预览层
	function createImgLayer(html){
		$.layer({
		    type: 1,
		    area: ['auto', 'auto'],
		    closeBtn: [1, true],
		    maxWidth: '70%',
		    title: false,
		    border: [0],
		    page: {html:html}
		});
	}
	return {
		openDialog:openDialog,
		closeDialog:closeDialog,
		createLayer:createLayer,
		createImgLayer:createImgLayer
	}
})();
