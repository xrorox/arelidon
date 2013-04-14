function check_login(login)
{
	var url;
	url = 'page/form_verif/verifform.php?verif=login&login='+login;
	loadInDiv(url,'check-login') ;
	
	var div = document.getElementById('check-login');
	div.style.display = 'block';
}

function check_password(password)
{
	var url;
	url = 'page/form_verif/verifform.php?verif=password&password='+password;
	loadInDiv(url,'check-password') ;
	
	var div = document.getElementById('check-password');
	div.style.display = 'block';
}

function check_email(mail)
{
	var url;
	url = 'page/form_verif/verifform.php?verif=mail&mail='+mail;
	loadInDiv(url,'check-email') ;	
	
	var div = document.getElementById('check-email');
	div.style.display = 'block';
}

function check_classe(classe)
{
	var url;
	url = 'page/form_verif/verifform.php?verif=classe&classe='+classe;
	loadInDiv(url,'check-classe') ;
	
	var div = document.getElementById('check-classe');
	div.style.display = 'block';
}

function check_sponsor(sponsor)
{
	var url;
	url = 'page/form_verif/verifform.php?verif=sponsor&sponsor='+sponsor;
	loadInDiv(url,'check-sponsor') ;

	var div = document.getElementById('check-sponsor');
	div.style.display = 'block';
}



function check_form()
{
	if(document.getElementById('form_valid_1'))
	{
		var form_valid_1 = document.getElementById('form_valid_1').innerHTML;
	}else{
		var form_valid_1 = 0;
	}
	
	if(document.getElementById('form_valid_2'))
	{
		var form_valid_2 = document.getElementById('form_valid_2').innerHTML;
	}else{
		var form_valid_2 = 0;
	}
	
	if(document.getElementById('form_valid_3'))
	{
		var form_valid_3 = document.getElementById('form_valid_3').innerHTML;
	}else{
		var form_valid_3 = 0;
	}
	
	if(document.getElementById('form_valid_4'))
	{
		var form_valid_4 = document.getElementById('form_valid_4').innerHTML;
	}else{
		var form_valid_4 = 0;
	}

	
	if(form_valid_1 == 0)
	{
		alert('pseudo incorrect');
	}else{
		if(form_valid_2 == 0)
		{
			alert('email incorrect');
		}else{
			if(form_valid_3 == 0)
			{
				alert('mot de passe incorrect');
			}else{
				if(form_valid_4 == 0)
				{
					alert('Parrain incorrect');
				}else{
					return true;
				}
			}
		}
	}
	
}

