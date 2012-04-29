# Using asynchronous method to load facebook javascript adk
window.fbAsyncInit = ->
	FB.init
		appId      : APP_ID
		channelUrl : "#{SITE_URL}/public/channel.html"
		cookie     : true
		status     : true
		xfbml      : true
		oauth      : true

# Append sdk to script tag content
((d) ->
	id  = "facebook-jssdk"
	ref = d.getElementsByTagName("script")[0]

	return if d.getElementById(id)

	js = d.createElement("script")
	js.id = id
	js.async = true
	js.src = "//connect.facebook.net/en_US/all.js"

	ref.parentNode.insertBefore js, ref
) document

#
share = (callback) ->
	selfGain          = $("#gain")
	originGainContent = selfGain.html()

	selfGain.html("等待中");

	FB.ui
		method     : 'feed'
		name       : feedInfo.name
		link       : feedInfo.link
		picture    : feedInfo.picture
		caption    : feedInfo.caption
		description: feedInfo.description
	, (response) ->
		if response and response.post_id
			FB.api '/me', (responseMe) ->
				selfGain.html("已分享")

				userId	 = responseMe.id
				username = escape(responseMe.name)
				postId	 = response.post_id

				window.location = "#{SITE_URL}/index/gain_key/#{userId}/#{username}/#{postId}"
		else
			alert "請先分享"

			selfGain.html(originGainContent)

# Work flow control when DOM ready
$ ->
	$share= $('span #share')

	# Default action when first click on Gain button
	$('#gain').click ->
		alert('請先分享')

	# Require user to login facebook first and ask they grant permission
	# - Ref: https://developers.facebook.com/docs/authentication/permissions/
	$('#auth').click ->
		self          = $(this);
		originContent = self.html()

		self.html("等待中")

		FB.login (response) ->
			if response.authResponse
				self.html("已完成")
			else
				alert "請先同意授權"

				self.html(originContent)
		, scope: ''

	# Post share message to user wall
	$('#share').click ->
		FB.getLoginStatus (response) ->
			if response.status is 'connected'
				share()
			else
				alert "請先同意授權"

