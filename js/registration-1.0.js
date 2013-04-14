function selectClass(id)
{
	var old = document.getElementById('selected-class').innerHTML;
	
	if(old != 0)
	{
		$("#class-div-"+old).removeClass("div-with-cadre-selected");
	}
	
	$("#class-div-"+id).addClass("div-with-cadre-selected");
	document.getElementById('selected-class').innerHTML = id;
	
	if(document.getElementById('selected-sex').innerHTML == 0)
		selectSex(1);

	checkSexForClass(id);
	refreshPicture();
	refreshInfo();
}

function selectSex(number)
{
	var old = document.getElementById('selected-sex').innerHTML;
	
	if(old != 0)
	{
		$("#sex-div-"+old).removeClass("div-with-cadre-selected");
	}	
	
	$("#sex-div-"+number).addClass("div-with-cadre-selected");
	document.getElementById('selected-sex').innerHTML = number;
	
	refreshPicture();
}

function selectFaction(id)
{
	var old = document.getElementById('selected-faction').innerHTML;
	
	if(old != 0)
	{
		$("#faction-"+old).removeClass("selected-faction");
	}	
	
	$("#faction-"+id).addClass("selected-faction");
	document.getElementById('selected-faction').innerHTML = id;
	
	refreshInfo();
}

function refreshPicture()
{
	HTTPTargetCall("page/new_char_form/picture.php?class="+document.getElementById('selected-class').innerHTML+"&sex="+document.getElementById('selected-sex').innerHTML,"picture-container");
}

function refreshInfo()
{
	if(document.getElementById('selected-class').innerHTML != 0)
	{
		HTTPTargetCall("page/new_char_form/infoClass.php?class="+document.getElementById('selected-class').innerHTML,'class-info-container');
	}
	
	if(document.getElementById('selected-faction').innerHTML != 0)
	{
		HTTPTargetCall("page/new_char_form/infoFaction.php?faction="+document.getElementById('selected-faction').innerHTML,'faction-info-container');
	}
}

function checkSexForClass(class_id)
{
	
	if(class_id == 5 || class_id == 8)
	{
		$("#sex-div-1").removeClass("hide");
		$("#sex-div-2").addClass("hide");
		// Pas de sexe F
		if(document.getElementById('selected-sex').innerHTML == 2)
			selectSex(1);
		
	}else if(class_id == 6)
	{
		// Pas de sexe H
		$("#sex-div-1").addClass("hide");
		$("#sex-div-2").removeClass("hide");
		
		if(document.getElementById('selected-sex').innerHTML == 1)
			selectSex(2);
	}else{
		$("#sex-div-1").removeClass("hide");
		$("#sex-div-2").removeClass("hide");
	}	
}

function checkCharNameAvailable(charName)
{
	HTTPTargetCall("page/new_char_form/nameVerif.php?name="+charName,"char-name-available","",false);
}

function postChar()
{
	var class_id = document.getElementById('selected-class').innerHTML;
	var sex_id = document.getElementById('selected-sex').innerHTML;
	var faction_id = document.getElementById('selected-faction').innerHTML;
	var char_name = document.getElementById('char-name').value;
	
	var url = "page/new_char_form/createChar.php?char_name="+char_name+"&classe="+class_id+"&sex="+sex_id+"&faction="+faction_id;
	HTTPTargetCall(url,"post_container_response","",false);

	if(document.getElementById('post_container_response').innerHTML == "V")
		window.location.href = "index.php?page=selectchar";
	else if(document.getElementById('post_container_response').innerHTML == "X")
		alert("Une erreur est survenue veuillez vérifier que tous les champs sont correctement remplis");
}

function checkCreateCharForm()
{
	checkCharNameAvailable(document.getElementById('char-name').value);
	
	if(document.getElementById('selected-class').innerHTML != 0)
	{
		if(document.getElementById('selected-faction').innerHTML != 0)
		{
			if(document.getElementById('char-name').value != 'Nom du personnage' 
				&& document.getElementById('char-name').value != ''
				&& document.getElementById('char-name').value != ' ')
			{
				if(document.getElementById('char-name-available').innerHTML == 'V')
				{
					postChar();
				}else{
					alert("Le nom est déjà pris");
				}
			}else{
				alert("Vous devez entrer un nom");
			}
		}else{
			alert("Vous devez sélectionner une faction");
		}
	}else{
		alert("Vous devez sélectionner une classe");
	}
}

