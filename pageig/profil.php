<?php
/*
 * Created on 4 sept. 2009
 *


 */
if(empty($_GET['mode'])) $_GET['mode'] = 'Profil';

$action = $_GET['action'];

	$menu = array('Profil','Comp&eacute;tences','Inventaire','M&eacute;tiers');
	 
	echo '<div style="text-align:center;margin-bottom:-10px;margin-top:-5px;">';
		echo '<table class="onglet_container" align="center" cellspacing="3" style="width:650px;"><tr>';
                $i = 1;
		foreach($menu as $onglet)
		{
			
			$style="min-width:20%;height:30px;font-size:18px;font-weight:700;margin:0px;";
			echo '<td class="onglet" id="" style="'.$style.'background-image:url(\'pictures/utils/boutonMenu.png\');width:170px;padding-top:4px;">';
				
                       
                            $class="cap_onglet";
				echo '<li class="'.$class.'" title="'.$onglet.'">';
					echo $onglet;
				echo '</li>';
			echo '</td>';
                        $i++;
		}
		echo '</tr></table>';
	echo '</div>';	
	echo '<hr />';

        echo '<input type="hidden" id="choosed" value="'.$_GET['mode'].'" />';
        
	echo '<div id="Profil" style="display:none;" class="cap_content">';
		require_once('profil/default.php');
	echo '</div>';
	
	echo '<div id="Inventaire" style="display:none;" class="cap_content">';
		require_once('profil/inventaire.php');
	echo '</div>';
	
	echo '<div id="Compétences" style="display:none;" class="cap_content">';
		require_once('profil/competences.php');
	echo '</div>';
//	
//	echo '<div id="Métiers" style="display:none;" class="cap_content">';
//		require_once('profil/mes_metiers.php');
//	echo '</div>';
	
	


?>
<script text="text/javascript">

    $(document).ready()
    {
        var category = $('#choosed').val();
        $('#' + category).css('display','block');
        $("li[title='" + category + "']").addClass('cap_active');
        
        
        // Lorsqu'on clique sur un onglet
        $(".cap_onglet").click(   function () {
            // On les met tous en inactif
            var contenu_del = $(".cap_active").attr("title");
            var contenu_aff = $(this).attr("title");
            
            $("#" + contenu_del).css("display","none");
            $("#" + contenu_aff).css("display","block");
//            $("#" + contenu_del).slideUp('fast',function()
//            {
//                $("#" + contenu_aff).slideDown('fast');
//            });
            $(".cap_active").removeClass("cap_active");
 
            // On met l'onglet cliqué en actif
            $(this).addClass("cap_active");
            
 
            // On cache toutes les boîtes de contenu
            
 
            // On affiche la boîte de contenu liée à notre onglet
            
            	
        }
        
        
        
        )};
</script>