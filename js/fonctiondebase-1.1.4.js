var actual_char = 1;

var dispo = 1;
var first = 1;
var isSendMessage = 0;
autoRefresh();
autoRefreshBarres();
refreshGroup(1);


function resize()
{
	if (this.name!='fullscreen'){
		window.open(location.href,'fullscreen','fullscreen,scrollbars')
	} 
}

function show(div)
{
	var obj = document.getElementById(div,type);
	if(type == "")
		var type = "block";
	else
		var type = "";
	
	if(obj.style.display == "none"){
		obj.style.display=type;
	}
	else
	{
		obj.style.display="none";
	}
}

function hide(div)
{
    $('#'+div).css('display','none');
}

function justShow(div)
{
    $('#'+div).css('display','block');
}

function switchArrow(div)
{
	if(document.getElementById(div))
		var obj = document.getElementById(div);
	else
		return false;
	
	if(obj.src == "pictures/utils/arrow_right.gif"){
		obj.src="pictures/utils/arrow_down.gif";
	}
	else{
		
		obj.src="pictures/utils/arrow_right.gif";
	}
}


function changeUrl(url)
{
	document.location = url;
}

function change()
{	
	$('#perso').css('backgroundImage',"url('pictures/0-1.gif')");
}

function loadObject(mode,distance,id)
{
    
	if((distance <= 1 && mode == 'pnj' || mode != 'pnj') && $('#menuig'))
	{
            
		if($('#menuig').css('display') == "none")
		{
			$('#menuig').html('');
			show('menuig');
		}
				
		url = "include/menuig.php?refresh=1&mode="+mode+"&distance="+distance+"&id="+id;
		loadInDiv(url,'menuig');
		refreshInfos();				
	}
        
}

function autoComplete(div,array,back) // on place en argument la div , et le tableau sous forme de string s�par� par des | (pour garder les virgules) exemple : objet1|objet2|objet2,3 ...
{
	var divContainer = "#"+div;
	var data = array.split('|'); // on r�cup�rer la chaine val1,val2,val3 sous forme de tableau	
	
	$(divContainer).autocomplete(data,{matchContains:1});
}		

function deleteDiv(div)
{
	$('#'+div).html('');
}

function switchShowTypeQuest(type)
{
    var allquest = document.getElementsByName(type);
	if($('#'+type).attr('checked') == true)
	{
		for(i=0;i<=allquest.length;i++)
		{
			allquest[i].style.display = 'block';
		}
	}
	else
	{
		for(i=0;i<=allquest.length;i++)
		{
			allquest[i].style.display = 'none';
		}		
	}
}

function cleanMenu()
{
	if($('#menuig'))
	{
		$('#menuig').html('');
	}	
}

function refreshMenu()
{
	HTTPTargetCall('include/menuig.php?refresh=1','menuig',false,true);
}

function cleanMenuKeyboard()
{
    if($('#menuig').html() != '<div id="menuig" style="text-align: left; margin-top: 0px; font-weight: 700;"></div>')
    {
        $('#menuig').html('');
    }
}

function refreshMap(move)
{
    
	if($("#inDonjon").html() != 0)
	{
            url = 'pageig/map/eventOnMap.php?refresh=1';
		
	}else{
            url = 'pageig/map/eventOnMap.php?refresh=1';
	}

	target = 'map_container_event';
	HTTPTargetCall(url,target,'',true);			

	if($('#life_perso').html() == 0 || $('#life_perso').html() == "0")
	{
            		
            dispo = 0;

            $('#perso').css('backgroundImage',"url('pictures/classe/die.gif')");	
            $('#perso').css('title',"Vous �tes mort, si aucun pr�tre ne vous vient en aide, vous serez t�l�porter dans un cimeti�re dans "+$('#die_perso').html()+" secondes");
			
            if($('#die_perso').html() > 0)
            {
                url = "pageig/game.php?refresh=1&majposition=1&die=1";
                loadInDiv(url,'bodygameig');
				
                // Resurection on redonne le d�placement possible
                dispo = 1;
            }
		
	
	}else{
			
	if($('#perso').css('backgroundImage') == "url('http://localhost/arelidon/pictures/classe/die.gif')")
	{
            classe = $("#perso_classe").html();
            gender = $("#perso_gender").html();
				
            $('#perso').css('backgroundImage',"url('pictures/classe/"+classe+"/ico/"+gender+"-1");			
            $('#perso').css('title',"");
	}
	
	}

	
delete classe;
delete gender;
delete url;
delete target;
delete classe;
delete gender;
	
}

