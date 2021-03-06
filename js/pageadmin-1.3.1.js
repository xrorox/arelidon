function changeMap()
{
	var url = "gestion/page.php?category=2&map=" + $('#changemap').val();
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
	
	$('#ModuleGestionMapContainer').html('');
        var id_mstr = 0;
	if($('#monster_to_add').html() != '')
	{
            id_mstr = $('#monster_to_add').html();
	}
        
        var url = ';'
	
	switch(type)
	{
		case 1 :
			url = 'gestion/page.php?category=2&'+url2+'&type=cases_bloquees';
				HTTPTargetCall(url,'tdbodygame');
		break;
		
		case 2 :
			url = 'gestion/page.php?category=2&'+url2+'&type=cases_monsters';
			HTTPTargetCall(url,'tdbodygame');
			url = "gestion/page.php?category=2&action=add&type=choose_monster&idmap="+idmap;
			HTTPPostCall(url,'form_monster','add_or_modif');
		break;
		
		default :
			url = 'gestion/page.php?category=2&'+url2+'&type=cases_bloquees';
			HTTPTargetCall(url,'tdbodygame');
		break;
	}
	

	
	$('#monster_to_add').html(id_mstr);
}

function changeGestionType(idmap,type)
{
        var url = '';
	switch(type)
	{
		case 1 :
			refreshMapEdition(idmap,'cases_bloquees');
			HTTPPostCall('','form_monster','add_or_modif');
		break;
		
		case 2 :
			refreshMapEdition(idmap,'cases_monsters');
			url = "gestion/page.php?category=2&action=add&type=choose_monster&idmap="+idmap;
			HTTPPostCall(url,'form_monster','add_or_modif');
		break;
		
		case 3 :
			refreshMapEdition(idmap,'ressources');
			url = "gestion/page.php?category=2&action=add&type=choose_ressource&idmap="+idmap;
			HTTPPostCall(url,'form_monster','add_or_modif');
		break;
		
		default :
			refreshMapEdition(idmap,'cases_bloquees');
		break;
	}
}

function selectMonsterToAdd()
{
	
    var id_mstr = $('#monster_to_select').val();
    if(id_mstr >= 1)
    {
            $('#monster_to_add').html(id_mstr); 
    }else{
            alert('veuillez s�lectionner le monstre � ajouter');
    }
	
}

function addMonsterOnMap(idmap,abs,ord)
{

    var id_mstr = $('#monster_to_add').html();
    if(id_mstr >= 1)
    {
            var url = "gestion/page.php?category=2&action=add&type=valid_add_monster&idmap="+idmap+"&abs="+abs+"&ord="+ord+"&idmstr="+id_mstr;
            HTTPTargetCall(url,'maj','',false);	
            refreshMapEdition(idmap,'cases_monsters');
    }else{
            alert('veuillez s�lectionner le monstre � ajouter');
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
	
    var id_mstr = $('#ressource_to_select').val();
    if(id_mstr >= 1)
    {
            $('#ressource_to_add').html(id_mstr); 
    }else{
            alert('veuillez s�lectionner le monstre � ajouter');
    }
	
}

function addRessourceOnMap(idmap,abs,ord)
{

        var action_id = $('#ressource_to_add').html();
        if(action_id >= 1)
        {
                var url = "gestion/page.php?category=2&action=add&type=valid_add_ressource&idmap="+idmap+"&abs="+abs+"&ord="+ord+"&action_id="+action_id;
                HTTPTargetCall(url,'maj','',false);	
                refreshMapEdition(idmap,'ressources');
        }else{
                alert('veuillez s�lectionner la ressource � ajouter');
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
	if(textac.value == "texte PNJ avant avoir finis l'�tape")
		textac.value = "";
}

function cleanTextPnjAfter(div)
{
	textac = document.getElementById(div);
	if(textac.value == "texte PNJ apr�s avoir finis l'�tape")
		textac.value = "";
}

function putAllPnjRow()
{
	var pnjName = $('#rowDefaultPnjName').val();	
	var elements = document.getElementsByName('step');
	for(var i=0; i<elements.length; i++)
	{
		var stepid = elements[i].value;
		var inputId = 'pnj_'+stepid
		var input = $('#'+inputId);	
		input.value = pnjName;
	}
}

function putAllLvlReqRow()
{
	var pnjName = $('#rowDefaultLvlReqName').val();	
	var elements = document.getElementsByName('step');
	for(var i=0; i<elements.length; i++)
	{
		var stepid = elements[i].value;
		var inputId = 'lvlreq_'+stepid
		var input = $('#'+inputId);	
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

