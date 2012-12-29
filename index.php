<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Theorie de la Sécurité</title>
        <link rel="stylesheet" href="style.css"/>
        <script src="js/jquery.js" type="text/javascript"></script><!-- Insertion de la bibliotheque jQuery -->
        <script type="text/javascript" src="js/localscroll/jquery.localscroll.js"></script>
        <script type="text/javascript" src="js/localscroll/jquery.scrollTo.js"></script>
        <script type="text/javascript" src="js/lancement.js"></script><!-- permet le lancement de la fonction de scroll -->
    </head>
    <body class="home">
        <div id="content" style="position:relative">
            <center><h1>Projet : Conception et analyse de protocoles cryptographiques</h1></center>
            <div id="connection">
                <?php
                    if (isset($_GET['error'])) {
                        echo "<div class=\"error\">".$_GET["error"]."</div>";
                    }
                ?>
                <form name="connection" method ="post" action="authen.php">                
                    <table>
                        <tr>
                            <td style="text-align: right;">Groupe :</td>
                            <td>
                                <select name='groupeId'>
                                    <?php
                                        include 'class/Groupe.php';
                                        foreach (Groupe::getGroupes("numero","ASC") as $g) {
                                             echo "<option value='".$g->getNumero()."'>Groupe ".$g->getNumero()."</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Mot de passe :</td>
                            <td><input type='password' name="password"/></td>
                        </tr>
                    </table>
                <input type="submit" value="Ok" style="float:right"/>
                </form>
                <div style="clear : both"></div>
            </div>

        </div>
    </body>
</html>