var Portal = {
	change: (elem, tag) => {
		if($(elem).attr('class').includes('active')){
			$(elem).removeClass('active')
			$(elem).html('Pokaż')
		}
		else {
			$(elem).addClass('active')
			$(elem).html('Ukryj')
		}

		$('.port').each( (index, el) => {
			$(el).css('display', 'none')
		})

		$('.port').each( (index, el) => {
			$('.active').each( (index2, e) => {
				if($(el).attr("tags").includes($(e).attr("tag")))
					$(el).css('display', 'block')
			})
		})
	}
}