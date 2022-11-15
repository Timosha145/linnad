<?php
require_once('connect.php');
global $yhendus;

if (isset($_REQUEST['lisamisVorm']) && !empty($_REQUEST['linn']))
{
    $paring=$yhendus->prepare("INSERT INTO linnad(linnaNimi, rahvastik, linnaPeaId) VALUES (?,?,?)");
    $paring->bind_param('sii', $_REQUEST['linn'], $_REQUEST['rahvastik'], $_REQUEST['linnapea']);
    $paring->execute();
}

if (isset($_REQUEST['kustuta']))
{
    $paring=$yhendus->prepare("DELETE FROM linnad WHERE id=?");
    $paring->bind_param('i', $_REQUEST['kustuta']);
    $paring->execute();
}


$paring=$yhendus->prepare("SELECT Id, linnaNimi, rahvastik, linnapea.linnaPea FROM linnad, linnapea where linnad.linnaPeaId=linnapea.linnaPeaId");
$paring->bind_result($id, $linnaNimi, $rahvastik, $linnaPea);
$paring->execute();


?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Linnad</title>
    <link rel="stylesheet" type="text/css" href="loomadLinkidegaStylw.css">
</head>
<body>
<header>
    <h1>Eesti Linnad</h1>
    <a style='font-size: 20pt; color: #A52A2A' href='https://github.com/Timosha145/linnad.git'>Github</a>
    <br>
</header>

<div id="menu">
    <h3>Linnade nimed</h3>
    <?php
    
    //näitab loomade loetelu tabelist loomad
    echo "<ul>";
    while($paring->fetch())
    {
        echo "<li><a href='?id=$id'>$linnaNimi</a></li>"; //htmlspecialchars - käsk nurksulgudes mis ei loetakse

    }
    echo "</ul>";
    echo "<a href='?jah'>Lisa linn</a>";


    ?>
</div>
<div id="line"></div>
<div id="info">
    <?php
    if (isset($_REQUEST['id']))
    {
        $paring=$yhendus->prepare("SELECT linnaNimi, rahvastik, linnapea.linnaPea FROM linnad, linnapea WHERE id=? && linnapea.linnaPeaId=linnad.linnaPeaId ");
        $paring->bind_param('i', $_REQUEST['id']);
        //küsimärki asemel aadressiribalt tuleb id
        $paring->bind_result( $linnaNimi, $rahvastik, $linnaPea);
        $paring->execute();

        //$paring=$yhendus->prepare("SELECT linnaPea FROM linnapea WHERE linnaPeaId=?");
        //$paring->bind_param('i', $linnaPeaId);
        //$paring->bind_result($linnaPea);
        //$paring->execute();


        if($paring->fetch())
        {
            echo "<div id='infoSisu'>"."<strong>Linn: </strong>".htmlspecialchars($linnaNimi)."<br>";
            echo "<strong>Rahvastik: </strong>".htmlspecialchars($rahvastik)." inimest<br>";
            echo "<strong>Linnapea: </strong>".htmlspecialchars($linnaPea)."<br>";
            echo "<a  style='font-size: 16pt; color: #A52A2A' href='?kustuta=".$_REQUEST['id']."'><strong>Kustuta</strong></a>";
            echo "</div>";
        }
    }

    else if (isset($_REQUEST['jah']))
    {
    ?>
        <h2>Uue linna lisamine</h2>

    <form name="uusLinn" method="post" action="?">
        <input type="hidden" name="lisamisVorm">
        <input type="text" name="linn" placeholder="Linn">
        <br>
        <label for="rahvastik">Rahvastik: </label>
        <input type="number" name="rahvastik" value="0" min="0">
        <br>
        <label for="Linnapea">Linnapea: </label>
        <input type="number" name="linnapea" value="1" min="1" max="2">
        <input type="submit" value="OK">
    </form>

    <?php
    }
    else
    {
        echo "<h3>Siia tuleb linnade informatsioon</h3>";
    }
    ?>

</div>


</body>
<?php
$yhendus->close();
?>
</html>