function refreshBarres()
{
	url = 'pageig/header/show_barres.php?refresh=1';
	target = 'show_barres';
	HTTPTargetCall(url,target,'',true);
	
	delete url;
	delete target;
}

function autoRefreshBarres()
{
	setTimeout("refreshBarres();",2000);	
}

function refreshInfos()
{
	url = 'pageig/header/char_infos.php?refresh=1';
	target = 'char_infos';
	HTTPTargetCall(url,target,'',true);
	
	url = 'include/headerig.php?refresh=1';
	target = 'headerig';
	HTTPTargetCall(url,target,'',true);
	delete url;
	delete target;
}

function openPopup(page,nom,option) 
{
	window.open(page,nom,option); 
}

function autoRefresh()
{
	if($('#onmap'))
	{
		onmap = 1;
	}
	else
	{
		onmap = 0;
        }
	if(onmap == 1 || first == 1)
	{
		first = 0;
		
		refreshMap();
		setTimeout("autoRefresh();",1000);		
	}
	
	delete onmap;
	delete first;
}

function refreshGroup(i)
{

    if($('#has_invitation').html() == 1)
    {
        invit_by = $('#invit_by').html();
        group_id = $('#group_invit_id').html();
		

        if(confirm('Vous avez recu une invitation de '+invit_by+' a rejoindre son groupe'))
        {
            HTTPTargetCall('pageig/group/show.php?refresh=1&action=accept&group_id='+group_id,'group');
        }else{
            HTTPTargetCall('pageig/group/show.php?refresh=1&action=refuse&group_id='+group_id,'group');
        }
    }
	
    if(i != 1)
    {
        HTTPTargetCall('pageig/group/show.php?refresh=1','group','',true);
    }
    setTimeout("refreshGroup();",1000);	
}

function setIsSendingMessage()
{
	isSendMessage = 1;
}

function removeIsSendingMessage()
{
	isSendMessage = 0;
}

function weight()
{
	HTTPTargetCall('page.php?category=trade&action=weight&nb='+
            +$('#nb').val()
            +'&ob='+$('#item_to_post').val()
        ,'weight');
}

function switchCharLeft()
{
	cleanActualChar();
	
	actual_char--;
	if(actual_char < 1)
		actual_char = $('#max_char').val();
	
	switchChar(actual_char);
}

function switchCharRight()
{
	cleanActualChar();
	
	actual_char++;
	if(actual_char > $('#max_char').val())
		actual_char = 1;
	
	switchChar(actual_char);
}

function cleanActualChar()
{
	$("#char_show_"+actual_char).hide();
	$("#char-element-list-table-"+actual_char).removeClass("char-element-list-selected");
}

function switchChar(i)
{
	cleanActualChar();
	
	actual_char = i;
	$("#char_show_"+actual_char).show();
	$("#char-element-list-table-"+actual_char).addClass("char-element-list-selected");
}

function deleteChar(id)
{
	if(confirm("Voulez vous vraiment supprimer ce personnage ?"))
	{
		window.location.href ='index.php?page=selectchar&delete=1&char_id='+id; 
	}
}

// Fonctions de combats

function checkIsAllReady()
{
	var all_ready = true;
	var numberOfReady = 0;
	
	for(place=0;place<=20;place++)
	{
            if($("#is_ready_"+place).html())
            {
                if($("#is_ready_"+place).html() == "1"
                   || $("#is_ready_"+place).html() == " 1"
                   || $("#is_ready_"+place).html() == " 1 ")
                {
                        // Ok ready
                        //alert("ready pour place : "+place);
                        numberOfReady++;
                }else{
                        all_ready = false;
                }
           }
	}
	
	if(numberOfReady > 0)
	{
		
		if(all_ready)
		{
			// On peut passer au combat
			window.location = "fight.php?fight_id="+document.getElementById("fight_id").innerHTML+"&all_ready=1";
		}
	}
}

function setReady(fighter_id,place)
{
	HTTPTargetCall("pageig/fight/ajax_call/setReady.php?fighter_id="+fighter_id,"cursor_"+place);
}

function refreshFight()
{
        var fight_id = $("#fight_id").html();
       
            checkFightIsEnd(fight_id);
            refreshTimerAjax(fight_id);
            refreshTextFight(fight_id);
            refreshTurn(fight_id);
            refreshSkillList(fight_id);
            refreshPa(fight_id);	
}

function refreshTurn(fight_id)
{
	var url = "pageig/fight/subview/turnList.php?refresh=1&fight_id="+fight_id;
	HTTPTargetCall(url,"turn_list_container");
}

function refreshTextFight(fight_id)
{

	var url = "pageig/fight/subview/infoFight.php?refresh=1&fight_id="+fight_id;
	HTTPTargetCall(url,"tchat_fight_container");
}

