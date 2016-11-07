function setLocation(url){
    window.location.href = url;
}

function confirmSetLocation(message, url){
    if( confirm(message) ) {
        setLocation(url);
    }
    return false;
}
function tips() {

}
function deleteConfirm(message, url) {
    confirmSetLocation(message, url);
}

function encode_base64( what )
{
    var base64_encodetable = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var result = "";
    var len = what.length;
    var x, y;
    var ptr = 0;
    console.log(what);

    while( len-- > 0 )
    {
        x = what.charCodeAt( ptr++ );
        result += base64_encodetable.charAt( ( x >> 2 ) & 63 );

        if( len-- <= 0 )
        {
            result += base64_encodetable.charAt( ( x << 4 ) & 63 );
            result += "==";
            break;
        }

        y = what.charCodeAt( ptr++ );
        result += base64_encodetable.charAt( ( ( x << 4 ) | ( ( y >> 4 ) & 15 ) ) & 63 );

        if ( len-- <= 0 )
        {
            result += base64_encodetable.charAt( ( y << 2 ) & 63 );
            result += "=";
            break;
        }

        x = what.charCodeAt( ptr++ );
        result += base64_encodetable.charAt( ( ( y << 2 ) | ( ( x >> 6 ) & 3 ) ) & 63 );
        result += base64_encodetable.charAt( x & 63 );

    }

    return result;
}


function decode_base64( what )
{
    var base64_decodetable = new Array (
        255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255,
        255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255,
        255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255,  62, 255, 255, 255,  63,
         52,  53,  54,  55,  56,  57,  58,  59,  60,  61, 255, 255, 255, 255, 255, 255,
        255,   0,   1,   2,   3,   4,   5,   6,   7,   8,   9,  10,  11,  12,  13,  14,
         15,  16,  17,  18,  19,  20,  21,  22,  23,  24,  25, 255, 255, 255, 255, 255,
        255,  26,  27,  28,  29,  30,  31,  32,  33,  34,  35,  36,  37,  38,  39,  40,
         41,  42,  43,  44,  45,  46,  47,  48,  49,  50,  51, 255, 255, 255, 255, 255
    );
    var result = "";
    var len = what.length;
    var x, y;
    var ptr = 0;

    while( !isNaN( x = what.charCodeAt( ptr++ ) ) )
    {
        if( x == 13 || x == 10 )
            continue;

        if( ( x > 127 ) || (( x = base64_decodetable[x] ) == 255) )
            return false;
        if( ( isNaN( y = what.charCodeAt( ptr++ ) ) ) || (( y = base64_decodetable[y] ) == 255) )
            return false;

        result += String.fromCharCode( (x << 2) | (y >> 4) );

        if( (x = what.charCodeAt( ptr++ )) == 61 )
        {
            if( (what.charCodeAt( ptr++ ) != 61) || (!isNaN(what.charCodeAt( ptr ) ) ) )
                return false;
        }
        else
        {
            if( ( x > 127 ) || (( x = base64_decodetable[x] ) == 255) )
                return false;
            result += String.fromCharCode( (y << 4) | (x >> 2) );
            if( (y = what.charCodeAt( ptr++ )) == 61 )
            {
                if( !isNaN(what.charCodeAt( ptr ) ) )
                    return false;
            }
            else
            {
                if( (y > 127) || ((y = base64_decodetable[y]) == 255) )
                    return false;
                result += String.fromCharCode( (x << 6) | y );
            }
        }
    }
    return result;
}

function wrap76( what )
{
    var result = "";
    var i;

    for(i=0; i < what.length; i+=76)
    {
        result += what.substring(i, i+76) + String.fromCharCode(13) + String.fromCharCode(10);
    }
    return result;
}

/**
 * @描述：封装的工具类
 */

