<?php

namespace App\Libraries;

use CodeIgniter\Config\Config;
use CodeIgniter\Session\Session;
use Config\App;

class TokopediaApi
{
    private static $instances = [];

    private $curl = null;
    private $mssidn = '6281251554104';
    private $key = 'BCet';

    public function __construct()
    {
        $this->options = [];
        $options['http_errors'] = true;
        $options['baseURI'] = 'https://gql.tokopedia.com';
        $options['headers'] = [
            'Host' => 'gql.tokopedia.com',
            'X-Version' => '27a71d9',
            'Origin' => 'https://mitra.tokopedia.com',
            'X-Mitra-Device' => 'others',
            'Fingerprint-Data' => 'eyJ1c2VyX2FnZW50IjoiTW96aWxsYS81LjAgKExpbnV4OyBBbmRyb2lkIDcuMS4yOyBHMDExQSBCdWlsZC9OMkc0OEgpIEFwcGxlV2ViS2l0LzUzNy4zNiAoS0hUTUwsIGxpa2UgR2Vja28pIENocm9tZS82OC4wLjM0NDAuNzAgTW9iaWxlIFNhZmFyaS81MzcuMzYifQ==',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 7.1.2; G011A Build/N2G48H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.70 Mobile Safari/537.36',
            'Content-Type' => 'application/json',
            'Accept' => '*/*',
            'Fingerprint-Hash' => '10050acc8dc41f16f27c1a203c7e63e0',
            'X-Source' => 'tokopedia-lite',
            'X-Device' => 'mitra_app-1.0, tokopedia-lite',
            'Referer' => 'https://mitra.tokopedia.com/login',
            // 'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-US,en;q=0.9',
        ];

        $this->curl = \Config\Services::curlrequest($options);
    }

    public static function getInstance(): TokopediaApi
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Mengembalikan CURL default
     * @return \CodeIgniter\HTTP\CURLRequest
     */
    private function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param array $params
     * @return $this
     */
    private function setBody(string $body)
    {
        $this->body = $body;
        $this->curl->setBody($body)
            ->setHeader('Content-Length', strlen($body));
        return $this;
    }

    /**
     * Eksekusi request ke API
     * @param $method
     * @param $url
     * @param array $options
     * @return array|mixed
     */
    public function execute($method, $url, $options = [])
    {
        $options['debug'] = WRITEPATH . '/logs/log_tokped.txt';
        $options['http_errors'] = false;

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);

        $cookieFile = $response->getHeaderLine('set-cookie');
        $status = $this->saveCookieFile(WRITEPATH.'cookie/tokopedia-mitra.txt', $cookieFile);
        
        $data = json_decode($response->getBody(), true);
        
