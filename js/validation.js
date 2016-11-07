/*
 * author luke@ioe9.com
 * 验证类
 */
function Validator(){
	this.initialize();
}

Validator.prototype = {
    initialize : function() {
        this.error = '验证失败。';
    },
    //测试
    test : function(elm) {
    	var obj = Validator.methods;
    	elm.siblings('.validation-advice').remove();
    	for(var m in obj){
    		if (elm.hasClass(obj[m][0])) {
    			if (obj[m][2](elm.val())) {
    				//验证通过
    			} else {
    				//验证不通过
    				var adviceHtml = '<div class="validation-advice" id="advice-' + obj[m][0] + '-' + elm.id +'" style="display:block">' + obj[m][1] + '</div>'
    				elm.after(adviceHtml);
    				break;
    			}
    			
    		}
	        
      	}
    }
    
}
function $F(elm) {
	return $('#'+elm).val();
}
function $IsEmpty(v) {
 	return  (v == '' || (v == null) || (v.length == 0) || /^\s+$/.test(v));
}
Validator.methods = [
	['required-entry', '必填项', function(v) {
            return !$IsEmpty(v);
        }
    ]
];
function Validation(form, options) {
	this.initialize(form, options);
}
Validation.defaultOptions = {
    containerClassName: '.input-box',
};

Validation.prototype = {
    initialize : function(form, options){
        this.form = $('#'+form);
        if (!this.form) {
            return;
        }
    },
    onChange : function (ev) {
        Validation.isOnChange = false;
    },
    onSubmit :  function(ev){
        if(!this.validate()) {
        	return false;
        }
    },
    validate : function() {
        var result = false;
        try {
        	//遍历元素
        	this.form.find('input,select,textarea,file').each(function(index,element){
        		var $this = $(this);
        		//开始验证
        		var v = new Validator();
        		v.test($this);
        		
        	})

        	if (this.form.find('.validation-advice').length==0) {
        		result = true;
        	}
        	
        } catch (e) {
        	console.log(e);
        }
        return result;
    },
    reset : function() {
        //重置
    },
    
    isVisible : function(elm) {
    	//元素是否可见
        return true;
    },
    createAdvice : function(name, elm, useTitle, customError) {
       //显示错误提示
    },
    get : function(name) {
        return  Validation.methods[name] ? Validation.methods[name] : null;
    },
    addAllThese : function(validators) {
    	//加入验证器
        var nv = {};
        return;
    }
}

function removeDelimiters (v) {
    v = v.replace(/\s/g, '');
    v = v.replace(/\-/g, '');
    return v;
}
function parseNumber(v)
{
    if (typeof v != 'string') {
        return parseFloat(v);
    }

    var isDot  = v.indexOf('.');
    var isComa = v.indexOf(',');

    if (isDot != -1 && isComa != -1) {
        if (isComa > isDot) {
            v = v.replace('.', '').replace(',', '.');
        }
        else {
            v = v.replace(',', '');
        }
    }
    else if (isComa != -1) {
        v = v.replace(',', '.');
    }

    return parseFloat(v);
}

