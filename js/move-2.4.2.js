var security = 0;
var dispo = 1;

var blockabs = 0;
var blockord = 0;

var abspx=0;
var ordpx=0;

var abs=0;
var ord=0;

var isDoingAction = false;

var can_move = 1;
var number_try_move = 0;

function getAbs(div)
{
    var abspx_obj = $('#'+div).css('marginLeft');	
    var abspx = abspx_obj.replace('px','');
    var abss =parseInt(abspx);

    abs = (abss + 32) / 32;
    abs = Math.round(abs);

    return abs;
}

function getOrd(div)
{
    
    var ordpx_obj = $('#'+div).css('marginTop');
    var ordpx = ordpx_obj.replace('px','');
    var ordd =parseInt(ordpx);		
		
    ord = (ordd + 48) / 32;
    ord = Math.round(ord);

    return ord;
}

function getValueBlock(number)
{	
    if($("#free"+number).html() == 1)
        blocking = 1;
    else
        blocking = 0;
	
    return blocking;
}

	
function move(typemove)
{
    
    var fatigue = $('#fatigue').html();
    fatigue = parseInt(fatigue);
    //On chèque la valeur connue par le js. Cependant les réactualisations du serveur font foi.
    if(fatigue >= 500)
    {
        can_move =2;
        alert("Vous êtes trop fatigué, vous ne pouvez bouger.");
    }else if(fatigue < 500)
    {
        can_move =1;
    }
	if($('#life_perso').html() > 0 && can_move == 1)
	{
		// R�cup�ration de l'abscisse et ordonn�es du joueur	
            var char_id = $("#perso_id").html();
	   
	    var abspx = $("#perso").css('marginLeft');
            var ordpx = $("#perso").css('marginTop');
		
            abspx = parseInt(abspx);
            ordpx = parseInt(ordpx);	
		
            abs = getAbs('perso');
            ord = getOrd('perso');
		
            classe = $("#perso_classe").html();
            gender = $("#perso_gender").html();
            skin = $("#perso_skin").html();
		
            var number = (ord - 1 ) * 25 + (abs);
            var moveabs = moveord = hasmove = 0;               
            var array_block = ["tableau"];
            var number_to_verif=0;
            
            
            //on chech les 8 cases
            array_block[1] = getValueBlock(number + 25);
            array_block[2] = getValueBlock(number - 1);
            array_block[3] = getValueBlock(number - 25);
            array_block[4] = getValueBlock(number + 1);
            array_block[5] = getValueBlock(number + 26);
            array_block[6] = getValueBlock(number + 24);
            array_block[7] = getValueBlock(number - 24);
            array_block[8] = getValueBlock(number - 26);
            
          
	// 1 : bas , 2 : gauche , 3 : haut , 4 : droite , 5 : bas droite , 6 : bas gauche , 7 : haut droite , 8 : bas droite
	switch(typemove)
	{
		// Bas
		case 1 :
                    number_to_verif = number + 25;
                    // Si case non bloqu�e
                    abspx = abspx + 0;
                    ordpx = ordpx + 32;

                    
                    if(array_block[1] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768 )
                    {	
                        
                        moveabs = 0;
                        moveord = 32;

                        hasmove = 1;

                        newabs = abs;
                        neword = ord + 1;
                    }else
                    {
                        ordpx = ordpx - 32;
                    }
			
		break;
			
		// Gauche
		case 2:
                    number_to_verif = number - 1;
                    // Si case non bloqu�e
			
                    abspx = abspx - 32;
                    ordpx = ordpx;
                    
                    
                    if(array_block[2] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768)
                    {	
                       
                            moveabs = -32;
                            moveord = 0;

                            hasmove = 1;

                            newabs = abs - 1;
                            neword = ord;
                    }
                    else
                    {
                        abspx += 32;
                    }

		break;
			
		// Haut
                
		case 3 :
                    number_to_verif = number - 25;
                    // Si case non bloqu�e
                    abspx = abspx + 0;
                    ordpx = ordpx - 32;
                    if(array_block[3] == 0 && abspx > 0 && ordpx > -17 && ordpx < 448 && abspx < 768)
                    {
                        
                        moveabs = 0;
                        moveord = -32;

                        hasmove = 1;

                        newabs = abs;
                        neword = ord - 1;
                    }
                    else
                    {
                        ordpx += 32;
                    }
			
		break;
			
		// droite
		case 4 :
		 number_to_verif = number + 1;
                    // Si case non bloqu�e
                    abspx = abspx + 32;

                    ordpx = ordpx;
                                
                     
                    if(array_block[4] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768)
                    {
                        
                        moveabs = 32;
                        moveord = 0;

                        hasmove = 1;

                        newabs = abs + 1;
                        neword = ord;
                    }
                    else
                    {
                        abspx -= 32;
                    }
                        
		break;
			
		// Bas droite
		case 5 :
			number_to_verif = number +26;
			// Si case non bloqu�e
                        abspx = abspx + 32;
                        ordpx = ordpx + 32;
                                
			if(array_block[5] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768)
			{
	    			
                            moveabs = 32;
                            moveord = 32;

                            hasmove = 1;

                            newabs = abs + 1;
                            neword = ord + 1;
			}
                        else
                        {
                            abspx -=32;
                            ordpx -=32;
                        }
			
		break;
			
		// Bas gauche
		case 6 :
                     number_to_verif = number +24;
                    // Si case non bloqu�e
                    abspx = abspx - 32;
                    ordpx = ordpx + 32;

                    if(array_block[6] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768)
                    {

                    moveabs = -32;
                    moveord = 32;

                    hasmove = 1;

                    newabs = abs - 1;
                    neword = ord + 1;
                    }
                    else
                    {
                        abspx += 32;
                        ordpx -=32;
                    }
                    
		break;
			
		// Haut droit
		case 7 :
                     number_to_verif = number - 24;
                    // Si case non bloqu�e
                    abspx = abspx + 32;
                    ordpx = ordpx - 32;

                    if(array_block[7] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768)
                    {
                    moveabs = 32;
                    moveord = -32;

                    hasmove = 1;

                    newabs = abs + 1;
                    neword = ord - 1;
                    }
                    else
                    {
                        abspx -= 32;
                        ordpx += 32;
                    }

		break;
			
		// Haut gauche
		case 8 :
		 number_to_verif = number - 26;
                // Si case non bloqu�e
                abspx = abspx - 32;
                ordpx = ordpx - 32;



                if(array_block[8] == 0 && abspx > 0 && ordpx > 0 && ordpx < 448 && abspx < 768)		
                {
                        moveabs = -32;
                        moveord = -32;

                        hasmove = 1;

                        newabs = abs - 1;
                        neword = ord - 1;
                }
                else
                {
                    asbpx += 32;
                    ordpx += 32;
                }

		break;
	}
        

	if(typemove == 5 || typemove == 6)
		typemove = 1;
		
	if(typemove == 7 || typemove == 8)
		typemove = 3;
	
	if(gender == 0)
		gender = 1;
		
	if(skin > 0)
		gender = skin;
	
	if($("#perso").css('backgroundImage') != "url('pictures/classe/"+classe+"/ico/"+gender+"-"+typemove+".gif')")
            $("#perso").css('backgroundImage',"url('pictures/classe/"+classe+"/ico/"+gender+"-"+typemove+".gif')");
	
	$("#perso").css('marginLeft',abspx+'px');
	$("#perso").css('marginTop',ordpx+'px');
		
	if($("#telep"+number_to_verif))
	{
		var changemap = $("#telep"+number_to_verif).html();	
		var changeabs = $("#telep"+number_to_verif+"_abs").html();
		var changeord = $("#telep"+number_to_verif+"_ord").html();
	}
	
	if(hasmove == 1)
	{
	
            number = (neword - 1) * 25 + (newabs);
            // Nouveau calcul des cases bloqu�es :
            array_block = ["tableau"];
	
			array_block[1] = getValueBlock(number + 25);
			array_block[2] = getValueBlock(number - 1);
			array_block[3] = getValueBlock(number - 25);
			array_block[4] = getValueBlock(number + 1);
			array_block[5] = getValueBlock(number + 26);
			array_block[6] = getValueBlock(number + 24);
			array_block[7] = getValueBlock(number - 24);
			array_block[8] = getValueBlock(number - 26);
                        
			for(i=1;i<=8;i++)
			{
			   
                            var abspxfleche = 0;
                            var ordpxfleche = 0;
                            
                            abspxfleche = parseInt($("#fleche_"+i).css('marginLeft'));
                            ordpxfleche = parseInt($("#fleche_"+i).css('marginTop'));
                            
                        
                            abspxfleche = abspxfleche + moveabs;
                            ordpxfleche = ordpxfleche + moveord;
                     
                            // V�rification que case accessible + pas hors de map sinon on cache la fl�che
				
                            $("#fleche_"+i).css('marginLeft',abspxfleche);
                            $("#fleche_"+i).css('marginTop',ordpxfleche);

                           
				
		    	
		    	if(array_block[i] == 1 || abspxfleche < 0 || ordpxfleche < 0 || ordpxfleche > 448 || abspxfleche > 768)
		    		$("#fleche_"+i).css('display','none');   
		    	else
		    		$("#fleche_"+i).css('display','block');
                            
		    	
			}
			
		}
                if(changemap ==null)
                    changemap=0;
                
		var map5 = $(".starwars").val();
                
		if(changemap > 0)
		{
			updateAfterTime(changeabs,changeord,typemove,changemap,char_id,map5);
                        $('#fatigue').html(fatigue + 1); // On augmente la valeur de la fatigue pour pouvoir bloquer avec le js.
		}
		else{
				
			updateAfterTime(newabs,neword,typemove,changemap,char_id,map5);
                        $('#fatigue').html(fatigue + 1);
		}
		
		
		if(changemap > 0)
		{
			
			refreshInfos();
			url = "pageig/game.php?refresh=1";
			HTTPTargetCall(url,'bodygameig','',true);
			
		}
		dispo = 1;
		
		
		// lib�ration de la m�moire
		delete obj;
		delete url;
		delete target;
		
	}	
}


function updateAfterTime(abs,ord,face,changemap,char_id,map5)
{
	var url = "pageig/move/move.php?abs="+abs+"&ord="+ord+"&face="+face+"&char_id="+char_id+"&changemap="+changemap+"&map="+map5;

	if(changemap > 0)
	{
		can_move = 0;
                refreshMap(1);
		HTTPTargetCall(url,'update_position');
                
		
		can_move = 1;
	}
	else
	{		
		HTTPTargetCall(url,'update_position');	
                 
		can_move = 1;
	}
        
}

function setCanMove()
{
	can_move = 1;
}

function teleport(map,abs,ord,telep)
{
	url = "pageig/move/move.php?map="+map+"&abs="+abs+"&ord="+ord+"&face=1&telep="+telep;
	HTTPTargetCall(url,'update_position','',false);	
	refreshInfos();
	url = "pageig/game.php?refresh=1";
	HTTPTargetCall(url,'bodygameig','',true);
}