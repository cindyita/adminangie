<?php
namespace ControllersNS;
use ModelsNS\QueryModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Throwable;

class AuthController
{

    public static function auth($data){

        try{
    
            if (!empty($data) && count($data)>0) {
                $db = new QueryModel();
                
                $email = $data['email'];
                $row = $db->unique("sys_user","email = '$email'");
                if($row && $row != [] && password_verify($data['pass'], $row['password'])){

                    if($row['status'] != 1){
                        return 3;
                    }

                    // session_start();

                    foreach ($row as $key => $value) {
                        if($key != "password"){
                            $_SESSION['MYSESSION'][$key] = $value;
                        }
                    }

                    $id = $row['id'];
                    $_SESSION['MYSESSION']['userid'] = $id;
                    
                    $idCompany = $row['id_company'];
                    $company = $db->unique("sys_company","id = $idCompany");
                    $_SESSION['MYSESSION']['company'] = [];

                    foreach ($company as $key => $value) {
                        if($key != "register_password"){
                            $_SESSION['MYSESSION']['company'][$key] = $value;
                        }
                    }

                    $token = self::generateToken($id);

                    setcookie('AuthToken', $token, [
                        'expires' => time() + 60*60*24*30, // 30 días
                        'path' => '/',
                        // 'domain' => $_ENV['DOMAIN'],
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);

                    $db->close();
                    if($token){
                        return 1;
                    }else{
                        return 4;
                    }
                    
                }else{
                    $db->close();
                    return 2;
                }
                
            } else {
                return json_encode(['error'=>'Invalid format or no info']);
            }
            
        }catch(exception $e){
            return json_encode('error: '.$e->getMessage());
        }

    }

    public static function generateToken($id){
        $now = strtotime("now");
        $key = $_ENV['KEY_AUTH'];
        $expiration_time = $now + (30 * 24 * 60 * 60); //30 días

        $payload = [
            'exp' => $expiration_time,
            'data' => $id
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        $res = ["token" => $jwt];

        return json_encode($res);
    }

    public static function getToken(){
        try{
            if(isset($_COOKIE['AuthToken'])){
                $token = json_decode($_COOKIE['AuthToken'], true);
                $token = $token['token'];
                $decodedToken = JWT::decode($token, new Key($_ENV['KEY_AUTH'], 'HS256'));
                return $decodedToken;
            }else{
                return false;
            }
        }catch(\Throwable $e){
            if($e->getMessage() == "Expired token"){
                return "expired";
            }else{
                return false;
            }
        }
    }

    public static function validateAuthToken(){
        $info = self::getToken();
        if(!$info){
            return false;
        }
        if($info == "expired"){
            return "expired";
        }
        $id = $info->data;
        $db = new QueryModel();
        $row = $db->value("sys_user","id = $id","id");
        return $row;
    }

    public static function clearAuthCookie() {
        if (isset($_COOKIE["AuthToken"])) {
            setcookie("AuthToken", "");
        }
    }

    public static function checkSession() {
        if (!self::validateAuthToken()) {
            self::logout();
        }
    }

    public static function logout() {
        unset($_SESSION['MYSESSION']);
        setcookie("AuthToken", "", time() - 3600, '/');
        session_destroy();
        redirect('login');
    }


}