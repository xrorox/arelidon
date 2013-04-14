function changeMap()
{
	var num = document.getElementById('changemap').value;
	var url = "gestion/page.php?category=2&map="+num;
	//document.getElementById(ModuleGestionMapContainer).innerHTML = '';
	HTTPTargetCall(url,'tdbodygame');
	

}

function addTelep(idmap)
{
	var url = "gestion/page.php?category=2&action=add&type=insert_telep&btelep=1";
	HTTPPostCall(url,'form_telep','maj');
	refreshMapEdition(idmap,'cases_bloquees');
}

function deleteTeleporteur(idmap,abs,ord)
{
	var url="gestion/page.php?category=2&action=deleteTelep&map="+idmap+"&abs="+abs+"&ord="+ord;
	var target = "modif_telep_"+idtel;
	HTTPTargetCall(url,target);
	refreshMapEdition(idmap,'cases_bloquees');
}

function addInteraction(idmap)
{
	var url = "gestion/page.php?category=2&action=add&type=valid_insert_interaction&btelep=1";
	HTTPPostCall(url,'form_interaction','maj');
	refreshMapEdition(idmap);
}

function deleteInteraction(ididinteraction,idmap)
{
	var url="gestion/page.php?category=2&action=deleteInteraction&ididinteraction="+ididinteraction;
	var target = "modif_interaction_"+ididinteraction;
	HTTPTargetCall(url,target);
	refreshMapEdition(idmap);
}

function addMonster(idmap)
{
	var url = "gestion/page.php?category=2&action=add&type=insert_monster&idmap="+idmap;
	HTTPPostCall(url,'form_monster','maj');
}

function modifMonster(id)
{
	var url = "gestion/page.php?category=5&action=modif&idmonster="+id;
	HTTPTargetCall(url,'modifMonster');
}

function modifPnj(id)
{
	var url = "gestion/page.php?category=16&action=modif&idpnj="+id;
	HTTPTargetCall(url,'modifpnj');
}

function duplicPnj(id)
{
	var url = "gestion/page.php?category=16&duplic=1&idpnj="+id;
	HTTPTargetCall(url,'modifpnj');
}

function modifItem(id)
{
	var url = "gestion/page.php?category=11&action=modif&iditem="+id;
	HTTPTargetCall(url,'modifItem');
}

function modifTresor(id)
{
	var url = "gestion/page.php?category=13&action=modif&tresor_id="+id;
	HTTPTargetCall(url,'modifTresor');
}

function duplicTresor(id)
{
	var url = "gestion/page.php?category=13&action=duplic&tresor_id="+id;
	HTTPTargetCall(url,'modifTresor');
	loadMenu('gestion/page.php?category=13');
}

function deleteTresor(id)
{
	var url = "gestion/page.php?category=13&action=delete&tresor_id="+id;
	HTTPTargetCall(url,'modifTresor');
	loadMenu('gestion/page.php?category=13');
}

function refreshMapEdition(idmap,type)
{
	if(type == '')
		type = 'cases_bloquees';
		
	var url="gestion/page.php?category=2&refreshmap=1&map="+idmap+"&idmap="+idmap+"&type_gestion="+type;
	var target = "mapGestion";
	HTTPTargetCall(url,target);
}

function changeMapWithTelep(url2,type)
{
	
	document.getElementById('ModuleGestionMapContainer').innerHTML = '';
	if(document.getElementById('monster_to_add'))
	{
		var id_mstr = document.getElementById('monster_to_add').innerHTML;
	}
	
	switch(type)
	{
		case 1 :
			var url = 'gestion/page.php?category=2&'+url2+'&type=cases_bloquees';
				HTTPTargetCall(url,'tdbodygame');
		break;
		
		case 2 :
			var url = 'gestion/page.php?category=2&'+url2+'&type=cases_monsters';
			HTTPTargetCall(url,'tdbodygame');
			var url = "gestion/page.php?category=2&action=add&type=choose_monster&idmap="+idmap;
			HTTPPostCall(url,'form_monster','add_or_modif');
		break;
		
		default :
			var url = 'gestion/page.php?category=2&'+url2+'&type=cases_bloquees';
			HTTPTargetCall(url,'tdbodygame');
		break;
	}
	

	
	document.getElementById('monster_to_add').innerHTML = id_mstr;
}

function changeGestionType(idmap,type)
{
	switch(type)
	{
		case 1 :
			refreshMapEdition(idmap,'cases_bloquees');
			HTTPPostCall('','form_monster','add_or_modif');
		break;
		
		case 2 :
			refreshMapEdition(idmap,'cases_monsters');
			var url = "gestion/page.php?category=2&action=add&type=choose_monster&idmap="+idmap;
			HTTPPostCall(url,'form_monster','add_or_modif');
		break;
		
		case 3 :
			refreshMapEdition(idmap,'ressources');
			var url = "gestion/page.php?category=2&action=add&type=choose_ressource&idmap="+idmap;
			HTTPPostCall(url,'form_monster','add_or_modif');
		break;
		
		default :
			refreshMapEdition(idmap,'cases_bloquees');
		break;
	}
}

