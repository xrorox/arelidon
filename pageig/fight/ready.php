<?php $fighter = new Fighter($char->getId(),$char->getFightId(),1);?>
<div id="ready_phase_container" style="width: 600px;margin:auto; ">

	<div style="display:none;">
		<div id="ready_phase" style="display:none">1</div>
		<div id="fight_id" style="display:none"><?php echo $_GET['fight_id']; ?></div>
		<div id="char_id" style="display:none"><?php echo $char->getId(); ?></div>
		<div id="need_refresh" style="display:none;">0</div>
	</div>

	<div style="">
		<?php 
		$ready_phase = 1; 
		$fight->loadFighterList();
		?>
		<table border="1" style="height:180px;width:400px;margin:auto;margin-top:10px;margin-bottom:10px;">
			<tr style="height:80px;">
				<!-- Affichage des monstres / team 2	-->
				<?php 
					
					$fighterList = $fight->getFighterList(2);
					
					foreach($fighterList as $fighter)
					{
						require("subview/fighter_container.php");
					}
				?>
			</tr>	
			<tr style="height:80px;">
				<!-- Affichage des invocs teams 2	-->
				<?php 
					
//					$fighterList = $fight->getFighterList(1);
//					
//					foreach($fighterList as $fighter)
//					{
//						require("fighter_container.php");
//					}
				?>
			</tr>	
			<tr style="height:80px;">
				<!-- Affichage des invoc team 1	-->
				<?php 
					
//					$fighterList = $fight->getFighterList(1);
//					
//					foreach($fighterList as $fighter)
//					{
//						require("fighter_container.php");
//					}
				?>
			</tr>	
			<tr style="height:80px;">
				<!-- Affichage des joueurs	-->
				<?php 
					$fighterList = $fight->getFighterList(1);
					
					foreach($fighterList as $fighter)
					{
						require("subview/fighter_container.php");
					}
				?>
			</tr>			
		</table>
	</div>

	<div style="text-align:center">
            <input type="button" value=" Prêt " onclick="setReady(<?php echo "'",$char->getId(),"','",$fighter->getPlace(),"'"; ?>);" />
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        setInterval("checkIsAllReady();",1000);
        
    });

</script>

