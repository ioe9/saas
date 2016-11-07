/**
 * description :组织结构--在职员工
 */
var MIO = MIO || {};
MIO.ORG_SET = (function () {
    var parentDept = {};//上级部门
    var currentDept = {};//当前部门
    //var callbacks = $.Callbacks();
    //初始化函数
    function initEvents() {
        //SimpleTool.createGlobMaskLayer();// 蒙上遮罩层
        $.showLoading();
    	//MIO.COMMON_MM.tabSelect();
        //initScrollerbar('#ztreeWrap');

        MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
            "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
		defTreeHover();
        loadStaff();
        //列表加滚动条
    }

    /**
     * 响应事件绑定
     */
    function bindEvents() {
        /********************人员列表复选操作**********************/
        $('body').on("click", ".icon-unchecked", function () {//选择人员
            if ($(this).attr('_tag') && $(this).attr('_tag') == 'all' && $(this).hasClass('icon-checked')) {//全不选
                $(this).removeClass('icon-checked');
                $('.org-item-list').find('.icon-unchecked').removeClass('icon-checked');
            } else if ($(this).attr('_tag') && $(this).attr('_tag') == 'all') {//全选
                $(this).addClass('icon-checked');
                $('.org-item-list').find('.icon-unchecked').addClass('icon-checked');
            } else if ($(this).hasClass('icon-checked')) {//某项不选,全选也要去掉
                $(this).removeClass('icon-checked');
                $('.org-item-header').find('.icon-unchecked').removeClass('icon-checked');
            } else {//某项选中
                $(this).addClass('icon-checked');
                if ($('.org-item-list').find('.icon-unchecked').length == $('.org-item-list').find('.icon-checked').length) {
                    $('.org-item-header').find('.icon-unchecked').addClass('icon-checked');
                }
            }
        });
        /********************部门tree界面操作********************/
            //制作tree列表鼠标移入的情况
        $('body').on('mouseenter', '#ztreeWrap .ztree li > div', function () {
        	
            var level = parseInt($(this).attr('level'));
            if (level > 0) {
                var left = -(18 * level) + 'px';
                var pdleft = 18 * (level + 1) + 'px';
                $(this).css('left', left);
                $(this).css('padding-left', pdleft);
            }
            if ($(this).find('.ztree-btn-wrap').length == 0) {
                var html = '';
                if ($(this).attr('id') != 'tree_1_wrap') {
                    html = '<div class="ztree-btn-wrap clearfix mr6">' +
                        '<i class="tree-add-btn" title="添加部门"></i>' +
                        '<i class="tree-rename-btn" title="修改部门"></i>' +
                        '<i class="tree-del-btn" title="删除部门"></i>' +
                        '</div>';
                } else {
                    html = '<div class="ztree-btn-wrap clearfix mr6">' +
                        '<i class="tree-add-btn add-root-btn" title="添加部门"></i>' +
                        '</div>';
                }
                $(this).append(html);
            }
        });
        $('body').on('mouseleave', '#ztreeWrap .ztree li > div', function () {
            $(this).find('.ztree-btn-wrap').unbind().remove();
			$("#tree_1_wrap").removeClass('ztreeDef');
        });
        /****************部门tree增删改*****************/
        //增加部门
        $("body").on("click", "#ztreeWrap .tree-add-btn", function () {
            if($.isDisabled(this)){
               return;
            }
            $.disable(this);
            var zTree = $.fn.zTree.getZTreeObj("tree");
            callbacks.add($.removeLoading);
            currentDept = zTree.getNodeByTId($(this).closest('li').attr("id"));//获取当前部门
            var deptId = currentDept.id;
            callbacks.add(saveAddDeptback);//保存
            callbacks.add(defDeptSelect);
            MIO.dialog.openDialog('/admin/setting_organization/addDept?deptId=' + deptId, '添加部门', 360, callbacks,$(this));
        });
        $("body").on("click", ".dept-select", function() {
        	$(".depart-dropdown-tree").show();
		});
        //编辑部门
        $("body").on("click", ".tree-rename-btn", function () {
             if($.isDisabled(this)){
               return;
            }
            $.disable(this);
            var zTree = $.fn.zTree.getZTreeObj("tree");
            var currentDept = zTree.getNodeByTId($(this).closest('li').attr("id"));//获取当前部门
            var deptId = currentDept.id;
            callbacks.add($.removeLoading);
            callbacks.add(saveEditDept);//保存
            //callbacks.add(saveLayerIndex);//关闭
            callbacks.add(defDeptSelect);//默认选中部门
            MIO.dialog.openDialog('/admin/setting_organization/editDept?deptId=' + deptId, '编辑部门', 360, callbacks);
        });
        //删除部门
        $("body").on("click", ".tree-del-btn", function () {
            var zTree = $.fn.zTree.getZTreeObj("tree");
            var currentDept = zTree.getNodeByTId($(this).closest('li').attr("id"));//获取当前部门
            var deptId = currentDept.id;
            layer.confirm("您确认要删除此部门吗？", function (index) {//确定操作
                //.....
            	if($.isDisabled(".xubox_yes")){
                    return;
            	}
            	$.disable(".xubox_yes");
                $.ajax({
                        url: '/admin/setting_organization/delDept',
                        type: 'GET',
                        dataType: 'json',
                        data: {"deptId": deptId}
                    })
                    .done(function (data) {
                    	$.enable(".xubox_yes");
                    	layer.close(index);
                        MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                            "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
                    })
                    .fail(function (e) {
                    	$.enable(".xubox_yes");
                    	tips("数据加载失败！",0);
                    });
            });
            //layer.alert("你确认要弹出?",-1,function(index){
            //    layer.close(index);
            //});
        });

        /*********************************员工设置*************************/
        //员工设置
        $("body").on("click", ".staffSetBtn", function () {
        	if($.isDisabled(this)){
                return;
            }
            $.disable(this);
            callbacks.add($.removeLoading);
            callbacks.add(MIO.customUnit.cutomRadio);//radio单选设置
            callbacks.add(saveStaffSet);//保存
            //callbacks.add(saveLayerIndex);//关闭
            var id = $(this).attr("data-id");
            //callbacks.add(dropDownDeptTree);//加载下拉部门树
            callbacks.add(defDeptSelect);//默认选中部门
            MIO.dialog.openDialog('/admin/setting_organization/editUser?userId=' + id, '员工设置', 360, callbacks,$(this));
        });
        //员工移除
        $("body").on("click", ".staffRemoveBtn", function () {
            var olddeptid = $("#userDept").val();
            var userdept = $(".dept-select").find('option:selected').val();
            var userid = $(this).attr("data-id");
            layer.confirm("您确认要移除此员工吗？", function (index) {//确定操作
                //.....
            	if($.isDisabled(".xubox_yes")){
                    return;
            	}
            	$.disable(".xubox_yes");
                $.ajax({
                        url: '/admin/setting_organization/delUser',
                        type: 'GET',
                        dataType: 'json',
                        data: {"userid": userid}
                    })
                    .done(function (data) {
                        if (data.succeed) {
                        	$.enable(".xubox_yes");
                            layer.close(index);
                            MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                                    "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
                                var refreshid = $("#refreshid").val();
                                var refreshtype = $('#refreshtype').val();
                                var posttype = 0;
                                if (refreshtype == "root") {
                                    posttype = 0;
                                    $('#refreshid').val("-1");
                                    $('#refreshtype').val("root");
                                } else if (refreshtype == "dept") {
                                    posttype = 1;
                                    $('#refreshid').val(refreshid);
                                    $('#refreshtype').val("dept");
                                }
                                $.showLoading();
                                var zTree = $.fn.zTree.getZTreeObj("tree");
                                var node = zTree.getNodesByParam('id',refreshid,null);
                                if (refreshid) {
                                	$('#nodeNames').html(node[0].name).attr("title",node[0].title);
                                }
                                
                                //$('#initName').val(node[0].name);
                            	$.ajax({
                            		type : "POST",
                            		url : "/admin/setting_organization/countUserByTreeNode",
                            		data : {"id": refreshid, "type": posttype, "form_key":FORM_KEY},
                            		dataType : "JSON",
                            		async : false,
                            		success : function(data) {
                            			if (data.succeed) {
                            				if(data.data == 0) {
                            					$("#colleague_pag").attr("style","display:none");
                            					$("#orgStaffList").html("");
                            					$.removeLoading();
                            				}if(data.data < 16){
                            					$("#colleague_pag").attr("style","display:none");
                            					$.removeLoading();
                            				} else {
                            					$("#colleague_pag").attr("style","");
                            					$.removeLoading();
                            				}
                            				// 初始化ajax分页控件
                            				var config = {
                            					totalRecords : data.data,
                            					pageRowCount : 15,// 每页显示20条数据
                            					clickPage : function(pageParam) {
                            						loadListPage(pageParam,"2",refreshid,posttype);// 调用数据渲染
                            					}
                            				};
                            				initPagin(config);
                            			} else {
                            				$("#colleague_pag").attr("style","display:none");
                            				$("#listPageBody").html("");
                            			}
                            		},
                            		error : function(XMLHttpRequest, textStatus, errorThrown) {
                            			$.removeLoading();// 移除遮罩层
                            			if (XMLHttpRequest.status == 200) {
                            				var json = $.parseJSON(XMLHttpRequest.responseText);
                            				tips(json.msg, 0);
                            			} else if (XMLHttpRequest.readyState != 0) {
                            				tips('网络连接出错！',0);
                            			}
                            		}
                            	});
                        }else{
                        	$.enable(".xubox_yes");
                        	tips(data.msg,0);
                        }
                    })
                    .fail(function (e) {
                    	$.enable(".xubox_yes");
                    	tips("数据加载失败！",0);
                    });

            });
        });
        //添加员工
        $(".addStaffBtn").click(function () {
            if($.isDisabled(this)){
                return;
            }
            callbacks.add($.removeLoading());
            callbacks.add(saveAddback);//保存
            //callbacks.add(saveLayerIndex);//关闭
            callbacks.add(defDeptSelect);//默认选中部门
            callbacks.add(addScrollbar);
            callbacks.add(function () {
            	MIO.bmtree.first($(".bmtree"));
            });
            callbacks.add(_bmtreeBind);
            MIO.dialog.openDialog('/admin/setting_organization/addUser', '添加员工', 480, callbacks,$(this));
        });
        //导出员工
        $(".exportStaffBtn").click(function () {
            //MIO.dialog.openDialog('/yop/pc/test/open_add_staff', '员工设置', 360, callbacks);
            var refreshid = $("#refreshid").val();
            var refreshtype = $('#refreshtype').val();
            var name = $('#searchname').val();
            var posttype = 0
            if (refreshtype == "root") {
                posttype = 0;
                $('#refreshid').val("-1");
                $('#refreshtype').val("root");
            } else if (refreshtype == "dept") {
                posttype = 1;
                $('#refreshid').val(refreshid);
                $('#refreshtype').val("dept");
            }
            window.open("/admin/setting_organization/exportUser?id=" + refreshid + "&type=" + posttype + "&name=" + name);
        });
        //批量设置员工
        $(".batSetBtn").click(function () {
            if($.isDisabled(this)){
               return;
            }
            callbacks.add($.removeLoading);
            callbacks.add(MIO.customUnit.cutomRadio);//radio单选设置
            callbacks.add(saveBatSet);//保存
            //callbacks.add(saveLayerIndex);//关闭
            callbacks.add(defDeptSelect);//默认选中部门
            var userIds = "";
            $('.mm-list-wrap').find('.icon-checked').each(function () {
            	if($(this).attr('_tag') != 'all'){
            		var userid = $(this).attr("data-id");
                    if (userid != "") {
                        if (userIds != "") {
                            userIds = userIds + "," + userid;
                        } else {
                            userIds = userid;
                        }
                    }
            	}
            });
            if (userIds == "") {
            	tips("请选择至少一名员工！",0);
            } else {
                $.disable(this);
                MIO.dialog.openDialog('/admin/setting_organization/bulkEditUser?userIds=' + userIds, '批量设置', 360, callbacks,$(this));
            }
        });

        /*************搜索**************/
        $(".searchBtn").click(function () {
            //SimpleTool.createGlobMaskLayer();// 蒙上遮罩层
            $.showLoading();
        	var refreshid = $("#refreshid").val();
            var refreshtype = $('#refreshtype').val();
            var name = $('#searchname').val();
            var isBlank = /^\s+$/g;
            if(name.match(isBlank)){
            	name="";
            }
            var posttype = 0
            if (refreshtype == "root") {
                posttype = 0;
                $('#refreshid').val("-1");
                $('#refreshtype').val("root");
            } else if (refreshtype == "dept") {
                posttype = 1;
                $('#refreshid').val(refreshid);
                $('#refreshtype').val("dept");
            }
        	$.ajax({
        		type : "POST",
        		url : "/admin/setting_organization/countSearchUser",
        		data : {"id": refreshid, "type": posttype,"name": name,"form_key":FORM_KEY},
        		dataType : "JSON",
        		async : false,
        		success : function(data) {
        			if (data.succeed) {
        				if(data.data == 0) {
        					$("#colleague_pag").attr("style","display:none");
        					$("#orgStaffList").html("<div class='no-data'>没有找到符合条件的员工，请重试</div>");
        					$.removeLoading();
        				}if(data.data < 16){
        					$("#colleague_pag").attr("style","display:none");
        					$.removeLoading();
        				}else {
        					$("#colleague_pag").attr("style","");
        					$.removeLoading();
        				}
        				// 初始化ajax分页控件
        				var config = {
        					totalRecords : data.data,
        					pageRowCount : 15,// 每页显示20条数据
        					clickPage : function(pageParam) {
        						loadListPage(pageParam,"3",refreshid,posttype);// 调用数据渲染
        					}
        				};
        				initPagin(config);
        			} else {
        				$("#colleague_pag").attr("style","display:none");
        				$("#orgStaffList").html("");
        				$.removeLoading();
        				tips(data.msg,0);
        			}
        		},
        		error : function(XMLHttpRequest, textStatus, errorThrown) {
        			$.removeLoading();// 移除遮罩层
        			if (XMLHttpRequest.status == 200) {
        				var json = $.parseJSON(XMLHttpRequest.responseText);
        				tips(json.msg, 0);
        			} else if (XMLHttpRequest.readyState != 0) {
        				tips('网络连接出错！',0);
        			}
        		}
        	});
        });
        $('body').on('click','#ztreeWrap #tree li > div',function(e){
            if($(e.target).hasClass('tree-add-btn') || $(e.target).hasClass('tree-rename-btn') || $(e.target).hasClass('tree-del-btn')){
                return;
            }
            var treeNode = $.fn.zTree.getZTreeObj("tree").getNodeByTId($(this).closest('li').attr('id'));
            //console.log(treeNode);
            $(".icon-unchecked").removeClass('icon-checked');
            if (treeNode.type == "root") {
                type = 0;
                $('#refreshid').val("-1");
                $('#refreshtype').val("root");
                var initname = $('#initName').val();
                $('#nodeNames').html(initname).attr("title",initname);
            } else if (treeNode.type == "dept") {
                type = 1;
                $('#refreshid').val(treeNode.id);
                $('#refreshtype').val("dept");
                $('#nodeNames').html(treeNode.name).attr("title",treeNode.name);
            }
            $("#searchname").val("");

            $.showLoading();
            $.ajax({
                type : "POST",
                url : "/admin/setting_organization/countUserByTreeNode",
                data : {"id": treeNode.id, "type": type, "form_key":FORM_KEY},
                dataType : "JSON",
                async : false,
                success : function(data) {
                    if (data.succeed) {
                        if(data.data == 0) {
                            $("#colleague_pag").attr("style","display:none");
                            $("#orgStaffList").html("");
                            $.removeLoading();
                        }if(data.data < 16){
                            $("#colleague_pag").attr("style","display:none");
                            $.removeLoading();
                        } else {
                            $("#colleague_pag").attr("style","");
                            $.removeLoading();
                        }
                        // 初始化ajax分页控件
                        var config = {
                            totalRecords : data.data,
                            pageRowCount : 15,// 每页显示20条数据
                            clickPage : function(pageParam) {
                                loadListPage(pageParam,"2",treeNode.id,type);// 调用数据渲染
                            }
                        };
                        initPagin(config);
                    } else {
                        $("#colleague_pag").attr("style","display:none");
                        $("#listPageBody").html("");
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $.removeLoading();// 移除遮罩层
                    if (XMLHttpRequest.status == 200) {
                        var json = $.parseJSON(XMLHttpRequest.responseText);
                        tips(json.msg, 0);
                    } else if (XMLHttpRequest.readyState != 0) {
                        tips('网络连接出错！',0);
                    }
                }
            });
        });
    }

    /************************************页面功能函数****************************************/

    /**
     *绑定动态添加部门树的click事件
     */
    function _bmtreeBind() {
    	var selector = ".bmtree-arrows,.bmtree-text";
		$("body").off("click", selector).on("click", selector, function (e) {
			e.stopPropagation();
			var $bmtree = $(this).closest(".bmtree");
			MIO.bmtree.toggle($bmtree);
			MIO.bmtree.create($bmtree, null, null, null, true);
		});
    }

    /**
     *加载首页职员信息
     */
    function loadStaff() {
        $.ajax({
    		type : "POST",
    		url : "/admin/setting_organization/countStaff",
    		data : {form_key:FORM_KEY},
    		dataType : "JSON",
    		async : false,
    		success : function(data) {
    			if (data.succeed) {
    				if(data.data == 0) {
    					$("#colleague_pag").attr("style","display:none");
    				}if(data.data < 16){
    					$("#colleague_pag").attr("style","display:none");
    				} else {
    					$("#colleague_pag").attr("style","");
    				}
    				//更新数量
    				//$('#nodeNames').html(node[0].name).attr("title",node[0].title);
    				// 初始化ajax分页控件
    				var config = {
    					totalRecords : data.data,
    					pageRowCount : 15,// 每页显示20条数据
    					clickPage : function(pageParam) {
    						loadListPage(pageParam,"1","","");// 调用数据渲染
    					}
    				};
    				initPagin(config);
    			} else {
    				$("#colleague_pag").attr("style","display:none");
    				$("#listPageBody").html("");
    			}
    		},
    		error : function(XMLHttpRequest, textStatus, errorThrown) {
    			$.removeLoading();// 移除遮罩层
    			if (XMLHttpRequest.status == 200) {
    				var json = $.parseJSON(XMLHttpRequest.responseText);
    				tips(json.msg, 0);
    			} else if (XMLHttpRequest.readyState != 0) {
    				tips('网络连接出错！',0);
    			}
    		}
    	});
        return;
    }

    /**
     *默认选中部门名字
     */
    function defDeptSelect() {
    	console.log('defDeptSelect');
        $.ajax({
                url: '/admin/setting_organization/getDeptList',
                type: 'get',
                dataType: 'json',
                data: []
            })
            .done(function (data) {
                var result = data.data;
                var html = "";
                var userdept = $("#defaultDept").val();
                for (var i = 0; i < result.length; i++) {
                    if (result[i].id == userdept) {
                    	$(".bmtree-text").text(data.data[i].name).attr("_id", result[i].id);
                    }
                }
            })
            .fail(function (e) {
            	tips("部门数据下拉列表加载失败！",0);
            });
    }

    /**
     *加载部门下拉树
     */
    function dropDownDeptTree(){
    	MIO.treeUtil.createTree("/admin/ajax_tree/orgtree",
               $('#departtree'), "", clickCallBack, beaforDragback, dropEndback);//初始化tree
    }

    function addScrollbar(){
       // MIO.customUnit.createScrollBar($(this).find('.addMoreScroller'));
    }

    /**
     * 保存添加部门
     * @param index
     */
    function saveAddDeptback(index) {
        $(this).find('.btn-save').click(function () {
        	if($.isDisabled(this)){
                return;
             }
            //保存操作
            var deptName = $("#addDeptName").val();
            var deptCode = $("#addDeptCode").val();
            var parentId = $(".bmtree-text").attr("_id");//$(".dept-select").find('option:selected').val();
            if (deptName.length == 0 || deptName.match(/^\s+$/g)) {
            	tips("部门名称不可为空或全为空格！",0);
            }else if(deptName.length > 20){
            	tips("部门名称不可超过20位！",0);
            } else if (deptCode.match(/^\s+$/g)) {
            	tips("部门编号不可为空格！",0);
            }else if(deptCode.length > 20){
            	tips("部门编号不可超过20位！",0);
            }else {
            	$.disable(this);
            	var that = this;
                $.ajax({
                        url: '/admin/setting_organization/addDeptSave',
                        type: 'GET',
                        dataType: 'json',
                        data: {"parentId": parentId, "deptName": deptName, "deptCode": deptCode}
                    })
                    .done(function (data) {
                        if (data.succeed) {
                        	$.enable(that);
                            layer.close(index);
                            MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                                "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
                        } else {
                        	$.enable(that);
                        	tips(data.msg,0);
                        }
                    })
                    .fail(function (e) {
                    	$.enable(that);
                    	tips("数据加载失败！",0);
                    });
            }
        });
    }

    /**
     * 保存编辑部门
     * @param index
     */
    function saveEditDept(index) {
        $(this).find('.btn-save').click(function () {
        	if($.isDisabled(this)){
                return;
        	}
            //保存操作
            var deptId = $("#staff_deptid").val();
            var deptName = $("#editDeptName").val();
            var deptCode = $("#editDeptCode").val();
            var parentId = $(".bmtree-text").attr("_id");//$(".dept-select").find('option:selected').val();
            if (deptId == parentId) {
            	tips("不能选择自己作为上级部门！",0);
            } else if (deptName.length == 0 || deptName.match(/^\s+$/g)) {
            	tips("部门名称不可为空或全为空格！",0);
            }else if(deptName.length > 20){
            	tips("部门名称不可超过20位！",0);
            } else if (deptCode.match(/^\s+$/g)) {
            	tips("部门编号不可为空格！",0);
            } else {
            	$.disable(this);
            	var that = this;
                $.ajax({
                        url: '/admin/setting_organization/editDeptSave',
                        type: 'GET',
                        dataType: 'json',
                        data: {"parentId": parentId, "deptName": deptName, "deptId": deptId, "deptCode": deptCode}
                    })
                    .done(function (data) {
                        if (data.succeed) {
                        	$.enable(that);
                            layer.close(index);
                            MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                                "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
                        } else {
                        	$.enable(that);
                        	tips(data.msg,0);
                        }

                    })
                    .fail(function (e) {
                    	$.enable(that);
                    	tips("数据加载失败！",0);
                    });
            }

        });
    }

    /**
     * 保存员工设置
     * @param index
     */
    function saveStaffSet(index) {
        $(this).find('.btn-save').click(function () {
        	if($.isDisabled(this)){
                return;
             }
            var olddeptid = $("#defaultDept").val();
            //保存操作
            var userid = $("#staff_userid").val();
            var ismanage = $("input[name=setAdmin]:checked").val();
            var duty = $("#addDeptName").val();
            var userdept = $(".bmtree-text").attr("_id");
            $.disable(this);
            var that = this;
            $.ajax({
                    url: '/admin/setting_organization/editUserSave',
                    type: 'GET',
                    dataType: 'json',
                    data: {"userid": userid, "ismanage": ismanage, "duty": duty, "userdept": userdept}
                })
                .done(function (data) {
                    if (data.succeed) {
                    	$.enable(that);
                    	if(data.data == "1"){//取消自己的管理员跳转
                    		location.replace("/yop/pc/workbench");
                    	}else{
                            layer.close(index);
                                //刷新用户列表
                                MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                                    "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
                                var posttype = 0
                                var refreshid = $("#refreshid").val();
                                var refreshtype = $('#refreshtype').val();
                                if (refreshtype == "root") {
                                    posttype = 0;
                                    $('#refreshid').val("-1");
                                    $('#refreshtype').val("root");
                                } else if (refreshtype == "dept") {
                                    posttype = 1;
                                    $('#refreshid').val(olddeptid);
                                    $('#refreshtype').val("dept");
                                }
                                $.showLoading();
                                var zTree = $.fn.zTree.getZTreeObj("tree");
                                var node = zTree.getNodesByParam('id',refreshid,null);
                                //console.log(refreshid);
                                //注意 refreshid 的值不对
                                //$('#nodeNames').html(node[0].name).attr("title",node[0].title);
                            	$.ajax({
                            		type : "POST",
                            		url : "/admin/setting_organization/countUserByTreeNode",
                            		data : {"id": refreshid, "type": posttype, "form_key":FORM_KEY},
                            		dataType : "JSON",
                            		async : false,
                            		success : function(data) {
                            			if (data.succeed) {
                            				if(data.data == 0) {
                            					$("#colleague_pag").attr("style","display:none");
                            					$("#orgStaffList").html("");
                            					$.removeLoading();
                            				}if(data.data < 16){
                            					$("#colleague_pag").attr("style","display:none");
                            				} else {
                            					$("#colleague_pag").attr("style","");
                            				}
                            				// 初始化ajax分页控件
                            				var config = {
                            					totalRecords : data.data,
                            					pageRowCount : 15,// 每页显示20条数据
                            					clickPage : function(pageParam) {
                            						loadListPage(pageParam,"2",refreshid,posttype);// 调用数据渲染
                            					}
                            				};
                            				initPagin(config);
                            			} else {
                            				$("#colleague_pag").attr("style","display:none");
                            				$("#listPageBody").html("");
                            			}
                            		},
                            		error : function(XMLHttpRequest, textStatus, errorThrown) {
                            			$.removeLoading();// 移除遮罩层
                            			if (XMLHttpRequest.status == 200) {
                            				var json = $.parseJSON(XMLHttpRequest.responseText);
                            				tips(json.msg, 0);
                            			} else if (XMLHttpRequest.readyState != 0) {
                            				tips('网络连接出错！',0);
                            			}
                            		}
                            	});
                    	}
                    } else {
                    	$.enable(that);
                    	tips(data.msg,0);

                    }
                })
                .fail(function (e) {
                	$.enable(that);
                	tips("数据加载失败！",0);
                });
        });
    }

    /**
     * 保存批量设置
     * @param index
     */
    function saveBatSet(index) {
        $(this).find('#batSetting .btn-save').click(function () {
        	if($.isDisabled(this)){
                return;
             }
            //保存操作
            var olddeptid = $("#userDept").val();
            var userIds = $("#bat_userIds").val();
            var userdept = $(".bmtree-text").attr("_id");//$(".dept-select").find('option:selected').val();
            $.disable(this);
            var that = this;
            $.ajax({
                    url: '/admin/setting_organization/bulkEditUserSave',
                    type: 'GET',
                    dataType: 'json',
                    data: {"deptId": userdept, "userIds": userIds}
                })
                .done(function (data) {
                    if (data.succeed) {
                    	$.enable(that);
                        layer.close(index);
                        MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                            "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
                        var refreshid = $("#refreshid").val();
                        var refreshtype = $('#refreshtype').val();
                        var posttype = 0;
                        if (refreshtype == "root") {
                            posttype = 0;
                            $('#refreshid').val("-1");
                            $('#refreshtype').val("root");
                        } else if (refreshtype == "dept") {
                            posttype = 1;
                            $('#refreshid').val(refreshid);
                            $('#refreshtype').val("dept");
                        }
                        $.showLoading();
                        var zTree = $.fn.zTree.getZTreeObj("tree");
                        var node = zTree.getNodesByParam('id',refreshid,null);
                        $('#nodeNames').html(node[0].name).attr("title",node[0].title);
                        $('.icons-checkbox').removeClass('icon-checked');
                    	$.ajax({
                    		type : "POST",
                    		url : "/admin/setting_organization/countUserByTreeNode",
                    		data : {"id": refreshid, "type": posttype, "form_key":FORM_KEY},
                    		dataType : "JSON",
                    		async : false,
                    		success : function(data) {
                    			if (data.succeed) {
                    				if(data.data == 0) {
                    					$("#colleague_pag").attr("style","display:none");
                    					$("#orgStaffList").html("");
                    					$.removeLoading();
                    				}if(data.data < 16){
                    					$("#colleague_pag").attr("style","display:none");
                    					$.removeLoading();
                    				} else {
                    					$("#colleague_pag").attr("style","");
                    					$.removeLoading();
                    				}
                    				// 初始化ajax分页控件
                    				var config = {
                    					totalRecords : data.data,
                    					pageRowCount : 15,// 每页显示20条数据
                    					clickPage : function(pageParam) {
                    						loadListPage(pageParam,"2",refreshid,posttype);// 调用数据渲染
                    					}
                    				};
                    				initPagin(config);
                    			} else {
                    				$("#colleague_pag").attr("style","display:none");
                    				$("#listPageBody").html("");
                    			}
                    		},
                    		error : function(XMLHttpRequest, textStatus, errorThrown) {
                    			$.removeLoading();// 移除遮罩层
                    			if (XMLHttpRequest.status == 200) {
                    				var json = $.parseJSON(XMLHttpRequest.responseText);
                    				tips(json.msg, 0);
                    			} else if (XMLHttpRequest.readyState != 0) {
                    				tips('网络连接出错！',0);
                    			}
                    		}
                    	});
                    } else {
                    	$.enable(that);
                    	tips(data.msg,0);

                    }
                })
                .fail(function (e) {
                	$.enable(that);
                    tips("数据加载失败!",0);
                });
        });
    }

    function saveAddback(index) {

        var isMob = /^1[3|4|5|7|8][0-9]{9}$/;
        var isBlank = /^\s+$/g;
        $(this).find('.addStaffSection .btn-save').click(function () {//保存添加员工
        	if($.isDisabled(this)){
        		return;
        	}
        	$.disable(this);
        	var that =this;

        	var flag = true;
        	var staffnames = "";
            var staffphones = "";
            var staffdutys = "";
            var staffdepts = "";
        	var arrItem = $("#addMoreWrap").find('.addnew-section');
            var str = '';
//            var flag = true;
            for(var i=0;i<arrItem.length;i++){
                if($(arrItem[i]).find('input[name="staffname"]').val() != "" &&
                    $(arrItem[i]).find('input[name="staffphone"]').val() == ""){
                    flag = false;
                    tips("请输入电话号码！",0);
                    break;
                } else if($(arrItem[i]).find('input[name="staffname"]').val() == "" &&
                    $(arrItem[i]).find('input[name="staffphone"]').val() != ""){
                    flag = false;
                    tips("请输入员工姓名！",0);
                    break;
                } else if($(arrItem[i]).find('input[name="staffname"]').val() != "" &&
                        $(arrItem[i]).find('input[name="staffphone"]').val() != ""){

                	if($(arrItem[i]).find('input[name="staffname"]').val().match(isBlank)){
                		tips("员工姓名不可全为空格！",0);
                    	flag = false;
                    	break;
                    }

                	if(!$(arrItem[i]).find('input[name="staffphone"]').val().match(isMob)){
                		tips("电话号码不符合规范！",0);
                     	flag = false;
                     	break;
                     }

                	if($(arrItem[i]).find('input[name="staffduty"]').val().match(isBlank)){
                		tips("员工职位不可全为空格！",0);
                    	flag = false;
                    	break;
                    }

                	if(staffnames == ""){
                		staffnames = $(arrItem[i]).find('input[name="staffname"]').val();
                	}else{
                		staffnames = staffnames + "," + $(arrItem[i]).find('input[name="staffname"]').val();
                	}

                	if(staffphones == ""){
                		staffphones = $(arrItem[i]).find('input[name="staffphone"]').val();
                	}else{
                		staffphones = staffphones + "," + $(arrItem[i]).find('input[name="staffphone"]').val();
                	}

                	if($(arrItem[i]).find('input[name="staffduty"]').val() == ""){
                    	duty = "无";
                    }else{
                    	duty = $(arrItem[i]).find('input[name="staffduty"]').val();
                    }
                    if (staffdutys == "") {
                        staffdutys = duty;
                    } else {
                        staffdutys = staffdutys + "," + duty;
                    }

                    if (staffdepts == "") {
                        //staffdepts = $(arrItem[i]).find('select[name="staffdept"]').find('option:selected').val();
                    	staffdepts = $(arrItem[i]).find(".bmtree-text").attr("_id");
                    } else {
                        //staffdepts = staffdepts + "," + $(arrItem[i]).find('select[name="staffdept"]').find('option:selected').val();
                    	staffdepts = staffdepts + "," + $(arrItem[i]).find(".bmtree-text").attr("_id");
                    }
                }
            }
            if(staffnames == "" && staffphones == "" && flag){
                flag = false;
                tips("你没有输入数据！",0);
                $.enable(this);
            }else if(flag && staffnames != "" && staffphones != ""){//提交数据
            	var valphones = staffphones.split(",");
                for (var i = 0; i < valphones.length; i++) {
                    for (var j = i + 1; j < valphones.length; j++) {
                        if (valphones[i] != "" && valphones[j] != "") {
                            if (valphones[i] == valphones[j]) {
                            	flag = false;
                            	tips("电话号码不能重复！",0);
                            	break;
                            }
                        }
                    }
                }
                if(!flag){
                	$.enable(this);
                	return;
                }else{
                	$.ajax({
                        url: '/admin/setting_organization/addUserSave',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "staffnames": staffnames,
                            "staffphones": staffphones,
                            "staffdutys": staffdutys,
                            "staffdepts": staffdepts,
                            "form_key": FORM_KEY
                        }
                    })
                    .done(function (data) {
                        if (data.succeed) {
                        	$.enable(that);
                        	layer.close(index);
                        	tips("已成功添加员工！",1,1000,function(){
                    			location.reload();
                    		});

                        } else {
                        	$.enable(that);
                        	tips(data.msg,0);
                        }

                    })
                    .fail(function (e) {
                    	$.enable(that);
                    	tips("添加用户失败！",0);
                    });
                }
            }else{
            	 $.enable(this);
            }

        });
        //下载导入模板
//        $('body').off("click", ".userImportTmp").on("click", ".userImportTmp", function (){
        $(".userImportTmp").click(function () {
            window.open("/admin/setting_organization/downloadTemplate");
        });
        $(this).find('.importStaffSection .btn-save').click(function (e) {//导入员工
        	if($.isDisabled(this)){
        		return;
        	}
        	$.disable(this);
        	var that=this;

            var fileName = $("#input-choseFile").val();
            var names = new Array();
            names = fileName.split(".");
            var fileType = names[names.length - 1];
            if ("xlsx" != fileType) {
            	tips("文件格式不正确，请下载模板文件进行参照！",0);
            	$.enable(that);
                return;
            }

            $("#importForm").ajaxSubmit({
                type: 'post',
                url: '/admin/setting_organization/importUser',
                enctype: 'multipart/form-data',
                dataType: 'text',
                success: function (data) {
                    var result = JSON.parse(data);
                    layer.close(index);
                    var url = "/admin/setting_organization/downloadImportRecord?batchid=" + result.data;
                    if (result.succeed) {
                        createResultDialog(1, url);
                    } else {
                        createResultDialog(0, url);
                    }
                    $.enable(that);
                },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                	layer.close(index);
                    var url = "/admin/setting_organization/downloadImportRecord?batchid=" + data.data;
                    createResultDialog(0, url);
                    $.enable(that);
                }
            });
        });
    }

    function isRepeat(arr) {
        var hash = {};
        for (var i in arr) {
            if (hash[arr[i]]) {
                return true;
            }
            // 不存在该元素，则赋值为true，可以赋任意值，相应的修改if判断条件即可
            hash[arr[i]] = true;
        }
        return false;
    }

    //导入结果显示
    function createResultDialog(state, url) {
        $.ajax({
            url: "/yop/pc/test/open_import_result",
            type: "GET",
            dataType: "text"
        }).done(function (html) {
            var indexD = $.layer({
                type: 1,
                fix: false,
                move: false,
                title: "导入结果",
                area: ["500px", "auto"],
                page: {html: html},
                success: function (layero) {
                    $(".xubox_main").css("height", "auto");
                    $(".xubox_close").focus();
                    if (state == '1') {
                        $('#resultTxt').addClass('red').text('数据导入成功!');

                    } else {
                        $('#resultTxt').text('数据导入失败!');
                    }
                    $('#downloadResult').attr('href', url);
                    //确定(关闭弹窗)
                    $('#btn-close-result').click(function () {
                        layer.close(indexD);
                        location.reload();
                    });
                }
            });
        }).fail(function (e1, e2, e3) {
            console.log(e1.status + (e2 || e3));
        });
    }

    return {
        init: function () {
            initEvents();
            bindEvents();
        }
    };
})();


