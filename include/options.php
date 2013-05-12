<div style="text-align:right;margin-top:0px;">

     <!--Signaler un bug-->
    <div style="float:left;width:32px;height:32px;background-image:url('pictures/utils/cadre32x32.png');margin:auto;margin-left:10px;cursor:pointer;">
        <div style="margin-right:8px;margin-top:8px;">
            <?php $url = "pageig/widget/signal_bug.php";
            $onclick="openPopup('$url','Signaler un bug','width=400,height=365,top=200,left=400');"; ?>
            <img src="pictures/icones/bug.gif" alt="Signaler un bug" title="Signaler un bug" onclick="<?php echo $onclick ?>" />
        </div>
    </div>

     <!--Plein ecran-->
    <div style="float:left;width:32px;height:32px;background-image:url('pictures/utils/cadre32x32.png');margin:auto;margin-left:5px;cursor:pointer;">
        <div style="margin-right:8px;margin-top:8px;">
            <?php $onclick = "self.close();window.open('ingame.php', 'WindowName', 'fullscreen,scrollbars');return(false); "; ?>
            <img src="pictures/icones/pleinecran.png" alt="Plein ecran" title="Jeu en plein ecran" onclick="<?php echo $onclick ?>" />
        </div>
    </div>
     <!--Allopass--> 
    <div style="float:left;width:32px;height:32px;background-image:url('pictures/utils/cadre32x32.png');margin:auto;margin-left:5px;cursor:pointer;">
        <div style="margin-right:6px;margin-top:7px;">
            <?php $onclick = "window.location.href='ingame.php?page=allopass';"; ?>
            <img src="pictures/utils/phone.png" alt="?" title="Allopass" onclick="<?php echo $onclick ?>" style="width:16px;height:16px;" />
        </div>
    </div>

     <!--R?glages-->
    <div style="float:left;width:32px;height:32px;background-image:url('pictures/utils/cadre32x32.png');margin:auto;margin-left:5px;cursor:pointer;">
        <div style="margin-right:3px;margin-top:5px;">
            <?php $onclick = "HTTPTargetCall('page.php?category=regulating','bodygameig')"; ?>
            <img src="pictures/icones/regulating.gif" alt="R?glages" title="R?glages" onclick="<?php echo $onclick ?>" />
        </div>
    </div>

</div>

