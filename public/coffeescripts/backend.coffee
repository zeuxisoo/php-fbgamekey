$ ->
	# Add active style when page is browsering
	$(".navbar-fixed-top ul.nav li a").each ->
		if window.location.toString().indexOf($(this).prop('href')) isnt -1
			$(this).parent().addClass('active')
		else
			$(this).parent().removeClass('active')

	$(".sidebar-nav ul.nav li a").each ->
		if window.location.toString() is $(this).prop('href')
			$(this).parent().addClass('active')
		else
			$(this).parent().removeClass('active')

	$("a.delete-confirm-client-list").click ->
		clientName = $(this).parent().parent().find("td:eq(1)").text()

		window.confirm "確定要刪除 #{clientName} 這個金鑰嗎?"