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

    public static function checkIsAdmin(){
        if($_SESSION["MYSESSION"]['id_role'] != 1){
            header('Location: unauth');
            exit();
        }
    }

    public static function checkSessionToHome(){
        $validate = AuthController::validateAuthToken();
        if($validate && isset($_SESSION["MYSESSION"]) && $validate != "expired"){
            header('Location: home');
        }
    }

    // PÁGINA NO AUTORIZADO
    public static function unAuth(){
        require_once "./src/views/pages/unauthorized.php";
    }

    public static function menuLayout($page = "") {
        self::addScript('./assets/js/menu.js');
        require_once "./src/views/layouts/menuLayout.php";
    }

    // PÁGINA HOME
    public static function home() {
        self::checkSession();
        self::menuLayout('home');
        self::pageScript('home');
        require_once "./src/views/pages/home.php";
    }

    // PÁGINA ORDERS
    public static function orders() {
        self::checkSession();
        self::menuLayout('orders');
        self::pageScript('orders');
        require_once "./src/views/pages/orders.php";
    }

    // PÁGINA PRODUCTS
    public static function products() {
        self::checkSession();
        self::menuLayout('products');
        self::pageScript('products');
        $idcompany = $_SESSION['MYSESSION']['company']['id'];
        $db = new QueryModel();
        $categories = $db->select("reg_category","id_company = $idcompany AND type = 'P'");
        $contacts = $db->select("reg_contact","id_company = $idcompany");
        require_once "./src/views/pages/products.php";
    }

    // PÁGINA SERVICES
    public static function services() {
        self::checkSession();
        self::menuLayout('services');
        self::pageScript('services');
        $idcompany = $_SESSION['MYSESSION']['company']['id'];
        $db = new QueryModel();
        $categories = $db->select("reg_category","id_company = $idcompany AND type = 'S'");
        $contacts = $db->select("reg_contact","id_company = $idcompany");
        require_once "./src/views/pages/services.php";
    }

    // PÁGINA CATEGORIES
    public static function categories() {
        self::checkSession();
        self::menuLayout('categories');
        self::pageScript('categories');
        require_once "./src/views/pages/categories.php";
    }

    // PÁGINA CONTACTS
    public static function contacts() {
        self::checkSession();
        self::menuLayout('contacts');
        self::pageScript('contacts');
        $db = new QueryModel();
        $typesContacts = $db->select("reg_type_contact");
        require_once "./src/views/pages/contacts.php";
    }

    // PÁGINA CONTACTS
    public static function inventory() {
        self::checkSession();
        self::menuLayout('inventory');
        self::pageScript('inventory');
        require_once "./src/views/pages/inventory.php";
    }

    // PÁGINA SALES
    public static function sales() {
        self::checkSession();
        self::menuLayout('sales');
        self::pageScript('sales');
        $db = new QueryModel();
        $payment_methods = $db->select("reg_payment_method","status = 1");
        require_once "./src/views/pages/sales.php";
    }

    // PÁGINA USERS
    public static function users() {
        self::checkSession();
        self::menuLayout('users');
        self::pageScript('users');
        $db = new QueryModel();
        $roles = $db->select("sys_rol");
        require_once "./src/views/pages/users.php";
    }

    // PÁGINA Settings
    public static function settings() {
        self::checkSession();
        self::checkIsAdmin();
        self::menuLayout('settings');
        self::pageScript('settings');
        require_once "./src/views/pages/settings.php";
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