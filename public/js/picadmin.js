
var pic_click = function(name){
	//console.write('error');
	var query = '#' + name + ' input';
	var obj = $(query);
	var frame = $('#' +  name).parent();
	if(!obj.prop("checked")){
		obj.prop("checked", true);
		obj.attr("checked", "checked");
		frame.css('border-bottom', 'solid 5px red');
	}
	else{
		obj.prop("checked", false);
		obj.removeAttr("checked");
		frame.css('border-bottom', 'solid 5px 68507E');
	}
}

function download(){
	var ids = [];
	$('input[checked="checked"]').each(function(){
		ids.push($(this).attr('id'));
	});
	if (ids.length > 0){
		location.href = "download?id=" + ids.join("-");
	}
	else {
		alert('no image selected.');
	}
}