(function() {
  $(function() {
    $(".navbar-fixed-top ul.nav li a").each(function() {
      if (window.location.toString().indexOf($(this).prop('href')) !== -1) {
        return $(this).parent().addClass('active');
      } else {
        return $(this).parent().removeClass('active');
      }
    });
    $(".sidebar-nav ul.nav li a").each(function() {
      if (window.location.toString() === $(this).prop('href')) {
        return $(this).parent().addClass('active');
      } else {
        return $(this).parent().removeClass('active');
      }
    });
    return $("a.delete-confirm-client-list").click(function() {
      var clientName;
      clientName = $(this).parent().parent().find("td:eq(1)").text();
      return window.confirm("確定要刪除 " + clientName + " 這個金鑰嗎?");
    });
  });
}).call(this);
