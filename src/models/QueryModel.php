<?php 
namespace ModelsNS;

use PDO;
use PDOException;
use DateTimeZone;
use DateTime;
use Exception;

class QueryModel {
    private $db;
    private $data;
    public function __construct($dbName = null){
        $this->data = array();
        
        if ($dbName) {
            $this->connect($dbName);
        } else {
            $this->connect();
        }

    }

    // CONEXIONES
    private function connect($dbName = null) {
        try {
            $host = $_ENV['DB_HOST'];
            $dbname = $dbName ?? $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];

            $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true
            ];

            // $this->db = new PDO($dsn, $user, $this->decrypt($pass,$_ENV['SALT']), $options);
            $this->db = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->log($e->getMessage());
        }
    }

    public function __destruct() {
        $this->closeConnection();
    }

    private function closeConnection() {
        $this->db = null;
    }

    public function close() {
        $this->closeConnection();
    }

    // CONSULTAS

    public function query($query, $params = []) {
        try {
            $start = microtime(true);
            $sanitizedParams = $this->sanitizeData($params);
            $stmt = $this->db->prepare($query);
            $stmt->execute($sanitizedParams);
            $result = $stmt->fetchAll();
            $end = microtime(true);

            if (($end - $start) > 2) {
                $this->log("[".ACTUALPAGE."] La consulta tardó ".($end - $start)."seg en ejecutarse: $query");
            }

            return $result;
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    public function queryUnique($query, $params = []) {
        try {
            $start = microtime(true);
            $sanitizedParams = $this->sanitizeData($params);
            $stmt = $this->db->prepare($query);
            $stmt->execute($sanitizedParams);
            $result = $stmt->fetch();
            $end = microtime(true);

            if (($end - $start) > 2) {
                $this->log("[".ACTUALPAGE."] La consulta tardó ".($end - $start)."seg en ejecutarse: $query");
            }

            return $result;
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

        
    public function insert($table, $data) {
        $sanitizedData = $this->sanitizeData($data);

        $columns = implode(", ", array_keys($sanitizedData));
        $placeholders = ":" . implode(", :", array_keys($sanitizedData));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($sanitizedData);
            return 1;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function select($table, $condition = 1) {
        $query = "SELECT * FROM $table WHERE $condition";

        try {
            $start = microtime(true);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $end = microtime(true);
            
            if ($end - $start > 5) {
                $this->log("[".ACTUALPAGE."] La consulta SELECT tardó ".($end - $start)."seg en ejecutarse: $query");
            }
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            $this->data = array();
        }

        return $this->data;
    }

    public function value($table, $condition, $value) {
        $query = "SELECT $value FROM $table WHERE $condition";

        try {
            $start = microtime(true);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetchColumn();
            $end = microtime(true);

            if ($end - $start > 5) {
                $this->log("[".ACTUALPAGE."] La consulta SELECT tardó ".($end - $start)."seg en ejecutarse: $query");
            }
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            $this->data = null;
        }

        return $this->data;
    }

    public function unique($table, $condition) {
        $query = "SELECT * FROM $table WHERE $condition LIMIT 1";

        try {
            $start = microtime(true);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetch(PDO::FETCH_ASSOC);
            $end = microtime(true);
            
            if ($end - $start > 5) {
                $this->log("[".ACTUALPAGE."] La consulta SELECT tardó ".($end - $start)."seg en ejecutarse: $query");
            }
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            $this->data = array();
        }

        return $this->data;
    }

    public function update($table, $data, $condition) {
        $sanitizedData = $this->sanitizeData($data);

        $setValues = [];
        foreach ($sanitizedData as $key => $value) {
            $setValues[] = $key . " = :" . $key;
        }
        $setClause = implode(", ", $setValues);

        $query = "UPDATE $table SET $setClause WHERE $condition";
        
        try {
            $start = microtime(true);
            $stmt = $this->db->prepare($query);
            $stmt->execute($sanitizedData);
            $rowCount = $stmt->rowCount();
            $end = microtime(true);
            if ($end - $start > 5) {
                $this->log("[".ACTUALPAGE."] La consulta UPDATE tardó ".($end - $start)."seg en ejecutarse: $query");
            }
            return $rowCount;
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    public function delete($table, $condition) {
        $query = "DELETE FROM $table WHERE $condition";
        
        try {
            $start = microtime(true);
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            $end = microtime(true);
            if ($end - $start > 5) {
                $this->log("[".ACTUALPAGE."] La consulta UPDATE tardó ".($end - $start)."seg en ejecutarse: $query");
            }
            return $rowCount;
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    public function lastid(){
        try {
            $lastId = $this->db->lastInsertId();
            return $lastId;
        } catch (PDOException $e) {
            $this->log($e->getMessage());
            return null;
        }
    }

    // RECURSOS

    private function getClientIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    private function truncateLongValues(array $source, int $maxLength = 40): array {
        foreach ($source as &$value) {
            if (strlen($value) > $maxLength) {
                $value = substr($value, 0, $maxLength - 3) . '...';
            }
        }
        return $source;
    }


    private function sanitizeData($data) {
        if (is_string($data)) {
            $sanitizedData = $this->db->quote($data);
        } elseif (is_int($data)) {
            $sanitizedData = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        } elseif (is_float($data)) {
            $sanitizedData = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            $sanitizedData = $data;
        }

        return $sanitizedData;
    }

    public function log(string $txt, ?int $userId = null) {
        if (!isset($userId) && isset($_SESSION['sibSession'], $_SESSION['sibSession']['id'])) {
            $userId = $_SESSION['sibSession']['id'];
        }

        $now = microtime(true);
        $timezone = new DateTimeZone('America/Mexico_City');
        $datetime = DateTime::createFromFormat('U.u', $now);
        $datetime->setTimeZone($timezone);

        $hh = intval($datetime->format('H'));

        $logPath = __DIR__ . "/../../log/";
        if (file_exists($logPath) && is_writable($logPath)) {
            try {
                $userIdString = $userId ? '{' . $userId . '}' : '';
                $formattedDateTime = $datetime->format("Y-m-d H:i:s.u");
                // $txt = str_replace($_ENV['SALT'], 'XX', $txt);
                $logMessage = "$formattedDateTime $userIdString $txt" . PHP_EOL;
                file_put_contents($logPath . 'trans.' . $datetime->format("Ymd") . '_'.$hh, $logMessage, FILE_APPEND | LOCK_EX);
            } catch (Exception $e) {
                return false;
            }
        }
    }


    public static function decrypt(string $string, string $key) {
        
        $c = base64_decode($string);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);

        return openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    }
    
    public static function encrypt(string $plaintext, string $key) {
        
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        
        return base64_encode( $iv.$hmac.$ciphertext_raw );
    }


}