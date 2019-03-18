<?php
include('cube_util.php');
$rp = new StdClass;
if (!isset($_POST['cmd'])||!isset($_POST['room'])) {
    $rp->status = 0;
    $rp->msg = 'Missing parameters';
} else {
    if ($_POST['cmd']=='getstates') {
        $cube_data = array();
        $cubes = getCubes(intval($_POST['room']));
        foreach ($cubes as $gid => $groupname) {
            $error_code = 0;
            $cube_data[$gid]['data'] = getCubeData($gid, $error_code);
            $cube_data[$gid]['error_code'] = $error_code;
        }
        $rp->status = 1;
        $rp->data = $cube_data;
    } else {
        $rp->status = 0;
        $rp->msg = 'Unknown command';
    }
}
print json_encode($rp);
