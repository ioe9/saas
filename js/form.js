/***
 * @author luke@ioe9.com
 * 表单组件
 */

function mioForm(formId, validationUrl){
	this.initialize(formId, validationUrl)
};

mioForm.prototype = {
    initialize : function(formId, validationUrl){
        this.formId = formId;
        this.validationUrl = validationUrl;
        this.submitUrl = false;

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
        location.href = BASE_URL;
    },

    _submit : function(){
        var $form = $('#'+this.formId);
        if(this.submitUrl){
            $form.action = this.submitUrl;
        }
        $form.submit();
    }
}