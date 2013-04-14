<div style="min-height:300px;">

    <div id="preview" style="float:left;width:30%;margin-left:30px;">
        <img src="pictures/utils/index.gif" style="margin-top:20px;"" alt="pas d image" title="Royaume d Ar�lidon" />
    </div>

    <div id="news" style="float:left;width:60%;margin-left:10px;">
        <!--Aperçu-->
        <fieldset style="min-height:300px;">
            <legend class="fontElfique" style="font-weight:700;font-size:16px;">

            </legend>
            <div id="bodypreview">
                <?php require_once('/include/bodypreview.php'); ?>
            </div>
        </fieldset>

    </div>

</div>

<!-- Indication si le site est en maintenance ou en ligne-->
<br/><h3 style="display:block;margin-left:250px;"> Serveur : 
    <?php if (admin::isInMaintenance()): ?>
        <span style = "color:red"> en maintenance </span>
    <?php else: ?>
        <span style = "color:green"> Online </span>
    <?php endif; ?>

</h3>

<div style="margin:30px;">
    <!--News-->
    <fieldset>
        <legend class="fontElfique" style="font-weight:700;font-size:16px;">
            News 
        </legend>
        <?php
        require_once($server . 'class/news.class.php');
        $array_news = news::getAllNews();
        foreach ($array_news as $news) {
            $news = new news($news['id']);
            $news->showNews();
        }
        ?>
    </fieldset>
</div>
