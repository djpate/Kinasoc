function displayError(msg){
	jQuery('body').showMessage({
		delayTime:	2000,
		autoClose:	true,
		className:	'fail',
		'thisMessage': [msg]
	});
}

function is_int(input){
	return !isNaN(input)&&parseInt(input)==input;
}


$(document).ready(function(){
   $('form').uniform();
});


