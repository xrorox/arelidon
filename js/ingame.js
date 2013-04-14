// skin 

function TriSkin(){
	var target = "subbody";
	var onclick = "ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=shop&classe="+$('#classe').val()+"&sexe="+$('#sexe').val();
	HTTPTargetCall(onclick,target);
}


//shop

function buyItem(item_id,pnj)
{
	var onclick = "page.php?category=shop&pnj="+pnj+"&action_shop=buy&item_id="+item_id+"&qte="
            + $('#qte').val();	
	HTTPTargetCall(onclick,"bodygameig");
}

function sellItem(item_id,pnj)
{
	var onclick = "page.php?category=shop&pnj="+pnj+"&action_shop=sell&item_id="+item_id+"&qte="
            +$('#qte').val() ;	
	HTTPTargetCall(onclick,"bodygameig");
}

function buySkill(skill_id,pnj)
{
	var onclick = "page.php?category=shop_skill&pnj="+pnj+"&action=buy&skill_id="+skill_id+"" ;	
	HTTPTargetCall(onclick,"bodygameig");
}
function changeRestrict(restrict,pnj)
{
	var onclick = "page.php?category=shop&pnj="+pnj+"&restrict="+restrict ;	
	HTTPTargetCall(onclick,"bodygameig");
}

function gestionItem(value)
{
	var url ="gestion/page.php?category=28&action=itemContainer&type="+value;
	HTTPTargetCall(url,"item_container");
}

function EmptyShopText()
{
    $("#shop_text").html('');
}




//guild


function addGuild(pnj)
{
	var url = "page.php?category=guild_pnj&action=add&pnj="+pnj;
	HTTPPostCall(url,'form_add_guild','bodygameig');
}

function joinGuild(pnj)
{
	var url = "page.php?category=guild_pnj&action=join&pnj="+pnj;
	HTTPPostCall(url,'form_join_guild','bodygameig');
}







//messagerie

function viewMessage(id)
{
        //Permet de savoir si l'élement est visible.
	if($('#view_mess_'+id).is(':hidden'))
	{
		var url="page.php?category=messagerie&action=view_message&id="+id;
		HTTPTargetCall(url,'view_mess_'+id);	
	}
	$('#view_mess_'+id+'_container').show();
}

function checkAll(field)
{
 	for (i = 0; i < field.length; i++) 
 	{
		if(field[i].checked == true)
			field[i].checked = false;
		else
			field[i].checked = true;
	}
}

function addFriend()
{
	url = "page.php?category=messagerie&action=friends_list&do=add_friend";
	HTTPPostCall(url,'add_friend_form',"box_container");
}








//tchat

function autoRefreshTchat()
{
	if($('#tchat_zoom_value'))
		refreshTextZoom();
	
	refreshText();	
	setTimeout("autoRefreshTchat();", 5000);	
}

autoRefreshTchat();

function sendMessage(canal,type)
{	
	if ($('#mute').val() == 0){
//		alert('test');
            var url=target = '';
		if(type == 1)
		{
			 url = "tchat/tchatcontainer.php?refresh=1&add=1&zoom=1";
			 target = "tchatcontainerbody_zoom";
			
			HTTPPostCall(url,'form_tchat_public_zoom',target);	
		
			refreshTchat();
		}else{
			 url = "tchat/tchatcontainer.php?refresh=1&add=1";
			 target = "tchatcontainerbody";
		
			HTTPPostCall(url,'form_tchat_public',target);	
		
			refreshTchatZoom();
		}
	}
}

function swapChannel(channel,zoom)
{
	var url = "tchat/swap_channel.php?channel="+channel;
	var target = "swap_channel";
	HTTPTargetCall(url,target);
	
	refreshTchat();
	
	if(zoom == 1)
		refreshTchatZoom();
}

function refreshText()
{
	var url = "tchat/tchattext.php?refreshtchat=1";
	var target = "miniTchatContainer";
		
	HTTPTargetCall(url,target,'',true);	
}

function refreshTextZoom()
{
	var url = "tchat/tchattext.php?refreshtchat=1&zoom=1";
	var target = "miniTchatContainerZoom";
	HTTPTargetCall(url,target,'',true);	
}

function refreshTchat()
{
	var url = "tchat/tchatcontainer.php?refresh=1";
	var target = "tchatcontainerbody";
	HTTPTargetCall(url,target);		
}

function refreshTchatZoom()
{
	var url = "tchat/tchatcontainer.php?refresh=1&zoom=1";
	var target = "tchatcontainerbody_zoom";
	HTTPTargetCall(url,target);		
}

//pop up

var popupActive =0;

function load()
{
    if(popupActive == 0)
    {
        $('.background').css(
        {
            "opacity": "0.6"
        });
    
        $('.background').fadeIn('slow');
        $('.popup').fadeIn('slow');
        
        popupActive = 1;
    }
}

function disable()
{
    if(popupActive == 1)
    {
        $('.background').fadeOut('slow');
        $('.popup').fadeOut('slow');
        
        popupActive = 0;
    }
}


