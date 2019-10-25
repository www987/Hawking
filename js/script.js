var Menu = {
	titles: [
		"Kim jesteśmy",
		"Niepełnosprawni",
		"Uchodźcy",
		"Praca",
		"Autorzy"
	],
	init(){
		$('.content').fsScroll({
			loop: true,
		})
		$('.page.vertical li').each( (index, el) => 
			$(el).append(`<p>${Menu.titles[index].replace(" ", '&nbsp;')}</p>`)
		)
	}
}

Menu.init();