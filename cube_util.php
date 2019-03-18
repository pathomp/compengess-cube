<?php
date_default_timezone_set('Asia/Bangkok');
function getCubePath($gid)
{
    $root = __DIR__;
    return $root.'/data/'.$gid.'.cube';
}
function getCubes($room)
{
    $cubes = array();
    /*if ($room == 504) {
        // 1 - 16
        for ($i=1; $i<=16; $i++) {
            $cubes[strval('g'.$i)] = 'Group '.$i;
        }
    } else {
        // 17 - 32
        for ($i=17; $i<=32; $i++) {
            $cubes[strval('g'.$i)] = 'Group '.$i;
        }
    }*/

    for ($i=1; $i <= 19; $i++) {
        $cubes[strval('g'.$i)] = 'Group '.$i;
    }

    return $cubes;
}
function getCubeData($gid, &$error_code)
{
    $error_code = 0;
    $filename = getCubePath($gid);
    if (file_exists($filename)===true) {
        $handle = fopen($filename, 'r');
        $ct = fread($handle, filesize($filename));
        fclose($handle);
        if ($ct===false) {
            $error_code = 2;
            return false;
        } else {
            $data = json_decode($ct);
            if ($data===false) {
                $error_code = 3;
                return false;
            } else {
                return $data;
            }
        }
    } else {
        $error_code = 1;
        return false;
    }
}
function writeCubeData($gid, $state, $token, $init=false, $error=false)
{
    echo($gid);
    $filename = getCubePath($gid);
    $cubefile = fopen($filename, 'w');
    $data = new StdClass;
    $data->state = $state;
    $data->token = $token;
    $data->init = $init;
    $data->error = $error;
    $ct = json_encode($data);
    $success = fwrite($cubefile, $ct);
    fclose($cubefile);
    return $success;
}
function initCubeFiles($cubes)
{
    foreach ($cubes as $gid => $groupname) {
        $state = 0;
        $token = getInitToken($gid);
        writeCubeData($gid, $state, $token, true);
    }
}
function getInitToken($gid)
{
    $dict  = "UAE39USEKKJSIVKL32451UEKDMHSKFI12837J73LPWJEHDNFJSKJIOEK2J1K24AC";
    $dict .= "ERTYUITHWE789U3481746ERNXSD1984IUE74KJ387EUJRK3647K3L4H5SUIT2559";
    $groupno = intval(substr($gid, 1));
    $token = substr($dict, ($groupno-1)*4, 4);
    return $token;
}
function getNewToken()
{
    $dict = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $token_length = 4;
    $token = '';
    for ($i=1; $i<=$token_length; $i++) {
        $idx = rand(0, strlen($dict)-1);
        $token = $token.substr($dict, $idx, 1);
    }
    return $token;
}
function logRequest($fields)
{
    $root = __DIR__;
    $filename = $root.'/data/request_'.date('d-M-Y').'.log';
    $logfile = fopen($filename, 'a');
    fputcsv($logfile, $fields);
    fclose($logfile);
}
