//Salve barbari!

var Pages = {
	page: 1, //page = one module, many modules are form
	//function staring after site loaded
	init: () => {
		//nav buttons on clicks
		$('.next').on('click', () => Pages.next())
		$('.prev').on('click', () => Pages.prev())
		//show first page
		TweenMax.to(document.getElementById("loginForm"),
				.4, {opacity: 1, transform: "scale(1)"})	
		Pages.show(1)
		//add tag button onclick
		$('#tagAddBtn').on('click', () => {
			if($('#tagInput').val().length >= 1){
				//append new tag
				$('#tags').append(`<label class="tag">
					<input 
					type="checkbox" 
					name="tags[]" 
					class="checktag"
					value="${$('#tagInput').val()}"
					onclick='Pages.check()'
					checked>
					${$('#tagInput').val()}
				</label>`);
				//check if every checkbox is checked
				Pages.check()
				//clear and focus 
				$('#tagInput').val("")
				$('#tagInput').focus()
			}
		})
	},
	//int arg is number of page 
	//please dont use this method directly
	//please use next() and prev() instead
	//only for debuging
	show: (arg) => {
		//hide all visible pages
		TweenMax.to($(`.subPage`), .4, {opacity: 0, transform: "scale(0.6)"})
		//after anim ended
		setTimeout(() => {
			//set all paged to invisible
			$(`.subPage`).css('display', 'none')
			//the ONE PAGE set to visible and anim
			$(`#sub${arg}`).css('display', 'flex')
			TweenMax.to($(`#sub${arg}`), .4, {opacity: 1, transform: "scale(1)"})
		}, 450)
	},
	//page nav methods
	next: () => {
		Pages.page += 1
		Pages.show(Pages.page)
	},
	prev: () => {
		Pages.page -= 1
		Pages.show(Pages.page)
	},
	check: () => {
		//if checkbox is unchecked hide label
		$('.tag').each( (index, el) => {
			if(!$(el).children()[0].checked)
				$(el).css('display', 'none')
		})
	},
	addTag: () => {

	}
}
//Pages initialization
setTimeout(() => Pages.init(), 500)