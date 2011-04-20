function displayError(msg){
	jQuery('body').showMessage({
		delayTime:	2000,
		autoClose:	true,
		className:	'fail',
		'thisMessage': [msg]
	});
}

function displayConfirmation(msg){
	jQuery('body').showMessage({
		delayTime:	2000,
		autoClose:	true,
		className:	'success',
		'thisMessage': [msg]
	});
}

function is_int(input){
	return !isNaN(input)&&parseInt(input)==input;
}

function split( val ) {
	return val.split( /,\s*/ );
}

function extractLast( term ) {
	return split( term ).pop();
}


$(document).ready(function(){
   $('form').uniform();
   
   jQuery.validator.addMethod("validlogin", function(value, element) {
	return this.optional(element) || /^([a-zA-Z0-9]+)$/.test(value);
	}, "Vous ne pouvez utilisez que des lettres ou des chiffres."); 
   
});

var RecaptchaOptions = {
    theme : 'white',
    lang : 'fr'
 };



