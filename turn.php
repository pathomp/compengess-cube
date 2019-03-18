<?php
include('cube_util.php');
$rp = new StdClass;
if (!isset($_GET['g'])) {
    $rp->status = 0;
    $rp->msg = 'Missing parameter';
} else {
    $gid = 'g'.trim($_GET['g']);
    $error_code = 0;
    $data = getCubeData($gid, $error_code);
    if ($data===false) {
        $rp->status = 0;
        if ($error_code==1) {
            $rp->msg = 'Cube file not found';
        } elseif ($error_code==2) {
            $rp->msg = 'Cannot open cube file';
        } elseif ($error_code==3) {
            $rp->msg = 'Cube data is invalid';
        } else {
            $rp->msg = 'Unknown error';
        }
    } else {
        if (!isset($_GET['token'])) {
            $rp->status = 0;
            $rp->msg = 'Missing token';
            $write_success = writeCubeData($gid, $data->state, $data->token, false, true);
        } elseif ($_GET['token']!=$data->token) {
            if ($data->init===true) {
                $rp->status = 2;
            } else {
                $rp->status = 0;
                $rp->msg = 'Invalid token';
                $write_success = writeCubeData($gid, $data->state, $data->token, false, true);
            }
        } else {
            $new_token = getNewToken();
            $new_state = ($data->state+1)%2;
            $write_success = writeCubeData($gid, $new_state, $new_token);

            if ($write_success===false) {
                $rp->status = 0;
                $rp->msg = 'Error writing cube file';
            } else {
                $rp->status = 1;
                $rp->token = $new_token;
            }
        }
    }
}
$fields = array();
$fields[] = $_SERVER['REMOTE_ADDR'];
$fields[] = date('d-m-y h:i:s');
$fields[] = $_GET['g'];
$fields[] = $rp->status;
$fields[] = isset($rp->token)?$rp->token:'';
$fields[] = isset($rp->msg)?$rp->msg:'';
$fields[] = $_SERVER['QUERY_STRING'];
logRequest($fields);
print json_encode($rp);