function selectMonsterToAdd()
{
	if(document.getElementById('monster_to_select'))
	{
		var id_mstr = document.getElementById('monster_to_select').value;
		if(id_mstr >= 1)
		{
			document.getElementById('monster_to_add').innerHTML = id_mstr
		}else{
			alert('veuillez sélectionner le monstre à ajouter');
		}
	}
}

function addMonsterOnMap(idmap,abs,ord)
{
	if(document.getElementById('monster_to_add'))
	{
		var id_mstr = document.getElementById('monster_to_add').innerHTML;
		if(id_mstr >= 1)
		{
			var url = "gestion/page.php?category=2&action=add&type=valid_add_monster&idmap="+idmap+"&abs="+abs+"&ord="+ord+"&idmstr="+id_mstr;
			HTTPTargetCall(url,'maj','',false);	
			refreshMapEdition(idmap,'cases_monsters');
		}else{
			alert('veuillez sélectionner le monstre à ajouter');
		}
	}
}

function delMonsterOnMap(idmap,abs,ord)
{
	if(confirm('Voulez vous supprimer ce monstre ?'))
	{
		var url = "gestion/page.php?category=2&action=add&type=valid_del_monster&idmap="+idmap+"&abs="+abs+"&ord="+ord;
		HTTPTargetCall(url,'maj','',false);	
		refreshMapEdition(idmap,'cases_monsters');		
	}
}

function selectRessourceToAdd()
{
	if(document.getElementById('ressource_to_select'))
	{
		var id_mstr = document.getElementById('ressource_to_select').value;
		if(id_mstr >= 1)
		{
			document.getElementById('ressource_to_add').innerHTML = id_mstr
		}else{
			alert('veuillez sélectionner le monstre à ajouter');
		}
	}
}

function addRessourceOnMap(idmap,abs,ord)
{
	if(document.getElementById('ressource_to_add'))
	{
		var action_id = document.getElementById('ressource_to_add').innerHTML;
		if(action_id >= 1)
		{
			var url = "gestion/page.php?category=2&action=add&type=valid_add_ressource&idmap="+idmap+"&abs="+abs+"&ord="+ord+"&action_id="+action_id;
			HTTPTargetCall(url,'maj','',false);	
			refreshMapEdition(idmap,'ressources');
		}else{
			alert('veuillez sélectionner la ressource à ajouter');
		}
	}
}

function delRessourceOnMap(idmap,abs,ord)
{
	if(confirm('Voulez vous supprimer cette ressource ?'))
	{
		var url = "gestion/page.php?category=2&action=add&type=valid_del_ressource&idmap="+idmap+"&abs="+abs+"&ord="+ord;
		HTTPTargetCall(url,'maj','',false);	
		refreshMapEdition(idmap,'ressources');		
	}
}



function changeTelep(div) {
	select = document.getElementById(div);
	select.style.backgroundImage = select.options[select.selectedIndex].style.backgroundImage;
}


function loadStepType(steptype,stepid)
{
	var url="gestion/page.php?category=25&action=loadStepType&steptype="+steptype+"&stepid="+stepid;
	var target = "loadStepType_"+stepid;
	HTTPTargetCall(url,target);
}

function loadStepAction(actionType,stepid,div)
{
	var url="gestion/page.php?category=25&action=loadStepAction&actiontype="+actionType+"&stepid="+stepid+"&div="+div;
	var target = div+'_'+stepid;
	HTTPTargetCall(url,target);
}

function cleanTextPnj(div)
{
	textac = document.getElementById(div);
	if(textac.value == "texte PNJ avant avoir finis l'étape")
		textac.value = "";
}

function cleanTextPnjAfter(div)
{
	textac = document.getElementById(div);
	if(textac.value == "texte PNJ après avoir finis l'étape")
		textac.value = "";
}

function putAllPnjRow()
{
	var pnjName = document.getElementById('rowDefaultPnjName').value;	
	var elements = document.getElementsByName('step');
	for(var i=0; i<elements.length; i++)
	{
		var stepid = elements[i].value;
		var inputId = 'pnj_'+stepid
		var input = document.getElementById(inputId);	
		input.value = pnjName;
	}
}

function putAllLvlReqRow()
{
	var pnjName = document.getElementById('rowDefaultLvlReqName').value;	
	var elements = document.getElementsByName('step');
	for(var i=0; i<elements.length; i++)
	{
		var stepid = elements[i].value;
		var inputId = 'lvlreq_'+stepid
		var input = document.getElementById(inputId);	
		input.value = pnjName;
	}
}

function loadMenu(url)
{
	$('#ModuleGestionMapContainer').hide();
	HTTPTargetCall(url,'tdbodygame');
}



function duplicateQuest(idquete)
{
	var url="gestion/quetes/duplicateQuest.php?idquete="+idquete;
	HTTPTargetCall(url,'tdbodygame');	
}

