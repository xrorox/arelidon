<?php
$min = (!empty($_GET['min'])) ? $_GET['min'] : 0;
$max = (!empty($_GET['max'])) ? $_GET['max'] : 15;

require_once($server.'class/bug.class.php');

//$bug_list = bug_report::getAllBugReport('*', $min, $max);
$bug_list = bug::getAllBugReports($server."bug_report/to_do");
?>
<fieldset>
    <legend> Bug postés par les admins.</legend>
<table class="backgroundBodyNoRadius" cellspacing="0">

    <tr class="backgroundMenuNoRadius" style="text-align:center;">
        <td>
            Liste de messages
        </td>
    </tr>

<?php foreach($bug_list as $bug):

        
    ?>


    <div id="supr" class="backgroundMenuNoRadius" style="z-index:1;font-weight:700;padding-left:15px;cursor:pointer;margin-top:10px;" onclick="show('message_text_<?php echo $bug->getId() ?>');" >';
         Bug de <?php $bug->getCharName() ?>,Type de bug :<?php echo $bug->displayType()?> , Le <?php echo $bug->getDate()?>
        <div id="message_text_<?php $bug->getId()?>" style="padding-left:30px;padding-right:30px;padding-top:5px;display:none;">
             <?php $bug->getText(); ?>
            <br/>
            <br/>
            Navigateur : <?php echo $bug->getNavigator(); ?>
            </div>

        <th>
              <img style="float:right;" src="pictures/icones/deconnection.gif" alt="y a un bogue mon cher watson" onclick="HTTPTargetCall('gestion/bugs/suprbug.php?idBugReport=<?php $bug->getId() ?>','supr');" />	
            </th>



        </tr>
        </div>
    <?php endforeach; ?>

    </table>
</fieldset>

<fieldset>
    <legend>Ajouter un bug.</legend>
    
    <div id="add_bug">
        <button onclick="HTTPTargetCall('gestion/bugs/add_bug.php', 'add_bug')"> Ajoutez un bug.</button> 
    </div>
</fieldset>