$(function () {
    MIO.ORG_SET.init();
});

/***************************/
function defTreeHover() {
    $("#tree_1_wrap").addClass('ztreeDef');
    var html = '<div class="ztree-btn-wrap clearfix mr6">' +
        '<i class="tree-add-btn add-root-btn" title="添加部门"></i>'+
    	'</div>';
    $("#tree_1_wrap").append(html);
}

function createTree() {
    var zTree = $.fn.zTree.getZTreeObj("tree"),
        nodes = zTree.getNodes();
    for (var i = 0, l = nodes.length; i < l; i++) {
        var num = nodes[i].children ? nodes[i].children.length : 0;
        nodes[i].text = nodes[i].text.replace(/ \(.*\)/gi, "") + " (" + num + ")";
        zTree.updateNode(nodes[i]);
    }
}
/************************/

/**
 * 初始化人员列表滚动条
 * @param selector
 */
function initScrollerbar(selector) {
    $(selector).mCustomScrollbar({autoDraggerLength: true});
    $(selector).mCustomScrollbar('update');
    $(selector + " .mCSB_dragger:hover").css("background-color", "#ccc");
    $(selector + " .mCSB_draggerRail").css({"width": "1px", "background-color": "#ccc"});
    $(selector + " .mCSB_dragger_bar").css({"width": "6px", "background-color": "#ccc"});
    if (selector == '#orgStaffList' && $(selector).find('.mCSB_scrollTools').css('display') == 'block') {//有滚动条时,设置内部div宽度
        //$('.mm-info-position').css("width", "138px");
        //$('.mm-infos-wrap').css("width", "670px");
        //$('.mm-item-info').css("width", "720px");
    } else if (selector == '#ztreeWrap' && $(selector).find('.mCSB_scrollTools').css('display') == 'block') {
        $('#ztreeWrap').css('padding-right', '4px');
    }
}

