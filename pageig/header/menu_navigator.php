
<div class="navigator_container" style="border:1px;">

	<div  class="nav-profil" style="">
		<?php
			$onclick = "cleanMenu();HTTPTargetCall('page.php?category=profil&mode=Profil','bodygameig');";
			echo '<img src="'.$char->getUrlPicture('mini').'" alt="" title="Profil" onclick="'.$onclick.'" style="width:20px;height:20px;" />';	
		?>
	</div>

	<div  class="float-menu-nav nav-home" style="">
		<a id="nav-home-pic" href="ingame.php" class="nav-pic" title="Retour"></a>
	</div>
	
	<div  class="float-menu-nav nav-inv" style="">
		<a id="nav-inv-pic" class="nav-pic" title="Inventaire" onclick="cleanMenu();HTTPTargetCall('page.php?category=profil&mode=Inventaire','bodygameig');"></a>
	</div>
	
	<div  class="float-menu-nav nav-guild" style="">
		<a id="nav-guild-pic" class="nav-pic" title="Guilde" onclick="cleanMenu();HTTPTargetCall('page.php?category=guilde','bodygameig');"></a>
	</div>
	
	<div  class="float-menu-nav nav-skill" style="">
		<a id="nav-skill-pic" class="nav-pic" title="Sorts" onclick="cleanMenu();HTTPTargetCall('page.php?category=profil&mode=Compétences','bodygameig');"></a>
	</div>
	
	<div  class="float-menu-nav nav-disc" style="">
		<a id="nav-disc-pic" class="nav-pic" href="index.php?page=selectchar" title="D&eacute;connexion"></a>
	</div>
	
	<div  class="float-menu-nav nav-quests" style="">
		<a id="nav-quests-pic" class="nav-pic" title="Qu&ecirc;tes" onclick="cleanMenu();HTTPTargetCall('page.php?category=quetes','bodygameig');"></a>
	</div>
	
	<div  class="float-menu-nav nav-world" style="">
		<a id="nav-world-pic" class="nav-pic" title="Carte du monde" onclick="cleanMenu();HTTPTargetCall('page.php?category=worldmap','bodygameig');"></a>
	</div>
	
	<div  class="float-menu-nav nav-message" style="">
		<a id="nav-message-pic" class="nav-pic" title="Messages" onclick="cleanMenu();HTTPTargetCall('page.php?category=messagerie','bodygameig');"></a>
	</div>


</div>