(function(window, undefined)
{
	var SimpleTool =
	{};
	var dateHadExtend=false;//是否已经扩展Date类
	
	
	
	/**
	 * @作者 陈杰
	 * @描述 判断单个变量是否为空
	 */
	SimpleTool.isNull = function(v)
	{
		if (v == undefined)
		{
			return true;
		}
		if (typeof(v) == "string")
		{
			if (v == "undefined" || v == "" || v == "null"||$.trim(v)=="")
			{
				return true;
			}
		}
		if (typeof(v) == "object")
		{
			if (v == null||v.length<=0)
			{
				return true;
			}
		}
		return false;

	}

	/**
	 * @作者 陈杰
	 * @描述 判断所传入参数中是否有空，参数个数是不受到限制的
	 * @调用示例 SimpleTool.hasNull(a,b,c,d);
	 */
	SimpleTool.hasNull = function()
	{
		for (var i = 0; i < arguments.length; i++)
		{
			if (SimpleTool.isNull(arguments[i]))
			{
				return true;
			}
		}
		return false;
	}
	/**
	 * @作者 陈杰(转)
	 * @描述 将页面嵌入
	 * @调用示例 new SimpleTool.EmbTool("czrz/showlist?czrz.glid=dfds&type=tl", "",
	 *       "", "embidContainer", "1","");
	 */
	SimpleTool.EmbTool = function(B, A)
	{
		this.bindFunction = function(E, D)
		{
			return function()
			{
				return E.apply(D,
						[D])
			}
		};
		this.stateChange = function(D)
		{
			if (this.request.readyState == 4)
			{
				if (this.appendHtml)
				{
					if (this.request.status == 200)
					{
						document.getElementById(this.srcElement).innerHTML = this.request.responseText
					} else
					{
						document.getElementById(this.srcElement).innerHTML = this.failTxt
					};
				} else
				{
					this.callbackFunction(this.request,
							this.request.responseText, this.srcElement)
				}
			}
		};
		this.getRequest = function()
		{
			if (window.ActiveXObject)
			{
				return new ActiveXObject("Microsoft.XMLHTTP")
			} else
			{
				if (window.XMLHttpRequest)
				{
					return new XMLHttpRequest()
				}
			}
			return false
		};
		this.callbackFunction = A;
		this.url = B;
		this.postBody = (arguments[2] || "");
		this.srcElement = arguments[3];
		this.appendHtml = arguments[4];
		this.failTxt = "<font color='#FF0000'><I>错误</I></font>";
		if (arguments[5])
		{
			this.failTxt = arguments[5];
		}
		this.request = this.getRequest();
		if (this.request)
		{
			var C = this.request;
			C.onreadystatechange = this.bindFunction(this.stateChange, this);
			if (this.postBody !== "")
			{
				C.open("POST", B, true);
				C.setRequestHeader("X-Requested-With", "XMLHttpRequest");
				C.setRequestHeader("Content-type",
						"application/x-www-form-urlencoded");
				C.setRequestHeader("If-Modified-Since", "0");
				C.setRequestHeader("Connection", "close")
			} else
			{
				C.open("GET", B, true)
				C.setRequestHeader("If-Modified-Since", "0");
			}
			C.send(this.postBody)
		}
	};

	SimpleTool.openCzrzDiv = function(id)
	{
		$("#embidContainer" + id).hide();
		$("#embidload" + id).hide();
		$("#embidcontext" + id).show();
	}

	SimpleTool.loadCzrzDiv = function(url, id)
	{
		new SimpleTool.EmbTool(url, "", "", "embidContainer" + id, "1", "");
		$("#embidContainer" + id).show();
		$("#embidload" + id).show();
		$("#embidcontext" + id).hide();
	}

	SimpleTool.startLoad = function()
	{
		var array = $("img[id^='embidcontext']").click();
	}

	SimpleTool.fetchWebRootURL = function()
	{
		// js获取项目根路径，如： http://localhost:8083/uimcardprj

		// 获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
		var curWwwPath = window.document.location.href;
		// 获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
		var pathName = window.document.location.pathname;
		var pos = curWwwPath.indexOf(pathName);
		// 获取主机地址，如： http://localhost:8083
		var localhostPaht = curWwwPath.substring(0, pos);
		// 获取带"/"的项目名，如：/uimcardprj
		var projectName = pathName.substring(0, pathName.substr(1).indexOf('/')
						+ 1);
		return (localhostPaht + projectName);

	}

	SimpleTool.refreshPage = function(window,param)
	{
		if (window == undefined)
		{
			alert("未传入windw对象！");
			return;
		}
		if(!SimpleTool.isNull(param))
		{
			if(param.indexOf("&")!=0)
			{
				param="&"+param;
			}
		}
		// 不是关窗口的操作，而是重新加载页面
		$("#save_btn").removeAttr("disabled");
		// 强制刷新本页面
		var tmp = window.location.href;
		var ind=tmp.indexOf("?");
		if (index < 0)
		{
		   window.location.href=window.location.href+"1=1";
		}
		var index = tmp.indexOf("rd_rd");
		if (index > 0)
		{
			var a = tmp.substr(0, index - 1);
			window.location.href = tmp + "&rd_rd=" + Math.random()+param;

		} else
		{
			window.location.href = tmp + "&rd_rd=" + Math.random()+param;
		}
	}

	// alert 封装
	SimpleTool.alert = function(param)
	{
		var paramDefault={
			title:"提示", msg:"", icon:"info", callback:function(){}
		};
		var finalParam={};
		$.extend(true,finalParam,paramDefault);
		$.extend(true,finalParam,param);
		if (typeof(layer)!= undefined)
		{
			// 需要引入skynetDialog.js
		  layer.alert(finalParam.msg,-1);
		    
		}else
		{
			// 使用普通alert
			alert(finalParam.msg);
			if (typeof finalParam.callback == "function")
			{
				finalParam.callback();
			}
		}

	}

	// confirm封装
	SimpleTool.confirm = function(btnTitle, msg, okCallback, cacelCallback)
	{
		if (sky != undefined && sky.skynetDialog != undefined)
		{
			// 需要引入skynetDialog.js
			skynetDialog.confirm(msg, okCallback, cacelCallback);
			return;
		} else if ($ != undefined && $.messager != undefined)
		{
			// 使用easyui
			// "info"
			$.messager.confirm(btnTitle, msg, function(b)
					{
						if (b == false)
						{
							// 否
							if (cacelCallback != undefined)
							{
								if (typeof(cacelCallback) == "function")
								{
									// 需要回调
									cacelCallback();
								} else
								{
									SimpleTool.alert("传入的回调函数参数错误！cacelCallback");
								}

							}
							return;
						} else
						{
							// 是
							if (okCallback != undefined)
							{
								if (typeof(okCallback) == "function")
								{
									// 需要回调
									okCallback();
								} else
								{
									SimpleTool.alert("传入的回调函数参数错误！okCallback");
								}

							}
							return;
						}
					});
			return;
		} else
		{
			// 使用普通alert
			var b = confirm(msg);
			if (b == false)
			{
				// 否
				if (cacelCallback != undefined)
				{

					if (typeof(cacelCallback) == "function")
					{
						// 需要回调
						cacelCallback();
					} else
					{
						SimpleTool.alert("传入的回调函数参数错误！cacelCallback");
					}

				}
			} else
			{
				// 是
				if (okCallback != undefined)
				{
					if (typeof(okCallback) == "function")
					{
						// 需要回调
						okCallback();
					} else
					{
						SimpleTool.alert("传入的回调函数参数错误！okCallback");
					}

				}
			}
			if (typeof callback == "function")
			{
				callback();
			}
		}
	}
	SimpleTool.savewindow = function()
	{
		var tpstr = "window" + Math.random();
		tpstr = tpstr.replace(/\./g, "");
		var exestr = "window.top." + tpstr + "=window";
		eval(exestr);
		return tpstr;
	}

	SimpleTool.createMaskLayer=function(obj) {
		if(obj==undefined)
		{
			obj={};
		}
		var webRoot=SimpleTool.fetchWebRootURL();
		var imgsrc=webRoot+"/static/app/performance/images/loading.gif";
		 var defaultConfig={title:"正在处理中，请稍候……",_window:window,dest:$("body")};
		  var finallConfig={};
		  $.extend(finallConfig,defaultConfig);
	      $.extend(finallConfig,obj);
		// var $maskLayer = $('<div style="vertical-align:middle;color:black;" class="top-maskLayer">'+finallConfig.title+'</div>');
	      var $maskLayer = $('<div style="vertical-align:middle;color:black;" class="top-maskLayer">'+'<img src="'+imgsrc+'" style="width:32px; height:32px;" />'+'</div>');
		 var lineHeight_=$(finallConfig.dest).height()+"px";
		 var top_=$(finallConfig.dest).offset().top;
		 top_=top_-document.body.scrollTop;
		 var left_=$(finallConfig.dest).offset().left;
		 left_=left_-document.body.scrollLeft;
		 $maskLayer.css({
			background: "#e8e8e8",
			opacity: "0.5",
			position: "fixed",
			left: left_,
			top: top_,
			width:   $(finallConfig.dest).width(),
			height:  $(finallConfig.dest).height(),
			fontSize: "15px",
			zIndex: 9999999,
			lineHeight: lineHeight_,
			textAlign: "center"
		});
		$maskLayer.appendTo($(finallConfig.dest));
	}
	
	SimpleTool.removeMaskLayer=function(obj) {
		if(obj==undefined)
		{
			obj={};
		}
		 var defaultConfig={_window:window};
		    $.extend(obj,defaultConfig);
		obj._window.$(".top-maskLayer").remove();
	}
	
	// 根据传入参数，获取jQuery对象
	SimpleTool.jQueryObject = function(obj)
	{
		if (SimpleTool.isNull(obj))
		{
			return null;
		}
		if (typeof(obj) == "string")
		{
			return $("#" + obj);
		} else
		{
			return $(obj);
		}
	}
	// 生成一个字符串作为ID
	SimpleTool.createRdID = function()
	{
		var tmp = "" + Math.random();
		tmp = tmp.replace(".", "");
		var date = new Date();
		tmp = tmp + date.getTime();
		return tmp;
	}
	
	/**
	 * 扩展时间类
	 */
	SimpleTool.extendDate = function() {
		Date.prototype.Format = function(fmt) {
			var o = {
				"M+" : this.getMonth() + 1, // 月份
				"d+" : this.getDate(), // 日
				"h+" : this.getHours(), // 小时
				"m+" : this.getMinutes(), // 分
				"s+" : this.getSeconds(), // 秒
				"q+" : Math.floor((this.getMonth() + 3) / 3), // 季度
				"S" : this.getMilliseconds()
				// 毫秒
			};
			if (/(y+)/.test(fmt))
				fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4
								- RegExp.$1.length));
			for (var k in o)
				if (new RegExp("(" + k + ")").test(fmt))
					fmt = fmt.replace(RegExp.$1,
							(RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k])
									.substr(("" + o[k]).length)));
			return fmt;
		}
		
		dateHadExtend=true;
	}
	
	SimpleTool.formatDate = function(date,format) {
		 SimpleTool.extendDate();
		 if(SimpleTool.isNull(date))
		 {
		 	return "";
		 }
		 if(SimpleTool.isNull(format))
		 {
		 	return "";
		 }
		 if(date instanceof Date)
		 {
		 	return date.Format(format);
		 }
	}
	
	// 判断两个时间是否属于同一个月份
	 SimpleTool.dateInSameMonth=function(date1,date2)
	 {
	    	try
	    	{
	    		if(dateHadExtend==false)
	    		{
	    			SimpleTool.extendDate();
	    		}
	    		var format = "yyyy-MM";
	    		var str1=date1.Format(format);
	    		var str2=date2.Format(format);
	    		if(str1==str2)
	    		{
	    			return true;
	    		}else
	    		{
	    			return false;
	    		}
	    	}catch(e)
	    	{
	    		throw new Error("判断两个时间是否处于同一个月份出现异常！");
	    	}
	 }
	 SimpleTool.parseDate=function(str)
	 {
	 	    if(SimpleTool.isNull(str))
	 	    {
	 	       //如果为空
	 	       return null;
	 	    }
	 	    if(typeof(str)=="number")
			{
			   var date=new Date(str);
			   return date;
			}
			
	 	    str=$.trim(str);
	 	    var  partten = "", reg = null;
	 	    var strlong = "^[0-9]*$";
            var ny2 = "^\\d{4}-([0][1-9]|[1][0-2])$";
            var nyr2 = "^\\d{4}-([0][1-9]|[1][0-2])-([0][1-9]|[1-2][0-9]|[3][0-1])$";
            var nyrsfm2 = "^\\d{4}-([0][1-9]|[1][0-2])-([0][1-9]|[1-2][0-9]|[3][0-1]) ([0-1][0-9]|2?[0-3]):([0-5][0-9]):([0-5][0-9])$";
             var nyrsf2 = "^\\d{4}-([0][1-9]|[1][0-2])-([0][1-9]|[1-2][0-9]|[3][0-1]) ([0-1][0-9]|2?[0-3]):([0-5][0-9])$";
            var sfm2 = "^\\d([0-1][0-9]|2?[0-3]):([0-5][0-9]):([0-5][0-9])$";
            var sf2 = "^([0-1][0-9]|2?[0-3]):([0-5][0-9])$";
            var fm2 = "^([0-5][0-9]):([0-5][0-9])$";
            try
            {
            	   if (new RegExp(strlong).test(str))
                    {
                        //longtime
                    	var date = new Date(Number(str)); 
                    	return date;
                    }else if (new RegExp(ny2).test(str))
                    {
                        //年月的格式
                    	var oDate1= str.split("-"); 
                    	var date = new Date(oDate1[0], oDate1[1]-1); 
                    	return date;
                    }else if(new RegExp(nyr2).test(str))
					{
					   		var oDate1= str.split("-"); 
                    	    var date = new Date(oDate1[0], oDate1[1]-1,oDate1[2]); 
                    	    return date;
					}else if(new RegExp(nyrsfm2).test(str))
					{
							var a1=str.split(" "); 
					   		var oDate1= a1[0].split("-"); 
							var oDate2= a1[1].split(":"); 
                    	    var date = new Date(oDate1[0], oDate1[1]-1,oDate1[2],oDate2[0],oDate2[1],oDate2[2]); 
                    	    return date;
					}else if(new RegExp(nyrsf2).test(str))
					{
							var a1=str.split(" "); 
					   		var oDate1= a1[0].split("-"); 
							var oDate2= a1[1].split(":"); 
                    	    var date = new Date(oDate1[0], oDate1[1]-1,oDate1[2],oDate2[0],oDate2[1]); 
                    	    return date;
					}else if(new RegExp(sfm2).test(str))
					{
						 	var oDate2= str.split(":"); 
                    	    var date = new Date(); 
							date.setHours(oDate2[0],oDate2[1],oDate2[2]);
                    	    return date;
					}else if(new RegExp(sf2).test(str))
					{
						 	var oDate2= str.split(":"); 
                    	    var date = new Date(); 
							date.setHours(oDate2[0],oDate2[1],0);
                    	    return date;
					}else if(new RegExp(fm2).test(str))
					{
						 	var oDate2= str.split(":"); 
                    	    var date = new Date(); 
							date.setHours(0,oDate2[0],oDate2[1]);
                    	    return date;
					}else
					{
					   alert("SimpleTool解析时间出错，时间值非法！");
					}
            }catch(e)
            {
            	alert("SimpleTool解析时间出异常！");
            	return null;
            }
             
	 }
	 
	//将数组去重
    SimpleTool.uniqueArray = function(arr)
	{
		if (SimpleTool.isNull(arr))
		{
			return [];
		}
		var result = [], hash =
		{};
		for (var i = 0, elem; (elem = arr[i]) != null; i++)
		{
			if (!hash[elem])
			{
				result.push(elem);
				hash[elem] = true;
			}
		}
		return result;
	}

	 //移除数组中的某个元素
	SimpleTool.removeArray=function(array,val)
	{
		   var bNeedCurl=false;
	 	    do{
	 	    	  var index = array.indexOf(val);
	              if (index > -1) {
	                array.splice(index, 1);
	                bNeedCurl=true;
	              }else
	              {
	              	bNeedCurl=false;
	              }
	 	    }while(bNeedCurl);
	}
	 
	function patternReg(pattern,val)
	{
		try
		{
			return pattern.test(val);
		}catch(e)
		{
			return false;
		}
	}
	
	//判断是否是电话号码
	SimpleTool.isPhone=function(val)
	{
		 if(SimpleTool.isNull(val))val="";
		 var pattern = /^1\d{10}$/;
    	 return patternReg(pattern,val);
	}
	
	//判断是否是手机号
	SimpleTool.isMobile=function(val)
	{
		 if(SimpleTool.isNull(val))val="";
		  var pattern = /^1\d{10}$/;
    	  return patternReg(pattern,val);
	}
	
	//判断是否是邮箱
	SimpleTool.isEmail=function(val)
	{
		   if(SimpleTool.isNull(val))val="";
		   var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;  
    	  return patternReg(pattern,val);
	}
	
	//判断是否是正数（可以是整数也可以是小数）
	SimpleTool.isPositiveNum =function(val)
	{
		    if(SimpleTool.isNull(val))val="";
		    var pattern = /^\d+(\.\d+)?$/;
    	    return patternReg(pattern,val);
	}
	
	//判断是否是正正数
	SimpleTool.isPositiveInt =function(val)
	{
		    if(SimpleTool.isNull(val))val="";
		    var pattern = /^\d+$/;
    	    return patternReg(pattern,val);
	}
	
	//判断输入密码
	SimpleTool.checkPassW = function(value){
		var pattern = /^[a-zA-Z0-9]{6,14}$/;
		var contents = value.split("");
		var subPattern = /\d/;
		if (!/\d/.test(contents[0])) {
			subPattern = /[a-zA-Z]/;
		}
		if (pattern.test(value)) {
			for (var i = 0, len = contents.length; i < len - 1; i++) {
				if (subPattern.test(contents[i]) != subPattern.test(contents[i + 1])) return true;
			}
		}
		return false;
	}
	
	
	//判断是否是合法的IP（可以是整数也可以是小数）
	SimpleTool.isIp =function(val)
	{
		    if(SimpleTool.isNull(val))val="";
		    var pattern = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
    	    return patternReg(pattern,val);
	}
	
	var glob_mask_loadid=null;
	var glob_mask_count=0;

	//加一个全局的遮罩层，目前只支持使用master-layer
	SimpleTool.createGlobMaskLayer=function()
	{
		if(SimpleTool.isNull(window.top.layer))
		{
			alert("该遮罩只限于支持master-layer！");
			return ;
		}
		if(glob_mask_loadid==null||glob_mask_count<=0)
		{
			glob_mask_loadid=window.top.layer.load(0, 2); //打开加载层，关闭时使用layer.close(loadid)
			glob_mask_count=1;
		}else
		{
			glob_mask_count++;
		}
	}
	
	//移除全局的遮罩层
	SimpleTool.removeGlobMaskLayer=function()
	{
		if(SimpleTool.isNull(window.top.layer))
		{
			alert("该遮罩只限于支持master-layer！");
			return ;
		}
		
		//加载成功之后需要移除
		if(glob_mask_count>0)
		{
			glob_mask_count--;
		}else
		{
			glob_mask_count=0;
		}
		if(glob_mask_count==0)
		{
			//执行移除
			window.top.layer.close(glob_mask_loadid);//关闭遮罩
		}
	}
	
	//判断是否有ajax异常
	SimpleTool.hasAjaxException = function(response,$obj)
	{
		try
		{
			var json={};
			if(typeof(response)=="object")
			{
				 json=response;
			}
			else
			 {
			 	json = $.parseJSON(response);
			 }
			if (json != undefined && json.success == false&&json.exception==true)
			{
				var tip = "出现异常！";
				if (!SimpleTool.isNull(json.msg))
				{
					tip = json.msg;
				}
				window.top.layer.alert(tip, -1);
				if($($obj))
				{
					$($obj).empty();
				}
				return true;
			}
			return false;
		} catch (e)
		{
			return false;
		}
	}
	SimpleTool.ajax=function(_config_)
	{
		if(SimpleTool.isNull(_config_)||typeof(_config_)!="object")
		{
			return ;
		}
		var finalConfig_={};
		     $.extend(finalConfig_,_config_);
		 	 finalConfig_.success=function(data)
		 	 {
		 	 	 if(SimpleTool.hasAjaxException(data))
							{
								//如果出现了ajax异常
								if(typeof(_config_.error)=="function")
								{
									if(typeof(data)=="string")
									{
										data=$.parseJSON(data);
									}
									_config_.error(true,true,data);
								}
								return ;
							}
					if(data.success==true)
					{
						//返回成功
						if(typeof(_config_.success)=="function")
						{
							_config_.success(data);
						}
						
					}else
					{
						//返回失败
						if(typeof(_config_.error)=="function")
								{
									_config_.error(true,false,data);
								}
								return ;
					}
		 	 	 	
		 	 }
		 	 finalConfig_.error=function(XMLHttpRequest, textStatus, errorThrown)
					{
						if (XMLHttpRequest.status == 200)
						{
							var json = $.parseJSON(XMLHttpRequest.responseText);
							if(typeof(json)=="object")
							{
								 window.top.layer.alert("访问了服务器，但是出现异常！详情："+json, -1);
							}
							if(typeof(_config_.error)=="function")
							{
								if(typeof(json)=="string")
								{
									json=$.parseJSON(json);
								}
								_config_.error(true,false,json);
							}
						} else if (XMLHttpRequest.readyState != 0)
						{
							window.top.layer.alert('网络连接出错！'
											+ XMLHttpRequest.status + "、"
											+ XMLHttpRequest.readyState + "、"
											+ textStatus + "、" + errorThrown,
									-1);
							if(typeof(_config_.error)=="function")
							{
								_config_.error(false,false,{msg:'网络连接出错！'});
							}
						}
					}
			$.ajax(finalConfig_);
	}
	
	window.SimpleTool = SimpleTool;
})(window);

