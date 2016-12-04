/***
 * @author luke@ioe9.com
 * 表单组件
 */

function mioForm(formId, validationUrl, options){
	this.initialize(formId, validationUrl, options)
};

mioForm.prototype = {
    initialize : function(formId, validationUrl, options){
        this.formId = formId;
        this.validationUrl = validationUrl;
        this.submitUrl = false;

		this.submitCallback = (options && options.submitCallback) ? options.submitCallback : false;
        if($('#'+this.formId)){
            this.validator  = new Validation(this.formId);
        }
        this.errorSections = {};
    },
    validate : function(){
        if(this.validator && this.validator.validate()){
            if(this.validationUrl){
                this._validate();
            }
            return true;
        }
        return false;
    },
    submit : function(url){
        this.errorSections = {};
        this.canShowError = true;
        this.submitUrl = url;
        if(this.validator && this.validator.validate()){
            if(this.validationUrl){
                this._validate();
            }
            else{
                this._submit();
            }
            return true;
        }
        return false;
    },
	//异步验证
    _validate : function(){
    	$.ajax({
    		type: "POST",
    		url: this.validationUrl,
    		data: $('#'+this.formId).serialize(),
    		dataType: "JSON",
    		success: function(response) {
    			this._processValidationResult(response);
    		},
    		error: function(response) {
    			this._processFailure(response);
    		}
    	})
    },

	//验证返回成功
    _processValidationResult : function(response){
        if(response.error){
            if($('#messages')){
                $('#messages').innerHTML = response.message;
            }
        }
        else{
            this._submit();
        }
    },
	
	//验证请求失败
    _processFailure : function(response){
    	console.log(response);
        //location.href = BASE_URL;
    },

    _submit : function(){
    	$this = this;
        var $form = $('#'+this.formId);
        //判断是否Ajax提交
        if ($form.hasClass('ajax-submit')) {
        	
        	$.ajax({
	    		type: "POST",
	    		url: $('#'+$this.formId).attr('action'),
	    		data: $('#'+$this.formId).serialize(),
	    		dataType: "JSON",
	    		success: function(response) {

	    			if($this.submitCallback){
	    				$this.submitCallback(response);
    				}
	    		},
	    		error: function(response) {
	    			$this._processFailure(response);
	    		}
	    	})
        } else {
        	if(this.submitUrl){
	            $form.action = $this.submitUrl;
	        }
	        $form.submit();
        }
        
    }
}

//表单元素依赖关系
function FormElementDependenceController(elementsMap){
	this.initialize(elementsMap)
};

FormElementDependenceController.prototype = {
    initialize : function(elementsMap){
        for (var idTo in elementsMap) {
            for (var idFrom in elementsMap[idTo]) {
                if ($('#'+idFrom).length) {
                   var v = $('#'+idFrom).val();
                   if (v!=elementsMap[idTo][idFrom]) {
                   		$('#'+idTo).parent().parent().hide();
                   }
                   $('#'+idFrom).change(function(){
                   	   var v = $(this).val();
	                   if (v!=elementsMap[idTo][idFrom]) {
	                   		$('#'+idTo).parent().parent().hide();
	                   } else {
	                   		$('#'+idTo).parent().parent().show();
	                   }
                   })
                }
            }
        }
    }
}