        if(is_array($data) && isset(current($data)['data'])){
            return current($data)['data'];
        } else{
            return $data;
        }
    }


    private function saveCookieFile($path, $data){
        helper('filesystem');
        if(file_exists($path))
            $statusLog = write_file($path, $data. "\r\n",  'a');
        else
            $statusLog = write_file($path, $data);

        return $statusLog;
    }
   
    public function sendOTP()
    {
        $body = '[{"operationName":"OTPRequest","variables":{"msisdn":"'.$this->mssidn.'","otpType":"112","mode":"sms","otpDigit":6},"query":"query OTPRequest($otpType: String!, $mode: String, $msisdn: String, $email: String, $otpDigit: Int, $ValidateToken: String, $UserIDEnc: String, $UserIDSigned: Int, $Signature: String, $MsisdnEnc: String, $EmailEnc: String) {\n  OTPRequest(otpType: $otpType, mode: $mode, msisdn: $msisdn, email: $email, otpDigit: $otpDigit, ValidateToken: $ValidateToken, UserIDEnc: $UserIDEnc, UserIDSigned: $UserIDSigned, Signature: $Signature, MsisdnEnc: $MsisdnEnc, EmailEnc: $EmailEnc) {\n    success\n    message\n    errorMessage\n    sse_session_id\n    list_device_receiver\n    error_code\n    message_title\n    message_sub_title\n    message_img_link\n    __typename\n  }\n}\n"}]';
        $response = $this
                        ->setBody($body)
                        ->execute('POST', '/graphql/OTPRequest', [
                            'headers' => [
                            ],
                        ]);

        return $response;
    }

    public function validasiOTP($otpCode)
    {
        $body = '[{"operationName":"OTPValidate","variables":{"msisdn":"'.$this->mssidn.'","code":"'.$otpCode.'","otpType":"112","mode":"sms"},"query":"query OTPValidate($msisdn: String, $code: String!, $otpType: String, $fpData: String, $getSL: String, $email: String, $mode: String, $ValidateToken: String, $UserIDEnc: String, $UserID: Int, $signature: String, $UsePINHash: Boolean, $PIN: String, $PINHash: String) {\n  OTPValidate(code: $code, otpType: $otpType, msisdn: $msisdn, fpData: $fpData, getSL: $getSL, email: $email, mode: $mode, ValidateToken: $ValidateToken, UserIDEnc: $UserIDEnc, UserID: $UserID, signature: $signature, UsePINHash: $UsePINHash, PIN: $PIN, PINHash: $PINHash) {\n    success\n    message\n    errorMessage\n    validateToken\n    cookieList {\n      key\n      value\n      expire\n      __typename\n    }\n    __typename\n  }\n}\n"}]';
        $response = $this
                        ->setBody($body)
                        ->execute('POST', '/graphql/OTPValidate');

        return $response;
    }

     
    public function loginMutationV2($key)
    {
        $password = base64_encode($key);
        $username = base64_encode($this->mssidn);
        $body = '[{"operationName":"LoginMutationV2","variables":{"input":{"grant_type":"cGFzc3dvcmQ='.$this->key.'","password_type":"lpn","code":"'.$this->mssidn.'","username":"'.$username.''.$this->key.'","password":"'.$password.''.$this->key.'","supported":"true","fpt":"285cff84ee19aef49551dd12b9f83390"}},"query":"mutation LoginMutationV2($input: TokenRequestV2!) {\n  login_token: web_token_v2(input: $input) {\n    access_token\n    refresh_token\n    token_type\n    sid\n    acc_sid\n    errors {\n      name\n      message\n      __typename\n    }\n    popup_error {\n      header\n      body\n      action\n      __typename\n    }\n    sq_check\n    cotp_url\n    uid\n    action\n    event_code\n    expires_in\n    __typename\n  }\n}\n"}]';
      
        $response = $this
                        ->setBody($body)
                        ->execute('POST', '/graphql/LoginMutationV2', [
                            'headers' => [
                                'Accounts-Authorization' => 'MTAwMg=='.$this->key,
                                'Cookie' => '_gid=GA1.2.685379138.1658626711; DID=aef293d9c379736ec282053600f8ab34898fe49394c18d57ddf74a1952300f4fbfc37b3d00e25eb595abe5349a274148; DID_JS=YWVmMjkzZDljMzc5NzM2ZWMyODIwNTM2MDBmOGFiMzQ4OThmZTQ5Mzk0YzE4ZDU3ZGRmNzRhMTk1MjMwMGY0ZmJmYzM3YjNkMDBlMjVlYjU5NWFiZTUzNDlhMjc0MTQ447DEQpj8HBSa+/TImW+5JCeuQeRkm5NMpJWZG3hSuFU=; _gcl_au=1.1.1785014804.1658626713; CSHLD_SID=44bdf8d9f15d36cd0ea74cbecb6c17bde14323ea496f3bd3cc5cc75da475ac7e; __auc=c95549321822ddb295e4d0683b6; l=1; FPF=1; aus=1; _fbp=fb.1.1658671767316.1648286107; bm_sz=C5AA1FE5831F535A38372CF905ACA436~YAAQvdN9ck6mhyOCAQAAwEOUOhBcUPVXov38MoCoqo+lNV1V7sSFSLc++1eDVHp24lKKmn/vQwUy/8P5V4EUUjRhsxRYuBOsTWr32yQ2hY1ttF3mvf598X2xc95JzPcHZiPP6CCWzrsebmVcbtGA2meCC6QHSZ6h4b7CBPTf5AIABc+1MA0D5OANZ/m8XqcJKIyVp0RSsI5oykVRWkGpyXzxSJg8B1FEtBsmreaDlbndgwb6R9oEZAaoNMBUQ1EpG40QPvBb72s5vbREB2vrxjD5DqSgQHfvkVqAQYeCgNBZpZ672qk=~3684658~4605505; AMP_TOKEN=%24NOT_FOUND; _SID_Tokopedia_=3h-2S5hWjPoAGUBdhe6H2rL_wjamS6KnMYXusPcHOD9vktg3eoaF0xIxQbkDTkVC0Mg487zfp_Mfqxlk8pBbiDdFBhl9RSeHFVPc0-5y0kK6am1GvKMZcBh02YIEuWQd; _dc_gtm_UA-126956641-2=1; _ga=GA1.1.1065290740.1658626711; _ga_70947XW48P=GS1.1.1658844304.5.1.1658845260.49; _abck=E12CEE5F098B98DB0F504E08CEDE54A6~-1~YAAQt9N9cgqrhyOCAQAArkTiOgjb7JsbY3GzhWbLT4nuM8wEoHV12pQkQikbF+4Soy61FPPj5vOndmMberBboEFPrTto/vYkh7rQo4tfegXw2BNTbzgMW6XVzRc/bmuQknaXXwcEO0RoTMIGnlDvQvCBr3HrSxO1FMUTvQc/spt9LGSRCLWo3NSYcfDCQ8rwM8xpxyDmxlmr4T7J7e5woIgrHL5rjbrWKFkiQvjy8vnMZnJGFH37HNfK7Xdv3fTo/4hXth9SbxPLyDuSqrj5f1/iKhlPGkXC6yRLUtXe6E/m4DufVDc8Lh0u9gvSyJM3l7BfNOk9PlpcbpmlmuGc3lptGLb4Z8/UFOcZcU17XXofkZsYyp0Fj6FDFCyUFmz4UfMtPHfDVZ4DwDrlqLuj5ERgJtIi0wNTmY0b8tw=~-1~-1~-1',
                            ],
                        ]);

        return $response;
    }

    public function isAuth()
    {
        $body = '[ { "operationName": "isAuthenticatedQuery", "variables": {}, "query": "query isAuthenticatedQuery {\n  isAuthenticated\n  user {\n    id\n    isLoggedIn\n    email\n    name\n    full_name\n    phone\n    profile_picture\n    __typename\n  }\n}\n" } ]';
      
        $response = $this
                        ->setBody($body)
                        ->execute('POST', '/graphql/isAuthenticatedQuery', [
                            'headers' => [
                                'Cookie' => '_SID_Tokopedia_=3h-2S5hWjPoAGUBdhe6H2rL_wjamS6KnMYXusPcHOD9vktg3eoaF0xIxQbkDTkVC0Mg487zfp_Mfqxlk8pBbiDdFBhl9RSeHFVPc0-5y0kK6am1GvKMZcBh02YIEuWQd',
                            ],
                        ]);

        return $response;
    }

    public function checkSaldoMitraBRI()
    {
        $body = '[ { "operationName": "vaMitraBalance", "variables": {}, "query": "query vaMitraBalance {\n  vaMitraGetBalance {\n    balance\n    balance_str\n    error {\n      error\n      __typename\n    }\n    __typename\n  }\n}\n" } ]';
      
        $response = $this
                        ->setBody($body)
                        ->execute('POST', '/graphql/vaMitraBalance', [
                            'headers' => [
                                'Cookie' => '_SID_Tokopedia_=3h-2S5hWjPoAGUBdhe6H2rL_wjamS6KnMYXusPcHOD9vktg3eoaF0xIxQbkDTkVC0Mg487zfp_Mfqxlk8pBbiDdFBhl9RSeHFVPc0-5y0kK6am1GvKMZcBh02YIEuWQd',
                            ],
                        ]);

        return $response;
    }

    public function checkVaNumberMitraBRI()
    {
        $body = '[ { "operationName": "VAMitraGetVANumberQuery", "variables": {}, "query": "query VAMitraGetVANumberQuery {\n  vaMitraGetVANumber {\n    va_number\n    status\n    error_data {\n      error\n      __typename\n    }\n    __typename\n  }\n}\n" } ]';
      
        $response = $this
                        ->setBody($body)
                        ->execute('POST', '/graphql/VAMitraGetVANumberQuery', [
                            'headers' => [
                                'Cookie' => '_SID_Tokopedia_=3h-2S5hWjPoAGUBdhe6H2rL_wjamS6KnMYXusPcHOD9vktg3eoaF0xIxQbkDTkVC0Mg487zfp_Mfqxlk8pBbiDdFBhl9RSeHFVPc0-5y0kK6am1GvKMZcBh02YIEuWQd',
                            ],
                        ]);

        return $response;
    }

}