function refreshSkillList(fight_id)
{
	
}

function refreshChar()
{
        var fight_id = $("#fight_id").html();
	var url = "pageig/fight/subview/charsContainer.php?refresh=1&fight_id="+fight_id;
	HTTPTargetCall(url,"chars_container");
}

function refreshTimerAjax(fight_id)
{
	HTTPTargetCall("pageig/fight/subview/timer.php?refresh=1&fight_id="+fight_id,"timer");
}

function refreshPa(fight_id)
{
	HTTPTargetCall("pageig/fight/ajax_call/showPa.php?refresh=1&fight_id="+fight_id,"pa");
}

function checkFightIsEnd(fight_id)
{
	// Test si un perso est encore vivant
	checkAllTeamisDead(fight_id);
        
        
        if($('#end_of_fight').html() == "1" || $('#end_of_fight').html() == "2") window.location = "fight.php?fight_id="+fight_id;
}

function checkAllTeamisDead(fight_id)
{
        // On envoie vers fin du combat
        
       if(fight_id != '')
       {
        var url = "pageig/fight/ajax_call/endFight.php?fight_id="+fight_id;
        HTTPTargetCall(url,"end_of_fight");
       }
}

function refreshTimer()
{
    
	var time = $("#timer").html();
	
	time--;
	
	if(time < 0)
		time = 0;
	
	if(time == 0)
	{
		$("#timer").html(time);
		finishTurn();
	}
	else
	{
		$("#timer").html(time);	
	}
        
}

function finishTurn()
{
	var fight_id = $("#fight_id").html();

	var url = "pageig/fight/ajax_call/finishTurn.php?fight_id="+fight_id;
	HTTPTargetCall(url,"ajax_call_container");	
}


function clickOnSkill(skill_id,place,team,on_ally,on_himself,can_rez,AoE,number_of_peon_in_targeted_team)
{
        
	$("#click_on_skill").html('1');
	$("#skill_id").html(skill_id);
	
	// On déselectionne les anciennes cibles
	deselectChar();
	
	// On indique les cibles sélectionnables
	if(on_ally == 1)
	{
		putPlaceSelectionnable(team,can_rez,number_of_peon_in_targeted_team);
	}else{
                if(team == 1)putPlaceSelectionnable(2,0,number_of_peon_in_targeted_team);
		else putPlaceSelectionnable(1,0,number_of_peon_in_targeted_team);
	}
}

function putPlaceSelectionnable(team,can_rez,number_of_peon_in_targeted_team)
{
        if(team == 1)place =101;
        else place = 1;
        var i =0;
        var current_place = 0;
        
        for(i = 0;i <= number_of_peon_in_targeted_team;i++)
        {
            current_place = place + i;
            
            if( $("#id_of_fighter_"+current_place).html() == null) return false;
            if($("#id_of_fighter_"+current_place).html() == "0") return false;
            if(  $("#is_dead_"+current_place).html() == "1" && can_rez == 0) return false;
            $("#pict_"+current_place).addClass("char_targetable");
            $("#can_be_target_"+current_place).html('1');
        }
        
	return true;
	
}

function deselectChar()
{
	var i;
	for(i=1;i<=5;i++)
	{
		putPlaceUnSelectionnable(i);
	}
	
	for(i=101;i<=105;i++)
	{
		putPlaceUnSelectionnable(i);
	}
}

function putPlaceUnSelectionnable(place)
{
	
    $("#pict_"+place).removeClass("char_targetable");
    $("#can_be_target_"+place).html('0');
	
}

function mouseOverOnChar(place)
{
	if($("click_on_skill").html() == 1)
	{
		if($("#can_be_target_"+place).html() == 1)
		{
			$("#cursor_"+place).html() = "v";
		}
	}
}

function mouseOutOnChar(place)
{
	$("#cursor_"+place).html("");
}

function clickOnTargetWithSkill(target_id,target_place)
{
	if($("#click_on_skill").html() == 1)
	{
		if($("#can_be_target_"+target_place).html() == 1)
		{
			var skill_id = $("#skill_id").html();
			if(skill_id > 0)
			{
				var is_char = $("#is_char_"+target_place).html();
				var fight_id = $("#fight_id").html();
				
				var url = "pageig/fight/ajax_call/useAttack.php?skill_id="+skill_id+"&target_id="+target_id+"&is_char="+is_char+"&fight_id="+fight_id;
				HTTPTargetCall(url,"use_attack_container");
				refreshFight();
				setIsRefreshed();
			}
		}
	}
}