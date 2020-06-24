<?php
/**
 * A class to generate and parse Hawk authentication headers
 *
 * @author		Alex Bilbie | www.alexbilbie.com | hello@alexbilbie.com
 * @copyright	Copyright (c) 2012, Alex Bilbie.
 * @license		http://www.opensource.org/licenses/mit-license.php
 * @link		http://alexbilbie.com
 */
class Hawk {

    protected $_url;

    protected $_path;

    protected $_endPoint;

    protected $_request;

    protected $_headers = '';

    protected $_body = false;

    protected $_params = array();

    public function __construct($endPoint = false, $request = false)
    {
        $this->_url = env('KAIOS_BASE_URL');
    }

    function generateNonce() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function normalizedHeader($current_timestamp, $nonce, $method, $resource, $secret_key, $hash = NULL) {
        $uri = env('KAIOS_URL_STR');

        $normalized_header = "hawk.1.header\n";
        $normalized_header .= $current_timestamp."\n";
        $normalized_header .= $nonce."\n";
        $normalized_header .= $method."\n";
        $normalized_header .= $resource."\n";
        $normalized_header .= $uri."\n";
        $normalized_header .= "443\n";
        $normalized_header .= (is_null($hash)) ? "\n" : $hash."\n";
        $normalized_header .= "\n";

        $str = str_replace('\n', '', $normalized_header);
        $mac_key = base64_decode($secret_key, true);

        $normalized_header_hmac = hash_hmac("sha256", $str, $mac_key, True);
        $compute_header = base64_encode($normalized_header_hmac);

        return $compute_header;
    }

    function normalizePayload ($payload) {
        $normalized_payload = "hawk.1.payload\n";
        $normalized_payload .= "application/json\n";
        $normalized_payload .= $payload."\n";

        $payload_str = str_replace('\n', '', $normalized_payload);
        $compute_hash = hash("sha256", $payload_str, true);
        return base64_encode($compute_hash);
    }

    function sendRequest($end_point, $method, $header, $params = NULL) {
        $hit_url = $this->_url . $end_point;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $hit_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if($method == 'POST') {
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

//        curl_setopt($curl, CURLOPT_URL, "https://api.test.kaiostech.com/financier_be/v1.0/devices/192168718812411/notify_paid");
//        curl_setopt($curl, CURLOPT_POST, 1);
//        curl_setopt($curl, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $server_output = curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//        $header = substr($server_output, 0, $header_size);
//        $body = substr($server_output, $header_size);
        $object = json_decode($server_output);
        return array('status_code' => $httpcode, "response" => json_decode(json_encode($object), true));
    }

}
