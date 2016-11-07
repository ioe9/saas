var MIO = MIO || {};
MIO.treeUtil = (function(){
	function createTree(url,container,onCheckCallback,clickCallback,beaforDragback,dropEndback,callbacks){
		//console.log("callBacks"+callbacks);
		var treeContainer = container || $("#tree");
		$.ajax({
				url: url,
				type: 'GET',
				dataType : 'JSON',
				async: false,
				success: function(data){
					var zNodes = data.data;
					//console.log(JSON.stringify(data))
					var setting = {
						check: {
							enable: false
						},
						data: {
							key: { name: "name",
									/*total:"total",*/
									title:"title"
							} ,
							simpleData: {
								enable: true,
								idKey: "id",
								pIdKey: "pId",
								rootPId: 0
							}
						},
						view: {
								showLine: false,
								showIcon: false,
								//addHoverDom: addHoverDom,
								//removeHoverDom: removeHoverDom,
								selectedMulti: false,
								showTitle:true
						},
						callback: {
							beforeClick: clickCallback,
							onCheck: onCheckCallback,
							beforeDrag:beaforDragback,
							onDrop:dropEndback
							//onClick:onClickTree
						},
						edit:{
							enable: true,
							editNameSelectAll: true,
							showRemoveBtn: false,//showRemoveBtn,
							showRenameBtn: false//showRenameBtn
						},
					};
					var treeNow = $.fn.zTree.init(treeContainer, setting, zNodes);

					if (callbacks!=undefined) {
						callbacks.fire(treeNow);
						callbacks.empty();

					}
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
		}
		$.fn.zTree.init($("#tree"), setting);
	}
	function beforeClick(treeId, treeNode) {
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		console.log(treeNode);
		loadOrgStaffTpl("orgStaffList");
		zTree.checkNode(treeNode, !treeNode.checked, true, true);
		return true;
	}
	function clickToChose(event, treeId, treeNode) {
	    $(".btn-chose-path").text(treeNode.name).attr("data-id",treeNode.id).removeClass("path-open");
	    $("#div-pathtree").hide();
	}
	function getCheckedNodes(treeId,type){
		var checkedNodes = [];
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getCheckedNodes(true);
		$.each(nodes,function(index, el) {
			if (!el.getCheckStatus().half && el.type == type) {
				console.log(el.getCheckStatus());
				var temp = {
					id : el.id,
					name : el.name,
					pid : el.pid
				};
				checkedNodes.push(temp);
			}
		});
		return checkedNodes;
	}
	function searchByName(value,type,treeId){
		var result = [];
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getNodesByParamFuzzy("name", value);
		$.each(nodes,function(index, el) {
			if (el.type == type) {
				var temp = {
					id : el.id,
					name : el.name,
					pid : el.pid,
					checked: el.checked
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
					}
				}
			});
	}
	return {
		createTree:createTree,
		getCheckedNodes:getCheckedNodes,
		searchByName:searchByName,
		createAsyncTree:createAsyncTree,
		getSelectedNodes:getSelectedNodes,
		checkedNodes:checkedNodes
	}
})();


function showRemoveBtn(treeId, treeNode) {
	return treeNode.isFirstNode;
}
function showRenameBtn(treeId, treeNode) {
	return treeNode.isLastNode;
}

var newCount = 1;
function addHoverDom(treeId, treeNode) {
	var sObj = $("#" + treeNode.tId + "_span");
	if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
	var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
			+ "' title='add node' onfocus='this.blur();'></span>";
	sObj.after(addStr);
	var btn = $("#addBtn_"+treeNode.tId);
	if (btn) btn.bind("click", function(){
		var zTree = $.fn.zTree.getZTreeObj("tree");
		zTree.addNodes(treeNode, {id:(100 + newCount), pId:treeNode.id, text:"new node" + (newCount++)});
		return false;
	});
}
function removeHoverDom(treeId, treeNode) {
	$("#addBtn_"+treeNode.tId).unbind().remove();
}