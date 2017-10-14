function handleAjaxLink(e) {

	e.preventDefault();

	var
		$link = $(e.target),
		callUrl = $link.attr('href'),
		formId = $link.data('formId'),
		onDone = $link.data('onDone'),
		onFail = $link.data('onFail'),
		onAlways = $link.data('onAlways'),
		ajaxRequest;


	ajaxRequest = $.ajax({
		type: "post",
		dataType: 'json',
		url: callUrl,
		data: (typeof formId === "string" ? $('#' + formId).serializeArray() : null)
	});

	// Assign done handler
	if (typeof onDone === "string" && ajaxCallbacks.hasOwnProperty(onDone)) {
		ajaxRequest.done(ajaxCallbacks[onDone]);
	}

	// Assign fail handler
	if (typeof onFail === "string" && ajaxCallbacks.hasOwnProperty(onFail)) {
		ajaxRequest.fail(ajaxCallbacks[onFail]);
	}

	// Assign always handler
	if (typeof onAlways === "string" && ajaxCallbacks.hasOwnProperty(onAlways)) {
		ajaxRequest.always(ajaxCallbacks[onAlways]);
	}

}

var ajaxCallbacks = {
	'randDone': function (response) {
		console.dir(response);
		$('#rand_result').html(response.body);
	},

	'linkFormDone': function (response) {
		$('#ajax_result_02').html(response.body);
	},

        'actionDone': function (response) {
            if(response.status!=-1){
                $('#status_' + response.id).html(response.status);
            }else{
                alert("Can't set status below current");
            }
        }

}
