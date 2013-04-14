//var security = 0;
//var dispo = 1;
//
//var blockabs = 0;
//var blockord = 0;
//
//var fin = 0;
//var timestamp = 0;
//var timetemp = 0;
//var stillsend = 0;
//
//var tempabs = 0;
//var tempord = 0;
//
//var abspx=0;
//var ordpx=0;
//
//var intval = "";
//
//var abs=0;
//var ord=0;
//
//var endep=0;
//
//var ratio = 2;
//
//function autoLoadPlayerOnline()
//{
//	
//}
//
//function moving_player(absmax,ordmax,time,classe,id)
//{
//	if(dispo == 0)
//	{	
//		return 1;
//		$('#perso_'+id).hide();
//	}else{
//		ordmax = parseInt(ordmax);
//		ordmax = ordmax + 16;
//		moving_now_player(absmax,ordmax,time,classe,0,0,id);
//	}
//}
//
//function moving_now_player(absmax,ordmax,time,classe,b,block,id)
//{
//	time = 15;
// 
//        var abspx = $("#perso_"+id).css('marginLeft');
//	var ordpx = $("#perso_"+id).css('marginTop');
//	
//	var abss =parseInt(abspx);
//	var ordd =parseInt(ordpx);	
//	
//
//// Récupération des cordonnées de départ et d'arrivée	
//	abs = (abss) / 32;
//	abs = Math.round(abs);	
//		
//	ord = (ordd + 16) / 32;
//	ord = Math.round(ord);
//
//
//	absmax = parseInt(absmax);	
//	var temp_absmax = absmax;
//	
//	absmax = (absmax) / 32;
//	absmax = Math.round(absmax);
//	
//	ordmax = parseInt(ordmax);
//	var temp_ordmax = ordmax;
//	
//	ordmax = (ordmax) / 32;
//	ordmax = Math.round(ordmax);	
//	
//// Début de la boucle qui va gérer le déplacement
//	var secu = number=value =0
//	var i = 0;
//         block =0;
//	var hori = absmax - abs;
//	var verti = ordmax - ord;
//	var axis=0;
//	// On regarde si il faut déplace en horizontal ou vertical
//	if(Math.abs(hori) >= Math.abs(verti))
//		 axis = 1;
//	else
//		 axis = 2;
//				
//if(abs != absmax || ord != ordmax)
//{
//    if(axis == 1)
//    {
//	// Déplacement horizontale
//	if(hori > 0)
//	{
//            // Vers la droite 
//            number = (ord * 25) + (abs) + 2;
//            face = 4;
//	}else{
//            // Vers la gauche
//            number = (ord * 25) + (abs);
//            face = 2;		
//	}
//        
//        value = $("#free"+number).html();		
//            // Gestion du mouvement
//        if(value != 1)
//           move_player(axis,hori,classe,abspx,time,i,temp_absmax,temp_ordmax);
//        else
//            block = 1;
//		
//    }else{
//	if(verti > 0)
//	{
//            // Déplacement vertical
//            // Vers le bas 
//            number = ((ord + 1) * 25) + (abs) + 1;
//            face = 1;				
//            
//	}else{
//		// Vers le haut 
//            number = ((ord - 1) * 25) + (abs) + 1;
//           // Gestion du mouvement
//            face = 3;		
//             }	
//             
//        value = $("#free"+number).html();
//        // Gestion du mouvement
//        if(value != 1)				
//            move_player(axis,verti,classe,ordpx,time,i,temp_absmax,temp_ordmax);
//        else
//            block = 2;   
//              
//	}
//		
//	// Gestion du cas où l'on est bloqué à un endroit
//    if(block > 0)
//    {
//        if(axis == 1)
//            axis = 2;
//        else
//            axis = 1;
//			
//	i = 0;
//			
//			// On a été bloqué en horizontale , on tente en verticale
//	if(block == 1)
//	{
//            if(verti != 0)
//            {
//					
//		if(verti > 0)
//		{
//                    // Vers le bas 
//                    number = ((ord + 1) * 25) + (abs) + 1; 	
//                    face = 1;
//		}else{
//                    // Vers le haut 
//                    number = ((ord - 1) * 25) + (abs) + 1;
//                    face = 3;				
//		}
//                value = document.$("#free"+number).html();
//                // Gestion du mouvement
//                if(value != 1)
//                {
//                    move_player(axis,verti,classe,ordpx,time,i,temp_absmax,temp_ordmax);	
//                }else{
//                    block = 3;
//                }
//                   
//	}else{
//            block = 3;
//	}			
//    }else{
//	// Sinon si on est bloqué à la verticale on tente en horizontale
//	if(hori != 0)
//        {
//            if(hori > 0)
//            {
//		// Vers la droite 
//		number = (ord * 25) + (abs) + 2;
//                face = 4;					
//            }else{
//		// Vers la gauche
//		number = (ord * 25) + (abs);	
//                face = 2;
//		// Gestion du mouvement		
//            }
//          value = $("#free"+number).html();
//          if(value != 1)	
//              move_player(axis,hori,classe,abspx,time,i,temp_absmax,temp_ordmax);
//          else
//              block = 3;	
//		
//            
//        }else{
//            block = 3;
//	}	
//    }
//		
//    // Si complètement bloqué , on stoppe et on redonne la main
//    if(block == 3)
//    {
//        dispo = 1;
//	$("#perso_"+id).css('backgroundImage',"url('pictures/ico/"+classe+"-0-"+face+".gif')");			
//    }
//}	
//}else{
//    out_player(classe,face,id);
//}
//}
//
//function out_player(classe,face,id)
//{
//	dispo = 1;
//	$("#perso_"+id).css('backgroundImage',"url('pictures/ico/"+classe+"-0-"+face+".gif')");	
//	
//	abs = getAbs();
//	ord = getOrd();
//        var changemap=0;
//	
//	var number = (ord - 1) * 25 + (abs);
//	if($("#telep"+number))
//		 changemap = $("#telep"+number).html();	
//	
//	if(changemap >= 1)
//	{
//		url = "pageig/game.php?refresh=1&majposition=1&abs="+abs+"&ord="+ord+"&face="+face;
//		loadInDiv(url,'bodygameig');
//	}else{
//		url = "pageig/move/move.php?abs="+abs+"&ord="+ord+"&face="+face+"&changemap="+changemap;
//		loadInDiv(url,'update_position'); 
//	}
//	
//	if($('#menuig').html() == "")
//	{
//		var url = "include/menuig.php?refresh=1";
//		var target = "menuig";
//		HTTPTargetCall(url,target);
//	}
//}
//
//function move_player(axis,valaxis,classe,px,time,i,absmax,ordmax)
//{
//		// Si on est en cours de mouvement
//		ration = parseInt(ratio);
//		var imax = (32 / ratio) -1;
//		px = parseInt(px);
//	var obj=0;
//    if(i<=imax)
//    {
//        i++;
//			
//        if(axis == 1)
//	{
//            if(valaxis > 0)
//            {
//                px = px + ratio;
//		 	
//		$("#perso_"+id).css('marginLeft',px);
//		if($("#perso_"+id).css('backgroundImage') != "url('pictures/ico/"+classe+"-1-4.gif')")
//                    $("#perso_"+id).css('backgroundImage',"url('pictures/ico/"+classe+"-1-4.gif')");
//		}else{
//                    px = px - ratio;
//                    $("#perso_"+id).css('marginLeft',px);
//                    if($("#perso_"+id).css('backgroundImage') != "url('pictures/ico/"+classe+"-1-2.gif')")
//                        $("#perso_"+id).css('backgroundImage',"url('pictures/ico/"+classe+"-1-2.gif')");			
//                    }
//				
//	}else{			
//            if(valaxis > 0)
//            {
//                px = px + ratio;
//		$("#perso_"+id).css('marginTop',px);
//		if($("#perso_"+id).css('backgroundImage') != "url('pictures/ico/"+classe+"-1-1.gif')")	
//                    $("#perso_"+id).css('backgroundImage',"url('pictures/ico/"+classe+"-1-1.gif')");
//            }else{
//		px = px - ratio;
//		$("#perso_"+id).css('marginTop',px);
//		if($("#perso_"+id).css('backgroundImage') != "url('pictures/ico/"+classe+"-1-3.gif')")
//                    $("#perso_"+id).css('backgroundImage',"url('pictures/ico/"+classe+"-1-3.gif')");			
//		}		
//	}		
//        nav = navigator.appName;
//	if( nav == "Microsoft Internet Explorer"){	
//            setTimeout("move_player("+axis+","+valaxis+","+classe+","+px+","+time+","+i+","+absmax+","+ordmax+");",0.05);
//	}else{
//            setTimeout("move_player("+axis+","+valaxis+","+classe+","+px+","+time+","+i+","+absmax+","+ordmax+");", time);
//	}
//    }else{
//			
//    // On recharge moving_now si ya besoin d'encore bouger
//    moving_now_player(absmax,ordmax,time,classe,'1');
//    }
//}