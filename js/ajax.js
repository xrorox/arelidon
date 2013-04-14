// Fonction d'appel ajax
function loadInDiv(url,id)
{
	
	var xhr_object = null;
	var position = id;
	if(window.XMLHttpRequest) xhr_object = new XMLHttpRequest();
	else
	if (window.ActiveXObject) xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	
	// On ouvre la requete vers la page d�sir�e
	xhr_object.open("GET", url, true);
	xhr_object.onreadystatechange = function(){
		if ( xhr_object.readyState == 4 )
		{
			// j'affiche dans la DIV sp�cifi�es le contenu retourn� par le fichier
			if(document.getElementById(position).innerHTML != xhr_object.responseText)
				document.getElementById(position).innerHTML = xhr_object.responseText;
		}
	}
	// dans le cas du get
	xhr_object.send(null);

}

function HTTPTargetCall(url,target,waiter,nosyncro,datatype)
{
    
   if(target == "update_position")  
       $('#'+target).load("pageig/move/move.php","die=0,changemap=1,abs=1,ord=1");
   
       $('#'+target).load(url);
}



function HTTPPostCall(url,form,target,waiter,content,nosyncro,allform)
	{
		var retval;

		if(waiter)
		{
			var waiting_button = document.getElementById(waiter);
			waiting_button.innerHTML = '<img id="waiting" src="@assets.url@/icons/ajax-loader3.gif" style="padding:5px;"/>';
		}		
		
		if(nosyncro)
		{
			if(allform)
				var args = jQuery.extend($("#"+form+" :input"),content);
			else	
			if(content)
				var args = jQuery.extend($("#"+form+" :not(input:checkbox,input:radio),:input:checkbox:checked,:input:radio:checked"),content);
			else
				var args = $("#"+form+" :not(input:checkbox,input:radio),:input:checkbox:checked,:input:radio:checked");

			args = $("#"+form+" :input");
			$.post(url,args,function(data)
			{
				if(target != '')
				{
					if(waiting_button)
						waiting_button.innerHTML = '';
					document.getElementById(target).innerHTML = data;
					$("#"+target).show("slow");
				}
			},"html");
		}
		else
		{
			if(allform)
				var args = jQuery.extend($("#"+form+" :input"),content);
			else
			if(content)
				var args = jQuery.extend($("#"+form+" :not(input:checkbox,input:radio),:input:checkbox:checked,:input:radio:checked"),content);
			else
				var args = $("#"+form+" :not(input:checkbox,input:radio),:input:checkbox:checked,:input:radio:checked,select option:selected");

			$.ajax(
				{
					type: "POST",
				   	url: url,
				   	data:args,
				   	success: function(msg){ 
								if(waiting_button)
									waiting_button.innerHTML = '';
				   				if(target != '')
				   				{
				   					document.getElementById(target).innerHTML = msg;
					   				$("#"+target).show("slow");
				   				}
				   				retval=msg;
				   				msg = null;
							},
				   	async:false
				}
			);
		}
		waiting_button = null;
		target = null;
		args = null;
		return retval;
	}
