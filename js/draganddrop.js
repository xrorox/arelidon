function loadDragAndDrop()
{

	$(".draggable_content img").draggable({	// enable all product images to be dragged
	
	containment: 'document',
	opacity: 0.6,
	revert: 'invalid',
	helper: 'clone',
	zIndex: 100
	
	});

	$("div.content.drop-here").droppable({	// fonction drop de base
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					alert(param);
				}
	});

	$("div.content.compt_back").droppable({	// retirer un objet des raccourcis
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					removeSkill(param);
				}
	});

	$("div.content.compt0").droppable({	// Ajouter un skill en raccourcis 1
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					addSkill(param,0);
				}
	});

	$("div.content.compt1").droppable({	// Ajouter un skill en raccourcis 1
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					addSkill(param,1);
				}
	});
	
	$("div.content.compt2").droppable({	// Ajouter un skill en raccourcis 2
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					addSkill(param,2);
				}
	});

	$("div.content.compt3").droppable({	// Ajouter un skill en raccourcis 2
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					addSkill(param,3);
				}
	});

	$("div.content.compt4").droppable({	// Ajouter un skill en raccourcis 2
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					addSkill(param,4);
				}
	});
	
	$("div.content.compt5").droppable({	// Ajouter un skill en raccourcis 2
			drop:
				function(e, ui)
				{
					var param = $(ui.draggable).attr('id');
					addSkill(param,5);
				}
	});
	
}

function removeSkill(skill_id)
{
	var url = "competences_frame.php?remove_skill=1&skill_id="+skill_id;
	HTTPTargetCall(url,'frame_competence');
}

function addSkill(skill_id,place)
{
	var url = "competences_frame.php?add_skill=1&skill_id="+skill_id+"&place="+place;
	HTTPTargetCall(url,'frame_competence');
}

function loadDragAndDropAuto()
{
	loadDragAndDrop();
	setTimeout("loadDragAndDropAuto();", 1500);
}
