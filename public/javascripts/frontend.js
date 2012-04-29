(function() {
  var share;
  window.fbAsyncInit = function() {
    return FB.init({
      appId: APP_ID,
      channelUrl: "" + SITE_URL + "/public/channel.html",
      cookie: true,
      status: true,
      xfbml: true,
      oauth: true
    });
  };
  (function(d) {
    var id, js, ref;
    id = "facebook-jssdk";
    ref = d.getElementsByTagName("script")[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement("script");
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    return ref.parentNode.insertBefore(js, ref);
  })(document);
  share = function(callback) {
    var originGainContent, selfGain;
    selfGain = $("#gain");
    originGainContent = selfGain.html();
    selfGain.html("等待中");
    return FB.ui({
      method: 'feed',
      name: feedInfo.name,
      link: feedInfo.link,
      picture: feedInfo.picture,
      caption: feedInfo.caption,
      description: feedInfo.description
    }, function(response) {
      if (response && response.post_id) {
        return FB.api('/me', function(responseMe) {
          var postId, userId, username;
          selfGain.html("已分享");
          userId = responseMe.id;
          username = escape(responseMe.name);
          postId = response.post_id;
          return window.location = "" + SITE_URL + "/index/gain_key/" + userId + "/" + username + "/" + postId;
        });
      } else {
        alert("請先分享");
        return selfGain.html(originGainContent);
      }
    });
  };
  $(function() {
    var $share;
    $share = $('span #share');
    $('#gain').click(function() {
      return alert('請先分享');
    });
    $('#auth').click(function() {
      var originContent, self;
      self = $(this);
      originContent = self.html();
      self.html("等待中");
      return FB.login(function(response) {
        if (response.authResponse) {
          return self.html("已完成");
        } else {
          alert("請先同意授權");
          return self.html(originContent);
        }
      }, {
        scope: ''
      });
    });
    return $('#share').click(function() {
      return FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
          return share();
        } else {
          return alert("請先同意授權");
        }
      });
    });
  });
}).call(this);