(function($) {
			$.fn.serializeJson = function() {
				var serializeObj = {};
				var array = this.serializeArray();
				var str = this.serialize();
				$(array)
						.each(
								function() {
									if (serializeObj[this.name]) {
										if ($.isArray(serializeObj[this.name])) {
											serializeObj[this.name]
													.push(this.value);
										} else {
											serializeObj[this.name] = [
													serializeObj[this.name],
													this.value ];
										}
									} else {
										serializeObj[this.name] = this.value;
									}
								});
				return serializeObj;
			};
		
})(jQuery);

var callbacks = $.Callbacks();

jQuery.extend({
	showLoading: function () {
		if (!$("#_loading").length) $("<div id=\"_loading\" class=\"loading\"><div></div><div></div><div></div>数据加载中，请稍后...</div>").appendTo("body");
	},
	//移除loading
	removeLoading: function () {
		if ($("#_loading").length) $("#_loading").remove();
	},
	//启动按钮
	enable: function (el) {
		if (typeof (el) == "undefined" || el === null || el === "") return;
		$(el).removeClass("btn-disabled");
		$.removeLoading();
	},
	//禁用按钮
	disable: function (el) {
		if (typeof (el) == "undefined" || el === null || el === "") return;
		$(el).addClass("btn-disabled");
		$.showLoading();
	},
	//是否被禁用
	isDisabled: function (el) {
		return $(el).hasClass("btn-disabled");
	},
	//设置缓存数据
    setCache: function (key, value) {
        if (!key) return false;
        window.localStorage ? window.localStorage.setItem(key, value) : $.cookie(key, value);
    },
    //获取缓存数据
    getCache: function (key) {
        if (!key) return null;
        return window.localStorage ? window.localStorage.getItem(key) : $.cookie(key);
    },
	//回到顶部
	gotop: function () {
		if ($("#goTop").length) $("#goTop").remove();
	    $("<a class=\"go-top\" id=\"goTop\" href=\"javascript:;\"><i></i></a>").appendTo("body").off("click").on("click", function () {
	        window.scrollTo(0, 0);
	    });

	    var top = document.documentElement.scrollTop || document.body.scrollTop;
	    top > 500 && $("#goTop").show();

	    $("#goTop").hover(function () {
	        $(this).html("顶部");
	    }, function () {
	        $(this).html("<i></i>");
	    });

	    $(window).scroll(function () {
	        var _top = document.documentElement.scrollTop || document.body.scrollTop;
	        _top <= 50 ? $("#goTop").hide() : $("#goTop").show();
	    });
	},
	//动态加载css文件
	getCss: function (file, version, callback) {
		var files = typeof file == "string" ? [file] : file;
        for (var i = 0; i < files.length; i++) {
            var name = files[i].replace(/^\s|\s$/g, "");
            var att = name.split(".");
            var ext = att[att.length - 1].toLowerCase();
            var isCSS = ext == "css";
            var tag = isCSS ? "link" : "script";
            var attr = isCSS ? " type=\"text/css\" rel=\"stylesheet\" " : " type=\"text/javascript\" ";
            var link = (isCSS ? "href" : "src") + "=\"" + name + "?" + (version || new Date().getTime()) + "\"";
            
            if (!$(tag + "[" + link + "]").length) {
                isCSS ? $("head").append("<" + tag + attr + link + " />") : $("head").append("<" + tag + attr + link + "></" + tag + ">");
            }
        }
        callback && callback();
	},
	//格式化money, s:money, n:要显示的小数位数(不传此参数默认显示两位，自动四舍五入)
	formatMoney: function (s, n) {
		n = n > 0 && n <= 20 ? n : 2;  
	    s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";  
	    var l = s.split(".")[0].split("").reverse(),
	    	r = s.split(".")[1],
	    	t = "";
	    for (i = 0; i < l.length; i++) {  
	        t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");  
	    }  
	    return t.split("").reverse().join("") + "." + r;  
    },
    scrollTo: function (selector, callback) {
        var _el = $(selector),
            _timer,
            _dead_time = 100,
            _min_dead_time = 10,
            _first_position = document.documentElement.scrollTop || document.body.scrollTop,
            _distance,
            _min_distance = 200,
            _step,
            _top_position,
            _curr_position,
            _scroll_height = $(document).height(),
            _window_height = $(window).height(),
            _runTop = function () {
                _curr_position = document.documentElement.scrollTop || document.body.scrollTop;
                _curr_position += _step;
                if ((_step < 0 && _curr_position >= _top_position) || (_step > 0 && _curr_position <= _top_position)) {
                    if (_step > 0 && (_curr_position + _window_height >= _scroll_height)) {
                        clearInterval(_timer);
                        callback && callback();
                    }
                    window.scrollTo(0, _curr_position);
                }
                else {
                    clearInterval(_timer);
                    callback && callback();
                }
            };
        if (!_el || !_el.length) return false;
        _top_position = _el.offset().top;
        _distance = _top_position - _first_position;

        _step = _distance / (Math.abs(_distance) <= _min_distance ? _min_dead_time : _dead_time);
        _timer = setInterval(_runTop, 1);
    }
})

