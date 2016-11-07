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
		createLayer:createLayer,
		createImgLayer:createImgLayer
	}
})();

/**
 * 表单弹窗
 */
MIO.formDialog = (function(){
	/**
	 * 打开一个弹窗
	 * @param url 弹窗地址
	 * @param width 弹窗宽度
	 * @param callbacks回调函数
	 *  @param option按钮样式和文字和点击打开弹窗的按钮对象(自定义样式控制)
     * @private
     */
	function _openDialog(url,width,callbacks,option){
		$.ajax({
			url: url,
			type: 'GET',
			async: false
		}).done(function(data){
			var _zId = 10000;
			var _width = 900;//默认宽度900px
			//var _titlTxt = {//按钮控制参数
			//	'btnArr':[
			//		{'txt':'提交','classClick':'dg-btn-save'}
			//	],
			//	'btnClass':'dg-btn-normal',
			//};
			//弹窗默认样式
			var _defOption = {
				'header':{
					'height':45,
					'line_height': 50,
					'border_bottom':'1px solid #eaebec',
					'background':'#fff',
					'padding_left':30,
					'padding_right':30
				},
				'btns':{
					'btnShow':'true',
					'btnWrap':{
						'height':45,
						'line_height':45,
						'margin_left':10
					},
					'title':{
						'titleTxt':''
					},
					'btnArr':[
						{'txt':'提交','classClick':'dg-btn-save','btnColor':'dg-btn-blue'}
					],
					'btnClass':'dg-btn'
				},
				'dg_wrap':{
					'background':'#fff'
				}
			};
			var _option = $.extend({},_defOption,option);
			//console.log(JSON.stringify(_option))
			if(parseInt(width) > 0){
				_width = width;
			}
			if($('.wrap').find('.yop-dg-wrap').length>0){//如果是已经打开过窗口
				 _zId = _zId+$('.wrap').find('.yop-dg-wrap').length;
			}
			var _dgwIndex    = 'yop-dg-wrap'+_zId;//弹窗id
			var _dgsIndex    = 'yop-dg-shade'+_zId;//遮罩id
			var _dgwScollId  = 'dg-content-wrapout'+_zId;//滚动条id
			var _windowH = document.documentElement.clientHeight-parseInt(50+parseInt(_option.header.height))+'px';//获取可见窗口的高度,减去头部banner距离
			$(window).resize(function() {//当窗口大小发生改变的时候,重新计算弹窗的高度
				_windowH = document.documentElement.clientHeight-parseInt(50+parseInt(_option.header.height))+'px';
				$('#'+_dgwScollId).css('height',_windowH);
			});
			var _rizeAndGap  = 'width:'+_width+'px !important;'+'margin-left:'+(1300-_width)+'px !important;';
			//弹窗content样式
			var _dgwinStyle  = 'width:'+'100%;'
							 + 'height:'+_windowH
							 + ';overflow:'+'hidden;'
					         + 'background:' + _option.dg_wrap.background+';';
			//弹窗header自定义样式
			var _headerStyle = 'height:'+_option.header.height+'px;'
					         + 'line-height:'+_option.header.line_height+'px;'
							 + 'border-bottom:'+_option.header.border_bottom+';'
							 + 'background:'+_option.header.background+';'
							 + 'padding-left:'+_option.header.padding_left+'px;'
					         + 'padding-right:'+_option.header.padding_right+'px;';
			//按钮样式
			var _btnwrapStyl = 'height:'+_option.btns.btnWrap.height+'px;'
			   				 + 'line-height:'+_option.btns.btnWrap.line_height+'px;'
							 + 'margin-left:'+_option.btns.btnWrap.margin_left+'px;';

			var _btnHtml = '';
			if(_option.btns.btnShow == 'true'){//按钮初始化
				if(_option.btns.btnArr.length>0){
					for(var i = 0;i < _option.btns.btnArr.length;i++){
						_btnHtml += /*'<div class="dg-btn-wrap" style="'+_btnwrapStyl+'">'*/
								 '<a href="javascript:;" class="'+_option.btns.btnClass+' '+_option.btns.btnArr[i].btnColor+' '+_option.btns.btnArr[i].classClick+'">'+_option.btns.btnArr[i].txt+'</a>';
								/*'</div>';*/
					}
				}
			}

			var _titlHtml = '';
			if(_option.title.titleTxt.length > 0){
				_titlHtml = '<span class="f14" style="position: absolute;top:-3px;left: 40%;">'+_option.title.titleTxt+'</span>';
			}

			//弹窗初始化
			var _$dgwrap = $('<div class="yop-dg-wrap" style="'+_rizeAndGap+'" id="'+_dgwIndex+'" data-index="'+_zId+'">' +
							'<div class="dg-header" style="'+_headerStyle+'">' +
							'<i class="close-btn close-dialog"></i>'+
							_titlHtml +
							'<div class="btn-wrapout" style="float: right;line-height: 40px;margin-top: 3px;">'+_btnHtml+'</div>'+
							'</div>'+
							'<div class="dg-content-wrapout" style="'+_dgwinStyle+'" id="'+_dgwScollId+'">'+
							'<div class="dg-content">'+data+'</div>'+
							'</div>'+
							'</div>');//新建窗体wrap
			var _$dgshade = $('<div class="yop-dg-shade" id="'+_dgsIndex+'"></div>');//窗体的遮罩
			$('.wrap').append(_$dgshade,_$dgwrap);//弹窗窗体
			//窗口遮罩向下展开(默认300毫秒)
			_$dgshade.show();//slideDown(300);
			//窗口向下展开(默认300毫秒)
			_$dgwrap.slideDown(300,function(){
				var _scollbar = $('#'+_dgwScollId);
				//添加滚动条并修改滚动条样式
				_scollbar.mCustomScrollbar({
				    scrollEasing:"linear",
				    scrollInertia:300
				});
				_scollbar.find('.mCSB_dragger:hover').css("background-color", "#ccc");
				_scollbar.find('.mCSB_draggerRail').css({"width": "1px", "background-color": "#ccc"});
				_scollbar.find('.mCSB_dragger_bar').css({"width": "6px", "background-color": "#ccc"});
				_scollbar.find('.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar').css({'margin-right':'1px'});
				_scollbar.find('.mCSB_scrollTools .mCSB_draggerRail').css({'margin-right':'3px'});

				if (callbacks!=undefined) {
					callbacks.fireWith($('#'+_dgwIndex)/*_$dgwrap*/,[_zId]);
					callbacks.empty();
					_closeCurrentDg(_zId);
				};
				//弹出框解除
				if(_option.selector && _option.selector.length > 0){
					$.enable(_option.selector);
				}
			});
		});
	}

	/**
	 * 关闭按钮关闭当前弹窗(最后一层)
	 * @private
     */
	function _closeCurrentDg(index){
		var _currentContent = $('#yop-dg-wrap'+index/*$(content).attr('id')*/);//当前弹窗层
		var _currentShade = $('#yop-dg-shade'+index/*$(content).attr('data-index')*/);//当前遮罩层
		_currentContent.find('.close-dialog').click(function(){
			_currentContent.slideUp(300,function(){
				_currentContent.remove();
				_currentShade.remove();
			});
			//_currentShade.slideUp(300,function(){
			//	_currentShade.remove();
			//});
		});
	}

	/**
	 * 外部调用关闭当前弹窗(最后一层)
	 * @private
	 */
	function _close(index){
		var _currentContent = $('#yop-dg-wrap'+index);//当前弹窗层
		var _currentShade = $('#yop-dg-shade'+index);//当前遮罩层
		_currentContent.slideUp(300,function(){
			_currentContent.remove();
			_currentShade.remove();
		});
		//_currentShade.slideUp(300,function(){
		//	_currentShade.remove();
		//});
	}

	/**
	 * 关闭所有弹窗
	 * @private
     */
	function _closeAllDg(){
		$('.yop-dg-wrap').slideUp(300,function(){
			$('.yop-dg-wrap').remove();
			$('.yop-dg-shade').remove();
		});
		//$('.yop-dg-shade').slideUp(300,function(){
		//	$('.yop-dg-shade').remove();
		//});
	}

	/**
	 * 获取参数设置 obj
	 * @param selector 要锁的按钮
	 * @param bgc 背景色
	 * @param btnShow 是否显示按钮
	 * @param btnArr 按钮的数量(数组)
	 * @param hbgc 头部背景色
	 * @param hh 头部高度
	 * @param hlh 头部行高
     * @param hr 头部右边距
     * @private selector,bgc,btnShow,btnArr,hr,hbgc,hh,hlh
     */
	function _setOption(obj){
		var _myOption = {
			'header':{
				'height':obj.hh||45,
				'line_height': obj.hlh||50,
				'border_bottom':obj.hbb||'1px solid #eaebec',
				'background':obj.hbgc||'#fff',
				'padding_left':obj.hpl||30,
				'padding_right':obj.hr||30
			},
			'title':{
				'titleTxt':obj.titleTxt||''
			},
			'btns':{
				'btnShow':obj.btnShow||'true',
				'btnWrap':{
					'height':obj.btnwh||45,
					'line_height':obj.btnwlh||45,
					'margin_left':obj.btnwml||10
				},
				'btnArr':obj.btnArr||[{'txt':'提交','classClick':'dg-btn-save','btnColor':'dg-btn-blue'}],
				'btnClass':'dg-btn'
			},
			'dg_wrap':{
				'background':obj.bgc||'#fff'
			},
			'selector':obj.selector
		}
		//var _option = $.extend({},_defOption,option);
		return _myOption;
	}

	return{
		openDialog:_openDialog,
		closeCurrentDg:_closeCurrentDg,
		closeAllDg:_closeAllDg,
		close:_close,
		setOption:_setOption
	}
})();