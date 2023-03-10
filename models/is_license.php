<?php
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$CMSNT = new DB();
function checkWhiteDomain($domain){
    $domain_white = [
        'muafb.net',
        'trongclone.com',
        'uyenclone.com',
        'shopviafb24h.com',
        'storerobloxvn.com',
        'fptvclone.com',
        'nksport.vn',
        'sellfb247.com',
        'accrunner.com',
        'adsygo.com',
        '250fb.com',
        'funcatz.info'
    ];
    foreach($domain_white as $row){
        if($row == $domain){
            return true;
        }
    }
    return false;
}
function CMSNT_check_license($licensekey, $localkey='') {
    global $config;
    $whmcsurl = 'https://client.cmsnt.co/';
    $licensing_secret_key = $config['project'];
    $localkeydays = 15;
    $allowcheckfaildays = 5;
    $check_token = time() . md5(mt_rand(100000000, mt_getrandmax()) . $licensekey);
    $checkdate = date("Ymd");
    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(__FILE__);
    $verifyfilepath = 'modules/servers/licensing/verify.php';
    $localkeyvalid = false;
    if ($localkey) {
        $localkey = str_replace("\n", '', $localkey); # Remove the line breaks
        $localdata = substr($localkey, 0, strlen($localkey) - 32); # Extract License Data
        $md5hash = substr($localkey, strlen($localkey) - 32); # Extract MD5 Hash
        if ($md5hash == md5($localdata . $licensing_secret_key)) {
            $localdata = strrev($localdata); # Reverse the string
            $md5hash = substr($localdata, 0, 32); # Extract MD5 Hash
            $localdata = substr($localdata, 32); # Extract License Data
            $localdata = base64_decode($localdata);
            $localkeyresults = json_decode($localdata, true);
            $originalcheckdate = $localkeyresults['checkdate'];
            if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - $localkeydays, date("Y")));
                if ($originalcheckdate > $localexpiry) {
                    $localkeyvalid = true;
                    $results = $localkeyresults;
                    $validdomains = explode(',', $results['validdomain']);
                    if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validips = explode(',', $results['validip']);
                    if (!in_array($usersip, $validips)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validdirs = explode(',', $results['validdirectory']);
                    if (!in_array($dirpath, $validdirs)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                }
            }
        }
    }
    if (!$localkeyvalid) {
        $responseCode = 0;
        $postfields = array(
            'licensekey' => $licensekey,
            'domain' => $domain,
            'ip' => $usersip,
            'dir' => $dirpath,
        );
        if ($check_token) $postfields['check_token'] = $check_token;
        $query_string = '';
        foreach ($postfields AS $k=>$v) {
            $query_string .= $k.'='.urlencode($v).'&';
        }
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $whmcsurl . $verifyfilepath);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $responseCodePattern = '/^HTTP\/\d+\.\d+\s+(\d+)/';
            $fp = @fsockopen($whmcsurl, 80, $errno, $errstr, 5);
            if ($fp) {
                $newlinefeed = "\r\n";
                $header = "POST ".$whmcsurl . $verifyfilepath . " HTTP/1.0" . $newlinefeed;
                $header .= "Host: ".$whmcsurl . $newlinefeed;
                $header .= "Content-type: application/x-www-form-urlencoded" . $newlinefeed;
                $header .= "Content-length: ".@strlen($query_string) . $newlinefeed;
                $header .= "Connection: close" . $newlinefeed . $newlinefeed;
                $header .= $query_string;
                $data = $line = '';
                @stream_set_timeout($fp, 20);
                @fputs($fp, $header);
                $status = @socket_get_status($fp);
                while (!@feof($fp)&&$status) {
                    $line = @fgets($fp, 1024);
                    $patternMatches = array();
                    if (!$responseCode
                        && preg_match($responseCodePattern, trim($line), $patternMatches)
                    ) {
                        $responseCode = (empty($patternMatches[1])) ? 0 : $patternMatches[1];
                    }
                    $data .= $line;
                    $status = @socket_get_status($fp);
                }
                @fclose ($fp);
            }
        }
        if ($responseCode != 200) {
            $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - ($localkeydays + $allowcheckfaildays), date("Y")));
            if ($originalcheckdate > $localexpiry) {
                $results = $localkeyresults;
            } else {
                $results = array();
                $results['status'] = "Invalid";
                $results['description'] = "Remote Check Failed";
                return $results;
            }
        } else {
            preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches);
            $results = array();
            foreach ($matches[1] AS $k=>$v) {
                $results[$v] = $matches[2][$k];
            }
        }
        if (!is_array($results)) {
            die("Invalid License Server Response");
        }
        if (isset($results['md5hash'])) {
            if ($results['md5hash'] != md5($licensing_secret_key . $check_token)) {
                $results['status'] = "Invalid";
                $results['description'] = "MD5 Checksum Verification Failed";
                return $results;
            }
        }
        if ($results['status'] == "Active") {
            $results['checkdate'] = $checkdate;
            $data_encoded = json_encode($results);
            $data_encoded = base64_encode($data_encoded);
            $data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
            $data_encoded = strrev($data_encoded);
            $data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
            $data_encoded = wordwrap($data_encoded, 80, "\n", true);
            $results['localkey'] = $data_encoded;
        }
        $results['remotecheck'] = true;
    }
    unset($postfields,$data,$matches,$whmcsurl,$licensing_secret_key,$checkdate,$usersip,$localkeydays,$allowcheckfaildays,$md5hash);
    return $results;
}
function checkLicenseKey($licensekey){
    $results = CMSNT_check_license($licensekey, '');
    if($results['status'] == "Active"){   
        $results['msg'] = "Gi???y ph??p h???p l???";
        $results['status'] = true;
        return $results;
    }
    if($results['status'] == "Invalid"){   
        $results['msg'] = "Gi???y ph??p k??ch ho???t kh??ng h???p l???";
        $results['status'] = false;
        return $results;
    }
    if($results['status'] == "Expired"){   
        $results['msg'] = "Gi???y ph??p m?? ngu???n ???? h???t h???n, vui l??ng gia h???n ngay";
        $results['status'] = false;
        return $results;
    }
    if($results['status'] == "Suspended"){   
        $results['msg'] = "Gi???y ph??p c???a b???n ???? b??? t???m ng??ng";
        $results['status'] = false;
        return $results;
    }
    $results['msg'] = "Kh??ng t??m th???y gi???y ph??p n??y trong h??? th???ng";
    $results['status'] = false;
    return $results;
}


