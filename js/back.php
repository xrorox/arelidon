function move(abs,ord,absmax,ordmax,absfirst,time)
{
	var blockabs = 0;
	var blockord = 0;
	var abss = 0;
	var ordd = 0;
	if(dispo == 0)
	{
		security = security + 1;
		var face = 1;
		if(abs < absmax && (absfirst == 1 || blockord == 1))
		{		
			abs = abs + 2;
			
			abss = abs / 32;
			abss = Math.round(abss);
			
			ordd = (ord + 16) / 32;
			ordd = Math.round(ordd);
				
			var number = ordd * 23 + abss + 1;	
    
			var value = document.getElementById("free"+number).innerHTML;
			
			if(value != 1)
			{

				var obj = document.getElementById("perso");
				obj.style.marginLeft = abs+'px';	
				obj.style.backgroundImage="url('pictures/1-4.gif')";
				secu = 1;
				face = 4;
				setTimeout("move("+abs+","+ord+","+absmax+","+ordmax+","+absfirst+","+time+");", time);				
			}else{
				blockabs = 1;
			}

			
			
		}
		if(abs > absmax && (absfirst == 1 || blockord == 1))
		{
			abs = abs - 2;
			
			abss = abs  / 32;
			abss = Math.round(abss);
			
			ordd = (ord + 16) / 32;
			ordd = Math.round(ordd);
				
			var number = ordd * 23 + abss + 1;	
    
			var value = document.getElementById("free"+number).innerHTML;
			
			if(value != 1)
			{
				var obj = document.getElementById("perso");
				obj.style.marginLeft = abs+'px';	
				obj.style.backgroundImage="url('pictures/1-2.gif')";
				secu = 1;
				face = 4;
				setTimeout("move("+abs+","+ord+","+absmax+","+ordmax+","+absfirst+","+time+");", time);				
			}else{
				blockabs = 1;
			}
		}
	
		if(ord < ordmax && (absfirst == 0 || blockabs == 1))
		{
			ord = ord + 2;
			abss = abss / 32;
			abss = Math.round(abss);
			
			ordd = (ord + 16) / 32;
			ordd = Math.round(ordd);
				
			var number = ordd * 23 + abss + 4;	
    		if(number < 0)
    		{
    			number = 0;
    			
    		}
			var value = document.getElementById("free"+number).innerHTML;
			
			if(value != 1)
			{
				var obj = document.getElementById("perso");	
				obj.style.marginTop = ord+'px';
				obj.style.backgroundImage="url('pictures/1-1.gif')";
				face = 1;
				setTimeout("move("+abs+","+ord+","+absmax+","+ordmax+","+absfirst+","+time+");", time);
			}else{
				blockord = 1;
			}
		}
		if(ord > ordmax && (absfirst == 0 || blockabs == 1))
		{
			ord = ord - 2;
			abss = abs / 32;
			abss = Math.round(abss);
			
			ordd = (ord + 16) / 32;
			ordd = Math.round(ordd);
				
			var number = ordd * 23 + abss + 1;	
    
			var value = document.getElementById("free"+number).innerHTML;
			if(value != 1)
			{
				var obj = document.getElementById("perso");	
				obj.style.marginTop = ord+'px';
				obj.style.backgroundImage="url('pictures/1-3.gif')";
				face = 1;
				setTimeout("move("+abs+","+ord+","+absmax+","+ordmax+","+absfirst+","+time+");", time);
			}else{
				blockord = 1;
			}
		}
	}	
	
	if((ord == ordmax && abs == absmax) || (blockabs == 1 && blockord == 1) || (ord == ordmax && blockabs == 1) || (abs == absmax && blockord == 1) || security > 4000)
	{
		var obj = document.getElementById("perso");
		if(face >= 1)
		{
			obj.style.backgroundImage="url('pictures/0-"+face+".gif')";			
		}
		dispo = 1;	
	}else if(abs == absmax && absfirst == 1)
	{
		setTimeout("move("+abs+","+ord+","+absmax+","+ordmax+",'0',"+time+");", time);
	}else if(ord == ordmax && absfirst == 0)
	{	
		setTimeout("move("+abs+","+ord+","+absmax+","+ordmax+",'1',"+time+");", time);
	}
	
		
}