function initPagin(obj)
{
	$("#colleague_pag").CJPaginator(obj);
}

/**
 * 点击某个部门tree节点
 * @param treeId
 * @param treeNode
 */
function clickCallBack(treeId, treeNode) {

}

//执行查询
// @pageObj:分页相关的对象
function loadListPage(_pageParam,loadType,nodeId,nodeType) {
	
	if(loadType == "1"){//初始化加载
		var obj = {
			form_key: FORM_KEY,
			begin : _pageParam.start,
			length : _pageParam.pageRowCount
		};
		var _url = "/admin/setting_organization/loadStaff";
	}else if(loadType == "2"){//点击树节点请求
		var obj = {
			id: nodeId,
			type: nodeType,
			form_key: FORM_KEY,
			begin : _pageParam.start,
			length : _pageParam.pageRowCount
		};
		// load数据页面
		var _url = "/admin/setting_organization/getUserListByTreeNode";
	}else if(loadType == "3"){//条件查询
		var name = $("#searchname").val();
		var isBlank = /^\s+$/g;
		if(name.match(isBlank)){
        	name="";
        }
		var obj = {
			id: nodeId,
			type: nodeType,
			name: name,
			form_key: FORM_KEY,
			begin : _pageParam.start,
			length : _pageParam.pageRowCount
		};
		// load数据页面
		var _url = "/admin/setting_organization/searchUser";
	}
	
	$("#orgStaffList").load(_url, obj, function(response, status, xhr) {
		// 加载成功，移除遮罩层
		$.removeLoading();//移除遮罩层
	});
	$('.icons-checkbox[_tag="all"]').removeClass('icon-checked');//移除全选
}

