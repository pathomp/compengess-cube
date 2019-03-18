<!DOCTYPE html>
<?php
include('cube_util.php');
global $cubes;
session_start();
if (isset($_GET['room'])) {
    $room =  intval($_GET['room']);
} else {
    $room = 401;
}
$cubes = getCubes($room);
initCubeFiles($cubes);

function renderPanels()
{
    global $cubes;
    $ct = '';
    foreach ($cubes as $gid => $groupname) {
        $ct .= renderCube($gid);
    }
    return $ct;
}

function renderCube($gid)
{
    global $cubes;
    $ct = '';
    $ct .= '<div class="grouppanel" data-gid="'.$gid.'" data-init="'.getInitToken($gid).'">';
    $ct .= '  <div class="cubepanel">';
    $ct .= '    <div class="cube"><div class="cube-inner">';
    $ct .= '      <div class="face front"></div>';
    $ct .= '      <div class="face back"></div>';
    $ct .= '      <div class="face top"></div>';
    $ct .= '      <div class="face bottom"></div>';
    $ct .= '      <div class="face right"></div>';
    $ct .= '      <div class="face left"></div>';
    $ct .= '    </div></div>';
    $ct .= '  </div>';
    $ct .= '  <div class="groupname">'.$cubes[$gid].'</div>';
    $ct .= '</div>';
    return $ct;
}
?>
<html>
    <head>
        <title>Spinning Cubes | Room # <?php print $room; ?></title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="style.css"/>
        <script src="jquery/jquery-1.12.4.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <div class="container" id="maincontainer" data-room="<?php print $room; ?>">
            <div id="roomlabel">Room # <?php print $room; ?></div>
            <?php print renderPanels();?>
            <div id="countdown"><i class="fa fa-clock-o"></i> <span id="timeleft"></span> s.<br/>until refresh</div>
        </div>
    </body>
</html>
