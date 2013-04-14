nobash = 0;
keypress = 0;
var faceChar;
var needCleanMenu = 0;
var dispo_keyboard = 1;

function ejs_code_clavier(keyStroke)
{
var onmap;
var zoom = 0;
    if($('#onmap'))
		onmap = 1;
	else
		onmap = 0;
		
    ejs_code_eventChooser = (!document.all) ? keyStroke.which : event.keyCode;
	ejs_code_which = String.fromCharCode(ejs_code_eventChooser).toLowerCase();

	if((onmap == 1 && isSendMessage == 0 && can_move == 1) || ejs_code_eventChooser == 13)
	{
	    switch(ejs_code_eventChooser)
	    {
	    	case 83:
	    		move(1);
	    		faceChar = 1;
	    	break;
	       	case 65:
	    		move(2);
	    		faceChar = 2;
	    	break;
	    	case 87:
	    		move(3);
	    		faceChar = 3;
	    	break;
	    	case 68:
	    		move(4);
	    		faceChar = 4;
	    	break;
	    	case 67:
	    		move(5);
	    		faceChar = 1;
	    	break;
	    	case 90:
	    		move(6);
	    		faceChar = 1;
	    	break;
	    	case 69:
	    		move(7);
	    		faceChar = 3;
	    	break;
	    	case 81:
	    		move(8);
	    		faceChar = 3;
	    	break;
	    	case 82:
	    		HTTPTargetCall('pageig/header/hidden.php?shortcut=R','hiddenDiv');
	    		HTTPTargetCall('pageig/header/shortcuts.php?refresh=1','shortcuts');
	    	break;
	    	case 84:
	    		HTTPTargetCall('pageig/header/hidden.php?shortcut=T','hiddenDiv');
	    		HTTPTargetCall('pageig/header/shortcuts.php?refresh=1','shortcuts');
	    	break;
	    	// bouton entrer
	    	case 13:
	    		if($('#tchat_zoom_value'))
					zoom = 1;
								
				sendMessage($('#canal').html(),zoom);removeIsSendingMessage();
	    	break;
	    	
	    	
	    }
	    keypress = ejs_code_eventChooser;
	}
}


document.onkeydown = ejs_code_clavier;
    
  
function removeKeyPress()
{
	keypress = 0;
}  
    
document.onkeyup = removeKeyPress;