function displayError(msg){
	jQuery('body').showMessage({
		delayTime:	2000,
		autoClose:	true,
		className:	'fail',
		'thisMessage': [msg]
	});
}

$(document).ready(function(){
   $('form').uniform();
});


