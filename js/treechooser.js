var MIO = MIO || {};
MIO.treeUtil = (function(){
	function createDeptTree(url,container,callbacks){
		var treeContainer = container || $("#deptTree");
		$.ajax({
				url: url,
				type: 'GET',
				dataType : 'JSON',
				async: false,
				success: function(data){
					var zNodes = data;
					//console.log(JSON.stringify(data));
					var setting = {
						view: {
								showLine: false,
								showIcon: false,
							dblClickExpand: false
							},
						callback: {
							beforeClick: beforeDeptClick,
						}
					};
					var treeNow = $.fn.zTree.init(treeContainer, setting, zNodes);
					if (callbacks!=undefined) {
						callbacks.fire(treeNow);
						callbacks.empty();
					}
				}
			});
	}

	function createTreePerson(url,container,callbacks){
		var treeContainer = container || $("#personTree");
		$.ajax({
			url: url,
			type: 'GET',
			dataType : 'JSON',
			async: false,
			success: function(data){
				var zNodes = data;
				//console.log(JSON.stringify(data));
				var setting = {
					data:{
						simpleData: {
							enable: true
						}
					},
					view: {
						showLine: false,
						showIcon: showIconForTree,
						dblClickExpand: false
					},
					callback: {
						beforeClick: beforePersonClick,
					}
				};
				var treeNow = $.fn.zTree.init(treeContainer, setting, zNodes);
				if (callbacks!=undefined) {
					//console.log(callbacks)
					callbacks.fire(treeNow);
					callbacks.empty();

				};
			}
		});
	}

	function createAsyncTree(url,isClick){
		var setting = {
			view: {
				showLine: false,
				selectedMulti: false
			},
			async: {
				enable: true,
				url: url,
				autoParam: ["id","level"]
			}
		};
		if (isClick) {
			setting.callback = {
				onClick: clickToChose
			}
		};
		$.fn.zTree.init($("#tree"), setting);
	}

	function showIconForTree(treeId, treeNode){
		return treeNode.type == 3;
	}

	//单击选人节点事件
	function beforePersonClick(treeId, treeNode){
		var zTree = $.fn.zTree.getZTreeObj("personTree");
		zTree.expandNode(treeNode);
	}

	//单击部门节点事件
	function beforeDeptClick(treeId, treeNode) {
		var zTree = $.fn.zTree.getZTreeObj("deptTree");
		zTree.expandNode(treeNode);
	}
	function clickToChose(event, treeId, treeNode) {
	    $(".btn-chose-path").text(treeNode.name).attr("data-id",treeNode.id).removeClass("path-open");
	    $("#div-pathtree").hide();
	}
	function getCheckedNodes(treeId,type){
		var checkedNodes = [];
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getCheckedNodes(true);
		console.log(nodes);
		$.each(nodes,function(index, el) {
			if (!el.getCheckStatus().half && el.type == type) {
				console.log(el.getCheckStatus());
				var temp = {
					id : el.id,
					name : el.name,
					pid : el.pid,
					tId:el.tId
				};
				checkedNodes.push(temp);
			}
		});
		return checkedNodes;
	}
	function searchPersonByName(value,treeId){
		var result = [];
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getNodesByParamFuzzy("name", value);
		//console.log(nodes);
		$.each(nodes,function(index, el) {
			if(el.type == 3){//搜索是人的才取
				var temp = {
					id : el.id,
					name : el.name,
					pid : el.pid,
					checked: el.checked,
					type:el.type,
					tId:el.tId,
					icon:el.icon
				};
				result.push(temp);
			}
		});
		return result;
	}

	//搜索部门树
	function searchDeptByName(value,treeId){
		var result = [];
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getNodesByParamFuzzy("name", value);
		//console.log(nodes);
		$.each(nodes,function(index, el) {
			if(el.type == 2){//搜索是人的才取
				var temp = {
					id : el.id,
					name : el.name,
					pid : el.pid,
					checked: el.checked,
					type:el.type,
					tId:el.tId
				};
				result.push(temp);
			}
		});
		return result;
	}

	function getSelectedNodes(){
		var checkedNodes = [];
		var zTree = $.fn.zTree.getZTreeObj("tree");
		var nodes = zTree.getSelectedNodes();
		$.each(nodes,function(index, el) {
			var temp = {
				id : el.id
			};
			checkedNodes.push(temp);
		});
		return checkedNodes;
	}
	function checkedNodes(url){
		$.ajax({
				url: url,
				type: 'GET',
				async: false,
				success: function(data){
					var ids = data;
					for (var i = 0; i < ids.length; i++) {
						var zTree = $.fn.zTree.getZTreeObj("tree");
						var node = zTree.getNodeByParam("id", ids[i], null);
						zTree.checkNode(node, true, true);
					};
				}
			});
	}
	return {
		createDeptTree:createDeptTree,
		createTreePerson:createTreePerson,
		getCheckedNodes:getCheckedNodes,
		searchPersonByName:searchPersonByName,
		searchDeptByName:searchDeptByName,
		createAsyncTree:createAsyncTree,
		getSelectedNodes:getSelectedNodes,
		checkedNodes:checkedNodes
	}
})();

