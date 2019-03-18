<!DOCTYPE html>

<?php
include('cube_util.php');
//$cubes502 = getCubes(502);
//$cubes504 = getCubes(504);
$cubes401 = getCubes(401);

function renderButtons($cubes)
{
    $ct = '';
    foreach ($cubes as $gid => $groupname) {
        $ct .= '<button data-gid="'.$gid.'" class="btn btn-primary turn-button" data-token="'.getInitToken($gid).'">'.$gid.'</button>';
    }
    return $ct;
}
?>
<html>
    <head>
        <title>Spinning Cubes | Remote Control</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="control_style.css"/>
        <script src="jquery/jquery-1.12.4.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="control_script.js"></script>
    </head>
    <body>
        <div class="container" id="maincontrol">
            <div class="alert alert-info" id="rp-panel"></div>
            <div class="row">
                <div class="col col-sm-6">
                    <div>Room # 401</div>
                    <?php print renderButtons($cubes401);?>
                </div>
                <!--<div class="col col-sm-6">
                    <div>Room # 504</div>
                    <?php //print renderButtons($cubes504);?>
                </div>-->
            </div>
        </div>
    </body>
</html>