var MIO = MIO || {};
MIO.customUnit = (function() {
	function cutomCheckbox(){
		var items = $(".checkbox-icons");
		//根据checkbox初始化选择状态
		for (var i = 0; i < items.length; i++) {
			var checkbox = $(items[i]).find("input[type=checkbox]");
			if (checkbox.is(':checked')) {
				$(items[i]).addClass('checkbox-icons-checked');
			}
		}
		$("body").on("click",".checkbox-icons input[type=checkbox]",function(){
			var that = $(this);
			if (that.is(':checked')) {
				that.parent().addClass('checkbox-icons-checked');
				that.parent().parent().addClass('tr-checked');
			}else{
				that.parent().removeClass('checkbox-icons-checked');
				that.parent().parent().removeClass('tr-checked');
			}
		});
	}
	function cutomRadio(){
		var items = $(".radio-icons");
		//根据radio默认checked初始化选择状态
		for (var i = 0; i < items.length; i++) {
			var radio = $(items[i]).find("input[type=radio]");
			if (radio.is(':checked')) {
				if($(items[i]).hasClass('radio-disable-null') || $(items[i]).hasClass('radio-disable')){
					continue;
				}
				$(items[i]).addClass('radio-icons-checked');
			}
		}
		$("body").on("click",".radio-icons input[type=radio]",function(){
			var that = $(this);
			var name = $(this).attr("name");
			if(that.parent().hasClass('radio-disable-null') || that.parent().hasClass('radio-disable')){
				return;
			}
			if (that.is(':checked')) {
				$("[name='"+name+"']").parent().removeClass('radio-icons-checked');
				that.parent().addClass('radio-icons-checked');
			}
		});
	}
	//选中radio
	function checkRadio(radios){
		for (var i = 0; i < radios.length; i++) {
			var radio = $(radios[i]);
			radio.prop("checked",true);
			var name = radio.attr("name");
			$("[name='"+name+"']").parent().removeClass('radio-icons-checked');
			radio.parent().addClass('radio-icons-checked');
		};
	}
	//取消选中
	function cancelCheckRadio(radios){
		for (var i = 0; i < radios.length; i++) {
			var radio = $(radios[i]);
			radio.prop("checked",false);
			radio.parent().removeClass('radio-icons-checked');
		};
	}
	//checkbox全选
	function checkAll(){
		$("body").on("click",".checkbox-icons-all input[type=checkbox]",function(){
			var that = $(this);
			var table = $(this).closest('table');
			if (that.is(':checked')) {
				that.parent().addClass('checkbox-icons-all-checked');
				table.find('tbody input[type=checkbox]').prop('checked', true);
				table.find('tbody input[type=checkbox]').parent().removeClass('checkbox-icons-checked');
				table.find('tbody input[type=checkbox]').parent().addClass('checkbox-icons-checked');
				table.find('tbody tr').removeClass('tr-checked');
				table.find('tbody tr').addClass('tr-checked');
			}else{
				that.parent().removeClass('checkbox-icons-all-checked');
				table.find('tbody input[type=checkbox]').prop('checked', false);
				table.find('tbody input[type=checkbox]').parent().removeClass('checkbox-icons-checked');
				table.find('tbody tr').removeClass('tr-checked');
			}
		});
	}
	function changeTheTab(){
		var lis = $(".tab-title li");
		var divs = $(".tab-content");
		if (lis.length!=divs.length) {return;}
		var tabIndex = 0;
		for (var i = 0; i < lis.length; i++) {
			$(lis[i]).attr("id",i);
			$(lis[i]).click(function() {
				var that = $(this);
				tabIndex = that.attr("id");
				for (var j = 0; j < lis.length; j++) {
					$(lis[j]).removeClass("tab-title-selected");
					$(divs[j]).css("display","none");
				}
				$(lis[tabIndex]).addClass('tab-title-selected');
				$(divs[tabIndex]).css("display","");
			});
		}
	}
	//获取选中的checkbox的value
	function getCheckedbox(container,name){
		var checkboxes = [];
		if (name != undefined) {
			container.find("input[type=checkbox][name='"+name+"']:checked").each(function(index,el){
				var value = $(el).val();
				if (value.length > 0) {
					checkboxes.push(value);
				};
				
			});
		}else{
			container.find("input[type=checkbox]:checked").each(function(index,el){
				var value = $(el).val();
				if (value.length > 0) {
					checkboxes.push(value);
				};
			});
		}
		return checkboxes;
	}
	//滚动条
	function createScrollBar(container){
		container.mCustomScrollbar({
		    theme:"dark",
		    scrollEasing:"linear",
		    scrollInertia:300
		});
	}
	function createScrollBarX(container){
		container.mCustomScrollbar({
			theme: "dark",
			axis: "x",
			scrollEasing:"linear",
			scrollInertia:300
		});
	}
	//下拉菜单
	function createChosenList(width,container) {
		container.chosen({
			width : width,
			disable_search : true
		});
	}
	function createChosenListAuto(container) {
		container.chosen({
			disable_search : true
		});
	}
	//选择框checkbox
	function bindChoseCheckboxEvent(){
		$("body").on("click",".choseCheckbox",function(){
			if ($(this).is(":checked")) {
				$(this).parent().addClass('item-checked');
			}else{
				$(this).parent().removeClass('item-checked');
			}
		});
		$("body").on("click",".dialog-choseall",function(){
			var btnStatus = $(this).data("status");
			if (btnStatus == "cancelAll") {
				$(this).parents(".dialog-chose-section").find('.dialog-chose-item').removeClass('item-checked').find(".choseCheckbox").prop('checked', false);
				$(this).text("全选").data("status","choseall").removeClass("btn-gray").addClass("btn-blue");
			}else{
				$(this).parents(".dialog-chose-section").find(".choseCheckbox").each(function(index,el){
					var item = $(el);
					if ((!item.is(':checked'))&& (!item.parent().hasClass("hide"))) {
						//console.log("123");
						$(el).prop('checked', true).parent().addClass('item-checked');
					}
				});
				$(this).text("取消全选").data("status","cancelAll").removeClass("btn-blue").addClass("btn-gray");
			}
			
		});
	}
	//选择框radio
	function bindChoseRadioEvent(){
		$("body").on("click",".choseRadio",function(){
			if ($(this).is(":checked")) {
				var name = $(this).attr('name');
				$("[name='"+name+"']").parent().removeClass('item-checked');
				$(this).parent().addClass('item-checked');
			}
		});
	}
	//获取选中的单选框
	function getCheckedRadio(container,name){
		var checkedRadio = {};
		var radio = container.find("input[type=radio][name='"+name+"']:checked");
		checkedRadio.value = radio.val();
		checkedRadio.text = radio.parent().find('span').text();
		return checkedRadio;
	}
	//选中某个单选框
	function checkRadioItem(radios){
		for (var i = 0; i < radios.length; i++) {
			var radio = $(radios[i]);
			radio.prop("checked",true);
			var name = radio.attr("name");
			$("[name='"+name+"']").parent().removeClass('item-checked');
			radio.parent().addClass('item-checked');
		};
	}
	//取消全选
	function cancelChoseAll(container){
		container.find('.choseCheckbox').prop('checked', false).parent().removeClass('item-checked');
	}
	// 取消选中的checkbox
	function cancelCheckedCheckbox(container,ids){
		for (var i = 0; i < ids.length; i++) {
			container.find('input[type=checkbox][value="'+ids[i]+'"]').prop('checked', false).parent().removeClass('item-checked');
		};
	}
	// 取消选中的checkbox
	function cancelCheckedCheckbox2(container,ids){
		for (var i = 0; i < ids.length; i++) {
			container.find('input[type=checkbox][value="'+ids[i]+'"]').prop('checked', false).parent().removeClass('checkbox-icons-checked');
		};
	}
	//选中指定checkbox
	function checkedCheckbox(container,ids){
		for (var i = 0; i < ids.length; i++) {
			container.find('input[type=checkbox][value="'+ids[i]+'"]').prop('checked', true).parent().addClass('item-checked');
		};
	}
	//保存弹窗index
	function saveLayerIndex(index,save,cancel){
		$(save).attr("dialog-index",index);
		$(cancel).attr('dialog-index', index).click(function(){
			layer.close($(this).attr('dialog-index'));
		});
		$('.xubox_close').focus();
	}
	//获取某个容器下选中的checkbox的值，返回string数组
	function getCheckboxValue(container){
		var value = [];
		container.find('input[type=checkbox]').each(function(index, el) {
			if ($(el).is(':checked')) {
				var temp = {
					value: $(el).val(),
					icon:$(el).attr("data-icon"),
					text: $(el).parent().find('span').text()
				}
				value.push(temp);
			};
		});
		return value;
	}
	//绑定弹窗搜索事件
	function bindDialogScreenEvent(){
		//弹窗页面搜索
		$("body").on("click",".dialog-search",function(){
			var searchText = $(this).prev('.input-text-search').val();
			
			//取消全选
			var parent = $(this).parents(".dialog-chose-section");
			var itemlist = parent.find(".dialog-chose-item");
			//MIO.customUnit.cancelChoseAll(parent.find(".dialog-chose-list"));
			if (searchText.length == 0) {
				itemlist.removeClass("hide");
				return;
			};
			itemlist.removeClass("hide").each(function(index, el) {
				var text = $(el).text();
				var regExp = new RegExp(searchText, 'g');
				if(!regExp.test(text)){
					$(el).addClass('hide');
				}
			});
			$(this).parents(".dialog-title").find(".input-select").val("opstart").trigger("chosen:updated");
			layer.autoArea($(this).parents(".addnew-dialog-nopadding").find(".btn-save").attr("dialog-index"));
		});
		$("body").on("keypress",".dialog-search",function(e){
			if (e.which == 13) {
				return false;
			}
		});
		//下拉筛选
		$("body").on("change",".dialog-select-dpt",function(){
			var value = $(this).val();
			var parent = $(this).parents(".dialog-chose-section");
			var itemlist = parent.find(".dialog-chose-item");
			//MIO.customUnit.cancelChoseAll(parent.find(".dialog-chose-list"));
			if (value == "opstart") {return;};
			if(value == "showall"){
				itemlist.removeClass("hide");
			}else{
				itemlist.removeClass("hide");
				itemlist.each(function(index, el) {
					if (!($(el).attr("data-dptid")==value)) {
						$(el).addClass("hide");
					}	
				});
			}
			layer.autoArea($(this).parents(".addnew-dialog-nopadding").find(".btn-save").attr("dialog-index"));
		});
	}
	//创建日期+时间
	function createDateTime(){
		var myDate = new Date();
		var curYear=myDate.getFullYear();
		var beforYear=curYear-120;
		var nextYear=curYear+100;
		$('.datetimepicker').datetimepicker({
 			dateFormat:'yy-mm-dd',
 			timeFormat: "hh:mm",
 			changeYear:true,
 			changeMonth:true,
 			//minDate:new Date(),
 			yearRange: beforYear+":"+nextYear,
			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12']
 			
 		});
	}
	//创建日历
	function createCalendar(){
		var myDate = new Date();
		var curYear=myDate.getFullYear();
		var beforYear=curYear-120;
		var nextYear=curYear+100;
		$('.datepicker').datepicker({
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
 			changeMonth:true,
 			yearRange: beforYear+":"+nextYear,
			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12']
 			
 		});
	}
	function createDialogCalendar(){
 		var dialogCalendar = $(this).find('.datepicker');
 		// console.log(dialogCalendar);
 		if (dialogCalendar.length > 0) {
 			//日历
 			var myDate = new Date();
 			var curYear=myDate.getFullYear();
 			var beforYear=curYear-120;
 			var nextYear=curYear+100;
 			dialogCalendar.datepicker({
	 			dateFormat:'yy-mm-dd',
	 			changeYear:true,
	 			changeMonth:true,
	 			yearRange: beforYear+":"+nextYear,
				monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
				monthNames:['01','02','03','04','05','06','07','08','09','10','11','12']
	 			
	 		});
 		}
 	}
 	// 创建开始时间，结束时间一年内的日历
 	function createCalendarWidthRange(startDateTextBox,endDateTextBox){
 		startDateTextBox.datepicker({ 
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
	 		changeMonth:true,
 			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			onClose: function(dateText, inst) {
 				if (endDateTextBox.val() != '') {
 					var testStartDate = startDateTextBox.datetimepicker('getDate');
 					var testEndDate = endDateTextBox.datetimepicker('getDate');
 					if (testStartDate > testEndDate)
 						endDateTextBox.datetimepicker('setDate', testStartDate);
 				}
 				// else {
 				// 	endDateTextBox.val(dateText);
 				// }
 				startDateTextBox.trigger('dateChanged');
 			},
 			onSelect: function (selectedDateTime){
 				var startDate = startDateTextBox.datetimepicker('getDate');
 				var endMax = new Date(startDate.getFullYear()+1,startDate.getMonth(),startDate.getDate(),0,0,0);
 				endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
 				endDateTextBox.datetimepicker('option', 'maxDate', endMax );
 			}
 		});
 		endDateTextBox.datepicker({ 
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
 			changeMonth:true,
 			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			onClose: function(dateText, inst) {
 				if (startDateTextBox.val() != '') {
 					var testStartDate = startDateTextBox.datetimepicker('getDate');
 					var testEndDate = endDateTextBox.datetimepicker('getDate');
 					if (testStartDate > testEndDate)
 						startDateTextBox.datetimepicker('setDate', testEndDate);
 				}
 				// else {
 				// 	startDateTextBox.val(dateText);
 				// }
 				startDateTextBox.trigger('dateChanged');
 			},
 			onSelect: function (selectedDateTime){
 				var endDate = endDateTextBox.datetimepicker('getDate');
 				var endMin = new Date(endDate.getFullYear()-1,endDate.getMonth(),endDate.getDate(),0,0,0);
 				startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
 				startDateTextBox.datetimepicker('option', 'minDate', endMin );
 			}
 		});
 	}
 	// 创建开始时间，结束时间一年内的日历
 	function createCalendarWidthRangeDate(startDateTextBox,endDateTextBox){
 		startDateTextBox.datepicker({ 
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
 			changeMonth:true,
 			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			onClose: function(dateText, inst) {
 				if (endDateTextBox.val() != '') {
 					var testStartDate = startDateTextBox.datetimepicker('getDate');
 					var testEndDate = endDateTextBox.datetimepicker('getDate');
 					if (testStartDate > testEndDate)
 						endDateTextBox.datetimepicker('setDate', testStartDate);
 				}
 				// else {
 				// 	endDateTextBox.val(dateText);
 				// }
 			},
 			onSelect: function (selectedDateTime){
 				endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
 			}
 		});
 		endDateTextBox.datepicker({ 
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
 			changeMonth:true,
 			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			onClose: function(dateText, inst) {
 				if (startDateTextBox.val() != '') {
 					var testStartDate = startDateTextBox.datetimepicker('getDate');
 					var testEndDate = endDateTextBox.datetimepicker('getDate');
 					if (testStartDate > testEndDate)
 						startDateTextBox.datetimepicker('setDate', testEndDate);
 				}
 				// else {
 				// 	startDateTextBox.val(dateText);
 				// }
 			},
 			onSelect: function (selectedDateTime){
 				startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
 			}
 		});
 	}
 	// 创建开始时间，结束时间带时间的日历
 	function createCalendarWidthRangeTime(startDateTextBox,endDateTextBox){
 		startDateTextBox.datetimepicker({ 
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
 			changeMonth:true,
 			//minDate:new Date(),
 			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			onClose: function(dateText, inst) {
 				if (endDateTextBox.val() != '' && startDateTextBox.val() != '') {
 					var testStartDate = startDateTextBox.datetimepicker('getDate');
 					var testEndDate = endDateTextBox.datetimepicker('getDate');
 					if (testStartDate > testEndDate){
 						//endDateTextBox.datetimepicker('setDate', testStartDate);
 						tips("活动开始时间不能大于活动结束时间！",0);
 					}
 				}
 				// else {
 				// 	endDateTextBox.val(dateText);
 				// }
 			},
 			onSelect: function (selectedDateTime){
 				endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
 			}
 		});
 		endDateTextBox.datetimepicker({ 
 			dateFormat:'yy-mm-dd',
 			changeYear:true,
 			changeMonth:true,
 			//minDate:new Date(),
 			monthNamesShort:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			monthNames:['01','02','03','04','05','06','07','08','09','10','11','12'],
 			onClose: function(dateText, inst) {
 				if (startDateTextBox.val() != '' && endDateTextBox.val() != '' ) {
 					var testStartDate = startDateTextBox.datetimepicker('getDate');
 					var testEndDate = endDateTextBox.datetimepicker('getDate');
 					if (testStartDate > testEndDate){
 						//startDateTextBox.datetimepicker('setDate', testEndDate);
 						tips("活动开始时间不能大于活动结束时间！",0);
 					}
 				}
 				// else {
 				// 	startDateTextBox.val(dateText);
 				// }
 			},
 			onSelect: function (selectedDateTime){
 				startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
 			}
 		});
 	}
	return {
		cutomCheckbox: cutomCheckbox,
		cutomRadio: cutomRadio,
		checkRadio: checkRadio,
		cancelCheckRadio: cancelCheckRadio,
		checkAll: checkAll,
		changeTheTab: changeTheTab,
		getCheckedbox: getCheckedbox,
		createScrollBar: createScrollBar,
		createScrollBarX: createScrollBarX,
		createChosenList: createChosenList,
		createChosenListAuto:createChosenListAuto,
		bindChoseCheckboxEvent: bindChoseCheckboxEvent,
		saveLayerIndex: saveLayerIndex,
		getCheckboxValue: getCheckboxValue,
		cancelChoseAll: cancelChoseAll,
		bindDialogScreenEvent: bindDialogScreenEvent,
		bindChoseRadioEvent:bindChoseRadioEvent,
		checkedCheckbox:checkedCheckbox,
		createDateTime: createDateTime,
		createCalendar: createCalendar,
		createDialogCalendar: createDialogCalendar,
		getCheckedRadio: getCheckedRadio,
		checkRadioItem: checkRadioItem,
		cancelCheckedCheckbox:cancelCheckedCheckbox,
		cancelCheckedCheckbox2:cancelCheckedCheckbox2,
		createCalendarWidthRange:createCalendarWidthRange,
		createCalendarWidthRangeTime:createCalendarWidthRangeTime,
		createCalendarWidthRangeDate:createCalendarWidthRangeDate
	};
})();