var MIO = MIO || {};
MIO.chooser = (function () {
	var callbacks = $.Callbacks();
	var oldDataArr = [];
	var myconfirmFn = '';
	var _selector = '';
	var _params = {};

	function initEvents(){//初始化事件

	}

	function initTreeDialog(option) {
		//console.log(option)
		if(option.btnobj){
			oldDataArr = option.oldData || [];
			myconfirmFn = option.confirmFn || '';
			_selector = option.selector || '';
			_params = option.args||{};
			callbacks.add(oldDataAdd);//已经选过的数据填充
			callbacks.add(saveChoseTree);//保存树
			callbacks.add(cancelChoseTree);//取消选择
			callbacks.add(initParms);//初始化一些参数(主要是应用权限和管理看板页面需要)
			if (option.btnobj.open_type == "dept") {
				callbacks.add(initDeptTree);//初始化部门树
				MIO.dialog.openDialog('/admin/setting_tree/getDeptChooser', '选择部门', 510, callbacks,'',true);
			} else if (option.btnobj.open_type == "person") {//人员弹窗
				callbacks.add(initPersonTree);//初始化人员树
				MIO.dialog.openDialog('/admin/setting_tree/getStaffChooser', '选择人员',510, callbacks,'',true);
			} else if(option.btnobj.open_type =='personAndDept'){//人和部门在同一个弹窗中切换
				callbacks.add(initDeptTree);//初始化部门树//callbacks.add(initPersonTree);
				MIO.dialog.openDialog('/admin/setting_tree/getChooser', '选择人员',510, callbacks,'',true);
			} else if(option.btnobj.open_type == 'appset'){//应用权限设置
				callbacks.add(initPersonTree);
				if(option.args){
					//console.log(option.args);
					MIO.dialog.openDialog('/yop/pc/test/app_set',(option.args.appName||'')+'设置',557, callbacks,'',true);
				}
			} else if(option.btnobj.open_type == 'boradset'){//管理看板设置
				callbacks.add(initPersonTree);
				if(option.args){
					//console.log(option.args);
					MIO.dialog.openDialog('/yop/pc/test/borad_set',(option.args.appName||'')+'设置',557, callbacks,'',true);
				}
			}
		}

		//人员部门切换
		$('body').on('click','.tree-tab .tree-tab-item',function(){
			$('.tree-tab .tree-tab-item').removeClass('active');
			$(this).addClass('active');
			if($(this).attr('_type') == 'colleage'){//点击切换人
				/*$('#personTreeWrap').show(function(){
					initPersonTree();
				});*/
				$('#deptTreeWrap').hide();
                $('#personTreeWrap').show();
                initPersonTree();
                $('#personTreeWrap input[name="personName"]').val("");
			} else if($(this).attr('_type') == 'dept'){//点击切部门
				$('#personTreeWrap').hide();
				$('#deptTreeWrap').show();
                initDeptTree();
                $('#deptTreeWrap input[name="deptName"]').val("");
			}
            $('.tree-scrollerbar').scrollTop(0);
		});

		/*******************选人tree操作********************/
		//鼠标移到选人的树上
		$('body').on('mouseenter','#personTree.ztree li > div',function(){
			var treeNode = $.fn.zTree.getZTreeObj("personTree").getNodeByTId($(this).closest('li').attr('id'));
			var leafArr = [];
			leafArr = getAllChildrenNodes(treeNode,leafArr);
			if(leafArr && leafArr.length > 0){//下面有人的叶子节点,则右边出现加号
				if($(this).find('.tree-add-icon').length == 0){
					var html = '<i class="chose-person-icons tree-add-icon" title="添加全组人员"></i>';
					$(this).append(html);
				}
			}
		});
		//鼠标从选人的树上移除
		$('body').on('mouseleave', '#personTree.ztree li > div', function () {
			$(this).find('.tree-add-icon').unbind().remove();
		});

		//点击选人的加号
		$('body').on('click','#personTree .tree-add-icon',function(e){
			var treeNode = $.fn.zTree.getZTreeObj("personTree").getNodeByTId($(this).closest('li').attr('id'));
			var leafArr = [];
			var result = getAllChildrenNodes(treeNode,leafArr);
			addSelectResult(result);
		});

		//点击人的tree节点和人的搜索结果,添加人
		$('body').on('click','#personTree.ztree li > div[type="3"],#personTreeWrap .search-list div',function(){
			var treeNode = $.fn.zTree.getZTreeObj("personTree").getNodeByTId($(this).closest('li').attr('id'));
			addSelectResult([treeNode]);
		});

		/**************部门tree操作***********************/
			//鼠标移到选部门的树上
		$('body').on('mouseenter','#deptTree.ztree li > div',function(){
			var treeNode = $.fn.zTree.getZTreeObj("deptTree").getNodeByTId($(this).closest('li').attr('id'));
			var leafArr = [];
			leafArr = getAllChildrenDeptNodes(treeNode,leafArr);
			//console.log(leafArr);
			if(leafArr && leafArr.length > 0){//下面有人的叶子节点,则右边出现加号
				if($(this).find('.tree-add-icon').length == 0){
                    var titleTxt = '添加此部门';
                    if($(this).attr('type') == 1){
                        titleTxt = '添加全公司';
                    } else {
                        titleTxt = '添加此部门';
                    }
					var html = '<i class="chose-person-icons tree-add-icon" title="'+titleTxt+'"></i>';
					$(this).append(html);
				}
			}
		});
		//鼠标从选部门的树上移除
		$('body').on('mouseleave', '#deptTree.ztree li > div', function () {
			$(this).find('.tree-add-icon').unbind().remove();
		});

		//点击部门的加号,把部门拿过去
		$('body').on('click','#deptTree .tree-add-icon',function(e){
			var treeNode = $.fn.zTree.getZTreeObj("deptTree").getNodeByTId($(this).closest('li').attr('id'));
			//var leafArr = [];
			//var result = getAllChildrenDeptNodes(treeNode,leafArr);
			addSelectResult([treeNode]);
		});

		//点击部门节点,且部门是叶子节点才可以点击
		$('body').on('click','#deptTree.ztree li > div[type="2"]',function(e){
			var treeNode = $.fn.zTree.getZTreeObj("deptTree").getNodeByTId($(this).closest('li').attr('id'));
			var leafArr = [];
			var result = getAllChildrenDeptNodes(treeNode,leafArr);
			if(result.length > 0){//如果此部门下面还有部门,则不能直接点击此部门添加,要点击加号添加
				return;
			}
			addSelectResult([treeNode]);
		});

		//点击部门搜索结果
		$('body').on('click','#deptTreeWrap .search-list div',function(){
			var treeNode = $.fn.zTree.getZTreeObj("deptTree").getNodeByTId($(this).closest('li').attr('id'));
			addSelectResult([treeNode]);
		});


		/**********************结果集操作*************************/
		//点搜索按钮搜素选人tree
		$('body').on('click', '#personTreeWrap .tree-search-icon', function () {
            searchPerson();
		});

        //回车搜索人
        $('body').on('keydown','#personTreeWrap input[name="personName"]',function(e){
            if(e.keyCode == 13){
                searchPerson();
            }
        });

        //清空搜人输入框
		$('body').on('keyup','#personTreeWrap input[name="personName"]',function(){
			var val = $(this).val();
			if(val == 0){
				$(".data-wrap").hide();
				$("#personTree").show();
                initPersonTree();
			}
		});

		//点搜索按钮搜素部门tree
		$('body').on('click', '#deptTreeWrap .tree-search-icon', function () {
            searchDept();
		});

        //回车搜索部门
        $('body').on('keydown','#deptTreeWrap input[name="deptName"]',function(e){
            if(e.keyCode==13){
                searchDept();
            }
        });

        //清空搜部门输入框
		$('body').on('keyup','#deptTreeWrap input[name="deptName"]',function(){
			var val = $(this).val();
			if(val == 0){
				$(".data-wrap").hide();
				$("#deptTree").show();
                initDeptTree();
			}
		});

		//删除选择项
		$('body').on('click', '#selected-list .close-node', function () {
			$(this).closest('li').remove();
			calculateNum();
		});
	}

	/**********************提交取消操作*****************************/
	//提交选中的树
	function saveChoseTree(index){
		$(this).find('.chose-confirm').click(function(){
			var arr = [];
			$('#selected-list').find('li').each(function(){
				var that = $(this);
				if(_params.goodId){
					var goodId = _params.goodId;
				}
				if(_params.appCode){
					var appCode = _params.appCode;
				}
				arr.push({'type':1,'data_type':that.attr('_type'),'id':that.attr('id'),'name':that.find(".node-name").text(),'header':that.find('img').attr('src'),'goodId':goodId,'appCode':appCode});
			});
			if($('#selected-list').find('li').length == 0){//如果没有选中任何人,那么应用权限设置和管理看板设置需要goodId和appCode
				if(_params.goodId){
					var goodId = _params.goodId;
				}
				if(_params.appCode){
					var appCode = _params.appCode;
				}
				arr.push({'type':0,'goodId':goodId,'appCode':appCode});
			}
			if(typeof myconfirmFn == 'function'){
				myconfirmFn(arr,oldDataArr);//执行函数
				oldDataArr = [];
			}
			layer.close(index);
		});
	}

	function cancelChoseTree(index){//取消选择树
		if(_selector && _selector.length > 0){
			$.enable(_selector);
			$.removeLoading();
		}
		$(this).find('.chose-cancel').click(function(){
			layer.close(index);
		});
	}

	function initParms(index){
		if(_params){
			//console.log(_params);
			$(this).find('.appIcon').attr('src',(_params.appImg || '/yop/static/app/yop/images/v3/workbench-icon.png'));
			$(this).find('.app-name').text(_params.appName || '');
			$(this).find('.used-nums').text(_params.usedNum || '');
			$(this).find('.remind-nums').text(_params.remindNums || '');
			$(this).find('.time-out-span').text(_params.timeOut || '');
			$(this).find('.broad-des-txt').text(_params.broadDes || '');
		}
	}

	function oldDataAdd(){
		//console.log(oldDataArr);
		addSelectResult(oldDataArr);
	}

	/***********************公用初始化人员和部门tree方法***************************/
	function initDeptTree(){//初始化部门树
		MIO.treeUtil.createDeptTree('/admin/setting_tree/getDeptData',$('#deptTree'),callbacks);
	}

	function initPersonTree(){//初始化人员树
		MIO.treeUtil.createTreePerson('/admin/setting_tree/getStaffData',$('#personTree'),callbacks);
	}

	/************************一些公用方法***************************/
	//选中结果放入右边
	function addSelectResult(data){
		//console.log(data)
		if(!data || data.length==0){
			return;
		}
		var html = '';
		for(var i=0;i < data.length;i++){
			if($('#selected-list').find('#'+data[i].id).length > 0){//如果已经添加过了,则不要重复添加
				//console.log(data[i].id);tId="'+data[i].tId+'"
				//tips("请不要重复添加！", 0, 500);
				continue;
			}
			var headerIcon = '';
			if(data[i].icon){
				//console.log(data[i].icon);
				headerIcon = '<img class="tree-header" src="'+data[i].icon+'"/>';
			}
			if(data[i].type==1||data[i].type==2){//添加的是部门,则加上静态头像
				headerIcon = '<img class="tree-header" src="/yop/static/app/yop/images/v3/def-dept-icon.png"/>';
			}

			html = '<li id="'+data[i].id+'"  _type="'+data[i].type+'">'
					+ headerIcon
					+'<span class="node-name break">'+data[i].name+'</span>'
					+'<span class="chose-person-icons close-node"></span>'
					+'</li>';
			//console.log(html);
			//console.log(data[i].name);
			$('#selected-list').prepend(html);//append(html)//
		}
		calculateNum();
	}

	//统计选中的节点
	function calculateNum(){
		var selectNumDept = $('#selected-list').find('li[_type="2"]').length + $('#selected-list').find('li[_type="1"]').length;//已选部门统计
		var selectNumPerson = $('#selected-list').find('li[_type="3"]').length;//已选人员统计
		$('.select-num-dept').text(selectNumDept);
		$('.select-num-person').text(selectNumPerson);
	}

	//获取人的子节点
	function getAllChildrenNodes(treeNode,result){
		if (treeNode.isParent) {
			var childrenNodes = treeNode.children;
			if (childrenNodes) {
				for (var i = 0; i < childrenNodes.length; i++) {
					if(childrenNodes[i].isParent){
						getAllChildrenNodes(childrenNodes[i], result);
					}else if(childrenNodes[i].type=='3'){//叶子节点是人的才要选中
						//result += ',' + childrenNodes[i].name;
						result.push(childrenNodes[i]);
					}
				}
			}
		}
		//console.log(result);
		return result;
	}

	//获取部门的子节点
	function getAllChildrenDeptNodes(treeNode,result){
		if (treeNode.isParent) {
			var childrenNodes = treeNode.children;
			if (childrenNodes) {
				for (var i = 0; i < childrenNodes.length; i++) {
					if(childrenNodes[i].isParent){
						getAllChildrenDeptNodes(childrenNodes[i], result);
					}else if(childrenNodes[i].type=='2'){//叶子节点是人的才要选中
						//result += ',' + childrenNodes[i].name;
						result.push(childrenNodes[i]);
					}
				}
			}
		}
		return result;
	}

    //搜索人的公共方法
    function searchPerson(){
        var value = $('#personTreeWrap input[name="personName"]').val();
        //console.log(value);
        var result = MIO.treeUtil.searchPersonByName(value, "personTree");
        if (value.length === 0) {
            $(".data-wrap").hide();
            var zTree = $.fn.zTree.getZTreeObj("personTree");
            $("#personTree").show();

        } else if (result.length === 0 && value.length != 0) {
            var searchHtml = "<li class='nodata-li'>没有找到要搜索的内容</li>";
            $("#personTree").hide();
            $(".data-wrap").show().find('.search-list').html(searchHtml);
        } else {
            //显示搜索结果
            var searchHtml = "";
            for (var i = 0; i < result.length; i++) {
                var node = result[i];
                var iconHmtl = ''
                if(node.icon){
                    iconHmtl = '<img class="search-result-img" src="'+node.icon+'"/>';
                }
                searchHtml += '<li id="' + node.tId + '"><div>'+iconHmtl+'<a href="javascript:;" data-id-search="' + node.id + '" data-type="' + node.type + '" data-name="' + node.name + '" class="">' + node.name + '</a></div></li>';
            }
            $("#personTree").hide();
            $(".data-wrap").show().find('.search-list').html(searchHtml);
        }
    }

    //搜索部门的公共方法
    function searchDept(){
        var value = $('#deptTreeWrap input[name="deptName"]').val();
        //console.log(value);
        var result = MIO.treeUtil.searchDeptByName(value, "deptTree");
        if (value.length === 0) {
            $(".data-wrap").hide();
            var zTree = $.fn.zTree.getZTreeObj("deptTree");
            $("#deptTree").show();
        } else if (result.length === 0 && value.length != 0) {
            var searchHtml = "<li class='nodata-li'>没有找到要搜索的内容</li>";
            $("#deptTree").hide();
            $(".data-wrap").show().find('.search-list').html(searchHtml);
        } else {
            //显示搜索结果
            var searchHtml = "";

            for (var i = 0; i < result.length; i++) {
                var node = result[i];
                searchHtml += '<li id="' + node.tId + '"><div><a href="javascript:;" data-id-search="' + node.id + '" data-type="' + node.type + '" data-name="' + node.name + '" class="">' + node.name + '</a></div></li>';
            }
            $("#deptTree").hide();
            $(".data-wrap").show().find('.search-list').html(searchHtml);
        }
    }

	return {
		initTreeDialog:initTreeDialog
	}
})();