if(checkWhiteDomain($_SERVER['SERVER_NAME']) != true){
    if($CMSNT->site('license_key') == '' || checkLicenseKey($CMSNT->site('license_key'))['status'] != true){
        if (isset($_POST['btnSaveLicense'])) {
            if ($CMSNT->site('status_demo') != 0) {
                die('<script type="text/javascript">if(!alert("Kh??ng ???????c d??ng ch???c n??ng n??y v?? ????y l?? trang web demo.")){window.history.back().location.reload();}</script>');
            }
            foreach ($_POST as $key => $value) {
                $CMSNT->update("settings", array(
                    'value' => $value
                ), " `name` = '$key' ");
            }
            $checkKey = checkLicenseKey($CMSNT->site('license_key'));
            if($checkKey['status'] != true){
                die('<script type="text/javascript">if(!alert("'.$checkKey['msg'].'")){window.history.back().location.reload();}</script>');
            }
            die('<script type="text/javascript">if(!alert("L??u th??nh c??ng !")){window.history.back().location.reload();}</script>');
        } ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>C???u h??nh th??ng tin b???n quy???n</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">TH??NG TIN B???N QUY???N CODE</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">M?? b???n quy???n (license key)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="license_key" placeholder="Nh???p m?? b???n quy???n c???a b???n ????? s??? d???ng ch???c n??ng n??y" value="<?=$CMSNT->site('license_key');?>"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveLicense" class="btn btn-primary btn-block">
                                <span>L??U</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">H?????NG D???N</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Qu?? kh??ch c?? th??? l???y License key t???i ????y: <a target="_blank" href="https://client.cmsnt.co/clientarea.php?action=products&module=licensing">https://client.cmsnt.co/clientarea.php?action=products&module=licensing</a></p>
                        <p>N???u qu?? kh??ch mua h??ng t???i CMSNT.CO m?? ch??a c?? License key, vui l??ng li??n h??? Zalo <b>0947838128</b> ????? ???????c c???p.</p>
                        <p>Ch??? ??p d??ng cho nh???ng ai mua code, kh??ng h??? tr??? nh???ng tr?????ng h???p mua l???i hay s??? d???ng m?? ngu???n l???u.</p>
                        <p>N???u b???n ch??a mua code t???i CMSNT.CO, b???n c?? th??? mua gi???y ph??p t???i ????y: <a target="_blank" href="https://www.cmsnt.co/2021/12/shopclone6-thiet-ke-website-ban-nguyen.html">CLIENT CMSNT</a></p>
                        <img src="https://i.imgur.com/VzDVIx0.png" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 
    require_once(__DIR__."/../resources/views/admin/footer.php");
?>
<?php die(); } } ?>