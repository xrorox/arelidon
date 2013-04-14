<?php
$index = 1;
$pageindex = 'onindex';

require_once('require.php');


if (isset($_GET['page'])) {

    if ($_GET['page'] == "selectchar") {
        require_once('savelog.inc.php');
    } else {
        $index = 0;
    }
}

include($server . 'deb.inc.php');
?>

<?php include($server . 'js/alljs.php'); ?>

<?php include($server . 'css/allcss.php'); ?>
<script type="text/javascript" src="js/screenshot_viewer-1.0.js"></script>


<meta name="google-site-verification" content="TDRE4t3ZGQhG0TkjnnPH8uKoy80yrY9aQqwyKF-GXfY" />
<title>Irelion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">

</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="1004" height="785" border="0" align="center" cellpadding="0" cellspacing="0" id="Tableau_01" bgcolor="#000000">
        <tr>
            <td colspan="3" border="0" style="border:0px;font-size:0px;">
                <img src="pictures/horscadre_01.jpg" style="border:0px;font-size:0px;" width="1004" height="26" alt="">
            </td>
        </tr>
        <tr border="0">
            <td valign="top" border="0" style="font-size:0px;"><img src="pictures/horscadre_02.jpg" width="112" height="753" alt=""></td>

            <!-- Debut Design Erardork war II (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

            <td valign="top">
                <table width="780" border="0" cellspacing="0" cellpadding="0">
                    <tr border="0">
                        <td style="height:100%;margin:0px;font-size:0px;" border="0">
                            <img src="pictures/head_03.jpg" width="780" height="276" style="border: 0px;margin:0px;" alt="">
                        </td>
                    </tr>
                    <tr>

                        <!-- Debut du design (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                        <td><table width="780" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td background="pictures/centrepage_11.jpg" width="33" height="390"></td>
                                    <td background="pictures/bg_16.jpg" width="713" height="19">
                                        <table width="713" border="0" cellspacing="0" cellpadding="0">
                                            <tr>

                                                <!-- Debut du centre page (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                                                <!-- Debut de la navigation (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                                                <td valign="top">
                                                    <?php include("include/menu.php"); ?> 
                                                </td>

                                                <td width="8"></td>

                                                <td valign="top" width="530">

                                                    <?php
                                                    if (!isset($_GET['page'])) {
                                                        include($server . 'page/home.php');
                                                    } else {
                                                        include($server . 'page/' . $_GET['page'] . '.php');
                                                    }
                                                    ?>

                                                </td>

                                                <!-- Fin du centre page (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->



                                                <!-- Fin de la navigation (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                                            </tr>
                                        </table></td>
                                    <td background="pictures/centrepage_15.jpg" width="34" height="390"></td>
                                </tr>
                            </table></td>

                        <!-- Fin du design (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                    </tr>
                    <tr>

                        <!-- Debut du footer (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                        <td><table width="780" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td background="pictures/footer_12.jpg" width="780" height="16"><div align="center" class="Style4">- Copyright  2011 - </div></td>
                                </tr>
                                <tr>
                                    <td><img src="pictures/footer_13.jpg" width="780" height="31" alt=""></td>
                                </tr>
                            </table></td>

                        <!-- Fin du footer (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

                    </tr>
                </table></td>

            <!-- Fin Design Erardork war II (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->

            <td valign="top"><img src="pictures/horscadre_04.jpg" width="112" height="753" alt=""></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>

    <!-- End ImageReady Slices -->

</body>
</html>