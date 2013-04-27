function selectClass(id)
{
    var old = $('#selected-class').val();
	
    if(old != 0)
    {
        $("#class-div-"+old).removeClass("div-with-cadre-selected");
    }
	
    $("#class-div-"+id).addClass("div-with-cadre-selected");
    $('#selected-class').val(id);
	
    if($('#selected-sex').val() == 0)
        selectSex(1);

    checkSexForClass(id);
    refreshPicture();
    refreshInfo();
}

function selectSex(number)
{
    var old = $('#selected-sex').val();
	
    if(old != 0)
    {
        $("#sex-div-"+old).removeClass("div-with-cadre-selected");
    }	
	
    $("#sex-div-"+number).addClass("div-with-cadre-selected");
    $('#selected-sex').val(number);
	
    refreshPicture();
}

function selectFaction(id)
{
    var old = $('#selected-faction').val();
	
    if(old != 0)
    {
        $("#faction-"+old).removeClass("selected-faction");
    }	
	
    $("#faction-"+id).addClass("selected-faction");
    $('#selected-faction').val(id);
	
    refreshInfo();
}

function refreshPicture()
{
    HTTPTargetCall("page/new_char_form/picture.php?class="+$('#selected-class').val()+"&sex="+$('#selected-sex').val(),"picture-container");
}

function refreshInfo()
{
    if($('#selected-class').val() != 0)
    {
        HTTPTargetCall("page/new_char_form/infoClass.php?class="+$('#selected-class').val(),'class-info-container');
    }
	
    if($('#selected-faction').val() != 0)
    {
        HTTPTargetCall("page/new_char_form/infoFaction.php?faction="+$('#selected-faction').val(),'faction-info-container');
    }
}

function checkSexForClass(class_id)
{
	
    if(class_id == 5 || class_id == 8)
    {
        $("#sex-div-1").removeClass("hide");
        $("#sex-div-2").addClass("hide");
        // Pas de sexe F
        if($('#selected-sex').val() == 2)
            selectSex(1);
		
    }else if(class_id == 6)
    {
        // Pas de sexe H
        $("#sex-div-1").addClass("hide");
        $("#sex-div-2").removeClass("hide");
		
        if($('#selected-sex').val() == 1)
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
    var class_id = $('#selected-class').val();
    var sex_id = $('#selected-sex').val();
    var faction_id = $('#selected-faction').val();
    var char_name = $('#char-name').val();
	
    var url = "page/new_char_form/createChar.php?char_name="+char_name+"&classe="+class_id+"&sex="+sex_id+"&faction="+faction_id;
    HTTPTargetCall(url,"post_container_response","",false);
        
    $.get(url,null,
        function(data){
            if(data == 'true')
            {
                window.location.href = "index.php?page=selectchar";
            }
            else
            {
                alert("Une erreur est survenue veuillez vérifier que tous les champs sont correctement remplis");
            }
        });
}

function checkCreateCharForm()
{
    checkCharNameAvailable($('#char-name').val());
	
    if($('#selected-class').val() != 0)
    {
        if($('#selected-faction').val() != 0)
        {
            if($('#char-name').val() != 'Nom du personnage' 
                && $('#char-name').val() != ''
                && $('#char-name').val() != ' ')
                {
                if($('#login_free').val() == 0)
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

