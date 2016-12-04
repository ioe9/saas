var DOC = DOC || {};
DOC.directory = (function() {
	function loadDir() {
		MIO.dialog.closeDialog(1);
		$('#dir_ctn').load('/admin/document/loadDir');
	}
	function handleEvents() {
		//点击上传文件
		$(".btn-upload").click(function() {
			MIO.dialog.openDialog('/admin/document/uploadFile', '创建文件夹', 860, callbacks, $(this));
		});
	}

	

	//触发改名保存操作
	function renameSave(obj) {
		var newName = $(obj).val();
		if (newName.length == 0) {
			$(obj).parents(".column-filename").find(".text").removeClass('hide');
			$(obj).remove();
		} else {
			var oldName = $(obj).attr('data-oldname');
			var that = obj;
			var item = $(obj).parent().parent();
			if (newName == oldName) {
				$(item).find('span.text').removeClass('hide');
				$(item).find('.input-text-rename').remove();
				return;
			}
			
			var id = $(item).attr("data-dirid");
			var name = $(obj).val();
			var isDir = $(item).attr("isDir");
			if (SimpleTool.isNull(id)) {
				window.top.layer.alert("获取文件ID失败！", -1);
				return;
			}
			if (SimpleTool.isNull(name)) {
				window.top.layer.alert("文件名不能为空！", -1);
				return;
			}
			
			$.post('/admin/document/renameSave',{form_key:FORM_KEY,dir_id:id,dir_name:name},function(res) {
				if(res.succeed) {
					//
					$(item).find('span.text').html(name).removeClass('hide');
					$(item).find('.input-text-rename').remove();
				} else {
					alert(res.msg);
				}
			},'json')
		}
	}
	function loadMovetoDir() {
		var treeContainer = $("#moveto-filepath #tree");
		var url = '/admin/document/loadMovetoDir';
		$.ajax({
			url: url,
			type: 'GET',
			dataType : 'JSON',
			async: false,
			success: function(data){
				var zNodes = data;
				
				var setting = {
					
					view: {
						showLine: false,
						selectedMulti: false
					},
					async: {
						enable: true,
						url: url,
						type: 'GET',
						autoParam: ["id","level"],
						otherParam: {form_key:FORM_KEY}
					},
					callback: {
						//onClick: clickToChose
						beforeClick: beforeClick
					}
				};
				var treeNow = $.fn.zTree.init(treeContainer, setting, zNodes);
				
			}
		})
	}
	function beforeClick(treeId, treeNode) {
		var zTree = $.fn.zTree.getZTreeObj("tree");
		console.log(treeNode);
		zTree.selectNode(treeNode);
		zTree.updateNode(treeNode);
		//jQuery
		return false;
	}
	function getCheckedNodes(){
		var checkedNodes = [];
		var zTree = $.fn.zTree.getZTreeObj("tree");
		var nodes = zTree.getSelectedNodes();
		
		return nodes;
	}
	function loadUploadDir() {
		console.log('loadUploadDir');
		loadUploadTree();
	}
	function loadUploadTree() {
		var treeContainer = $("#utree");
		var url = '/admin/document/loadMovetoDir';
		$.ajax({
			url: url,
			type: 'GET',
			dataType : 'JSON',
			async: false,
			success: function(data){
				var zNodes = data;
				
				var setting = {
					data:{
						simpleData: {
							enable: true
						}
					},
					view: {
						showLine: false,
						dblClickExpand: false
					},
					callback: {
						onClick: clickToChose
					}
				};
				var treeNow = $.fn.zTree.init(treeContainer, setting, zNodes);
				
			}
		})
	}
	function clickToChose(event, treeId, treeNode) {
	    $(".btn-chose-path").text(treeNode.name).attr("data-id",treeNode.id).removeClass("path-open");
	    $("#div-pathtree").hide();
	}
	function loadDirTree(container) {
		var treeContainer = container || $("#tree");
		var url = '/admin/document/loadMovetoDir';
		$.ajax({
			url: url,
			type: 'GET',
			dataType : 'JSON',
			async: false,
			success: function(data){
				var zNodes = data;
				
				var setting = {
					data:{
						simpleData: {
							enable: true
						}
					},
					view: {
						showLine: false,
						dblClickExpand: false
					},
					callback: {
						onCheck: function(){
						
						},
					}
				};
				var treeNow = $.fn.zTree.init(treeContainer, setting, zNodes);
				
			}
		})
	}
	
	//移动相关
	function moveEvents() {
		//点击移动到
		$(".btn-moveto").click(function() {
			var item = $('.dir-grid li.selected');;
			if (item.length == 0) {
				layer.alert('请选择一个要移动的文件或文件夹！', -1);
			} else {
				//判断是否有权限
				var hasPri = $(item).attr("hasPri");
				if (hasPri != "true") {
					window.top.layer.alert("您无移动操作权限！", -1);
					return;
				}
				callbacks.add(loadMovetoDir);
				var dirId = $(item[0]).attr('data-dirid');
				MIO.dialog.openDialog('/admin/document/moveto/?dir_id='+dirId, '选择存储位置', 392, callbacks, $(this));
			}
		});

		//点击列表视图移动到
		$("body").on("click", ".column-moveto",
		function() {
			var item = $(this).parents(".filelist-item");
			if (item.length == 0) {
				layer.alert('请选择一个要移动的文件或文件夹！', -1);
			} else {
				DOC.FileMng.setselectedMoveFileLI(item);
				MIO.dialog.openDialog('/docmanagement/document/moveto', '选择存储位置', 392, callbacks, $(this));
			}
		});
		//点击移动页面上的保存
		$("body").on("click", "#btn-save-moveto",function() {
			var target = getCheckedNodes(); //选中的路径的id
			if (SimpleTool.isNull(target) || target.length <= 0) {
				window.top.layer.alert("请选择一个目标文件夹！", -1);
				return;
			}
			if (target.length > 1) {
				window.top.layer.alert("只能选择一个目标文件夹！", -1);
				return;
			}
			var pid = target[0].id; //目标文件夹的ID
			var item = $(".dir-grid li.selected");
			var id = $(item[0]).attr('data-dirid');
			$.post('/admin/document/movetoSave',{form_key:FORM_KEY,id:id,dir_parent:pid},function(res) {
				if(res.succeed) {
					//
					$(item).find('span.text').html(name).removeClass('hide');
					$(item).find('.input-text-rename').remove();
				} else {
					alert(res.msg);
				}
			},'json')
			
		});
	}

	//执行删除选中的文件
	function excuteFile() {
		//获取选中的要删除的文件DOM
		var item = $('.dir-grid li.selected');
		$this = this;
		if (item.length == 0) {
			layer.alert('请选择一个要删除的文件或文件夹！', -1);
		} else {
			//判断是否有权限
			var hasPri = $(item).attr("hasPri");
			if (hasPri != "true") {
				window.top.layer.alert("您无删除权限！", -1);
				return;
			}
			layer.confirm('确定要删除这个文件吗？<br/><span style="color:#afb5bf;font-size:12px;">如果删除文件夹，内部的文件将都会被删除</span>',
			function(index) {
				//item.remove();
				layer.close(index);
				var dirId = $(item).attr("data-dirid");
				ajaxDeleteDir(dirId);
				
			});
		}
	}
	//删除相关
	function deleteEvents() {
		//点击删除按钮
		$(".btn-delete").click(function() {
			excuteFile();
		});

		//列表页删除
		$("body").on("click", ".column-delete",
		function() {
			var item = $(this).parents(".filelist-item");
			layer.confirm('确定要删除这个文件吗？<br/><span style="color:#afb5bf;font-size:12px;">如果删除文件夹，内部的文件将都会被删除</span>',
			function(index) {
				layer.close(index);
				var dirid = $(item).attr("data-dirid");
				ajaxDeleteDir(dirid,
				function() {
					//刷新
					//DOC.FileMng.reload();
					item.remove();
				});

			});
		});
	}
	function renameEvents() {
		$("body").on("blur",".input-text-rename",function(){ 
			renameSave(this);
		});
		
		$("body").on("keydown",".input-text-rename",function(){ 
			var event = window.event || arguments.callee.caller.arguments[0];
		   if (event && event.keyCode == 13)
			{ // enter 键
				renameSave(this);
			}
		});
	}
	function bindEvents() {
		bindGridEvents();
		renameEvents();
		deleteEvents();
		moveEvents();

		//--------------------创建or设置文件夹------------------------
		$("body").on("click", '.btn-create',
		function() {
			MIO.dialog.openDialog('/admin/document/loadCreateDir', '创建文件夹', 450, callbacks, $(this));

		})
		//列表页重命名
		$("body").on("click", ".btn-rename",
		
			function() {
				var item = $('.dir-grid li.selected');
				renameFile(item);
			});

		//点击上传弹窗路径选择按钮
		$("body").on("click", ".btn-chose-path",
		function() {
			toggleUploadPathLayer($(this));
			
		});
		//点击选择层以外的地方则关闭选择层
		$("body").on('click',
		function(e) {
			var _con = $('#div-pathtree'); // 设置目标区域
			if (!_con.is(e.target) && _con.has(e.target).length === 0 && !$(e.target).hasClass('btn-chose-path')) {
				$(".btn-chose-path").removeClass('path-open');
				_con.hide();
			}
		});
		//点击上传弹窗路径选择按钮
		$("body").on("click", "#btn-startUpload",
		function() {
			DOC.uploadUtil.upload();
		});
		
		//list/grid切换
		$("body").on("click", ".view-as-list",
			function() {
				$('.dir-grid').removeClass('icon-list').addClass('list-list');
				$('#fileListHead').show();
			}
		);
		$("body").on("click", ".view-as-grid",
			function() {
				$('.dir-grid').removeClass('list-list').addClass('icon-list');
				$('#fileListHead').hide();
			}
		);
	}
	
	//Grid 目录列表事件
	function bindGridEvents() {
		$('.dir-grid li').off('click').click(function() {
			$(this).siblings().removeClass('selected');
			$(this).addClass('selected');
		})
		$('.dir-grid li .wish').off('click').click(function() {
			$this = this;
			var dirId = $(this).attr('data-dirid');
			if ($(this).hasClass('wish-checked')) {
				
				$.post('/admin/document/deleteWish',{form_key:FORM_KEY,dir_id:dirId},function(res) {
					if(res.succeed) {
						$($this).removeClass('wish-checked');
					} else {
						layer.alert(res.msg, -1);
					}
				},'json')
			} else {
				$.post('/admin/document/addWish',{form_key:FORM_KEY,dir_id:dirId},function(res) {
					if(res.succeed) {
						$($this).addClass('wish-checked');
					} else {
						layer.alert(res.msg, -1);
					}
				},'json')
			}
				
		})
		$('.dir-grid li .set').off('click').click(function() {
			var dirId = $(this).attr('data-dirid');
			MIO.dialog.openDialog('/admin/document/loadCreateDir?dir_id='+dirId, '设置', 450, callbacks, $(this));
		})
		$('.dir-grid li .icon-folder').off('dblclick').dblclick(function() {
			var id = $(this).attr('data-dirid');
			var pid = $(this).attr('data-dirpid');
			$('#dir_ctn').load('/admin/document/loadDir?dir_parent='+id);
			$('#btn-back').attr('data-dirpid',pid).show();
		})
		$('#btn-back').off('click').click(function(){
			var pid = $(this).attr('data-dirpid');
			$('#dir_ctn').load('/admin/document/loadDir?dir_parent='+pid);
			$(this).hide();
		})
	}
	//设置移动到弹窗信息
	function setMovetoInfo() {
		var item = $('.dir-grid li.selected');;
		var filetype = item.attr("data-filetype");
		var filename = item.find(".text").text();
		var filesize = item.find(".column-size").text();
		$(".moveto-header-type").addClass("icon-" + filetype);
		$(".moveto-header-filename").text(filename).attr("title", filename);
		$(".moveto-header-filesize").text(filesize);
		DOC.treeUtil.createAsyncTree('/admin/document/fetchDirectoryWhoCanOperForZtree');
	}
	//显示or隐藏文件类型选择层
	function toggleUploadPathLayer(btn) {
		if (btn.hasClass('path-open')) {
			//目前是显示状态，隐藏
			$("#div-pathtree").hide();
			btn.removeClass('path-open');
		} else {
			//目前是隐藏状态，显示
			loadUploadDir();
			$("#div-pathtree").show();
			btn.addClass('path-open');
		}

	}

	//删除方法
	function deleteFile(item) {
		if (item.length == 0) {
			layer.alert('请选择一个要删除的文件或文件夹！', -1);
		} else {
			layer.confirm('确定要删除这个文件吗？<br/><span style="color:#afb5bf;font-size:12px;">如果删除文件夹，内部的文件将都会被删除</span>',
			function(index) {
				item.remove();
				layer.close(index);
			});
		}
	}
	function ajaxDeleteDir(dirId) {
		$this = this;
		$.post('/admin/document/deleteDir',{form_key:FORM_KEY,dir_id:dirId},function(res) {
			if(res.succeed) {
				loadDir();
			} else {
				layer.alert(res.msg, -1);
			}
		},'json')
	}
	//移动
	function moveToFile(item) {
		if (item.length == 0) {
			layer.alert('请选择一个要移动的文件或文件夹！', -1);
		} else {
			DOC.dialog.openLayer('/admin/document/moveto', '选择存储位置', 392, "#btn-save-moveto", "#btn-cancel-moveto", setMovetoInfo);
		}
	}
	//重命名
	function renameFile(item) {
		if (item.length == 0) {
			layer.alert('请选择一个要重命名的文件或文件夹！', -1);
		} else {
			item.find(".text").addClass('hide');
			var valueStr = item.find(".text").text();
			var originName = valueStr.split("\.");
			if (originName.length > 1) {
				var oldname = valueStr.replace('.'+originName[originName.length-1],'');
			} else {
				var oldname = originName;
			}
			var inputHtml = '<input data-oldname="'+oldname+'" class="input-text input-text-rename wp100" value="' + valueStr + '"></input>';
			item.find(".column-filename").append(inputHtml);
			
			if (originName.length > 1) {
				setSelectionRange($(".input-text-rename")[0], 0, valueStr.length - (originName[1].length + 1));
			} else {
				$(".input-text-rename").select();
				$(".input-text-rename").focus();
			}

		}
	}
	function setSelectionRange(input, selectionStart, selectionEnd) {
		if (input.setSelectionRange) {
			input.focus();
			input.setSelectionRange(selectionStart, selectionEnd);
		} else if (input.createTextRange) {
			var range = input.createTextRange();
			range.collapse(true);
			range.moveEnd('character', selectionEnd);
			range.moveStart('character', selectionStart);
			range.select();
		}
	}
	return {
		init: function() {
			handleEvents();
			bindEvents();
		},
		bindGridEvents: bindGridEvents,
		loadDir: loadDir,
		deleteFile: deleteFile,
		moveToFile: moveToFile,
		renameFile: renameFile,
		setMovetoInfo: setMovetoInfo
	}
})();
$(function() {
	DOC.directory.init();
});