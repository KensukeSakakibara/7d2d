$(function(){
	setInterval(refreshLog, 1000)

	function refreshLog() {
		$.ajax({
			url:'/serverctl.php?type=log',
			type:'GET',
		})
		.done((data) => {
			var jsonData = JSON.parse(data);
			var logStr = jsonData.reverse().join("\n");
			$('#log').html(logStr);
        })
	}
	
	$("#restart_btn").on('click', function(){
		if(window.confirm("サーバを再起動します。\nよろしいですか？")) {
			$.ajax({
				url:'/serverctl.php?type=restart',
				type:'GET',
			})
			.done((data) => {
				var jsonData = JSON.parse(data);
				if (jsonData['status'] == 1) {
					alert("サーバを再起動しました！\n少し待ってからログインし直してください。");
				} else {
					alert("サーバの再起動に失敗しました。\nサーバ管理者へお問い合わせください。");
				}
	        })
		}
	});
});