//拖拽完成后操作
function dropEndback(event, treeId, treeNodes, targetNode, moveType, isCopy) {
    var targetId;
    if (moveType == "inner") {
        targetId = targetNode.id;
    } else if (moveType == "prev" || moveType == "next") {
        targetId = targetNode.getParentNode().id;
    }
    $.ajax({
            url: '/admin/setting_organization/dragDept',
            type: 'GET',
            dataType: 'json',
            data: {"targetDeptId": targetId, "oldDeptId": treeNodes[0].id}
        })
        .done(function (data) {
            MIO.treeUtil.createTree("/admin/setting_organization/getOrgTree",
                "", "", clickCallBack, beaforDragback, dropEndback);//初始化tree
        })
        .fail(function (e) {
        	console.log("数据加载失败！");
        });
}

//拖拽前完成操作
function beaforDragback(treeId, treeNodes) {

}



var MIO = MIO || {};
MIO.bmtree = (function () {
	/**
	 * @function:创建一个目前来说看似chosen实则并非chosen的的下拉选择框，且只会是选部门的树。
	 * @parameters:
	 * bmtree:[jQuery Obj]目标区域dom对象，一般来说是$(".bmtree")。(不能为空)
	 * url:[string]请求数据的URL地址。(可以为空)
	 * pointer:[string]展开下拉列表的方向，默认down向下展开，up向上展开。(可以为空)
	 * callback:[method]选中一个节点后要执行的函数。(可以为空)
	 * more:[boolean]指定为true说明页面上有多个这种下拉选择框。(可以为空)
	 */
	function _create(bmtree, url, pointer, callback, more) {
		var width = bmtree.outerWidth(),
			$area = bmtree.find(".bmtree-area"),
			$text = bmtree.find(".bmtree-text");
		$area.css("width", width + "px").removeClass("down").addClass(pointer || "down");
		if (!more) { if ($area.children("li").length > 0) return; }
		$.ajax({
			url: url || "/admin/setting_organization/departDataWithCompanyName",
			type: "GET",
			dataType: "json",
			success: function (json) {
				if (json) {
                    var setting = {
                        view: {
                        	showIcon: false,
                        	showLine: false,
                        	showTitle: false
                        },
                        callback: {
                            beforeClick: function (treeId, treeNode) {
                            	$text.text(treeNode.name).attr("_id", treeNode.id);
                            	$area.hide();
                            	bmtree.removeClass("bmOpen");
                    			bmtree.find(".bmtree-arrows").removeClass("up").addClass("down");
                    			callback && callback();
                            }
                        }
                    };
                    $.fn.zTree.init(bmtree.find(".ztree"), setting, json);
                }
			},
			error: function (xhr) {
				console.log(xhr.status);
			}
		});
	}
	//获取树的第一个节点(或是根节点或是第一子节点)
	function _getFirstNode(bmtree, type, url) {
		var $text = bmtree.find(".bmtree-text");
		$.ajax({
			url: url || "/yop/pc/treeData/departDataWithCompanyName",
			type: "GET",
			dataType: "json",
			success: function (json) {
				if (json) {
					!type ? $text.text(json.name).attr("_id", json.id) : $text.text(json.children[0].name).attr("_id", json.children[0].id);
				} else {
					$text.text("全公司").attr("_id", "-1");
				}
			},
			error: function (xhr) {
				console.log(xhr.status);
			}
		});
	}
	//点击外形像个chosen的bmtree显示或隐藏层级树
	function _toggle(obj) {
		var $tree = obj;
		var $area = $tree.find(".bmtree-area"),
			$arrows = $tree.find(".bmtree-arrows");
		$(".bmtree").not($tree).removeClass("bmOpen");
		$(".bmtree-area").not($area).hide();
		$(".bmtree-arrows").not($arrows).removeClass("up").addClass("down");
		if ($tree.hasClass("bmOpen")) {
			$area.hide();
			$tree.removeClass("bmOpen");
			$arrows.removeClass("up").addClass("down");
		} else {
			$area.show();
			$tree.addClass("bmOpen");
			$arrows.removeClass("down").addClass("up");
		}
	}
	//事件绑定
	function _bindEvents() {
		//点击一个看似chosen实则并非chosen的区域(此方法可以在页面比较特殊的情况下从新绑定事件)
		$("body").on("click", ".bmtree-arrows,.bmtree-text", function (e) {
			e.stopPropagation();
			var $bmtree = $(this).closest(".bmtree");
			if ($bmtree.hasClass("disabled")) return;
			_toggle($bmtree);
			_create($bmtree);
		});
		//组织树形区域点击冒泡时间
		$("body").on("click", ".bmtree-area", function (e) {
			e.stopPropagation();
		});
		//点击其他地方关闭树形区域
		$("body").on("click", function (e) {
			var $tree = $(".bmtree");
			var $area = $(".bmtree-area");
			var $arrows = $(".bmtree-arrows");
			var tag = e.target || e.srcElement;
			if (!$tree.is(tag) && !$area.is(tag) && !$arrows.is(tag)) {
				$area.hide();
				$tree.removeClass("bmOpen");
				$arrows.removeClass("up").addClass("down");
			}
		});
	}
	return {
		init: function () {
			_bindEvents();
		},
		toggle: _toggle,
		create: _create,
		first: _getFirstNode
	}
})();

$(function () {
	MIO.bmtree.init();
});