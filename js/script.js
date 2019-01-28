function funcBefore() {
	$("#registerLabel").text("Отправка запроса");
}

function funcSuccess(data) {
	$("#registerLabel").text("Запрос выполнен");
	alert('Запрос выполнен!'+data);
}

$(document).ready (function() {
	

	

	$.ajax({
		url: "controllers/update.php",
		method: "POST",
		dataType: "html",
		data: {token: Cookies.get('token')},
		success: function(data){

			var selecter = JSON.parse(data);
			if(selecter['sex'] == "Женщина")
				$("#female").attr('selected','');

			if(selecter['local'] == 'Иногородний')
				$("#not_native").attr('selected','');
		}
	});

	$("#update_button").bind("click", function() {
		var form = {
			'first_name':$("input[name='first_name']").val(),
			'last_name':$("input[name='last_name']").val(),
			'group_id':$("input[name='group_id']").val(),
			'rating':$("input[name='rating']").val(),
			'email':$("input[name='email']").val(),
			'birthday':$("input[name='birthday']").val(),
			'sex':$("select[name='sex']").val(),
			'local':$("select[name='local']").val(),
			'token': Cookies.get('token')

		};
		$.ajax({
			url: "controllers/update.php",
			method: "POST",
			dataType: "html",
			data: { formData: form},
			success: function(res) {
				var response = JSON.parse(res);
				if(response['valid'] == 0)
				{
					var errors = response['errors'];
					$('#errors').empty();
					for(var error in errors)
					$('#errors').append('<div class="alert alert-danger" role="alert">'+errors[error]+'</div>');
				} else {
					$('#errors').empty();
					$('#errors').append('<div class="alert alert-success" role="alert">Информация успешно обновлена</div>');
				}
				console.log(response);
				
				
			}
		});
	});
});