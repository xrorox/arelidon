<?php require_once("widgets/IrelionContainer.class.php"); ?>

<div class="nodisplay">
	<div id="post_container_response" class="nodisplay"></div>
</div>

<table class="width90P marginAuto">
    <tr>
        <td class="alignTop width120">
        <!-- Left menu, selection of class / sexe / faction -->
            <table style="width: 120px;margin:auto;" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="top-left"></td>
                    <td class="top-middle"></td>
                    <td class="top-right"></td>
		</tr>
		<tr>
                    <td class="middle-left"></td>
                    <td class="middle"><?php include("classPanel.php"); ?></td>
                    <td class="middle-right"></td>
		</tr>
		<tr>
                    <td class="middle-left"></td>
                    <td class="middle"> <div id="sexPanel"> <?php include("sexPanel.php"); ?> </div> </td>
                    <td class="middle-right"></td>
		</tr>
		<tr>
                    <td class="middle-left"></td>
                    <td class="middle"> <div id="sexPanel"> <?php include("factionPanel.php"); ?></div></td>
                    <td class="middle-right"></td>
		</tr>
		<tr>
                    <td class="bottom-left"></td>
                    <td class="bottom-middle"></td>
                    <td class="bottom-right"></td>
		</tr>
              </table>
            </td>
	<td class="alignTop">
            <table class="width230 marginAuto">
                <tr class="heigth300 paddingTop70">
                    <td> <div id="picture-container" class="center"></div> </td>
                </tr>
                <tr>
                    <td class="center">
                    <input id="char-name" type="text" 
                        onclick="if(this.value == 'Nom du personnage'){ this.value = '';}" 
                        onblur="checkCharNameAvailable(this.value);" 
                        value="Nom du personnage" 
                        class="center width180"/>
                    <div class="right nodisplay">
                        <div id="char-name-available" class="nodisplay right"></div>
                    </div>
                    <br />
                    <input type="button" 
                        value="Créer le personnage" 
                        onclick="checkCreateCharForm();" 
                        class="marginTop5 font11"/>
                    <br />
                    <input type="button" 
                        value="Annuler" 
                        onclick="window.location.href='index.php?page=selectchar';" 
                        class="marginTop5 font11"/>
                    </td>
                </tr>
            </table>
	</td>
	<td class="alignTop width170">
            <table class="marginAuto">
                <tr>
                    <td> <div id="class-info-container" class="width150 center marginAuto heigth130"></div></td>
                </tr>
                <tr>
                    <td class="center marginTop30"> <div id="faction-info-container" class="center heigth250"> </div></td>
                </tr>
            </table>
	</td>
    </tr>
</table>