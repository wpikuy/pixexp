function login(){
	var pw = $("#password").val();
	var token = $("#token").attr('value');
	$.ajax({
		type: 'POST',
		url: './login' ,
		data: {
			_token : token,
			pw : pw
		} ,
		success: function (data){
			console.log(data);
			if (data == 'done'){
				location.href = 'request?page=1';
			}
			else{
				$('#request').html('Incorrect password');
			}
		} ,
		error: function(){
			alert('unable to login.');
		}
	});
}