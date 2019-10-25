var App = {
	init: () => {
		TweenMax.to(document.getElementById("loginForm"),
				.4, {opacity: 1, transform: "scale(1)"})
		setTimeout( () => {
			$('input').css('opacity', '1')
			TweenMax.to(document.getElementsByTagName("input"),
				.5, {transform: "scale(1)"})
			$('#loginHeader').css('opacity', '1')
			TweenMax.to(document.getElementById("loginHeader"),
				.5, {transform: "scale(1)"})
			$('a').css('opacity', '1')
			TweenMax.to(document.getElementsByTagName("a"),
				.5, {transform: "scale(1)"})
		}, 400)
		setTimeout( () => {
			TweenMax.to(document.getElementsByTagName("label"),
				.5, {opacity: "1"})
		}, 700)

		$('label').each( (index, el) => {
			$('#'+$(el).attr('to')).on('focus', () => {
				TweenMax.to($(el),
				.5, {transform: "translateY(-1.4vw)", fontSize: "1vw"})
			})
			$('#'+$(el).attr('to')).on('focusout', () => {
				if($('#'+$(el).attr('to')).val().length == 0)
					TweenMax.to($(el),
					.5, {transform: "translateY(0.6vw)", fontSize: "2vw"})
			})
		})
	}
}
setTimeout(() => App.init(), 500)