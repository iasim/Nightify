<?
	//Database Info
	$db_user = 'asim_nightify';
	$db_pass = 'S-S.8=[p-U)A';
	$db_name = 'asim_nightify';
	$db_host = 'localhost';

	$connection = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die(mysqli_error($connection));
?>
<?
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
?>
