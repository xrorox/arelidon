<?php 
	require_once("../../class/faction.class.php");

	if(!empty($_GET['faction'])): ?>
		<table class="width120 marginAuto">
                    <tr>
			<td class="alignTop width120">
			<!-- Left menu, selection of class / sexe / faction -->
				<table class="width120" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="top-left"></td>				
                                        <td class="top-middle"></td>
                                        <td class="top-right"></td>
				
                                    </tr>
                                    <tr>
                                        <td class="middle-left"></td>	
                                        <td class="middle">
                                            <img id="faction-1" src="pictures/faction/<?php echo $_GET['faction'];?>-24.png" alt="" class="left marginLeft6 width16 heigth16 border1grey"/>
                                            <div style="float:left;margin-left:6px;">	<?php echo faction::getFactionText($_GET['faction']);?></div>	
                                        </td>
                                        <td class="middle-right"></td>
                                    </tr>
                                    <tr>
                                        <td class="bottom-left"></td>
                                        <td class="bottom-middle"></td>
                                        <td class="bottom-right"></td>
                                    </tr>
                                </table>
                        </td>
		</tr>
            </table>	
		
            <table class="width120 marginAuto marginTop-8">
                <tr>
                    <td class="alignTop width120 marginAuto">
		<!-- Left menu, selection of class / sexe / faction -->
                        <table style="width: 120px;" cellpadding="0" cellspacing="0">
                            <tr>
				<td class="top-left"></td>
				<td class="top-middle"></td>
				<td class="top-right"></td>
                            </tr>
                            <tr class="heigth140">
                                <td class="middle-left"></td>
                                <td class="middle" class="alignTop paddingTop5">
                                    <?php echo faction::getDescription($_GET['faction']);?>
                                    <br /><br />
                                    <u> Bonus : </u><br />
                                    <?php echo faction::getBonus($_GET['faction']);?></td>
				<td class="middle-right"></td>
                            </tr>
                            <tr>
                                <td class="bottom-left"></td>
                                <td class="bottom-middle"></td>
                                <td class="bottom-right"></td>
                            </tr>
                    </table>
		</td>
	</tr>
</table>		
		
<?php 	endif ?>
