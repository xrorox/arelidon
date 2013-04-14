function switchScreens(switcher)
{
	var current_page = document.getElementById('current_page').value;
	current_page = parseInt(current_page);
	var new_page = current_page + switcher;
	if(new_page == 0)
		new_page = 1;
	if(new_page > document.getElementById('max_page').value)
		new_page = document.getElementById('max_page').value;
	
	if(new_page != current_page)
	{
		document.getElementById('current_page').value = new_page;
		
		var div_current_page = '#'+current_page;
		$(div_current_page).hide();
		
		var div_new_page = '#'+new_page;
		$(div_new_page).show();
		
	}
}