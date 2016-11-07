/***
 HTML：
 <div class="tr page-normal" id="yb_pag">
 </div>
 
 
 
 JS代码：
   $("#yb_pag").CJPaginator({totalRecords:200,clickPage:function(obj){
			    	 alert("记录总数是："+obj.totalRecord
			    	    +"用户当前请求的页号是：" +obj.pageNumber
			    	    +"页码栏上显示的页码个数是：" +obj.countInBar
			    	    +"每一页上的记录数是：" +obj.pageRowCount
			    	    +"如果你使用的是mySQL数据库，可以使用 limit obj.start,obj.pageRowCount 直接查询数据
			    	    );
			}});
 ***/
  
(function($,window, undefined)
{
	 var defaultConfig={
			 totalRecords:0,//总数
			 activePageIndex:1,//当前活动的页号
			 pageRowCount:10,//每一页上显示的记录数
			 countInBar:10,//显示多少个页号
			 clickPage:function(obj){
			 	//说明
				 /*obj是一个json,
				{pageNumber:0, //用户点击的页号
				 totalRecord:0,//总的记录数
				 pageRowCount:0,//每一页显示的记录数
				 start:1  //计算好的，该也上放置的第一条记录的序号
				  mySql数据库中可以直接用     limit start,pageRowCount
				 }*/
			 }
	          
	 };
	 var methods={
			 test:function()
			 {
				 alert(arguments[1]);
			 },
			 createHtml:function(paginator)
			 {
			 	 var finallConfig=paginator.finallConfig;
			 	 var state=paginator.state;
			 	 var bz=paginator.bz;
				 //生成之前，可以改变起始页号
			     var bFind=false;
				 var tmpDqIndex=state.startPage;//当前页号
				 var html='';
				 html+='<ul class="pagination">';
				// html+='<li><a bz="'+bz+'" type="first" num="1" href="javascript:void(0)">首页</a></li>';
				 var numpre=state.activePage-1;
				 if(numpre<=0)
					 {
					 	numpre=1;
					 }
				 html+='<li><a bz="'+bz+'" type="pre"   num="'+numpre+'" href="javascript:void(0)"><i class="icons icons-prev"></i></a></li>';
				 
				 //如果起始页大于1，显示省略号
				 if(state.startPage>1)
					 {
					    html+='<li><a href="javascript:void(0)">...</a></li>';
					 }
				 for(var i=0;i<finallConfig.countInBar&&tmpDqIndex<=state.pageCount;i++)
					 {
					     //只要当前页号小于总的页面数，并且还未构造满一次显示的页数，就循环执行
					 	 var a="";
					 	 if(tmpDqIndex==state.activePage)
					 		 {
					 		      a='<li><a bz="'+bz+'"   num="'+tmpDqIndex+'" state="active"  type="page" href="javascript:void(0)" class="active">'+tmpDqIndex+'</a></li>';
					 		     bFind=true;
					 		 }else
					 			 {
					 			    a='<li><a bz="'+bz+'"  num="'+tmpDqIndex+'" type="page" href="javascript:void(0)">'+tmpDqIndex+'</a></li>';
					 			 }
					 	 html+=a;
					 	 state.endPage=tmpDqIndex;
					 	 tmpDqIndex=tmpDqIndex+1;
					 }
				 //如果结束页不是最后一页
				 if(state.endPage<state.pageCount)
				 {
				    html+='<li><a href="javascript:void(0)">...</a></li>';
				 }
				 var numnext=state.activePage+1;
				 if(numnext>state.pageCount)
					  numnext=state.pageCount;
				 html+='<li><a bz="'+bz+'" type="next" num="'+numnext+'"  href="javascript:void(0)"><i class="icons icons-next"></i></a></li>';
				// html+='<li><a bz="'+bz+'" type="last" num="'+state.pageCount+'" href="javascript:void(0)">尾页</a></li>';
				 html+='</ul>';
				 return html;
			 }
	 }
	 
	 var linkClick=function(paginator,a)
	 {
	 	
	 	 var finallConfig=paginator.finallConfig;
		 var state=paginator.state;
		 var bz=paginator.bz;
			 	 
		 var type=a.attr("type");
			//单纯的点击页号
		 var num=a.attr("num");
		 var intnum=parseInt(num);
		 switch(type)
		 {
		   case "first":
			 {
			     //首页
			   state.activePage=1;
			   state.startPage=1;
			 }break;
		   case "pre":
			   {
			      //前一页
			      state.activePage=state.activePage-1;
			      if(state.activePage<=0)
			    	  {
			    	     state.activePage=1;
			    	     state.startPage=1;
			    	  }else
			    		  {
			    		    state.startPage=state.startPage-1;
			    		  }
			    
			   }break;
		   case "next":
		   		{
			   		//下一页
			   		 state.activePage=state.activePage+1;
			   		 if(state.activePage>=state.pageCount)
			    	  {
			    	     state.activePage=state.pageCount;
			    	  }
			   		 
			   		 //如果
			   		 if(state.activePage>state.endPage)
			   			 {
				   			 if((state.endPage+1)<=state.pageCount)
				   			 {
				   			    //如果最后一页在加1页不会超出范围
				   			    state.startPage=state.startPage+1;
				   			 }
			   			 }
			   		
		   		}break; 
			   case "last":
		   		{
			   		//最后一页
				   state.activePage=state.pageCount;
				   if(state.pageCount>finallConfig.countInBar)
					   {
					       state.startPage=state.pageCount-finallConfig.countInBar+1;
					   }else
						   {
						      state.startPage=1;
						   }
		   		}break; 
			   case "page":
		   		{
				     state.activePage=intnum; 
		   		}break; 
		   		default:
		   			return ;
		 }
		 if(state.startPage<=0)
			 {
			    state.startPage=1;
			 }
		  if(state.endPage>=state.pageCount)
			  {
			    state.endPage=state.pageCount;
			  }
		 //生成html，然后append
	     var html=methods.createHtml(paginator);
	     paginator.empty();
	     paginator.append(html);
	     paginator.find("a[bz='"+bz+"']").bind("click",function(){
			 linkClick(paginator,$(this));
		 });
		
		 if(typeof(finallConfig.clickPage)=="function")
		  {
		  	    var _start=(intnum-1)*finallConfig.pageRowCount
		  	    var obj={pageNumber:intnum, //用户点击的页号
					 totalRecord:finallConfig.totalRecords,//总的记录数
					 pageRowCount:finallConfig.pageRowCount,//每一页显示的记录数
					 start:_start  //计算好的，该也上放置的第一条记录的序号
					 };
		  		finallConfig.clickPage(obj);
		  }
	 }
	 
	$.fn.CJPaginator=function(config){
		var args = arguments;
		var _paginator=$(this);
		_paginator.finallConfig={};
	
		_paginator.state={startPage:1,//bar上的起始页
			 	endPage:1,//bar上的结束页
			 	activePage:1,//活动页的页号
			 	pageCount:1//总页数
			 };
		_paginator.bz="lj";
		var finallConfig=_paginator.finallConfig;
		var state=_paginator.state;
		var bz=_paginator.bz;
		if(typeof(args[0])==="string")
			{
			  return methods[args[0]].apply(this,args);
			}
		 $.extend(finallConfig,defaultConfig);
		 $.extend(finallConfig,config);
		 state.activePage=finallConfig.activePageIndex;
		 state.pageCount=Math.ceil(finallConfig.totalRecords/finallConfig.pageRowCount);//分页后的总页数
		 if(finallConfig.pageRowCount<=0)
			 {
			    alert("每页显示的记录数必须为正整数！");
			    return ;
			 }
		 var html=methods.createHtml(_paginator);
		 $(this).empty();
		 $(this).append(html);
		 $(this).find("a[bz='"+bz+"']").bind("click",function(){
			 linkClick(_paginator,$(this));
		 });

		 //生成完成后调用一次click
		  $(this).find("a[state='active']").trigger("click");

	}
 
})($,window);
