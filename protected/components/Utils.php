<?php

class Utils {

    public static function getRandomPassword($length = 8) {

        //$characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ@!#$*';

        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public static function GetBaseUrl() {
        $base_url = Yii::app()->baseUrl;
        return $base_url;
    }

    public static function NoImagePath() {
        $path = Yii::app()->baseUrl . "/bootstrap/dashboard/img/default-image.jpeg";
        return $path;
    }

    public static function NoImageBasePath() {
        $path = Yii::app()->basePath . "/../bootstrap/dashboard/img/default-image.jpeg";
        return $path;
    }

    public static function ProductImageTempBasePath() {
        $temp_path = Yii::app()->basePath . "/../bootstrap/uploads/product/temp/";
        return $temp_path;
    }

    public static function ProductImageBasePath() {
        $product_image_path = Yii::app()->basePath . "/../bootstrap/uploads/product/";
        return $product_image_path;
    }

    public static function ProductImageThumbnailBasePath() {
        $product_image_path = Yii::app()->basePath . "/../bootstrap/uploads/product/thumbs/";
        return $product_image_path;
    }

    public static function ProductImagePath() {
        $product_image_path = Yii::app()->baseUrl . "/bootstrap/uploads/product/";
        return $product_image_path;
    }

    public static function ProductImageThumbnailPath() {
        $product_image_path = Yii::app()->baseUrl . "/bootstrap/uploads/product/thumbs/";
        return $product_image_path;
    }

    public static function UserImagePath() {
        $user_image_path = Yii::app()->request->baseUrl . "/bootstrap/uploads/user/";
        return $user_image_path;
    }

    public static function UserThumbnailImagePath() {
        $user_image_path = Yii::app()->request->baseUrl . "/bootstrap/uploads/user/thumbs/";
        return $user_image_path;
    }

    public static function UserImageBasePath() {
        $user_image_path = Yii::app()->basePath . "/../bootstrap/uploads/user/";
        return $user_image_path;
    }

    public static function UserThumbnailImageBasePath() {
        $user_image_path = Yii::app()->basePath . "/../bootstrap/uploads/user/thumbs/";
        return $user_image_path;
    }

    public static function UserImagePath_M() {
        $user_m = Utils::UserImagePath() . "avatar_m.png";
        return $user_m;
    }

    public static function UserImagePath_F() {
        $user_f = Utils::UserImagePath() . "avatar_f.png";
        return $user_f;
    }

    private function Encryption_Key() {
        $string = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';
        return $string;
    }

    private function mc_encrypt($encrypt, $key) {
        $encrypt = serialize($encrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt) . '|' . base64_encode($iv);
        return $encoded;
    }

    private function mc_decrypt($decrypt, $key) {
        $decrypt = explode('|', $decrypt . '|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {
            return false;
        }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if ($calcmac !== $mac) {
            return false;
        }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }

    function passwordEncrypt($password) {
        return $this->mc_encrypt($password, $this->Encryption_Key());
    }

    function passwordDecrypt($password) {
        return $this->mc_decrypt($password, $this->Encryption_Key());
    }

    public static function getWinnerStatus($id) {
        $name = '';

        $status = array(
            1 => 'First',
            2 => 'Second',
            3 => 'Third',
            4 => 'Fourth',
            5 => 'Fifth',
            6 => 'Sixth',
            7 => 'Seventh',
            8 => 'Eighth',
            9 => 'Ninth',
            10 => 'Tenth',
        );

        foreach ($status as $k => $v) {
            if ($k == $id) {
                $name = $v;
            }
        }

        return $name;
    }

}
