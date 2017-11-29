<?php
function get($key = '') {
    return isset($_POST[$key]) ? $_POST[$key] : false;
}

function getPageVar($key) {
    return get($key) ? get($key) : '';
}

function safeOutput($variable) {
    return htmlspecialchars($variable);
}

function safeJsOutput($variable) {
    $variable = safeOutput($variable);

    if(gettype($variable) === "string") {
        $variable = '"' . $variable . '"';
    }

    return $variable === '' ? '""' : $variable;
}

function curlPost($url, $postData) {

    $header = ['Content-Type: application/json'];
    $ch     = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);

    $response = curl_exec($ch);

    curl_close($ch);

    return $response;
}

function curlGet($url) {
    $chx = curl_init();
    curl_setopt($chx, CURLOPT_URL, $url);
    curl_setopt($chx,CURLOPT_RETURNTRANSFER, true);
    $returnData = curl_exec($chx);
    curl_close($chx);

    return $returnData;
}

function buildCountyUrl($getCountyURL) {

    $usaPos    = strripos($getCountyURL, 'USA/');
    $usaStr    = substr($getCountyURL, $usaPos);
    $sanitized = preg_replace('/ /', '%20', $usaStr);

    return substr_replace($getCountyURL, $sanitized, $usaPos);
}

function process() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $faciMethod    = get("faciMethod");
    $faciLat       = '';
    $faciLng       = '';
    $geoCodeMethod = false;
    if ((int)$faciMethod === 0) {
        $geoCodeMethod = 0;
        $LatLong       = (int)get("LatLong");
        $a             = ['lat' => get("LatitudeA"), 'lng' => get('LongitudeA')];
        $b             = ['lat' => get("LatitudeB"), 'lng' => get('LongitudeB')];
        $c             = ['lat' => get("LatitudeC"), 'lng' => get('LongitudeC')];
        $e             = ['lat' => get("LatitudeE"), 'lng' => get('LongitudeE')];
        $f             = ['lat' => get("LatitudeF"), 'lng' => get('LongitudeF')];
        $g             = ['lat' => get("LatitudeG"), 'lng' => get('LongitudeG')];
        $decLatA       = get('decimalLatA');
        $decLatB       = get('decimalLatB');
        $decLngC       = get('decimalLongC');
        $decLngD       = get('decimalLongD');

        switch ($LatLong) {
            case 0:
                $b['lat'] = $b['lat'] ? ((int)$b['lat'] / 60) : false;
                $b['lng'] = $b['lng'] ? ((int)$b['lng'] / 60) : false;
                $c['lat'] = $c['lat'] ? ((int)$c['lat'] / 3600) : false;
                $c['lng'] = $c['lng'] ? ((int)$c['lng'] / 3600) : false;

                if ($a['lat'] && $b['lat'] && $c['lat']) {
                    $faciLat = $a['lat'] + $b['lat'] + $c['lat'];
                }

                if ($a['lng'] && $b['lng'] && $c['lng']) {
                    $faciLng = '-' . ($a['lng'] + $b['lng'] + $c['lng']);
                }

                break;
            case 1:
                $g['lat'] = $g['lat'] ? ((int)$g['lat'] / 60) : false;
                $g['lng'] = $g['lng'] ? ((int)$g['lng'] / 60) : false;
                if ($e['lat'] && $f['lat'] && $g['lat']) {
                    $faciLat = $e['lat'] + (int)($f['lat'] . '.' . $g['lat']);
                }

                if ($e['lng'] && $f['lng'] && $g['lng']) {
                    $faciLng = '-' . ($e['lng'] + (int)($f['lng'] . '.' . $g['lng']));
                }

                break;
            case 2:
                if ($decLatA && $decLatB) {
                    $faciLat = $decLatA . '.' . $decLatB;
                }

                if ($decLngC && $decLngD) {
                    $faciLng = '-' . ($decLngC . '.' . $decLngD);
                }
                break;
            default:
                break;
        }
    } elseif ($faciMethod == 1) {
        $geoCodeMethod = 1;
        $faciLat       = get("lat");
        $faciLng       = get("lng");
    }

    $metadata = [
        'mode'         => 'sync',
        'keep_results' => '3600000',
    ];

    $parameter = [
        [
            'name'  => 'latitude',
            'value' => $faciLat,
        ],
        [
            'name'  => 'longitude',
            'value' => $faciLng,
        ],
    ];

    // $postData   = '{"metainfo":' . json_encode($metadata) . ',"parameter":' . json_encode($parameter) . '}';
    $postData   = [
        'metainfo'  => $metadata,
        'parameter' => $parameter,
    ];
    // $returnData = curlPost('http://csip.engr.colostate.edu:8086/csip-erosion/d/rusle2/climate/1.0', $postData);
    $returnData = curlPost('http://csip.engr.colostate.edu:8084/csip-erosion/d/rusle2/climate/1.1', $postData);

    $validLocation = 0;
    $climateData   = false;
    if($returnData) {
        $json = json_decode($returnData, true);
        $countyResult = array_key_exists('result',$json) ? $json['result'] : false;
        $url = false;
        if($countyResult) {
            $key = array_search('climate',array_column($countyResult,'name'));
            $url = $countyResult[$key]['value'];

        }

        if ($url) {
            $validLocation = 1;
            $setCountyURL  = buildCountyUrl($url);
            $climateData   = curlGet($setCountyURL);
        }
    }


    return [
        $faciMethod,
        $geoCodeMethod,
        $faciLat,
        $faciLng,
        $returnData,
        $validLocation,
        $climateData,
    ];
}

function didSubmit() {
    $submitForm = 0;
    $processing = '';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $submitForm = 1;
        $processing = "<div id='processing'><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p><br><p><strong>Processing Results</strong></p></div>";
    }

    return [$submitForm, $processing];
}

list($submitForm, $processing) = didSubmit();
list($faciMethod, $geoCodeMethod, $faciLat, $faciLng, $returnData, $validLocation, $climateData) = process();
