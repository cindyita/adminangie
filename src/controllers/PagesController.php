<?php
namespace ControllersNS;
use ModelsNS\QueryModel;
use ControllersNS\AuthController;

class PagesController
{
    public static $styles;
    public static $scripts;

    public function __construct()
    {
        $this->styles = [];
        $this->scripts = [];
    }

    public static function headerLayout() {
        $styles = self::$styles;
        require_once "./src/views/layouts/headerLayout.php";
    }

    public static function menuLayout() {
        require_once "./src/views/layouts/menuLayout.php";
    }

    public static function footerLayout() {
        $scripts = self::$scripts;
        require_once "./src/views/layouts/footerLayout.php";
    }

    private static function addScript($path) {
        self::$scripts[] = $path;
    }

    private static function addStyle($path) {
        self::$styles[] = $path;
    }

    private static function pageScript($page) {
        self::addScript('./assets/js/pages/'.$page.'.js');
    }

    private static function pageStyle($page) {
        self::addStyle('./assets/css/pages/'.$page.'.css');
    }

    public static function checkSession(){
        if(!isset($_SESSION["MYSESSION"])){
            header('Location: login');
            exit();
        }
        $validate = AuthController::validateAuthToken();
        if(!$validate){
            self::unAuth();
            exit();
        }
        if($validate == "expired"){
            header('Location: login');
            exit();
        }
    }

    public static function checkSessionToHome(){
        $validate = AuthController::validateAuthToken();
        if($validate && isset($_SESSION["MYSESSION"]) && $validate != "expired"){
            header('Location: home');
        }
    }

    // VER VARIABLES DE SESSION
    public static function session() {
        require_once "./src/views/pages/_session.php";
    }

    // PÁGINA NO AUTORIZADO
    public static function unAuth(){
        require_once "./src/views/pages/unauthorized.php";
    }

    // PÁGINA HOME
    public static function home() {
        self::checkSession();
        self::pageScript('home');
        require_once "./src/views/pages/home.php";
    }

    // PÁGINA LOGIN
    public static function login() {
        self::checkSessionToHome();
        self::pageScript('login');
        require_once "./src/views/pages/login.php";
    }

    public static function logout(){
        AuthController::logout();
        self::checkSession();
    }

    // PÁGINA REGISTRO
    public static function register() {
        self::pageScript('register');
        require_once "./src/views/pages/register.php";
    }

    // PÁGINA ERROR 404
    public static function error404() {
        require_once "./src/views/pages/error404.php";
    }

}