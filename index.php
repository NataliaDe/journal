<?php
//echo 'В связи с проблемами с серверным программным обеспечением ПС "Журнал ЦОУ" временно закрыто.<br>';
//echo 'Ориентировочные сроки запуска 26.12.2018 - 27.12.2018';
//echo 'Сегодня 15.01.2020 с 11:00 до 13:00 будут проводиться технические работы с базами данных программного средства «Журнал ЦОУ» в связи переводом на новый отчетный год
//В этот период программное средство будет недоступно для работы.';
//exit();
session_start();


require_once dirname(__FILE__) . '/bootstrap.php';

/* ----------------- CONSTANT ------------------- */

define('BASE_URL', '/journal');

define(GOCHS, 1); //id_organ
define(ROCHS, 2); //id_organ
define(GROCHS, 3); //id_organ
define(UMCHS, 4); //id_organ
define(RCU, 5); //id_organ
define(PASO, 6); //id_organ
define(PASOO, 7); //id_organ
define(ROSN, 8); //id_organ ROSN
define(UGZ, 9); //id_organ UGZ
define(AVIA, 12); //id_organ AVIACIA

define(DIVIZ_COU_ID,8);//id divizion of cou

define(VER, '4.0');
define(NEWS_DATE, '19.08.2020');

CONST ARCHIVE_YEAR = array(0 => array('table_name' => '2019a'), 1 => array('table_name' => '2020a'));
CONST ARCHIVE_YEAR_LIST = array(2019, 2020);
CONST LIST_MONTH = array(1  => 'январь', 2  => 'февраль', 3  => 'март', 4  => 'апрель', 5  => 'май', 6  => 'июнь', 7  => 'июль', 8  => 'август',
    9  => 'сентябрь', 10 => 'октябрь', 11 => 'ноябрь', 12 => 'декабрь');

const IS_NEW_MODE_ARCHIVE =1;// 1 -older years are on 172.26.200.15
const APP_SERVER='172.26.200.14';

define(ID_BOKK, 23); // = journal.service.id

const REASONRIG_WITH_INFORMING = array(34, 14, 69, 79, 74, 64, 73);
const REASON_FIRE = 34;
CONST REASON_HS = 73;
CONST REASON_OTHER_ZAGOR = 14;
CONST REASON_HELP = array(76,38);
CONST REASON_DEMERK = 68;
CONST REASON_MOLNIA = 74;// + manual js
CONST REASON_LTT = 79;

// work view
CONST REASON_WORK_MOLNIA = 89;// + manual js


CONST CITY_VID=array(111,112,113,212,213,300);//city

const UPLOAD_PATH='data';
const SIZE_SUM_REMARK_RCU_FILE='15000000';


const MIN_OBL_ID=6;

const MIN_OBL_ID_LOCAL=72;



/* PHPWORD */
//const cell_center = array('valign' => 'center', 'align' => 'center');


/* ----------------- END CONSTANT ------------------- */

use \RedBeanPHP\Facade as R;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

require 'libraries/PHPExcel.php';

//require('libraries/PhpWord.php');
//require_once('libraries/PhpWord/TemplateProcessor.php');
//require_once('libraries/PhpWord/Writer/Word2007.php');
//require_once('libraries/htmltoopenxml/src/Parser.php');
//require_once('libraries/PhpWord/Element/Field.php');
//require_once('libraries/PhpWord/Element/Table.php');
//require_once('libraries/PhpWord/Element/TextRun.php');
//require_once('libraries/PhpWord/SimpleType/TblWidth.php');

//require('/vendor/setasign/fpdf.php');

/* ----------------- MODELS --------------------- */

use App\MODELS\Model_Index; // model
use App\MODELS\Model_Region; //область
use App\MODELS\Model_Local; //район
use App\MODELS\Model_Locality; //нас.пункт.
use App\MODELS\Model_Vid_Locality; // vid нас.пункт.
use App\MODELS\Model_Selsovet;
use App\MODELS\Model_Street;
use App\MODELS\Model_Locorgview; //ГРОЧС
use App\MODELS\Model_Pasp; //ПАСЧ
use App\MODELS\Model_User;
use App\MODELS\Model_Permissions;
use App\MODELS\Model_Rig; //вызов
use App\MODELS\Model_People; //заявитель
use App\MODELS\Model_Officebelong; //вед прин
use App\MODELS\Model_Workview; //вид работ
use App\MODELS\Model_Firereason; //причина пожара
use App\MODELS\Model_Statusrig; //статус выезда
use App\MODELS\Model_Statusrigcolor; //статус выезда цвет зависит от пользователя
use App\MODELS\Model_Reasonrigcolor; //причина выезда цвет зависит от пользователя
use App\MODELS\Model_Reasonrig; //прич выезда
use App\MODELS\Model_Service; //службы взаимодействия
use App\MODELS\Model_Innerservice; //привлекаемые силы др ведомств
use App\MODELS\Model_Silymchs; //силы МЧС
use App\MODELS\Model_Rigtable; //таблица с вызовами
use App\MODELS\Model_Jrig; //журнал выезда-машины МЧС с врем характеристиками
use App\MODELS\Model_Destinationlist; //список адресатов
use App\MODELS\Model_Destination;
use App\MODELS\Model_Informing; //информирование
use App\MODELS\Model_Classificator;
use App\MODELS\Model_Listmail; //список email
use App\MODELS\Model_Mailsend; // отправленыые путевки
use App\MODELS\Model_Listmailview; //список email
use App\MODELS\Model_Actionwaybill; //meri dly putevki
use App\MODELS\Model_Loglogin;
use App\MODELS\Model_Logs;
use App\MODELS\Model_Helpers;
//архив
use App\MODELS\Model_Archivedate;
use App\MODELS\Model_Archiveyear;
use App\MODELS\Model_Main;

use App\CLASSES\Class_Phpword;

/* ----------------- END MODELS ----------------- */



/* ----------------- MIDDLEWARE ------------------- */

//use \Slim\Middleware;
//use App\MW\AllCapsMiddleware;
function mw1()
{
    echo "This is middleware!";
}

//авторизован ли пользователь
function is_login()
{
    $app = \Slim\Slim::getInstance();
    if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {

        //Проверяем, не пустые ли нужные нам куки...
        if (!empty($_COOKIE['id_user']) && !empty($_COOKIE['key'])) {
            $permissions = new Model_Permissions();
            $permis = $permissions->selectPermisByCookie($_COOKIE['id_user'], $_COOKIE['cookie']);

            if (!empty($permis)) {
                session_start();
                //write to session
                $_SESSION['id_user'] = $permis['id_user'];
                $_SESSION['user_name'] = $permis['user_name'];
                $_SESSION['id_level'] = $permis['id_level'];
                $_SESSION['id_region'] = $permis['id_region'];
                $_SESSION['id_locorg'] = $permis['id_locorg'];
                $_SESSION['id_local'] = $permis['id_local'];
                $_SESSION['login'] = $permis['login'];
                $_SESSION['password'] = $permis['password'];
                $_SESSION['id_organ'] = $permis['id_organ'];
                $_SESSION['sub'] = $permis['sub'];
                $_SESSION['can_edit'] = $permis['can_edit'];
                $_SESSION['is_admin'] = $permis['is_admin'];
                $_SESSION['auto_ate'] = $permis['auto_ate'];
                $_SESSION['level_name'] = $permis['level_name'];
                $_SESSION['region_name'] = $permis['region_name'];
                $_SESSION['locorg_name'] = $permis['locorg_name'];
                $_SESSION['can_edit_name'] = $permis['can_edit_name'];
                $_SESSION['is_admin_name'] = $permis['is_admin_name'];
                $_SESSION['auto_ate_name'] = $permis['auto_ate_name'];
                $_SESSION['auto_local'] = $permis['auto_local'];
                $_SESSION['auto_locality'] = $permis['auto_locality'];
            } else {
                $app->redirect(BASE_URL . '/login');
            }
        } else {
            $app->redirect(BASE_URL . '/login');
        }
    }
}

function is_permis()
{
    $app = \Slim\Slim::getInstance();

    //user
    if (strpos($app->request->getResourceUri(), 'user')) {
        if ($_SESSION['is_admin'] == 1 && $_SESSION['id_organ'] == RCU) {

        } else {
            $app->redirect(BASE_URL . '/rig');
        }
    }
    //rig
    elseif (strpos($app->request->getResourceUri(), 'rig')) {
        if ($app->request->isDelete() || $app->request->isPut() || $app->request->isPost()) {

            //таблица выездов для РЦУ
            if (strpos($app->request->getResourceUri(), 'for_rcu')) {
                if ($_SESSION['id_level'] != 1) {
                    $app->redirect(BASE_URL . '/rig');
                }
            } elseif (strpos($app->request->getResourceUri(), 'table')) {//табл выездов кроме РЦУ - фильтр по датам
                //если нет прав н ред/доб выездов -  фильтр по датам работает
            } elseif ($_SESSION['can_edit'] != 1) {
                $app->redirect(BASE_URL . '/rig');
            }
        }

        //таблица выездов для РЦУ
        if (strpos($app->request->getResourceUri(), 'for_rcu')) {
            if ($_SESSION['id_level'] != 1) {
                $app->redirect(BASE_URL . '/rig');
            }
        }
    }

    //classificator
    elseif (strpos($app->request->getResourceUri(), 'classif')) {

        if ($_SESSION['id_level'] != 1) {
            if (!strpos($app->request->getResourceUri(), 'destination')) {
                $app->redirect(BASE_URL . '/rig');
            }
        } else {//только РЦУ админ
            if ($app->request->isDelete() || $app->request->isPut() || $app->request->isPost()) {
                if ($_SESSION['is_admin'] != 1) {
                    $app->redirect(BASE_URL . '/rig');
                }
            }
        }
    } elseif (strpos($app->request->getResourceUri(), 'logs')) {
        if ($_SESSION['id_user'] == 2) {// rcu ovpo
        } else {
            $app->redirect(BASE_URL . '/rig');
        }
    }

    //Путевка
    elseif (strpos($app->request->getResourceUri(), 'waybill')) {

        if ($app->request->isDelete() || $app->request->isPut() || $app->request->isPost()) {
            if ($_SESSION['can_edit'] == 0) {
                $app->redirect(BASE_URL . '/rig');
            }
        }
    } elseif (strpos($app->request->getResourceUri(), 'archive_1')) {

        /* only rcu or umchs */
        /*  $arr_organ=array(4,5);
          $arr_level=array(1,2);
          if (in_array($_SESSION['id_level'], $arr_level) && in_array($_SESSION['id_organ'], $arr_organ)) {

          }
          else{
          $app->redirect(BASE_URL . '/no_permission');
          } */
    } elseif (strpos($app->request->getResourceUri(), 'archive')) {

        /* only rcu admin */

        if ($_SESSION['id_user'] != 2) {
            $app->redirect(BASE_URL . '/no_permission');
        }
    } elseif (strpos($app->request->getResourceUri(), 'copy_rig')) {

        if ($_SESSION['can_edit'] != 1) {

            $app->redirect(BASE_URL . '/rig');
        }
    }
    elseif (strpos($app->request->getResourceUri(), 'nii_reports')) {

        if (!in_array($_SESSION['id_user'], array(2,150,433))) {

            $app->redirect(BASE_URL . '/rig');
        }
    }
}
/* ----------------- END MIDDLEWARE -------------- */

/* -------------------------- ФУНКЦИИ ------------------------- */

/* +++ Генерация key for COOKIE +++ */

function generateSalt()
{
    $salt = '';
    $saltLength = 8; //длина соли
    for ($i = 0; $i < $saltLength; $i++) {
        $salt .= chr(mt_rand(33, 126)); //символ из ASCII-table
    }
    return $salt;
}
/* +++ END Генерация key for COOKIE +++ */


/* ++ Вывод ошибок после валидации формы ++ */
/* array - массив ошибок
 *  url_back - на какую страницу перейти, если нужна конкретная стр
 *  post - post-данные, которые надо отрисовать  в виде формы и выполнить обратный переход методом post
 *  path_to_form_back - путь до файла с формой с кнопкой назад
 */

function show_error($array, $url_back = NULL, $post = NULL, $path_to_form_back = NULL)
{
    $data['error'] = $array;
    $data['url_back'] = $url_back;
    $data['post'] = $post;
    $data['path_to_form_back'] = $path_to_form_back;
    $app = \Slim\Slim::getInstance();
    $app->render('layouts/header.php');

    $data['path_to_view'] = 'error_show.php';
    $app->render('layouts/div_wrapper.php', $data);
    $app->render('layouts/footer.php');
}
/* ++ КОНЕЦ Вывод ошибок после валидации формы ++ */


/* +++ Поиск выезда по введенному Id +++ */

function search_rig_by_id($rig_m, $id_rig)
{

    $rig = $rig_m->selectAllByIdRig($id_rig, 0); //неудаленный выезд

    if (empty($rig)) {

        $rig = array();
    }

    return $rig;
}
/* +++ Поиск выезда по введенному Id +++ */


/* empty or no technics, time character, informing in rig. If empty - icon is red */

function empty_icons($id_rig_arr, $tab = null,$ids_rig_for_character=[])
{
    $result = array();

    /* id of rigs, where silymschs/innerservice are not selected */

    if (!empty($id_rig_arr) && $tab == null) {

        /* silymchs is empty */
        $id_rig_empty_sily = R::getAll('SELECT id_rig FROM countsily WHERE c=? AND id_rig IN (' . implode(',', $id_rig_arr) . ')', array(0));

        $id_rig = array();

        if (!empty($id_rig_empty_sily)) {
            foreach ($id_rig_empty_sily as $value) {
                $id_rig[] = $value['id_rig'];
            }
        }


        /* innerservice is not empty  for this rigs */
        $id_rig_empty_inner = array();
        if (!empty($id_rig)) {
            $id_rig_empty_inner = R::getAll('SELECT id_rig FROM countinnerservice WHERE c=? AND id_rig IN (' . implode(',', $id_rig) . ')', array(1));
        }

        /* if innerservice is not empty for this rigs - then delete id_rig from list */
        if (!empty($id_rig_empty_inner)) {
            $id_rig_inner = array();
            foreach ($id_rig_empty_inner as $value) {
                $id_rig_inner[] = $value['id_rig'];
            }
            /* delete id_rig where innerservice is not empty from list */
            $result_sily = array_diff($id_rig, $id_rig_inner);
        } else {
            $result_sily = $id_rig;
        }

        $result['car'] = $result_sily;
    }

    /* END id of rigs, where silymschs/innerservice are not selected */


    /* id of rigs, where informing are not selected */
    if (!empty($id_rig_arr) && $tab == 'informing') {

        $id_rig_empty_informing = R::getAll('SELECT id_rig FROM countinforming WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ')', array(0));
        $informing = array();
        if (!empty($id_rig_empty_informing)) {
            foreach ($id_rig_empty_informing as $value) {
                $informing[] = $value['id_rig'];
            }
        }

        $result['informing'] = $informing;
    }
    /* END id of rigs, where informing are not selected */


    /* id of rigs, where time character are not selected */
    if (!empty($ids_rig_for_character) && $tab == null) {

        $id_rig_empty_character = R::getAll('SELECT id_rig FROM countcharacter WHERE  id_rig IN(' . implode(',', $ids_rig_for_character) . ')');
        $character = array();

        if (!empty($id_rig_empty_character)) {
            foreach ($id_rig_empty_character as $value) {
                $character[] = $value['id_rig'];
            }
        }
        $result['character'] = $character;
    }
    /* END id of rigs, where time character are not selected */
    // print_r($result);
    //exit();
    return $result;
}

function get_users_connect_sd($id_user = 0)
{
    $res = [];
    if ($id_user != 0) {
        $users = R::getCell("SELECT id from journal.user WHERE id_user_sd is NOT NULL AND id = ?", array($id_user));
        if (!empty($users))
            $res[] = $id_user;
    } else {
        $users = R::getAll("SELECT id from journal.user WHERE id_user_sd is NOT NULL");

        if (!empty($users)) {
            foreach ($users as $row) {
                $res[] = $row['id'];
            }
        }
    }

    return $res;
}

function order_rigs($a, $b)
{
    return strcmp($b["full_time_msg"], $a["full_time_msg"]);
}

function order_rigs_asc($a, $b)
{
    return strcmp($a["full_time_msg"], $b["full_time_msg"]);
}

function get_notifications($id_user)
{
    $user_m = new Model_User();
    $notif = $user_m->selectNotifications($id_user);

    if (isset($notif) && !empty($notif)) {

    }
}

function set_notifications($id_user)
{
    $user_m = new Model_User();
    $notif = $user_m->getCntUnseenNotif($id_user);

    if (isset($notif) && !empty($notif) && isset($_SESSION['id_user'])) {
        $_SESSION['cnt_unseen_notifications'] = $notif;
    } elseif (isset($_SESSION['cnt_unseen_notifications'])) {
        unset($_SESSION['cnt_unseen_notifications']);
    }
}

function do_login($permis)
{
    $_SESSION['id_user'] = $permis['id_user'];
    $_SESSION['user_name'] = $permis['user_name'];
    $_SESSION['id_level'] = $permis['id_level'];
    $_SESSION['id_region'] = $permis['id_region'];
    $_SESSION['id_locorg'] = $permis['id_locorg'];
    $_SESSION['id_local'] = $permis['id_local'];
    $_SESSION['login'] = $permis['login'];
    $_SESSION['password'] = $permis['password'];
    $_SESSION['id_organ'] = $permis['id_organ'];
    $_SESSION['sub'] = $permis['sub'];
    $_SESSION['can_edit'] = $permis['can_edit'];
    $_SESSION['is_admin'] = $permis['is_admin'];
    $_SESSION['auto_ate'] = $permis['auto_ate'];
    $_SESSION['level_name'] = $permis['level_name'];
    $_SESSION['region_name'] = $permis['region_name'];
    $_SESSION['locorg_name'] = $permis['locorg_name'];
    $_SESSION['can_edit_name'] = $permis['can_edit_name'];
    $_SESSION['is_admin_name'] = $permis['is_admin_name'];
    $_SESSION['auto_ate_name'] = $permis['auto_ate_name'];
    $_SESSION['auto_local'] = $permis['auto_local'];
    $_SESSION['auto_locality'] = $permis['auto_locality'];
}

function set_cookie($permis)
{
    //Сформируем случайную строку для куки (используем функцию generateSalt):
    $key = generateSalt(); //назовем ее $key
    //Пишем куки (имя куки, значение, время жизни - без времени)
    setcookie('id_user', $permis['id_user']);
    setcookie('key', $key); //случайная строка

    /*
      Пишем эту же куку в базу данных для данного юзера.

      Формируем и отсылаем SQL запрос:
      ОБНОВИТЬ  таблицу_users УСТАНОВИТЬ cookie = $key ГДЕ id_user=$permis['id_user'].
     */
    $u = R::load('user', $permis['id_user']);
    $u->cookie = $key;
    R::store($u);
}
/* -------------------------- END ФУНКЦИИ ------------------------- */



 function get_pdo_15 ($s='172.26.200.15') {
//$s='172.26.200.15';
             $dsn = 'mysql:host='.$s.';dbname=jarchive;charset=utf8';
    $usr = 'str_natali';
    $pwd = 'str_natali';

    $pdo = new PDO($dsn, $usr, $pwd);

    return $pdo;

//    $db= array(
//    'driver' => 'mysql',
//        'host' => '172.26.200.15',
//    'user' => 'str_natali',
//    'pass' => 'str_natali',
//    'dbname' => 'journal'
//
//);
//    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
//        $db['user'], $db['pass']);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//    return $pdo;
//         $dbhost="172.26.200.15";
//    $dbuser="str_natali";
//    $dbpass="str_natali";
//    $dbname="journal";
//    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
//    //$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    return $dbh;
}


/* -------------- baseUrl ---------------------- */

$app->hook('slim.before', function () use ($app) {
    $app->view()->appendData(array('baseUrl' => '/journal','is_new_mode_archive'=>IS_NEW_MODE_ARCHIVE,'app_server'=>APP_SERVER));
});
/* -------------- END baseUrl ---------------------- */



/* ------------------------- LogOn ------------------------------- */

$app->group('/login', function () use ($app, $log) {
    // view form login
    $app->get('/', function () use ($app) {

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'login/loginForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //log in
    $app->post('/', function () use ($app, $log) {

        /* ++ обработка POST-данных ++ */
        $login = ($app->request()->post('login') == '') ? NULL : $app->request()->post('login');
        $password = ($app->request()->post('password') == '') ? NULL : $app->request()->post('password');
        /* ++  КОНЕЦ обработка POST-данных ++ */

        if (!empty($login) && !empty($password)) {
            $permissions = new Model_Permissions();
            $permis = $permissions->selectPermisByLogin($login, $password);

            //print_r($permis);
            //exit();
            //print_r($permis);
            if (!empty($permis)) {
                //write to session
                do_login($permis);
//                $_SESSION['id_user'] = $permis['id_user'];
//                $_SESSION['user_name'] = $permis['user_name'];
//                $_SESSION['id_level'] = $permis['id_level'];
//                $_SESSION['id_region'] = $permis['id_region'];
//                $_SESSION['id_locorg'] = $permis['id_locorg'];
//                $_SESSION['id_local'] = $permis['id_local'];
//                $_SESSION['login'] = $permis['login'];
//                $_SESSION['password'] = $permis['password'];
//                $_SESSION['id_organ'] = $permis['id_organ'];
//                $_SESSION['sub'] = $permis['sub'];
//                $_SESSION['can_edit'] = $permis['can_edit'];
//                $_SESSION['is_admin'] = $permis['is_admin'];
//                $_SESSION['auto_ate'] = $permis['auto_ate'];
//                $_SESSION['level_name'] = $permis['level_name'];
//                $_SESSION['region_name'] = $permis['region_name'];
//                $_SESSION['locorg_name'] = $permis['locorg_name'];
//                $_SESSION['can_edit_name'] = $permis['can_edit_name'];
//                $_SESSION['is_admin_name'] = $permis['is_admin_name'];
//                $_SESSION['auto_ate_name'] = $permis['auto_ate_name'];
//                $_SESSION['auto_local'] = $permis['auto_local'];
//                $_SESSION['auto_locality'] = $permis['auto_locality'];
                //Проверяем, что была нажата галочка 'Запомнить меня':
                if (!empty($_POST['remember_me']) && $_POST['remember_me'] == 1) {
                    /* ------ Cookie ------ */

                    set_cookie($permis);
                    //Сформируем случайную строку для куки (используем функцию generateSalt):
//                    $key = generateSalt(); //назовем ее $key
//                    //Пишем куки (имя куки, значение, время жизни - без времени)
//                    setcookie('id_user', $permis['id_user']);
//                    setcookie('key', $key); //случайная строка
//
//                    /*
//                      Пишем эту же куку в базу данных для данного юзера.
//
//                      Формируем и отсылаем SQL запрос:
//                      ОБНОВИТЬ  таблицу_users УСТАНОВИТЬ cookie = $key ГДЕ id_user=$permis['id_user'].
//                     */
//                    $u = R::load('user', $permis['id_user']);
//                    $u->cookie = $key;
//                    R::store($u);

                    /* ------ Cookie ------ */
                }

                $array = array('time' => date("Y-m-d H:i:s"), 'ip-address' => $_SERVER['REMOTE_ADDR'], 'login' => $login, 'password' => $password, 'user_name' => $_SESSION['user_name']);
                $log_array = json_encode($array, JSON_UNESCAPED_UNICODE);
                $log->info('Сессия -  :: Вход пользователя с - id = ' . $_SESSION['id_user'] . ' данные - : ' . $log_array); //запись в logs



                /* save log to bd */
                $arr = array('user_id' => $_SESSION['id_user'], 'user_name' => $_SESSION['user_name'], 'region_name' => $_SESSION['region_name'], 'locorg_name' => $_SESSION['locorg_name']);
                $loglogin = new Model_Loglogin();
                $loglogin->save($arr, 1);

                set_notifications($_SESSION['id_user']);


                if (isset($_SESSION['id_ghost']))
                    unset($_SESSION['id_ghost']);

                $app->redirect(BASE_URL . '/rig');
            } else {
                $app->redirect(BASE_URL . '/login');
            }
        } else {
            $app->redirect(BASE_URL . '/login');
        }
    });
});

//logout
$app->get('/logout', function () use ($app, $log) {

    $array = array('time' => date("Y-m-d H:i:s"), 'ip-address' => $_SERVER['REMOTE_ADDR'], 'login' => $_SESSION['login'], 'password' => $_SESSION['password'], 'user_name' => $_SESSION['user_name']);
    $log_array = json_encode($array, JSON_UNESCAPED_UNICODE);
    $log->info('Сессия -  :: Выход пользователя с - id = ' . $_SESSION['id_user'] . ' выполнил ' . $_SESSION['user_name'] . ' данные - : ' . $log_array); //запись в logs


    /* save log to bd */
    $arr = array('user_id' => $_SESSION['id_user'], 'user_name' => $_SESSION['user_name'], 'region_name' => $_SESSION['region_name'], 'locorg_name' => $_SESSION['locorg_name']);
    $loglogin = new Model_Loglogin();
    $loglogin->save($arr, 0);

    //
    // if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
    //session_start();
    //$_SESSION=array();
    session_destroy();
    //unset($_SESSION);
    //Удаляем куки авторизации путем установления времени их жизни на текущий момент:
    setcookie('id_user', '', time()); //удаляем id_user
    setcookie('key', '', time()); //удаляем ключ
    // }

    $app->redirect(BASE_URL . '/login');
});

/* ------------------------- END  LogOn ------------------------------- */


$app->get('/', function () use ($app) {

    if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
        $app->redirect(BASE_URL . '/rig');
    } else {
        $app->redirect(BASE_URL . '/login');
    }
});

$app->get('/hello/:type', 'mw1', function ($type) use ($app, $log) {
    //$r=R::getAll('select * from organs');
    // $log->info('Сессия -  :: Редактирование listfiostr - запись с id=1 - Данные:: ');

    $g = new Model_Index();
    $guests = $g->getAll(TRUE);

    foreach ($guests as $value) {
        echo $value['name'];
    }

    $app->render('layouts/header.php');

    $app->render('test/test.php');
    $app->render('layouts/footer.php');
});



/* ------------------------- user ------------------------------- */

$app->group('/user', 'is_login', 'is_permis', function () use ($app, $log) {

    // form user - add, edit
    $app->get('/new(/:id)', function ($id = 0) use ($app) {

        $data['title'] = 'Новый пользователь';

        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll();
        $locorg = new Model_Locorgview();
        $data['locorg'] = $locorg->selectAll();

        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        $locality = new Model_Locality();
        $data['locality'] = $locality->selectAll(); //нас.пункты

        $data['ranks'] = R::getAll('select * from rank');

        /*         * *** КОНЕЦ Классификаторы **** */

        $data['id'] = $id; //id user
        //edit user
        if ($id != 0) {
            $bread_crumb = array('Пользователи', 'Редактировать');

            $user = new Model_User();
            $data['user'] = $user->selectUserById($id);
        }
        //add user
        else {
            $bread_crumb = array('Пользователи', 'Создать');
        }

        if ($id != 0) {

            $data['users_sd'] = R::getAll('select * from speciald.permissions as u where u.is_delete = ? and u.is_guest = ?'
                    . ' AND u.id_user NOT IN (SELECT id_user_sd from journal.user WHERE id_user_sd is NOT NULL AND id != ?)', array(0, 0, $id));
        } else {
            $data['users_sd'] = R::getAll('select * from speciald.permissions as u where u.is_delete = ? and u.is_guest = ?'
                    . ' AND u.id_user NOT IN (SELECT id_user_sd from journal.user WHERE id_user_sd is NOT NULL)', array(0, 0));
        }

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'user/userForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    // add, edit user
    $app->post('/new(/:id)', function ($id = 0) use ($app, $log) {

        /* ++ обработка POST-данных ++ */
        $id_organ = ($app->request()->post('id_organ') == '') ? 0 : $app->request()->post('id_organ');
        $id_region = ($app->request()->post('id_region') == '') ? 0 : $app->request()->post('id_region');
        $id_locorg = ($app->request()->post('id_locorg') == '') ? 0 : $app->request()->post('id_locorg');
        $name = ($app->request()->post('name') == '') ? 0 : $app->request()->post('name');
        $login = ($app->request()->post('login') == '') ? 112 : $app->request()->post('login');
        $password = ($app->request()->post('password') == '') ? NULL : $app->request()->post('password');
        $can_edit = (isset($_POST['can_edit'])) ? 1 : 0;
        $is_admin = (isset($_POST['is_admin'])) ? 1 : 0;
        $auto_ate = (isset($_POST['auto_ate'])) ? 1 : 0;
        $sub = ($id_organ == RCU) ? 1 : ( ($id_organ == ROSN || $id_organ == UGZ || $id_organ == AVIA) ? 2 : 0);
        $id_level = ($id_organ == RCU) ? 1 : ($id_organ == UMCHS || (($id_organ == ROSN || $id_organ == UGZ || $id_organ == AVIA) && $id_region == 3) ? 2 : 3);
        $auto_local = ($app->request()->post('auto_local') == '') ? 0 : $app->request()->post('auto_local');
        $auto_locality = ($app->request()->post('auto_locality') == '') ? 0 : $app->request()->post('auto_locality');

        $array['name'] = $name;
        $array['id_level'] = $id_level;
        $array['id_region'] = $id_region;
        $array['id_locorg'] = $id_locorg;
        $array['login'] = $login;
        $array['password'] = $password;
        $array['id_organ'] = $id_organ;
        $array['sub'] = $sub;
        $array['can_edit'] = $can_edit;
        $array['is_admin'] = $is_admin;
        $array['auto_ate'] = $auto_ate;
        $array['auto_local'] = $auto_local;
        $array['auto_locality'] = $auto_locality;


        /* for special d */
        $id_user_sd = $app->request()->post('id_user_sd');
        if (isset($id_user_sd) && !empty($id_user_sd)) {//connect with user SD
            $array['id_user_sd'] = $id_user_sd;
        } else {
            $array['id_user_sd'] = null;
            $fio_for_speciald = (trim($app->request()->post('fio_for_speciald')) == '') ? '' : trim($app->request()->post('fio_for_speciald'));
            $position_for_speciald = (trim($app->request()->post('position_for_speciald')) == '') ? '' : trim($app->request()->post('position_for_speciald'));
            $id_rank = ($app->request()->post('id_rank') == '') ? 0 : $app->request()->post('id_rank');
            $creator_name_for_speciald = (trim($app->request()->post('creator_name_for_speciald')) == '') ? '' : trim($app->request()->post('creator_name_for_speciald'));

            $array['fio_for_speciald'] = $fio_for_speciald;
            $array['position_for_speciald'] = $position_for_speciald;
            $array['id_rank'] = $id_rank;
            $array['creator_name_for_speciald'] = $creator_name_for_speciald;
        }
        /* END for special d */


        /* ++  КОНЕЦ обработка POST-данных ++ */

        $user = new Model_User();
        $ok = $user->save($array, $id); //save user

        if ($ok) {
            $log_array = json_encode($array, JSON_UNESCAPED_UNICODE);
            $log->info('Сессия -  :: Сохранение пользователя - id = ' . $id . ' выполнил ' . $_SESSION['user_name'] . ' данные - : ' . $log_array); //запись в logs
            $app->redirect(BASE_URL . '/user');
        } else {
            $data['title'] = 'Новый пользователь';
            $bread_crumb = array('Пользователи');
            $data['bread_crumb'] = $bread_crumb;

            $app->render('layouts/header.php', $data);
            $data['path_to_view'] = 'user/error.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
    });

    //таблица с пользователями
    $app->get('/', function () use ($app) {
        $data['title'] = 'Пользователи';
        $permis = new Model_Permissions();
        $data['permissions'] = $permis->selectAll();
        $bread_crumb = array('Пользователи');
        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'user/userTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //вопрос об удалении пользователя
    $app->get('/:id', function ($id) use ($app) {

        $data['title'] = 'Удаление пользователя';

        $bread_crumb = array('Пользователи', 'Удалить');
        $data['bread_crumb'] = $bread_crumb;

        $data['id'] = $id;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'user/questionOfDelete.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    })->conditions(array('id' => '\d+'));

    //удаление пользователя
    $app->delete('/:id', function ($id) use ($app, $log) {
        //delete from bd
        $user = new Model_User();

        if ($user->deleteUserById($id)) {
            $log->info('Сессия -  :: Удаление пользователя - запись с id = ' . $id . ' выполнил ' . $_SESSION['user_name']); //запись в logs
            $app->redirect(BASE_URL . '/user');
        } else {
            $app->redirect(BASE_URL . '/error');
        }
    })->conditions(array('id' => '\d+'));
});

/* ------------------------- END  user ------------------------------- */



/* ------------------------- rig ------------------------------- */

$app->group('/rig', 'is_login', 'is_permis', function () use ($app, $log) {

    // form rig - add, edit
    $app->get('/new(/:id(/:active_tab))', function ($id = 0, $active_tab = 1) use ($app) {


        $data['settings_user'] = getSettingsUser();
        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            if (in_array($active_tab, array(10, 20, 30))) {
                $data['new_active_tab'] = $active_tab;
                $active_tab = 1;
            }
        }

        $data['active_tab'] = $active_tab; //number of active tab
        $data['id'] = $id; //id of rig


        $cp = array(8, 9, 12);

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;
        $data['reasons_for_sim']=array(REASON_MOLNIA);
        $data['work_for_sim']=array(REASON_WORK_MOLNIA);

        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $locorg = new Model_Locorgview();
        $data['locorg'] = $locorg->selectAll(1); //выбрать все подразд кроме РЦУ, УМЧС(там нет техники)
        $pasp = new Model_Pasp();
        $data['pasp'] = $pasp->selectAll();

        $main_model=new Model_Main();
        $data['owner_categories']=$main_model->get_owner_categories();

        if ($active_tab != 2) {

            $local = new Model_Local();
            // $data['local'] = $local->selectAll(); //районы
            $locality = new Model_Locality();
            //$data['locality'] = $locality->selectAll(); //нас.пункты
            $street = new Model_Street();
            // $data['street'] = $street->selectAll(); //улицы
            $selsovet = new Model_Selsovet();
            //$data['selsovet'] = $selsovet->selectAll();
            $vid_locality_m = new Model_Vid_Locality();
            $data['vid_locality'] = $vid_locality_m->selectAll();
            $reasonrig = new Model_Reasonrig();
            $data['reasonrig'] = $reasonrig->selectAll(1);
            $officebelong = new Model_Officebelong();
            $data['officebelong'] = $officebelong->selectAll();
            $workview = new Model_Workview();
            $data['workview'] = $workview->selectAll();
            $firereason = new Model_Firereason();
            $data['firereason'] = $firereason->selectAll();
            $statusrig = new Model_Statusrig();
            $data['statusrig'] = $statusrig->selectAll();
        }

        $service = new Model_Service();
        $data['service'] = $service->selectAll();

        /*         * *** КОНЕЦ Классификаторы **** */

        /* ------------- Редактирование выезда -------------- */

        if ($id != 0) {

            $rig_table_m = new Model_Rigtable();
            $inf_rig = $rig_table_m->selectByIdRig($id); // дата, время, адрес объекта для редактируемого вызова по id
            // инф по вызову
            $rig_m = new Model_Rig();
            $rig = $rig_m->selectAllById($id);
            $data['is_sily_mchs'] = $rig['is_sily_mchs'];

            if ($active_tab != 2) {
                // инф по вызову
                $rig_m = new Model_Rig();
                $rig = $rig_m->selectAllById($id);
                $data['rig'] = $rig;


                /* ------------------ выбор классификаторов с учетом редактируемого вызова ------------------- */
                $data['local'] = $local->selectAllByRegion($rig['id_region']); //районы для области редактируемого вызова

                if ($rig['id_local'] != 0) {

                    $id_loc = ($rig['id_local'] < 0) ? 123 : $rig['id_local'];

                    $data['selsovet'] = $selsovet->selectAllByLocal($id_loc); //сельсоветы для района редактируемого вызова
                    $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района
                } elseif ($rig['id_region'] != 0) {
                    $data['locality'] = $locality->selectAllByRegion($rig['id_region']); //нас.пункты области
                }

                if ($rig['id_locality'] != 0) {
                    $data['street'] = $street->selectAllByLocality($rig['id_locality']); //улицы
                }

                /* ------------------ END выбор классификаторов с учетом редактируемого вызова ------------------- */


                //инф по заявителю
                $people = new Model_People();
                $data['people'] = $people->selectAllByIdRig($id);
            }



            //инф по привлекаемым СиС МЧС
            $silymchs = new Model_Silymchs();
            $data['silymchs'] = $silymchs->selectGroupByPasp($id);

            //техника МЧС  на выезде-отметить в списке как (В)
            $teh_on_rig_m = new Model_Silymchs();
            $teh_on_rig = $teh_on_rig_m->selectAllOnRig();
            $data['teh_on_rig'] = $teh_on_rig;


            //инф по СиС др ведомств
            $innerservice = new Model_Innerservice();
            $data['innerservice'] = $innerservice->selectAllByIdRig($id);

            /* is updeting now ?  */
            $is_update_now = is_update_rig_now($rig, $id);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['is_update_now'] = $is_update_now;
            }
            //  exit();

            /* is updeting now ?  */
        }

        /* ------------- КОНЕЦ Редактирование выезда -------------- */ else {

            //если по умолчанию выбирать в адресе район - город( Витебск, Жодино,...), то надо подгрузить сразу нас.пункты и улицы
            $city = array(21, 22, 123, 124, 135, 136, 137, 138, 139, 140, 141);

//$_SESSION['auto_local']<0 только для районов г.минска
            if (in_array($_SESSION['auto_local'], $city) || ($_SESSION['auto_local'] < 0)) {//если по умолчанию город выбран
                $data['auto_local_city'] = $city;

                //если районы г.Минска - выбрать нас пунктом г.Минск
                $id_loc = ($_SESSION['auto_local'] < 0) ? 123 : $_SESSION['auto_local'];

                $locality_result = $locality->selectAllByLocal($id_loc); //нас.пункты района
                //print_r($locality_result);
                $data['locality'] = $locality_result;
                foreach ($locality_result as $value) {
                    $id_locality = $value['id'];
                }

                //  echo $id_locality;
                //exit();
                $data['street'] = $street->selectAllByLocality($id_locality); //улицы района
            } else {
                if ($_SESSION['auto_local'] != 0) {

                    //если районы г.Минска - выбрать нас пунктом г.Минск
                    $id_loc = ($_SESSION['auto_local'] < 0) ? 123 : $_SESSION['auto_local'];

                    $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района

                    $data['selsovet'] = $selsovet->selectAllByLocal($_SESSION['auto_local']); //сельсоветы для района
                }
            }


            $data['local'] = $local->selectAllByRegion($_SESSION['id_region']); //районы авторизованной области
        }



        if ($active_tab != 2) {
            /* guide pasp  */
            if ($_SESSION['id_level'] == 1 && $_SESSION['id_organ'] == 5) {//rcu
                $data['podr'] = R::getAll('select g.*,r.id_loc_org,  r.locorg_name, r.pasp_name as pasp_name_1, concat(r.pasp_name,", ",r.locorg_name,", ",r.region_name) as pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp  ');
            } elseif ($_SESSION['id_level'] == 3 && !in_array($_SESSION['id_organ'], $cp)) {//rochs
                //$data['podr'] = R::getAll('select g.*,r.id_loc_org,  r.locorg_name, r.pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp where r.id_loc_org = ? ', array($_SESSION['id_locorg']));

                if (!isset($data['settings_user']['is_show_paso_zanyatia']) || ((isset($data['settings_user']['is_show_paso_zanyatia']) && $data['settings_user']['is_show_paso_zanyatia']['name_sign'] == 'yes'))) {
                    $data['podr'] = R::getAll('select g.*, r.id_loc_org, r.locorg_name, (CASE WHEN ( r.of_gohs is not null and r.name_paso_object is not null ) THEN CONCAT(r.pasp_name," ",r.locorg_name, " (",r.name_paso_object,")")
when (r.of_gohs is not null)  THEN CONCAT(r.pasp_name," ",r.locorg_name)
 WHEN (r.of_gohs IS  NULL AND r.`id_organ`=6)  THEN CONCAT(r.locorg_name) ELSE r.pasp_name END) AS `pasp_name`, r.of_gohs from guidepasp as g left join pasp as r on r.id=g.id_pasp where (r.id_loc_org = ? or r.of_gohs = ?) or (r.id_region = ? AND r.id_organ = ? AND r.id_divizion <> ?) ', array($_SESSION['id_locorg'], $_SESSION['id_locorg'], $_SESSION['id_region'], PASO, DIVIZ_COU_ID));
                } else {
                    $data['podr'] = R::getAll('select g.*, r.id_loc_org, r.locorg_name, (CASE WHEN ( r.of_gohs is not null and r.name_paso_object is not null ) THEN CONCAT(r.pasp_name," ",r.locorg_name, " (",r.name_paso_object,")")
when (r.of_gohs is not null)  THEN CONCAT(r.pasp_name," ",r.locorg_name)
 WHEN (r.of_gohs IS  NULL AND r.`id_organ`=6)  THEN CONCAT(r.locorg_name) ELSE r.pasp_name END) AS `pasp_name`, r.of_gohs from guidepasp as g left join pasp as r on r.id=g.id_pasp where (r.id_loc_org = ? or r.of_gohs = ?)  ', array($_SESSION['id_locorg'], $_SESSION['id_locorg']));
                }
            } elseif ($_SESSION['id_level'] == 3 && in_array($_SESSION['id_organ'], $cp)) {//rosn pinsk
                $data['podr'] = R::getAll('select g.*,r.id_loc_org,  r.locorg_name, r.pasp_name  from guidepasp as g left join pasp as r on r.id=g.id_pasp  where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
            } elseif ($_SESSION['id_level'] == 2 && in_array($_SESSION['id_organ'], $cp)) {//rosn, ugz,avia - all g. Minsk
                $data['podr'] = R::getAll('select g.*,r.id_loc_org,  r.locorg_name, r.pasp_name  from guidepasp as g left join pasp as r on r.id=g.id_pasp  where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
            } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] == 3) {//umchs g.Minsk
                $data['podr'] = R::getAll('select g.*,r.id_loc_org,  r.locorg_name, r.pasp_name as pasp_name_1, concat(r.pasp_name,", ",r.locorg_name) as pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp  where r.id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array(3));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array(3));
            } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] != 3) {//umchs
                $data['podr'] = R::getAll('select g.*,r.id_loc_org,  r.locorg_name, r.pasp_name as pasp_name_1, concat(r.pasp_name,", ",r.locorg_name) as pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp  where r.id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array($_SESSION['id_region']));
            }
        }


        if ($id == 0) {
            $bread_crumb = array('Создать выезд');
            $data['title'] = 'Новый выезд';
        } elseif ($active_tab == 2) {
            $bread_crumb = array('Редактирование выезда');
            $data['title'] = 'Высылка техника';
        } else {
            $bread_crumb = array('Редактирование выезда');
            $data['title'] = 'Редактирование выезда';
        }

        /* --------- добавить инф о редактируемом вызове ------------ */

        if ($id != 0) {

            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];

                    $data['id_user'] = $value['id_user'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }
        }

        /* --------- добавить инф о редактируемом вызове ------------ */


        $paso_object = R::getAll('select * from paso_object');
        if (!empty($paso_object)) {
            foreach ($paso_object as $row) {
                $data['paso_object'][$row['id_locorg']] = $row['name'];
            }
        }

        $data['bread_crumb'] = $bread_crumb;
        $data['bread_crumb_addr'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'rig/tabsRig/rigForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    // form informing
    $app->get('/:id/info', function ($id) use ($app) {

        $bread_crumb = array('Информирование');
        $data['title'] = 'Информирование';
        $data['title_block'] = 'info';

        $data['id_rig'] = $id;

        $data['settings_user'] = getSettingsUser();

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;


        /* --------- добавить инф о редактируемом вызове ------------ */
        if ($id != 0) {

            $rig_table_m = new Model_Rigtable();
            $inf_rig = $rig_table_m->selectByIdRig($id); // дата, время, адрес объекта для редактируемого вызова по id

            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];

                    $data['id_user'] = $value['id_user'];
                    $data['current_reason_rig'] = $value['id_reasonrig'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }

            /* is updeting now ?  */
            $rig_m = new Model_Rig();
            $rig = $rig_m->selectAllById($id);

            $is_update_now = is_update_rig_now($rig, $id);
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['is_update_now'] = $is_update_now;
            }
            /* is updeting now ?  */

            //is infroming
            $data['is_informing'] = $rig->is_informing;
        }
        /* --------- добавить инф о редактируемом вызове ------------ */


        $data['bread_crumb'] = $bread_crumb;

        /*         * ********* Классификаторы ************* */
        $destination_m = new Model_Destinationlist();
        $data['destinationlist'] = $destination_m->selectAll(); //Список адресатов
        $data['destinations'] = $destination_m->select_destinations();

        /*         * ********* КОНЕЦ Классификаторы************* */

        /* --------------- Уже существующие адресаты по выезду ------------------- */
        $informing_m = new Model_Informing();
        $data['informing_by_rig'] = $informing_m->selectAllByIdRig($id);
        /* --------------- КОНЕЦ Уже существующие адресаты по выезду ------------------- */

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'rig/info/infoForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //save info
    $app->post('/:id/info', function ($id) use ($app, $log) {

        /*         * ********* Обработка POST-данных************* */
        $informing_m = new Model_Informing();

        $data['settings_user'] = getSettingsUser();


        /* did informing get involved or not */
        $is_informing = $app->request()->post('is_informing');
        if (isset($is_informing) && !empty($is_informing) && $is_informing == 1) {//no
            $is_informing = 1;
        } else {//involved
            $is_informing = 0;
        }
        $post_info = $informing_m->getPOSTData();
        //update rig
        $rig = R::findOne('rig', 'id = ? ', [$id]);
        if (isset($rig) && !empty($rig)) {
            $rig->is_informing = $is_informing;
            R::store($rig);
        }



        $post_info = $informing_m->getPOSTData();

//        print_r($post_info);
//        exit();

        /*         * ********* КОНЕЦ Обработка POST-данных ************* */

        /* -------- Прошла ли валидация ------- */
        if (!empty($post_info['error'])) {
            show_error($post_info['error']);
            exit();
        }
        /* -------- КОНЕЦ Прошла ли валидация ------- */

        /* ------------------------------- Сохранить информированных адресатов по данному вызову ------------------------------------ */
        $informing_m->save($post_info, $id); //
        /* ---------------------------- КОНЕЦ Сохранить информированных адресатов по данному вызову---------------------------- */

        /* is updeting now ?  */
        if ($id != 0) {//edit
            unset_update_rig_now($id);
        }

        $log_post_info = json_encode($post_info, JSON_UNESCAPED_UNICODE);
        $log->info('Сессия -  :: Сохранение ИНФОРМИРОВАНИЕ - id_rig = ' . $id . ' данные - : ' . $log_post_info); //запись в logs

        /* save log to bd */
        $action = 'редактирование информирования по выезду';
        $arr = array('s_user_id' => $_SESSION['id_user'], 's_user_name' => $_SESSION['user_name'], 's_region_name' => $_SESSION['region_name'], 's_locorg_name' => $_SESSION['locorg_name'], 'id_rig' => $id, 'action' => $action);
        $logg = new Model_Logs();
        $logg->save($arr);

        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            $app->redirect(BASE_URL . '/rig/' . $id . '/info');
        } else {
            $app->redirect(BASE_URL . '/rig');
        }
    });


    // form time character, journal of rigs
    $app->get('/:id/character', function ($id) use ($app) {

        $bread_crumb = array('Временные характеристики выезда');

        $data['title'] = 'Временные характеристики выезда';
        $data['title_block'] = 'time';

        $data['id'] = $id;

        $data['settings_user'] = getSettingsUser();

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;


        /* --------- добавить инф о редактируемом вызове ------------ */
        if ($id != 0) {

            $rig_table_m = new Model_Rigtable();
            $inf_rig = $rig_table_m->selectByIdRig($id); // дата, время, адрес объекта для редактируемого вызова по id

            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];
                    $data['id_user'] = $value['id_user'];
                    $data['id_reasonrig'] = $value['id_reasonrig'];
                    $data['current_reason_rig'] = $value['id_reasonrig'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }

            /* is updeting now ?  */
            $rig_m = new Model_Rig();
            $rig = $rig_m->selectAllById($id);

            $is_update_now = is_update_rig_now($rig, $id);
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['is_update_now'] = $is_update_now;
            }
            /* is updeting now ?  */
        }
        /* --------- добавить инф о редактируемом вызове ------------ */



        /*         * ********* Временные характеристики вызова ************* */
        $time_character_m = new Model_Rig();
        $data['time_character'] = $time_character_m->selectTimeCharacter($id);

        /*         * ********* КОНЕЦ Временные характеристики вызова ************* */


        /*         * ********* Журнал вызова - СиС МЧС ************* */
        $sily_m = new Model_Jrig();
        $data['sily'] = $sily_m->selectAllByIdRig($id);

        /*         * ********* КОНЕЦ Журнал вызова  - СиС МЧС************* */

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'rig/character/characterForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    // SAVE time character, journal of rigs
    $app->post('/:id/character', function ($id) use ($app, $log) {

        /*         * ********* Обработка POST-данных************* */
        $time_character_m = new Model_Rig();
        $post_character = $time_character_m->getPOSTTimeCharacter(); //врем характеристики вызова

        $jrig_m = new Model_Jrig();
        $post_jrig = $jrig_m->getPOSTData(); //журнал выезда

        /*         * ********* КОНЕЦ Обработка POST-данных ************* */


        $data['settings_user'] = getSettingsUser();

        /* -------- Прошла ли валидация ------- */
        if (!empty($post_jrig)) {
            if (!empty($post_jrig['error'])) {
                show_error($post_jrig['error']);
                exit();
            }
        }

        if (!empty($post_character['error'])) {
            show_error($post_character['error']);
            exit();
        }
        /* -------- КОНЕЦ Прошла ли валидация ------- */

        /* ------------------------------- Сохранить ------------------------------------ */
        $time_character_m->saveTimeCharacter($post_character, $id); //временные хар-ки по выезду



        /* if likv before arrival - set results_battle_part_1 : people_help = 1 */
        if (isset($post_character['is_likv_before_arrival']) && $post_character['is_likv_before_arrival'] == 1) {
            $save_data['people_help'] = 1;
            $save_data['no_water'] = 1;
        } else {
            $save_data['people_help'] = 0;
            $save_data['no_water'] = 0;
        }
        $id_battle = R::getCell('select id from rb_chapter_1 where id_rig = ? limit 1', array($id));

        $battle = R::load('rb_chapter_1', $id_battle);
        if ($id_battle == 0) {//insert
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $id;
        }
        $save_data['last_update'] = date("Y-m-d H:i:s");
        $battle->import($save_data);
        R::store($battle);



        if (!empty($post_jrig)) {
            $jrig_m->save($post_jrig); //журнал вызова
        }



        /* is updeting now ?  */
        if ($id != 0) {//edit
            unset_update_rig_now($id);
        }

        /* ---------------------------- КОНЕЦ Сохранить---------------------------- */
        $log_post_character = json_encode($post_character, JSON_UNESCAPED_UNICODE);
        $log_post_jrig = json_encode($post_jrig, JSON_UNESCAPED_UNICODE);
        $log->info('Сессия -  :: Сохранение ВРЕМЕННЫЕ ХАР-КИ ПО ВЫЕЗДУ - id_rig = ' . $id . ' данные - : ' . $log_post_character); //запись в logs
        $log->info('Сессия -  :: Сохранение ЖУРНАЛ ПО ВЫЕЗДУ - id_rig = ' . $id . ' данные - : ' . $log_post_jrig); //запись в logs


        /* save log to bd */
        $action = 'редактирование временных характеристик по выезду, журнала выезда';
        $arr = array('s_user_id' => $_SESSION['id_user'], 's_user_name' => $_SESSION['user_name'], 's_region_name' => $_SESSION['region_name'], 's_locorg_name' => $_SESSION['locorg_name'], 'id_rig' => $id, 'action' => $action);
        $logg = new Model_Logs();
        $logg->save($arr);

        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            $app->redirect(BASE_URL . '/rig/' . $id . '/character');
        } else {
            $app->redirect(BASE_URL . '/rig');
        }
    });



    // question with delete rig
    $app->get('/delete/:id', function ($id) use ($app) {
        $bread_crumb = array('Выезд', 'Удалить');


        /* --------- добавить инф о редактируемом вызове ------------ */
        if ($id != 0) {

            $rig_table_m = new Model_Rigtable();
            $inf_rig = $rig_table_m->selectByIdRig($id); // дата, время, адрес объекта для редактируемого вызова по id

            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }
        }
        /* --------- добавить инф о редактируемом вызове ------------ */

        $data['bread_crumb'] = $bread_crumb;

        $data['id'] = $id;
        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/questioOfDelete.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });




    //rigtable for rcu
    $app->get('/table/for_rcu/:id(/:id_rig)(/:is_reset_filter)', function ($id, $id_rig = 0, $is_reset_filter = 0) use ($app) {

        $filter = [];
        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        /* MODELS */
        $sily_m = new Model_Jrig();
        $rig_m = new Model_Rigtable();
        $inner_m = new Model_Innerservice();
        $informing_m = new Model_Informing();
        $sily_mchs_m = new Model_Silymchs();

        if ($is_reset_filter == 1) {
            rememberFilterDate($filter);
        }
        $bread_crumb = array('Все выезды');

        $data['id_page'] = $id; //номер вклдаки

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;


        set_notifications($_SESSION['id_user']);

        /* ---- SD ---- */
        $is_show_link_sd = get_users_connect_sd($_SESSION['id_user']);
        if (!empty($is_show_link_sd)) {
            $data['is_show_link_sd'] = 1;
        } else {
            $data['is_show_link_sd'] = 0;
        }

        /* ---- END SD ---- */

        $rig_m = new Model_Rigtable();

        $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

        /* -------------- Поиск вызова по введенному id ---------------- */
        if ($id_rig != 0) {
            $rig = search_rig_by_id($rig_m, $id_rig);
            $data['rig'] = $rig;

            $data['search_rig_by_id'] = 1;
        }
        /* -------------- END Поиск вызова по введенному id ---------------- */ elseif ($id_rig == 0) {//обычная таблица

            /* -------- таблица выездов в зависимости от авт пользователя -------- */

            if (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {
                $rig_m->setDateStart($_SESSION['remember_filter_date_start']);
            }
            if (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_end']) && !empty($_SESSION['remember_filter_date_end'])) {
                $rig_m->setDateEnd($_SESSION['remember_filter_date_end']);
            }

            if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {//mode
                $filter['reasonrig'] = $data['settings_user_br_table'];
            } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_reasonrig']) && !empty($_SESSION['remember_filter_reasonrig'])) {
                $filter['reasonrig'] = $_SESSION['remember_filter_reasonrig'];
            }

            if (!in_array($id, $cp)) {//выезды за области без ЦП
                $data['rig'] = $rig_m->selectAllByIdRegion($id, 0, 0, $filter); //без ЦП
            } else {//выезды за РОСН, УГЗ, АВиацию
                $data['rig'] = $rig_m->selectAllByIdOrgan($id, 0, $filter); //за весь орган
            }

            if (!empty($data['rig']))
                usort($data['rig'], "order_rigs");

            /* ----- КОНЕЦ таблица выездов в зависимости от авт пользователя --------- */
        }

        //-------- цвет статусов выездов ----------*/
        $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //цвет причин выездов
        $reasonrig_color = array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']] = $value['color'];
        }
        $data['reasonrig_color'] = $reasonrig_color;
        /* -------- END цвет статусов выездов ---------- */




        $id_rig_arr = array();
        $id_rig_informing = array();
        $id_rig_sis_mes = array();
        $id_rig_with_informing = array(); //rigs with informing
        $ids_rig=[];
        $ids_rig_for_character=[];

        foreach ($data['rig'] as $value) {//id of rigs
            if ($value['id'] != null && in_array($value['id_reasonrig'], $data['reasonrig_with_informing'])) {
                $id_rig_with_informing[] = $value['id']; // rigs with informing
            }

            if ($value['id'] != null) {
                $id_rig_arr[] = $value['id'];
                $id_rig_informing[] = $value['id'];
            }

            if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
                $id_rig_sis_mes[] = $value['id'];
            }


            if ($value['is_likv_before_arrival'] == 0 && $value['is_not_measures'] == 0) {
                $ids_rig[] = $value['id'];
                $ids_rig_for_character[]=$value['id'];
            }
        }

        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {
            $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
            $data['sily_mchs'] = $sily_mchs;
        }



        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            $rig_cars = [];
            $rig_innerservice = [];
            $rig_informing = [];
            if (!empty($id_rig_sis_mes)) {
                //sis mchs
                $jrig = $sily_m->get_jrig_by_rigs($id_rig_sis_mes);

                if (!empty($jrig)) {
                    foreach ($jrig as $row) {
                        $rig_cars[$row['id_rig']][] = $row;
                    }
                }
            }

            //sis inner
            if (!empty($id_rig_arr)) {
                $inner = $inner_m->get_innerservice_by_rigs($id_rig_arr);

                if (!empty($inner)) {
                    foreach ($inner as $row) {
                        $rig_innerservice[$row['id_rig']][] = $row;
                    }
                }
            }


            //informing
            if (!empty($id_rig_informing)) {
                $informing = $informing_m->get_informing_by_rigs($id_rig_informing);

                if (!empty($informing)) {
                    foreach ($informing as $row) {

                        $rig_informing[$row['id_rig']][] = $row;
                    }
                }
            }

            $data['rig_cars'] = $rig_cars;
            $data['rig_innerservice'] = $rig_innerservice;
            $data['rig_informing'] = $rig_informing;
        } elseif (isset($data['settings_user']['vid_rig_table']) && ($data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type2' || $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type3')) {//type2 or tupe 3



            /* --- for table type 2 ---- */
            $res = getSilyForType2($sily_mchs);
            $data['teh_mark'] = $res['teh_mark'];
            $data['exit_time'] = $res['exit_time'];
            $data['arrival_time'] = $res['arrival_time'];
            $data['follow_time'] = $res['follow_time'];
            $data['end_time'] = $res['end_time'];
            $data['return_time'] = $res['return_time'];
            $data['distance'] = $res['distance'];
            /* --- END for table type 2 ---- */
        }


        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {


            /* fill or no icons */
            $informing_empty = array();
            if (!empty($id_rig_with_informing)) {
                $informing_empty = empty_icons($id_rig_with_informing, 'informing');
            }
            $result_icons_empty = empty_icons($id_rig_arr,null,$ids_rig_for_character);
            $data['result_icons'] = array_merge($result_icons_empty, $informing_empty);
            /* END fill or no icons */


            if (!empty($id_rig_with_informing)) {
                $ids_rig_not_full_info = $informing_m->getNotFullInfo($id_rig_with_informing);
                foreach ($ids_rig_not_full_info as $value) {
                    $data['not_full_info'][] = $value['id_rig'];
                }
            }

            if (!empty($ids_rig)) {
                $ids_rig_not_full_sily = $sily_mchs_m->getNotFullSily($ids_rig);
                foreach ($ids_rig_not_full_sily as $value) {
                    $data['not_full_sily'][] = $value['id_rig'];
                }
            }

            $data['rig'] = getResultsBattle($data['rig']); //results battle
            $data['trunk_by_rig'] = getTrunkByRigs($id_rig_arr);
        }

        // empty fields
        if (!empty($data['rig']))
            $data['rig'] = getEmptyFields($data['rig']);


        /* is updeting now ?  */
        foreach ($data['rig'] as $k => $r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();
        }
        /* is updeting now ?  */




        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php');
        $data['active_tab'] = $id; //активная вклдака - id области
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    // table for rcu - filter on dates
    $app->post('/table/for_rcu/:id(/:id_rig)', function ($id, $id_rig = 0) use ($app) {

        $bread_crumb = array('Все выезды');
        $data['bread_crumb'] = $bread_crumb;


        $data['id_page'] = $id; //number of tabs

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();


        $rig_m = new Model_Rigtable();
        $sily_m = new Model_Jrig();
        $inner_m = new Model_Innerservice();
        $informing_m = new Model_Informing();
        $sily_mchs_m = new Model_Silymchs();

        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;

        /* ++++++ proccessing of POST-data ++++++++ */
        $post_date = $rig_m->getPOSTData(); //dates for filter
        //print_r($post_silymchs);
        //exit();
        /* +++++++++ END proccessing of POST-data +++++++++ */

        /* -------- validate is success------- */
        if (!empty($post_date['error'])) {
            $data['url_back'] = 'rig'; //back
            $error = $post_date['error'];
            unset($post_date['error']);
            show_error($error, NULL, $post_date, '/rig/rigTable/form_search.php'); //view dates for repeat choose
            exit();
        }


        $filter = $post_date;
        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1) {
            if (isset($filter['reasonrig'])) {
                unset($filter['reasonrig']);
            }
        }
        rememberFilterDate($filter);
        /* -------- END validate is success ------- */

        set_notifications($_SESSION['id_user']);
        /* ---- SD ---- */
        $is_show_link_sd = get_users_connect_sd($_SESSION['id_user']);
        if (!empty($is_show_link_sd)) {
            $data['is_show_link_sd'] = 1;
        } else {
            $data['is_show_link_sd'] = 0;
        }

        /* ---- END SD ---- */


        /* -------- color of reasonrig ---------- */
        $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //color of reasonrig
        $reasonrig_color = array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']] = $value['color'];
        }
        $data['reasonrig_color'] = $reasonrig_color;
        /* -------- END color of reasonrig -------- */



        /* -------- rigtable according to session user -------- */

        $cp = array(8, 9, 12); //rosn, ugz,avia tabs


        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {//mode
            $filter['reasonrig'] = $data['settings_user_br_table'];
        }

        if (!in_array($id, $cp)) {//rigs for regions without CP
            $data['rig'] = $rig_m->selectAllByIdRegion($id, 0, 0, $filter); //without CP
        } else {//rosn, ugz,avia rigs
            $data['rig'] = $rig_m->selectAllByIdOrgan($id, 0, $filter); //for all organ
        }

        if (!empty($data['rig']))
            usort($data['rig'], "order_rigs");
        /* ----- END rigtable according to session user --------- */





        /* ------- select information on SiS MHS -------- */
        $id_rig_arr = array();
        $id_rig_informing = array();
        $id_rig_sis_mes = array();
        $id_rig_with_informing = array(); //rigs with informing
        $ids_rig=[];
        $ids_rig_for_character=[];

        foreach ($data['rig'] as $value) {//id of rigs
            if ($value['id'] != null && in_array($value['id_reasonrig'], $data['reasonrig_with_informing'])) {
                $id_rig_with_informing[] = $value['id']; // rigs with informing
            }

            if ($value['id'] != null) {
                $id_rig_arr[] = $value['id'];
                $id_rig_informing[] = $value['id'];
            }

            if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
                $id_rig_sis_mes[] = $value['id'];
            }

            if ($value['is_likv_before_arrival'] == 0 && $value['is_not_measures'] == 0) {
                $ids_rig[] = $value['id'];
                $ids_rig_for_character[]=$value['id'];
            }
        }

        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {
            $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
            $data['sily_mchs'] = $sily_mchs;
        }

        /* ------- END select information on SiS MHS-------- */




        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            $rig_cars = [];
            $rig_innerservice = [];
            $rig_informing = [];
            if (!empty($id_rig_sis_mes)) {
                //sis mchs
                $jrig = $sily_m->get_jrig_by_rigs($id_rig_sis_mes);

                if (!empty($jrig)) {
                    foreach ($jrig as $row) {
                        $rig_cars[$row['id_rig']][] = $row;
                    }
                }
            }

            //sis inner
            if (!empty($id_rig_arr)) {
                $inner = $inner_m->get_innerservice_by_rigs($id_rig_arr);

                if (!empty($inner)) {
                    foreach ($inner as $row) {
                        $rig_innerservice[$row['id_rig']][] = $row;
                    }
                }
            }


            //informing
            if (!empty($id_rig_informing)) {
                $informing = $informing_m->get_informing_by_rigs($id_rig_informing);

                if (!empty($informing)) {
                    foreach ($informing as $row) {

                        $rig_informing[$row['id_rig']][] = $row;
                    }
                }
            }

            $data['rig_cars'] = $rig_cars;
            $data['rig_innerservice'] = $rig_innerservice;
            $data['rig_informing'] = $rig_informing;
        } elseif (isset($data['settings_user']['vid_rig_table']) && ($data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type2' || $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type3')) {//type2

            /* --- for table type 2 ---- */

            $res = getSilyForType2($sily_mchs);
            $data['teh_mark'] = $res['teh_mark'];
            $data['exit_time'] = $res['exit_time'];
            $data['arrival_time'] = $res['arrival_time'];
            $data['follow_time'] = $res['follow_time'];
            $data['end_time'] = $res['end_time'];
            $data['return_time'] = $res['return_time'];
            $data['distance'] = $res['distance'];

            /* --- END for table type 2 ---- */
        }


        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {


            /* fill or no icons */
            $informing_empty = array();
            if (!empty($id_rig_with_informing)) {
                $informing_empty = empty_icons($id_rig_with_informing, 'informing');
            }
            $result_icons_empty = empty_icons($id_rig_arr,null,$ids_rig_for_character);
            $data['result_icons'] = array_merge($result_icons_empty, $informing_empty);
            /* END fill or no icons */

            if (!empty($id_rig_with_informing)) {

                $ids_rig_not_full_info = $informing_m->getNotFullInfo($id_rig_with_informing);
                foreach ($ids_rig_not_full_info as $value) {
                    $data['not_full_info'][] = $value['id_rig'];
                }
            }

            if (!empty($ids_rig)) {
                $ids_rig_not_full_sily = $sily_mchs_m->getNotFullSily($ids_rig);
                foreach ($ids_rig_not_full_sily as $value) {
                    $data['not_full_sily'][] = $value['id_rig'];
                }
            }

            $data['rig'] = getResultsBattle($data['rig']); //results battle
            $data['trunk_by_rig'] = getTrunkByRigs($id_rig_arr);
        }



        // empty fields
        if (!empty($data['rig']))
            $data['rig'] = getEmptyFields($data['rig']);


        /* is updeting now ?  */
        foreach ($data['rig'] as $k => $r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();
        }
        /* is updeting now ?  */





        $app->render('layouts/header.php');
        $data['active_tab'] = $id; // active tab - id of region
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    //rigtable
    $app->get('(/:id_rig)(/:is_reset_filter)', function ($id_rig = 0, $is_reset_filter = 0) use ($app) {

        $filter = [];

        if ($is_reset_filter == 1) {
            rememberFilterDate($filter);
        }
        $bread_crumb = array('Все выезды');
        $data['bread_crumb'] = $bread_crumb;

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();
        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;

        set_notifications($_SESSION['id_user']);
        /* ---- SD ---- */
        $is_show_link_sd = get_users_connect_sd($_SESSION['id_user']);
        if (!empty($is_show_link_sd)) {
            $data['is_show_link_sd'] = 1;
        } else {
            $data['is_show_link_sd'] = 0;
        }

        /* ---- END SD ---- */

        /* MODELS */
        $sily_m = new Model_Jrig();
        $rig_m = new Model_Rigtable();
        $inner_m = new Model_Innerservice();
        $informing_m = new Model_Informing();
        $sily_mchs_m = new Model_Silymchs();

        /* -------------- Поиск вызова по введенному id ---------------- */
        if ($id_rig != 0) {

            $rig = search_rig_by_id($rig_m, $id_rig);
            foreach ($rig as $r) {
                $region = $r['id_region_user']; //кто создал
                $organ = $r['id_organ_user']; //кто создал
            }
            $data['rig'] = $rig;

            $data['search_rig_by_id'] = 1;
        }
        /* -------------- END Поиск вызова по введенному id ---------------- */

        /* -------- цвет статусов выездов ---------- */
        $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //цвет причин выездов
        $reasonrig_color = array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']] = $value['color'];
        }
        $data['reasonrig_color'] = $reasonrig_color;
        /* -------- END цвет статусов выездов ---------- */


        /* -------- таблица выездов в зависимости от авт пользователя -------- */

        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {//mode
            $filter['reasonrig'] = $data['settings_user_br_table'];
        } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_reasonrig']) && !empty($_SESSION['remember_filter_reasonrig'])) {
            $filter['reasonrig'] = $_SESSION['remember_filter_reasonrig'];
        }

        if ($_SESSION['id_level'] == 3) {

            if ($id_rig == 0) {

                if (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {
                    $rig_m->setDateStart($_SESSION['remember_filter_date_start']);
                }
                if (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_end']) && !empty($_SESSION['remember_filter_date_end'])) {
                    $rig_m->setDateEnd($_SESSION['remember_filter_date_end']);
                }

                //выезды за ГРОЧС
                // $data['rig'] = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС
                $rig = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0, $filter); //за ГРОЧС

                if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                    $rig_neighbor_id = $rig_m->selectIdRigByIdGrochs(0, $_SESSION['id_locorg'], $filter); //за ГРОЧС
                    $rig_neighbor = $rig_m->selectAllByIdLocorgNeighbor($rig_neighbor_id, $filter);

                    $data['rig'] = array_merge($rig, $rig_neighbor);
                } else {
                    $data['rig'] = $rig;
                }


                //molodechno
            //if ($_SESSION['id_user'] == 19) {
            if (isset($data['settings_user']['is_misk_obl_paso_rigs']) && $data['settings_user']['is_misk_obl_paso_rigs']['name_sign'] == 'yes') {//show rigs of min obl PASO teh
                $id_grochs_of_teh = R::getCell('select id from ss.locorg where id_local = ? and id_organ = ? limit ?', array(MIN_OBL_ID_LOCAL, PASO, 1));
                $minsk_obl_paso_rigs_id = $rig_m->selectIdRigByIdGrochsOfTeh(0, $id_grochs_of_teh, $_SESSION['id_locorg'], $filter);

                if (!empty($minsk_obl_paso_rigs_id)) {
                    $delete_ids = [];

                    foreach ($data['rig'] as $value) {

                        if (in_array($value['id'], $minsk_obl_paso_rigs_id)) {
                            $delete_ids[] = $value['id'];
                            //
                        }
                    }

                    if (!empty($delete_ids)) {
                        foreach ($minsk_obl_paso_rigs_id as $key => $v) {
                            if (in_array($v, $delete_ids))
                                unset($minsk_obl_paso_rigs_id[$key]);
                        }
                    }

                    $minsk_obl_paso_rigs_id = array_unique($minsk_obl_paso_rigs_id);
                    if (!empty($minsk_obl_paso_rigs_id)) {

                        $not_my_rigs = $rig_m->selectRigsByIds($minsk_obl_paso_rigs_id, $filter);

                        if (!empty($not_my_rigs)) {
                            foreach ($not_my_rigs as $key => $r) {
                                $not_my_rigs[$key]['is_not_my'] = 1;
                                $not_my_rigs[$key]['is_not_can_edit_rig'] = 1;
                            }
                        }

                        $data['rig'] = array_merge($data['rig'], $not_my_rigs);
                        //print_r($data['rig']);exit();
                    }
                }
            }
            }
        } elseif ($_SESSION['id_level'] == 2) {

            if ($id_rig == 0) {

                if (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {
                    $rig_m->setDateStart($_SESSION['remember_filter_date_start']);
                }
                if (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_end']) && !empty($_SESSION['remember_filter_date_end'])) {
                    $rig_m->setDateEnd($_SESSION['remember_filter_date_end']);
                }

                if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                    $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0, $filter); //за весь орган
                } else {// UMCHS
                    // $data['rig'] = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //выезды за всю область(не включая ЦП), не удаленные записи
                    $rig = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0, $filter); //выезды за всю область(не включая ЦП), не удаленные записи

                    if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                        $rig_neighbor_id = $rig_m->selectIdRigByIdRegion(0, $_SESSION['id_region'], $filter); //за ГРОЧС
                        $rig_neighbor = $rig_m->selectAllByIdRegionNeighbor($rig_neighbor_id, $filter);
                        $data['rig'] = array_merge($rig, $rig_neighbor);
                    } else {
                        $data['rig'] = $rig;
                    }
                }
            }
        } else {//rcu
            if ($id_rig == 0) {

                // выезды за РБ
                $app->redirect(BASE_URL . '/rig/table/for_rcu/1');
            } else {//поиск вызова по id
                if (!empty($rig)) {

                    $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

                    if (in_array($organ, $cp)) {//выезд за  ЦП
                        $i = $organ;
                    } else {
                        $i = $region;
                    }
                    $app->redirect(BASE_URL . '/rig/table/for_rcu/' . $i . '/' . $id_rig);
                } else {
                    // выезды за РБ
                    $app->redirect(BASE_URL . '/rig/table/for_rcu/1');
                }
            }
        }

        if (!empty($data['rig']))
            usort($data['rig'], "order_rigs");

        /* ----- КОНЕЦ таблица выездов в зависимости от авт пользователя --------- */


        /* ------- select information on SiS MHS -------- */


        /* ------- select information on SiS MHS -------- */
        $id_rig_arr = array();
        $id_rig_informing = array();
        $id_rig_sis_mes = array();
        $id_rig_with_informing = array(); //rigs with informing
        $ids_rig=[];
        $ids_rig_for_character=[];

        foreach ($data['rig'] as $value) {//id of rigs
            if ($value['id'] != null && in_array($value['id_reasonrig'], $data['reasonrig_with_informing'])) {
                $id_rig_with_informing[] = $value['id']; // rigs with informing
            }

            if ($value['id'] != null) {
                $id_rig_arr[] = $value['id'];
                $id_rig_informing[] = $value['id'];
            }
            if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
                $id_rig_sis_mes[] = $value['id'];
            }

            if ($value['is_likv_before_arrival'] == 0 && $value['is_not_measures'] == 0) {
                $ids_rig[] = $value['id'];
                $ids_rig_for_character[]=$value['id'];
            }
        }

        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {
            $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
            $data['sily_mchs'] = $sily_mchs;
        }

        /* ------- END select information on SiS MHS-------- */






        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            $rig_cars = [];
            $rig_innerservice = [];
            $rig_informing = [];
            if (!empty($id_rig_sis_mes)) {
                //sis mchs
                $jrig = $sily_m->get_jrig_by_rigs($id_rig_sis_mes);

                if (!empty($jrig)) {
                    foreach ($jrig as $row) {
                        $rig_cars[$row['id_rig']][] = $row;
                    }
                }
            }

            //sis inner
            if (!empty($id_rig_arr)) {
                $inner = $inner_m->get_innerservice_by_rigs($id_rig_arr);

                if (!empty($inner)) {
                    foreach ($inner as $row) {
                        $rig_innerservice[$row['id_rig']][] = $row;
                    }
                }
            }


            //informing
            if (!empty($id_rig_informing)) {
                $informing = $informing_m->get_informing_by_rigs($id_rig_informing);

                if (!empty($informing)) {
                    foreach ($informing as $row) {

                        $rig_informing[$row['id_rig']][] = $row;
                    }
                }
            }

            $data['rig_cars'] = $rig_cars;
            $data['rig_innerservice'] = $rig_innerservice;
            $data['rig_informing'] = $rig_informing;
        } elseif (isset($data['settings_user']['vid_rig_table']) && ($data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type2' || $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type3')) {//type2




            /* --- for table type 2 ---- */
            $res = getSilyForType2($sily_mchs);
            $data['teh_mark'] = $res['teh_mark'];
            $data['exit_time'] = $res['exit_time'];
            $data['arrival_time'] = $res['arrival_time'];
            $data['follow_time'] = $res['follow_time'];
            $data['end_time'] = $res['end_time'];
            $data['return_time'] = $res['return_time'];
            $data['distance'] = $res['distance'];
            /* --- END for table type 2 ---- */
        }
        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {

            /* fill or no icons */
            $informing_empty = array();
            if (!empty($id_rig_with_informing)) {
                $informing_empty = empty_icons($id_rig_with_informing, 'informing');
            }
            $result_icons_empty = empty_icons($id_rig_arr,null,$ids_rig_for_character);
            $data['result_icons'] = array_merge($result_icons_empty, $informing_empty);
            /* END fill or no icons */


            if (!empty($id_rig_with_informing)) {
                $ids_rig_not_full_info = $informing_m->getNotFullInfo($id_rig_with_informing);
                foreach ($ids_rig_not_full_info as $value) {
                    $data['not_full_info'][] = $value['id_rig'];
                }
            }

            if (!empty($ids_rig)) {
                $ids_rig_not_full_sily = $sily_mchs_m->getNotFullSily($ids_rig);
                foreach ($ids_rig_not_full_sily as $value) {
                    $data['not_full_sily'][] = $value['id_rig'];
                }
            }


            $data['rig'] = getResultsBattle($data['rig']); //results battle

            $data['trunk_by_rig'] = getTrunkByRigs($id_rig_arr);
        }

        // empty fields
        if (!empty($data['rig']))
            $data['rig'] = getEmptyFields($data['rig']);



        /* is updeting now ?  */
        foreach ($data['rig'] as $k => $r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();
        }
        /* is updeting now ?  */


        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    //rigtable - filter on dates
    $app->post('/table', function ($is_remember_filter = 0) use ($app) {
        $bread_crumb = array('Все выезды');
        $data['bread_crumb'] = $bread_crumb;

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();

        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));


        $rig_m = new Model_Rigtable();
        $sily_m = new Model_Jrig();
        $inner_m = new Model_Innerservice();
        $informing_m = new Model_Informing();
        $sily_mchs_m = new Model_Silymchs();

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;

        /* ++++++ обработка POST-данных ++++++++ */
        $post_date = $rig_m->getPOSTData(); //даты для фильтра
        //print_r($post_silymchs);
        //exit();
        /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

        /* -------- Прошла ли валидация ------- */
        if (!empty($post_date['error'])) {
//            $data['url_back']='rig';
//            show_error($post_date['error'],$data['url_back']);
//            exit();

            $data['url_back'] = 'rig'; //куда вернуться
            $error = $post_date['error'];
            unset($post_date['error']);
            show_error($error, NULL, $post_date, '/rig/rigTable/form_search.php'); //отобразить даты для повторного выбора
            exit();
        }

        $filter = $post_date;
        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1) {
            if (isset($filter['reasonrig'])) {
                unset($filter['reasonrig']);
            }
        }
        rememberFilterDate($filter);
        /* -------- КОНЕЦ Прошла ли валидация ------- */

        set_notifications($_SESSION['id_user']);

        /* ---- SD ---- */
        $is_show_link_sd = get_users_connect_sd($_SESSION['id_user']);
        if (!empty($is_show_link_sd)) {
            $data['is_show_link_sd'] = 1;
        } else {
            $data['is_show_link_sd'] = 0;
        }

        /* ---- END SD ---- */


        /* -------- таблица выездов в зависимости от авт пользователя -------- */


        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {//mode
            $filter['reasonrig'] = $data['settings_user_br_table'];
        }

        if ($_SESSION['id_level'] == 3) {
            //выезды за ГРОЧС
            // $data['rig'] = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС
            $rig = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0, $filter); //за ГРОЧС

            if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                $rig_neighbor_id = $rig_m->selectIdRigByIdGrochs(0, $_SESSION['id_locorg'], $filter); //за ГРОЧС
                $rig_neighbor = $rig_m->selectAllByIdLocorgNeighbor($rig_neighbor_id, $filter);

                $data['rig'] = array_merge($rig, $rig_neighbor);
            } else {
                $data['rig'] = $rig;
            }

            //print_r($data['settings_user']);exit();
            //molodechno
            //if ($_SESSION['id_user'] == 19) {
            if (isset($data['settings_user']['is_misk_obl_paso_rigs']) && $data['settings_user']['is_misk_obl_paso_rigs']['name_sign'] == 'yes') {//show rigs of min obl PASO teh
                $id_grochs_of_teh = R::getCell('select id from ss.locorg where id_local = ? and id_organ = ? limit ?', array(MIN_OBL_ID_LOCAL, PASO, 1));
                $minsk_obl_paso_rigs_id = $rig_m->selectIdRigByIdGrochsOfTeh(0, $id_grochs_of_teh, $_SESSION['id_locorg'], $filter);

                if (!empty($minsk_obl_paso_rigs_id)) {
                    $delete_ids = [];

                    foreach ($data['rig'] as $value) {

                        if (in_array($value['id'], $minsk_obl_paso_rigs_id)) {
                            $delete_ids[] = $value['id'];
                            //
                        }
                    }

                    if (!empty($delete_ids)) {
                        foreach ($minsk_obl_paso_rigs_id as $key => $v) {
                            if (in_array($v, $delete_ids))
                                unset($minsk_obl_paso_rigs_id[$key]);
                        }
                    }

                    $minsk_obl_paso_rigs_id = array_unique($minsk_obl_paso_rigs_id);
                    if (!empty($minsk_obl_paso_rigs_id)) {

                        $not_my_rigs = $rig_m->selectRigsByIds($minsk_obl_paso_rigs_id, $filter);

                        if (!empty($not_my_rigs)) {
                            foreach ($not_my_rigs as $key => $r) {
                                $not_my_rigs[$key]['is_not_my'] = 1;
                                $not_my_rigs[$key]['is_not_can_edit_rig'] = 1;
                            }
                        }

                        $data['rig'] = array_merge($data['rig'], $not_my_rigs);
                        //print_r($data['rig']);exit();
                    }
                }
            }
        } elseif ($_SESSION['id_level'] == 2) {
            if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0, $filter); //за весь орган
            } else {// UMCHS
                //$data['rig'] = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //rigs on region without CP, deleted rigs
                $rig = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0, $filter); //rigs on region without CP, deleted rigs

                if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                    $rig_neighbor_id = $rig_m->selectIdRigByIdRegion(0, $_SESSION['id_region'], $filter); //за ГРОЧС
                    $rig_neighbor = $rig_m->selectAllByIdRegionNeighbor($rig_neighbor_id, $filter);
                    //print_r($rig_neighbor);exit();
                    $data['rig'] = array_merge($rig, $rig_neighbor);
                } else {
                    $data['rig'] = $rig;
                }
            }
        } else {
            // выезды за РБ
            //for_rcu
        }


        if (!empty($data['rig']))
            usort($data['rig'], "order_rigs");
        /* ----- КОНЕЦ таблица выездов в зависимости от авт пользователя --------- */



        /* -------- цвет статусов выездов ---------- */
        $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //цвет причин выездов
        $reasonrig_color = array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']] = $value['color'];
        }
        $data['reasonrig_color'] = $reasonrig_color;
        /* -------- END цвет статусов выездов ---------- */



        /* ------- select information on SiS MHS -------- */
        $id_rig_arr = array();
        $id_rig_informing = array();
        $id_rig_sis_mes = array();
        $id_rig_with_informing = array(); //rigs with informing
        $ids_rig=[];
        $ids_rig_for_character=[];

        foreach ($data['rig'] as $value) {//id of rigs
            if ($value['id'] != null && in_array($value['id_reasonrig'], $data['reasonrig_with_informing'])) {
                $id_rig_with_informing[] = $value['id']; // rigs with informing
            }

            if ($value['id'] != null) {
                $id_rig_arr[] = $value['id'];
                $id_rig_informing[] = $value['id'];
            }
            if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
                $id_rig_sis_mes[] = $value['id'];
            }
            if ($value['is_likv_before_arrival'] == 0 && $value['is_not_measures'] == 0) {
                $ids_rig[] = $value['id'];
                $ids_rig_for_character[]=$value['id'];
            }
        }

        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {
            $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
            $data['sily_mchs'] = $sily_mchs;
        }

        /* ------- END select information on SiS MHS-------- */





        if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
            $rig_cars = [];
            $rig_innerservice = [];
            $rig_informing = [];
            if (!empty($id_rig_sis_mes)) {
                //sis mchs
                $jrig = $sily_m->get_jrig_by_rigs($id_rig_sis_mes);

                if (!empty($jrig)) {
                    foreach ($jrig as $row) {
                        $rig_cars[$row['id_rig']][] = $row;
                    }
                }
            }

            //sis inner
            if (!empty($id_rig_arr)) {
                $inner = $inner_m->get_innerservice_by_rigs($id_rig_arr);

                if (!empty($inner)) {
                    foreach ($inner as $row) {
                        $rig_innerservice[$row['id_rig']][] = $row;
                    }
                }
            }


            //informing
            if (!empty($id_rig_informing)) {
                $informing = $informing_m->get_informing_by_rigs($id_rig_informing);

                if (!empty($informing)) {
                    foreach ($informing as $row) {

                        $rig_informing[$row['id_rig']][] = $row;
                    }
                }
            }

            $data['rig_cars'] = $rig_cars;
            $data['rig_innerservice'] = $rig_innerservice;
            $data['rig_informing'] = $rig_informing;
        } elseif (isset($data['settings_user']['vid_rig_table']) && ($data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type2' || $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type3')) {//type2

            /* --- for table type 2 ---- */
            $res = getSilyForType2($sily_mchs);
            $data['teh_mark'] = $res['teh_mark'];
            $data['exit_time'] = $res['exit_time'];
            $data['arrival_time'] = $res['arrival_time'];
            $data['follow_time'] = $res['follow_time'];
            $data['end_time'] = $res['end_time'];
            $data['return_time'] = $res['return_time'];
            $data['distance'] = $res['distance'];
            /* --- END for table type 2 ---- */
        }


        if (!isset($data['settings_user']['vid_rig_table']) || (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] != 'level3_type4')) {

            /* fill or no icons */
            $informing_empty = array();
            if (!empty($id_rig_with_informing)) {
                $informing_empty = empty_icons($id_rig_with_informing, 'informing');
            }
            $result_icons_empty = empty_icons($id_rig_arr,null,$ids_rig_for_character);
            $data['result_icons'] = array_merge($result_icons_empty, $informing_empty);
            /* END fill or no icons */

            if (!empty($id_rig_with_informing)) {
                $ids_rig_not_full_info = $informing_m->getNotFullInfo($id_rig_with_informing);
                foreach ($ids_rig_not_full_info as $value) {
                    $data['not_full_info'][] = $value['id_rig'];
                }
            }

            if (!empty($ids_rig)) {
                $ids_rig_not_full_sily = $sily_mchs_m->getNotFullSily($ids_rig);
                foreach ($ids_rig_not_full_sily as $value) {
                    $data['not_full_sily'][] = $value['id_rig'];
                }
            }


            $data['rig'] = getResultsBattle($data['rig']); //results battle

            $data['trunk_by_rig'] = getTrunkByRigs($id_rig_arr);
        }

        // empty fields
        if (!empty($data['rig']))
            $data['rig'] = getEmptyFields($data['rig']);

        /* is updeting now ?  */
        foreach ($data['rig'] as $k => $r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();
        }
        /* is updeting now ?  */


        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });



    //delete rig
    $app->delete('/:id', function ($id) use ($app, $log) {

        $rig = new Model_Rig();
        $rig->deleteRigById($id); // update is_delete=1

        $log->info('Сессия -  :: УДАЛЕНИЕ ВЫЕЗДА - id_rig = ' . $id . ' выполнил ' . $_SESSION['user_name']); //запись в logs

        /* save log to bd */
        $action = 'удаление выезда';

        $arr = array('s_user_id' => $_SESSION['id_user'], 's_user_name' => $_SESSION['user_name'], 's_region_name' => $_SESSION['region_name'], 's_locorg_name' => $_SESSION['locorg_name'], 'id_rig' => $id, 'action' => $action);
        $logg = new Model_Logs();
        $logg->save($arr);

        $app->redirect(BASE_URL . '/rig');
    });


    //add/edit new rig
    $app->post('/new(/:id/:active_tab)', function ($id = 0, $active_tab = 0) use ($app, $log) {

        /* --------- обработка POST-данных --------- */
        $rig = new Model_Rig();
        $post_rig = $rig->getPOSTDataByRig(); //данные по вызову
        $people = new Model_People();
        $post_people = $people->getPOSTData(); //данные по заявителю
        $service = new Model_Innerservice();
        $post_service = $service->getPOSTData(); //данные по привлекаемым службам
        $silymchs = new Model_Silymchs();
//print_r($post_rig);exit();
        $data['settings_user'] = getSettingsUser();

        /* did sily mchs get involved or not */
        $is_sily_mchs = $app->request()->post('is_sily_mchs');
        if (isset($is_sily_mchs) && !empty($is_sily_mchs) && $is_sily_mchs == 1) {//no
            $is_sily_mchs = 1;
            $post_silymchs = array();
        } else {//involved
            $is_sily_mchs = 0;

            $post_silymchs = $silymchs->getPOSTData(); //данные по силам МЧС
        }
        $post_rig['is_sily_mchs'] = $is_sily_mchs;

        $post_rig['is_copy'] = 0;


        //print_r($post_silymchs);
        //exit();
        /* -------- КОНЕЦ обработка POST-данных ---------- */


        /* is updeting now ?  */
        if ($id != 0) {//edit
            unset_update_rig_now($id);
        }


        /* ---------- сохранить вызов ----------- */

        if ($active_tab != 2) {
            $new_id = $rig->save($post_rig, $id); //id of rig
            $id = ($id == 0) ? $new_id : $id; //id of rig
        } else {//только вкладка "Техника"
            $rig->save(array('is_sily_mchs' => $is_sily_mchs), $id);
            $new_id = $id;
            $id = $id;
        }

        /* ------- END сохранить вызов -------- */


        $region_of_rig = R::getCell('select id_region_user from rigtable where id = ?', array($new_id)); //id_region  of rig
        $organ_of_rig = R::getCell('select id_organ_user from rigtable where id = ?', array($new_id)); //id_organ of rig
        //сохранить инф по заявителю по id_rig
        if ($active_tab != 2) {
            $people->save($post_people, $id);
        }

        // сохранить инф по привлекаемым СиС МЧС
        $silymchs->save($post_silymchs, $id);


        /* ------- сохранить инф по привлекаемым СиС др.ведомств -------- */

        // Прошла ли валидация
        if (!empty($post_service['error'])) {
            show_error($post_service['error']);
            exit();
        }
        $service->save($post_service, $id);

        /* ------- END сохранить инф по привлекаемым СиС др.ведомств ------ */


        if ($new_id) {//успех
            $log_post_rig = json_encode($post_rig, JSON_UNESCAPED_UNICODE);
            $log_post_people = json_encode($post_people, JSON_UNESCAPED_UNICODE);

            $log->info('Сессия -  :: Сохранение ВЫЕЗДА - id_rig = ' . $id . ' выполнил ' . $_SESSION['user_name'] . ' данные - : ' . $log_post_rig); //запись в logs
            $log->info('Сессия -  :: Сохранение ИНФ ПО ЗАЯВИТЕЛЮ - id_rig = ' . $id . ' выполнил ' . $_SESSION['user_name'] . ' данные - : ' . $log_post_people); //запись в logs



            /* save log to bd */
            if ($id == 0) {//new
                $action = 'создание выезда';
            } else {

                $action = 'редактирование выезда';
            }

            $arr = array('s_user_id' => $_SESSION['id_user'], 's_user_name' => $_SESSION['user_name'], 's_region_name' => $_SESSION['region_name'], 's_locorg_name' => $_SESSION['locorg_name'], 'id_rig' => $new_id, 'action' => $action);
            $logg = new Model_Logs();
            $logg->save($arr);


            if (isset($data['settings_user']['vid_rig_table']) && $data['settings_user']['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
                $app->redirect(BASE_URL . '/rig/new/' . $new_id);
            } else {
                if ($_SESSION['id_level'] == 1) {
                    $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

                    if (in_array($organ_of_rig, $cp)) {//выезд за  ЦП
                        $app->redirect(BASE_URL . '/rig/table/for_rcu/' . $organ_of_rig);
                    } else
                        $app->redirect(BASE_URL . '/rig/table/for_rcu/' . $region_of_rig);
                }
                else {
                    $app->redirect(BASE_URL . '/rig');
                }
            }
        } else {
            $bread_crumb = array('Выезды', 'Сохранить выезд');
            $data['bread_crumb'] = $bread_crumb;
            $app->render('layouts/header.php');
            $data['path_to_view'] = '/error.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
    });
});

function rememberFilterDate($filter)
{

    if (isset($filter['remember_filter_date']) && $filter['remember_filter_date'] == 1) {//set
        if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
            $_SESSION['is_remember_filter_date'] = 1;

            if (isset($filter['date_start']) && isset($filter['date_end'])) {
                $_SESSION['remember_filter_date_start'] = $filter['date_start'];
                $_SESSION['remember_filter_date_end'] = $filter['date_end'];
            }
            if (isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
                $_SESSION['remember_filter_reasonrig'] = $filter['reasonrig'];
            }
        }
    } else {
        if (isset($_SESSION['is_remember_filter_date'])) {
            unset($_SESSION['is_remember_filter_date']);

            if (isset($filter['date_start']) && isset($filter['date_end'])) {
                unset($_SESSION['remember_filter_date_start']);
                unset($_SESSION['remember_filter_date_end']);
            }

            if (isset($filter['remember_filter_reasonrig']) && !empty($filter['remember_filter_reasonrig'])) {
                unset($_SESSION['remember_filter_reasonrig']);
            }
        }
    }
}
/* ------------------------- END  rig ------------------------------- */



/* ------------------------- SEARCH rig by Id ------------------------------- */

$app->group('/search', function () use ($app) {

    // search rig by id
    $app->post('/rig', function () use ($app) {

        $id = intval($_POST['id_rig']);
        if (isset($id) && !empty($id)) {
            $app->redirect(BASE_URL . '/rig/' . $id);
        } else
            $app->redirect(BASE_URL . '/rig');
    });
});


/* ------------------------- END SEARCH rig by Id ------------------------------- */



/* ------------------------- news ------------------------------- */
$app->group('/news', function () use ($app) {

    // show news
    $app->get('/', function () use ($app) {

        $data['title'] = 'Новости';

        $bread_crumb = array('Новости');

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'news/news.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});
/* ------------------------- END  news -------------------------- */


/* ------------------------- classificator ------------------------------- */

$app->group('/classif', 'is_login', 'is_permis', function () use ($app, $log) {

    //добавление записи/редактирование
    $app->post('/:bean/new/:id', function ($bean, $id = 0) use ($app, $log) {


        if ($bean != 'destination') {

            /* ++++++ обработка POST-данных ++++++++ */

            if ($bean == 'listmail') {

                $post['mail'] = $_POST['name']; //mail
                if ($id == 0 && isset($_POST['id_pasp']) && !empty($_POST['id_pasp'])) {//create new
                    $post['id_pasp'] = $_POST['id_pasp'];
                }
            } else
                $post['name'] = $_POST['name'];

            if (isset($_POST['color'])) {//для классификатора статус выезда
                $post['color'] = $_POST['color'];
            }

            if (isset($_POST['id_reasonrig'])) {//для классификатора вид работ можем ред отношение к причине выезда
                $post['id_reasonrig'] = $_POST['id_reasonrig'];
            }

            /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

            /*             * ********* сохранить  **************** */
            $classif = new Model_Classificator($bean);
            $result = $classif->save($post, $id); //сохранить
            //print_r($post_silymchs);
            //exit();
            /*             * ********* END сохранить  **************** */
        } else {

            if ($id == 0) {//create new
                $post['fio'] = $_POST['fio'];
                $post['id_position'] = intval($_POST['id_position']);
                $post['id_rank'] = intval($_POST['id_rank']);
                $post['pos_place'] = $_POST['pos_place'];
            } else {//edit field
                if (isset($_POST['name']) && !empty($_POST['name'])) {
                    $name_field = $_POST['name'];
                }

                if (isset($_POST['value']) && !empty($_POST['value'])) {
                    $value_field = $_POST['value'];
                }
                if (isset($name_field) && isset($value_field)) {
                    $post[$name_field] = $value_field;
                }
            }

            $post['id'] = $id;
            $dest = new Model_Destination();
            $result = $dest->save($post); //сохранить
        }



        if ($result) {//успех
            $log_post = json_encode($post, JSON_UNESCAPED_UNICODE);
            $log->info('Сессия -  :: Сохранение записи в классификатор ' . $bean . ' выполнил ' . $_SESSION['user_name'] . '  данные - : ' . $log_post); //запись в logs
            $app->redirect(BASE_URL . '/classif/' . $bean);
        } else {
            $bread_crumb = array('Классификаторы', 'Сохранить');
            $data['bread_crumb'] = $bread_crumb;
            $app->render('layouts/header.php');
            $data['path_to_view'] = '/error.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
    });

    //удаление classif
    $app->delete('/:bean/:id', function ($bean, $id) use ($app, $log) {
        $rig = new Model_Classificator($bean);
        $rig->deleteClassifById($id); // update is_delete=1
        $log->info('Сессия -  :: УДАЛЕНИЕ записи из таблицы ' . $bean . '  - id = ' . $id . ' выполнил ' . $_SESSION['user_name']); //запись в logs
    });

    //таблица
    $app->get('/:bean', function ($bean) use ($app) {

        switch ($bean) {
            case "reasonrig": $name_bean = "Причина вызова";
                break;
            case "firereason": $name_bean = "Причина пожара";
                break;
            case "service": $name_bean = "Службы взаимодействия";
                break;
            case "officebelong": $name_bean = "Ведомственная принадлежность";
                break;
            case "statusrig": $name_bean = "Статус вызова";
                break;
            case "destination":$name_bean = 'Список лиц';
                break;
            case "workview":$name_bean = 'Вид работ';
                break;
            case "listmail":$name_bean = 'Список email';
                break;
            case "actionwaybill":$name_bean = 'Меры безопасности (для путевки)';
                break;
        }

        $bread_crumb = array('Классификаторы', $name_bean);
        $data['bread_crumb'] = $bread_crumb;

        $bean1 = strtolower($bean); //преобразовать строку в нижн регистр - название таблицы
        $data['classif_active'] = $bean1;

        $array_tables = array('reasonrig', 'firereason', 'service', 'officebelong', 'statusrig', 'destination', 'workview', 'listmail', 'actionwaybill'); //перечень возможных классификаторов

        if (!in_array($bean1, $array_tables)) {
            $data['url_back'] = 'rig'; //куда вернуться
            $error = array('Такого классификатора не существует!');
            show_error($error, $data['url_back']);
            exit();
        }


        if ($bean1 == 'destination') {
            /* ---------------------- Выборка данных -------------------- */
            $model = new Model_Destination();
            $data['list'] = $model->selectAll(); //выбор всех данных
            //должность - классификатор
            $data['position'] = R::getAll('SELECT * FROM position');


            //звание - классификатор
            $data['rank'] = R::getAll('SELECT * FROM rank');

            /* ---------------------- END Выборка данных -------------------- */
        } elseif ($bean1 == 'listmail') {
            $model = new Model_Listmailview();
            $data['classif'] = $model->selectAll(); //выбор всех данных



            /*             * *** Классификаторы **** */
            $region = new Model_Region();
            $data['region'] = $region->selectAll(); //области
            $locorg = new Model_Locorgview();
            $data['locorg'] = $locorg->selectAll(1); //выбрать все подразд кроме РЦУ, УМЧС(там нет техники)
            $pasp = new Model_Pasp();
            $data['pasp'] = $pasp->selectAll();
        } else {

            /* ---------------------- Создать экземпляр класса Bean -------------------- */
            $model = new Model_Classificator($bean1);
            $data['classif'] = $model->selectAll(); //выбор всех данных
            /* ---------------------- END Создать экземпляр класса Bean -------------------- */



            if ($bean1 == 'workview') {
                $reasonrig_m = new Model_Reasonrig();
                $data['reasonrig'] = $reasonrig_m->selectAll(0); //все причины
            }
        }

        $app->render('layouts/header.php');
        if ($bean1 == 'destination') {
            $data['path_to_view'] = 'classif/destination/destinationTable.php';
        } elseif ($bean1 == 'listmail') {

            $data['path_to_view'] = 'classif/listmail/listmailTable.php';
        } elseif ($bean1 == 'actionwaybill') {
            $data['path_to_view'] = 'classif/actionwaybill/table.php';
        } else {
            $data['path_to_view'] = 'classif/classifTable.php';
        }

        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    })->conditions(array('bean' => '[a-z]{5,}'));




    //actionwaybill classif - form add
    $app->get('/actionwaybill/addForm', function () use ($app, $log) {

        $name_bean = 'Меры безопасности (для путевки)';
        $bread_crumb = array('Классификаторы', $name_bean, 'Добавление');
        $data['bread_crumb'] = $bread_crumb;

        $reasonrig_m = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig_m->selectAll(0); //all reason
        $workview = new Model_Workview();
        $data['workview'] = $workview->selectAll();

        if (isset($_SESSION['msg_success']) && !empty($_SESSION['msg_success'])) {
            $data['msg_success'] = $_SESSION['msg_success'];
            unset($_SESSION['msg_success']);
        }

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'classif/actionwaybill/addForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //actionwaybill classif - add/edit
    $app->post('/actionwaybill/addForm/:id', function ($id = 0) use ($app, $log) {

        //echo  $_POST['id_reasonrig'];
        //  echo $_POST['myeditor'];
        //print_r($_POST['myeditor']);
        // print_r($_POST);
        //   echo '************<br>';

        $id_reasonrig = $app->request()->post('id_reasonrig');
        $id_work_view = $app->request()->post('id_work_view');
        $myeditor = $app->request()->post('myeditor');
        $is_off = $app->request()->post('is_off');
        $ord = $app->request()->post('ord');

        $add_data = array();

        if ($id_reasonrig != 0 && $id_work_view != 0) {
            foreach ($myeditor as $key => $value) {
                if (isset($value) && !empty($value)) {

                    /* include or no in waybill */
                    if (isset($is_off[$key]) && $is_off[$key] == 1) {
                        $is = 1;
                    } else {
                        $is = 0;
                    }

                    /* order in waybill - ord */


                    $add_data[] = array('id_reasonrig' => $id_reasonrig, 'description' => $value, 'is_off' => $is, 'ord' => $ord[$key], 'id_work_view' => $id_work_view);
                    //  $add_data[]=array('id_reasonrig'=>$id_reasonrig,'is_off'=>$is);
                }
            }
        }


        //print_r($add_data);
        //exit();

        /* add */
        if ($id == 0) {

            /* repeat of ord */
            $is_twice = array_count_values($ord);
            $max_ord = max($is_twice);
            if ($max_ord > 1)
                $app->redirect(BASE_URL . '/error/actionwaybill');

            /* add into bd */
            if (isset($add_data) && !empty($add_data)) {
                $way = new Model_Actionwaybill();
                $new_id = $way->save($add_data, $id);
            }

            /* success */
            if ($new_id == TRUE) {
                /* add next block */
                if (isset($_POST['next'])) {

                    $_SESSION['msg_success'] = 'Информация успешно добавлена в БД!';
                    /* add next block */
                    $app->redirect(BASE_URL . '/classif/actionwaybill/addForm');
                } else {
                    /* redirect to table */
                    $app->redirect(BASE_URL . '/classif/actionwaybill');
                }
            } else {
                $app->redirect(BASE_URL . '/error');
            }
        }
        /* edit */ else {

            /* edit ord another action of this reason */
            $way = new Model_Actionwaybill();
            $old_action_ord = $way->isOrd($id);
            //print_r($old_action_ord);
            if (isset($old_action_ord) && !empty($old_action_ord)) {

                foreach ($old_action_ord as $value) {
                    $new_ord = $value['ord'];
                }
                foreach ($add_data as $add) {
                    $id_reas = $add['id_reasonrig'];
                    $old_ord = $add['ord'];
                    $id_work = $add['id_work_view'];
                }
                // echo $new_ord.'    ****'.$old_ord ;exit();

                $way->editOrd($id_reas, $old_ord, $new_ord, $id_work);
            }


            /* edit bd */
            if (isset($add_data) && !empty($add_data)) {
                $way = new Model_Actionwaybill();
                $new_id = $way->save($add_data, $id);
            }

            $app->redirect(BASE_URL . '/classif/actionwaybill');
        }
    });

    //actionwaybill classif - edit form
    $app->get('/actionwaybill/edit/:id', function ($id) use ($app, $log) {

        $name_bean = 'Меры безопасности (для путевки)';
        $bread_crumb = array('Классификаторы', $name_bean, 'Редактирование');
        $data['bread_crumb'] = $bread_crumb;

        $reasonrig_m = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig_m->selectAll(0); //all reason
        $workview = new Model_Workview();
        $data['workview'] = $workview->selectAll();

        $way = new Model_Actionwaybill();
        $data['action'] = $way->selectById($id);

        $data['action_id'] = $id;

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'classif/actionwaybill/editForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //actionwaybill classif - delete
    $app->post('/actionwaybill/delete', function () use ($app, $log) {

        $ids = $app->request()->post('ids_del');

        if (isset($ids) && !empty($ids)) {
            // $ids_for_del= explode(',', $ids);

            $way = new Model_Actionwaybill();
            $way->delete($ids);

            $log->info('Сессия -  :: УДАЛЕНИЕ записи из таблицы actionwaybill  -  выполнил ' . $_SESSION['user_name']); //запись в logs
        }
    });



    //actionwaybill classif - edit form of order
    $app->get('/actionwaybill/edit/ord/:id_reasonrig/:id_work', function ($id_reasonrig, $id_work) use ($app, $log) {

        $name_bean = 'Меры безопасности (для путевки)';
        $bread_crumb = array('Классификаторы', $name_bean, 'Редактирование', 'Последовательность в путевке');
        $data['bread_crumb'] = $bread_crumb;

        $reasonrig_m = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig_m->selectAll(0); //all reason
        $workview = new Model_Workview();
        $data['workview'] = $workview->selectAll();


        $way = new Model_Actionwaybill();
        $data['action'] = $way->selectAllActionByIdReason($id_reasonrig, $id_work);

        $data['action_id'] = $id_reasonrig;

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'classif/actionwaybill/editFormOrd.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //actionwaybill classif - edit  of order
    $app->post('/actionwaybill/edit/ord/:id_reasonrig/:id_work', function ($id_reasonrig, $id_work) use ($app, $log) {

        // print_r($_POST);
        $id_reasonrig = $app->request()->post('id_reasonrig');
        $id_work_view = $app->request()->post('id_work_view');
//        $myeditor=$app->request()->post('myeditor');
        $is_off = $app->request()->post('is_off');
        $ord = $app->request()->post('ord');

        $is_twice = array_count_values($ord);
        $max_ord = max($is_twice);
        // print_r($is_twice);
        //  echo 'da';
        // exit();

        if ($max_ord > 1)
            $app->redirect(BASE_URL . '/error/actionwaybill');

        $add_data = array();

        if ($id_reasonrig != 0) {

            foreach ($ord as $key => $value) {
                /* include or no in waybill */
                if (isset($is_off[$key]) && $is_off[$key] == 1) {
                    $is = 1;
                } else {
                    $is = 0;
                }
                $add_data[$key] = array('id_reasonrig' => $id_reasonrig, 'is_off' => $is, 'ord' => $ord[$key], 'id_work_view' => $id_work_view);

                /* edit bd */
                if (isset($add_data) && !empty($add_data)) {
                    $way = new Model_Actionwaybill();
                    $new_id = $way->save($add_data, $key);
                }
            }
        }
        // print_r($add_data);
        //  exit();

        $app->redirect(BASE_URL . '/classif/actionwaybill');
    });
});


//классификатор информируемых лиц
$app->group('/destination', 'is_login', 'is_permis', function () use ($app, $log) {

    //добавление записи/редактирование
    $app->post('/post/:id', function ($id = 0) use ($app, $log) {

        /* ++++++ обработка POST-данных ++++++++ */
//
//        if (isset($_POST['name_field']) && !empty($_POST['name_field'])) {
//            $name_field = $_POST['name_field'];
//            //$post['fio'] = $_POST['name'];
//        }
//
//        if (isset($_POST['value_field']) && !empty($_POST['value_field'])) {
//            $value_field = $_POST['value_field'];
//            //$post['fio'] = $_POST['name'];
//        }
//        if(isset($name_field) && isset($value_field)){
//            $post[$name_field] = $value_field;
//        }

        $post['fio'] = 'ivan';

        // $post['id']=$id;

        $dest = R::findOne('destination', 'id = ? ', [$id]);
        $dest->import($post);
        R::store($post);


        //print_r($post);
        //exit();
        /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

        //     $dest = new Model_Destination();
        // $result=-$dest->save($post); //сохранить
    });
});

/* ------------------------- END   classificator------------------------------- */




/* ------------------------- settings------------------------------- */

$app->group('/settings', 'is_login', function () use ($app, $log) {

    //добавление записи
    $app->post('/reason_rig_color', function () use ($app) {

        /* ++++++ обработка POST-данных ++++++++ */
        if (isset($_POST['id_reasonrig']) && !empty($_POST['id_reasonrig'])) {
            $post['id_reasonrig'] = $_POST['id_reasonrig'];

            if (isset($_POST['color'])) {
                $post['color'] = (empty($_POST['color'])) ? 'white' : $_POST['color'];
            }

            /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

            /*             * ********* сохранить  **************** */
            $status_m = new Model_Reasonrigcolor();
            $status_m->save_new_record($post); //сохранить

            /*             * ********* END сохранить  **************** */
        }


        $app->redirect(BASE_URL . '/settings/reason_rig_color');
    });

    //ред записи
    $app->post('/reason_rig_color/:id', function ($id) use ($app) {

        /* ++++++ обработка POST-данных ++++++++ */
        if (isset($_POST['id_reasonrig']) && !empty($_POST['id_reasonrig'])) {
            $post['id_reasonrig'] = $_POST['id_reasonrig'];

            if (isset($_POST['color'])) {
                $post['color'] = (empty($_POST['color'])) ? 'white' : $_POST['color'];
            }

            /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

            /*             * ********* сохранить  **************** */
            $status_m = new Model_Reasonrigcolor();
            $status_m->edit($post, $id); //сохранить

            /*             * ********* END сохранить  **************** */
        }


        //  $app->redirect(BASE_URL . '/settings/status_rig_color' );
    });



    //удаление classif
    $app->delete('/reason_rig_color/:id', function ($id) use ($app, $log) {
        $status_m = new Model_Reasonrigcolor();
        $status_m->deleteById($id);
        $log->info('Сессия -  :: УДАЛЕНИЕ записи из таблицы reasonrigcolor  - id = ' . $id . ' выполнил ' . $_SESSION['user_name']); //запись в logs
    });

    //таблица
    $app->get('/reason_rig_color', function () use ($app) {


        $bread_crumb = array('Настройки', 'Цвет причины вызова');
        $data['bread_crumb'] = $bread_crumb;



        /* ---------------------- Выборка данных -------------------- */
        $model = new Model_Reasonrigcolor();
        $data['list'] = $model->selectAllDataByIdUser($_SESSION['id_user']); //выбор всех данных
        //статус выезда (НЕ УДАЛЕННЫЙ) - классификатор
        $data['statusrig'] = R::getAll('SELECT id, name FROM reasonrig where is_delete <> ?', array(1));

        /* ---------------------- END Выборка данных -------------------- */


        $app->render('layouts/header.php');

        $data['path_to_view'] = 'settings/reason_rig_color.php';


        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    /* settings */
    $app->get('/index', function () use ($app) {


        $bread_crumb = array('Настройки', 'Настройки пользователя');
        $data['bread_crumb'] = $bread_crumb;



        $reasonrig = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig->selectAll(1);


        $all_settings = R::getAll('SELECT * FROM settings');
        $data['all_settings'] = $all_settings;

        /* select */
        $all_settings_type = R::getAll('SELECT * FROM settings_type');
        $settings_type = array();
        foreach ($all_settings_type as $value) {
            $settings_type[$value['id_setting']][] = $value;
        }
        $data['settings_type'] = $settings_type;


        $settings_user_bd = R::getAll('SELECT * FROM settings_user WHERE id_user = ?', array($_SESSION['id_user']));
        $settings_user = array();
        foreach ($settings_user_bd as $value) {
            $settings_user[] = $value['id_settings_type'];
        }
        $data['settings_user'] = $settings_user;

        /* br table */
        $settings_user_bd = R::getAll('SELECT * FROM settings_user_br_table WHERE id_user = ?', array($_SESSION['id_user']));
        $reasonrig_by_user = array();
        foreach ($settings_user_bd as $value) {
            $reasonrig_by_user[] = $value['id_reasonrig'];
        }
        $data['settings_user_br_table'] = $reasonrig_by_user;



        $app->render('layouts/header.php');

        $data['path_to_view'] = 'settings/index.php';


        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    $app->post('/index/save', function () use ($app) {

        // print_r($_POST['type']);exit();

        $types = $_POST['type'];
        $id_reasonrig_for_br_table = (isset($_POST['id_reasonrig_for_br_table']) && !empty($_POST['id_reasonrig_for_br_table'])) ? $_POST['id_reasonrig_for_br_table'] : array();
        $fields_filter = (isset($_POST['fields_filter']) && !empty($_POST['fields_filter'])) ? $_POST['fields_filter'] : array();

        R::exec('DELETE FROM settings_user  WHERE id_user = ?', array($_SESSION['id_user']));

        foreach ($types as $value) {

            R::exec('INSERT INTO settings_user(id_user, id_settings_type) values(?,?) ', array($_SESSION['id_user'], $value));
        }


        /* fields filter */
        if (isset($fields_filter) && !empty($fields_filter)) {
            foreach ($fields_filter as $value) {
                R::exec('INSERT INTO settings_user(id_user, id_settings_type) values(?,?) ', array($_SESSION['id_user'], $value));
            }
        } else {
            if (isset($_SESSION['remember_filter_reasonrig']))
                unset($_SESSION['remember_filter_reasonrig']);
        }



        /* reason for br table */

        R::exec('DELETE FROM settings_user_br_table  WHERE id_user = ?', array($_SESSION['id_user']));
        if (isset($id_reasonrig_for_br_table) && !empty($id_reasonrig_for_br_table)) {
            foreach ($id_reasonrig_for_br_table as $value) {
                R::exec('INSERT INTO settings_user_br_table(id_user, id_settings, id_reasonrig) values(?,?,?) ', array($_SESSION['id_user'], 4, $value));
            }
        } else {
            if (isset($_SESSION['br_table_mode']))
                unset($_SESSION['br_table_mode']);
        }


//exit();
        $app->redirect(BASE_URL . '/settings/index');
    });
});


/* ------------------------- END   settings------------------------------- */




/* ------------------------- report ------------------------------- */

$app->group('/report', 'is_login', function () use ($app, $log) {

    // export to excel rep1
    $app->post('/rep1', function () use ($app, $log) {

        $filter=[];

        if(isset($_POST['status_teh']) && !empty($_POST['status_teh'])){
            $filter['status_teh']=$_POST['status_teh'];
        }

        /* ------- Даты ------ */

        if (isset($_POST['date_start']) && !empty($_POST['date_start'])) {
            $d1 = $_POST['date_start'];
        } else {
            $d1 = date("Y-m-d");
        }
        if (isset($_POST['date_end']) && !empty($_POST['date_end'])) {
            $d2 = $_POST['date_end'];
        } else {
            $d2 = $_POST['date_end'];
        }

        /* ------- END Даты ------ */

        /* ------- Запрошенные область и район------ */
        $id_region = (isset($_POST['id_region']) && !empty($_POST['id_region'])) ? intval($_POST['id_region']) : 0; //куда был выезд
        $id_local = (isset($_POST['id_local']) && !empty($_POST['id_local'])) ? intval($_POST['id_local']) : 0; //куда был выезд

        if ($id_region != 0) {
            $region_m = new Model_Region();
            $region_name = $region_m->selectNameById($id_region);
        } else {
            $region_name = 'все';
        }


        if ($id_local != 0) {
            $local_m = new Model_Local();
            $local_name = $local_m->selectNameById($id_local);
        } else {
            $local_name = 'все';
        }


        if (isset($_POST['reasonrig']) && !empty($_POST['reasonrig'])) {
            $reasonrig_n = $_POST['reasonrig'];
        }

        if (isset($reasonrig_n) && !empty($reasonrig_n)) {
            $reas_list = R::getAll('select name from reasonrig where id IN(' . implode(',', $reasonrig_n) . ')');

            if (!empty($reas_list)) {
                foreach ($reas_list as $value) {
                    $reasonrig_name[] = $value['name'];
                }
            }
            $reasonrig_name = implode(', ', $reasonrig_name);
        } else {
            $reasonrig_name = 'все';
        }


        if (isset($_POST['id_pasp']) && !empty($_POST['id_pasp']) && isset($_POST['is_pasp']) && $_POST['is_pasp'] == 1) {
            $id_pasp = $_POST['id_pasp'];
            $pasp_name = R::getAll('select pasp_name from pasp where pasp_id IN(' . implode(',', $id_pasp) . ')');
            $arr_pasp_name = array();
            foreach ($pasp_name as $value) {
                $arr_pasp_name[] = $value['pasp_name'];
            }

            $filter_pasp_name = ' с привлечением техники подразделений: ' . implode(', ', $arr_pasp_name);
        } else {
            $filter_pasp_name = '';
        }




        /* ------- КОНЕЦ Запрошенные область и район------ */



        /* ------------------- обработка POST-данных и получение результата по выезду ----------------- */
        $is_switch_by_podr = (isset($_POST['is_switch_by_podr']) && $_POST['is_switch_by_podr'] == 1) ? 1 : 0;

        $rig = new Model_Rigtable();
        $sily_m = new Model_Jrig();

        if ($is_switch_by_podr == 1) {//by podr
            $result = $rig->validateRep1(1); //результат по вызову

            $ids = [];
            if (!empty($result)) {// get unique rigs
                foreach ($result as $key => $value) {

                    if (in_array($value['id'], $ids)) {
                        unset($result[$key]);
                    } else {
                        $ids[] = $value['id'];
                    }
                }
            }
        } else {


            $result = $rig->validateRep1(); //результат по вызову
        }

        /* --------------КОНЕЦ обработка POST-данных  и получение результата по выезду -------------- */

        if (empty($result)) {//нет вызовов
            // $app->redirect(BASE_URL . '/error');
            $arr[] = 'Нет данных для отображения!';
            show_error($arr, 'report/rep1');
            exit();
        }

        if (!empty($result))
            usort($result, "order_rigs");

        /* ------- все id вызовов, для которых надо выбрать остальные данные --------- */
        foreach ($result as $key => $row) {
//            if(!empty($sily_m->is_neighbor_rig($row['id'])))
//                $result[$key]['is_neighbor_rig']=1;
            if ($id_local != 0 && $id_local != $row['id_local_user']) {

                $result[$key]['is_neighbor_rig'] = 1;
            } elseif ($id_region != 0 && $id_region != $row['id_region_user']) {
                $result[$key]['is_neighbor_rig'] = 1;
            }
            $id_rig[] = $row['id'];
        }
        /* ------- КОНЕЦ все id вызовов, для которых надо выбрать остальные данные --------- */


        /* -------выбор инф по заявителю-------- */
        $p = new Model_People();
        $people = $p->selectAllInIdRig($id_rig);        // в формате mas[id_rig]=>array()
        /* -------КОНЕЦ выбор инф по заявителю-------- */


        /* -------выбор инф по СиС МЧС-------- */

        $sily_mchs = $sily_m->selectAllInIdRig($id_rig,$filter);        // в формате mas[id_rig]=>array()
        /* -------КОНЕЦ выбор инф по СиС МЧС-------- */


        /* -------выбор инф по СиС ведомств-------- */
        $inners = new Model_Innerservice();
        $inner = $inners->selectAllInIdRig($id_rig);        // в формате mas[id_rig]=>array()
        /* -------КОНЕЦ выбор инф по СиС ведомств-------- */


        /* -------выбор инф информированию-------- */
        $inf_m = new Model_Informing();
        $informing = $inf_m->selectAllInIdRig($id_rig);        // в формате mas[id_rig]=>array()
//        print_r($informing);
//        exit();
        /* -------КОНЕЦ выбор инф поинформированию------- */

//count($sily_mchs[$id_r]) + count($inner[$id_r]) + count($informing[$id_r])
        //print_r($result);
        //exit();


        if (isset($id_pasp) && !empty($id_pasp) && isset($_POST['is_pasp']) && $_POST['is_pasp'] == 1) {
            //print_r($id_pasp);exit();
            $arr_exclude = array();

            foreach ($sily_mchs as $id_rig_k => $value) {

                $t = 0;
                $ids_pasp_by_rig = array();

                foreach ($sily_mchs[$id_rig_k] as $s) {
                    $ids_pasp_by_rig[] = $s['pasp_id'];
                }

                if (isset($ids_pasp_by_rig) && !empty($ids_pasp_by_rig)) {
                    foreach ($id_pasp as $id_p) {
                        if (in_array($id_p, $ids_pasp_by_rig)) {
                            $t++;
                        }
                    }
                    if ($t == 0) {
                        $arr_exclude[] = $id_rig_k;
                    }
                }
            }


            if (!empty($arr_exclude)) {

                foreach ($result as $key => $value) {
                    if (in_array($value['id'], $arr_exclude)) {
                        unset($result[$key]);
                    }
                }
            }

        }

        foreach ($result as $key => $value) {
            if ((!isset($sily_mchs[$value['id']]) || empty($sily_mchs[$value['id']])) && (isset($filter['status_teh']) && !empty($filter['status_teh']))) {
                unset($result[$key]);
            }
        }
        /* ---------------------------------------------------- ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/report/rep1.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //начальная строка для записи
        $c = 0; //начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . $d1 . ' по ' . $d2); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . $region_name . ', район: ' . $local_name . ', причина вызова: ' . $reasonrig_name . ((isset($filter_pasp_name) && !empty($filter_pasp_name)) ? (', ' . $filter_pasp_name) : '')); //выбранный область и район

        foreach ($result as $row) {
            $i++;
            $id_r = $row['id']; //id of rig

            if (isset($sily_mchs) && !empty($sily_mchs) && isset($sily_mchs[$id_r]))
                $a = count($sily_mchs[$id_r]);
            else
                $a = 0;

            if (isset($inner) && !empty($inner) && isset($inner[$id_r]))
                $b = count($inner[$id_r]);
            else
                $b = 0;

            if (isset($informing) && !empty($informing) && isset($informing[$id_r]))
                $c = count($informing[$id_r]);
            else
                $c = 0;




            $count_str = $a + $b + $c;  // сколько строк для одного выезда объединить

            $number__of_cell = ($count_str != 0 && $count_str > 1 ) ? ($r + $count_str - 1) : 0; //номер строки, по котрую надо объединить ячеуки
            //    echo  $row['id'] .':'.$count_str.':'.$number__of_cell.':'.$r. '<br>';

            if ($count_str != 0 && $number__of_cell > $r) {
                $sheet->mergeCells('A' . $r . ':A' . $number__of_cell);
                $sheet->mergeCells('B' . $r . ':B' . $number__of_cell);
                $sheet->mergeCells('C' . $r . ':C' . $number__of_cell);
                $sheet->mergeCells('D' . $r . ':D' . $number__of_cell);
                $sheet->mergeCells('E' . $r . ':E' . $number__of_cell);
                $sheet->mergeCells('F' . $r . ':F' . $number__of_cell);
                $sheet->mergeCells('K' . $r . ':K' . $number__of_cell);
                $sheet->mergeCells('L' . $r . ':L' . $number__of_cell);
                $sheet->mergeCells('P' . $r . ':P' . $number__of_cell);
                $sheet->mergeCells('Q' . $r . ':Q' . $number__of_cell);
            }

            /* ------------------- данные по вызову -------------------------- */
            if (isset($row['is_neighbor_rig']) && $row['is_neighbor_rig'] == 1) {
                $style_is_neihbor_rig = array(
                    'fill' => array(
                        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                        'color' => array(
                            'rgb' => 'c0c0c0'
                        )
                    )
                );
                $sheet->getStyle('A' . $r)->applyFromArray($style_is_neihbor_rig);

                $sheet->setCellValue('R' . $r, 'создатель: ' . $row['auth_locorg']);
            }

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('C' . $r, date('H:i', strtotime($row['time_msg'])));

            $sheet->setCellValue('E' . $r, $row['description']);


            $adr = ($row['address'] == NULL ) ? $row['additional_field_address'] : $row['address'];  /*   <!--                            если адрес пуст-выводим дополнит поле с адресом--> */
            $adr_region = ($row['id_region'] == 3 && $row['id_local'] == 123 ) ? '' : ( ($row['id_region'] == 3) ? $row['region_name'] . ', ' : $row['region_name'] . ' обл., ');
            $local_arr = array(21, 22, 123, 124, 135, 136, 137, 138, 139, 140, 141); //id_local городов - им не надо слово район
            $adr_local = (in_array($row['id_local'], $local_arr) || empty($row['id_local'])) ? '' : $row['local_name'] . ' район., ';

//                 if($row['id_local']==123){//г.Минск
//                     $adr_region='';
//                 }

            $sheet->setCellValue('F' . $r, $adr_region . $adr_local . $adr);

            $sheet->setCellValue('K' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc'])) ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
            $sheet->setCellValue('L' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv'])) ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
            $sheet->setCellValue('P' . $r, $row['inf_detail']);
            $sheet->setCellValue('Q' . $r, $row['view_work']);
            /* ------------------- КОНЕЦ данные по вызову -------------------------- */

            /* ------------------- данные по заявителю -------------------------- */
            $tt = '';
            if (isset($row['id']) && isset($people[$row['id']]) && isset($people[$row['id']]['phone'])) {
                if ($people[$row['id']]['phone'] == NULL || empty($people[$row['id']]['phone'])) {
                    $tt = '';
                } else {
                    $tt = 'тел. ' . $people[$row['id']]['phone'];
                }
            }
            //$tel= ($people[$row['id']]['phone'] == NULL || empty($people[$row['id']]['phone']) ) ? '': ('тел. '.$people[$row['id']]['phone']);
            $tel = $tt;

            if (isset($row['id']) && isset($people[$row['id']]['fio'])) {
                $people_fio = $people[$row['id']]['fio'];
            } else {
                $people_fio = '';
            }

            if (isset($row['id']) && isset($people[$row['id']]['address'])) {
                $people_address = $people[$row['id']]['address'];
            } else {
                $people_address = '';
            }

            if (isset($row['id']) && isset($people[$row['id']]['position'])) {
                $people_position = $people[$row['id']]['position'];
            } else {
                $people_position = '';
            }


            //$sheet->setCellValue('D' . $r, $people[$row['id']]['fio'].chr(10).$tel.chr(10).$people[$row['id']]['address'].chr(10).$people[$row['id']]['position']);

            $sheet->setCellValue('D' . $r, $people_fio . chr(10) . $tel . chr(10) . $people_address . chr(10) . $people_position);

            /* ------------------- данные по СиС МЧС -------------------------- */
            // Заполнение цветом
            $style_sily = array(
                'fill' => array(
                    'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                    'color' => array(
                        'rgb' => 'ebf1de'
                    )
                )
            );

            $s = $r;
            if (!empty($sily_mchs[$id_r])) {
                foreach ($sily_mchs[$id_r] as $si) {

                    if ($si['is_return'] == 1) {//если техника была отбита - ее зачеркнуть
                        $style_return_car = array(
                            'fill' => array(
                                'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                                'color' => array(
                                    'rgb' => 'ebf1de'
                                )
                            ),
                            'font' => array(
                                'strike' => TRUE//зачеркнутый текст
                            )
                        );
                        $sheet->getStyle('G' . $s)->applyFromArray($style_return_car);
                    } else {
                        $sheet->getStyle('G' . $s)->applyFromArray($style_sily);
                    }

                    if($si['status_teh'] == 1){
                        $status='боевая';
                    }
                    elseif($si['status_teh'] == 2){
                        $status='резерв';
                    }
                    elseif($si['status_teh'] == 3){
                        $status='ремонт';
                    }
                    elseif($si['status_teh'] == 4){
                        $status='ТО-1';
                    }
                    elseif($si['status_teh'] == 5){
                        $status='ТО-2';
                    }
                    $sheet->setCellValue('G' . $s, $si['locorg_name'] . ', ' . $si['pasp_name'] . ', ' . $si['mark'] . ' ( гос. номер ' . $si['numbsign'] . ')'.((isset($status)) ? ', '.$status : ''));
                    $sheet->setCellValue('H' . $s, '-');
                    $sheet->setCellValue('I' . $s, (($si['time_exit'] == '0000-00-00 00:00:00' || empty($si['time_exit'])) ? '' : date('d.m.Y H:i', strtotime($si['time_exit']))));
                    $sheet->setCellValue('J' . $s, (($si['time_arrival'] == '0000-00-00 00:00:00' || empty($si['time_arrival'])) ? '' : date('d.m.Y H:i', strtotime($si['time_arrival']))));
                    $sheet->setCellValue('M' . $s, (($si['time_end'] == '0000-00-00 00:00:00' || empty($si['time_end'])) ? '' : date('d.m.Y H:i', strtotime($si['time_end']))));
                    $sheet->setCellValue('N' . $s, (($si['time_return'] == '0000-00-00 00:00:00' || empty($si['time_return'])) ? '' : date('d.m.Y H:i', strtotime($si['time_return']))));
                    $sheet->setCellValue('O' . $s, $si['distance']);


                    $sheet->getStyle('I' . $s)->applyFromArray($style_sily);
                    $sheet->getStyle('J' . $s)->applyFromArray($style_sily);
                    $sheet->getStyle('M' . $s)->applyFromArray($style_sily);
                    $sheet->getStyle('N' . $s)->applyFromArray($style_sily);
                    $sheet->getStyle('O' . $s)->applyFromArray($style_sily);

                    $s++;
                }
            }

            /* ------------------- END данные по СиС МЧС -------------------------- */

            /* ------------------- данные по СиС др.ведомств-------------------------- */
            // Заполнение цветом
            $style_inner = array(
                'fill' => array(
                    'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                    'color' => array(
                        'rgb' => 'dce6f1'
                    )
                )
            );
            if (!empty($inner[$id_r])) {
                foreach ($inner[$id_r] as $si) {
                    $sheet->setCellValue('G' . $s, $si['service_name']);
                    $sheet->setCellValue('H' . $s, (($si['time_msg'] == '0000-00-00 00:00:00' || empty($si['time_msg'])) ? '' : date('d.m.Y H:i', strtotime($si['time_msg']))));
                    $sheet->setCellValue('I' . $s, '-');
                    $sheet->setCellValue('J' . $s, (($si['time_arrival'] == '0000-00-00 00:00:00' || empty($si['time_arrival'])) ? '' : date('d.m.Y H:i', strtotime($si['time_arrival']))));
                    $sheet->setCellValue('M' . $s, '-');
                    $sheet->setCellValue('N' . $s, '-');
                    $sheet->setCellValue('O' . $s, $si['distance']);


                    $sheet->getStyle('G' . $s)->applyFromArray($style_inner);
                    $sheet->getStyle('H' . $s)->applyFromArray($style_inner);
                    $sheet->getStyle('J' . $s)->applyFromArray($style_inner);
                    $sheet->getStyle('O' . $s)->applyFromArray($style_inner);

                    $s++;
                }
            }

            /* ------------------- END данные по СиС др.ведомств -------------------------- */

            /* ------------------- данные по информированию -------------------------- */
            // Заполнение цветом
            $style_inf = array(
                'fill' => array(
                    'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                    'color' => array(
                        'rgb' => 'fde9d9'
                    )
                )
            );

            if (!empty($informing[$id_r])) {
                foreach ($informing[$id_r] as $si) {

                    if (empty($si['position_name']) && empty($si['rank_name'])) {
                        $fio = $si['fio'];
                    } else {
                        $fio = $si['fio'] . ' ( ' . $si['position_name'] . ', ' . $si['rank_name'] . ' )';
                    }
                    $sheet->setCellValue('G' . $s, $fio);
                    $sheet->setCellValue('H' . $s, (($si['time_msg'] == '0000-00-00 00:00:00' || empty($si['time_msg'])) ? '' : date('d.m.Y H:i', strtotime($si['time_msg']))));
                    $sheet->setCellValue('I' . $s, (($si['time_exit'] == '0000-00-00 00:00:00' || empty($si['time_exit'])) ? '' : date('d.m.Y H:i', strtotime($si['time_exit']))));
                    $sheet->setCellValue('J' . $s, (($si['time_arrival'] == '0000-00-00 00:00:00' || empty($si['time_arrival'])) ? '' : date('d.m.Y H:i', strtotime($si['time_arrival']))));
                    $sheet->setCellValue('M' . $s, '-');
                    $sheet->setCellValue('N' . $s, '-');
                    $sheet->setCellValue('O' . $s, '-');

                    $sheet->getStyle('G' . $s)->applyFromArray($style_inf);
                    $sheet->getStyle('H' . $s)->applyFromArray($style_inf);
                    $sheet->getStyle('I' . $s)->applyFromArray($style_inf);
                    $sheet->getStyle('J' . $s)->applyFromArray($style_inf);



                    $s++;
                }
            }

            /* ------------------- END данные по информированию-------------------------- */


            $r += ($count_str != 0) ? $count_str : 1;
        }

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $sheet->getStyleByColumnAndRow(0, 8, 16, $r - 1)->applyFromArray($styleArray);

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rep1.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        /* ---------------------------------------------------- END ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
    });

    // form for rep1 - отчет-форма из устава
    $app->get('/rep1', function () use ($app) {

        $data['title'] = 'Отчеты/Журнал';

        $bread_crumb = array('Отчеты', 'Журнал');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы

        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        /*         * *** КОНЕЦ Классификаторы **** */

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'report/rep1/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });



    /* ----- results battle report ------ */
    //form
    $app->get('/rep2(:is_error)', function ($is_error = 0) use ($app) {

        $data['title'] = 'Отчеты/Боевая работа';

        $bread_crumb = array('Отчеты', 'Боевая работа');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** Классификаторы **** */
        //$archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');
        $archive_year = ARCHIVE_YEAR;
        foreach ($archive_year as $value) {
            $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
            $archive_year_1[] = $value;
        }
        $data['archive_year'] = $archive_year_1;


        /*         * *** КОНЕЦ Классификаторы **** */

        if (isset($is_error)) {
            $data['is_error'] = $is_error;
        }

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'report/rep2/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    $app->post('/rep2', function () use ($app) {

        $main_m = new Model_Main();

        $table_name_year =$y= $app->request()->post('archive_year');
        $month = $app->request()->post('archive_month');

        $real_server = $main_m->get_js_connect(substr($y, 0, -1));

        $months = array('01' => 'январь', '02' => 'февраль', '03' => 'март', '04' => 'апрель', '05' => 'май', '06' => 'июнь', '07' => 'июль', '08' => 'август'
            , '09' => 'сентябрь', '10' => 'октябрь', '11' => 'ноябрь', '12' => 'декабрь');


        $year = $table_name_year;
        $year = substr($year, 0, -1);

        // echo $table_name_year;
        if ($month == '') {//all months
            if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
                $pdo = get_pdo_15($real_server);
                $sql = 'SELECT q.`reasonrig_name`, COUNT(q.`id`) as cnt FROM jarchive.' . $table_name_year . ' as q GROUP BY q.`reasonrig_name`';
                $sth = $pdo->prepare($sql);
                $sth->execute();
                $rigs = $sth->fetchAll();
            } else {
                $rigs = R::getAll('SELECT q.`reasonrig_name`, COUNT(q.`id`) as cnt FROM jarchive.' . $table_name_year . ' as q GROUP BY q.`reasonrig_name`');
            }
        } else {
            if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
                $pdo = get_pdo_15($real_server);
                $sql = 'SELECT q.`reasonrig_name`, COUNT(q.`id`) as cnt FROM jarchive.' . $table_name_year . ' as q WHERE DATE_FORMAT( q.`date_msg`,"%m") ="' . $month . '" GROUP BY q.`reasonrig_name`';
                $sth = $pdo->prepare($sql);
                $sth->execute();
                $rigs = $sth->fetchAll();
            } else {
                $rigs = R::getAll('SELECT q.`reasonrig_name`, COUNT(q.`id`) as cnt FROM jarchive.' . $table_name_year . ' as q WHERE DATE_FORMAT( q.`date_msg`,"%m") ="' . $month . '" GROUP BY q.`reasonrig_name`');
            }
        }
        // print_r($rigs);
        //exit();
        $result = array(0, 0, 0, 0, 0, 0, 0);
        $no_cnt = 0;
        $total = 0;

        if (!empty($rigs)) {
            foreach ($rigs as $row) {
                if ($row['reasonrig_name'] == '09 другие ЧС') {
                    $result[0] = $row['cnt'];
                } elseif ($row['reasonrig_name'] == '12 пожар') {
                    $result[2] = $row['cnt'];
                } elseif ($row['reasonrig_name'] == '22 загорание в природных экосистемах') {
                    $result[3] = $row['cnt'];
                } elseif ($row['reasonrig_name'] == '04 другие загорания') {
                    $result[4] = $row['cnt'];
                } elseif ($row['reasonrig_name'] == '03 демеркуризация') {
                    $result[5] = $row['cnt'];
                } elseif ($row['reasonrig_name'] == 'не выбрано') {
                    $no_cnt = $row['cnt'];
                }

                $total += $row['cnt'];
            }

            $result[1] = $result[2] + $result[3] + $result[4];
            $result[6] = $total - $no_cnt - $result[1] - $result[0] - $result[5];
        }


        if (!isset($result) || empty($result)) {

            $app->redirect(BASE_URL . '/report/rep2/1');
        }


        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/report/boevaya.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //start row
        $c = 0; //start col



        if ($month == '') {//all months
            $sheet->setCellValue('F3', $year . ' год');
        } else {
            $sheet->setCellValue('F3', ($months[$month] . chr(10) . $year));
        }


        $sheet->setCellValue('F6', $result[0]);
        $sheet->setCellValue('F7', $result[1]);
        $sheet->setCellValue('F8', $result[2]);
        $sheet->setCellValue('F9', $result[3]);
        $sheet->setCellValue('F10', $result[4]);
        $sheet->setCellValue('F11', $result[5]);
        $sheet->setCellValue('F12', $result[6]);


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="boevaya.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });




    /*  daily report */

    //form
    $app->get('/rep3(:is_error)', function ($is_error = 0) use ($app) {

        $data['title'] = 'Отчеты/Суточная сводка УМЧС';

        $bread_crumb = array('Отчеты', 'Суточная сводка УМЧС');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** classif **** */


        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы

        /*         * *** end classif **** */

        if (isset($is_error)) {
            $data['is_error'] = $is_error;
        }

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'report/rep3/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //result rep 3
    $app->post('/rep3', function () use ($app) {

        $filter['id_region'] = $app->request()->post('id_region');
        $filter['year'] = $app->request()->post('year');
        //$filter['year'] = 2019;

        $is_excel = $app->request()->post('btn_rep3_excel');

        $data['title'] = 'Отчеты/Суточная сводка УМЧС';

        $bread_crumb = array('Отчеты', 'Суточная сводка УМЧС');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** classif **** */


        /* date time */
        $time_now = date('H:i:s');
        $time_default = '06:00:00';
        $today = date('Y-m-d');
        $yesterday = date("Y-m-d", time() - (60 * 60 * 24));
        $tomorrow = date("Y-m-d", time() + (60 * 60 * 24));
        $d1 = $today;
        $d2 = $tomorrow;

        if ($time_now <= $time_default) {
            $d1 = $yesterday;
            $d2 = $today;
        }



        if ($filter['id_region'] == 0) {
            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений ';
            $caption_head_2 = 'МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 1) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Брестское областное управление МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 2) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Витебское областное управление МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 3) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Минское городское управление МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 4) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Гомельское областное управление МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 5) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Гродненское областное управление МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 6) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Минское областное управление МЧС Республики Беларусь';
        } elseif ($filter['id_region'] == 7) {

            $caption_head_1 = 'СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений учреждения ';
            $caption_head_2 = 'Могилевское областное управление МЧС Республики Беларусь';
        }


         if ($filter['year'] < date('Y')) {
            $caption_head_3 = ' за ' . $filter['year'] . ' год';
        } else {
            $caption_head_3 = ' с 06-00 ' . date('d.m.Y', strtotime($d1)) . ' до 06-00 ' . date('d.m.Y', strtotime($d2)) . ' года';
        }



        $caption = $caption_head_1 . '<br>' . '&laquo;' . $caption_head_2 . '&raquo;' . '<br>' . $caption_head_3;





        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
//        if ($filter['id_region'] == 0)
//            $caption = 'Суточная сводка с 06:00 до 06:00 по республике';
//
//        else {
//            $region_name = R::getCell('select name from regions where id = ?', array($filter['id_region']));
//            $caption = 'Суточная сводка с 06:00 до 06:00 по области: ' . $region_name;
//        }
        $data['caption'] = $caption;


        /*         * *** end classif **** */


        /* -------------------- current daily ------------------------- */

        /*         * * current daily: hs ** */
        $daily_rigs_array = array();
        if ($filter['year'] == date('Y')) {
            $daily_rigs = R::getAssoc("CALL daily_report_current_get_hs('{$filter['id_region']}','1');"); //current day from 06:00 till 06:00

            if (empty($daily_rigs)) {

                $daily_rigs_array['rig_teh_hs'] = 0;
                $daily_rigs_array['rig_fire'] = 0;
                $daily_rigs_array['rig_live_sector'] = 0;
                $daily_rigs_array['rig_live_support'] = 0;
                $daily_rigs_array['rig_other_teh_hs'] = 0;
                $daily_rigs_array['rig_nature_ltt'] = 0;
            } else {
                foreach ($daily_rigs as $row) {

                    $daily_rigs_array['rig_teh_hs'] = (!isset($row['rig_teh_hs']) || empty($row['rig_teh_hs']) || $row['rig_teh_hs'] == null) ? 0 : $row['rig_teh_hs'];
                    $daily_rigs_array['rig_fire'] = (!isset($row['rig_fire']) || empty($row['rig_fire']) || $row['rig_fire'] == null) ? 0 : $row['rig_fire'];
                    $daily_rigs_array['rig_live_sector'] = (!isset($row['rig_live_sector']) || empty($row['rig_live_sector']) || $row['rig_live_sector'] == null) ? 0 : $row['rig_live_sector'];
                    $daily_rigs_array['rig_live_support'] = (!isset($row['rig_live_support']) || empty($row['rig_live_support']) || $row['rig_live_support'] == null) ? 0 : $row['rig_live_support'];
                    $daily_rigs_array['rig_other_teh_hs'] = (!isset($row['rig_other_teh_hs']) || empty($row['rig_other_teh_hs']) || $row['rig_other_teh_hs'] == null) ? 0 : $row['rig_other_teh_hs'];
                    $daily_rigs_array['rig_nature_ltt'] = (!isset($row['rig_nature_ltt']) || empty($row['rig_nature_ltt']) || $row['rig_nature_ltt'] == null) ? 0 : $row['rig_nature_ltt'];
                }
            }
        }

        $data['daily_rigs_hs'] = $daily_rigs_array;
        /*         * * END current daily: hs ** */



        /*         * * current daily: rigs ** */
        $all_rigs_today_array = array();
        if ($filter['year'] == date('Y')) {
            $all_rigs_today = R::getAssoc("CALL daily_report_current_get_rigs('{$filter['id_region']}','1');"); //current day from 06:00 till 06:00

            if (!empty($all_rigs_today)) {
                foreach ($all_rigs_today as $k => $row) {
                    $all_rigs_today_array = $row;
                }
            }
        }
        $data['rigs_today'] = $all_rigs_today_array;
        /*         * * END current daily: rigs ** */




        /*         * * current daily: mans ** */
        $daily_current_array = array();
        if ($filter['year'] == date('Y')) {

        $daily_current = R::getAssoc("CALL daily_report_current_get_results_battle('{$filter['id_region']}','1');"); //current day from 06:00 till 06:00

        if (empty($daily_current)) {

            $daily_current_array['dead_man'] = 0;

            $daily_current_array['dead_child'] = 0;

            $daily_current_array['dead_man_fire'] = 0;
            $daily_current_array['dead_child_fire'] = 0;

            $daily_current_array['inj_man'] = 0;
            $daily_current_array['inj_man_fire'] = 0;

            $daily_current_array['des_build'] = 0;
            $daily_current_array['des_build_fire'] = 0;

            $daily_current_array['dam_build'] = 0;
            $daily_current_array['dam_build_fire'] = 0;

            $daily_current_array['des_teh'] = 0;
            $daily_current_array['des_teh_fire'] = 0;

            $daily_current_array['dam_teh'] = 0;
            $daily_current_array['dam_teh_fire'] = 0;

            $daily_current_array['dam_money'] = 0;

            $daily_current_array['save_wealth'] = 0;

            $daily_current_array['save_man'] = 0;
            $daily_current_array['save_child'] = 0;

            $daily_current_array['save_man_fire'] = 0;
            $daily_current_array['save_child_fire'] = 0;

            $daily_current_array['save_mchs'] = 0;

            $daily_current_array['ev_man'] = 0;
            $daily_current_array['ev_child'] = 0;

            $daily_current_array['ev_man_fire'] = 0;
            $daily_current_array['ev_child_fire'] = 0;

            $daily_current_array['ev_mchs'] = 0;

            $daily_current_array['save_an'] = 0;

            $daily_current_array['save_an_mchs'] = 0;
        } else {
            foreach ($daily_current as $row) {


                $daily_current_array['dead_man'] = (!isset($row['dead_man']) || empty($row['dead_man']) || $row['dead_man'] == null) ? 0 : $row['dead_man'];
                $daily_current_array['dead_child'] = (!isset($row['dead_child']) || empty($row['dead_child']) || $row['dead_child'] == null) ? 0 : $row['dead_child'];

                $daily_current_array['dead_man_fire'] = (!isset($row['dead_man_fire']) || empty($row['dead_man_fire']) || $row['dead_man_fire'] == null) ? 0 : $row['dead_man_fire'];
                $daily_current_array['dead_child_fire'] = (!isset($row['dead_child_fire']) || empty($row['dead_child_fire']) || $row['dead_child_fire'] == null) ? 0 : $row['dead_child_fire'];

                $daily_current_array['inj_man'] = (!isset($row['inj_man']) || empty($row['inj_man']) || $row['inj_man'] == null) ? 0 : $row['inj_man'];
                $daily_current_array['inj_man_fire'] = (!isset($row['inj_man_fire']) || empty($row['inj_man_fire']) || $row['inj_man_fire'] == null) ? 0 : $row['inj_man_fire'];

                $daily_current_array['des_build'] = (!isset($row['des_build']) || empty($row['des_build']) || $row['des_build'] == null) ? 0 : $row['des_build'];
                $daily_current_array['des_build_fire'] = (!isset($row['des_build_fire']) || empty($row['des_build_fire']) || $row['des_build_fire'] == null) ? 0 : $row['des_build_fire'];

                $daily_current_array['dam_build'] = (!isset($row['dam_build']) || empty($row['dam_build']) || $row['dam_build'] == null) ? 0 : $row['dam_build'];
                $daily_current_array['dam_build_fire'] = (!isset($row['dam_build_fire']) || empty($row['dam_build_fire']) || $row['dam_build_fire'] == null) ? 0 : $row['dam_build_fire'];

                $daily_current_array['des_teh'] = (!isset($row['des_teh']) || empty($row['des_teh']) || $row['des_teh'] == null) ? 0 : $row['des_teh'];
                $daily_current_array['des_teh_fire'] = (!isset($row['des_teh_fire']) || empty($row['des_teh_fire']) || $row['des_teh_fire'] == null) ? 0 : $row['des_teh_fire'];

                $daily_current_array['dam_teh'] = (!isset($row['dam_teh']) || empty($row['dam_teh']) || $row['dam_teh'] == null) ? 0 : $row['dam_teh'];
                $daily_current_array['dam_teh_fire'] = (!isset($row['dam_teh_fire']) || empty($row['dam_teh_fire']) || $row['dam_teh_fire'] == null) ? 0 : $row['dam_teh_fire'];

                $daily_current_array['dam_money'] = (!isset($row['dam_money']) || empty($row['dam_money']) || $row['dam_money'] == null) ? 0 : $row['dam_money'];

                $daily_current_array['save_wealth'] = (!isset($row['save_wealth']) || empty($row['save_wealth']) || $row['save_wealth'] == null) ? 0 : $row['save_wealth'];

                $daily_current_array['save_man'] = (!isset($row['save_man']) || empty($row['save_man']) || $row['save_man'] == null) ? 0 : $row['save_man'];
                $daily_current_array['save_child'] = (!isset($row['save_child']) || empty($row['save_child']) || $row['save_child'] == null) ? 0 : $row['save_child'];

                $daily_current_array['save_man_fire'] = (!isset($row['save_man_fire']) || empty($row['save_man_fire']) || $row['save_man_fire'] == null) ? 0 : $row['save_man_fire'];
                $daily_current_array['save_child_fire'] = (!isset($row['save_child_fire']) || empty($row['save_child_fire']) || $row['save_child_fire'] == null) ? 0 : $row['save_child_fire'];

                $daily_current_array['save_mchs'] = (!isset($row['save_mchs']) || empty($row['save_mchs']) || $row['save_mchs'] == null) ? 0 : $row['save_mchs'];

                $daily_current_array['ev_man'] = (!isset($row['ev_man']) || empty($row['ev_man']) || $row['ev_man'] == null) ? 0 : $row['ev_man'];
                $daily_current_array['ev_child'] = (!isset($row['ev_child']) || empty($row['ev_child']) || $row['ev_child'] == null) ? 0 : $row['ev_child'];

                $daily_current_array['ev_man_fire'] = (!isset($row['ev_man_fire']) || empty($row['ev_man_fire']) || $row['ev_man_fire'] == null) ? 0 : $row['ev_man_fire'];
                $daily_current_array['ev_child_fire'] = (!isset($row['ev_child_fire']) || empty($row['ev_child_fire']) || $row['ev_child_fire'] == null) ? 0 : $row['ev_child_fire'];

                $daily_current_array['ev_mchs'] = (!isset($row['ev_mchs']) || empty($row['ev_mchs']) || $row['ev_mchs'] == null) ? 0 : $row['ev_mchs'];

                $daily_current_array['save_an'] = (!isset($row['save_an']) || empty($row['save_an']) || $row['save_an'] == null) ? 0 : $row['save_an'];

                $daily_current_array['save_an_mchs'] = (!isset($row['save_an_mchs']) || empty($row['save_an_mchs']) || $row['save_an_mchs'] == null) ? 0 : $row['save_an_mchs'];
            }
        }
    }


        $data['daily_current'] = $daily_current_array;

        /*         * * END current daily: mans ** */

        /* -------------------- END current daily ------------------------- */


        /* ------------------- from archive: from start year ----------------------------- */

        /* archive rigs */

        if ($filter['id_region'] != 0) {//by region
            $archive_rigs = R::getAssoc("select * from jarchive.daily_report_rigs where year = ? and id_region = ?", array($filter['year'], $filter['id_region'])); //rigs from archive
            $archive_rigs_arr = array();
            if (!empty($archive_rigs)) {
                foreach ($archive_rigs as $k => $row) {
                    $archive_rigs_arr = $row;
                }
            }
        } else {//by RB
            $archive_rigs = R::getAll("select * from jarchive.daily_report_rigs where year = ?", array($filter['year']));

            $sumArray = array();

            foreach ($archive_rigs as $k => $subArray) {
                foreach ($subArray as $id => $value) {

                    if ($id != 'id' && $id != "date_insert" && $id != 'id_region' && $id != 'year' && $id != 'date_update')
                        if (isset($sumArray[$id]))
                            $sumArray[$id] += $value;
                        else
                            $sumArray[$id] = $value;
                }
            }

            $archive_rigs_arr = $sumArray;
        }

        $data['archive_rigs'] = $archive_rigs_arr;

        /* END archive rigs */


        /* mans */
        if ($filter['id_region'] != 0) {//by region
            $daily_archive = R::getAll("select * from jarchive.daily_report_results_battle where id_region = ? and year = ?", array($filter['id_region'], $filter['year']));

            foreach ($daily_archive as $value) {
                //print_r($value);

                $daily_archive = $value;
            }
        } else {//by RB
            $daily_archive = R::getAll("select * from jarchive.daily_report_results_battle as a where a.year = ?", array($filter['year']));

            $sumArray = array();

            foreach ($daily_archive as $k => $subArray) {
                foreach ($subArray as $id => $value) {

                    if ($id != 'id' && $id != "date_insert" && $id != 'id_region' && $id != 'year' && $id != 'date_update')
                        if (isset($sumArray[$id]))
                            $sumArray[$id] += $value;
                        else
                            $sumArray[$id] = $value;
                }
            }

            $daily_archive = $sumArray;
        }
        $data['daily_archive'] = $daily_archive;
        /* ------------------- END from archive: from start year ----------------------------- */


        /* ---------------- all results_battle by all time from journal (it is plused to archive data) --------------------- */

        /* mans */
        $all_days_journal_arr = array();

        if ($filter['year'] == date('Y')) {
        $all_days_journal = R::getAssoc("CALL daily_report_current_get_results_battle('{$filter['id_region']}','0');"); //by all rigs in journal



        if (!empty($all_days_journal)) {
            foreach ($all_days_journal as $row) {

                $all_days_journal_arr = $row;
            }
        }
        }

        $data['all_days_journal_mans'] = $all_days_journal_arr;
        /* END mans */


        /* all hs */

         $all_hs_journal = array();
        if ($filter['year'] == date('Y')) {
        $all_hs = R::getAssoc("CALL daily_report_current_get_hs('{$filter['id_region']}','0');"); //all rigs from journal

        if (!empty($all_hs)) {
            foreach ($all_hs as $k => $row) {
                $all_hs_journal = $row;
            }
        }
        }
        $data['all_hs_journal'] = $all_hs_journal;

        /* END all hs */


        /* all rigs */
        $all_rigs_journal = array();
        if ($filter['year'] == date('Y')) {
            $all_rigs = R::getAssoc("CALL daily_report_current_get_rigs('{$filter['id_region']}','0');"); //all rigs from journal

            if (!empty($all_rigs)) {
                foreach ($all_rigs as $k => $row) {
                    $all_rigs_journal = $row;
                }
            }
        }
        $data['all_rigs_journal'] = $all_rigs_journal;

        /* END all rigs */




        /* ------------ END all results_battle by all time from journal ----------- */



        /* ------------------- get data from results_battle_archive_2019: only for 2019 year --------------------- */

        $main_m = new Model_Main();

        if (isset($filter['year']) && $filter['year'] == '2019') {

            if ($filter['id_region'] == 0) {//by RB

                $real_server = $main_m->get_js_connect($filter['year']);
                if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
                    $pdo = get_pdo_15($real_server);
                    $sql = 'select * from results_battle_archive_2019 where year = ?';
                    $sth = $pdo->prepare($sql);
                    $sth->execute(array($filter['year']));
                    $archive_2019 = $sth->fetchAll();
                } else {
                    $archive_2019 = R::getAll('select * from results_battle_archive_2019 where year = ?', array($filter['year']));
                }

                $sumArray = array();

                foreach ($archive_2019 as $k => $subArray) {
                    foreach ($subArray as $id => $value) {

                        if ($id != 'id' && $id != "date_insert" && $id != 'id_user' && $id != 'id_region' && $id != 'year' && $id != 'last_update' && $id != 'id_organ')
                            if (isset($sumArray[$id]))
                                $sumArray[$id] += $value;
                            else
                                $sumArray[$id] = $value;
                    }
                }

                $archive_2019 = $sumArray;
            } else {
                $real_server = $main_m->get_js_connect($filter['year']);
                if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
                    $pdo = get_pdo_15($real_server);
                    $sql = 'select * from results_battle_archive_2019 where year = ? and id_region =?';
                    $sth = $pdo->prepare($sql);
                    $sth->execute(array($filter['year'], $filter['id_region']));
                    $archive_2019 = $sth->fetchAll();
                } else {
                    $archive_2019 = R::getAll('select * from results_battle_archive_2019 where year = ? and id_region =?', array($filter['year'], $filter['id_region']));
                }


                foreach ($archive_2019 as $value) {
                    //print_r($value);

                    $archive_2019 = $value;
                }
            }
            $data['archive_2019'] = $archive_2019;
        }




        /* ------------------- END get data from results_battle_archive_2019: only for 2019 year --------------------- */




        $data['filter'] = $filter;

        // echo htmlspecialchars_decode($caption_head_2);exit();
        /* ------------------------------------ excel  --------------------------------- */

        if (isset($is_excel)) {
            $objPHPExcel = new PHPExcel();
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/report/rep3.xlsx');

            $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
            $sheet = $objPHPExcel->getActiveSheet();

            $r = 8; //начальная строка для записи
            $c = 0; //начальный столбец для записи

            $i = 0; //счетчик кол-ва записей № п/п


            $sheet->setCellValue('A1', $caption_head_1);
            $ca = '«' . $caption_head_2 . '»';
            $sheet->setCellValue('A2', $ca); //выбранный период
            $sheet->setCellValue('A3', $caption_head_3); //выбранный область и район

            $sheet->setCellValue('C' . $r, (((isset($data['daily_rigs_hs']['rig_teh_hs']) && !empty($data['daily_rigs_hs']['rig_teh_hs'])) ? $data['daily_rigs_hs']['rig_teh_hs'] : 0) + ((isset($data['daily_rigs_hs']['rig_nature_ltt']) && !empty($data['daily_rigs_hs']['rig_nature_ltt'])) ? $data['daily_rigs_hs']['rig_nature_ltt'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_teh_hs']) && !empty($data['all_hs_journal']['rig_teh_hs'])) ? $data['all_hs_journal']['rig_teh_hs'] : 0) +
                ((isset($data['all_hs_journal']['rig_nature_ltt']) && !empty($data['all_hs_journal']['rig_nature_ltt'])) ? $data['all_hs_journal']['rig_nature_ltt'] : 0) +
                ((isset($data['archive_rigs']['rig_all_hs']) && !empty($data['archive_rigs']['rig_all_hs'])) ? $data['archive_rigs']['rig_all_hs'] : 0) +
                ((isset($data['archive_2019']['r_nature_ltt']) && !empty($data['archive_2019']['r_nature_ltt'])) ? $data['archive_2019']['r_nature_ltt'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, ((isset($data['daily_rigs_hs']['rig_teh_hs']) && !empty($data['daily_rigs_hs']['rig_teh_hs'])) ? $data['daily_rigs_hs']['rig_teh_hs'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_teh_hs']) && !empty($data['all_hs_journal']['rig_teh_hs'])) ? $data['all_hs_journal']['rig_teh_hs'] : 0) +
                ((isset($data['archive_rigs']['rig_teh_hs']) && !empty($data['archive_rigs']['rig_teh_hs'])) ? $data['archive_rigs']['rig_teh_hs'] : 0) +
                ((isset($data['archive_2019']['r_teh']) && !empty($data['archive_2019']['r_teh'])) ? $data['archive_2019']['r_teh'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_rigs_hs']['rig_fire']) && !empty($data['daily_rigs_hs']['rig_fire'])) ? $data['daily_rigs_hs']['rig_fire'] : 0)  );
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_fire']) && !empty($data['all_hs_journal']['rig_fire'])) ? $data['all_hs_journal']['rig_fire'] : 0) +
                ((isset($data['archive_rigs']['rig_fire']) && !empty($data['archive_rigs']['rig_fire'])) ? $data['archive_rigs']['rig_fire'] : 0) +
                ((isset($data['archive_2019']['r_teh_fire']) && !empty($data['archive_2019']['r_teh_fire'])) ? $data['archive_2019']['r_teh_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_rigs_hs']['rig_live_sector']) && !empty($data['daily_rigs_hs']['rig_live_sector'])) ? $data['daily_rigs_hs']['rig_live_sector'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_live_sector']) && !empty($data['all_hs_journal']['rig_live_sector'])) ? $data['all_hs_journal']['rig_live_sector'] : 0) +
                ((isset($data['archive_rigs']['rig_live_sector']) && !empty($data['archive_rigs']['rig_live_sector'])) ? $data['archive_rigs']['rig_live_sector'] : 0) +
                ((isset($data['archive_2019']['r_life_sector']) && !empty($data['archive_2019']['r_life_sector'])) ? $data['archive_2019']['r_life_sector'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_rigs_hs']['rig_live_support']) && !empty($data['daily_rigs_hs']['rig_live_support'])) ? $data['daily_rigs_hs']['rig_live_support'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_live_support']) && !empty($data['all_hs_journal']['rig_live_support'])) ? $data['all_hs_journal']['rig_live_support'] : 0) +
                ((isset($data['archive_rigs']['rig_live_support']) && !empty($data['archive_rigs']['rig_live_support'])) ? $data['archive_rigs']['rig_live_support'] : 0) +
                ((isset($data['archive_2019']['r_live_support']) && !empty($data['archive_2019']['r_live_support'])) ? $data['archive_2019']['r_live_support'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_rigs_hs']['rig_other_teh_hs']) && !empty($data['daily_rigs_hs']['rig_other_teh_hs'])) ? $data['daily_rigs_hs']['rig_other_teh_hs'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_other_teh_hs']) && !empty($data['all_hs_journal']['rig_other_teh_hs'])) ? $data['all_hs_journal']['rig_other_teh_hs'] : 0) +
                ((isset($data['archive_rigs']['rig_other_teh_hs']) && !empty($data['archive_rigs']['rig_other_teh_hs'])) ? $data['archive_rigs']['rig_other_teh_hs'] : 0) +
                ((isset($data['archive_2019']['r_other_teh_hs']) && !empty($data['archive_2019']['r_other_teh_hs'])) ? $data['archive_2019']['r_other_teh_hs'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_rigs_hs']['rig_nature_ltt']) && !empty($data['daily_rigs_hs']['rig_nature_ltt'])) ? $data['daily_rigs_hs']['rig_nature_ltt'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['all_hs_journal']['rig_nature_ltt']) && !empty($data['all_hs_journal']['rig_nature_ltt'])) ? $data['all_hs_journal']['rig_nature_ltt'] : 0) +
                ((isset($data['archive_rigs']['rig_nature_ltt']) && !empty($data['archive_rigs']['rig_nature_ltt'])) ? $data['archive_rigs']['rig_nature_ltt'] : 0) +
                ((isset($data['archive_2019']['r_nature_ltt']) && !empty($data['archive_2019']['r_nature_ltt'])) ? $data['archive_2019']['r_nature_ltt'] : 0)));
            $r++;


            /* all rigs */
            $all_rigs_archive_2019 = 0;
            if (isset($data['archive_2019']) && !empty($data['archive_2019'])) {
                $all_rigs_archive_2019 = $data['archive_2019']['rig_teh_hs'] + $data['archive_2019']['rig_hs_nature'] + $data['archive_2019']['rig_other_zagor'] +
                    $data['archive_2019']['rig_suh_trava'] + $data['archive_2019']['rig_help'] + $data['archive_2019']['rig_signal'] + $data['archive_2019']['rig_demerk'] +
                    $data['archive_2019']['rig_all_zan'] + $data['archive_2019']['rig_false'];
            }

            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['all_rigs']) && !empty($data['rigs_today']['all_rigs'])) ? $data['rigs_today']['all_rigs'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['all_rigs']) && !empty($data['all_rigs_journal']['all_rigs'])) ? $data['all_rigs_journal']['all_rigs'] : 0) +
                ((isset($data['archive_rigs']['all_rigs']) && !empty($data['archive_rigs']['all_rigs'])) ? $data['archive_rigs']['all_rigs'] : 0) +
                $all_rigs_archive_2019));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_teh_hs']) && !empty($data['rigs_today']['rig_teh_hs'])) ? $data['rigs_today']['rig_teh_hs'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_teh_hs']) && !empty($data['all_rigs_journal']['rig_teh_hs'])) ? $data['all_rigs_journal']['rig_teh_hs'] : 0) +
                ((isset($data['archive_rigs']['teh_hs']) && !empty($data['archive_rigs']['teh_hs'])) ? $data['archive_rigs']['teh_hs'] : 0) +
                ((isset($data['archive_2019']['rig_teh_hs']) && !empty($data['archive_2019']['rig_teh_hs'])) ? $data['archive_2019']['rig_teh_hs'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_fire']) && !empty($data['rigs_today']['rig_fire'])) ? $data['rigs_today']['rig_fire'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_fire']) && !empty($data['all_rigs_journal']['rig_fire'])) ? $data['all_rigs_journal']['rig_fire'] : 0) +
                ((isset($data['archive_rigs']['fire']) && !empty($data['archive_rigs']['fire'])) ? $data['archive_rigs']['fire'] : 0) +
                ((isset($data['archive_2019']['rig_fire']) && !empty($data['archive_2019']['rig_fire'])) ? $data['archive_2019']['rig_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_life']) && !empty($data['rigs_today']['rig_life'])) ? $data['rigs_today']['rig_life'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_life']) && !empty($data['all_rigs_journal']['rig_life'])) ? $data['all_rigs_journal']['rig_life'] : 0) +
                ((isset($data['archive_rigs']['live_support']) && !empty($data['archive_rigs']['live_support'])) ? $data['archive_rigs']['live_support'] : 0) +
                ((isset($data['archive_2019']['rig_life']) && !empty($data['archive_2019']['rig_life'])) ? $data['archive_2019']['rig_life'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_other_teh_hs']) && !empty($data['rigs_today']['rig_other_teh_hs'])) ? $data['rigs_today']['rig_other_teh_hs'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_other_teh_hs']) && !empty($data['all_rigs_journal']['rig_other_teh_hs'])) ? $data['all_rigs_journal']['rig_other_teh_hs'] : 0) +
                ((isset($data['archive_rigs']['other_teh_hs']) && !empty($data['archive_rigs']['other_teh_hs'])) ? $data['archive_rigs']['other_teh_hs'] : 0) +
                ((isset($data['archive_2019']['rig_other_teh_hs']) && !empty($data['archive_2019']['rig_other_teh_hs'])) ? $data['archive_2019']['rig_other_teh_hs'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_hs_nature']) && !empty($data['rigs_today']['rig_hs_nature'])) ? $data['rigs_today']['rig_hs_nature'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_hs_nature']) && !empty($data['all_rigs_journal']['rig_hs_nature'])) ? $data['all_rigs_journal']['rig_hs_nature'] : 0) +
                ((isset($data['archive_rigs']['nature_hs']) && !empty($data['archive_rigs']['nature_hs'])) ? $data['archive_rigs']['nature_hs'] : 0) +
                ((isset($data['archive_2019']['rig_hs_nature']) && !empty($data['archive_2019']['rig_hs_nature'])) ? $data['archive_2019']['rig_hs_nature'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_les']) && !empty($data['rigs_today']['rig_les'])) ? $data['rigs_today']['rig_les'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_les']) && !empty($data['all_rigs_journal']['rig_les'])) ? $data['all_rigs_journal']['rig_les'] : 0) +
                ((isset($data['archive_rigs']['les']) && !empty($data['archive_rigs']['les'])) ? $data['archive_rigs']['les'] : 0) +
                ((isset($data['archive_2019']['rig_les']) && !empty($data['archive_2019']['rig_les'])) ? $data['archive_2019']['rig_les'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_torf']) && !empty($data['rigs_today']['rig_torf'])) ? $data['rigs_today']['rig_torf'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_torf']) && !empty($data['all_rigs_journal']['rig_torf'])) ? $data['all_rigs_journal']['rig_torf'] : 0) +
                ((isset($data['archive_rigs']['torf']) && !empty($data['archive_rigs']['torf'])) ? $data['archive_rigs']['torf'] : 0) +
                ((isset($data['archive_2019']['rig_torf']) && !empty($data['archive_2019']['rig_torf'])) ? $data['archive_2019']['rig_torf'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_other_zagor']) && !empty($data['rigs_today']['rig_other_zagor'])) ? $data['rigs_today']['rig_other_zagor'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_other_zagor']) && !empty($data['all_rigs_journal']['rig_other_zagor'])) ? $data['all_rigs_journal']['rig_other_zagor'] : 0) +
                ((isset($data['archive_rigs']['other_zagor']) && !empty($data['archive_rigs']['other_zagor'])) ? $data['archive_rigs']['other_zagor'] : 0) +
                ((isset($data['archive_2019']['rig_other_zagor']) && !empty($data['archive_2019']['rig_other_zagor'])) ? $data['archive_2019']['rig_other_zagor'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_suh_trava']) && !empty($data['rigs_today']['rig_suh_trava'])) ? $data['rigs_today']['rig_suh_trava'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_suh_trava']) && !empty($data['all_rigs_journal']['rig_suh_trava'])) ? $data['all_rigs_journal']['rig_suh_trava'] : 0) +
                ((isset($data['archive_rigs']['suh_trava']) && !empty($data['archive_rigs']['suh_trava'])) ? $data['archive_rigs']['suh_trava'] : 0) +
                ((isset($data['archive_2019']['rig_suh_trava']) && !empty($data['archive_2019']['rig_suh_trava'])) ? $data['archive_2019']['rig_suh_trava'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_musor']) && !empty($data['rigs_today']['rig_musor'])) ? $data['rigs_today']['rig_musor'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_musor']) && !empty($data['all_rigs_journal']['rig_musor'])) ? $data['all_rigs_journal']['rig_musor'] : 0) +
                ((isset($data['archive_rigs']['musor']) && !empty($data['archive_rigs']['musor'])) ? $data['archive_rigs']['musor'] : 0) +
                ((isset($data['archive_2019']['rig_musor']) && !empty($data['archive_2019']['rig_musor'])) ? $data['archive_2019']['rig_musor'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_piha']) && !empty($data['rigs_today']['rig_piha'])) ? $data['rigs_today']['rig_piha'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_piha']) && !empty($data['all_rigs_journal']['rig_piha'])) ? $data['all_rigs_journal']['rig_piha'] : 0) +
                ((isset($data['archive_rigs']['piha']) && !empty($data['archive_rigs']['piha'])) ? $data['archive_rigs']['piha'] : 0) +
                ((isset($data['archive_2019']['rig_piha']) && !empty($data['archive_2019']['rig_piha'])) ? $data['archive_2019']['rig_piha'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_short_zam']) && !empty($data['rigs_today']['rig_short_zam'])) ? $data['rigs_today']['rig_short_zam'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_short_zam']) && !empty($data['all_rigs_journal']['rig_short_zam'])) ? $data['all_rigs_journal']['rig_short_zam'] : 0) +
                ((isset($data['archive_rigs']['short_zam']) && !empty($data['archive_rigs']['short_zam'])) ? $data['archive_rigs']['short_zam'] : 0) +
                ((isset($data['archive_2019']['rig_short_zam']) && !empty($data['archive_2019']['rig_short_zam'])) ? $data['archive_2019']['rig_short_zam'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_help']) && !empty($data['rigs_today']['rig_help'])) ? $data['rigs_today']['rig_help'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_help']) && !empty($data['all_rigs_journal']['rig_help'])) ? $data['all_rigs_journal']['rig_help'] : 0) +
                ((isset($data['archive_rigs']['help_r']) && !empty($data['archive_rigs']['help_r'])) ? $data['archive_rigs']['help_r'] : 0) +
                ((isset($data['archive_2019']['rig_help']) && !empty($data['archive_2019']['rig_help'])) ? $data['archive_2019']['rig_help'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_help_org']) && !empty($data['rigs_today']['rig_help_org'])) ? $data['rigs_today']['rig_help_org'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_help_org']) && !empty($data['all_rigs_journal']['rig_help_org'])) ? $data['all_rigs_journal']['rig_help_org'] : 0) +
                ((isset($data['archive_rigs']['help_org']) && !empty($data['archive_rigs']['help_org'])) ? $data['archive_rigs']['help_org'] : 0) +
                ((isset($data['archive_2019']['rig_help_org']) && !empty($data['archive_2019']['rig_help_org'])) ? $data['archive_2019']['rig_help_org'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_help_people']) && !empty($data['rigs_today']['rig_help_people'])) ? $data['rigs_today']['rig_help_people'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_help_people']) && !empty($data['all_rigs_journal']['rig_help_people'])) ? $data['all_rigs_journal']['rig_help_people'] : 0) +
                ((isset($data['archive_rigs']['help_people']) && !empty($data['archive_rigs']['help_people'])) ? $data['archive_rigs']['help_people'] : 0) +
                ((isset($data['archive_2019']['rig_help_people']) && !empty($data['archive_2019']['rig_help_people'])) ? $data['archive_2019']['rig_help_people'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_signal']) && !empty($data['rigs_today']['rig_signal'])) ? $data['rigs_today']['rig_signal'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_signal']) && !empty($data['all_rigs_journal']['rig_signal'])) ? $data['all_rigs_journal']['rig_signal'] : 0) +
                ((isset($data['archive_rigs']['signal_r']) && !empty($data['archive_rigs']['signal_r'])) ? $data['archive_rigs']['signal_r'] : 0) +
                ((isset($data['archive_2019']['rig_signal']) && !empty($data['archive_2019']['rig_signal'])) ? $data['archive_2019']['rig_signal'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_demerk']) && !empty($data['rigs_today']['rig_demerk'])) ? $data['rigs_today']['rig_demerk'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_demerk']) && !empty($data['all_rigs_journal']['rig_demerk'])) ? $data['all_rigs_journal']['rig_demerk'] : 0) +
                ((isset($data['archive_rigs']['demerk']) && !empty($data['archive_rigs']['demerk'])) ? $data['archive_rigs']['demerk'] : 0) +
                ((isset($data['archive_2019']['rig_demerk']) && !empty($data['archive_2019']['rig_demerk'])) ? $data['archive_2019']['rig_demerk'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_all_zan']) && !empty($data['rigs_today']['rig_all_zan'])) ? $data['rigs_today']['rig_all_zan'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_all_zan']) && !empty($data['all_rigs_journal']['rig_all_zan'])) ? $data['all_rigs_journal']['rig_all_zan'] : 0) +
                ((isset($data['archive_rigs']['zanyatia']) && !empty($data['archive_rigs']['zanyatia'])) ? $data['archive_rigs']['zanyatia'] : 0) +
                ((isset($data['archive_2019']['rig_all_zan']) && !empty($data['archive_2019']['rig_all_zan'])) ? $data['archive_2019']['rig_all_zan'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_tsu']) && !empty($data['rigs_today']['rig_tsu'])) ? $data['rigs_today']['rig_tsu'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_tsu']) && !empty($data['all_rigs_journal']['rig_tsu'])) ? $data['all_rigs_journal']['rig_tsu'] : 0) +
                ((isset($data['archive_rigs']['tsu']) && !empty($data['archive_rigs']['tsu'])) ? $data['archive_rigs']['tsu'] : 0) +
                ((isset($data['archive_2019']['rig_tsu']) && !empty($data['archive_2019']['rig_tsu'])) ? $data['archive_2019']['rig_tsu'] : 0)));
            $r++;



            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_tsz']) && !empty($data['rigs_today']['rig_tsz'])) ? $data['rigs_today']['rig_tsz'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_tsz']) && !empty($data['all_rigs_journal']['rig_tsz'])) ? $data['all_rigs_journal']['rig_tsz'] : 0) +
                ((isset($data['archive_rigs']['tsz']) && !empty($data['archive_rigs']['tsz'])) ? $data['archive_rigs']['tsz'] : 0) +
                ((isset($data['archive_2019']['rig_tsz']) && !empty($data['archive_2019']['rig_tsz'])) ? $data['archive_2019']['rig_tsz'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_other_zanyatia']) && !empty($data['rigs_today']['rig_other_zanyatia'])) ? $data['rigs_today']['rig_other_zanyatia'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_other_zanyatia']) && !empty($data['all_rigs_journal']['rig_other_zanyatia'])) ? $data['all_rigs_journal']['rig_other_zanyatia'] : 0) +
                ((isset($data['archive_rigs']['other_zan']) && !empty($data['archive_rigs']['other_zan'])) ? $data['archive_rigs']['other_zan'] : 0) +
                ((isset($data['archive_2019']['rig_other_zanyatia']) && !empty($data['archive_2019']['rig_other_zanyatia'])) ? $data['archive_2019']['rig_other_zanyatia'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['rig_false']) && !empty($data['rigs_today']['rig_false'])) ? $data['rigs_today']['rig_false'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['rig_false']) && !empty($data['all_rigs_journal']['rig_false'])) ? $data['all_rigs_journal']['rig_false'] : 0) +
                ((isset($data['archive_rigs']['false_r']) && !empty($data['archive_rigs']['false_r'])) ? $data['archive_rigs']['false_r'] : 0) +
                ((isset($data['archive_2019']['rig_false']) && !empty($data['archive_2019']['rig_false'])) ? $data['archive_2019']['rig_false'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, (((isset($data['rigs_today']['prohie']) && !empty($data['rigs_today']['prohie'])) ? $data['rigs_today']['prohie'] : 0)));
            $sheet->setCellValue('D' . $r, (((isset($data['all_rigs_journal']['prohie']) && !empty($data['all_rigs_journal']['prohie'])) ? $data['all_rigs_journal']['prohie'] : 0) +
                ((isset($data['archive_rigs']['prohie']) && !empty($data['archive_rigs']['prohie'])) ? $data['archive_rigs']['prohie'] : 0) +
                ((isset($data['archive_2019']['prohie']) && !empty($data['archive_2019']['prohie'])) ? $data['archive_2019']['prohie'] : 0)));
            $r++;

            /* posledstvia HS */
            $r++;
            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['dead_man']) && !empty($data['daily_current']['dead_man'])) ? $data['daily_current']['dead_man'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dead_man']) && !empty($data['daily_archive']['cnt_dead_man'])) ? $data['daily_archive']['cnt_dead_man'] : 0) + ((isset($data['all_days_journal_mans']['dead_man']) && !empty($data['all_days_journal_mans']['dead_man'])) ? $data['all_days_journal_mans']['dead_man'] : 0) + ((isset($archive_2019['dead_man']) && !empty($archive_2019['dead_man'])) ? $archive_2019['dead_man'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['dead_child']) && !empty($data['daily_current']['dead_child'])) ? $data['daily_current']['dead_child'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dead_child']) && !empty($data['daily_archive']['cnt_dead_child'])) ? $data['daily_archive']['cnt_dead_child'] : 0) + ((isset($data['all_days_journal_mans']['dead_child']) && !empty($data['all_days_journal_mans']['dead_child'])) ? $data['all_days_journal_mans']['dead_child'] : 0) + ((isset($archive_2019['dead_child']) && !empty($archive_2019['dead_child'])) ? $archive_2019['dead_child'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['dead_man_fire']) && !empty($data['daily_current']['dead_man_fire'])) ? $data['daily_current']['dead_man_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dead_man_fire']) && !empty($data['daily_archive']['cnt_dead_man_fire'])) ? $data['daily_archive']['cnt_dead_man_fire'] : 0) + ((isset($data['all_days_journal_mans']['dead_man_fire']) && !empty($data['all_days_journal_mans']['dead_man_fire'])) ? $data['all_days_journal_mans']['dead_man_fire'] : 0) + ((isset($archive_2019['dead_man_fire']) && !empty($archive_2019['dead_man_fire'])) ? $archive_2019['dead_man_fire'] : 0)));
            $r++;



            $sheet->setCellValue('C' . $r,((isset($data['daily_current']['dead_child_fire']) && !empty($data['daily_current']['dead_child_fire'])) ? $data['daily_current']['dead_child_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dead_child_fire']) && !empty($data['daily_archive']['cnt_dead_child_fire'])) ? $data['daily_archive']['cnt_dead_child_fire'] : 0) + ((isset($data['all_days_journal_mans']['dead_child_fire']) && !empty($data['all_days_journal_mans']['dead_child_fire'])) ? $data['all_days_journal_mans']['dead_child_fire'] : 0) + ((isset($archive_2019['dead_child_fire']) && !empty($archive_2019['dead_child_fire'])) ? $archive_2019['dead_child_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['inj_man']) && !empty($data['daily_current']['inj_man'])) ? $data['daily_current']['inj_man'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_inj_man']) && !empty($data['daily_archive']['cnt_inj_man'])) ? $data['daily_archive']['cnt_inj_man'] : 0) + ((isset($data['all_days_journal_mans']['inj_man']) && !empty($data['all_days_journal_mans']['inj_man'])) ? $data['all_days_journal_mans']['inj_man'] : 0) + ((isset($archive_2019['inj_man']) && !empty($archive_2019['inj_man'])) ? $archive_2019['inj_man'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['inj_man_fire']) && !empty($data['daily_current']['inj_man_fire'])) ? $data['daily_current']['inj_man_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_inj_man_fire']) && !empty($data['daily_archive']['cnt_inj_man_fire'])) ? $data['daily_archive']['cnt_inj_man_fire'] : 0) + ((isset($data['all_days_journal_mans']['inj_man_fire']) && !empty($data['all_days_journal_mans']['inj_man_fire'])) ? $data['all_days_journal_mans']['inj_man_fire'] : 0) + ((isset($archive_2019['inj_man_fire']) && !empty($archive_2019['inj_man_fire'])) ? $archive_2019['inj_man_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r,((isset($data['daily_current']['des_build']) && !empty($data['daily_current']['des_build'])) ? $data['daily_current']['des_build'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_des_build']) && !empty($data['daily_archive']['cnt_des_build'])) ? $data['daily_archive']['cnt_des_build'] : 0) + ((isset($data['all_days_journal_mans']['des_build']) && !empty($data['all_days_journal_mans']['des_build'])) ? $data['all_days_journal_mans']['des_build'] : 0) + ((isset($archive_2019['des_build']) && !empty($archive_2019['des_build'])) ? $archive_2019['des_build'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r,  ((isset($data['daily_current']['des_build_fire']) && !empty($data['daily_current']['des_build_fire'])) ? $data['daily_current']['des_build_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_des_build_fire']) && !empty($data['daily_archive']['cnt_des_build_fire'])) ? $data['daily_archive']['cnt_des_build_fire'] : 0) + ((isset($data['all_days_journal_mans']['des_build_fire']) && !empty($data['all_days_journal_mans']['des_build_fire'])) ? $data['all_days_journal_mans']['des_build_fire'] : 0) + ((isset($archive_2019['des_build_fire']) && !empty($archive_2019['des_build_fire'])) ? $archive_2019['des_build_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['dam_build']) && !empty($data['daily_current']['dam_build'])) ? $data['daily_current']['dam_build'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dam_build']) && !empty($data['daily_archive']['cnt_dam_build'])) ? $data['daily_archive']['cnt_dam_build'] : 0) + ((isset($data['all_days_journal_mans']['dam_build']) && !empty($data['all_days_journal_mans']['dam_build'])) ? $data['all_days_journal_mans']['dam_build'] : 0) + ((isset($archive_2019['dam_build']) && !empty($archive_2019['dam_build'])) ? $archive_2019['dam_build'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['dam_build_fire']) && !empty($data['daily_current']['dam_build_fire'])) ? $data['daily_current']['dam_build_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dam_build_fire']) && !empty($data['daily_archive']['cnt_dam_build_fire'])) ? $data['daily_archive']['cnt_dam_build_fire'] : 0) + ((isset($data['all_days_journal_mans']['dam_build_fire']) && !empty($data['all_days_journal_mans']['dam_build_fire'])) ? $data['all_days_journal_mans']['dam_build_fire'] : 0) + ((isset($archive_2019['dam_build_fire']) && !empty($archive_2019['dam_build_fire'])) ? $archive_2019['dam_build_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['des_teh']) && !empty($data['daily_current']['des_teh'])) ? $data['daily_current']['des_teh'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_des_teh']) && !empty($data['daily_archive']['cnt_des_teh'])) ? $data['daily_archive']['cnt_des_teh'] : 0) + ((isset($data['all_days_journal_mans']['des_teh']) && !empty($data['all_days_journal_mans']['des_teh'])) ? $data['all_days_journal_mans']['des_teh'] : 0) + ((isset($archive_2019['des_teh']) && !empty($archive_2019['des_teh'])) ? $archive_2019['des_teh'] : 0)));
            $r++;



            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['des_teh_fire']) && !empty($data['daily_current']['des_teh_fire'])) ? $data['daily_current']['des_teh_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_des_teh_fire']) && !empty($data['daily_archive']['cnt_des_teh_fire'])) ? $data['daily_archive']['cnt_des_teh_fire'] : 0) + ((isset($data['all_days_journal_mans']['des_teh_fire']) && !empty($data['all_days_journal_mans']['des_teh_fire'])) ? $data['all_days_journal_mans']['des_teh_fire'] : 0) + ((isset($archive_2019['des_teh_fire']) && !empty($archive_2019['des_teh_fire'])) ? $archive_2019['des_teh_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r,((isset($data['daily_current']['dam_teh']) && !empty($data['daily_current']['dam_teh'])) ? $data['daily_current']['dam_teh'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dam_teh']) && !empty($data['daily_archive']['cnt_dam_teh'])) ? $data['daily_archive']['cnt_dam_teh'] : 0) + ((isset($data['all_days_journal_mans']['dam_teh']) && !empty($data['all_days_journal_mans']['dam_teh'])) ? $data['all_days_journal_mans']['dam_teh'] : 0) + ((isset($archive_2019['dam_teh']) && !empty($archive_2019['dam_teh'])) ? $archive_2019['dam_teh'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r,((isset($data['daily_current']['dam_teh_fire']) && !empty($data['daily_current']['dam_teh_fire'])) ? $data['daily_current']['dam_teh_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dam_teh_fire']) && !empty($data['daily_archive']['cnt_dam_teh_fire'])) ? $data['daily_archive']['cnt_dam_teh_fire'] : 0) + ((isset($data['all_days_journal_mans']['dam_teh_fire']) && !empty($data['all_days_journal_mans']['dam_teh_fire'])) ? $data['all_days_journal_mans']['dam_teh_fire'] : 0) + ((isset($archive_2019['dam_teh_fire']) && !empty($archive_2019['dam_teh_fire'])) ? $archive_2019['dam_teh_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['dam_money']) && !empty($data['daily_current']['dam_money'])) ? $data['daily_current']['dam_money'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_dam_money']) && !empty($data['daily_archive']['cnt_dam_money'])) ? $data['daily_archive']['cnt_dam_money'] : 0) + ((isset($data['all_days_journal_mans']['dam_money']) && !empty($data['all_days_journal_mans']['dam_money'])) ? $data['all_days_journal_mans']['dam_money'] : 0) + ((isset($archive_2019['dam_money']) && !empty($archive_2019['dam_money'])) ? $archive_2019['dam_money'] : 0)));
            $r++;



            /* results battle */
            $r++;
            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_wealth']) && !empty($data['daily_current']['save_wealth'])) ? $data['daily_current']['save_wealth'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_wealth']) && !empty($data['daily_archive']['cnt_save_wealth'])) ? $data['daily_archive']['cnt_save_wealth'] : 0) + ((isset($data['all_days_journal_mans']['save_wealth']) && !empty($data['all_days_journal_mans']['save_wealth'])) ? $data['all_days_journal_mans']['save_wealth'] : 0) + ((isset($archive_2019['save_wealth']) && !empty($archive_2019['save_wealth'])) ? $archive_2019['save_wealth'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_man']) && !empty($data['daily_current']['save_man'])) ? $data['daily_current']['save_man'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_man']) && !empty($data['daily_archive']['cnt_save_man'])) ? $data['daily_archive']['cnt_save_man'] : 0) + ((isset($data['all_days_journal_mans']['save_man']) && !empty($data['all_days_journal_mans']['save_man'])) ? $data['all_days_journal_mans']['save_man'] : 0) + ((isset($archive_2019['save_man']) && !empty($archive_2019['save_man'])) ? $archive_2019['save_man'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_child']) && !empty($data['daily_current']['save_child'])) ? $data['daily_current']['save_child'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_child']) && !empty($data['daily_archive']['cnt_save_child'])) ? $data['daily_archive']['cnt_save_child'] : 0) + ((isset($data['all_days_journal_mans']['save_child']) && !empty($data['all_days_journal_mans']['save_child'])) ? $data['all_days_journal_mans']['save_child'] : 0) + ((isset($archive_2019['save_child']) && !empty($archive_2019['save_child'])) ? $archive_2019['save_child'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_man_fire']) && !empty($data['daily_current']['save_man_fire'])) ? $data['daily_current']['save_man_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_man_fire']) && !empty($data['daily_archive']['cnt_save_man_fire'])) ? $data['daily_archive']['cnt_save_man_fire'] : 0) + ((isset($data['all_days_journal_mans']['save_man_fire']) && !empty($data['all_days_journal_mans']['save_man_fire'])) ? $data['all_days_journal_mans']['save_man_fire'] : 0) + ((isset($archive_2019['save_man_fire']) && !empty($archive_2019['save_man_fire'])) ? $archive_2019['save_man_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_child_fire']) && !empty($data['daily_current']['save_child_fire'])) ? $data['daily_current']['save_child_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_child_fire']) && !empty($data['daily_archive']['cnt_save_child_fire'])) ? $data['daily_archive']['cnt_save_child_fire'] : 0) + ((isset($data['all_days_journal_mans']['save_child_fire']) && !empty($data['all_days_journal_mans']['save_child_fire'])) ? $data['all_days_journal_mans']['save_child_fire'] : 0) + ((isset($archive_2019['save_child_fire']) && !empty($archive_2019['save_child_fire'])) ? $archive_2019['save_child_fire'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_mchs']) && !empty($data['daily_current']['save_mchs'])) ? $data['daily_current']['save_mchs'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_mchs']) && !empty($data['daily_archive']['cnt_save_mchs'])) ? $data['daily_archive']['cnt_save_mchs'] : 0) + ((isset($data['all_days_journal_mans']['save_mchs']) && !empty($data['all_days_journal_mans']['save_mchs'])) ? $data['all_days_journal_mans']['save_mchs'] : 0) + ((isset($archive_2019['save_mchs']) && !empty($archive_2019['save_mchs'])) ? $archive_2019['save_mchs'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['ev_man']) && !empty($data['daily_current']['ev_man'])) ? $data['daily_current']['ev_man'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_ev_man']) && !empty($data['daily_archive']['cnt_ev_man'])) ? $data['daily_archive']['cnt_ev_man'] : 0) + ((isset($data['all_days_journal_mans']['ev_man']) && !empty($data['all_days_journal_mans']['ev_man'])) ? $data['all_days_journal_mans']['ev_man'] : 0) + ((isset($archive_2019['ev_man']) && !empty($archive_2019['ev_man'])) ? $archive_2019['ev_man'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['ev_child']) && !empty($data['daily_current']['ev_child'])) ? $data['daily_current']['ev_child'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_ev_child']) && !empty($data['daily_archive']['cnt_ev_child'])) ? $data['daily_archive']['cnt_ev_child'] : 0) + ((isset($data['all_days_journal_mans']['ev_child']) && !empty($data['all_days_journal_mans']['ev_child'])) ? $data['all_days_journal_mans']['ev_child'] : 0) + ((isset($archive_2019['ev_child']) && !empty($archive_2019['ev_child'])) ? $archive_2019['ev_child'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['ev_man_fire']) && !empty($data['daily_current']['ev_man_fire'])) ? $data['daily_current']['ev_man_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_ev_man_fire']) && !empty($data['daily_archive']['cnt_ev_man_fire'])) ? $data['daily_archive']['cnt_ev_man_fire'] : 0) + ((isset($data['all_days_journal_mans']['ev_man_fire']) && !empty($data['all_days_journal_mans']['ev_man_fire'])) ? $data['all_days_journal_mans']['ev_man_fire'] : 0) + ((isset($archive_2019['ev_man_fire']) && !empty($archive_2019['ev_man_fire'])) ? $archive_2019['ev_man_fire'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['ev_child_fire']) && !empty($data['daily_current']['ev_child_fire'])) ? $data['daily_current']['ev_child_fire'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_ev_child_fire']) && !empty($data['daily_archive']['cnt_ev_child_fire'])) ? $data['daily_archive']['cnt_ev_child_fire'] : 0) + ((isset($data['all_days_journal_mans']['ev_child_fire']) && !empty($data['all_days_journal_mans']['ev_child_fire'])) ? $data['all_days_journal_mans']['ev_child_fire'] : 0) + ((isset($archive_2019['ev_child_fire']) && !empty($archive_2019['ev_child_fire'])) ? $archive_2019['ev_child_fire'] : 0)));
            $r++;



            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['ev_mchs']) && !empty($data['daily_current']['ev_mchs'])) ? $data['daily_current']['ev_mchs'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_ev_mchs']) && !empty($data['daily_archive']['cnt_ev_mchs'])) ? $data['daily_archive']['cnt_ev_mchs'] : 0) + ((isset($data['all_days_journal_mans']['ev_mchs']) && !empty($data['all_days_journal_mans']['ev_mchs'])) ? $data['all_days_journal_mans']['ev_mchs'] : 0) + ((isset($archive_2019['ev_mchs']) && !empty($archive_2019['ev_mchs'])) ? $archive_2019['ev_mchs'] : 0)));
            $r++;


            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_an']) && !empty($data['daily_current']['save_an'])) ? $data['daily_current']['save_an'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_an']) && !empty($data['daily_archive']['cnt_save_an'])) ? $data['daily_archive']['cnt_save_an'] : 0) + ((isset($data['all_days_journal_mans']['save_an']) && !empty($data['all_days_journal_mans']['save_an'])) ? $data['all_days_journal_mans']['save_an'] : 0) + ((isset($archive_2019['save_an']) && !empty($archive_2019['save_an'])) ? $archive_2019['save_an'] : 0)));
            $r++;

            $sheet->setCellValue('C' . $r, ((isset($data['daily_current']['save_an_mchs']) && !empty($data['daily_current']['save_an_mchs'])) ? $data['daily_current']['save_an_mchs'] : 0));
            $sheet->setCellValue('D' . $r, (((isset($data['daily_archive']['cnt_save_an_mchs']) && !empty($data['daily_archive']['cnt_save_an_mchs'])) ? $data['daily_archive']['cnt_save_an_mchs'] : 0) + ((isset($data['all_days_journal_mans']['save_an_mchs']) && !empty($data['all_days_journal_mans']['save_an_mchs'])) ? $data['all_days_journal_mans']['save_an_mchs'] : 0) + ((isset($archive_2019['save_an_mchs']) && !empty($archive_2019['save_an_mchs'])) ? $archive_2019['save_an_mchs'] : 0)));
            // $r++;


            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $sheet->getStyleByColumnAndRow(0, 4, 3, $r)->applyFromArray($styleArray);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="отчет_суточная_сводка.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }

        /* ------------------------------------ END excel  --------------------------------- */ else {
            $app->render('layouts/header.php', $data);
            $data['path_to_view'] = 'report/rep3/result.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
    });





    /*  big report for NII */

    //form
    $app->get('/rep4(:is_error)', function ($is_error = 0) use ($app) {

        $data['title'] = 'Отчеты/Боевая работа';

        $bread_crumb = array('Отчеты', 'Боевая работа');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** classif **** */


        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы

        /*         * *** end classif **** */

        if (isset($is_error)) {
            $data['is_error'] = $is_error;
        }

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'report/rep4/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //result rep 4
    $app->post('/rep4', function () use ($app) {

        $rig_m = new Model_Rigtable();
        $main_m = new Model_Main();



        $filter['id_region'] = (!empty($app->request()->post('id_region'))) ? $app->request()->post('id_region') : 0;
        $filter['id_local'] = (!empty($app->request()->post('id_local'))) ? $app->request()->post('id_local') : 0;
        $filter['year'] = $app->request()->post('year');

        $real_server = $main_m->get_js_connect($filter['year']);


        if (!empty($filter['id_local'])) {//by local
            $local_name = R::getCell('SELECT name FROM locals WHERE id = ? ', array($filter['id_local']));
        }

        $date_start = $app->request()->post('date_start');
        $date_end = $app->request()->post('date_end');

        if (!empty($date_start) && !empty($date_end)) {

            if ($rig_m->isDateTimeValid($date_start, "d.m") == true && $rig_m->isDateTimeValid($date_end, "d.m") == true) {
                $date = explode('.', $date_start);
                $filter['date_start'] = $filter['year'] . '-' . $date[1] . '-' . $date[0] . ' 06:00:00';

                $date_e = explode('.', $date_end);
                $filter['date_end'] = $filter['year'] . '-' . $date_e[1] . '-' . $date_e[0] . ' 06:00:00';
            } else {
                $filter['date_start'] = 0;
                $filter['date_end'] = 0;
            }
        } else {
            $filter['date_start'] = 0;
            $filter['date_end'] = 0;
        }




        /* date time */
        $time_now = date('H:i:s');
        $time_default = '06:00:00';
        $today = date('Y-m-d');
        $yesterday = date("Y-m-d", time() - (60 * 60 * 24));
        $tomorrow = date("Y-m-d", time() + (60 * 60 * 24));
        $d1 = $today;
        $d2 = $tomorrow;

        if ($time_now <= $time_default) {
            $d1 = $yesterday;
            $d2 = $today;
        }


        $is_excel = $app->request()->post('btn_rep4_excel');

        $data['title'] = 'Отчеты/Боевая работа';

        $bread_crumb = array('Отчеты', 'Боевая работа');
        $data['bread_crumb'] = $bread_crumb;


        /* caption of table */

        $caption_head_1 = 'Сведения о чрезвычайных ситуациях (в том числе пожарах), их последствиях и боевой работе ';
        if ($filter['id_region'] == 0) {//by RB
            $caption_head_2 = 'органов и подразделений по чрезвычайным ситуациям';
        } elseif (!empty($filter['id_local'])) {//by local
            $caption_head_2 = 'органов и подразделений по чрезвычайным ситуациям ' . chr(10) . '(' . ((stristr($local_name, 'г.') === FALSE) ? ($local_name . ' район') : $local_name) . ')';
        } else {//by region
            if ($filter['id_region'] == 1) {
                $caption_head_2 = 'Брестского областного управления МЧС Республики Беларусь';
            } elseif ($filter['id_region'] == 2) {
                $caption_head_2 = 'Витебского областного управления МЧС Республики Беларусь';
            } elseif ($filter['id_region'] == 3) {
                $caption_head_2 = 'Минского городского управления МЧС Республики Беларусь';
            } elseif ($filter['id_region'] == 4) {
                $caption_head_2 = 'Гомельского областного управления МЧС Республики Беларусь';
            } elseif ($filter['id_region'] == 5) {
                $caption_head_2 = 'Гродненского областного управления МЧС Республики Беларусь';
            } elseif ($filter['id_region'] == 6) {
                $caption_head_2 = 'Минского областного управления МЧС Республики Беларусь';
            } elseif ($filter['id_region'] == 7) {
                $caption_head_2 = 'Могилевского областного управления МЧС Республики Беларусь';
            }
        }

        //$caption_head_3 = ' с 06-00 ' . date('d.m.Y', strtotime($d1)) . ' до 06-00 ' . date('d.m.Y', strtotime($d2)) . ' года';

        $caption = $caption_head_1 . '<br>' . $caption_head_2;
        $data['caption'] = $caption;

        $data['filter'] = $filter;
        /*         * *** classif **** */

        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        /*         * *** end classif **** */




        /* ---------------------- all data from archive ------------------------- */

        $sql_a = 'select sum(cnt_fire_city_object) as cnt_fire_city_object,'
            . 'sum(cnt_fire_city_obl) as cnt_fire_city_obl, sum(cnt_fire_city_loc) as cnt_fire_city_loc,'
            . 'sum(cnt_fire_village) as cnt_fire_village, sum(cnt_ltt_les) as cnt_ltt_les, '
            . 'sum(cnt_ltt_torf) as cnt_ltt_torf, sum(cnt_ltt_trava) as cnt_ltt_trava,'
            . 'sum(cnt_zagor) as cnt_zagor, sum(cnt_fire_people_help) as cnt_fire_people_help,'
            . 'sum(cnt_fire_gos_help) as cnt_fire_gos_help,'
            . 'sum(cnt_fire_sum_2) as cnt_fire_sum_2, sum(cnt_fire_no_water) as cnt_fire_no_water,'
            . 'sum(cnt_fire_water) as cnt_fire_water,sum(cnt_fire_alone_otd) as cnt_fire_alone_otd,'
            . 'sum(cnt_fire_alone_shift) as cnt_fire_alone_shift, sum(cnt_fire_dop_mes) as cnt_fire_dop_mes, '
            . 'sum(cnt_fire_tool_meh) as cnt_fire_tool_meh, sum(cnt_fire_tool_pnev) as cnt_fire_tool_pnev,'
            . 'sum(cnt_fire_tool_gidr) as cnt_fire_tool_gidr, sum(cnt_fire_avia_help) as cnt_fire_avia_help, '
            . 'sum(cnt_fire_other_mes) as cnt_fire_other_mes, sum(cnt_fire_one_gdzs) as cnt_fire_one_gdzs,'
            . 'sum(cnt_fire_many_gdzs) as cnt_fire_many_gdzs, sum(cnt_fire_powder_mob) as cnt_fire_powder_mob,'
            . 'sum(cnt_fire_powder_out) as cnt_fire_powder_out, sum(cnt_fire_save_p_mask) as cnt_fire_save_p_mask,'
            . 'sum(cnt_fire_pred_food) as cnt_fire_pred_food, sum(cnt_fire_pred_build) as cnt_fire_pred_build,'
            . 'sum(cnt_fire_pred_vehicle) as cnt_fire_pred_vehicle, sum(cnt_fire_w_1) as cnt_fire_w_1,'
            . 'sum(cnt_fire_w_2) as cnt_fire_w_2, sum(cnt_fire_w_3) as cnt_fire_w_3, '
            . 'sum(cnt_fire_w_5) as cnt_fire_w_5, sum(cnt_fire_svd) as cnt_fire_svd,'
            . 'sum(cnt_fire_gps_1) as cnt_fire_gps_1, sum(cnt_fire_gps_2) as cnt_fire_gps_2,'
            . 'sum(cnt_fire_po_out) as cnt_fire_po_out, sum(cnt_fire_abr) as cnt_fire_abr,'
            . 'sum(cnt_fire_ac) as cnt_fire_ac, sum(cnt_fire_al) as cnt_fire_al,'
            . 'sum(cnt_fire_akp) as cnt_fire_akp, sum(cnt_fire_adu) as cnt_fire_adu,'
            . 'sum(cnt_fire_pns) as cnt_fire_pns, sum(cnt_fire_ar) as cnt_fire_ar,'
            . 'sum(cnt_fire_aso) as cnt_fire_aso, sum(cnt_fire_agdzs) as cnt_fire_agdzs,'
            . 'sum(cnt_fire_avpt) as cnt_fire_avpt, sum(cnt_fire_ap) as cnt_fire_ap,'
            . 'sum(cnt_fire_akt) as cnt_fire_akt, sum(cnt_fire_agvt) as cnt_fire_agvt,'
            . 'sum(cnt_fire_ash) as cnt_fire_ash, sum(cnt_fire_vz) as cnt_fire_vz,'
            . 'sum(cnt_fire_asa) as cnt_fire_asa, sum(cnt_fire_ams) as cnt_fire_ams,'
            . 'sum(cnt_hs_p_hrz) as cnt_hs_p_hrz, sum(cnt_hs_p_avs) as cnt_hs_p_avs,'
            . 'sum(cnt_hs_kran) as cnt_hs_kran, sum(cnt_hs_pes) as cnt_hs_pes,'
            . 'sum(cnt_hs_toplivo_z) as cnt_hs_toplivo_z, sum(cnt_hs_abr) as cnt_hs_abr,'
            . 'sum(cnt_hs_ac) as cnt_hs_ac, sum(cnt_hs_asa) as cnt_hs_asa,'
            . 'sum(cnt_hs_ams) as cnt_hs_ams, sum(cnt_hs_aso) as cnt_hs_aso,'
            . 'sum(cnt_hs_al) as cnt_hs_al, sum(cnt_hs_akp) as cnt_hs_akp,'
            . 'sum(cnt_hs_ash) as cnt_hs_ash, sum(cnt_fire_save_man) as cnt_fire_save_man,'
            . 'sum(cnt_fire_save_child) as cnt_fire_save_child, sum(cnt_fire_ev_man) as cnt_fire_ev_man,'
            . 'sum(cnt_fire_ev_child) as cnt_fire_ev_child, sum(cnt_fire_save_an) as cnt_fire_save_an,'
            . 'sum(cnt_hs_save_man) as cnt_hs_save_man, sum(cnt_hs_save_child) as cnt_hs_save_child,'
            . 'sum(cnt_hs_ev_man) as cnt_hs_ev_man, sum(cnt_hs_ev_child) as cnt_hs_ev_child,'
            . 'sum(cnt_hs_save_an) as cnt_hs_save_an, sum(cnt_hs_tehn) as cnt_hs_tehn,'
            . 'sum(cnt_hs_nature) as cnt_hs_nature, sum(cnt_hs_pred_build_4s) as cnt_hs_pred_build_4s,'
            . 'sum(cnt_hs_pred_vehicle_4s) as cnt_hs_pred_vehicle_4s, sum(cnt_hs_avia_4s) as cnt_hs_avia_4s,'
            . 'sum(cnt_hs_tool_meh) as cnt_hs_tool_meh, sum(cnt_hs_tool_pnev) as cnt_hs_tool_pnev,'
            . 'sum(cnt_hs_tool_gidr) as cnt_hs_tool_gidr,'
            . 'sum(cnt_tsu) as cnt_tsu,'
            . 'sum(cnt_tsz) as cnt_tsz,'
            . 'sum(cnt_night) as cnt_night,'
            . 'sum(cnt_pasp) as cnt_pasp,'
            . 'sum(cnt_hs_fire) as cnt_hs_fire,'
            . 'sum(cnt_fire) as cnt_fire,'
            . 'sum(cnt_signal) as cnt_signal,'
            . 'sum(cnt_molnia) as cnt_molnia,'
            . 'sum(cnt_false) as cnt_false,'
            . 'sum(cnt_help) as cnt_help,'
            . 'sum(cnt_demerk) as cnt_demerk,'
            . 'sum(col_arg) as col_arg,'
            . 'sum(col_was) as col_was,'
            . 'sum(cnt_rigs_rb_3_dtp) as cnt_rigs_rb_3_dtp,'
            . 'sum(s_peop_dtp) as s_peop_dtp,'
            . 'sum(s_chi_dtp) as s_chi_dtp,'
            . 'sum(d_dead_dtp) as d_dead_dtp,'
            . 'sum(cnt_rigs_rb_3_water) as cnt_rigs_rb_3_water,'
            . 'sum(s_peop_water) as s_peop_water,'
            . 'sum(s_chi_water) as s_chi_water,'
            . 'sum(d_dead_water) as d_dead_water,'
            . 'sum(cnt_ins_kill_free_charge) as cnt_ins_kill_free_charge,'
            . 'sum(cnt_ins_kill_free) as cnt_ins_kill_free,'
            . 'sum(cnt_ins_kill_free_threat) as cnt_ins_kill_free_threat,'
            . 'sum(cnt_ins_kill_free_before_school) as cnt_ins_kill_free_before_school,'
            . 'sum(cnt_ins_kill_free_school) as cnt_ins_kill_free_school,'
            . 'sum(cnt_ins_kill_charge) as cnt_ins_kill_charge,'
            . 'sum(cnt_ins_kill_charge_estate) as cnt_ins_kill_charge_estate,'
            . 'sum(cnt_ins_kill_charge_dog) as cnt_ins_kill_charge_dog,'
            . 'sum(cnt_hero_in_out) as cnt_hero_in_out,'
            . 'sum(cnt_hero_in) as cnt_hero_in,'
            . 'sum(cnt_hero_out) as cnt_hero_out,'
            . 'sum(cnt_s_grunt) as cnt_s_grunt,'
            . 'sum(cnt_s_people_grunt) as cnt_s_people_grunt,'
            . 'sum(cnt_s_chi_grunt) as cnt_s_chi_grunt,'
            . 'sum(cnt_s_kon) as cnt_s_kon,'
            . 'sum(cnt_s_people_kon) as cnt_s_people_kon,'
            . 'sum(cnt_s_chi_kon) as cnt_s_chi_kon,'
            . 'sum(cnt_s_cons) as cnt_s_cons,'
            . 'sum(cnt_s_people_cons) as cnt_s_people_cons,'
            . 'sum(cnt_s_chi_cons) as cnt_s_chi_cons,'
            . 'sum(cnt_pavodok) as cnt_pavodok,'
            . 'sum(cnt_control) as cnt_control,'
            . 'sum(cnt_duty) as cnt_duty,'
            . 'sum(cnt_hoz) as cnt_hoz,'
            . 'sum(cnt_zapravka) as cnt_zapravka,'
            . 'sum(cnt_disloc) as cnt_disloc,'
            . 'sum(cnt_to) as cnt_to,'
            . 'sum(cnt_neighbor) as cnt_neighbor,'
            . 'sum(cnt_ptv) as cnt_ptv,'
            . 'sum(cnt_pay) as cnt_pay,'
            . 'sum(cnt_other) as cnt_other, '
            . 'sum(cnt_fire_gps_1_po_out) as cnt_fire_gps_1_po_out, sum(cnt_fire_gps_2_po_out) as cnt_fire_gps_2_po_out'
            . ' from jarchive.battle_work_' . $filter['year'];

        if ($filter['id_region'] == 0) {//by RB
            if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
                $pdo = get_pdo_15($real_server);
                $sth = $pdo->prepare($sql_a);
                $sth->execute();
                $archive_battle_work = $sth->fetchAll();
            } else {
                $archive_battle_work = R::getAll($sql_a);
            }
        } elseif (!empty($filter['id_local'])) {//by local
            $sql_a = $sql_a . ' WHERE id_local = ' . $filter['id_local'];
            if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
                $pdo = get_pdo_15($real_server);
                $sth = $pdo->prepare($sql_a);
                $sth->execute();
                $archive_battle_work = $sth->fetchAll();
            } else {
                $archive_battle_work = R::getAll($sql_a);
            }
        } else {//by region
            $sql_a = $sql_a . ' WHERE id_region = ' . $filter['id_region'] . ' group by id_region';

            if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
                $pdo = get_pdo_15($real_server);
                $sth = $pdo->prepare($sql_a);
                $sth->execute();
                $archive_battle_work = $sth->fetchAll();
            } else {
                $archive_battle_work = R::getAll($sql_a);
            }
        }
        $archive_bw = ((isset($archive_battle_work[0])) ? $archive_battle_work[0] : array()); // there are all data from archive!!!
        //print_r($archive_bw);        echo '<br><br>';
        // exit();
        $data['archive_bw'] = $archive_bw;


        /* ---------------------- table 1 PART 1 ------------------------- */
        //$number_1 = R::getAssoc("CALL get_rigs_rep4_number_1('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}');");
        $number_1 = R::getAssoc("CALL get_rigs_rep4_part1_tbl1('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}');");
        //print_r($number_1);exit();
        $number_1_arr = array();
        if (!empty($number_1)) {
            foreach ($number_1 as $row) {

                $number_1_arr = $row;
            }
        }
        $number_1 = $number_1_arr;
        $data['number_1'] = $number_1_arr;


        /* -------------------- table2  PART 1  ------------------------ */
        //$number_2 = R::getAssoc("CALL get_rigs_rep4_number_2('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");
        $number_2 = R::getAssoc("CALL get_rigs_rep4_part1_tbl2('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");

        $number_2_arr = array();
        if (!empty($number_2)) {
            foreach ($number_2 as $row) {

                $number_2_arr = $row;
            }
        }
        $number_2 = $number_2_arr;
        $data['number_2'] = $number_2_arr;

        /* -------------------- table3  PART 1  ------------------------ */

        //$number_3 = R::getAssoc("CALL get_rigs_rep4_number_3('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");
        $number_3 = R::getAssoc("CALL get_rigs_rep4_part1_tbl3('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");

        $number_3_arr = array();
        if (!empty($number_3)) {
            foreach ($number_3 as $row) {

                $number_3_arr = $row;
            }
        }
        $number_3 = $number_3_arr;
        $data['number_3'] = $number_3_arr;



        // table 3 cars 3.10 - 3.24
        //$number_3_cars = R::getAssoc("CALL get_rigs_rep4_number_3_cars('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");
        $number_3_cars = R::getAssoc("CALL get_rigs_rep4_part1_tbl3_cars ('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");

        $number_3_cars_arr = array();
        if (!empty($number_3_cars)) {
            foreach ($number_3_cars as $row) {

                $number_3_cars_arr = $row;
            }
        }
        $number_3_cars = $number_3_cars_arr;
        $data['number_3_cars'] = $number_3_cars_arr;


        /* -------------------- table4  PART 1  ------------------------ */
        //$number_4 = R::getAssoc("CALL get_rigs_rep4_number_4('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");
        $number_4 = R::getAssoc("CALL get_rigs_rep4_part1_tbl4('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',34);");

        $number_4_arr = array();
        if (!empty($number_4)) {
            foreach ($number_4 as $row) {

                $number_4_arr = $row;
            }
        }
        $number_4 = $number_4_arr;
        $data['number_4'] = $number_4_arr;

        /* ---------------------- table 1 PART 2 ------------------------- */
        //$chapter2_numb_1 = R::getAssoc("CALL get_rigs_rep4_chapter_2_numb_1('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}');");
        $chapter2_numb_1 = R::getAssoc("CALL get_rigs_rep4_part2_tbl1('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}');");

        $chapter2_numb_1_arr = array();
        if (!empty($chapter2_numb_1)) {
            foreach ($chapter2_numb_1 as $row) {

                $chapter2_numb_1_arr = $row;
            }
        }
        $chapter2_numb_1 = $chapter2_numb_1_arr;
        $data['chapter2_numb_1'] = $chapter2_numb_1_arr;


        /* -------------------- table2  PART 2  ------------------------ */
        //$chapter2_numb_2 = R::getAssoc("CALL get_rigs_rep4_number_4('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',73);");
        $chapter2_numb_2 = R::getAssoc("CALL get_rigs_rep4_part1_tbl4('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',73);");

        $chapter2_numb_2_arr = array();
        if (!empty($chapter2_numb_2)) {
            foreach ($chapter2_numb_2 as $row) {

                $chapter2_numb_2_arr = $row;
            }
        }
        $chapter2_numb_2 = $chapter2_numb_2_arr;
        $data['chapter2_numb_2'] = $chapter2_numb_2_arr;



        // table 2 : 2.4 - 2.5 PART 2
        //$chapter2_numb_2_part = R::getAssoc("CALL get_rigs_rep4_chapter_2_numb_2('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',73);");
        $chapter2_numb_2_part = R::getAssoc("CALL get_rigs_rep4_part2_tbl2('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',73);");

        $chapter2_numb_2_part_arr = array();
        if (!empty($chapter2_numb_2_part)) {
            foreach ($chapter2_numb_2_part as $row) {

                $chapter2_numb_2_part_arr = $row;
            }
        }
        $chapter2_numb_2_part = $chapter2_numb_2_part_arr;
        $data['chapter2_numb_2_part'] = $chapter2_numb_2_part_arr;



        /* -------------------- table3  PART 2 3.1 - 3.4  ------------------------ */

        // table 3 cars 3.1 - 3.4 PART 2
        //$chapter_2_numb_3_cars = R::getAssoc("CALL get_rigs_rep4_number_3_cars('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',73);");
        $chapter_2_numb_3_cars = R::getAssoc("CALL get_rigs_rep4_part1_tbl3_cars('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}',73);");

        $chapter_2_numb_3_cars_arr = array();
        if (!empty($chapter_2_numb_3_cars)) {
            foreach ($chapter_2_numb_3_cars as $row) {

                $chapter_2_numb_3_cars_arr = $row;
            }
        }
        $chapter_2_numb_3_cars = $chapter_2_numb_3_cars_arr;
        $data['chapter_2_numb_3_cars'] = $chapter_2_numb_3_cars_arr;



        /* -------------------- PART 3  ------------------------ */



        /* -------------------- table1  PART 3  ------------------------ */

        $part_3_tbl_1 = R::getAssoc("CALL get_rigs_rep4_part3_tbl1('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}');");

        $part_3_tbl_1_arr = array();
        if (!empty($part_3_tbl_1)) {
            foreach ($part_3_tbl_1 as $row) {

                $part_3_tbl_1_arr = $row;
            }
        }
        $part_3_tbl_1 = $part_3_tbl_1_arr;
        $data['part_3_tbl_1'] = $part_3_tbl_1_arr;


        /* -------------------- table2 2.5.1 - 2.8.2  PART 3  ------------------------ */

        $part_3_tbl_2 = R::getAssoc("CALL get_rigs_rep4_part3_tbl2('{$filter['year']}','{$filter['id_region']}','{$filter['id_local']}','{$filter['date_start']}','{$filter['date_end']}');");

        $part_3_tbl_2_arr = array();
        if (!empty($part_3_tbl_2)) {
            foreach ($part_3_tbl_2 as $row) {

                $part_3_tbl_2_arr = $row;
            }
        }
        $part_3_tbl_2 = $part_3_tbl_2_arr;
        $data['part_3_tbl_2'] = $part_3_tbl_2_arr;



//                print_r($archive_bw);        echo '<br><br>';
//        print_r($part_3_tbl_2);exit();
        // exit();
        // echo htmlspecialchars_decode($caption_head_2);exit();
        /* ------------------------------------ excel  --------------------------------- */

        if (isset($is_excel)) {
            $objPHPExcel = new PHPExcel();
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/report/rep4.xlsx');

            $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
            $sheet = $objPHPExcel->getActiveSheet();

            $r = 5; //начальная строка для записи
            $c = 2; //начальный столбец для записи

            $i = 0; //счетчик кол-ва записей № п/п


            $sheet->setCellValue('A1', ($caption_head_1 . chr(10) . $caption_head_2));


            $all_rigs_fire_part_1 = ((isset($number_1['all_fire']) && !empty($number_1['all_fire'])) ? $number_1['all_fire'] : 0) +
                ((isset($archive_bw['cnt_fire_city_object']) && !empty($archive_bw['cnt_fire_city_object'])) ? $archive_bw['cnt_fire_city_object'] : 0) +
                ((isset($archive_bw['cnt_ltt_les']) && !empty($archive_bw['cnt_ltt_les'])) ? $archive_bw['cnt_ltt_les'] : 0) +
                ((isset($archive_bw['cnt_ltt_torf']) && !empty($archive_bw['cnt_ltt_torf'])) ? $archive_bw['cnt_ltt_torf'] : 0) +
                ((isset($archive_bw['cnt_ltt_trava']) && !empty($archive_bw['cnt_ltt_trava'])) ? $archive_bw['cnt_ltt_trava'] : 0) +
                ((isset($archive_bw['cnt_zagor']) && !empty($archive_bw['cnt_zagor'])) ? $archive_bw['cnt_zagor'] : 0);


            $sheet->setCellValue('C' . $r, $all_rigs_fire_part_1);

            $r += 2;

            $sheet->setCellValue('C' . $r, (((isset($number_1['cnt_fire_city_object']) && !empty($number_1['cnt_fire_city_object'])) ? $number_1['cnt_fire_city_object'] : 0) +
                ((isset($archive_bw['cnt_fire_city_object']) && !empty($archive_bw['cnt_fire_city_object'])) ? $archive_bw['cnt_fire_city_object'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_fire_city_obl']) && !empty($number_1['cnt_fire_city_obl'])) ? $number_1['cnt_fire_city_obl'] : 0) +
                ((isset($archive_bw['cnt_fire_city_obl']) && !empty($archive_bw['cnt_fire_city_obl'])) ? $archive_bw['cnt_fire_city_obl'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_fire_city_loc']) && !empty($number_1['cnt_fire_city_loc'])) ? $number_1['cnt_fire_city_loc'] : 0) +
                ((isset($archive_bw['cnt_fire_city_loc']) && !empty($archive_bw['cnt_fire_city_loc'])) ? $archive_bw['cnt_fire_city_loc'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_fire_village']) && !empty($number_1['cnt_fire_village'])) ? $number_1['cnt_fire_village'] : 0) +
                ((isset($archive_bw['cnt_fire_village']) && !empty($archive_bw['cnt_fire_village'])) ? $archive_bw['cnt_fire_village'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_ltt_les']) && !empty($number_1['cnt_ltt_les'])) ? $number_1['cnt_ltt_les'] : 0) +
                ((isset($archive_bw['cnt_ltt_les']) && !empty($archive_bw['cnt_ltt_les'])) ? $archive_bw['cnt_ltt_les'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_ltt_torf']) && !empty($number_1['cnt_ltt_torf'])) ? $number_1['cnt_ltt_torf'] : 0) +
                ((isset($archive_bw['cnt_ltt_torf']) && !empty($archive_bw['cnt_ltt_torf'])) ? $archive_bw['cnt_ltt_torf'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_ltt_trava']) && !empty($number_1['cnt_ltt_trava'])) ? $number_1['cnt_ltt_trava'] : 0) +
                ((isset($archive_bw['cnt_ltt_trava']) && !empty($archive_bw['cnt_ltt_trava'])) ? $archive_bw['cnt_ltt_trava'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_1['cnt_zagor']) && !empty($number_1['cnt_zagor'])) ? $number_1['cnt_zagor'] : 0) +
                ((isset($archive_bw['cnt_zagor']) && !empty($archive_bw['cnt_zagor'])) ? $archive_bw['cnt_zagor'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_sum_2']) && !empty($number_2['cnt_fire_sum_2'])) ? $number_2['cnt_fire_sum_2'] : 0) +
                ((isset($archive_bw['cnt_fire_sum_2']) && !empty($archive_bw['cnt_fire_sum_2'])) ? $archive_bw['cnt_fire_sum_2'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, (((isset($number_2['cnt_fire_people_help']) && !empty($number_2['cnt_fire_people_help'])) ? $number_2['cnt_fire_people_help'] : 0) +
                ((isset($archive_bw['cnt_fire_people_help']) && !empty($archive_bw['cnt_fire_people_help'])) ? $archive_bw['cnt_fire_people_help'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_gos_help']) && !empty($number_2['cnt_fire_gos_help'])) ? $number_2['cnt_fire_gos_help'] : 0) +
                ((isset($archive_bw['cnt_fire_gos_help']) && !empty($archive_bw['cnt_fire_gos_help'])) ? $archive_bw['cnt_fire_gos_help'] : 0)));

            $r ++;


            $sheet->setCellValue('C' . $r, (((isset($number_2['cnt_fire_alone_otd']) && !empty($number_2['cnt_fire_alone_otd'])) ? $number_2['cnt_fire_alone_otd'] : 0) +
                ((isset($archive_bw['cnt_fire_alone_otd']) && !empty($archive_bw['cnt_fire_alone_otd'])) ? $archive_bw['cnt_fire_alone_otd'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_alone_shift']) && !empty($number_2['cnt_fire_alone_shift'])) ? $number_2['cnt_fire_alone_shift'] : 0) +
                ((isset($archive_bw['cnt_fire_alone_shift']) && !empty($archive_bw['cnt_fire_alone_shift'])) ? $archive_bw['cnt_fire_alone_shift'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_dop_mes']) && !empty($number_2['cnt_fire_dop_mes'])) ? $number_2['cnt_fire_dop_mes'] : 0) +
                ((isset($archive_bw['cnt_fire_dop_mes']) && !empty($archive_bw['cnt_fire_dop_mes'])) ? $archive_bw['cnt_fire_dop_mes'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_no_water']) && !empty($number_2['cnt_fire_no_water'])) ? $number_2['cnt_fire_no_water'] : 0) +
                ((isset($archive_bw['cnt_fire_no_water']) && !empty($archive_bw['cnt_fire_no_water'])) ? $archive_bw['cnt_fire_no_water'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_water']) && !empty($number_2['cnt_fire_water'])) ? $number_2['cnt_fire_water'] : 0) +
                ((isset($archive_bw['cnt_fire_water']) && !empty($archive_bw['cnt_fire_water'])) ? $archive_bw['cnt_fire_water'] : 0)));

            $r += 2;


            $sheet->setCellValue('C' . $r, (((isset($number_3['cnt_fire_w_1']) && !empty($number_3['cnt_fire_w_1'])) ? $number_3['cnt_fire_w_1'] : 0) +
                ((isset($archive_bw['cnt_fire_w_1']) && !empty($archive_bw['cnt_fire_w_1'])) ? $archive_bw['cnt_fire_w_1'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_w_2']) && !empty($number_3['cnt_fire_w_2'])) ? $number_3['cnt_fire_w_2'] : 0) +
                ((isset($archive_bw['cnt_fire_w_2']) && !empty($archive_bw['cnt_fire_w_2'])) ? $archive_bw['cnt_fire_w_2'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, (((isset($number_3['cnt_fire_w_3']) && !empty($number_3['cnt_fire_w_3'])) ? $number_3['cnt_fire_w_3'] : 0) +
                ((isset($archive_bw['cnt_fire_w_3']) && !empty($archive_bw['cnt_fire_w_3'])) ? $archive_bw['cnt_fire_w_3'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_w_5']) && !empty($number_3['cnt_fire_w_5'])) ? $number_3['cnt_fire_w_5'] : 0) +
                ((isset($archive_bw['cnt_fire_w_5']) && !empty($archive_bw['cnt_fire_w_5'])) ? $archive_bw['cnt_fire_w_5'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_svd']) && !empty($number_3['cnt_fire_svd'])) ? $number_3['cnt_fire_svd'] : 0) +
                ((isset($archive_bw['cnt_fire_svd']) && !empty($archive_bw['cnt_fire_svd'])) ? $archive_bw['cnt_fire_svd'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_gps_1']) && !empty($number_3['cnt_fire_gps_1'])) ? $number_3['cnt_fire_gps_1'] : 0) +
                ((isset($archive_bw['cnt_fire_gps_1']) && !empty($archive_bw['cnt_fire_gps_1'])) ? $archive_bw['cnt_fire_gps_1'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_gps_1_po_out']) && !empty($number_3['cnt_fire_gps_1_po_out'])) ? $number_3['cnt_fire_gps_1_po_out'] : 0) +
                ((isset($archive_bw['cnt_fire_gps_1_po_out']) && !empty($archive_bw['cnt_fire_gps_1_po_out'])) ? $archive_bw['cnt_fire_gps_1_po_out'] : 0)));


            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_gps_2']) && !empty($number_3['cnt_fire_gps_2'])) ? $number_3['cnt_fire_gps_2'] : 0) +
                ((isset($archive_bw['cnt_fire_gps_2']) && !empty($archive_bw['cnt_fire_gps_2'])) ? $archive_bw['cnt_fire_gps_2'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_gps_2_po_out']) && !empty($number_3['cnt_fire_gps_2_po_out'])) ? $number_3['cnt_fire_gps_2_po_out'] : 0) +
                ((isset($archive_bw['cnt_fire_gps_2_po_out']) && !empty($archive_bw['cnt_fire_gps_2_po_out'])) ? $archive_bw['cnt_fire_gps_2_po_out'] : 0)));


//            $r++;
//            $sheet->setCellValue('C' . $r, ( ((isset($number_3['cnt_fire_po_out']) && !empty($number_3['cnt_fire_po_out'])) ? $number_3['cnt_fire_po_out'] : 0) +
//                ((isset($archive_bw['cnt_fire_po_out']) && !empty($archive_bw['cnt_fire_po_out'])) ? $archive_bw['cnt_fire_po_out'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_powder_mob']) && !empty($number_2['cnt_fire_powder_mob'])) ? $number_2['cnt_fire_powder_mob'] : 0) +
                ((isset($archive_bw['cnt_fire_powder_mob']) && !empty($archive_bw['cnt_fire_powder_mob'])) ? $archive_bw['cnt_fire_powder_mob'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_powder_out']) && !empty($number_2['cnt_fire_powder_out'])) ? $number_2['cnt_fire_powder_out'] : 0) +
                ((isset($archive_bw['cnt_fire_powder_out']) && !empty($archive_bw['cnt_fire_powder_out'])) ? $archive_bw['cnt_fire_powder_out'] : 0)));

            $r++;


            $sum_3_9 = 0;

            if (isset($number_2['sum_tool']) && !empty($number_2['sum_tool']))
                $sum_3_9 += $number_2['sum_tool'];


            if (isset($archive_bw['cnt_fire_tool_meh']) && !empty($archive_bw['cnt_fire_tool_meh']))
                $sum_3_9 += $archive_bw['cnt_fire_tool_meh'];
            if (isset($archive_bw['cnt_fire_tool_pnev']) && !empty($archive_bw['cnt_fire_tool_pnev']))
                $sum_3_9 += $archive_bw['cnt_fire_tool_pnev'];
            if (isset($archive_bw['cnt_fire_tool_gidr']) && !empty($archive_bw['cnt_fire_tool_gidr']))
                $sum_3_9 += $archive_bw['cnt_fire_tool_gidr'];

            $sheet->setCellValue('C' . $r, $sum_3_9);

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_tool_meh']) && !empty($number_2['cnt_fire_tool_meh'])) ? $number_2['cnt_fire_tool_meh'] : 0) +
                ((isset($archive_bw['cnt_fire_tool_meh']) && !empty($archive_bw['cnt_fire_tool_meh'])) ? $archive_bw['cnt_fire_tool_meh'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_tool_pnev']) && !empty($number_2['cnt_fire_tool_pnev'])) ? $number_2['cnt_fire_tool_pnev'] : 0) +
                ((isset($archive_bw['cnt_fire_tool_pnev']) && !empty($archive_bw['cnt_fire_tool_pnev'])) ? $archive_bw['cnt_fire_tool_pnev'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($number_2['cnt_fire_tool_gidr']) && !empty($number_2['cnt_fire_tool_gidr'])) ? $number_2['cnt_fire_tool_gidr'] : 0) +
                ((isset($archive_bw['cnt_fire_tool_gidr']) && !empty($archive_bw['cnt_fire_tool_gidr'])) ? $archive_bw['cnt_fire_tool_gidr'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, (((isset($number_3_cars['cnt_fire_abr']) && !empty($number_3_cars['cnt_fire_abr'])) ? $number_3_cars['cnt_fire_abr'] : 0) +
                ((isset($archive_bw['cnt_fire_abr']) && !empty($archive_bw['cnt_fire_abr'])) ? $archive_bw['cnt_fire_abr'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, (((isset($number_3_cars['cnt_fire_ac']) && !empty($number_3_cars['cnt_fire_ac'])) ? $number_3_cars['cnt_fire_ac'] : 0) +
                ((isset($archive_bw['cnt_fire_ac']) && !empty($archive_bw['cnt_fire_ac'])) ? $archive_bw['cnt_fire_ac'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_al']) && !empty($number_3_cars['cnt_fire_al'])) ? $number_3_cars['cnt_fire_al'] : 0) +
                ((isset($archive_bw['cnt_fire_al']) && !empty($archive_bw['cnt_fire_al'])) ? $archive_bw['cnt_fire_al'] : 0) +
                ((isset($number_3_cars['cnt_fire_akp']) && !empty($number_3_cars['cnt_fire_akp'])) ? $number_3_cars['cnt_fire_akp'] : 0) +
                ((isset($archive_bw['cnt_fire_akp']) && !empty($archive_bw['cnt_fire_akp'])) ? $archive_bw['cnt_fire_akp'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($number_3_cars['cnt_fire_adu']) && !empty($number_3_cars['cnt_fire_adu'])) ? $number_3_cars['cnt_fire_adu'] : 0) +
                ((isset($archive_bw['cnt_fire_adu']) && !empty($archive_bw['cnt_fire_adu'])) ? $archive_bw['cnt_fire_adu'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_pns']) && !empty($number_3_cars['cnt_fire_pns'])) ? $number_3_cars['cnt_fire_pns'] : 0) +
                ((isset($archive_bw['cnt_fire_pns']) && !empty($archive_bw['cnt_fire_pns'])) ? $archive_bw['cnt_fire_pns'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_ar']) && !empty($number_3_cars['cnt_fire_ar'])) ? $number_3_cars['cnt_fire_ar'] : 0) +
                ((isset($archive_bw['cnt_fire_ar']) && !empty($archive_bw['cnt_fire_ar'])) ? $archive_bw['cnt_fire_ar'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_aso']) && !empty($number_3_cars['cnt_fire_aso'])) ? $number_3_cars['cnt_fire_aso'] : 0) +
                ((isset($archive_bw['cnt_fire_aso']) && !empty($archive_bw['cnt_fire_aso'])) ? $archive_bw['cnt_fire_aso'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_agdzs']) && !empty($number_3_cars['cnt_fire_agdzs'])) ? $number_3_cars['cnt_fire_agdzs'] : 0) +
                ((isset($archive_bw['cnt_fire_agdzs']) && !empty($archive_bw['cnt_fire_agdzs'])) ? $archive_bw['cnt_fire_agdzs'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_avpt']) && !empty($number_3_cars['cnt_fire_avpt'])) ? $number_3_cars['cnt_fire_avpt'] : 0) +
                ((isset($archive_bw['cnt_fire_avpt']) && !empty($archive_bw['cnt_fire_avpt'])) ? $archive_bw['cnt_fire_avpt'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_ap']) && !empty($number_3_cars['cnt_fire_ap'])) ? $number_3_cars['cnt_fire_ap'] : 0) +
                ((isset($archive_bw['cnt_fire_ap']) && !empty($archive_bw['cnt_fire_ap'])) ? $archive_bw['cnt_fire_ap'] : 0) +
                ((isset($number_3_cars['cnt_fire_akt']) && !empty($number_3_cars['cnt_fire_akt'])) ? $number_3_cars['cnt_fire_akt'] : 0) +
                ((isset($archive_bw['cnt_fire_akt']) && !empty($archive_bw['cnt_fire_akt'])) ? $archive_bw['cnt_fire_akt'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_agvt']) && !empty($number_3_cars['cnt_fire_agvt'])) ? $number_3_cars['cnt_fire_agvt'] : 0) +
                ((isset($archive_bw['cnt_fire_agvt']) && !empty($archive_bw['cnt_fire_agvt'])) ? $archive_bw['cnt_fire_agvt'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_ash']) && !empty($number_3_cars['cnt_fire_ash'])) ? $number_3_cars['cnt_fire_ash'] : 0) +
                ((isset($archive_bw['cnt_fire_ash']) && !empty($archive_bw['cnt_fire_ash'])) ? $archive_bw['cnt_fire_ash'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_vz']) && !empty($number_3_cars['cnt_fire_vz'])) ? $number_3_cars['cnt_fire_vz'] : 0) +
                ((isset($archive_bw['cnt_fire_vz']) && !empty($archive_bw['cnt_fire_vz'])) ? $archive_bw['cnt_fire_vz'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_asa']) && !empty($number_3_cars['cnt_fire_asa'])) ? $number_3_cars['cnt_fire_asa'] : 0) +
                ((isset($archive_bw['cnt_fire_asa']) && !empty($archive_bw['cnt_fire_asa'])) ? $archive_bw['cnt_fire_asa'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_3_cars['cnt_fire_ams']) && !empty($number_3_cars['cnt_fire_ams'])) ? $number_3_cars['cnt_fire_ams'] : 0) +
                ((isset($archive_bw['cnt_fire_ams']) && !empty($archive_bw['cnt_fire_ams'])) ? $archive_bw['cnt_fire_ams'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_avia_help']) && !empty($number_2['cnt_fire_avia_help'])) ? $number_2['cnt_fire_avia_help'] : 0) +
                ((isset($archive_bw['cnt_fire_avia_help']) && !empty($archive_bw['cnt_fire_avia_help'])) ? $archive_bw['cnt_fire_avia_help'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_other_mes']) && !empty($number_2['cnt_fire_other_mes'])) ? $number_2['cnt_fire_other_mes'] : 0) +
                ((isset($archive_bw['cnt_fire_other_mes']) && !empty($archive_bw['cnt_fire_other_mes'])) ? $archive_bw['cnt_fire_other_mes'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_one_gdzs']) && !empty($number_2['cnt_fire_one_gdzs'])) ? $number_2['cnt_fire_one_gdzs'] : 0) +
                ((isset($archive_bw['cnt_fire_one_gdzs']) && !empty($archive_bw['cnt_fire_one_gdzs'])) ? $archive_bw['cnt_fire_one_gdzs'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_many_gdzs']) && !empty($number_2['cnt_fire_many_gdzs'])) ? $number_2['cnt_fire_many_gdzs'] : 0) +
                ((isset($archive_bw['cnt_fire_many_gdzs']) && !empty($archive_bw['cnt_fire_many_gdzs'])) ? $archive_bw['cnt_fire_many_gdzs'] : 0)));

            $r += 2;
            $save_people_on_fire = ((isset($number_4['cnt_fire_save_man']) && !empty($number_4['cnt_fire_save_man'])) ? $number_4['cnt_fire_save_man'] : 0) +
                ((isset($archive_bw['cnt_fire_save_man']) && !empty($archive_bw['cnt_fire_save_man'])) ? $archive_bw['cnt_fire_save_man'] : 0);

            $sheet->setCellValue('C' . $r, $save_people_on_fire);

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_save_p_mask']) && !empty($number_2['cnt_fire_save_p_mask'])) ? $number_2['cnt_fire_save_p_mask'] : 0) +
                ((isset($archive_bw['cnt_fire_save_p_mask']) && !empty($archive_bw['cnt_fire_save_p_mask'])) ? $archive_bw['cnt_fire_save_p_mask'] : 0)));

            $r++;
            $save_child_on_fire = ((isset($number_4['cnt_fire_save_child']) && !empty($number_4['cnt_fire_save_child'])) ? $number_4['cnt_fire_save_child'] : 0) +
                ((isset($archive_bw['cnt_fire_save_child']) && !empty($archive_bw['cnt_fire_save_child'])) ? $archive_bw['cnt_fire_save_child'] : 0);

            $sheet->setCellValue('C' . $r, $save_child_on_fire);

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_4['cnt_fire_ev_man']) && !empty($number_4['cnt_fire_ev_man'])) ? $number_4['cnt_fire_ev_man'] : 0) +
                ((isset($archive_bw['cnt_fire_ev_man']) && !empty($archive_bw['cnt_fire_ev_man'])) ? $archive_bw['cnt_fire_ev_man'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_4['cnt_fire_ev_child']) && !empty($number_4['cnt_fire_ev_child'])) ? $number_4['cnt_fire_ev_child'] : 0) +
                ((isset($archive_bw['cnt_fire_ev_child']) && !empty($archive_bw['cnt_fire_ev_child'])) ? $archive_bw['cnt_fire_ev_child'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($number_4['cnt_fire_save_an']) && !empty($number_4['cnt_fire_save_an'])) ? $number_4['cnt_fire_save_an'] : 0) +
                ((isset($archive_bw['cnt_fire_save_an']) && !empty($archive_bw['cnt_fire_save_an'])) ? $archive_bw['cnt_fire_save_an'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_pred_food']) && !empty($number_2['cnt_fire_pred_food'])) ? $number_2['cnt_fire_pred_food'] : 0) +
                ((isset($archive_bw['cnt_fire_pred_food']) && !empty($archive_bw['cnt_fire_pred_food'])) ? $archive_bw['cnt_fire_pred_food'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_pred_build']) && !empty($number_2['cnt_fire_pred_build'])) ? $number_2['cnt_fire_pred_build'] : 0) +
                ((isset($archive_bw['cnt_fire_pred_build']) && !empty($archive_bw['cnt_fire_pred_build'])) ? $archive_bw['cnt_fire_pred_build'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($number_2['cnt_fire_pred_vehicle']) && !empty($number_2['cnt_fire_pred_vehicle'])) ? $number_2['cnt_fire_pred_vehicle'] : 0) +
                ((isset($archive_bw['cnt_fire_pred_vehicle']) && !empty($archive_bw['cnt_fire_pred_vehicle'])) ? $archive_bw['cnt_fire_pred_vehicle'] : 0)));

            $r += 3;

            $all_rigs_hs_part_2 = ((isset($chapter2_numb_1['hs_sum']) && !empty($chapter2_numb_1['hs_sum'])) ? $chapter2_numb_1['hs_sum'] : 0) +
                ((isset($archive_bw['cnt_hs_tehn']) && !empty($archive_bw['cnt_hs_tehn'])) ? $archive_bw['cnt_hs_tehn'] : 0) +
                ((isset($archive_bw['cnt_hs_nature']) && !empty($archive_bw['cnt_hs_nature'])) ? $archive_bw['cnt_hs_nature'] : 0);


            $sheet->setCellValue('C' . $r, $all_rigs_hs_part_2);

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_1['cnt_hs_tehn']) && !empty($chapter2_numb_1['cnt_hs_tehn'])) ? $chapter2_numb_1['cnt_hs_tehn'] : 0) +
                ((isset($archive_bw['cnt_hs_tehn']) && !empty($archive_bw['cnt_hs_tehn'])) ? $archive_bw['cnt_hs_tehn'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_1['cnt_hs_nature']) && !empty($chapter2_numb_1['cnt_hs_nature'])) ? $chapter2_numb_1['cnt_hs_nature'] : 0) +
                ((isset($archive_bw['cnt_hs_nature']) && !empty($archive_bw['cnt_hs_nature'])) ? $archive_bw['cnt_hs_nature'] : 0)));

            $r += 2;
            $save_people_on_hs = ((isset($chapter2_numb_2['cnt_fire_save_man']) && !empty($chapter2_numb_2['cnt_fire_save_man'])) ? $chapter2_numb_2['cnt_fire_save_man'] : 0) +
                ((isset($archive_bw['cnt_hs_save_man']) && !empty($archive_bw['cnt_hs_save_man'])) ? $archive_bw['cnt_hs_save_man'] : 0);

            $sheet->setCellValue('C' . $r, $save_people_on_hs);

            $r++;
            $save_child_on_hs = ((isset($chapter2_numb_2['cnt_fire_save_child']) && !empty($chapter2_numb_2['cnt_fire_save_child'])) ? $chapter2_numb_2['cnt_fire_save_child'] : 0) +
                ((isset($archive_bw['cnt_hs_save_child']) && !empty($archive_bw['cnt_hs_save_child'])) ? $archive_bw['cnt_hs_save_child'] : 0);

            $sheet->setCellValue('C' . $r, $save_child_on_hs);

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2['cnt_fire_ev_man']) && !empty($chapter2_numb_2['cnt_fire_ev_man'])) ? $chapter2_numb_2['cnt_fire_ev_man'] : 0) +
                ((isset($archive_bw['cnt_hs_ev_man']) && !empty($archive_bw['cnt_hs_ev_man'])) ? $archive_bw['cnt_hs_ev_man'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2['cnt_fire_ev_child']) && !empty($chapter2_numb_2['cnt_fire_ev_child'])) ? $chapter2_numb_2['cnt_fire_ev_child'] : 0) +
                ((isset($archive_bw['cnt_hs_ev_child']) && !empty($archive_bw['cnt_hs_ev_child'])) ? $archive_bw['cnt_hs_ev_child'] : 0)
            ));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2['cnt_fire_save_an']) && !empty($chapter2_numb_2['cnt_fire_save_an'])) ? $chapter2_numb_2['cnt_fire_save_an'] : 0) +
                ((isset($archive_bw['cnt_hs_save_an']) && !empty($archive_bw['cnt_hs_save_an'])) ? $archive_bw['cnt_hs_save_an'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, (((isset($chapter2_numb_2_part['cnt_hs_pred_build_4s']) && !empty($chapter2_numb_2_part['cnt_hs_pred_build_4s'])) ? $chapter2_numb_2_part['cnt_hs_pred_build_4s'] : 0) +
                ((isset($archive_bw['cnt_hs_pred_build_4s']) && !empty($archive_bw['cnt_hs_pred_build_4s'])) ? $archive_bw['cnt_hs_pred_build_4s'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2_part['cnt_hs_pred_vehicle_4s']) && !empty($chapter2_numb_2_part['cnt_hs_pred_vehicle_4s'])) ? $chapter2_numb_2_part['cnt_hs_pred_vehicle_4s'] : 0) +
                ((isset($archive_bw['cnt_hs_pred_vehicle_4s']) && !empty($archive_bw['cnt_hs_pred_vehicle_4s'])) ? $archive_bw['cnt_hs_pred_vehicle_4s'] : 0)));

            $r += 3;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_abr']) && !empty($chapter_2_numb_3_cars['cnt_fire_abr'])) ? $chapter_2_numb_3_cars['cnt_fire_abr'] : 0) +
                ((isset($archive_bw['cnt_hs_abr']) && !empty($archive_bw['cnt_hs_abr'])) ? $archive_bw['cnt_hs_abr'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_ac']) && !empty($chapter_2_numb_3_cars['cnt_fire_ac'])) ? $chapter_2_numb_3_cars['cnt_fire_ac'] : 0) +
                ((isset($archive_bw['cnt_hs_ac']) && !empty($archive_bw['cnt_hs_ac'])) ? $archive_bw['cnt_hs_ac'] : 0)));

            $r += 2;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_asa']) && !empty($chapter_2_numb_3_cars['cnt_fire_asa'])) ? $chapter_2_numb_3_cars['cnt_fire_asa'] : 0) +
                ((isset($archive_bw['cnt_hs_asa']) && !empty($archive_bw['cnt_hs_asa'])) ? $archive_bw['cnt_hs_asa'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_p_hrz']) && !empty($chapter_2_numb_3_cars['cnt_fire_p_hrz'])) ? $chapter_2_numb_3_cars['cnt_fire_p_hrz'] : 0) +
                ((isset($archive_bw['cnt_hs_p_hrz']) && !empty($archive_bw['cnt_hs_p_hrz'])) ? $archive_bw['cnt_hs_p_hrz'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_p_avs']) && !empty($chapter_2_numb_3_cars['cnt_fire_p_avs'])) ? $chapter_2_numb_3_cars['cnt_fire_p_avs'] : 0) +
                ((isset($archive_bw['cnt_hs_p_avs']) && !empty($archive_bw['cnt_hs_p_avs'])) ? $archive_bw['cnt_hs_p_avs'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_ams']) && !empty($chapter_2_numb_3_cars['cnt_fire_ams'])) ? $chapter_2_numb_3_cars['cnt_fire_ams'] : 0) +
                ((isset($archive_bw['cnt_hs_ams']) && !empty($archive_bw['cnt_hs_ams'])) ? $archive_bw['cnt_hs_ams'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_aso']) && !empty($chapter_2_numb_3_cars['cnt_fire_aso'])) ? $chapter_2_numb_3_cars['cnt_fire_aso'] : 0) +
                ((isset($archive_bw['cnt_hs_aso']) && !empty($archive_bw['cnt_hs_aso'])) ? $archive_bw['cnt_hs_aso'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_al']) && !empty($chapter_2_numb_3_cars['cnt_fire_al'])) ? $chapter_2_numb_3_cars['cnt_fire_al'] : 0) +
                ((isset($archive_bw['cnt_hs_al']) && !empty($archive_bw['cnt_hs_al'])) ? $archive_bw['cnt_hs_al'] : 0) +
                ((isset($chapter_2_numb_3_cars['cnt_fire_akp']) && !empty($chapter_2_numb_3_cars['cnt_fire_akp'])) ? $chapter_2_numb_3_cars['cnt_fire_akp'] : 0) +
                ((isset($archive_bw['cnt_hs_akp']) && !empty($archive_bw['cnt_hs_akp'])) ? $archive_bw['cnt_hs_akp'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_ash']) && !empty($chapter_2_numb_3_cars['cnt_fire_ash'])) ? $chapter_2_numb_3_cars['cnt_fire_ash'] : 0) +
                ((isset($archive_bw['cnt_hs_ash']) && !empty($archive_bw['cnt_hs_ash'])) ? $archive_bw['cnt_hs_ash'] : 0)));

            $r += 2;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_kran']) && !empty($chapter_2_numb_3_cars['cnt_fire_kran'])) ? $chapter_2_numb_3_cars['cnt_fire_kran'] : 0) +
                ((isset($archive_bw['cnt_hs_kran']) && !empty($archive_bw['cnt_hs_kran'])) ? $archive_bw['cnt_hs_kran'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($chapter_2_numb_3_cars['cnt_fire_pes']) && !empty($chapter_2_numb_3_cars['cnt_fire_pes'])) ? $chapter_2_numb_3_cars['cnt_fire_pes'] : 0) +
                ((isset($archive_bw['cnt_hs_pes']) && !empty($archive_bw['cnt_hs_pes'])) ? $archive_bw['cnt_hs_pes'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter_2_numb_3_cars['cnt_fire_toplivo_z']) && !empty($chapter_2_numb_3_cars['cnt_fire_toplivo_z'])) ? $chapter_2_numb_3_cars['cnt_fire_toplivo_z'] : 0) +
                ((isset($archive_bw['cnt_hs_toplivo_z']) && !empty($archive_bw['cnt_hs_toplivo_z'])) ? $archive_bw['cnt_hs_toplivo_z'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2_part['cnt_hs_avia_4s']) && !empty($chapter2_numb_2_part['cnt_hs_avia_4s'])) ? $chapter2_numb_2_part['cnt_hs_avia_4s'] : 0) +
                ((isset($archive_bw['cnt_hs_avia_4s']) && !empty($archive_bw['cnt_hs_avia_4s'])) ? $archive_bw['cnt_hs_avia_4s'] : 0)));

            $r++;


            $sum2_tool_3_6 = 0;

            if (isset($chapter2_numb_2_part['sum_tool']) && !empty($chapter2_numb_2_part['sum_tool']))
                $sum2_tool_3_6 += $chapter2_numb_2_part['sum_tool'];


            if (isset($archive_bw['cnt_hs_tool_meh']) && !empty($archive_bw['cnt_hs_tool_meh']))
                $sum2_tool_3_6 += $archive_bw['cnt_hs_tool_meh'];
            if (isset($archive_bw['cnt_hs_tool_pnev']) && !empty($archive_bw['cnt_hs_tool_pnev']))
                $sum2_tool_3_6 += $archive_bw['cnt_hs_tool_pnev'];
            if (isset($archive_bw['cnt_hs_tool_gidr']) && !empty($archive_bw['cnt_hs_tool_gidr']))
                $sum2_tool_3_6 += $archive_bw['cnt_hs_tool_gidr'];

            $sheet->setCellValue('C' . $r, $sum2_tool_3_6);

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2_part['cnt_hs_tool_meh']) && !empty($chapter2_numb_2_part['cnt_hs_tool_meh'])) ? $chapter2_numb_2_part['cnt_hs_tool_meh'] : 0) +
                ((isset($archive_bw['cnt_hs_tool_meh']) && !empty($archive_bw['cnt_hs_tool_meh'])) ? $archive_bw['cnt_hs_tool_meh'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2_part['cnt_hs_tool_pnev']) && !empty($chapter2_numb_2_part['cnt_hs_tool_pnev'])) ? $chapter2_numb_2_part['cnt_hs_tool_pnev'] : 0) +
                ((isset($archive_bw['cnt_hs_tool_pnev']) && !empty($archive_bw['cnt_hs_tool_pnev'])) ? $archive_bw['cnt_hs_tool_pnev'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($chapter2_numb_2_part['cnt_hs_tool_gidr']) && !empty($chapter2_numb_2_part['cnt_hs_tool_gidr'])) ? $chapter2_numb_2_part['cnt_hs_tool_gidr'] : 0) +
                ((isset($archive_bw['cnt_hs_tool_gidr']) && !empty($archive_bw['cnt_hs_tool_gidr'])) ? $archive_bw['cnt_hs_tool_gidr'] : 0)));

//            $r += 2;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['zan_sum']) && !empty($part_3_tbl_1['zan_sum'])) ? $part_3_tbl_1['zan_sum'] : 0) +
//                ((isset($archive_bw['cnt_tsu']) && !empty($archive_bw['cnt_tsu'])) ? $archive_bw['cnt_tsu'] : 0) +
//                ((isset($archive_bw['cnt_tsz']) && !empty($archive_bw['cnt_tsz'])) ? $archive_bw['cnt_tsz'] : 0) +
//                ((isset($archive_bw['cnt_pasp']) && !empty($archive_bw['cnt_pasp'])) ? $archive_bw['cnt_pasp'] : 0)));
//
//            $r++;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_tsu']) && !empty($part_3_tbl_1['cnt_tsu'])) ? $part_3_tbl_1['cnt_tsu'] : 0) +
//                ((isset($archive_bw['cnt_tsu']) && !empty($archive_bw['cnt_tsu'])) ? $archive_bw['cnt_tsu'] : 0)));
//
//            $r++;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_tsz']) && !empty($part_3_tbl_1['cnt_tsz'])) ? $part_3_tbl_1['cnt_tsz'] : 0) +
//                ((isset($archive_bw['cnt_tsz']) && !empty($archive_bw['cnt_tsz'])) ? $archive_bw['cnt_tsz'] : 0)));
//
//            $r++;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_night']) && !empty($part_3_tbl_1['cnt_night'])) ? $part_3_tbl_1['cnt_night'] : 0) +
//                ((isset($archive_bw['cnt_night']) && !empty($archive_bw['cnt_night'])) ? $archive_bw['cnt_night'] : 0)));
//
//            $r++;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_pasp']) && !empty($part_3_tbl_1['cnt_pasp'])) ? $part_3_tbl_1['cnt_pasp'] : 0) +
//                ((isset($archive_bw['cnt_pasp']) && !empty($archive_bw['cnt_pasp'])) ? $archive_bw['cnt_pasp'] : 0)));
//
//            $r += 2;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_hs_fire']) && !empty($part_3_tbl_1['cnt_hs_fire'])) ? $part_3_tbl_1['cnt_hs_fire'] : 0) +
//                ((isset($archive_bw['cnt_hs_fire']) && !empty($archive_bw['cnt_hs_fire'])) ? $archive_bw['cnt_hs_fire'] : 0)));
//
//            $r++;
//            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_fire']) && !empty($part_3_tbl_1['cnt_fire'])) ? $part_3_tbl_1['cnt_fire'] : 0) +
//                ((isset($archive_bw['cnt_fire']) && !empty($archive_bw['cnt_fire'])) ? $archive_bw['cnt_fire'] : 0)));

            $signal = ((isset($part_3_tbl_1['cnt_signal']) && !empty($part_3_tbl_1['cnt_signal'])) ? $part_3_tbl_1['cnt_signal'] : 0) +
                ((isset($archive_bw['cnt_signal']) && !empty($archive_bw['cnt_signal'])) ? $archive_bw['cnt_signal'] : 0) +
                ((isset($part_3_tbl_1['cnt_molnia']) && !empty($part_3_tbl_1['cnt_molnia'])) ? $part_3_tbl_1['cnt_molnia'] : 0) +
                ((isset($archive_bw['cnt_molnia']) && !empty($archive_bw['cnt_molnia'])) ? $archive_bw['cnt_molnia'] : 0);


            $false = ((isset($part_3_tbl_1['cnt_false']) && !empty($part_3_tbl_1['cnt_false'])) ? $part_3_tbl_1['cnt_false'] : 0) +
                ((isset($archive_bw['cnt_false']) && !empty($archive_bw['cnt_false'])) ? $archive_bw['cnt_false'] : 0);

            $help = ((isset($part_3_tbl_1['cnt_help']) && !empty($part_3_tbl_1['cnt_help'])) ? $part_3_tbl_1['cnt_help'] : 0) +
                ((isset($archive_bw['cnt_help']) && !empty($archive_bw['cnt_help'])) ? $archive_bw['cnt_help'] : 0);

            $demerk = ((isset($part_3_tbl_1['cnt_demerk']) && !empty($part_3_tbl_1['cnt_demerk'])) ? $part_3_tbl_1['cnt_demerk'] : 0) +
                ((isset($archive_bw['cnt_demerk']) && !empty($archive_bw['cnt_demerk'])) ? $archive_bw['cnt_demerk'] : 0);

            $dtp = ((isset($part_3_tbl_2['cnt_rigs_rb_3_dtp']) && !empty($part_3_tbl_2['cnt_rigs_rb_3_dtp'])) ? $part_3_tbl_2['cnt_rigs_rb_3_dtp'] : 0) +
                ((isset($archive_bw['cnt_rigs_rb_3_dtp']) && !empty($archive_bw['cnt_rigs_rb_3_dtp'])) ? $archive_bw['cnt_rigs_rb_3_dtp'] : 0);

            $akva = ((isset($part_3_tbl_2['cnt_rigs_rb_3_water']) && !empty($part_3_tbl_2['cnt_rigs_rb_3_water'])) ? $part_3_tbl_2['cnt_rigs_rb_3_water'] : 0) +
                ((isset($archive_bw['cnt_rigs_rb_3_water']) && !empty($archive_bw['cnt_rigs_rb_3_water'])) ? $archive_bw['cnt_rigs_rb_3_water'] : 0);

            $ins_kill_free_charge = ((isset($part_3_tbl_2['cnt_ins_kill_free_charge']) && !empty($part_3_tbl_2['cnt_ins_kill_free_charge'])) ? $part_3_tbl_2['cnt_ins_kill_free_charge'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_free_charge']) && !empty($archive_bw['cnt_ins_kill_free_charge'])) ? $archive_bw['cnt_ins_kill_free_charge'] : 0);

            $pavodok = ((isset($part_3_tbl_1['cnt_pavodok']) && !empty($part_3_tbl_1['cnt_pavodok'])) ? $part_3_tbl_1['cnt_pavodok'] : 0) +
                ((isset($archive_bw['cnt_pavodok']) && !empty($archive_bw['cnt_pavodok'])) ? $archive_bw['cnt_pavodok'] : 0);

            $prohie = ((isset($part_3_tbl_1['cnt_sum']) && !empty($part_3_tbl_1['cnt_sum'])) ? $part_3_tbl_1['cnt_sum'] : 0) +
                ((isset($archive_bw['cnt_control']) && !empty($archive_bw['cnt_control'])) ? $archive_bw['cnt_control'] : 0) +
                ((isset($archive_bw['cnt_duty']) && !empty($archive_bw['cnt_duty'])) ? $archive_bw['cnt_duty'] : 0) +
                ((isset($archive_bw['cnt_hoz']) && !empty($archive_bw['cnt_hoz'])) ? $archive_bw['cnt_hoz'] : 0) +
                ((isset($archive_bw['cnt_zapravka']) && !empty($archive_bw['cnt_zapravka'])) ? $archive_bw['cnt_zapravka'] : 0) +
                ((isset($archive_bw['cnt_disloc']) && !empty($archive_bw['cnt_disloc'])) ? $archive_bw['cnt_disloc'] : 0) +
                ((isset($archive_bw['cnt_to']) && !empty($archive_bw['cnt_to'])) ? $archive_bw['cnt_to'] : 0) +
                ((isset($archive_bw['cnt_neighbor']) && !empty($archive_bw['cnt_neighbor'])) ? $archive_bw['cnt_neighbor'] : 0) +
                ((isset($archive_bw['cnt_ptv']) && !empty($archive_bw['cnt_ptv'])) ? $archive_bw['cnt_ptv'] : 0) +
                ((isset($archive_bw['cnt_pay']) && !empty($archive_bw['cnt_pay'])) ? $archive_bw['cnt_pay'] : 0) +
                ((isset($archive_bw['cnt_other']) && !empty($archive_bw['cnt_other'])) ? $archive_bw['cnt_other'] : 0);

            $other_rigs_part_3 = $signal + $false + $help + $demerk + $dtp + $akva + $ins_kill_free_charge + $pavodok + $prohie;

            $r += 2;
            $sheet->setCellValue('C' . $r, $other_rigs_part_3);


            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_signal']) && !empty($part_3_tbl_1['cnt_signal'])) ? $part_3_tbl_1['cnt_signal'] : 0) +
                ((isset($archive_bw['cnt_signal']) && !empty($archive_bw['cnt_signal'])) ? $archive_bw['cnt_signal'] : 0) +
                ((isset($part_3_tbl_1['cnt_molnia']) && !empty($part_3_tbl_1['cnt_molnia'])) ? $part_3_tbl_1['cnt_molnia'] : 0) +
                ((isset($archive_bw['cnt_molnia']) && !empty($archive_bw['cnt_molnia'])) ? $archive_bw['cnt_molnia'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_molnia']) && !empty($part_3_tbl_1['cnt_molnia'])) ? $part_3_tbl_1['cnt_molnia'] : 0) +
                ((isset($archive_bw['cnt_molnia']) && !empty($archive_bw['cnt_molnia'])) ? $archive_bw['cnt_molnia'] : 0)
            ));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_false']) && !empty($part_3_tbl_1['cnt_false'])) ? $part_3_tbl_1['cnt_false'] : 0) +
                ((isset($archive_bw['cnt_false']) && !empty($archive_bw['cnt_false'])) ? $archive_bw['cnt_false'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_help']) && !empty($part_3_tbl_1['cnt_help'])) ? $part_3_tbl_1['cnt_help'] : 0) +
                ((isset($archive_bw['cnt_help']) && !empty($archive_bw['cnt_help'])) ? $archive_bw['cnt_help'] : 0)));

            $r++;

            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_demerk']) && !empty($part_3_tbl_1['cnt_demerk'])) ? $part_3_tbl_1['cnt_demerk'] : 0) +
                ((isset($archive_bw['cnt_demerk']) && !empty($archive_bw['cnt_demerk'])) ? $archive_bw['cnt_demerk'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['col_arg']) && !empty($part_3_tbl_2['col_arg'])) ? $part_3_tbl_2['col_arg'] : 0) +
                ((isset($archive_bw['col_arg']) && !empty($archive_bw['col_arg'])) ? $archive_bw['col_arg'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['col_was']) && !empty($part_3_tbl_2['col_was'])) ? $part_3_tbl_2['col_was'] : 0) +
                ((isset($archive_bw['col_was']) && !empty($archive_bw['col_was'])) ? $archive_bw['col_was'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_rigs_rb_3_dtp']) && !empty($part_3_tbl_2['cnt_rigs_rb_3_dtp'])) ? $part_3_tbl_2['cnt_rigs_rb_3_dtp'] : 0) +
                ((isset($archive_bw['cnt_rigs_rb_3_dtp']) && !empty($archive_bw['cnt_rigs_rb_3_dtp'])) ? $archive_bw['cnt_rigs_rb_3_dtp'] : 0)));

            $r++;
            $save_people_on_dtp = ((isset($part_3_tbl_2['s_peop_dtp']) && !empty($part_3_tbl_2['s_peop_dtp'])) ? $part_3_tbl_2['s_peop_dtp'] : 0) +
                ((isset($archive_bw['s_peop_dtp']) && !empty($archive_bw['s_peop_dtp'])) ? $archive_bw['s_peop_dtp'] : 0);

            $sheet->setCellValue('C' . $r, $save_people_on_dtp);

            $r++;
            $save_child_on_dtp = ((isset($part_3_tbl_2['s_chi_dtp']) && !empty($part_3_tbl_2['s_chi_dtp'])) ? $part_3_tbl_2['s_chi_dtp'] : 0) +
                ((isset($archive_bw['s_chi_dtp']) && !empty($archive_bw['s_chi_dtp'])) ? $archive_bw['s_chi_dtp'] : 0);

            $sheet->setCellValue('C' . $r, $save_child_on_dtp);

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['d_dead_dtp']) && !empty($part_3_tbl_2['d_dead_dtp'])) ? $part_3_tbl_2['d_dead_dtp'] : 0) +
                ((isset($archive_bw['d_dead_dtp']) && !empty($archive_bw['d_dead_dtp'])) ? $archive_bw['d_dead_dtp'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_rigs_rb_3_water']) && !empty($part_3_tbl_2['cnt_rigs_rb_3_water'])) ? $part_3_tbl_2['cnt_rigs_rb_3_water'] : 0) +
                ((isset($archive_bw['cnt_rigs_rb_3_water']) && !empty($archive_bw['cnt_rigs_rb_3_water'])) ? $archive_bw['cnt_rigs_rb_3_water'] : 0)));

            $r++;
            $save_people_on_akva = ((isset($part_3_tbl_2['s_peop_water']) && !empty($part_3_tbl_2['s_peop_water'])) ? $part_3_tbl_2['s_peop_water'] : 0) +
                ((isset($archive_bw['s_peop_water']) && !empty($archive_bw['s_peop_water'])) ? $archive_bw['s_peop_water'] : 0);


            $sheet->setCellValue('C' . $r, $save_people_on_akva);

            $r++;

            $save_child_on_akva = ((isset($part_3_tbl_2['s_chi_water']) && !empty($part_3_tbl_2['s_chi_water'])) ? $part_3_tbl_2['s_chi_water'] : 0) +
                ((isset($archive_bw['s_chi_water']) && !empty($archive_bw['s_chi_water'])) ? $archive_bw['s_chi_water'] : 0);


            $sheet->setCellValue('C' . $r, $save_child_on_akva);

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['d_dead_water']) && !empty($part_3_tbl_2['d_dead_water'])) ? $part_3_tbl_2['d_dead_water'] : 0) +
                ((isset($archive_bw['d_dead_water']) && !empty($archive_bw['d_dead_water'])) ? $archive_bw['d_dead_water'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_ins_kill_free_charge']) && !empty($part_3_tbl_2['cnt_ins_kill_free_charge'])) ? $part_3_tbl_2['cnt_ins_kill_free_charge'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_free_charge']) && !empty($archive_bw['cnt_ins_kill_free_charge'])) ? $archive_bw['cnt_ins_kill_free_charge'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_ins_kill_free']) && !empty($part_3_tbl_2['cnt_ins_kill_free'])) ? $part_3_tbl_2['cnt_ins_kill_free'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_free']) && !empty($archive_bw['cnt_ins_kill_free'])) ? $archive_bw['cnt_ins_kill_free'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_ins_kill_free_threat']) && !empty($part_3_tbl_2['cnt_ins_kill_free_threat'])) ? $part_3_tbl_2['cnt_ins_kill_free_threat'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_free_threat']) && !empty($archive_bw['cnt_ins_kill_free_threat'])) ? $archive_bw['cnt_ins_kill_free_threat'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_ins_kill_free_before_school']) && !empty($part_3_tbl_2['cnt_ins_kill_free_before_school'])) ? $part_3_tbl_2['cnt_ins_kill_free_before_school'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_free_before_school']) && !empty($archive_bw['cnt_ins_kill_free_before_school'])) ? $archive_bw['cnt_ins_kill_free_before_school'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_ins_kill_free_school']) && !empty($part_3_tbl_2['cnt_ins_kill_free_school'])) ? $part_3_tbl_2['cnt_ins_kill_free_school'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_free_school']) && !empty($archive_bw['cnt_ins_kill_free_school'])) ? $archive_bw['cnt_ins_kill_free_school'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_ins_kill_charge']) && !empty($part_3_tbl_2['cnt_ins_kill_charge'])) ? $part_3_tbl_2['cnt_ins_kill_charge'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_charge']) && !empty($archive_bw['cnt_ins_kill_charge'])) ? $archive_bw['cnt_ins_kill_charge'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_ins_kill_charge_estate']) && !empty($part_3_tbl_2['cnt_ins_kill_charge_estate'])) ? $part_3_tbl_2['cnt_ins_kill_charge_estate'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_charge_estate']) && !empty($archive_bw['cnt_ins_kill_charge_estate'])) ? $archive_bw['cnt_ins_kill_charge_estate'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_ins_kill_charge_dog']) && !empty($part_3_tbl_2['cnt_ins_kill_charge_dog'])) ? $part_3_tbl_2['cnt_ins_kill_charge_dog'] : 0) +
                ((isset($archive_bw['cnt_ins_kill_charge_dog']) && !empty($archive_bw['cnt_ins_kill_charge_dog'])) ? $archive_bw['cnt_ins_kill_charge_dog'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_pavodok']) && !empty($part_3_tbl_1['cnt_pavodok'])) ? $part_3_tbl_1['cnt_pavodok'] : 0) +
                ((isset($archive_bw['cnt_pavodok']) && !empty($archive_bw['cnt_pavodok'])) ? $archive_bw['cnt_pavodok'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_sum']) && !empty($part_3_tbl_1['cnt_sum'])) ? $part_3_tbl_1['cnt_sum'] : 0) +
                ((isset($archive_bw['cnt_control']) && !empty($archive_bw['cnt_control'])) ? $archive_bw['cnt_control'] : 0) +
                ((isset($archive_bw['cnt_duty']) && !empty($archive_bw['cnt_duty'])) ? $archive_bw['cnt_duty'] : 0) +
                ((isset($archive_bw['cnt_hoz']) && !empty($archive_bw['cnt_hoz'])) ? $archive_bw['cnt_hoz'] : 0) +
                ((isset($archive_bw['cnt_zapravka']) && !empty($archive_bw['cnt_zapravka'])) ? $archive_bw['cnt_zapravka'] : 0) +
                ((isset($archive_bw['cnt_disloc']) && !empty($archive_bw['cnt_disloc'])) ? $archive_bw['cnt_disloc'] : 0) +
                ((isset($archive_bw['cnt_to']) && !empty($archive_bw['cnt_to'])) ? $archive_bw['cnt_to'] : 0) +
                ((isset($archive_bw['cnt_neighbor']) && !empty($archive_bw['cnt_neighbor'])) ? $archive_bw['cnt_neighbor'] : 0) +
                ((isset($archive_bw['cnt_ptv']) && !empty($archive_bw['cnt_ptv'])) ? $archive_bw['cnt_ptv'] : 0) +
                ((isset($archive_bw['cnt_pay']) && !empty($archive_bw['cnt_pay'])) ? $archive_bw['cnt_pay'] : 0) +
                ((isset($archive_bw['cnt_other']) && !empty($archive_bw['cnt_other'])) ? $archive_bw['cnt_other'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_control']) && !empty($part_3_tbl_1['cnt_control'])) ? $part_3_tbl_1['cnt_control'] : 0) +
                ((isset($archive_bw['cnt_control']) && !empty($archive_bw['cnt_control'])) ? $archive_bw['cnt_control'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_1['cnt_duty']) && !empty($part_3_tbl_1['cnt_duty'])) ? $part_3_tbl_1['cnt_duty'] : 0) +
                ((isset($archive_bw['cnt_duty']) && !empty($archive_bw['cnt_duty'])) ? $archive_bw['cnt_duty'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_hoz']) && !empty($part_3_tbl_1['cnt_hoz'])) ? $part_3_tbl_1['cnt_hoz'] : 0) +
                ((isset($archive_bw['cnt_hoz']) && !empty($archive_bw['cnt_hoz'])) ? $archive_bw['cnt_hoz'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_zapravka']) && !empty($part_3_tbl_1['cnt_zapravka'])) ? $part_3_tbl_1['cnt_zapravka'] : 0) +
                ((isset($archive_bw['cnt_zapravka']) && !empty($archive_bw['cnt_zapravka'])) ? $archive_bw['cnt_zapravka'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_disloc']) && !empty($part_3_tbl_1['cnt_disloc'])) ? $part_3_tbl_1['cnt_disloc'] : 0) +
                ((isset($archive_bw['cnt_disloc']) && !empty($archive_bw['cnt_disloc'])) ? $archive_bw['cnt_disloc'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_1['cnt_to']) && !empty($part_3_tbl_1['cnt_to'])) ? $part_3_tbl_1['cnt_to'] : 0) +
                ((isset($archive_bw['cnt_to']) && !empty($archive_bw['cnt_to'])) ? $archive_bw['cnt_to'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_1['cnt_neighbor']) && !empty($part_3_tbl_1['cnt_neighbor'])) ? $part_3_tbl_1['cnt_neighbor'] : 0) +
                ((isset($archive_bw['cnt_neighbor']) && !empty($archive_bw['cnt_neighbor'])) ? $archive_bw['cnt_neighbor'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_ptv']) && !empty($part_3_tbl_1['cnt_ptv'])) ? $part_3_tbl_1['cnt_ptv'] : 0) +
                ((isset($archive_bw['cnt_ptv']) && !empty($archive_bw['cnt_ptv'])) ? $archive_bw['cnt_ptv'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_pay']) && !empty($part_3_tbl_1['cnt_pay'])) ? $part_3_tbl_1['cnt_pay'] : 0) +
                ((isset($archive_bw['cnt_pay']) && !empty($archive_bw['cnt_pay'])) ? $archive_bw['cnt_pay'] : 0)));

            $r++;


            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_other']) && !empty($part_3_tbl_1['cnt_other'])) ? $part_3_tbl_1['cnt_other'] : 0) +
                ((isset($archive_bw['cnt_other']) && !empty($archive_bw['cnt_other'])) ? $archive_bw['cnt_other'] : 0)));


            $r++;

            $save_people_other_case = ((isset($part_3_tbl_2['cnt_s_people']) && !empty($part_3_tbl_2['cnt_s_people'])) ? $part_3_tbl_2['cnt_s_people'] : 0) +
                ((isset($archive_bw['cnt_s_people_grunt']) && !empty($archive_bw['cnt_s_people_grunt'])) ? $archive_bw['cnt_s_people_grunt'] : 0) +
                ((isset($archive_bw['cnt_s_people_kon']) && !empty($archive_bw['cnt_s_people_kon'])) ? $archive_bw['cnt_s_people_kon'] : 0) +
                ((isset($archive_bw['cnt_s_people_cons']) && !empty($archive_bw['cnt_s_people_cons'])) ? $archive_bw['cnt_s_people_cons'] : 0);

            $sheet->setCellValue('C' . $r, $save_people_other_case);

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_s_grunt']) && !empty($part_3_tbl_2['cnt_s_grunt'])) ? $part_3_tbl_2['cnt_s_grunt'] : 0) +
                ((isset($archive_bw['cnt_s_grunt']) && !empty($archive_bw['cnt_s_grunt'])) ? $archive_bw['cnt_s_grunt'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_s_people_grunt']) && !empty($part_3_tbl_2['cnt_s_people_grunt'])) ? $part_3_tbl_2['cnt_s_people_grunt'] : 0) +
                ((isset($archive_bw['cnt_s_people_grunt']) && !empty($archive_bw['cnt_s_people_grunt'])) ? $archive_bw['cnt_s_people_grunt'] : 0)));

            $r++;

            $save_child_on_grunt = ((isset($part_3_tbl_2['cnt_s_chi_grunt']) && !empty($part_3_tbl_2['cnt_s_chi_grunt'])) ? $part_3_tbl_2['cnt_s_chi_grunt'] : 0) +
                ((isset($archive_bw['cnt_s_chi_grunt']) && !empty($archive_bw['cnt_s_chi_grunt'])) ? $archive_bw['cnt_s_chi_grunt'] : 0);

            $sheet->setCellValue('C' . $r, $save_child_on_grunt);

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_s_kon']) && !empty($part_3_tbl_2['cnt_s_kon'])) ? $part_3_tbl_2['cnt_s_kon'] : 0) +
                ((isset($archive_bw['cnt_s_kon']) && !empty($archive_bw['cnt_s_kon'])) ? $archive_bw['cnt_s_kon'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_s_people_kon']) && !empty($part_3_tbl_2['cnt_s_people_kon'])) ? $part_3_tbl_2['cnt_s_people_kon'] : 0) +
                ((isset($archive_bw['cnt_s_people_kon']) && !empty($archive_bw['cnt_s_people_kon'])) ? $archive_bw['cnt_s_people_kon'] : 0)));

            $r++;

            $save_child_on_kon = ((isset($part_3_tbl_2['cnt_s_chi_kon']) && !empty($part_3_tbl_2['cnt_s_chi_kon'])) ? $part_3_tbl_2['cnt_s_chi_kon'] : 0) +
                ((isset($archive_bw['cnt_s_chi_kon']) && !empty($archive_bw['cnt_s_chi_kon'])) ? $archive_bw['cnt_s_chi_kon'] : 0);

            $sheet->setCellValue('C' . $r, $save_child_on_kon);

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_s_cons']) && !empty($part_3_tbl_2['cnt_s_cons'])) ? $part_3_tbl_2['cnt_s_cons'] : 0) +
                ((isset($archive_bw['cnt_s_cons']) && !empty($archive_bw['cnt_s_cons'])) ? $archive_bw['cnt_s_cons'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_s_people_cons']) && !empty($part_3_tbl_2['cnt_s_people_cons'])) ? $part_3_tbl_2['cnt_s_people_cons'] : 0) +
                ((isset($archive_bw['cnt_s_people_cons']) && !empty($archive_bw['cnt_s_people_cons'])) ? $archive_bw['cnt_s_people_cons'] : 0)));

            $r++;
            $save_child_on_cons = ((isset($part_3_tbl_2['cnt_s_chi_cons']) && !empty($part_3_tbl_2['cnt_s_chi_cons'])) ? $part_3_tbl_2['cnt_s_chi_cons'] : 0) +
                ((isset($archive_bw['cnt_s_chi_cons']) && !empty($archive_bw['cnt_s_chi_cons'])) ? $archive_bw['cnt_s_chi_cons'] : 0);

            $sheet->setCellValue('C' . $r, $save_child_on_cons);


            $r = $r + 2;
            $sheet->setCellValue('C' . $r, ($all_rigs_fire_part_1 + $all_rigs_hs_part_2 + $other_rigs_part_3));

            $r++;
            $sheet->setCellValue('C' . $r, ( $save_people_on_fire + $save_people_on_hs + $save_people_on_dtp + $save_people_on_akva + $save_people_other_case));

            $r++;
            $sheet->setCellValue('C' . $r, ( $save_child_on_fire + $save_child_on_hs + $save_child_on_dtp + $save_child_on_akva + $save_child_on_grunt +
                $save_child_on_kon + $save_child_on_cons));

            $r ++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['zan_sum']) && !empty($part_3_tbl_1['zan_sum'])) ? $part_3_tbl_1['zan_sum'] : 0) +
                ((isset($archive_bw['cnt_tsu']) && !empty($archive_bw['cnt_tsu'])) ? $archive_bw['cnt_tsu'] : 0) +
                ((isset($archive_bw['cnt_tsz']) && !empty($archive_bw['cnt_tsz'])) ? $archive_bw['cnt_tsz'] : 0) +
                ((isset($archive_bw['cnt_pasp']) && !empty($archive_bw['cnt_pasp'])) ? $archive_bw['cnt_pasp'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_tsu']) && !empty($part_3_tbl_1['cnt_tsu'])) ? $part_3_tbl_1['cnt_tsu'] : 0) +
                ((isset($archive_bw['cnt_tsu']) && !empty($archive_bw['cnt_tsu'])) ? $archive_bw['cnt_tsu'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_tsz']) && !empty($part_3_tbl_1['cnt_tsz'])) ? $part_3_tbl_1['cnt_tsz'] : 0) +
                ((isset($archive_bw['cnt_tsz']) && !empty($archive_bw['cnt_tsz'])) ? $archive_bw['cnt_tsz'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_night']) && !empty($part_3_tbl_1['cnt_night'])) ? $part_3_tbl_1['cnt_night'] : 0) +
                ((isset($archive_bw['cnt_night']) && !empty($archive_bw['cnt_night'])) ? $archive_bw['cnt_night'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_1['cnt_pasp']) && !empty($part_3_tbl_1['cnt_pasp'])) ? $part_3_tbl_1['cnt_pasp'] : 0) +
                ((isset($archive_bw['cnt_pasp']) && !empty($archive_bw['cnt_pasp'])) ? $archive_bw['cnt_pasp'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, (((isset($part_3_tbl_2['cnt_hero_in_out']) && !empty($part_3_tbl_2['cnt_hero_in_out'])) ? $part_3_tbl_2['cnt_hero_in_out'] : 0) +
                ((isset($archive_bw['cnt_hero_in_out']) && !empty($archive_bw['cnt_hero_in_out'])) ? $archive_bw['cnt_hero_in_out'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_hero_in']) && !empty($part_3_tbl_2['cnt_hero_in'])) ? $part_3_tbl_2['cnt_hero_in'] : 0) +
                ((isset($archive_bw['cnt_hero_in']) && !empty($archive_bw['cnt_hero_in'])) ? $archive_bw['cnt_hero_in'] : 0)));

            $r++;
            $sheet->setCellValue('C' . $r, ( ((isset($part_3_tbl_2['cnt_hero_out']) && !empty($part_3_tbl_2['cnt_hero_out'])) ? $part_3_tbl_2['cnt_hero_out'] : 0) +
                ((isset($archive_bw['cnt_hero_out']) && !empty($archive_bw['cnt_hero_out'])) ? $archive_bw['cnt_hero_out'] : 0)));

//            $styleArray = array(
//                'borders' => array(
//                    'allborders' => array(
//                        'style' => PHPExcel_Style_Border::BORDER_THIN
//                    )
//                )
//            );
//            $sheet->getStyleByColumnAndRow(0, 4, 3, $r)->applyFromArray($styleArray);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="отчет_сведения_о_ЧС_и_БР.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }

        /* ------------------------------------ END excel  --------------------------------- */ else {
            $app->render('layouts/header.php', $data);
            $data['path_to_view'] = 'report/rep4/result.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
    });




    /* bokk */
    $app->post('/bokk', function () use ($app, $log) {

        if (isset($_POST['year']) && !empty($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = '';
        }


        /* ------- Запрошенные область и район------ */
        $id_region = (isset($_POST['id_region']) && !empty($_POST['id_region'])) ? intval($_POST['id_region']) : 0; //куда был выезд
        $id_local = (isset($_POST['id_local']) && !empty($_POST['id_local'])) ? intval($_POST['id_local']) : 0; //куда был выезд

        if ($id_region != 0) {
            $region_m = new Model_Region();
            $region_name = $region_m->selectNameById($id_region);
        } else {
            $region_name = 'все';
        }


        if ($id_local != 0) {
            $local_m = new Model_Local();
            $local_name = $local_m->selectNameById($id_local);
        } else {
            $local_name = 'все';
        }


        if (isset($_POST['reasonrig']) && !empty($_POST['reasonrig'])) {
            $reasonrig_n = $_POST['reasonrig'];
        }


        if (isset($reasonrig_n) && !empty($reasonrig_n)) {
            $reas_list = R::getAll('select name from reasonrig where id IN(' . implode(',', $reasonrig_n) . ')');

            if (!empty($reas_list)) {
                foreach ($reas_list as $value) {
                    $reasonrig_name[] = $value['name'];
                }
            }
            $reasonrig_name = implode(', ', $reasonrig_name);
        } else {
            $reasonrig_name = 'все';
        }

        /* ------- КОНЕЦ Запрошенные область и район------ */

        /* from journal */
        $sql = 'SELECT i.`id_service`, r.`time_msg`,  r.`date_msg`, concat(r.`date_msg`," ",r.`time_msg`) as full_date_msg ,r.`address`,r.`additional_field_address`,
            r.`inf_detail`,r.`description`, r.`id_region`,r.`id_local`, r.`region_name`, r.`local_name`,r.`id_reasonrig`
            FROM innerservice AS i
            LEFT JOIN rigtable AS  r ON r.`id`=i.`id_rig` WHERE r.`date_msg`<= DATE_FORMAT(NOW(),"%Y-%m-%d") ';


        $sql = $sql . ' AND i.`id_service`= ?';
        $param[] = ID_BOKK;

        //$year = '2019';
        if (isset($year) && $year != '') {
            $sql = $sql . ' AND  DATE_FORMAT(r.`date_msg`,"%Y") = ?';
            $param[] = $year;
        }

        if (isset($id_region) && $id_region != 0) {
            $sql = $sql . ' AND r.id_region = ?';
            $param[] = $id_region;
        }
        if (isset($id_local) && $id_local != 0) {
            $sql = $sql . ' AND r.id_local = ?';
            $param[] = $id_local;
        }


        if (isset($reasonrig_n) && !empty($reasonrig_n)) {
            $sql = $sql . ' AND r.id_reasonrig IN(' . implode(',', $reasonrig_n) . ')';
            //$sql = $sql . ' AND r.id_reasonrig = ?';
            //$param[] = $reasonrig_n;
        }
        $result = R::getAll($sql, $param);

        /* from archive */
        $table_name = $year . 'a';
        $sql = '';
        $param = [];
        $sql = 'SELECT a.`innerservice`,a.`time_msg`,a.`date_msg`, concat(a.`date_msg`," ",a.`time_msg`) as full_date_msg ,a.`address`,a.`additional_field_address`,a.`inf_detail`,
      a.`description`,a.`id_region`,a.`id_local`, reg.name AS region_name,loc.name AS local_name, a.reasonrig_id as id_reasonrig
      FROM jarchive.' . $table_name . ' AS a
      LEFT JOIN jarchive.regions AS reg ON reg.id=a.id_region
      LEFT JOIN jarchive.locals AS loc ON loc.id=a.id_local WHERE DATE_FORMAT(a.`date_msg`,"%Y") = ? ';

        $param[] = $year;

        $sql = $sql . ' AND a.`is_bokk`= ?';
        $param[] = 1;


        if (isset($id_region) && $id_region != 0) {
            $sql = $sql . ' AND a.id_region = ?';
            $param[] = $id_region;
        }
        if (isset($id_local) && $id_local != 0) {
            $sql = $sql . ' AND a.id_local = ?';
            $param[] = $id_local;
        }


        if (isset($reasonrig_n) && !empty($reasonrig_n)) {
            $sql = $sql . ' AND a.reasonrig_id IN(' . implode(',', $reasonrig_n) . ')';
            //$sql = $sql . ' AND a.reasonrig_id = ?';
            //$param[] = $reasonrig_n;
        }
        $archive = R::getAll($sql, $param);

        $result = array_merge($result, $archive);

        /* sort */

        function cmp($a, $b)
        {
            return strcmp($a["full_date_msg"], $b["full_date_msg"]);
        }
        if (!empty($result))
            usort($result, "cmp");



        if (empty($result)) {//нет вызовов
            // $app->redirect(BASE_URL . '/error');
            $arr[] = 'Нет данных для отображения!';
            show_error($arr, 'report/rep1');
            exit();
        }

        /* ---------------------------------------------------- ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/report/bokk.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //начальная строка для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'за ' . $year . ' год'); //выбранный период



        $sheet->setCellValue('A3', 'область: ' . $region_name . ', район: ' . $local_name . ', причина вызова: ' . $reasonrig_name); //выбранный область и район

        foreach ($result as $row) {
            $i++;


            /* ------------------- данные по вызову -------------------------- */
            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('C' . $r, date('H:i', strtotime($row['time_msg'])));

            $sheet->setCellValue('D' . $r, $row['inf_detail']);


            $adr = ($row['address'] == NULL ) ? $row['additional_field_address'] : $row['address'];  /*   <!--                            если адрес пуст-выводим дополнит поле с адресом--> */
            $adr_region = ($row['id_region'] == 3 && $row['id_local'] == 123 ) ? '' : ( ($row['id_region'] == 3) ? $row['region_name'] . ', ' : $row['region_name'] . ' обл., ');
            $local_arr = array(21, 22, 123, 124, 135, 136, 137, 138, 139, 140, 141); //id_local городов - им не надо слово район
            $adr_local = (in_array($row['id_local'], $local_arr) || empty($row['id_local'])) ? '' : $row['local_name'] . ' район., ';
            $sheet->setCellValue('E' . $r, $adr_region . $adr_local . $adr);

            /* ------------------- КОНЕЦ данные по вызову -------------------------- */
            $r++;
        }

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $sheet->getStyleByColumnAndRow(0, 8, 4, $r - 1)->applyFromArray($styleArray);

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="bokk.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        /* ---------------------------------------------------- END ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
    });
});

/* ------------------------- END report ------------------------------- */

/* ------------------ сообщение об ошибке -------------------------- */
$app->get('/error', function () use ($app) {
    $app->render('layouts/header.php');
    $data['path_to_view'] = 'error.php';
    $app->render('layouts/div_wrapper.php', $data);
    $app->render('layouts/footer.php');
});
/* ------------------ КОНЕЦ сообщение об ошибке -------------------------- */

/* ------------- Формирование классификаторов административно-терр деления --------------- */
$app->post('/select', function () use ($app) {
    switch ($_POST['action']) {

        /* ----------------- список районов по области ------------------ */
        case "showLocalByRegion":
            $locals = new Model_local();
            $rows = $locals->selectAllByRegion($_POST['id_region']);
            echo '<option value="" >Все</option>';
            foreach ($rows as $row) {
                if ($row['id'] != 123) {// кроме г.Минск
                    if (isset($_POST['selected_local']) && $_POST['selected_local'] == $row['id']) {//НА ФОРМЕ РЕД ВЫБРАНО ПО УМОЛЧАНИЮ
                        echo '<option selected     value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                    } else {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                }
            }
            break;

        /* ----------------- список нас.п. по району ------------------ */
        case "showLocalityByLocal":

            $id_loc = ($_POST['id_local'] < 0) ? 123 : $_POST['id_local'];

            $locality_m = new Model_Locality();
            $rows = $locality_m->selectAllByLocal($id_loc);
            // $rows = R::getAll('SELECT * FROM journal.locality WHERE id_local = ? ORDER BY name ASC', array($_POST['id_local']));
            echo '<option value="">Все</option>';
            foreach ($rows as $row) {
                if ($row['is_city'] == 1) {//г.областного подчинения выбирать автоматом
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" selected value="' . $row['id'] . '">' . $row['name'] . '</option>';
                } else {
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
            break;
        /* ------------- список нас.п. по области -------------- */
        case "showLocalityByRegion":
            $locality_m = new Model_Locality();
            $rows = $locality_m->selectAllByRegion($_POST['id_region']);
            // $rows = R::getAll('SELECT * FROM journal.locality WHERE id_region = ? ORDER BY name ASC', array($_POST['id_region']));
            echo '<option value=""  >Все</option>';
            foreach ($rows as $row) {
                if (isset($_POST['selected_locality']) && $_POST['selected_locality'] == $row['id'] || $_POST['id_region'] == 3) {//НА ФОРМЕ РЕД ВЫБРАНО ПО УМОЛЧАНИЮ
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" selected value="' . $row['id'] . '">' . $row['name'] . '</option>';
                } else {
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '"  value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
            break;

        /* ------------- авт выбор района по нас.п. -------------- */
        case "showLocalByLocality":
            //$locals = R::getAll('SELECT * FROM ss.locals WHERE id_region=? ORDER BY name ASC', array($_POST['id_region']));
            $local = new Model_Local();
            $locals = $local->selectAllByRegion($_POST['id_region']);

            $locality_m = new Model_Locality();
            $local_of_locality = $locality_m->selectIdLocalByLocality($_POST['id_locality']);
            //$local_of_locality = R::getCell('SELECT id_local FROM journal.locality  WHERE id=? ', array($_POST['id_locality']));
            //город, который не имеет района-г.Гродно- у него свои внутренние районы

            echo '<option value="">Все</option>';
            if (empty($local_of_locality)) {
                echo '<option value="">нет района</option>';
                foreach ($locals as $row) {
                    echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                }
            } else {
                foreach ($locals as $row) {
                    if ($row['id'] == $local_of_locality && $local_of_locality != 123) {
                        echo '<option selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                    } elseif ($row['id'] != 123) {
                        echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                    }
                }
            }

            break;

        /* ------------- оставить нас.п. только того района, который установился автоматически после выбора нас.п.-------------- */
        case "showLocalityByActiveLocal":

            $locality_m = new Model_Locality();
            $local_of_locality = $locality_m->selectIdLocalByLocality($_POST['id_locality']); // id района, которому принадлежит нас.п.
            //$local_of_locality = R::getCell('SELECT id_local FROM journal.locality  WHERE id=? ', array($_POST['id_locality']));// id района, которому принадлежит нас.п.
            $locality = $locality_m->selectAllByLocal($local_of_locality); //все нас.п. по id района

            echo '<option value="">Все</option>';
            foreach ($locality as $row) {
                if ($row['id'] == $_POST['id_locality']) {
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                } else {
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                }
            }
            break;

        /* ----------------- список сельсоветов по району ------------------ */
        case "showSelsovetByLocal":
            // $rows = R::getAll('SELECT * FROM journal.locality WHERE id_local = ? ORDER BY name ASC', array($_POST['id_local']));
            $selsovet_m = new Model_Selsovet();
            $rows = $selsovet_m->selectAllByLocal($_POST['id_local']);

            echo '<option value="">Все</option>';
            foreach ($rows as $row) {
                if (isset($_POST['selected_selsovet']) && $_POST['selected_selsovet'] == $row['id']) {//НА ФОРМЕ РЕД ВЫБРАНО ПО УМОЛЧАНИЮ
                    echo '<option selected value="' . $row['id'] . '">' . $row['name'] . '</option>';
                } else {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
            break;

        /* ------------- авт выбор сельсовета по нас.п. -------------- */
        case "showSelsovetByLocality":

            $locality_m = new Model_Locality();
            $selsovet_of_locality = $locality_m->selectIdSelsovet($_POST['id_locality']); //id сельсовета выбранного нас.пункта

            $id_local = $locality_m->selectIdLocalByLocality($_POST['id_locality']); //id района выбранного нас.пункта
            $selsovet_m = new Model_Selsovet();
            $selsovet = $selsovet_m->selectAllByLocal($id_local); //все сельсоветы района
            echo '<option value="">Все</option>';
            foreach ($selsovet as $row) {
                if (($row['id'] == $selsovet_of_locality) && $selsovet_of_locality != 0) {
                    echo '<option selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                } else {
                    echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                }
            }
            //echo '<option value="">Все</option>';
            break;

        /* ------------- список нас.п. по сельсовету -------------- */
        case "showLocalityBySelsovet":
            echo '<option value="">Все</option>';
            $locality_m = new Model_Locality();
            $locality = $locality_m->selectAllBySelsovet($_POST['id_selsovet']); //все нас.п. по выбранному с/с

            foreach ($locality as $row) {
                echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" value="' . $row['id'] . '" >' . $row['name'] . '</option>';
            }

            break;

        /* ------------- список нас.п. по сельсовету -------------- */
        case "showStreetByLocality":
            echo '<option value="">Все</option>';
            $street_m = new Model_Street();
            $street = $street_m->selectAllByLocality($_POST['id_locality']); //все улицы по нас.п.

            foreach ($street as $row) {
                if (isset($_POST['selected_street']) && $_POST['selected_street'] == $row['id']) {//улица выбрана по умолч-на форме редактирования
                    echo '<option selected value="' . $row['id'] . $row['name'] . ' (' . $row['vid_name'] . ')' . '</option>';
                } else {
                    echo '<option value="' . $row['id'] . '" >' . $row['name'] . ' (' . $row['vid_name'] . ')' . '</option>';
                }
            }
            break;


        /* ------------- список техники по выбранному ПАСЧ -------------- */
        case "showTehByPasp":
            $list_teh = array();

            /* cou or pasp */

            $id_divizion = R::getCell('select id_divizion FROM ss.records WHERE id = ?', array($_POST['id_pasp']));

            /* cou or pasp */

            /* -------------- technics - trip + from other divizion ---------------- */

            $today = date("Y-m-d"); //выбор техники из строевой на сегодняшн.сутки
            $yesterday = date("Y-m-d", time() - (60 * 60 * 24));
            //$today = '2018-03-28';

            if ($id_divizion != 8) {
                /* pasp. take or not on duty */
                $is_duty = R::getCell('SELECT id FROM str.main WHERE id_card = ? AND dateduty = ? AND is_duty = ? ', array($_POST['id_pasp'], $today, 1));
            } else {
                /* cou. take or not on duty today */
                $is_duty = R::getCell('SELECT id FROM str.maincou WHERE id_card = ? AND dateduty = ? AND is_duty = ? ', array($_POST['id_pasp'], $today, 1));
            }


            if (empty($is_duty)) {// today is not taken on duty
                if ($id_divizion != 8) {
                    /* pasp. take or not on duty yesterday */
                    $is_duty = R::getCell('SELECT id FROM str.main WHERE id_card = ? AND dateduty = ? AND is_duty = ? ', array($_POST['id_pasp'], $yesterday, 1)); //Заступила ли ПАСЧ на дежурство вчера
                } else {
                    /* cou. take or not on duty yesterday */
                    $is_duty = R::getCell('SELECT id FROM str.maincou WHERE id_card = ? AND dateduty = ? AND is_duty = ? ', array($_POST['id_pasp'], $yesterday, 1));
                }



                if (empty($is_duty)) {
                    $list_teh = array(); //list of technics is empty
                } else {
                    $dateduty = $yesterday;
                }
            } else {// today is taken on duty
                $dateduty = $today;
            }
            //$dateduty='2018-10-27';
            if (isset($dateduty)) {
                $list_teh = R::getAssoc("CALL `getListTeh`('{$_POST['id_pasp']}','{$dateduty}');");
            } else {
                $list_teh = array();
            }

            /* -------------- END technics - trip + from other divizion ---------------- */

            /* ------------- техника данного ПАСЧ на выезде - пометить как (В) -------------------- */
            $teh_on_rig_m = new Model_Silymchs();
            $teh_on_rig = $teh_on_rig_m->selectAllOnRig();

            if (!empty($teh_on_rig)) {
                foreach ($teh_on_rig as $value) {
                    $on_rig[] = $value['id_teh'];
                }
            } else {
                $on_rig = array();
            }
            /* ------------- END техника данного ПАСЧ на выезде - пометить как (В) -------------------- */

            /* ----------------- техника из др ПАСЧ - пометить как (К) ----------------- */
            $on_reserve = array();
            if (isset($dateduty)) {
                $on_reserve = R::getAssoc("CALL `getReserveTeh`('{$_POST['id_pasp']}','{$dateduty}');");
            }

            /* ----------------- END техника из др ПАСЧ - пометить как (К) ----------------- */
            /* &#155; - on rig;  */
            /* 			if (!empty($list_teh)) {
              foreach ($list_teh as $row) {
              if (!empty($on_rig) && in_array($row['id_teh'], $on_rig)) {
              if (!empty($on_reserve) && in_array($row['id_teh'], $on_reserve)) {
              echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br']. ' (К) &#155;</option>';
              } else
              echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br']. ' &#155; </option>';
              }
              elseif (!empty($on_reserve) && in_array($row['id_teh'], $on_reserve)) {
              echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br'] . ' (К) </option>';
              } else {
              echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br'] . '</option>';
              }
              }
              } */

            if (!empty($list_teh)) {
                foreach ($list_teh as $row) {
                    if (!empty($on_rig) && in_array($row['id_teh'], $on_rig)) {
                        if (!empty($on_reserve) && in_array($row['id_teh'], $on_reserve)) {
                            if (trim($row['is_br']) == '(ТО)')
                                echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . ' (К) &#155;</option>';
                            else
                                echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br'] . ' (К) &#155;</option>';
                        } else {

                            if (trim($row['is_br']) == '(ТО)')
                                echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . ' &#155; </option>';
                            else
                                echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br'] . ' &#155; </option>';
                        }
                    }
                    elseif (!empty($on_reserve) && in_array($row['id_teh'], $on_reserve)) {

                        if (trim($row['is_br']) == '(ТО)')
                            echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . ' (К) </option>';
                        else
                            echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br'] . ' (К) </option>';
                    } else {
                        if (trim($row['is_br']) == '(ТО)')
                            echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . '</option>';
                        else
                            echo '<option value="' . $row['id_teh'] . '" >' . $row['mark'] . ': ' . $row['numbsign'] . $row['is_br'] . '</option>';
                    }
                }
            }
            break;


        /* ------------- авт отображение вида нас.пункта по нас.п. -------------- */
        case "showVidLocality":

            $locality_m = new Model_Locality();
            $vid = $locality_m->selectVidByIdLocality($_POST['id_locality']);

            if (!empty($vid)) {

                foreach ($vid as $row) {
                    echo $row['name'];
                }
            }

            break;


        /* ------------- функция формирует список вида работ в зависимости от выбранной причины выезда-------------- */
        case "showWorkviewByReasonrig":


            if ($_POST['id_reasonrig'] == 0) {//не выбрано причина выезда - доступны все виды работ
                $workview_m = new Model_Workview();
                $workview = $workview_m->selectAll();
            } else {//доступны только виды работ выбранной причины
                $workview_m = new Model_Workview();
                $workview = $workview_m->selectByReasonrig($_POST['id_reasonrig']);

                echo '<option value="0">не выбрано</option>';
            }

            foreach ($workview as $row) {
                if ($_POST['id_reasonrig'] == 0 && $row['id'] == 0) {//не выбрано
                    echo '<option selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                } else
                    echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
            }
            break;


        /* ------------- определяет автоматически причину выезда выбранного вида работ ------------- */
        case "showReasonrigByWorkview":


            $workview_m = new Model_Workview();
            $id_reasonrig = $workview_m->selectIdReasonrig($_POST['id_workview']); //определяем причину выезда, к которой относится выбранный вид работ

            $reasonrig_m = new Model_Reasonrig();
            $reasonrig = $reasonrig_m->selectAll(0); //все причины

            if (!isset($_POST['id_workview']))
                echo '<option value="0">не выбрано</option>';

            foreach ($reasonrig as $row) {
                if ($row['id'] == $id_reasonrig) {
                    echo '<option selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                } else {
                    echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                }
            }
            break;


        /* select lang, lat for reason rig = zanyatia */
        case "showAddrPasp":


            $id_pasp = $_POST['pasp_id'];
            $data['pasp_id_from_guide'] = $id_pasp;
            // echo $id_pasp;

            $coord = R::getRow('select id,pasp_name, locorg_name, latitude, longitude from pasp where id = ? ', array($id_pasp));
            $address = R::getRow('select * from guidepasp where id_pasp = ? ', array($id_pasp));
            // echo $coord['latitude'];

            $length_lat = strlen($coord['latitude']);
            $razn_lat = 9 - $length_lat;
            if ($razn_lat > 0) {
                $lat = str_pad($coord['latitude'], 9, 0);
            } else {
                $lat = $coord['latitude'];
            }

            $length_lon = strlen($coord['longitude']);
            $razn_lon = 9 - $length_lon;
            if ($razn_lon > 0) {
                $lon = str_pad($coord['longitude'], 9, 0);
            } else {
                $lon = $coord['longitude'];
            }


//                            echo json_encode([
//                'innerHtml' => $this->twig->render('student/profile/tabs/profile/process_study_chart', ['data' => $this->data], true),
//                'innerHtml2' => $this->twig->render('student/profile/tabs/profile/how_go_chart', ['data' => $this->data], true),
//                'innerHtml3' => $this->twig->render('student/profile/tabs/profile/line_intensivnost_study', ['data' => $this->data], true)
//            ]);

            $data['result'] = array("latitude"    => $lat,
                "longitude"   => $lon,
                "id_region"   => $address['id_region'],
                "id_local"    => $address['id_local'],
                "id_locality" => $address['id_locality'],
                "id_selsovet" => $address['id_selsovet'],
                "id_street"   => $address['id_street'],
                "home_number" => $address['home_number'],
                "housing"     => $address['housing']);


            /* ------------------ address of pasp from guide pasp ------------------- */

            $region = new Model_Region();
            $data['region'] = $region->selectAll(); //области
            $local = new Model_Local();
            $locality = new Model_Locality();
            $street = new Model_Street();
            $selsovet = new Model_Selsovet();

            $data['local'] = $local->selectAllByRegion($address['id_region']); //locals

            if ($address['id_local'] != 0) {

                $id_loc = ($address['id_local'] < 0) ? 123 : $address['id_local'];

                $data['selsovet'] = $selsovet->selectAllByLocal($id_loc); //сельсоветы для района редактируемого вызова
                $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района
            } elseif ($address['id_region'] != 0) {
                $data['locality'] = $locality->selectAllByRegion($address['id_region']); //нас.пункты области
            }

            if ($address['id_locality'] != 0) {
                $data['street'] = $street->selectAllByLocality($address['id_locality']); //улицы
            }

            /* ------------------ END address of pasp from guide pasp ------------------- */

            if ($_POST['sign'] == 'street') {
                $view = $app->render('guide_pasp/street_block.php', $data);
                $response = json_encode(['success' => TRUE, 'view' => $view]);
            } elseif ($_POST['sign'] == 'address') {
                $view = $app->render('guide_pasp/address_block.php', $data);
                $response = json_encode(['success' => TRUE, 'view' => $view]);
            } else {
                echo json_encode([
                    "latitude"    => $lat,
                    "longitude"   => $lon,
                    "id_region"   => $address['id_region'],
                    "id_local"    => $address['id_local'],
                    "id_locality" => $address['id_locality'],
                    "id_selsovet" => $address['id_selsovet'],
                    "id_street"   => $address['id_street'],
                    "home_number" => $address['home_number'],
                    "housing"     => $address['housing']
                ]);
            }
            break;


        /* ----------------- pasp by local ------------------ */
        case "showPaspByLocalForRep1":
            //$id_region = $app->request()->post('id_region');
            $id_local = $app->request()->post('id_local');

            if (isset($id_local) && !empty($id_local)) {
                $sql = 'select * from journal.pasp as p where ';
                $sql = $sql . ' p.id_local = ' . $id_local;
            }
            $podr = R::getAll($sql);


            if (empty($podr)) {
                $id_local_new = R::getCell('select id_local_ss from journal.locals_accordance where id_local_journal = ?', array($id_local));
                if (!empty($id_local_new)) {
                    $sql = 'select * from journal.pasp as p where ';
                    $sql = $sql . ' p.id_local = ' . $id_local_new;
                    $podr = R::getAll($sql);
                }
            }



            if (empty($podr))
                $res1['error'] = 'Нет данных для отображения';



            $data['pasp'] = json_encode($podr);


            echo $data['pasp'];


            break;
    }
});
/* ------------- КОНЕЦ Формирование классификаторов административно-терр деления --------------- */


/* ------------- Кол-во выездов отображать в левом меню --------------- */
$app->post('/show/count', function () use ($app) {
    switch ($_POST['action']) {

        case "showCountRigs":

            $rig_m = new Model_Rigtable();

            if (isset($_SESSION['id_level'])) {
                if ($_SESSION['id_level'] == 3) {//по ГРОЧС
                    $row = $rig_m->selectCountByIdLocorg($_SESSION['id_locorg'], 0);
                } elseif ($_SESSION['id_level'] == 2) {//по области
                    if ($_SESSION['sub'] == 2) {//ЦП
                        $row = $rig_m->selectCountByIdOrgan($_SESSION['id_organ'], 0); //ЦП
                    } else {
                        $row = $rig_m->selectCountByIdRegion($_SESSION['id_region'], 1, 0); //ЦП+УМЧС
                    }
                } else {//по РБ
                    $row = $rig_m->selectCountByRb(0);
                }
            } else {//по РБ
                $row = $rig_m->selectCountByRb(0);
            }
            echo $row;
            break;
    }
});
/* ------------- КОНЕЦ Кол-во выездов отображать в левом меню --------------- */



/* --------------- Путевка ---------------------- */

$app->group('/waybill', 'is_login', 'is_permis', function () use ($app) {

    //данные для путевки из БД
    /*  function getData($id_rig) {

      //данные по выезду
      $rig_table = new Model_Rigtable();
      $rig = $rig_table->getRigById($id_rig);

      //данные по заявителю
      $people_m = new Model_People();
      $people = $people_m->selectAllByIdRig($id_rig);



      if (empty($rig)) {//нет вызова
      $arr[] = 'Нет данных для отображения!';
      show_error($arr);
      exit();
      }


      foreach ($rig as $row) {

      //адрес
      if (empty($row['address']))
      $address = $row['additional_field_address'];
      else
      $address = $row['address'];

      //объект, если указан
      if(!empty($row['object']))
      $object=' ('.$row['object'].')';
      else
      $object='';


      $purpose = $row['inf_detail']; //цель выезда


      $for_hour = new DateTime($row['time_msg']);
      $hour = $for_hour->Format('H'); //время - часы
      $minutes = $for_hour->Format('i'); //время - минуты

      // дата выезда
      $for_day = new DateTime($row['date_msg']);
      $day = $for_day->Format('d');
      $month = $for_day->Format('m');
      $year = $for_day->Format('Y');
      $dd = substr($day, 0, 1); //первая цифра дня
      if ($dd == 0)//если 03 января, то выводить 3 января
      $day = substr($day, 1, 1);

      switch ($month) {
      case '01': $name_month = 'января';
      break;
      case '02': $name_month = 'февраля';
      break;
      case '03': $name_month = 'марта';
      break;
      case '04': $name_month = 'апреля';
      break;
      case '05': $name_month = 'мая';
      break;
      case '06': $name_month = 'июня';
      break;
      case '07': $name_month = 'июля';
      break;
      case '08': $name_month = 'августа';
      break;
      case '09': $name_month = 'сентября';
      break;
      case '10': $name_month = 'октября';
      break;
      case '11': $name_month = 'ноября';
      break;
      case '12': $name_month = 'декабря';
      break;

      default: $name_month = '';
      break;
      }
      }

      //данные по заявителю
      if (!empty($people)) {

      $data_people = '';

      if (!empty($people['fio']))
      $data_people = $data_people . $people['fio'];


      if (!empty($people['phone'])) {
      if (!empty($data_people))
      $data_people = $data_people . ', ';

      $data_people = $data_people . $people['phone'];
      }

      if (!empty($people['address'])) {
      if (!empty($data_people))
      $data_people = $data_people . ', ';

      $data_people = $data_people . $people['address'];
      }

      if (!empty($people['position'])) {
      if (!empty($data_people))
      $data_people = $data_people . ', ';

      $data_people = $data_people . $people['position'];
      }

      // echo $data_people;
      }
      $array=array('address'=>$address, 'object'=>$object, 'purpose'=>$purpose,'hour'=>$hour,'minutes'=>$minutes,'day'=>$day,'name_month'=>$name_month,'year'=>$year,'data_people'=>$data_people);
      return $array;
      } */




    function getData($id_rig)
    {

        //данные по выезду
        $rig_table = new Model_Rigtable();
        $rig = $rig_table->getRigById($id_rig);

        //данные по заявителю
        $people_m = new Model_People();
        $people = $people_m->selectAllByIdRig($id_rig);

        /* action od waybill by reasonrig */
        $way = new Model_Actionwaybill();
        $action = $way->selectAllByIdRig($id_rig);



        if (empty($rig)) {//нет вызова
            $arr[] = 'Нет данных для отображения!';
            show_error($arr);
            exit();
        }


        foreach ($rig as $row) {

            //адрес
            if (empty($row['address']))
                $address = $row['additional_field_address'];
            else
                $address = $row['address'];

            //объект, если указан
            if (!empty($row['object']))
                $object = ' (' . $row['object'] . ')';
            else
                $object = '';


            $purpose = $row['inf_detail']; //цель выезда

            $reasonrig_name = $row['reasonrig_name'];
            $view_work = $row['view_work'];
            $reasonrig_id = $row['id_reasonrig'];
            $work_id = $row['view_work_id'];


            $for_hour = new DateTime($row['time_msg']);
            $hour = $for_hour->Format('H'); //время - часы
            $minutes = $for_hour->Format('i'); //время - минуты
            // дата выезда
            $for_day = new DateTime($row['date_msg']);
            $day = $for_day->Format('d');
            $month = $for_day->Format('m');
            $year = $for_day->Format('Y');
            $dd = substr($day, 0, 1); //первая цифра дня
            if ($dd == 0)//если 03 января, то выводить 3 января
                $day = substr($day, 1, 1);

            switch ($month) {
                case '01': $name_month = 'января';
                    break;
                case '02': $name_month = 'февраля';
                    break;
                case '03': $name_month = 'марта';
                    break;
                case '04': $name_month = 'апреля';
                    break;
                case '05': $name_month = 'мая';
                    break;
                case '06': $name_month = 'июня';
                    break;
                case '07': $name_month = 'июля';
                    break;
                case '08': $name_month = 'августа';
                    break;
                case '09': $name_month = 'сентября';
                    break;
                case '10': $name_month = 'октября';
                    break;
                case '11': $name_month = 'ноября';
                    break;
                case '12': $name_month = 'декабря';
                    break;

                default: $name_month = '';
                    break;
            }
        }

        //данные по заявителю
        if (!empty($people)) {

            $data_people = '';

            if (!empty($people['fio']))
                $data_people = $data_people . $people['fio'];


            if (!empty($people['phone'])) {
                if (!empty($data_people))
                    $data_people = $data_people . ', ';

                $data_people = $data_people . $people['phone'];
            }

            if (!empty($people['address'])) {
                if (!empty($data_people))
                    $data_people = $data_people . ', ';

                $data_people = $data_people . $people['address'];
            }

            if (!empty($people['position'])) {
                if (!empty($data_people))
                    $data_people = $data_people . ', ';

                $data_people = $data_people . $people['position'];
            }

            // echo $data_people;
        }
        // $array=array('address'=>$address, 'object'=>$object, 'purpose'=>$purpose,'hour'=>$hour,'minutes'=>$minutes,'day'=>$day,'name_month'=>$name_month,'year'=>$year,'data_people'=>$data_people,'action'=>$action);
        $array = array('address'        => $address, 'object'         => $object, 'purpose'        => $purpose, 'hour'           => $hour, 'minutes'        => $minutes, 'day'            => $day,
            'name_month'     => $name_month, 'year'           => $year, 'data_people'    => $data_people, 'action'         => $action, 'reasonrig_name' => $reasonrig_name,
            'work_view'      => $view_work, 'work_id'        => $work_id, 'reasonrig_id'   => $reasonrig_id);
        return $array;
    }
    /* mail - форма рассылки
     * ok=0 default
     * ok=1 success send
     * ok=2 send with error */
    $app->get('/mail/:id_rig(/:ok)', function ($id_rig, $ok = 0) use ($app) {


        //ПАСЧ, откуда высылали технику, туда отправить путевку
        $sily_m = new Model_Silymchs();
        $id_pasp_on_rig = $sily_m->getIdPasp($id_rig, $is_delete = 0);

        $id_pasp_on_rig_array = array(); //id_pasp

        foreach ($id_pasp_on_rig as $value) {
            $id_pasp_on_rig_array[] = $value['id_pasp'];
        }
        if (!empty($id_pasp_on_rig_array))
            $id_pasp_on_rig_array = array_unique($id_pasp_on_rig_array);

        $data['id_pasp_on_rig_array'] = $id_pasp_on_rig_array;

        //имена этих ПАСЧ
        $pasp_m = new Model_Pasp();
        $pasp_name = $pasp_m->selectPaspName($id_pasp_on_rig_array);

        $data['pasp_name'] = $pasp_name;

        //Email этих ПАСЧ
        $list_mail = array();
        if (!empty($id_pasp_on_rig_array)) {
            // print_r($id_pasp_on_rig_array);
            $list_mail_m = new Model_Listmail();
            $list_mail = $list_mail_m->getMail($id_pasp_on_rig_array);
        }

        $list_mail_array = array();

        if (!empty($list_mail)) {
            foreach ($list_mail as $value) {
                $list_mail_array[$value['id_pasp']]['mail'] = $value['mail'];
                $list_mail_array[$value['id_pasp']]['is_delete'] = $value['is_delete'];
            }
        }

        $data['list_mail_array'] = $list_mail_array;

        //Кому ранее отсылали путевку по этому выезду
        $mail_send_m = new Model_Mailsend();
        $mail_send = $mail_send_m->getAll($id_rig);

        $mail_send_array = array();

        if (!empty($mail_send)) {
            foreach ($mail_send as $value) {
                $mail_send_array[$value['id_pasp']]['id_rig'] = $value['id_rig'];
                $mail_send_array[$value['id_pasp']]['date_send'] = $value['date_send'];
            }
        }

        $data['mail_send_array'] = $mail_send_array;


        $data['title'] = 'Отправка путевки на почту';

        $bread_crumb = array('Путевка на выезд № ' . $id_rig, 'Отправить на почту');
        $data['bread_crumb'] = $bread_crumb;

        $data['id_rig'] = $id_rig;
        $app->render('layouts/header.php', $data);

        $data['ok'] = $ok;

        $data['path_to_view'] = 'waybill/mail/form.php';

        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    // mail - отправка путевки на почту
    $app->post('/mail/:id_rig', function ($id_rig) use ($app) {


        if (!empty($_POST['id_pasp'])) {//есть куда отправить
            $id_pasp = array();
            foreach ($_POST['id_pasp'] as $key => $value) {
                $id_pasp[] = $key;
            }

            //Email этих ПАСЧ
            $list_mail = array();
            $list_mail_m = new Model_Listmail();
            $list_mail = $list_mail_m->getMail($id_pasp);


            //сохранить инф о том, кому и когда отсылается путевка
            $mail_send_m = new Model_Mailsend();
            $is_save = $mail_send_m->save($id_rig, $id_pasp);


            if ($is_save == TRUE)
                $app->redirect(BASE_URL . '/waybill/mail/' . $id_rig . '/1'); //совершена отправка
            else
                $app->redirect(BASE_URL . '/waybill/mail/' . $id_rig . '/2'); //совершена отправка c ошибкой
        }
        else {//не выбрано на форме ни одной ПАСЧ для отправки письма
            $app->redirect(BASE_URL . '/waybill/mail/' . $id_rig); //ничего не изменилось
        }


        /* ---------------------------------------------------- ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

        $array = getData($id_rig); //данные для путевки из БД

        $pdf = new tFPDF();
        $pdf->AddPage();

// Add a Unicode font (uses UTF-8)
        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont('DejaVub', '', 'DejaVuSansCondensed-Bold.ttf', true);
        $pdf->SetFont('DejaVub', '', 14);
//$pdf->SetFont('Times','',14);
// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');

        $pdf->Cell(0, 8, 'ПУТЕВКА № ' . $id_rig, 0, 1, 'C', false);
        $pdf->Cell(0, 5, 'для выезда дежурной смены подразделения', 0, 1, 'C', false);

        $pdf->Ln(10); //отступ после заголовка

        /* 1.Адрес  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '1.Адрес      ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['address'] . $array['object']);

        $pdf->Ln(10); //отступ после заголовка

        /* 2.Цель выезда  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '2.Цель выезда      ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['purpose']);

        $pdf->Ln(10); //отступ после заголовка

        /* Время и дата получения сообщения */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '3.Время и дата получения сообщения     ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['hour']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  часов  ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['minutes']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  минут(ы)');

        $pdf->Ln(10); //отступ после строки
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '«' . $array['day'] . '»');
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  ' . $array['name_month']);
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '  ' . $array['year']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  г.');

        $pdf->Ln(10); //отступ после строки

        /* 4. Данные о заявителе  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '4. Данные о заявителе     ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['data_people']);


        $pdf->Ln(10); //отступ после строки


        /* Подпись дежурного диспетчера */

        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, 'Подпись дежурного диспетчера   ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '                                            ');


        $f_pdf = mt_rand() . '_tmp.pdf';
        $pdf->Output(__DIR__ . '/temp/' . $f_pdf, 'F'); //сохранить в папку

        /* ---------------------------------------------------- END ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */



        /* --- отправка на почту --- */

        // exit();

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        $mail->CharSet = 'UTF-8';

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail-01-sh.hoster.by';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication


            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            $mail->Username = 'erc@mchs.gov.by';                 // SMTP username
            $mail->Password = 'oC5uKWSL';                           // SMTP password
            //Recipients
            $mail->setFrom('erc@mchs.gov.by', 'rcu_rchs');


            //Attachments
            // $mail->addAttachment(__DIR__ . '/temp/' . $f_excel);         // Add attachments excel
            $mail->addAttachment(__DIR__ . '/temp/' . $f_pdf);         // Add attachments pdf
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            //Content

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Путевка на выезд № $id_rig";
            $mail->Body = '<b>Путевка в прикрепленном файле!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->addAddress('nata.deshchenya@mail.ru', 'Joe User');     // Add a recipient

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

        // exit();


        /* --- END отправка на почту -- */
    });

    // pdf_print
    $app->get('/pdf_print/:id_rig', function ($id_rig) use ($app) {

        $array = getData($id_rig);

        /* ---------------------------------------------------- ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

        $pdf = new tFPDF();
        $pdf->AddPage();

// Add a Unicode font (uses UTF-8)
        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont('DejaVub', '', 'DejaVuSansCondensed-Bold.ttf', true);
        $pdf->SetFont('DejaVub', '', 14);
//$pdf->SetFont('Times','',14);
// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');

        $pdf->Cell(0, 8, 'ПУТЕВКА № ' . $id_rig, 0, 1, 'C', false);
        $pdf->Cell(0, 5, 'для выезда дежурной смены подразделения', 0, 1, 'C', false);

        $pdf->Ln(10); //отступ после заголовка

        /* 1.Адрес  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '1.Адрес      ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['address'] . $array['object']);

        $pdf->Ln(10); //отступ после заголовка

        /* 2.Цель выезда  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '2.Цель выезда      ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['purpose']);

        $pdf->Ln(10); //отступ после заголовка

        /* Время и дата получения сообщения */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '3.Время и дата получения сообщения     ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['hour']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  часов  ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['minutes']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  минут(ы)');

        $pdf->Ln(10); //отступ после строки
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '«' . $array['day'] . '»');
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  ' . $array['name_month']);
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '  ' . $array['year']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  г.');

        $pdf->Ln(10); //отступ после строки

        /* 4. Данные о заявителе  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '4. Данные о заявителе     ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['data_people']);


        $pdf->Ln(10); //отступ после строки


        /* Подпись дежурного диспетчера */

        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, 'Подпись дежурного диспетчера   ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '                                            ');

        $f = mt_rand() . '_tmp.pdf';
        $pdf->Output(__DIR__ . '/temp/' . $f, 'F'); //сохранить в папку



        $content = file_get_contents(__DIR__ . '/temp/' . $f);

        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($content));
        header('Content-Disposition: inline; filename="YourFileName.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        ini_set('zlib.output_compression', '0');

        die($content);

        //сохраняем на сервере для дальнейшей отправки на почту
        //$f = mt_rand() . '_tmp.xlsx';
        //$objWriter->save(__DIR__ . '/tmpl/tmpl' . $f);

        /* ---------------------------------------------------- END ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

        /* --- отправка на почту --- */





        /* --- END отправка на почту -- */
    });


    // pdf_download
    $app->get('/pdf_download/:id_rig', function ($id_rig) use ($app) {

        $array = getData($id_rig);
        /* ---------------------------------------------------- ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

        $pdf = new tFPDF();
        $pdf->AddPage();

// Add a Unicode font (uses UTF-8)
        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont('DejaVub', '', 'DejaVuSansCondensed-Bold.ttf', true);
        $pdf->SetFont('DejaVub', '', 14);
//$pdf->SetFont('Times','',14);
// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');

        $pdf->Cell(0, 8, 'ПУТЕВКА № ' . $id_rig, 0, 1, 'C', false);
        $pdf->Cell(0, 5, 'для выезда дежурной смены подразделения', 0, 1, 'C', false);

        $pdf->Ln(10); //отступ после заголовка

        /* 1.Адрес  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '1.Адрес      ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['address'] . $array['object']);

        $pdf->Ln(10); //отступ после заголовка

        /* 2.Цель выезда  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '2.Цель выезда      ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['purpose']);

        $pdf->Ln(10); //отступ после заголовка

        /* Время и дата получения сообщения */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '3.Время и дата получения сообщения     ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['hour']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  часов  ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['minutes']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  минут(ы)');

        $pdf->Ln(10); //отступ после строки
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '«' . $array['day'] . '»');
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  ' . $array['name_month']);
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '  ' . $array['year']);
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '  г.');

        $pdf->Ln(10); //отступ после строки

        /* 4. Данные о заявителе  */
        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, '4. Данные о заявителе     ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, $array['data_people']);


        $pdf->Ln(10); //отступ после строки


        /* Подпись дежурного диспетчера */

        $pdf->SetFont('DejaVu', '', 14);
        $pdf->Write(8, 'Подпись дежурного диспетчера   ');
        $pdf->SetFont('DejaVu', 'U', 14);
        $pdf->Write(8, '                                            ');

        $filename = 'putevka' . $id_rig . '.pdf';
        $pdf->Output($filename, 'D');

        /* ---------------------------------------------------- END ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */
    });

    // excel_download
    $app->get('/excel_download/:id_rig', function ($id_rig) use ($app) {

        $array = getData($id_rig);


        /* ---------------------------------------------------- ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/waybill/waybill.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $sheet->setCellValue('A1', 'ПУТЕВКА № ' . $id_rig);

        $sheet->setCellValue('E4', $array['address'] . $array['object']); //адрес
        $sheet->setCellValue('E5', $array['purpose']); //цель выезда
        $sheet->setCellValue('J6', $array['hour']); //часы
        $sheet->setCellValue('L6', $array['minutes']); //минуты
        $sheet->setCellValue('B7', $array['day']); //день
        $sheet->setCellValue('D7', $array['name_month']); //месяц
        $sheet->setCellValue('E7', $array['year']); //год
        $sheet->setCellValue('G8', $array['data_people']); //данные по заявителю
        // Сохранить в файл
        $filename = 'putevka' . $id_rig . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');


        //сохраняем на сервере для дальнейшей отправки на почту
        // $f_excel = mt_rand() . '_tmp.xlsx';
        //$objWriter->save(__DIR__ . '/temp/' . $f_excel);

        /* ---------------------------------------------------- END ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
    });


// test!!!!!!
    $app->get('/html_pdf_print/:id_rig/:is_action/:is_download', function ($id_rig, $is_action, $is_download) use ($app) {


        $array = getData($id_rig);
        //print_r($array);exit();

        /* generate html file of putevki */

        $font_default = '<style>body { font-family: DejaVu Sans; font-size: 16px }</style>';
        $head = '<center><b>ПУТЕВКА № ' . $id_rig . '<br> для выезда дежурной смены подразделения</b></center><br><br>';



        /* 1.address  */
        $address = '1. Адрес&nbsp;&nbsp;&nbsp;<u>' . $array['address'] . $array['object'] . '</u><br>';

        /* 2.purpose  */
        $purpose = '2. Цель выезда&nbsp;&nbsp;&nbsp;<u>' . $array['purpose'] . '</u><br>';



        /* 3. time and date of msg */
        $date_time_msg = '3. Время и дата получения сообщения&nbsp;&nbsp;&nbsp;<u>' . $array['hour'] . '</u> часов <u>' . $array['minutes'] . '</u> ' . '  минут(ы) ' .
            '<u>«' . $array['day'] . '»</u> ' . $array['name_month'] . '&nbsp;<u>' . $array['year'] . '</u>  г.<br>';


        /* 4. data about people  */
        $people = '4. Данные о заявителе&nbsp;&nbsp;&nbsp;<u>' . $array['data_people'] . '</u><br><br>';

        /* sign of operativnogo */
        $sign = 'Подпись дежурного диспетчера&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br><br>';


        $text_1 = 'По мнению президента, проект закона — один из ключевых вопросов кадровой политики, «ведь эффективность и авторитет всей системы власти во многом зависят от уровня подготовки и мотивированности работников государственных органов».

Президент отметил, что высокий правовой статус государственных служащих, обеспечивающий престижность этой профессии, невозможен без установления в законе социально-правовых гарантий для них. Но эти гарантии должны строго соотноситься с обязанностями и ответственностью каждого сотрудника госоргана, обратил внимание он.

«Поручая разработать этот закон, я предупреждал всех вас, что эти „коврижки“, которые у нас принято раздавать в любом законе в виде каких-то социальных гарантий, не должны быть выше того, что они есть, — сказал Александр Лукашенко. — Материальное положение госслужащих должно расти или падать в соответствии с ростом или падением жизненного уровня нашего населения. Это ключевое».
Читать полностью:  <br><br>';
//$text_2='По мнению президента, проект закона — один из ключевых вопросов кадровой политики, «ведь эффективность и авторитет всей системы власти во многом зависят от уровня подготовки и мотивированности работников государственных органов».
//
//Президент отметил, что высокий правовой статус государственных служащих, обеспечивающий престижность этой профессии, невозможен без установления в законе социально-правовых гарантий для них. Но эти гарантии должны строго соотноситься с обязанностями и ответственностью каждого сотрудника госоргана, обратил внимание он.
//
//«Поручая разработать этот закон, я предупреждал всех вас, что эти „коврижки“, которые у нас принято раздавать в любом законе в виде каких-то социальных гарантий, не должны быть выше того, что они есть, — сказал Александр Лукашенко. — Материальное положение госслужащих должно расти или падать в соответствии с ростом или падением жизненного уровня нашего населения. Это ключевое».
//Читать полностью:  <br><br>';
//$text_3='По мнению президента, проект закона — один из ключевых вопросов кадровой политики, «ведь эффективность и авторитет всей системы власти во многом зависят от уровня подготовки и мотивированности работников государственных органов».
//
//Президент отметил, что высокий правовой статус государственных служащих, обеспечивающий престижность этой профессии, невозможен без установления в законе социально-правовых гарантий для них. Но эти гарантии должны строго соотноситься с обязанностями и ответственностью каждого сотрудника госоргана, обратил внимание он.  ';


        if ($array['work_id'] != 0) {
            $vid = '<span class="vid">Вид:&nbsp;&nbsp;&nbsp;' . (($array['work_id'] != 0) ? $array['work_view'] : '') . '</span><br>';
        } else
            $vid = '';

        $res = $font_default . $head . $address . $purpose . $date_time_msg . $people . $sign . $vid;

        /* with action */
        if ($is_action == 1) {
            if (!empty($array['action'])) {
                foreach ($array['action'] as $value) {
                    $res = $res . $value['description'];
                }
            }
        }
//echo $is_action;


        /* END generate html file of putevki */


// instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $dompdf->loadHtml($res, 'UTF-8');


// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
        $dompdf->render();


        /* save to directory */
        $f = mt_rand() . '_tmp.pdf';

        /* print, open in browser */
        if ($is_download == 0) {

            $output = $dompdf->output();
            file_put_contents(__DIR__ . '/temp/' . $f, $output);

            /* see in browser */
            $content = file_get_contents(__DIR__ . '/temp/' . $f);

            header('Content-Type: application/pdf');
            header('Content-Length: ' . strlen($content));
            header('Content-Disposition: inline; filename="YourFileName.pdf"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            ini_set('zlib.output_compression', '0');

            die($content);
        } else {
            $filename = 'putevka' . $id_rig . '.pdf';
            $dompdf->stream($filename);
        }
    });
});



/* --------------- КОНЕЦ  Путевка ---------------------- */


/* ------------------------- Logs ------------------------------- */

$app->group('/logs', 'is_login', 'is_permis', function () use ($app) {



    /* login */
    $app->get('/login', function () use ($app) {

        $bread_crumb = array('Логи. Авторизация пользователей', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';

        $date_from = date('Y-m-d');

        $data['logs'] = R::getAll('select * from loglogin where date_format(date_in,"%Y-%m-%d") = ?', array($date_from));

        $app->render('layouts/header.php', $data);
        // $data['path_to_view'] = 'logs/login/form.php';
        $data['path_to_view'] = 'logs/login/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    $app->post('/login', function () use ($app) {

        $bread_crumb = array('Логи. Авторизация пользователей', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';

        $date_from = (isset($_POST['date_start']) && !empty($_POST['date_start']) ) ? $_POST['date_start'] : date("Y-m-d");
        $date_to = (isset($_POST['date_end']) && !empty($_POST['date_end']) ) ? $_POST['date_end'] : date("Y-m-d");

        $data['logs'] = R::getAll('select * from loglogin where date_format(date_in,"%Y-%m-%d") between ? and ?', array($date_from, $date_to));

        $app->render('layouts/header.php', $data);
        //$data['path_to_view'] = 'logs/form.php';
        $data['path_to_view'] = 'logs/login/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    /* action */
    $app->get('/actions', function () use ($app) {

        $bread_crumb = array('Логи. Действия пользователей', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';

        $date_from = date('Y-m-d');
        $data['logs'] = R::getAll('select * from logs where date_format(date_action,"%Y-%m-%d") = ?', array($date_from));

        $app->render('layouts/header.php', $data);
        //$data['path_to_view'] = 'logs/actions/form.php';
        $data['path_to_view'] = 'logs/actions/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->post('/actions', function () use ($app) {

        $bread_crumb = array('Логи. Действия пользователей', 'Результат');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';

        $date_from = (isset($_POST['date_start']) && !empty($_POST['date_start']) ) ? $_POST['date_start'] : date("Y-m-d");
        $date_to = (isset($_POST['date_end']) && !empty($_POST['date_end']) ) ? $_POST['date_end'] : date("Y-m-d");

        $data['logs'] = R::getAll('select * from logs where date_format(date_action,"%Y-%m-%d") between ? and ?', array($date_from, $date_to));

        $app->render('layouts/header.php', $data);
        //$data['path_to_view'] = 'logs/form.php';
        $data['path_to_view'] = 'logs/actions/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    /* json */

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Логи', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';


        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'logs/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->post('/', function () use ($app) {


        $bread_crumb = array('Логи', 'Просмотр');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';

        $date = (isset($_POST['date_start']) && !empty($_POST['date_start']) ) ? $_POST['date_start'] : date("Y-m-d");

        $filename = 'share/logs/development_' . $date . '.log';

        if (file_exists($filename)) {
            $data['file'] = file($filename);
        }


        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'logs/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});


/* ------------------------- END  Logs ------------------------------- */


/* ------------------------- Save to json ------------------------------- */

$app->group('/save_to_json', 'is_login', 'is_permis', function () use ($app) {

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Сохранить в json', 'Выбор диапазона дат');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Сохранить в json';


        $archive_m = new Model_Archivedate();
        $data['archive_date'] = $archive_m->selectAll(); //какие архивы уже сделаны
        $archive_year_m = new Model_Archiveyear();
        $data['archive_year'] = $archive_year_m->selectAll(); //какие года есть в БД






        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'save_to_json/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->post('/', function () use ($app) {

//
        /* ------- Даты ------ */

        if (isset($_POST['date_start']) && !empty($_POST['date_start'])) {
            $d1 = $_POST['date_start'];
        } else {
            $d1 = date("Y-m-d");
        }
        if (isset($_POST['date_end']) && !empty($_POST['date_end'])) {
            $d2 = $_POST['date_end'];
        } else {
            $d2 = $_POST['date_end'];
        }
        /* ------- END Даты ------ */



        /*  Выборка запрошенных данных  */

        $rig_m = new Model_Rigtable(); //rig
        $rig = $rig_m->selectAllForJson(0, $d1, $d2);
        //  echo '123';
//exit();
        // print_r($rig);
        //exit();

        if (isset($rig) && !empty($rig)) {
            $json_val = array();
            $id_rigs = array();

            foreach ($rig as $row) {
                $json = array();
                $json['id_rig'] = $row['id'];
                $json['date_msg'] = $row['date_msg'];
                $json['time_msg'] = $row['time_msg'];
                $json['id_locorg'] = $row['id_locorg']; //создатель
                $json['local_name'] = $row['local_name'];
                $json['region_name'] = $row['region_name'];
                $json['address'] = $row['address'];
                $json['floor'] = $row['floor'];
                $json['reasonrig_name'] = $row['reasonrig_name'];
                $json['description'] = $row['description'];
                $json['firereason_name'] = $row['firereason_name'];
                $json['inspector'] = $row['inspector'];
                $json['id_statusrig'] = $row['id_statusrig'];
                $json['statusrig_name'] = $row['statusrig_name'];
                $json['statusrig_color'] = $row['statusrig_color'];
                $json['is_closed'] = $row['is_closed'];
                $json['id_organ_user'] = $row['id_organ_user']; //создатель
                $json['is_delete'] = $row['is_delete'];
                $json['id_region_user'] = $row['id_region_user']; //создатель
                $json['sub'] = $row['sub'];
                $json['id_region'] = $row['id_region']; //куда выезжали
                $json['id_local'] = $row['id_local']; //куда выезжали
                $json['additional_field_address'] = $row['additional_field_address'];
                $json['time_loc'] = $row['time_loc'];
                $json['time_likv'] = $row['time_likv'];
                $json['inf_detail'] = $row['inf_detail'];
                $json['view_work'] = $row['view_work'];
                $json['office_name'] = $row['office_name'];
                $json['object'] = $row['object'];
                $json['is_opg'] = $row['is_opg'];
                $json['opg_text'] = $row['opg_text'];


                $id_rigs[] = $json['id_rig'];

                array_push($json_val, $json);
            }


            //инф по привлекаемым СиС МЧС
            $jrig_m = new Model_Jrig();
            $silymchs = $jrig_m->selectAllInIdRig($id_rigs);

            //   print_r($silymchs);

            if (!empty($silymchs)) {
                foreach ($json_val as $key => $row) {
                    if (isset($silymchs[$row['id_rig']])) {//есть СиС МЧС по этому выезду
                        $json_val[$key]['silymchs'] = $silymchs[$row['id_rig']];
                    }
                }
            }


            //инф о заявителе
            $people_m = new Model_People();
            $people = $people_m->selectAllInIdRig($id_rigs);

            if (!empty($people)) {
                foreach ($json_val as $key => $row) {
                    if (isset($people[$row['id_rig']])) {//есть заявитель по этому выезду
                        $json_val[$key]['people'] = $people[$row['id_rig']];
                    }
                }
            }


            //инф о informing
            $informing_m = new Model_Informing();
            $informing = $informing_m->selectAllInIdRig($id_rigs);

            if (!empty($informing)) {
                foreach ($json_val as $key => $row) {
                    if (isset($informing[$row['id_rig']])) {//есть informing по этому выезду
                        $json_val[$key]['informing'] = $informing[$row['id_rig']];
                    }
                }
            }



            //инф о innerservice - привлекаемые ведомства
            $innerservice_m = new Model_Innerservice();
            $innerservice = $innerservice_m->selectAllInIdRig($id_rigs);

            if (!empty($innerservice)) {
                foreach ($json_val as $key => $row) {
                    if (isset($innerservice[$row['id_rig']])) {//есть innerservice по этому выезду
                        $json_val[$key]['innerservice'] = $innerservice[$row['id_rig']];
                    }
                }
            }

            //print_r($json_val);
            //exit();

            /*  экспорт в json */
            $fp = fopen('tmpl/save_to_json/' . $d1 . '_' . $d2 . '.json', 'w');
            fwrite($fp, json_encode($json_val, JSON_UNESCAPED_UNICODE));
            fclose($fp);

            $data['msg'] = 'Файл ' . $d1 . '_' . $d2 . '.json успешно сформирован!';


            /*  записать этот диапазон в БД */
            $archive_m = new Model_Archivedate();
            $archive_m->save($d1, $d2);
        } else {
            $data['msg'] = 'Нет данных!';
        }




        $archive_m = new Model_Archivedate();
        $data['archive_date'] = $archive_m->selectAll(); //какие архивы уже сделаны
        $archive_year_m = new Model_Archiveyear();
        $data['archive_year'] = $archive_year_m->selectAll(); //какие года есть в БД


        $bread_crumb = array('Сохранить в json', 'Выбор диапазона дат');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Сохранить в json';


        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'save_to_json/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});


/* ------------------------- END  Save to json ------------------------------- */



$app->get('/json_to_mysql', function () use ($app) {
    $file_json = '2019-03-01' . '_' . '2019-03-03';
    $myFile = "tmpl/save_to_json/" . $file_json . ".json";
    $arr_data = array(); // create empty array
    //Get data from existing json file
    $jsondata = file_get_contents($myFile);

    // converts json data into array
    $arr_data = json_decode($jsondata, true);
    //print_r($arr_data);
    //exit();

    foreach ($arr_data as $row) {
        // echo $row['id_rig'];                echo '<br>';

        $p = '';
        if (isset($row['people'])) {

            $p = ((empty($row['people']['fio'])) ? '' : $row['people']['fio']) . '' . ((empty($row['people']['phone'])) ? '' : (', ' . $row['people']['phone'])) . '' . ((empty($row['people']['address'])) ? '' : (', ' . $row['people']['address'])) . '' . ((empty($row['people']['position'])) ? '' : (', ' . $row['people']['position']));
        }
        //echo $p;echo '<br>****************<br>';

        $silymchs_for_archive = '';
        if (isset($row['silymchs'])) {

            foreach ($row['silymchs'] as $silymchs) {
                $silymchs_for_archive = $silymchs_for_archive . $silymchs['mark'] . '#' . $silymchs['numbsign'] . '$' . $silymchs['locorg_name'] . '%' . $silymchs['pasp_name'] . '?' . ((empty($silymchs['time_exit'])) ? '-' : $silymchs['time_exit']) . '&'
                    . ((empty($silymchs['time_arrival'])) ? '-' : $silymchs['time_arrival']) . '&' . ((empty($silymchs['time_follow'])) ? '-' : $silymchs['time_follow']) . '&' . ((empty($silymchs['time_end'])) ? '-' : $silymchs['time_end']) . '&'
                    . ((empty($silymchs['time_return'])) ? '-' : $silymchs['time_return']) . '&' . ((empty($silymchs['distance'])) ? '-' : $silymchs['distance']) . '&' . ((empty($silymchs['is_return'])) ? '-' : $silymchs['is_return']) . '~';
            }
        }
        // echo $silymchs_for_archive;
        // echo '<br>****************<br>';


        $informing_for_archive = '';
        if (isset($row['informing'])) {
            foreach ($row['informing'] as $informing) {
                $informing_for_archive = $informing_for_archive . $informing['fio'] . ' (' . $informing['position_name'] . ')' . '#'
                    . ((empty($informing['time_msg'])) ? '-' : ($informing['time_msg'])) . '&'
                    . ((empty($informing['time_exit'])) ? '-' : ($informing['time_exit'])) . '&'
                    . ((empty($informing['time_arrival'])) ? '-' : ($informing['time_arrival'])) . '~';
            }
        }
//                 echo $informing_for_archive;
//                 echo '<br>****************<br>';


        $innerservice_for_archive = '';
        if (isset($row['innerservice'])) {
            foreach ($row['innerservice'] as $innerservice) {
                $innerservice_for_archive = $innerservice_for_archive . $innerservice['service_name'] . '#'
                    . ((empty($innerservice['time_msg'])) ? '-' : $innerservice['time_msg']) . '&'
                    . ((empty($innerservice['time_arrival'])) ? '-' : $innerservice['time_arrival']) . '&'
                    . ((empty($innerservice['distance'])) ? '-' : $innerservice['distance']) . '%'
                    . ((empty($innerservice['note'])) ? '-' : $innerservice['note']) . '~';
            }
        }
//                 echo $innerservice_for_archive;
//                 echo '<br>****************<br>';



        /* insert into bd */
        R::selectDatabase('jarchive');
        $jarchive = R::dispense('2019a');
        $jarchive->id_rig = $row['id_rig'];
        $jarchive->date_msg = $row['date_msg'];
        $jarchive->time_msg = $row['time_msg'];
        $jarchive->description = $row['description'];
        $jarchive->reasonrig_name = $row['reasonrig_name'];
        $jarchive->address = $row['address'];
        $jarchive->locality_name = '-';
        $jarchive->region_name = $row['region_name'];
        $jarchive->local_name = $row['local_name'];
        $jarchive->selsovet_name = '-';
        $jarchive->is_opposite = 0;
        $jarchive->object = (!empty($row['object'])) ? ('(' . $row['object'] . ')') : '-';
        $jarchive->office_name = $row['office_name'];
        $jarchive->inf_detail = $row['inf_detail'];
        $jarchive->view_work = $row['view_work'];
        $jarchive->firereason_name = $row['firereason_name'];
        $jarchive->version_reason = '';
        $jarchive->inspector = $row['inspector'];
        $jarchive->is_closed = $row['is_closed'];
        $jarchive->is_delete = $row['is_delete'];
        $jarchive->time_loc = $row['time_loc'];
        $jarchive->time_likv = $row['time_likv'];
        $jarchive->additional_field_address = $row['additional_field_address'];
        $jarchive->sub = $row['sub'];
        $jarchive->is_opg = $row['is_opg'];
        $jarchive->opg_text = $row['opg_text'];
        $jarchive->is_likv_before_arrival = 0;
        $jarchive->opg_text = $row['opg_text'];
        $jarchive->date_insert = date("Y-m-d H:i:s");
        $jarchive->people = $p;
        $jarchive->silymchs = $silymchs_for_archive;
        $jarchive->informing = $informing_for_archive;
        $jarchive->innerservice = $innerservice_for_archive;
        R::store($jarchive);
    }
    R::selectDatabase('default');
});


/* ------------------------- Archive Журнал ЦОУ ------------------------------- */

$app->group('/archive', 'is_login', 'is_permis', function () use ($app) {

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Архив', 'Параметры');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Журнал ЦОУ. Архив';



        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        $archive_m = new Model_Archivedate();
        $data['archive_date'] = $archive_m->selectAll();
        $archive_year_m = new Model_Archiveyear();
        $data['archive_year'] = $archive_year_m->selectAll();

        /*         * *** КОНЕЦ Классификаторы **** */


        $isset_date = $archive_m->selectAll(); //какие архивы уже сделаны
        $isset_year = $archive_year_m->selectAll(); //какие года есть в БД


        $app->render('layouts/archive/header.php', $data);
        $data['path_to_view'] = 'archive/form.php';
        $app->render('layouts/archive/div_wrapper.php', $data);
        $app->render('layouts/archive/footer.php');
    });


    $app->post('/', function () use ($app) {

        /* если выбран диапазон дат, то выбрать год нельзя и наоборот. Но обязательно что-то из этого должно быть!!! */
        $archive_date = (isset($_POST['archive_date']) && !empty($_POST['archive_date'])) ? $_POST['archive_date'] : 0; //диапазон дат - array
        $archive_year = (isset($_POST['archive_year']) && !empty($_POST['archive_year'])) ? $_POST['archive_year'] : 0; //year
//куда был выезд - область
        $id_region = (isset($_POST['id_region']) && !empty($_POST['id_region'])) ? $_POST['id_region'] : 0;
        $region_m = new Model_Region();
        $data['region_name'] = $region_m->selectNameById($id_region);

//куда был выезд - район
        $id_local = (isset($_POST['id_local']) && !empty($_POST['id_local'])) ? $_POST['id_local'] : 0;
        $local_m = new Model_Local();
        $data['local_name'] = $local_m->selectNameById($id_local);


        if ($archive_date != 0) {//выбран диапазон дат
            //получить из БД диапазоны дат - имена json-файлов, которые надо прочитать
            $archive_m = new Model_Archivedate();
            $date_for_file_json = $archive_m->selectById($archive_date);

            $data['query_date'] = $date_for_file_json; //запросшенные диапазоны
            //считать данные из json-файлов в массив
            $array_of_content_file_json = array();
            foreach ($date_for_file_json as $value) {
                $file_json = $value['date_start'] . '_' . $value['date_end'];
                $myFile = "tmpl/save_to_json/" . $file_json . ".json";
                $arr_data = array(); // create empty array
                //Get data from existing json file
                $jsondata = file_get_contents($myFile);

                // converts json data into array
                $arr_data = json_decode($jsondata, true);
                $array_of_content_file_json[$file_json] = $arr_data; //каждый файл помещаем как элемент массива, ключ которого соответствует диапазону файла
            }
            //print_r($array_of_content_file_json);
        } elseif ($archive_year != 0) {//выбран год
            //получить из БД год, по которому запрошены данные
            $archive_year_m = new Model_Archiveyear();
            $year_for_file_json = $archive_year_m->selectById($archive_year); //год
            $data['query_year'] = $year_for_file_json; //запросшенный год
            //получить из БД все диапазоны дат, которые ложаться в этот год
            $archive_m = new Model_Archivedate();
            $date_for_file_json = $archive_m->selectByYear($year_for_file_json);


            //считать данные из json-файлов в массив
            $array_of_content_file_json = array();
            foreach ($date_for_file_json as $value) {
                $file_json = $value['date_start'] . '_' . $value['date_end'];
                $myFile = "tmpl/save_to_json/" . $file_json . ".json";
                $arr_data = array(); // create empty array
                //Get data from existing json file
                $jsondata = file_get_contents($myFile);

                // converts json data into array
                $arr_data = json_decode($jsondata, true);
                $array_of_content_file_json[$file_json] = $arr_data; //каждый файл помещаем как элемент массива, ключ которого соответствует диапазону файла
            }
            // print_r($array_of_content_file_json);
        }

        if (isset($array_of_content_file_json) && !empty($array_of_content_file_json)) {
            $data['result'] = $array_of_content_file_json;
        }
//print_r($array_of_content_file_json);
//exit();


        $bread_crumb = array('Архив', 'Результат запроса');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Журнал ЦОУ. Архив';

        $app->render('layouts/archive/header.php', $data);
        $data['path_to_view'] = 'archive/result/table.php';
        $app->render('layouts/archive/div_wrapper.php', $data);
        $app->render('layouts/archive/footer.php');

        exit();
    });
});





/* new archive. bd */
$app->group('/archive_1', 'is_login', 'is_permis', function () use ($app) {

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Архив', 'Параметры');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Журнал ЦОУ. Архив';



        /*         * *** Классификаторы **** */
        // $region = new Model_Region();


        $name_oblast[1] = 'Брестская область';
        $name_oblast[2] = 'Витебская область';
        $name_oblast[3] = 'г. Минск';
        $name_oblast[4] = 'Гомельская область';
        $name_oblast[5] = 'Гродненская область';
        $name_oblast[6] = 'Минская область';
        $name_oblast[7] = 'Могилевская область';

        $data['region'] = $name_oblast; //области

        $archive_m = new Model_Archivedate();
        $main_m = new Model_Main();

        $data['archive_date'] = $archive_m->selectAll();
        //$archive_year_m = new Model_Archiveyear();
        // $data['archive_year'] = $archive_year_m->selectAll();
        //$data['archive_year'] = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');
        //$archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');

        $archive_year = ARCHIVE_YEAR;


        foreach ($archive_year as $value) {

            $y = $value['table_name'];
            $real_server=$main_m->get_js_connect(substr($y, 0, -1));


            if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {

                $pdo = get_pdo_15($real_server);

                $sth = $pdo->prepare("SELECT MAX(a.date_msg) as max_date FROM ".$value['table_name']." as a ");
                $sth->execute();
                $value['max_date'] = $sth->fetchColumn();
                $archive_year_1[] = $value;
            } else {
                $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
                $archive_year_1[] = $value;
            }
        }
        //print_r($archive_year_1);
       // exit();
        $data['archive_year'] = $archive_year_1;


        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));
        /*         * *** КОНЕЦ Классификаторы **** */


        // $isset_date = $archive_m->selectAll();//какие архивы уже сделаны
        // $isset_year = $archive_year_m->selectAll();//какие года есть в БД


        $app->render('layouts/archive/header.php', $data);
        $data['path_to_view'] = 'archive_1/form.php';
        $app->render('layouts/archive/div_wrapper.php', $data);
        $app->render('layouts/archive/footer.php');
    });


    $app->post('/', function () use ($app) {


//                $dsn = 'mysql:host=172.26.200.15;dbname=jarchive;charset=utf8';
//        $usr = 'str_natali';
//        $pwd = 'str_natali';
//
////$pdo = new \FaaPz\PDO\Database($dsn, $usr, $pwd);
//        $pdo = new PDO($dsn, $usr, $pwd);
//
//        $sth = $pdo->prepare("SELECT * FROM 2019a where id = ?");
//        $sth->execute(array(3187));
//        print("Fetch the first column from the first row in the result set:\n");
//        $result = $sth->fetchAll();
//        print_r($result);

        /* если выбран диапазон дат, то выбрать год нельзя и наоборот. Но обязательно что-то из этого должно быть!!! */
        $archive_date = (isset($_POST['archive_date']) && !empty($_POST['archive_date'])) ? $_POST['archive_date'] : 0; //диапазон дат - array
        $archive_year = (isset($_POST['archive_year']) && !empty($_POST['archive_year'])) ? $_POST['archive_year'] : 0; //year
//куда был выезд - область
        $id_region = (isset($_POST['id_region']) && !empty($_POST['id_region'])) ? $_POST['id_region'] : 0;
        $region_m = new Model_Region();
        $data['region_name'] = $region_m->selectNameById($id_region);

//куда был выезд - район
        $id_local = (isset($_POST['id_local']) && !empty($_POST['id_local'])) ? $_POST['id_local'] : 0;
        $local_m = new Model_Local();
        $data['local_name'] = $local_m->selectNameById($id_local);


        if ($archive_date != 0) {//выбран диапазон дат
            //получить из БД диапазоны дат - имена json-файлов, которые надо прочитать
            $archive_m = new Model_Archivedate();
            $date_for_file_json = $archive_m->selectById($archive_date);

            $data['query_date'] = $date_for_file_json; //запросшенные диапазоны
            //считать данные из json-файлов в массив
            $array_of_content_file_json = array();
            foreach ($date_for_file_json as $value) {
                $file_json = $value['date_start'] . '_' . $value['date_end'];
                $myFile = "tmpl/save_to_json/" . $file_json . ".json";
                $arr_data = array(); // create empty array
                //Get data from existing json file
                $jsondata = file_get_contents($myFile);

                // converts json data into array
                $arr_data = json_decode($jsondata, true);
                $array_of_content_file_json[$file_json] = $arr_data; //каждый файл помещаем как элемент массива, ключ которого соответствует диапазону файла
            }
            //print_r($array_of_content_file_json);
        } elseif ($archive_year != 0) {//выбран год
            //получить из БД год, по которому запрошены данные
            $archive_year_m = new Model_Archiveyear();
            $year_for_file_json = $archive_year_m->selectById($archive_year); //год
            $data['query_year'] = $year_for_file_json; //запросшенный год
            //получить из БД все диапазоны дат, которые ложаться в этот год
            $archive_m = new Model_Archivedate();
            $date_for_file_json = $archive_m->selectByYear($year_for_file_json);


            //считать данные из json-файлов в массив
            $array_of_content_file_json = array();
            foreach ($date_for_file_json as $value) {
                $file_json = $value['date_start'] . '_' . $value['date_end'];
                $myFile = "tmpl/save_to_json/" . $file_json . ".json";
                $arr_data = array(); // create empty array
                //Get data from existing json file
                $jsondata = file_get_contents($myFile);

                // converts json data into array
                $arr_data = json_decode($jsondata, true);
                $array_of_content_file_json[$file_json] = $arr_data; //каждый файл помещаем как элемент массива, ключ которого соответствует диапазону файла
            }
            // print_r($array_of_content_file_json);
        }

        if (isset($array_of_content_file_json) && !empty($array_of_content_file_json)) {
            $data['result'] = $array_of_content_file_json;
        }
//print_r($array_of_content_file_json);
//exit();


        $bread_crumb = array('Архив', 'Результат запроса');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Журнал ЦОУ. Архив';

        $app->render('layouts/archive/header.php', $data);
        $data['path_to_view'] = 'archive/result/table.php';
        $app->render('layouts/archive/div_wrapper.php', $data);
        $app->render('layouts/archive/footer.php');

        exit();
    });

    $app->post('/getInfRig', function () use ($app) {

        $main_m = new Model_Main();

        /* post data */
        $date_start = $app->request()->post('date_start');
        $date_end = $app->request()->post('date_end');
        $table_name_year = $y= $app->request()->post('archive_year');
        $region_id = $app->request()->post('region');
        $local = $app->request()->post('local');
        $reasonrig = $app->request()->post('reasonrig');

        switch ($region_id) {
            case 1: $region = "Брестская";
                break;
            case 2: $region = "Витебская";
                break;
            case 3: $region = "г.Минск";
                break;
            case 4: $region = "Гомельская";
                break;
            case 5: $region = "Гродненская";
                break;
            case 6:$region = "Минская";
                break;
            case 7:$region = "Могилевская";
                break;
            default: $region = "";
                break;
        }

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;



        if (isset($region) && $region != '') {
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }
        if (isset($local) && !empty($local)) {
            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }

        if (isset($reasonrig) && !empty($reasonrig)) {
            $sql = $sql . ' AND reasonrig_name = "' . $reasonrig . '"';
            //$param[] = $local;
        }

        $sql = 'SELECT id_rig ' . $sql;



        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);
            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $data['result'] = $sth->fetchAll();
        } else {
            $data['result'] = R::getAll($sql, $param);
        }



        $cnt_result = count($data['result']);

        $ids_rig = array();
        foreach ($data['result'] as $value) {
            $ids_rig[] = $value['id_rig'];
        }

//$data['cnt']=$cnt_result;
        /* colors */
        if (!empty($ids_rig)) {
            $_SESSION['colors'] = array();
            $spread = 25;
            for ($row = 0; $row < $cnt_result; ++$row) {
                for ($c = 0; $c < 3; ++$c) {
                    $color[$c] = rand(0 + $spread, 255 - $spread);
                }
                //echo "<div style='float:left; background-color:rgb($color[0],$color[1],$color[2]);'>&nbsp;Base Color&nbsp;</div><br/>";
                for ($i = 0; $i < 92; ++$i) {
                    $r = rand($color[0] - $spread, $color[0] + $spread);
                    $g = rand($color[1] - $spread, $color[1] + $spread);
                    $b = rand($color[2] - $spread, $color[2] + $spread);
                    // echo "<div style='background-color:rgb($r,$g,$b); width:10px; height:10px; float:left;'></div>";
                    $id_rig = $ids_rig[$row];
                    $p = 0.6;
                    $colors[$id_rig] = $r . ',' . $g . ',' . $b . ',' . $p;
                }
                //echo "<br/>";
            }
            $_SESSION['colors'] = $colors;

            $view = $app->render('archive_1/getInfRig.php');
            $response = ['success' => TRUE, 'view' => $view];
            // echo '9969';
        } else {
            $view = $app->render('archive_1/empty_result.php');
            $response = ['success' => TRUE, 'view' => $view];
        }
    });

    /* table of tab */
    $app->post('/getTabContent/:id_tab', function ($id_tab) use ($app) {

        $main_m = new Model_Main();

        /* post data */
        $date_start = $app->request()->post('date_start');
        $date_end = $app->request()->post('date_end');
        $table_name_year = $app->request()->post('archive_year');
        $region_id = $app->request()->post('region');
        $local = $app->request()->post('local');

        $reasonrig = $app->request()->post('reasonrig');

        $data['table_name_year'] = $y=$table_name_year;

        $data['current_year'] =substr($y, 0, -1);



//$date_start='2018-12-03';
//$date_end='2018-12-10';
//$table_name_year='2018a';

        switch ($region_id) {
            case 1: $region = "Брестская";
                break;
            case 2: $region = "Витебская";
                break;
            case 3: $region = "г.Минск";
                break;
            case 4: $region = "Гомельская";
                break;
            case 5: $region = "Гродненская";
                break;
            case 6:$region = "Минская";
                break;
            case 7:$region = "Могилевская";
                break;
            default: $region = "";
                break;
        }

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';

        //     $sql = ' FROM jarchive.' . $table_name_year . '  WHERE  concat(date_msg," ",time_msg) >= ? AND concat(date_msg," ",time_msg) < ? AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';

//        $param[] = $date_start.' 06:00:00';
//        $param[] = $date_end.' 06:00:00';



        if (isset($region) && $region != '') {
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;

            $region_for_export = $region;
        } else {
            $region_for_export = 'no';
        }
        if (isset($local) && !empty($local)) {
            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
            $local_for_export = $local;
        } else {
            $local_for_export = 'no';
        }

        if (isset($reasonrig) && !empty($reasonrig)) {
            $sql = $sql . ' AND reasonrig_name = "' . $reasonrig . '"';
            //$param[] = $local;
            $reasonrig_for_export = $reasonrig;
        } else {
            $reasonrig_for_export = 'no';
        }

        //$sql=$sql.' ORDER BY id_rig ASC';
        $sql = $sql . ' ORDER BY concat(date_msg," ",time_msg) DESC';

        if ($id_tab == 'table-content1') {//rig
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail,  people,time_loc, time_likv,is_statistics ' . $sql;
        } elseif ($id_tab == 'table-content2') {//technic mchs
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival,silymchs ' . $sql;
        } elseif ($id_tab == 'table-content3') {//informing
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, informing ' . $sql;
        } elseif ($id_tab == 'table-content4') {//innerservice
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, innerservice ' . $sql;
        } elseif ($id_tab == 'table-content5') {//results br
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, results_battle, rb_chapter_1,rb_chapter_2,rb_chapter_3 ' . $sql;
        } elseif ($id_tab == 'table-content6') {//trunk
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, trunk ' . $sql;
        }

//echo $sql;

        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        $data['real_server']=$real_server;
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);

            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $data['result'] = $sth->fetchAll();
        } else {
            $data['result'] = R::getAll($sql, $param);
        }





//$data['link_excel']='archive_1/exportExcel/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export;

        if ($id_tab == 'table-content1') {
            $data['link_excel'] = 'archive_1/exportExcelTab1/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no';
            $data['link_excel_hidden'] = 'archive_1/exportExcelTab1/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export;
        } elseif ($id_tab == 'table-content2') {
            $data['link_excel'] = 'archive_1/exportExcelTab2/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no';
            $data['link_excel_hidden'] = 'archive_1/exportExcelTab2/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export;
        } elseif ($id_tab == 'table-content3') {
            $data['link_excel'] = 'archive_1/exportExcelTab3/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no';
            $data['link_excel_hidden'] = 'archive_1/exportExcelTab3/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export;
        } elseif ($id_tab == 'table-content4') {
            $data['link_excel'] = 'archive_1/exportExcelTab4/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no';
            $data['link_excel_hidden'] = 'archive_1/exportExcelTab4/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export;
        } elseif ($id_tab == 'table-content5') {
            $data['link_excel'] = 'archive_1/exportExcelTab5/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no';
            $data['link_excel_hidden'] = 'archive_1/exportExcelTab5/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export;
        } elseif ($id_tab == 'table-content6') {
            $data['link_excel'] = 'archive_1/exportExcelTab6/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no' . '/' . 'no';
            $data['link_excel_hidden'] = 'archive_1/exportExcelTab6/' . $id_tab . '/' . $table_name_year . '/' . $date_start . '/' . $date_end . '/' . $region_for_export . '/' . $local_for_export . '/' . $reasonrig_for_export;
        }

        $view = $app->render('archive_1/tab-content/' . $id_tab . '.php', $data);
        $response = ['success' => TRUE, 'view' => $view];
        // echo '9969';
    });




    $app->get('/exportExcelTab1/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/:reason/:work_view/:detail/:people/:time_loc/:time_likv', function ($id_tab, $table, $date_from, $date_to, $reg, $loc, $reasonrig_form, $id_rig, $date_msg, $time_msg, $local_1, $addr, $reason, $work_view, $detail, $people, $time_loc, $time_likv) use ($app) {


        $main_m = new Model_Main();

        /* get data */
        $date_start = $date_from;
        $date_end = $date_to;
        $table_name_year = $y=$table;
        $region = $reg;
        $local = $loc;



        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;
//var_dump($region);
        if ($region != 'no') {
            // echo 'uuuuuu';
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }

        if ($local != 'no') {

            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }

        if ($reasonrig_form != 'no') {

            $sql = $sql . ' AND reasonrig_name =  "' . $reasonrig_form . '"';
            //$param[] = $local;
        }

        /* --------------- filter from datatables ------------- */
        if ($id_rig != 'no') {
            $sql = $sql . ' AND ( id_rig like "%' . $id_rig . '" OR id_rig like "' . $id_rig . '%" OR id_rig like "%' . $id_rig . '%"  ) ';
        }
        if ($date_msg != 'no') {
            $sql = $sql . ' AND ( date_msg like "%' . $date_msg . '" OR date_msg like "' . $date_msg . '%" OR date_msg like "%' . $date_msg . '%"  ) ';
        }
        if ($time_msg != 'no') {
            $sql = $sql . ' AND ( time_msg like "%' . $time_msg . '" OR time_msg like "' . $time_msg . '%" OR time_msg like "%' . $time_msg . '%"  ) ';
        }
        if ($local_1 != 'no') {
            $sql = $sql . ' AND ( local_name like "%' . $local_1 . '" OR local_name like "' . $local_1 . '%" OR local_name like "%' . $local_1 . '%"  ) ';
        }
        if ($addr != 'no') {
            $sql = $sql . ' AND ( address like "%' . $addr . '" OR address like "' . $addr . '%" OR address like "%' . $addr . '%"  ) ';
        }
        if ($reason != 'no') {
            $sql = $sql . ' AND reasonrig_name = ?';
            $param[] = $reason;
        }
        if ($work_view != 'no') {
            $sql = $sql . ' AND view_work = ?';
            $param[] = $work_view;
        }
        if ($detail != 'no') {
            $sql = $sql . ' AND ( inf_detail like "%' . $detail . '" OR inf_detail like "' . $detail . '%" OR inf_detail like "%' . $detail . '%"  ) ';
        }
        if ($people != 'no') {
            $sql = $sql . ' AND ( people like "%' . $people . '" OR people like "' . $people . '%" OR people like "%' . $people . '%"  ) ';
        }
        if ($time_loc != 'no') {
            $sql = $sql . ' AND ( time_loc like "%' . $time_loc . '" OR time_loc like "' . $time_loc . '%" OR time_loc like "%' . $time_loc . '%"  ) ';
        }
        if ($time_likv != 'no') {
            $sql = $sql . ' AND ( time_likv like "%' . $time_likv . '" OR time_likv like "' . $time_likv . '%" OR time_likv like "%' . $time_likv . '%"  ) ';
        }

        /* --------------- END filter from datatables ------------- */




        $sql = $sql . ' ORDER BY id_rig ASC';

        if ($id_tab == 'table-content1') {//rig
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv ' . $sql;
        } elseif ($id_tab == 'table-content2') {//technic mchs
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs ' . $sql;
        } elseif ($id_tab == 'table-content3') {//informing
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, informing ' . $sql;
        } elseif ($id_tab == 'table-content4') {//innerservice
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, innerservice ' . $sql;
        }



        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);

            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $result = $sth->fetchAll();
            //print_r($result);exit();
        } else {
            $result = R::getAll($sql, $param);
        }


//$cnt_result=count($result);
//echo $sql;
//print_r($param);
//echo $cnt_result;
//exit();

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/archive/' . $id_tab . '.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //strначальная строка для записи
        $c = 0; // stolbec начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . date('d.m.Y', strtotime($date_start)) . ' по ' . date('d.m.Y', strtotime($date_end))); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no') ? $region : 'все') . ', район: ' . (($local != 'no') ? $local : 'все') . ', причина вызова: ' . (($reasonrig_form != 'no') ? $reasonrig_form : 'все')); //выбранный область и район

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (!empty($result)) {
            if ($id_tab == 'table-content1') {//rig
                foreach ($result as $row) {
                    $i++;

                    $sheet->setCellValue('A' . $r, $i); //№ п/п
                    $sheet->setCellValue('B' . $r, $row['id_rig']);
                    $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                    $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                    $sheet->setCellValue('E' . $r, $row['local_name']);
                    $sheet->setCellValue('F' . $r, $row['address']);
                    $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
                    $sheet->setCellValue('H' . $r, $row['view_work']);
                    $sheet->setCellValue('I' . $r, $row['inf_detail']);
                    $sheet->setCellValue('J' . $r, $row['people']);
                    $sheet->setCellValue('K' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                    $sheet->setCellValue('L' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));


                    $r++;
                }



                $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content2') {//technic mchs
                $i = 0;
                foreach ($result as $row) {
                    $arr_silymchs = explode('~', $row['silymchs']);

                    foreach ($arr_silymchs as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_mark = explode('#', $value);

                            $mark = $arr_mark[0];

                            /* all after # explode, exit,arrival......is_return , result -all  after ? */
                            $arr_time = explode('?', $arr_mark[1]);

                            /* all  after ? explode.  exit,arrival......is_return */
                            $each_time = explode('&', $arr_time[1]);

                            $t_exit = $each_time[0];
                            $t_arrival = $each_time[1];
                            $t_follow = $each_time[2];
                            $t_end = $each_time[3];
                            $t_return = $each_time[4];
                            $t_distance = $each_time[5];
                            $t_is_return = ($each_time[6] == 0) ? 'нет' : 'да';

                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $mark);
                            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
                            $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да' : 'нет'));
                            $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end == '-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
                            $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return == '-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
                            $sheet->setCellValue('O' . $r, $t_distance);
                            $sheet->setCellValue('P' . $r, $t_is_return);

                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content3') {//informing
                foreach ($result as $row) {

                    $arr = explode('~', $row['informing']);

                    foreach ($arr as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_fio = explode('#', $value);
                            /* fio - before # */
                            $fio = $arr_fio[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_fio[1]);

                            $t_msg = $each_time[0];
                            $t_exit = $each_time[1];
                            $t_arrival = $each_time[2];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $fio);
                            $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));


                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content4') {//innerservice
                $i = 0;
                foreach ($result as $row) {

                    $arr = explode('~', $row['innerservice']);

                    foreach ($arr as $value) {

                        if (!empty($value)) {
                            $i++;
                            $arr_name = explode('#', $value);
                            /* fio - before # */
                            $service_name = $arr_name[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_name[1]);

                            $t_msg = $each_time[0];
                            $t_arrival = $each_time[1];

                            $note = explode('%', $each_time[2]);

                            $t_distance = $note[0];
                            $t_note = $note[1];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('I' . $r, $service_name);
                            $sheet->setCellValue('J' . $r, $t_distance);
                            $sheet->setCellValue('K' . $r, $t_note);

                            $r++;
                        }
                    }
                }

                $sheet->getStyleByColumnAndRow(0, 8, 10, $r - 1)->applyFromArray($styleArray);
            }
        }

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="archive.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });



    /* teh info */
    $app->get('/exportExcelTab2/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/:time_loc/:time_likv/:is_likv_before_arrival', function ($id_tab, $table, $date_from, $date_to, $reg, $loc, $reasonrig_form, $id_rig, $date_msg, $time_msg, $local_1, $addr, $time_loc, $time_likv, $is_likv_before_arrival) use ($app) {

        $main_m = new Model_Main();

        /* get data */
        $date_start = $date_from;
        $date_end = $date_to;
        $table_name_year = $y=$table;
        $region = $reg;
        $local = $loc;

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;
//var_dump($region);
        if ($region != 'no') {
            // echo 'uuuuuu';
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }

        if ($local != 'no') {

            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }

        if ($reasonrig_form != 'no') {

            $sql = $sql . ' AND reasonrig_name =  "' . $reasonrig_form . '"';
            //$param[] = $local;
        }

        /* --------------- filter from datatables ------------- */
        if ($id_rig != 'no') {
            $sql = $sql . ' AND ( id_rig like "%' . $id_rig . '" OR id_rig like "' . $id_rig . '%" OR id_rig like "%' . $id_rig . '%"  ) ';
        }
        if ($date_msg != 'no') {
            $sql = $sql . ' AND ( date_msg like "%' . $date_msg . '" OR date_msg like "' . $date_msg . '%" OR date_msg like "%' . $date_msg . '%"  ) ';
        }
        if ($time_msg != 'no') {
            $sql = $sql . ' AND ( time_msg like "%' . $time_msg . '" OR time_msg like "' . $time_msg . '%" OR time_msg like "%' . $time_msg . '%"  ) ';
        }
        if ($local_1 != 'no') {
            $sql = $sql . ' AND ( local_name like "%' . $local_1 . '" OR local_name like "' . $local_1 . '%" OR local_name like "%' . $local_1 . '%"  ) ';
        }
        if ($addr != 'no') {
            $sql = $sql . ' AND ( address like "%' . $addr . '" OR address like "' . $addr . '%" OR address like "%' . $addr . '%"  ) ';
        }

        if ($time_loc != 'no') {
            $sql = $sql . ' AND ( time_loc like "%' . $time_loc . '" OR time_loc like "' . $time_loc . '%" OR time_loc like "%' . $time_loc . '%"  ) ';
        }
        if ($time_likv != 'no') {
            $sql = $sql . ' AND ( time_likv like "%' . $time_likv . '" OR time_likv like "' . $time_likv . '%" OR time_likv like "%' . $time_likv . '%"  ) ';
        }
        if ($is_likv_before_arrival != 'no') {

            $is_likv = ($is_likv_before_arrival == 'нет') ? 0 : 1;

            $sql = $sql . ' AND is_likv_before_arrival = ?';
            $param[] = $is_likv;
        }

        /* --------------- END filter from datatables ------------- */


        $sql = $sql . ' ORDER BY id_rig ASC';

        if ($id_tab == 'table-content1') {//rig
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv ' . $sql;
        } elseif ($id_tab == 'table-content2') {//technic mchs
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs ' . $sql;
        } elseif ($id_tab == 'table-content3') {//informing
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, informing ' . $sql;
        } elseif ($id_tab == 'table-content4') {//innerservice
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, innerservice ' . $sql;
        }


        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);
            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $result = $sth->fetchAll();
        } else {
            $result = R::getAll($sql, $param);
        }

//$cnt_result=count($result);
//echo $sql;
//print_r($param);
//echo $cnt_result;
//exit();

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/archive/' . $id_tab . '.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //strначальная строка для записи
        $c = 0; // stolbec начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . date('d.m.Y', strtotime($date_start)) . ' по ' . date('d.m.Y', strtotime($date_end))); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no') ? $region : 'все') . ', район: ' . (($local != 'no') ? $local : 'все') . ', причина вызова: ' . (($reasonrig_form != 'no') ? $reasonrig_form : 'все')); //выбранный область и район

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (!empty($result)) {
            if ($id_tab == 'table-content1') {//rig
                foreach ($result as $row) {
                    $i++;

                    $sheet->setCellValue('A' . $r, $i); //№ п/п
                    $sheet->setCellValue('B' . $r, $row['id_rig']);
                    $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                    $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                    $sheet->setCellValue('E' . $r, $row['local_name']);
                    $sheet->setCellValue('F' . $r, $row['address']);
                    $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
                    $sheet->setCellValue('H' . $r, $row['view_work']);
                    $sheet->setCellValue('I' . $r, $row['inf_detail']);
                    $sheet->setCellValue('J' . $r, $row['people']);
                    $sheet->setCellValue('K' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                    $sheet->setCellValue('L' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));


                    $r++;
                }



                $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content2') {//technic mchs
                $i = 0;
                foreach ($result as $row) {
                    $arr_silymchs = explode('~', $row['silymchs']);

                    foreach ($arr_silymchs as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_mark = explode('#', $value);

                            $mark = $arr_mark[0];

                            /* all after # explode, exit,arrival......is_return , result -all  after ? */
                            $arr_time = explode('?', $arr_mark[1]);

                            /* all  after ? explode.  exit,arrival......is_return */
                            $each_time = explode('&', $arr_time[1]);

                            $t_exit = $each_time[0];
                            $t_arrival = $each_time[1];
                            $t_follow = $each_time[2];
                            $t_end = $each_time[3];
                            $t_return = $each_time[4];
                            $t_distance = $each_time[5];
                            $t_is_return = ($each_time[6] == 0) ? 'нет' : 'да';

                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $mark);
                            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
                            $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да' : 'нет'));
                            $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end == '-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
                            $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return == '-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
                            $sheet->setCellValue('O' . $r, $t_distance);
                            $sheet->setCellValue('P' . $r, $t_is_return);

                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content3') {//informing
                foreach ($result as $row) {

                    $arr = explode('~', $row['informing']);

                    foreach ($arr as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_fio = explode('#', $value);
                            /* fio - before # */
                            $fio = $arr_fio[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_fio[1]);

                            $t_msg = $each_time[0];
                            $t_exit = $each_time[1];
                            $t_arrival = $each_time[2];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $fio);
                            $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));


                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content4') {//innerservice
                $i = 0;
                foreach ($result as $row) {

                    $arr = explode('~', $row['innerservice']);

                    foreach ($arr as $value) {

                        if (!empty($value)) {
                            $i++;
                            $arr_name = explode('#', $value);
                            /* fio - before # */
                            $service_name = $arr_name[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_name[1]);

                            $t_msg = $each_time[0];
                            $t_arrival = $each_time[1];

                            $note = explode('%', $each_time[2]);

                            $t_distance = $note[0];
                            $t_note = $note[1];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('I' . $r, $service_name);
                            $sheet->setCellValue('J' . $r, $t_distance);
                            $sheet->setCellValue('K' . $r, $t_note);

                            $r++;
                        }
                    }
                }

                $sheet->getStyleByColumnAndRow(0, 8, 10, $r - 1)->applyFromArray($styleArray);
            }
        }

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="archive.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });



    /* informing info */
    $app->get('/exportExcelTab3/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab, $table, $date_from, $date_to, $reg, $loc, $reasonrig_form, $id_rig, $date_msg, $time_msg, $local_1, $addr) use ($app) {

        $main_m = new Model_Main();

        /* get data */
        $date_start = $date_from;
        $date_end = $date_to;
        $table_name_year = $y= $table;
        $region = $reg;
        $local = $loc;

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;
//var_dump($region);
        if ($region != 'no') {
            // echo 'uuuuuu';
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }

        if ($local != 'no') {

            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }

        if ($reasonrig_form != 'no') {

            $sql = $sql . ' AND reasonrig_name =  "' . $reasonrig_form . '"';
            //$param[] = $local;
        }


        /* --------------- filter from datatables ------------- */
        if ($id_rig != 'no') {
            $sql = $sql . ' AND ( id_rig like "%' . $id_rig . '" OR id_rig like "' . $id_rig . '%" OR id_rig like "%' . $id_rig . '%"  ) ';
        }
        if ($date_msg != 'no') {
            $sql = $sql . ' AND ( date_msg like "%' . $date_msg . '" OR date_msg like "' . $date_msg . '%" OR date_msg like "%' . $date_msg . '%"  ) ';
        }
        if ($time_msg != 'no') {
            $sql = $sql . ' AND ( time_msg like "%' . $time_msg . '" OR time_msg like "' . $time_msg . '%" OR time_msg like "%' . $time_msg . '%"  ) ';
        }
        if ($local_1 != 'no') {
            $sql = $sql . ' AND ( local_name like "%' . $local_1 . '" OR local_name like "' . $local_1 . '%" OR local_name like "%' . $local_1 . '%"  ) ';
        }
        if ($addr != 'no') {
            $sql = $sql . ' AND ( address like "%' . $addr . '" OR address like "' . $addr . '%" OR address like "%' . $addr . '%"  ) ';
        }


        /* --------------- END filter from datatables ------------- */


        $sql = $sql . ' ORDER BY id_rig ASC';

        if ($id_tab == 'table-content1') {//rig
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv ' . $sql;
        } elseif ($id_tab == 'table-content2') {//technic mchs
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs ' . $sql;
        } elseif ($id_tab == 'table-content3') {//informing
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, informing ' . $sql;
        } elseif ($id_tab == 'table-content4') {//innerservice
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, innerservice ' . $sql;
        }


        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);

            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $result = $sth->fetchAll();
        } else {
           $result = R::getAll($sql, $param);
        }


//$cnt_result=count($result);
//echo $sql;
//print_r($param);
//echo $cnt_result;
//exit();

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/archive/' . $id_tab . '.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //strначальная строка для записи
        $c = 0; // stolbec начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . date('d.m.Y', strtotime($date_start)) . ' по ' . date('d.m.Y', strtotime($date_end))); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no') ? $region : 'все') . ', район: ' . (($local != 'no') ? $local : 'все') . ', причина вызова: ' . (($reasonrig_form != 'no') ? $reasonrig_form : 'все')); //выбранный область и район

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (!empty($result)) {
            if ($id_tab == 'table-content1') {//rig
                foreach ($result as $row) {
                    $i++;

                    $sheet->setCellValue('A' . $r, $i); //№ п/п
                    $sheet->setCellValue('B' . $r, $row['id_rig']);
                    $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                    $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                    $sheet->setCellValue('E' . $r, $row['local_name']);
                    $sheet->setCellValue('F' . $r, $row['address']);
                    $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
                    $sheet->setCellValue('H' . $r, $row['view_work']);
                    $sheet->setCellValue('I' . $r, $row['inf_detail']);
                    $sheet->setCellValue('J' . $r, $row['people']);
                    $sheet->setCellValue('K' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                    $sheet->setCellValue('L' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));


                    $r++;
                }



                $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content2') {//technic mchs
                $i = 0;
                foreach ($result as $row) {
                    $arr_silymchs = explode('~', $row['silymchs']);

                    foreach ($arr_silymchs as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_mark = explode('#', $value);

                            $mark = $arr_mark[0];

                            /* all after # explode, exit,arrival......is_return , result -all  after ? */
                            $arr_time = explode('?', $arr_mark[1]);

                            /* all  after ? explode.  exit,arrival......is_return */
                            $each_time = explode('&', $arr_time[1]);

                            $t_exit = $each_time[0];
                            $t_arrival = $each_time[1];
                            $t_follow = $each_time[2];
                            $t_end = $each_time[3];
                            $t_return = $each_time[4];
                            $t_distance = $each_time[5];
                            $t_is_return = ($each_time[6] == 0) ? 'нет' : 'да';

                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $mark);
                            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
                            $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да' : 'нет'));
                            $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end == '-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
                            $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return == '-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
                            $sheet->setCellValue('O' . $r, $t_distance);
                            $sheet->setCellValue('P' . $r, $t_is_return);

                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content3') {//informing
                foreach ($result as $row) {

                    $arr = explode('~', $row['informing']);

                    foreach ($arr as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_fio = explode('#', $value);
                            /* fio - before # */
                            $fio = $arr_fio[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_fio[1]);

                            $t_msg = $each_time[0];
                            $t_exit = $each_time[1];
                            $t_arrival = $each_time[2];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $fio);
                            $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));


                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content4') {//innerservice
                $i = 0;
                foreach ($result as $row) {

                    $arr = explode('~', $row['innerservice']);

                    foreach ($arr as $value) {

                        if (!empty($value)) {
                            $i++;
                            $arr_name = explode('#', $value);
                            /* fio - before # */
                            $service_name = $arr_name[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_name[1]);

                            $t_msg = $each_time[0];
                            $t_arrival = $each_time[1];

                            $note = explode('%', $each_time[2]);

                            $t_distance = $note[0];
                            $t_note = $note[1];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('I' . $r, $service_name);
                            $sheet->setCellValue('J' . $r, $t_distance);
                            $sheet->setCellValue('K' . $r, $t_note);

                            $r++;
                        }
                    }
                }

                $sheet->getStyleByColumnAndRow(0, 8, 10, $r - 1)->applyFromArray($styleArray);
            }
        }

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="archive.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });



    /* innerservice info */
    $app->get('/exportExcelTab4/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab, $table, $date_from, $date_to, $reg, $loc, $reasonrig_form, $id_rig, $date_msg, $time_msg, $local_1, $addr) use ($app) {

        $main_m = new Model_Main();

        /* get data */
        $date_start = $date_from;
        $date_end = $date_to;
        $table_name_year = $y= $table;
        $region = $reg;
        $local = $loc;

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;
//var_dump($region);
        if ($region != 'no') {
            // echo 'uuuuuu';
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }

        if ($local != 'no') {

            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }


        if ($reasonrig_form != 'no') {

            $sql = $sql . ' AND reasonrig_name =  "' . $reasonrig_form . '"';
            //$param[] = $local;
        }


        /* --------------- filter from datatables ------------- */
        if ($id_rig != 'no') {
            $sql = $sql . ' AND ( id_rig like "%' . $id_rig . '" OR id_rig like "' . $id_rig . '%" OR id_rig like "%' . $id_rig . '%"  ) ';
        }
        if ($date_msg != 'no') {
            $sql = $sql . ' AND ( date_msg like "%' . $date_msg . '" OR date_msg like "' . $date_msg . '%" OR date_msg like "%' . $date_msg . '%"  ) ';
        }
        if ($time_msg != 'no') {
            $sql = $sql . ' AND ( time_msg like "%' . $time_msg . '" OR time_msg like "' . $time_msg . '%" OR time_msg like "%' . $time_msg . '%"  ) ';
        }
        if ($local_1 != 'no') {
            $sql = $sql . ' AND ( local_name like "%' . $local_1 . '" OR local_name like "' . $local_1 . '%" OR local_name like "%' . $local_1 . '%"  ) ';
        }
        if ($addr != 'no') {
            $sql = $sql . ' AND ( address like "%' . $addr . '" OR address like "' . $addr . '%" OR address like "%' . $addr . '%"  ) ';
        }


        /* --------------- END filter from datatables ------------- */


        $sql = $sql . ' ORDER BY id_rig ASC';

        if ($id_tab == 'table-content1') {//rig
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv ' . $sql;
        } elseif ($id_tab == 'table-content2') {//technic mchs
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs ' . $sql;
        } elseif ($id_tab == 'table-content3') {//informing
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, informing ' . $sql;
        } elseif ($id_tab == 'table-content4') {//innerservice
            $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, innerservice ' . $sql;
        }



        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);

            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $result = $sth->fetchAll();
        } else {
            $result = R::getAll($sql, $param);
        }

//$cnt_result=count($result);
//echo $sql;
//print_r($param);
//echo $cnt_result;
//exit();

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/archive/' . $id_tab . '.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //strначальная строка для записи
        $c = 0; // stolbec начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . date('d.m.Y', strtotime($date_start)) . ' по ' . date('d.m.Y', strtotime($date_end))); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no') ? $region : 'все') . ', район: ' . (($local != 'no') ? $local : 'все') . ', причина вызова: ' . (($reasonrig_form != 'no') ? $reasonrig_form : 'все')); //выбранный область и район

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (!empty($result)) {
            if ($id_tab == 'table-content1') {//rig
                foreach ($result as $row) {
                    $i++;

                    $sheet->setCellValue('A' . $r, $i); //№ п/п
                    $sheet->setCellValue('B' . $r, $row['id_rig']);
                    $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                    $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                    $sheet->setCellValue('E' . $r, $row['local_name']);
                    $sheet->setCellValue('F' . $r, $row['address']);
                    $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
                    $sheet->setCellValue('H' . $r, $row['view_work']);
                    $sheet->setCellValue('I' . $r, $row['inf_detail']);
                    $sheet->setCellValue('J' . $r, $row['people']);
                    $sheet->setCellValue('K' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                    $sheet->setCellValue('L' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));


                    $r++;
                }



                $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content2') {//technic mchs
                $i = 0;
                foreach ($result as $row) {
                    $arr_silymchs = explode('~', $row['silymchs']);

                    foreach ($arr_silymchs as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_mark = explode('#', $value);

                            $mark = $arr_mark[0];

                            /* all after # explode, exit,arrival......is_return , result -all  after ? */
                            $arr_time = explode('?', $arr_mark[1]);

                            /* all  after ? explode.  exit,arrival......is_return */
                            $each_time = explode('&', $arr_time[1]);

                            $t_exit = $each_time[0];
                            $t_arrival = $each_time[1];
                            $t_follow = $each_time[2];
                            $t_end = $each_time[3];
                            $t_return = $each_time[4];
                            $t_distance = $each_time[5];
                            $t_is_return = ($each_time[6] == 0) ? 'нет' : 'да';

                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $mark);
                            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
                            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv'] == '-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
                            $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да' : 'нет'));
                            $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end == '-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
                            $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return == '-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
                            $sheet->setCellValue('O' . $r, $t_distance);
                            $sheet->setCellValue('P' . $r, $t_is_return);

                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content3') {//informing
                foreach ($result as $row) {

                    $arr = explode('~', $row['informing']);

                    foreach ($arr as $value) {
                        if (!empty($value)) {
                            $i++;
                            $arr_fio = explode('#', $value);
                            /* fio - before # */
                            $fio = $arr_fio[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_fio[1]);

                            $t_msg = $each_time[0];
                            $t_exit = $each_time[1];
                            $t_arrival = $each_time[2];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $fio);
                            $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                            $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));


                            $r++;
                        }
                    }
                }
                $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
            } elseif ($id_tab == 'table-content4') {//innerservice
                $i = 0;
                foreach ($result as $row) {

                    $arr = explode('~', $row['innerservice']);

                    foreach ($arr as $value) {

                        if (!empty($value)) {
                            $i++;
                            $arr_name = explode('#', $value);
                            /* fio - before # */
                            $service_name = $arr_name[0];

                            /* all  after # explode. time_msg,time_exit.... */
                            $each_time = explode('&', $arr_name[1]);

                            $t_msg = $each_time[0];
                            $t_arrival = $each_time[1];

                            $note = explode('%', $each_time[2]);

                            $t_distance = $note[0];
                            $t_note = $note[1];


                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, (date('d.m.Y', strtotime($row['date_msg']))));
                            $sheet->setCellValue('D' . $r, (date('H:i', strtotime($row['time_msg']))));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg == '-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                            $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival == '-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
                            $sheet->setCellValue('I' . $r, $service_name);
                            $sheet->setCellValue('J' . $r, $t_distance);
                            $sheet->setCellValue('K' . $r, $t_note);

                            $r++;
                        }
                    }
                }

                $sheet->getStyleByColumnAndRow(0, 8, 10, $r - 1)->applyFromArray($styleArray);
            }
        }

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="archive.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });


    /* results battle */
    $app->get('/exportExcelTab5/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab, $table, $date_from, $date_to, $reg, $loc, $reasonrig_form, $id_rig, $date_msg, $time_msg, $local_1, $addr) use ($app) {

        $main_m = new Model_Main();

        /* get data */
        $date_start = $date_from;
        $date_end = $date_to;
        $table_name_year = $y= $table;
        $region = $reg;
        $local = $loc;

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;
//var_dump($region);
        if ($region != 'no') {
            // echo 'uuuuuu';
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }

        if ($local != 'no') {

            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }

        if ($reasonrig_form != 'no') {

            $sql = $sql . ' AND reasonrig_name =  "' . $reasonrig_form . '"';
            //$param[] = $local;
        }



        /* --------------- filter from datatables ------------- */
        if ($id_rig != 'no') {
            $sql = $sql . ' AND ( id_rig like "%' . $id_rig . '" OR id_rig like "' . $id_rig . '%" OR id_rig like "%' . $id_rig . '%"  ) ';
        }
        if ($date_msg != 'no') {
            $sql = $sql . ' AND ( date_msg like "%' . $date_msg . '" OR date_msg like "' . $date_msg . '%" OR date_msg like "%' . $date_msg . '%"  ) ';
        }
        if ($time_msg != 'no') {
            $sql = $sql . ' AND ( time_msg like "%' . $time_msg . '" OR time_msg like "' . $time_msg . '%" OR time_msg like "%' . $time_msg . '%"  ) ';
        }
        if ($local_1 != 'no') {
            $sql = $sql . ' AND ( local_name like "%' . $local_1 . '" OR local_name like "' . $local_1 . '%" OR local_name like "%' . $local_1 . '%"  ) ';
        }
        if ($addr != 'no') {
            $sql = $sql . ' AND ( address like "%' . $addr . '" OR address like "' . $addr . '%" OR address like "%' . $addr . '%"  ) ';
        }


        /* --------------- END filter from datatables ------------- */


        $sql = $sql . ' ORDER BY id_rig ASC';

        $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, results_battle, rb_chapter_1,rb_chapter_2,rb_chapter_3 ' . $sql;


        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);

            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $result = $sth->fetchAll();
        } else {
            $result = R::getAll($sql, $param);
        }


//$cnt_result=count($result);
//echo $sql;
//print_r($param);
//echo $cnt_result;
//exit();

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/archive/' . $id_tab . '.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //strначальная строка для записи
        $c = 0; // stolbec начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . date('d.m.Y', strtotime($date_start)) . ' по ' . date('d.m.Y', strtotime($date_end))); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no') ? $region : 'все') . ', район: ' . (($local != 'no') ? $local : 'все') . ', причина вызова: ' . (($reasonrig_form != 'no') ? $reasonrig_form : 'все')); //выбранный область и район

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (!empty($result)) {



            foreach ($result as $row) {

                $res_battle = array();
                $res_battle = explode('#', $row['results_battle']);

                if (isset($res_battle) && !empty($res_battle) && count($res_battle) > 1 && max($res_battle) > 0) {
                    $i++;

                    $sheet->setCellValue('A' . $r, $i); //№ п/п
                    $sheet->setCellValue('B' . $r, $row['id_rig']);
                    $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                    $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                    $sheet->setCellValue('E' . $r, $row['local_name']);
                    $sheet->setCellValue('F' . $r, $row['address']);
                    $sheet->setCellValue('G' . $r, $res_battle[0]);
                    $sheet->setCellValue('H' . $r, $res_battle[1]);
                    $sheet->setCellValue('I' . $r, $res_battle[2]);
                    $sheet->setCellValue('J' . $r, $res_battle[3]);
                    $sheet->setCellValue('K' . $r, $res_battle[4]);
                    $sheet->setCellValue('L' . $r, $res_battle[5]);
                    $sheet->setCellValue('M' . $r, $res_battle[6]);
                    $sheet->setCellValue('N' . $r, $res_battle[7]);
                    $sheet->setCellValue('O' . $r, $res_battle[8]);
                    $sheet->setCellValue('P' . $r, $res_battle[9]);
                    $sheet->setCellValue('Q' . $r, $res_battle[10]);
                    $sheet->setCellValue('R' . $r, $res_battle[11]);
                    $sheet->setCellValue('S' . $r, $res_battle[12]);
                    $sheet->setCellValue('T' . $r, $res_battle[13]);
                    $sheet->setCellValue('U' . $r, $res_battle[14]);
                    $sheet->setCellValue('V' . $r, $res_battle[15]);
                    $sheet->setCellValue('W' . $r, $res_battle[16]);

                    $r++;
                }
            }



            $sheet->getStyleByColumnAndRow(0, 8, 22, $r - 1)->applyFromArray($styleArray);
        }

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Архив_результ.боевой работы.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });


    /* trunk */
    $app->get('/exportExcelTab6/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab, $table, $date_from, $date_to, $reg, $loc, $reasonrig_form, $id_rig, $date_msg, $time_msg, $local_1, $addr) use ($app) {

        $main_m = new Model_Main();

        /* get data */
        $date_start = $date_from;
        $date_end = $date_to;
        $table_name_year = $y= $table;
        $region = $reg;
        $local = $loc;

        /* from 06:00:00 till 06:00:00 */
        $sql = ' FROM jarchive.' . $table_name_year . '  WHERE date_msg between ? and ? and id_rig not in '
            . '  ( SELECT id_rig FROM jarchive.' . $table_name_year . ' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
        //  $param[]=0;
//var_dump($region);
        if ($region != 'no') {
            // echo 'uuuuuu';
            // $sql=$sql.' AND region_name like ?';
            $sql = $sql . ' AND region_name = ?';
            $param[] = $region;
        }

        if ($local != 'no') {

            $sql = $sql . ' AND ( local_name like "' . $local . '" OR local_name like "' . $local . '%" ) ';
            //$param[] = $local;
        }

        if ($reasonrig_form != 'no') {

            $sql = $sql . ' AND reasonrig_name =  "' . $reasonrig_form . '"';
            //$param[] = $local;
        }



        /* --------------- filter from datatables ------------- */
        if ($id_rig != 'no') {
            $sql = $sql . ' AND ( id_rig like "%' . $id_rig . '" OR id_rig like "' . $id_rig . '%" OR id_rig like "%' . $id_rig . '%"  ) ';
        }
        if ($date_msg != 'no') {
            $sql = $sql . ' AND ( date_msg like "%' . $date_msg . '" OR date_msg like "' . $date_msg . '%" OR date_msg like "%' . $date_msg . '%"  ) ';
        }
        if ($time_msg != 'no') {
            $sql = $sql . ' AND ( time_msg like "%' . $time_msg . '" OR time_msg like "' . $time_msg . '%" OR time_msg like "%' . $time_msg . '%"  ) ';
        }
        if ($local_1 != 'no') {
            $sql = $sql . ' AND ( local_name like "%' . $local_1 . '" OR local_name like "' . $local_1 . '%" OR local_name like "%' . $local_1 . '%"  ) ';
        }
        if ($addr != 'no') {
            $sql = $sql . ' AND ( address like "%' . $addr . '" OR address like "' . $addr . '%" OR address like "%' . $addr . '%"  ) ';
        }


        /* --------------- END filter from datatables ------------- */


        $sql = $sql . ' ORDER BY id_rig ASC';

        $sql = 'SELECT id_rig,date_msg,time_msg, local_name,address, trunk ' . $sql;



        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);

            $sth = $pdo->prepare($sql);
            $sth->execute($param);
            $result = $sth->fetchAll();
        } else {
            $result = R::getAll($sql, $param);
        }


//$cnt_result=count($result);
//echo $sql;
//print_r($param);
//echo $cnt_result;
//exit();

        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/archive/' . $id_tab . '.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();

        $r = 9; //strначальная строка для записи
        $c = 0; // stolbec начальный столбец для записи

        $i = 0; //счетчик кол-ва записей № п/п


        $sheet->setCellValue('A2', 'с ' . date('d.m.Y', strtotime($date_start)) . ' по ' . date('d.m.Y', strtotime($date_end))); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no') ? $region : 'все') . ', район: ' . (($local != 'no') ? $local : 'все') . ', причина вызова: ' . (($reasonrig_form != 'no') ? $reasonrig_form : 'все')); //выбранный область и район

        /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (!empty($result)) {



            foreach ($result as $row) {



                $arr_trunk = explode('~', $row['trunk']);

                if (isset($arr_trunk) && !empty($arr_trunk)) {
                    $i++;

                    foreach ($arr_trunk as $value) {
                        if (!empty($value)) {

                            /* mark#numsign$locorg_name%pasp_name?time_pod&trunk_name&cnt&water~mark#...... */
                            $arr_mark = explode('#', $value);

                            $mark = $arr_mark[0];


                            $arr_time = explode('?', $arr_mark[1]);

                            /* numsign$locorg_name%pasp_name */
                            $car = $arr_time[0];
                            $car_detail = explode('$', $car);
                            $numbsign = $car_detail[0];

                            $grochs_detail = explode('%', $car_detail[1]);
                            $locorg_name = $grochs_detail[0];
                            $pasp_name = $grochs_detail[1];


                            /* all  after ? explode.  time_pod, trunk_name, cnt, water */
                            $each_time = explode('&', $arr_time[1]);

                            $time_pod = $each_time[0];
                            $trunk_name = $each_time[1];
                            $cnt = $each_time[2];
                            $water = $each_time[3];



                            $sheet->setCellValue('A' . $r, $i); //№ п/п
                            $sheet->setCellValue('B' . $r, $row['id_rig']);
                            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
                            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
                            $sheet->setCellValue('E' . $r, $row['local_name']);
                            $sheet->setCellValue('F' . $r, $row['address']);
                            $sheet->setCellValue('G' . $r, $mark);
                            $sheet->setCellValue('H' . $r, $numbsign);
                            $sheet->setCellValue('I' . $r, ($locorg_name . ', ' . $pasp_name));
                            $sheet->setCellValue('J' . $r, $time_pod);
                            $sheet->setCellValue('K' . $r, $trunk_name);
                            $sheet->setCellValue('L' . $r, $cnt);
                            $sheet->setCellValue('M' . $r, $water);


                            $r++;
                        }
                    }
                }
            }



            $sheet->getStyleByColumnAndRow(0, 8, 12, $r - 1)->applyFromArray($styleArray);
        }

        /* Сохранить в файл */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Архив_стволы.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });





    /* search by id rig */

    $app->get('/search_form', function () use ($app) {

        $main_m = new Model_Main();

        $bread_crumb = array('Архив', 'Поиск по ID выезда');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Архив.Поиск по ID выезда';



        /*         * *** Классификаторы **** */
        // $region = new Model_Region();


        $name_oblast[1] = 'Брестская область';
        $name_oblast[2] = 'Витебская область';
        $name_oblast[3] = 'г. Минск';
        $name_oblast[4] = 'Гомельская область';
        $name_oblast[5] = 'Гродненская область';
        $name_oblast[6] = 'Минская область';
        $name_oblast[7] = 'Могилевская область';

        $data['region'] = $name_oblast; //области



        $archive_m = new Model_Archivedate();
        $data['archive_date'] = $archive_m->selectAll();
        //$archive_year_m = new Model_Archiveyear();
        // $data['archive_year'] = $archive_year_m->selectAll();
        //$data['archive_year'] = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');
        //$archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');

        $archive_year = ARCHIVE_YEAR;

        foreach ($archive_year as $value) {

            $y = $value['table_name'];

            $real_server = $main_m->get_js_connect(substr($y, 0, -1));
            if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
                $pdo = get_pdo_15($real_server);

                $sth = $pdo->prepare("SELECT MAX(a.date_msg) as max_date FROM " . $value['table_name'] . " as a ");
                $sth->execute();
                $value['max_date'] = $sth->fetchColumn();
                $archive_year_1[] = $value;
            } else {
                $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
                $archive_year_1[] = $value;
            }
        }
        $data['archive_year'] = $archive_year_1;

        /*         * *** КОНЕЦ Классификаторы **** */


        // $isset_date = $archive_m->selectAll();//какие архивы уже сделаны
        // $isset_year = $archive_year_m->selectAll();//какие года есть в БД


        $app->render('layouts/archive/header.php', $data);
        $data['path_to_view'] = 'archive_1/search/form_search.php';
        $app->render('layouts/archive/div_wrapper.php', $data);
        $app->render('layouts/archive/footer.php');
    });


    /* search from archive */
    $app->post('/search/rig', function () use ($app) {

        $main_m = new Model_Main();

        /* select data from bd. */
        $id_rig = $app->request()->post('id_rig');
        $table_name_year = $y= $app->request()->post('archive_year');

        $data = getCardByIdRig($table_name_year, $id_rig);



        $bread_crumb = array('Архив', 'Поиск по ID выезда');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Архив.Поиск по ID выезда';


        if (empty($data['result'])) {//no results
            $data['result_search_empty'] = 1;

            //$archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');
            $archive_year = ARCHIVE_YEAR;
            foreach ($archive_year as $value) {

                $y = $value['table_name'];
                $real_server = $main_m->get_js_connect(substr($y, 0, -1));
                if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
                    $pdo = get_pdo_15($real_server);

                    $sth = $pdo->prepare("SELECT MAX(a.date_msg) as max_date FROM " . $value['table_name'] . " as a ");
                    $sth->execute();
                    $value['max_date'] = $sth->fetchColumn();
                    $archive_year_1[] = $value;
                } else {
                    $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
                    $archive_year_1[] = $value;
                }
            }
            $data['archive_year'] = $archive_year_1;

            $app->render('layouts/archive/header.php', $data);
            $data['path_to_view'] = 'archive_1/search/form_search.php';
            $app->render('layouts/archive/div_wrapper.php', $data);
            $app->render('layouts/archive/footer.php');
        } else {
            $app->render('card_by_id_rig/id/card_by_id_rig.php', $data);
        }
    });

    /* END search by id rig */


    $app->post('/exclude_statistics', function () use ($app) {

        /* post data */
        $ids_delete = $app->request()->post('ids_delete');
        $ids = $app->request()->post('ids');
        $tbl = $app->request()->post('tbl_name');

        $cnt = 0; //cnt rigs with changes

        $helpers = new Model_Helpers();



        if (!empty($ids)) {
            $arr_ids = explode(',', $ids);
            foreach ($arr_ids as $element) {
                if (!empty($element) && $element != null) {
                    $new_array_ids[] = $element;
                }
            }

            if (!empty($new_array_ids)) {

                $res = R::getAll('select is_statistics from jarchive.' . $tbl . ' WHERE id_rig IN(' . implode(',', $new_array_ids) . ')');

                if (!empty($res)) {
                    foreach ($res as $row) {
                        if ($row['is_statistics'] != 1) {
                            $cnt++;
                        }
                    }
                }

                R::exec('UPDATE jarchive.' . $tbl . ' SET is_statistics = ? WHERE id_rig IN(' . implode(',', $new_array_ids) . ')', array(1));
            }
            //print_r($new_array_ids);
        }
        if (!empty($ids_delete)) {
            $arr_ids_delete = explode(',', $ids_delete);
            foreach ($arr_ids_delete as $element) {
                if (!empty($element) && $element != null) {
                    $new_array_ids_delete[] = $element;
                }
            }
            if (!empty($new_array_ids_delete)) {

                $res = R::getAll('select is_statistics from jarchive.' . $tbl . ' WHERE id_rig IN(' . implode(',', $new_array_ids_delete) . ')');
                if (!empty($res)) {
                    foreach ($res as $row) {
                        if ($row['is_statistics'] != 0) {
                            $cnt++;
                        }
                    }
                }

                R::exec('UPDATE jarchive.' . $tbl . ' SET is_statistics = ? WHERE id_rig IN(' . implode(',', $new_array_ids_delete) . ')', array(0));
            }
        }

        if ($cnt > 0) {

            $users_notif = R::getAll('select id from user where id_level = ? and can_edit = ? and is_admin = ?', array(1, 1, 1));


            if (!empty($users_notif)) {

                foreach ($users_notif as $value) {

                    $name = 'Внес пользователь: ' . $_SESSION['user_name'] . (($_SESSION['locorg_name'] != $_SESSION['user_name']) ? (', ' . $_SESSION['locorg_name']) : '') .
                        (($_SESSION['region_name'] != $_SESSION['user_name']) ? (', ' . (($_SESSION['id_region'] == 3) ? $_SESSION['region_name'] : ( $_SESSION['region_name'] . ' обл.'))) : '');

                    $notif['msg_show'] = 'Изменения в архиве: вкл./искл. выезда из статистики (затронуто <b>' . $cnt . ' ' . $helpers->declination_word_by_number($cnt, array('выезд', 'выезда', 'выездов')) . '</b>). ' . $name;
                    $notif['id_user'] = $value['id'];
                    $notif['is_see'] = 0;
                    $notif['date_action'] = $notif['date_insert'] = date('Y-m-d H:i:s');


                    if (!empty($notif)) {
                        $n = R::dispense('notifications');
                        $n->import($notif);
                        R::store($n);
                    }
                }
            }
        }
    });
});


$app->get('/no_permission', function () use ($app) {

    $bread_crumb = array('Архив', 'Параметры');
    $data['bread_crumb'] = $bread_crumb;
    $data['title'] = 'Журнал ЦОУ. Архив';


    $app->render('layouts/header.php', $data);
    $data['path_to_view'] = 'archive_1/no_permission.php';
    $app->render('layouts/div_wrapper.php', $data);
    $app->render('layouts/footer.php');
});
/* ------------------------- END  Archive Журнал ЦОУ ------------------------------- */


/* -------- card of rig by id - link from journal rigtable, from archive rigtable ------- */
$app->get('/card_rig/:year/:id_rig', function ($year, $id_rig) use ($app) {

    /* from bd */
    if (isset($year) && isset($id_rig)) {

        if ($year == 0) {//from journal
            $data = getCardByIdRigFromJournal($id_rig);
            //print_r($data);
            // exit();
        } else {//from archive
            $data = getCardByIdRig($year, $id_rig);
        }
    }



    $bread_crumb = array('Архив', 'Поиск по ID выезда');
    $data['bread_crumb'] = $bread_crumb;
    $data['title'] = 'Архив.Поиск по ID выезда';

    $data['no_btn_back'] = 1;


    if (isset($data['result']) && !empty($data['result'])) {
        $app->render('card_by_id_rig/id/card_by_id_rig.php', $data);
    } else {//no results
        $app->render('card_by_id_rig/id/empty_result.php', $data);
    }
});
/* ------ END card of rig by id - link from journal rigtable ------- */



/* ------------------------- diagram ------------------------------- */

$app->group('/diagram', 'is_login', function () use ($app, $log) {


    $app->get('/diag1', function () use ($app) {

        $data['title'] = 'Диаграммы/Диаграмма1';

        $bread_crumb = array('Диаграммы', 'Диаграмма1');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** Данные **** */
        $x = 0; //всего
        $y = 34; //причины выезда - пожар
        $z = 14; //drugie zagorania


        $umchs_vsego = R::getAssoc("CALL `diag1_umchs`('{$x}');");   //всего


        $umchs_fair = R::getAssoc("CALL `diag1_umchs`('{$y}');"); //пожары
        $data['umchs_fair'] = $umchs_fair;

        $umchs_other = R::getAssoc("CALL `diag1_umchs`('{$z}');"); //drugie zagorania
        $data['umchs_other'] = $umchs_other;

        foreach ($umchs_fair as $row) {
            $v = $row['vsego'];
            $id_region = $row['region_id'];
            $f[$id_region] = $v;
        }
        // print_r($f);echo '<br><br>';
        foreach ($umchs_vsego as $key => $row) {
            $v = $row['vsego'];
            $id_region = $row['region_id'];
            $umchs_vsego[$key]['end'] = $v - $f[$id_region];
        }
        $data['umchs_vsego'] = $umchs_vsego; //всего по областям
        //РОСН,УГЗ, АВИАЦИЯ
        $cp_vsego = R::getAssoc("CALL `diag1_cp`('{$x}');"); //всего


        $cp_fair = R::getAssoc("CALL `diag1_cp`('{$y}');"); //пожары
        $data['cp_fair'] = $cp_fair;

        $cp_other = R::getAssoc("CALL `diag1_cp`('{$z}');"); //drugie zagorania
        $data['cp_other'] = $cp_other;



        foreach ($cp_fair as $key => $row) {
            $v = $row['vsego'];
            $cp_f[$key] = $v;
        }
        //print_r($cp_f);echo '<br><br>';
        foreach ($cp_vsego as $key => $row) {
            $v = $row['vsego'];
            $cp_vsego[$key]['end'] = $v - $cp_f[$key];
        }
        //print_r($cp_vsego);exit();
        $data['cp_vsego'] = $cp_vsego; //всего по областям

        $min_d = R::getCell('SELECT MIN(r.`time_msg`) FROM rig AS r WHERE r.`time_msg` > "0000-00-00 00:00:00" and r.`is_delete`=0 '
                . 'and date_format(r.time_msg,"%Y") = ?', array(date('Y')));
        $max_d = R::getCell('SELECT MAX(r.`time_msg`) FROM rig AS r WHERE r.`time_msg`<=NOW() and r.`is_delete`=0');
        $data['min_d'] = $min_d;
        $data['max_d'] = $max_d;


        /*         * *** КОНЕЦ Данные **** */

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'diagram/diag1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

/* ------------------------- END diagram ------------------------------- */

/* ------------------------- chart ------------------------------- */

$app->group('/chart', 'is_login', function () use ($app, $log) {


    $app->get('/last_week', function () use ($app) {

        $data['title'] = 'Круговые диаграммы/Распределение выездов за текущую неделю в разрезе причин';

        $bread_crumb = array('Круговые диаграммы', 'Распределение выездов за текущую неделю в разрезе причин');
        $data['bread_crumb'] = $bread_crumb;


        $monday = date('Y-m-d', strtotime('monday this week'));
        $monday_next = date('Y-m-d', strtotime('monday next week'));


        $date1 = new DateTime($monday);
        $date1_f = $date1->Format('d.m.Y');

        $date2 = new DateTime($monday_next);
        $date2_f = $date2->Format('d.m.Y');

        $data['monday'] = $date1_f;
        $data['monday_next'] = $date2_f;


//$monday ='2018-12-01';
//$monday_prev = '2018-12-05';


        $cnt = R::getAssoc("CALL `cnt_reasonrig_by_period`('{$monday}','{$monday_next}');");
        $data['cnt'] = $cnt;



        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'diagram/chart/last_week.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

/* ------------------------- END chart ------------------------------- */


/* ------------------------- table_close_rigs ------------------------------- */

$app->group('/table_close_rigs', 'is_login', function () use ($app, $log) {


    $app->get('/', function () use ($app) {

        $data['title'] = 'Выезды за сутки';

        $bread_crumb = array('Выезды за сутки');
        $data['bread_crumb'] = $bread_crumb;


        $monday = date('Y-m-d', strtotime('monday this week'));
        $monday_next = date('Y-m-d', strtotime('monday next week'));


        $date1 = new DateTime($monday);
        $date1_f = $date1->Format('d.m.Y');

        $date2 = new DateTime($monday_next);
        $date2_f = $date2->Format('d.m.Y');

        $data['monday'] = $date1_f;
        $data['monday_next'] = $date2_f;

//$monday ='2018-12-01';
//$monday_prev = '2018-12-05';


        $date_start = date('Y-m-d');
        $date = new \DateTime();
        $date->modify('+1 day');
        $date_end = $date->format('Y-m-d');



        $rig_m = new Model_Rigtable();
        $rig_m->setStartEndDates($date_start, $date_end);

        $cp = array('РОСН' => 8, 'УГЗ' => 9, 'Авиация' => 12); //rosn, ugz,avia tabs

        $obl = array('Брестская область' => 1, 'Витебская область' => 2, 'Гомельская область' => 4, 'Гродненская область' => 5, 'г. Минск' => 3, 'Минская область' => 6, 'Могилевская область' => 7);

        $rigs = array();

        foreach ($obl as $key => $value) {

            $vsego = $rig_m->selectAllByIdRegion($value, 0, 0);
            $rigs[$value]['name'] = $key;
            $rigs[$value]['vsego'] = count($vsego); //without CP
            //print_r($vsego);            echo '<br><br>';
            //pogar
            $counts_1 = array_count_values(array_column($vsego, 'id_reasonrig'));

            $rigs[$value]['pogar'] = (isset($counts_1[34])) ? $counts_1[34] : 0;
            $rigs[$value]['hs'] = (isset($counts_1[73])) ? $counts_1[73] : 0;
            $rigs[$value]['uborka'] = (isset($counts_1[81])) ? $counts_1[81] : 0;
            $rigs[$value]['other'] = $rigs[$value]['vsego'] - $rigs[$value]['pogar'] - $rigs[$value]['hs'] - $rigs[$value]['uborka'];
        }

        foreach ($cp as $key => $value) {
            $vsego = $rig_m->selectAllByIdOrgan($value, 0); //for all organ


            $rigs[$value]['name'] = $key;
            $rigs[$value]['vsego'] = count($vsego); //without CP
            //pogar
            $counts_1 = array_count_values(array_column($vsego, 'id_reasonrig'));

            $rigs[$value]['pogar'] = (isset($counts_1[34])) ? $counts_1[34] : 0;
            $rigs[$value]['hs'] = (isset($counts_1[73])) ? $counts_1[73] : 0;
            $rigs[$value]['uborka'] = (isset($counts_1[81])) ? $counts_1[81] : 0;
            $rigs[$value]['other'] = $rigs[$value]['vsego'] - $rigs[$value]['pogar'] - $rigs[$value]['hs'] - $rigs[$value]['uborka'];
        }
        $data['rigs'] = $rigs;

        $itogo = array('vsego' => 0, 'pogar' => 0, 'hs' => 0, 'other' => 0, 'uborka' => 0);
        foreach ($rigs as $value) {
            $itogo['vsego'] += $value['vsego'];
            $itogo['pogar'] += $value['pogar'];
            $itogo['hs'] += $value['hs'];
            $itogo['uborka'] += $value['uborka'];
            $itogo['other'] += $value['other'];
        }
        $data['itogo'] = $itogo;
        //echo $counts_2;
//print_r($itogo);
        //exit();
        // print_r($rigs);exit();
        //$cnt = R::getAssoc("CALL `cnt_reasonrig_by_period`('{$monday}','{$monday_next}');");
        // $data['cnt'] = $cnt;
//exit();


        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'table_close_rigs/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

/* ------------------------- END table_close_rigs ------------------------------- */


/* --------------- export to csv ------------------- */

$app->group('/export/csv', 'is_login', function () use ($app, $log) {

    /* report 1: by date and vid of rig */
    $app->get('/:rep', function ($rep) use ($app) {

        $data['title'] = 'Экспорт в csv';

        $bread_crumb = array('Экспорт в csv');
        $data['bread_crumb'] = $bread_crumb;

        $data['export_csv_rep1'] = 1;

        $reasonrig = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig->selectAll(0);


        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'csv/export/form_rep1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    /* report 1: by date and vid of rig */
    $app->post('/:rep', function ($rep) use ($app) {

        $data['title'] = 'Экспорт в csv/Результат';

        $bread_crumb = array('Экспорт в csv/Результат');
        $data['bread_crumb'] = $bread_crumb;

        $data['export_csv_rep1'] = 1;


        $reasonrig = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig->selectAll(0);

        /* post date */
        $rig_m = new Model_Rigtable();
        $post_date = $rig_m->getPOSTData(); //даты для фильтра

        /* $post_id_reasonrig = (isset($_POST['id_reasonrig']) && !empty($_POST['id_reasonrig'])) ? $_POST['id_reasonrig'] : 0;
          if ($post_id_reasonrig != 0)
          $post_date['id_reasonrig'] = $post_id_reasonrig; */
        $post_id_reasonrig = array(14, 18, 33, 34, 38, 41, 70, 73, 74, 76, 78);
        $post_date['id_reasonrig'] = $post_id_reasonrig;


        /* vid for reasonrig */
        $reasonrig_vid = R::getAll('select * from reasonrig where id IN (' . implode(',', $post_id_reasonrig) . ')');

        $arr_vid = array();

        foreach ($reasonrig_vid as $value) {
            $arr_vid[$value['id']] = $value['vid'];
        }

        //print_r($arr_vid);
        $data['reasonrig_vid'] = $arr_vid;

        $post_limit = (isset($_POST['limit']) && !empty($_POST['limit'])) ? $_POST['limit'] : 0;
        $post_date['limit'] = $post_limit;


        $rigs = $rig_m->selectAllForCsv(0, $post_date); //all rigs
        // print_r($rigs);
        //exit();


        if (!empty($rigs)) {
            /* export to csv */
            $inf = array();
            foreach ($rigs as $row) {
                $reasonrig_name = trim(stristr($row['reasonrig_name'], ' '));

                $detail_1 = trim(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($row['inf_detail_1'])));
                $detail = substr($detail_1, 0, strrpos($detail_1, '.')) . '.'; //cut before last .

                if ($detail == '.') {
                    $detail_2 = trim(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($row['inf_detail_1'])));
                    $detail = trim(str_replace(array('"', "'", ";"), ' ', strip_tags($detail_2))) . '.';
                } else {
                    $detail = trim(str_replace(array('"', "'", ";"), ' ', strip_tags($detail)));
                }

                /* vid */
                $vid = (isset($arr_vid[$row['id_reasonrig']])) ? $arr_vid[$row['id_reasonrig']] : 0;
                $inf[] = array('lat' => $row['latitude'], 'lon' => $row['longitude'], 'date_msg' => date('d.m.Y', strtotime($row['date_msg'])), 'address' => $row['address'], 'inf_detail' => $detail, 'vid' => $vid);
            }
            // print_r($inf);exit();


            $csv = new ParseCsv\Csv('data.csv');
            # When saving,  write the header row:
            $csv->heading = TRUE;
            # Specify which columns to write, and in which order.
            # We won't output the 'Awesome' column this time.
            $csv->titles = ['lat', 'lon', 'date_msg', 'address', 'inf_detail', 'vid'];
            # Data to write:
//        $csv->data = [
//            0 => ['Name' => 'Anne', 'Age' => 45, 'Awesome' => true],
//            1 => ['Name' => 'John', 'Age' => 44, 'Awesome' => false],
//        ];

            $csv->delimiter = ";";
            $csv->data = $inf;
            //$path = $_SERVER['DOCUMENT_ROOT'] . '/out';
            $path = 'out';

            if ($csv->save($path . '/ex_jor.csv')) {
                $data['is_save'] = array('success', 'Выезды успешно сохранены в папку 172.26.200.14/www/out/. Имя файла ex_jor.csv. ');
            } else {
                $data['is_save'] = array('danger', 'Что-то пошло не так. ');
            }
        } else {
            $data['is_save'] = array('danger', 'Данные, удовлетворяющие запросу, отсутствуют. ');
        }


        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'csv/export/form_rep1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

function array2csv(array &$array)
{
    if (count($array) == 0) {
        return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv($df, array_keys(reset($array)));
    foreach ($array as $row) {
        fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
}
/* --------------- END export to csv ------------------- */



/* remark book */
$app->group('/remark', function () use ($app, $log) {


    $app->get('/', function () use ($app) {
       // echo 'В связи с проведением профилактических работ по информационной безопасности раздел временно закрыт';exit();
        $data['title'] = 'Книга замечаний';
        $data['upload_path']=UPLOAD_PATH;

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;

        $data['remarks'] = R::getAll('select r.*, t.name as type_user,t2.name as type_rcu_admin,
            s.name as status_rcu_admin, s.color as color_type_rcu, s.id as status_id  from remark as r
left join remark_type as t on t.id=r.type_user
left join remark_status as s on s.id=r.status_rcu_admin
left join  remark_type as t2 on t2.id=r.type_rcu_admin WHERE r.is_delete = ?', array(0));

        $data['max_date'] = R::getCell('select max(date_insert) from remark  ');


        $data['remark_type'] = R::getAll('select * from remark_type');
        $data['remark_status'] = R::getAll('select * from remark_status');

        $app->render('layouts/remark/header.php', $data);

        if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
            $data['path_to_view'] = 'remark/remark_rcu_admin.php';
        } else {
            $data['path_to_view'] = 'remark/remark.php';
        }

        if (!empty($data['remarks'])) {
            foreach ($data['remarks'] as $key => $value) {
                $data['remarks'][$key]['images_rcu'] = R::getAll('select * from remark_rcu_files  WHERE id_remark = ?', array($value['id']));
            }
        }


        if (isset($_SESSION['save_remark']) && $_SESSION['save_remark'] == 1) {
            $data['save_remark'] = 1;
            unset($_SESSION['save_remark']);
        }

        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php', $data);
    });


    $app->post('/', function () use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;


        $type_user = $app->request()->post('type_user');
        $type_rcu_admin = $app->request()->post('type_rcu_admin');
        $status_rcu_admin = $app->request()->post('status_rcu_admin');

        $is_delete = $app->request()->post('is_delete');

        $sql = 'select r.*, t.name as type_user,t2.name as type_rcu_admin,
            s.name as status_rcu_admin, s.color as color_type_rcu  from remark as r
left join remark_type as t on t.id=r.type_user
left join remark_status as s on s.id=r.status_rcu_admin
left join  remark_type as t2 on t2.id=r.type_rcu_admin WHERE  ';

        $param = array();

        $is_where = ' r.is_delete = ?  ';
        $param[] = $is_delete;


        if (!empty($type_user)) {
            $is_where = $is_where . ' AND r.type_user = ?  ';
            $param[] = $type_user;
        }
        if (!empty($type_rcu_admin)) {
            $is_where = $is_where . ' AND r.type_rcu_admin = ?  ';
            $param[] = $type_rcu_admin;
        }
        if (!empty($status_rcu_admin)) {
            $is_where = $is_where . ' AND r.status_rcu_admin = ?  ';
            $param[] = $status_rcu_admin;
        }


        if (!empty($is_where)) {
            $sql = $sql . $is_where;
        }


        $data['remarks'] = R::getAll($sql, $param);

        $data['max_date'] = R::getCell('select max(date_insert) from remark  ');


        $data['remark_type'] = R::getAll('select * from remark_type');
        $data['remark_status'] = R::getAll('select * from remark_status');

        $app->render('layouts/remark/header.php', $data);

        if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
            $data['path_to_view'] = 'remark/remark_rcu_admin.php';
        } else {
            $data['path_to_view'] = 'remark/remark.php';
        }



        if (!empty($data['remarks'])) {
            foreach ($data['remarks'] as $key => $value) {
                $data['remarks'][$key]['images_rcu'] = R::getAll('select * from remark_rcu_files  WHERE id_remark = ?', array($value['id']));
            }
        }



        if (isset($_SESSION['save_remark']) && $_SESSION['save_remark'] == 1) {
            $data['save_remark'] = 1;
            unset($_SESSION['save_remark']);
        }

        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');
    });



    $app->get('/remark_form', function () use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;


        $data['remark_type'] = R::getAll('select * from remark_type');
        $data['remark_status'] = R::getAll('select * from remark_status');

        $app->render('layouts/remark/header.php', $data);

        /* user journal is login */
        if (isset($_SESSION['id_user'])) {

            if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                $data['path_to_view'] = 'remark/remark_form_admin.php';
            } else {
                $data['path_to_view'] = 'remark/remark_form.php';
            }
        } elseif (isset($_SESSION['id_ghost'])) {
            $data['path_to_view'] = 'remark/remark_form.php';
        } else {
            $data['path_to_view'] = 'remark/remark_pre_form.php';
        }


        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');
    });

    /* edit form */
    $app->get('/edit_form/:id', function ($id) use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;


        $data['remark_type'] = R::getAll('select * from remark_type');
        $data['remark_status'] = R::getAll('select * from remark_status');
        $data['remark'] = R::getAll('select * from remark where id = ?', array($id));
        $data['id_remark'] = $id;

        $app->render('layouts/remark/header.php', $data);

        /* user is login */
        if (isset($_SESSION['id_user']) || isset($_SESSION['id_ghost'])) {

            if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                $data['path_to_view'] = 'remark/edit_form_rcu_admin.php';
            } else {
                $data['path_to_view'] = 'remark/edit_form.php';
            }
        } else {
            $app->redirect(BASE_URL . '/remark');
        }


        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');
    });


    $app->get('/auth/:sign', function ($sign) use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;

        $app->render('layouts/remark/header.php', $data);

        $data['remark_type'] = R::getAll('select * from remark_type');

        /*  login from journal  */
        if ($sign == 1) {
            $app->redirect(BASE_URL . '/remark/remark_login');
        }
        /*  login as ghost  */ else {
            /* login */
            $ghost = R::dispense('remarkghostsession');

            $array['name'] = 'Гость';
            $array['date_login'] = date("Y-m-d H:i:s");
            $ghost->import($array);
            $new_id = R::store($ghost);
            $_SESSION['id_ghost'] = $new_id;

            $data['path_to_view'] = 'remark/remark_form.php';
        }






        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');
    });



    // view form login
    $app->get('/remark_login', function () use ($app) {

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'remark/loginForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //log in
    $app->post('/remark_login', function () use ($app, $log) {

        /* ++ обработка POST-данных ++ */
        $login = ($app->request()->post('login') == '') ? NULL : $app->request()->post('login');
        $password = ($app->request()->post('password') == '') ? NULL : $app->request()->post('password');
        /* ++  КОНЕЦ обработка POST-данных ++ */

        if (!empty($login) && !empty($password)) {
            $permissions = new Model_Permissions();
            $permis = $permissions->selectPermisByLogin($login, $password);

            //print_r($permis);
            //exit();
            //print_r($permis);
            if (!empty($permis)) {
                //write to session
                $_SESSION['id_user'] = $permis['id_user'];
                $_SESSION['user_name'] = $permis['user_name'];
                $_SESSION['id_level'] = $permis['id_level'];
                $_SESSION['id_region'] = $permis['id_region'];
                $_SESSION['id_locorg'] = $permis['id_locorg'];
                $_SESSION['id_local'] = $permis['id_local'];
                $_SESSION['login'] = $permis['login'];
                $_SESSION['password'] = $permis['password'];
                $_SESSION['id_organ'] = $permis['id_organ'];
                $_SESSION['sub'] = $permis['sub'];
                $_SESSION['can_edit'] = $permis['can_edit'];
                $_SESSION['is_admin'] = $permis['is_admin'];
                $_SESSION['auto_ate'] = $permis['auto_ate'];
                $_SESSION['level_name'] = $permis['level_name'];
                $_SESSION['region_name'] = $permis['region_name'];
                $_SESSION['locorg_name'] = $permis['locorg_name'];
                $_SESSION['can_edit_name'] = $permis['can_edit_name'];
                $_SESSION['is_admin_name'] = $permis['is_admin_name'];
                $_SESSION['auto_ate_name'] = $permis['auto_ate_name'];
                $_SESSION['auto_local'] = $permis['auto_local'];
                $_SESSION['auto_locality'] = $permis['auto_locality'];

                //Проверяем, что была нажата галочка 'Запомнить меня':
                if (!empty($_POST['remember_me']) && $_POST['remember_me'] == 1) {
                    /* ------ Cookie ------ */

                    //Сформируем случайную строку для куки (используем функцию generateSalt):
                    $key = generateSalt(); //назовем ее $key
                    //Пишем куки (имя куки, значение, время жизни - без времени)
                    setcookie('id_user', $permis['id_user']);
                    setcookie('key', $key); //случайная строка

                    /*
                      Пишем эту же куку в базу данных для данного юзера.

                      Формируем и отсылаем SQL запрос:
                      ОБНОВИТЬ  таблицу_users УСТАНОВИТЬ cookie = $key ГДЕ id_user=$permis['id_user'].
                     */
                    $u = R::load('user', $permis['id_user']);
                    $u->cookie = $key;
                    R::store($u);

                    /* ------ Cookie ------ */
                }

                $array = array('time' => date("Y-m-d H:i:s"), 'ip-address' => $_SERVER['REMOTE_ADDR'], 'login' => $login, 'password' => $password, 'user_name' => $_SESSION['user_name']);
                $log_array = json_encode($array, JSON_UNESCAPED_UNICODE);
                $log->info('Сессия -  :: Вход пользователя с - id = ' . $_SESSION['id_user'] . ' данные - : ' . $log_array); //запись в logs

                $app->redirect(BASE_URL . '/remark/remark_form');
            } else {
                $app->redirect(BASE_URL . '/remark/remark_login');
            }
        } else {
            $app->redirect(BASE_URL . '/remark/remark_login');
        }
    });


    $app->post('/remark_save/(:id)', function ($id = 0) use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;



        $is_file = $app->request()->post('is_file');
        $is_file = (isset($is_file)) ? $is_file : 0;
        //echo $is_file;exit();

        $errors = array();

        if (isset($_FILES['userfile']) && !empty($_FILES['userfile']) && $_FILES['userfile']['error'] == 0 && $is_file == 0) {


            $uploaddir = 'uploads/remark/';
            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
            $basename = basename($_FILES['userfile']['name']);

            function translit($s)
            {
                $s = (string) $s; // преобразуем в строковое значение
                $s = trim($s); // убираем пробелы в начале и конце строки
                $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
                $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
                return $s; // возвращаем результат
            }
            /* extension of file */
            $info = new SplFileInfo($basename);

            $file_name_only = basename($uploadfile, "." . $info->getExtension());
            $extens = $info->getExtension();
            $new_name_file = $uploaddir . translit($file_name_only) . '.' . $info->getExtension();

            $allowed_extension = array('doc', 'docx', 'txt', 'xls', 'xlsx', 'jpg', 'png','pdf');

            $uploadOk = 1;

            $file_size = $_FILES['userfile']['size'];


            // Check if file already exists
            if (file_exists($new_name_file)) {
                //echo "Sorry, file already exists.";
//                return output->json([
//                        'errors' => 'файл с таким именем уже существует. Переименуйте файл и загрузите его заново.'
//                ]);


                if ($id != 0) {//edit
                    $remark = R::load('remark', $id);
                    $file_name_for_delete = $remark->file_name;

                    if (!empty($file_name_for_delete) && $file_name_for_delete === $new_name_file) {
                        //delete file from folder
                        if (file_exists($file_name_for_delete)) {
                            unlink($file_name_for_delete);
                        }
                    }
                } else {

                    $errors[] = 'файл с таким именем уже существует. Переименуйте файл и загрузите его заново.';
                    $uploadOk = 0;
                }
            }

            if ($file_size >= $_POST['MAX_FILE_SIZE']) {
                //error
                //echo "Sorry, your file is too large.";

                $errors[] = 'Размер файла превышает допустимое значение';
                $uploadOk = 0;
            }


            // Allow certain file formats
            if (!in_array($extens, $allowed_extension)) {
                //echo "Sorry, only ". implode(',', $allowed_extension). "files are allowed.";

                $errors[] = "Допустимы только следующие файлы: " . implode(',', $allowed_extension) . ".";

                $uploadOk = 0;
            }


            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                //echo "Sorry, your file was not uploaded.";
                $errors[] = 'Файл не был загружен.';
            } else {
                // if everything is ok, try to upload file


                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                    // echo "Файл корректен и был успешно загружен.\n";

                    rename($uploadfile, $new_name_file);
                    $array['file_name'] = $new_name_file;
                    $array['file_basename'] = $basename;


                    if ($id != 0) {//edit
                        $remark = R::load('remark', $id);
                        $file_name_for_delete = $remark->file_name;

                        if (!empty($file_name_for_delete) && $file_name_for_delete != $new_name_file) {
                            //delete file from folder
                            if (file_exists($file_name_for_delete)) {
                                unlink($file_name_for_delete);
                            }
                        }
                    }
                } else {
                    // print_r($_FILES['userfile']['error']);
                    //  echo "Возможная атака с помощью файловой загрузки!\n";
                    $errors[] = "Возможная атака с помощью файловой загрузки!";
                }
            }
        } else {

            if ($id == 0) {//create
                $array['file_name'] = NULL;
                $array['file_basename'] = NULL;
            } else {//edit
                if ($is_file == 1) {//don't upload
                    $array['file_name'] = NULL;
                    $array['file_basename'] = NULL;
                }
            }
        }

        if ($is_file == 1 && $id != 0) {//don't upload
            $remark = R::load('remark', $id);
            $file_name_for_delete = $remark->file_name;
            //delete file from folder
            unlink($file_name_for_delete);
        }
        // print_r($errors);
//exit();
        if (isset($errors) && !empty($errors)) {

            $data['errors'] = $errors;
            $data['title'] = 'Книга замечаний';

            $bread_crumb = array('Книга замечаний');
            $data['bread_crumb'] = $bread_crumb;


            $data['remark_type'] = R::getAll('select * from remark_type');
            $data['remark_status'] = R::getAll('select * from remark_status');

            $app->render('layouts/remark/header.php', $data);

            $data['path_to_view'] = 'remark/errors.php';


            $app->render('layouts/remark/div_wrapper.php', $data);
            $app->render('layouts/remark/footer.php');
            exit();
        }




        $array['description'] = $app->request()->post('description');
        $array['type_user'] = $app->request()->post('type_user');
        $array['contact'] = $app->request()->post('contact');
        $array['author'] = $app->request()->post('author');
        $array['note'] = $app->request()->post('note');


        if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
            $array['type_rcu_admin'] = $app->request()->post('type_rcu_admin');
            $array['status_rcu_admin'] = $app->request()->post('status_rcu_admin');
            $array['note_rcu'] = $app->request()->post('note_rcu');
            $array['id_journal_user'] = $_SESSION['id_user'];
        } elseif (isset($_SESSION['id_user'])) {
            $array['id_journal_user'] = $_SESSION['id_user'];
        } elseif (isset($_SESSION['id_ghost'])) {
            $array['id_ghost'] = $_SESSION['id_ghost'];
        }


        /* edit */
        if ($id != 0) {
            if (isset($_SESSION['id_user'])) {
                if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                    saveRemark($array, $id);
                } else {

                    $id_journal_user = R::getCell('select id_journal_user from remark where id = ?', array($id));

                    if ($id_journal_user == $_SESSION['id_user']) {
                        saveRemark($array, $id);
                    }
                }
            } elseif (isset($_SESSION['id_ghost'])) {

                $id_ghost = R::getCell('select id_ghost from remark where id = ?', array($id));

                if ($id_ghost == $_SESSION['id_ghost']) {
                    saveRemark($array, $id);
                }
            }
        } else {
            saveRemark($array, $id);
        }


        $app->redirect(BASE_URL . '/remark');
    });


    // edit table. rcu admin
    $app->post('/edit_table', function () use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;


        $input = filter_input_array(INPUT_POST);

        $id = $input['id'];

        /* edit */
        if ($input['action'] == 'edit') {



            $array['description'] = $input['description'];
            $array['type_user'] = $input['type_user'];
            $array['contact'] = $input['contact'];
            $array['author'] = $input['author'];
            $array['note'] = $input['note'];
//        print_r($input);
//        echo $id;exit();

            if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                $array['type_rcu_admin'] = $app->request()->post('type_rcu_admin');
                $array['status_rcu_admin'] = $app->request()->post('status_rcu_admin');
                $array['note_rcu'] = $app->request()->post('note_rcu');
                $array['id_journal_user'] = $_SESSION['id_user'];
            } elseif (isset($_SESSION['id_user'])) {
                $array['id_journal_user'] = $_SESSION['id_user'];
            } elseif (isset($_SESSION['id_ghost'])) {
                $array['id_ghost'] = $_SESSION['id_ghost'];
            }


            if ($id != 0) {
                if (isset($_SESSION['id_user'])) {
                    if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                        unset($array['id_journal_user']);
                        saveRemark($array, $id);
                    } else {

                        $id_journal_user = R::getCell('select id_journal_user from remark where id = ?', array($id));

                        if ($id_journal_user == $_SESSION['id_user']) {
                            saveRemark($array, $id);
                        }
                    }
                } elseif (isset($_SESSION['id_ghost'])) {

                    $id_ghost = R::getCell('select id_ghost from remark where id = ?', array($id));

                    if ($id_ghost == $_SESSION['id_ghost']) {
                        saveRemark($array, $id);
                    }
                }
            }
//         else {
//            saveRemark($array, $id);
//        }
        } elseif ($input['action'] == 'delete') {
            if ($id != 0) {
                deleteRemark($id);
            }
        } elseif ($input['action'] == 'restore') {
            if ($id != 0) {
                restoreRemark($id);
            }
        }



        echo json_encode($input);
        // $app->redirect(BASE_URL . '/remark');
    });

    //question delete
    $app->get('/:id', function ($id) use ($app) {

        $data['title'] = 'Удаление замечания';

        $bread_crumb = array('Книга замечаний', 'Удалить');
        $data['bread_crumb'] = $bread_crumb;

        $data['remark_id'] = $id;

        $app->render('layouts/remark/header.php', $data);
        $data['path_to_view'] = 'remark/questionOfDelete.php';
        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');
    })->conditions(array('id' => '\d+'));

    //delete remark
    $app->delete('/delete/:id', function ($id) use ($app) {

        if (isset($_SESSION['id_user'])) {

            if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                deleteRemark($id);
            } else {
                $id_journal_user = R::getCell('select id_journal_user from remark where id = ?', array($id));

                if ($id_journal_user == $_SESSION['id_user']) {
                    deleteRemark($id);
                }
            }
        } elseif (isset($_SESSION['id_ghost'])) {

            $id_ghost = R::getCell('select id_ghost from remark where id = ?', array($id));

            if ($id_ghost == $_SESSION['id_ghost']) {
                deleteRemark($id);
            }
        }

        $app->redirect(BASE_URL . '/remark');
    });


    $app->post('/rcu_upload_file', function () use ($app) {

        $post = $app->request()->post();
        $save = [];
//print_r($post);exit();
        //delete files
        R::exec('DELETE from remark_rcu_files  WHERE id_remark =?', array($post['id_remark']));

        if (isset($post['list_files']) && !empty($post['list_files'])) {

            $for_delete=[];
            if (isset($post['delete_photo_multi']) && !empty($post['delete_photo_multi'])) {
                $for_delete = $post['delete_photo_multi'];
            }

            $arr = explode(',', $post['list_files']);
            foreach ($arr as $value) {

                if (!in_array($value, $for_delete)) {
                    $save['file'] = $value;
                    $save['id_remark'] = $post['id_remark'];
                    $save['created_by'] = $_SESSION['id_user'];
                    $save['created_date'] = date('Y-m-d H:i:s');

                    if (!empty($save)) {
                        $w = R::load('remark_rcu_files', 0);
                        $w->import($save);
                        R::store($w);
                    }
                }
            }
            $is_ok = 1;
        }

        if (isset($is_ok)) {
            echo json_encode([
                'msg'   => 'Файлы прикреплены',
                'is_ok' => $is_ok
            ]);
        } else {
            echo json_encode([
                'msg'   => 'Файлы не прикреплены',
                'is_ok' => 0
            ]);
        }
    });


    $app->post('/get_rcu_file_modal', function () use ($app) {

        $post = $app->request()->post();

        $data['upload_path']=UPLOAD_PATH;

        $data['images'] = R::getAll('select * from remark_rcu_files  WHERE id_remark = ?', array($post['id']));

        if (!empty($data['images'])) {
            foreach ($data['images'] as $key => $value) {
                $info = new SplFileInfo($value['file']);
                $extens = $info->getExtension();
                $type_source = '';
                if (in_array($extens, ['txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                    $type_source = 'file';
                } else {
                    $type_source = 'img';
                }
                $data['images'][$key]['type_source'] = $type_source;
            }
        }

        $view = $app->render('remark/modals/body_modal_media_multi.php', $data);
        $response = ['success' => TRUE, 'view' => $view];
    });
});

function saveRemark($array, $id)
{
    $remark = R::load('remark', $id);

    if ($id == 0) {//insert
        $array['date_insert'] = date("Y-m-d H:i:s");
    } else {
        if (isset($array['id_journal_user'])) {
            unset($array['id_journal_user']);
        } elseif (isset($array['id_ghost'])) {
            unset($array['id_ghost']);
        }
    }
    $array['last_update'] = date("Y-m-d H:i:s");

    $remark->import($array);

    $new_id = R::store($remark);
    $_SESSION['save_remark'] = 1;
}

function deleteRemark($id)
{
    $remark = R::load('remark', $id);
    $remark->is_delete = 1;
    //R::trash($remark);
    R::store($remark);
    $_SESSION['save_remark'] = 1;
}

function restoreRemark($id)
{
    $remark = R::load('remark', $id);
    $remark->is_delete = 0;
    //R::trash($remark);
    R::store($remark);
    $_SESSION['save_remark'] = 1;
}
/* END remark book */

function getSettingsUser()
{
    $settings_user_bd = R::getAll('SELECT  s.name, s.`type` as setting_type, st.id as type_id,st.name_sign, s.is_multi
 FROM settings_user su
 left join settings_type as st on su.id_settings_type=st.id
 left join settings as s on s.id=st.id_setting WHERE su.id_user = ?', array($_SESSION['id_user']));
    $settings_user = array();
    foreach ($settings_user_bd as $value) {
        if ($value['is_multi'] == 1) {
            $settings_user[$value['setting_type']][] = $value;
        } else
            $settings_user[$value['setting_type']] = $value;
    }
    return $settings_user;
}

function getSilyForType2($sily_mchs)
{
    $teh_mark = array();
    $exit_time = array();
    $arrival_time = array();
    $follow_time = array();
    $end_time = array();
    $return_time = array();
    $distance = array();

    foreach ($sily_mchs as $id_rig => $row) {

        foreach ($row as $si) {
            //$teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b> - '.$si['locorg_name'].', '.$si['pasp_name'];
            $teh_mark[$id_rig][] = '<b>' . $si['mark'] . '</b>, ' . $si['pasp_name'] . (!empty($si['paso_object_num']) ? ' ' . $si['paso_object_num'] : '');
            $exit_time[$id_rig][] = (isset($si['time_exit']) && !empty($si['time_exit'])) ? date('H:i', strtotime($si['time_exit'])) : '-';
            $arrival_time[$id_rig][] = (isset($si['time_arrival']) && !empty($si['time_arrival'])) ? date('H:i', strtotime($si['time_arrival'])) : '-';
            $follow_time[$id_rig][] = (isset($si['time_follow']) && !empty($si['time_follow'])) ? date('H:i', strtotime($si['time_follow'])) : '-';
            $end_time[$id_rig][] = (isset($si['time_end']) && !empty($si['time_end'])) ? date('H:i', strtotime($si['time_end'])) : '-';
            $return_time[$id_rig][] = (isset($si['time_return']) && !empty($si['time_return'])) ? date('H:i', strtotime($si['time_return'])) : '-';
            $distance[$id_rig][] = (isset($si['distance']) && !empty($si['distance'])) ? $si['distance'] : '-';
        }
    }

    $res['teh_mark'] = $teh_mark;
    $res['exit_time'] = $exit_time;
    $res['arrival_time'] = $arrival_time;
    $res['follow_time'] = $follow_time;
    $res['end_time'] = $end_time;
    $res['return_time'] = $return_time;
    $res['distance'] = $distance;

    return $res;
}

function getEmptyFields($rigs)
{



    foreach ($rigs as $key => $value) {
        $error = array();
        if ($value['view_work_id'] == 0) {

            $error[] = 'вид работ';
        }
        if ($value['id_reasonrig'] == 0) {

            $error[] = 'причина вызова';
        } elseif ($value['id_reasonrig'] == 34) {//pogar
            if ($value['firereason_id'] == 0) {
                $error[] = 'причина пожара';
            }
            if ($value['firereason_descr'] == '' || empty($value['firereason_descr'])) {
                $error[] = 'причина пожара (пояснение)';
            }
            if ($value['inspector'] == '' || empty($value['inspector'])) {
                $error[] = 'инспектор';
            }
            if ($value['latitude'] == '' || empty($value['latitude'])) {
                $error[] = 'широта';
            }

            if ($value['longitude'] == '' || empty($value['longitude'])) {
                $error[] = 'долгота';
            }
            if ($value['object'] == '' || empty($value['object'])) {
                $error[] = 'объект';
            }
            if ($value['office_belong_id'] == 0) {
                $error[] = 'ведомственная принадлежность';
            }
        } elseif ($value['id_reasonrig'] == 74) {//molnia
            if ($value['object'] == '' || empty($value['object'])) {
                $error[] = 'объект';
            }
            if ($value['office_belong_id'] == 0) {
                $error[] = 'ведомственная принадлежность';
            }
        } elseif ($value['id_reasonrig'] == 14 || $value['id_reasonrig'] == 69) {//drugie, logny
            if ($value['inspector'] == '' || empty($value['inspector'])) {
                $error[] = 'инспектор';
            }
        }

        $rigs[$key]['empty_fields'] = $error;
    }
    // print_r($rigs);exit();
    return $rigs;
}
/* select data from bd. card by id rig. archive_1 */

function getCardByIdRig($table_name_year, $id_rig)
{

    $main_m = new Model_Main();
    $y=$table_name_year;

    $sql = ' SELECT * FROM jarchive.' . $table_name_year . '  WHERE  id_rig = ' . $id_rig;

        $real_server = $main_m->get_js_connect(substr($y, 0, -1));
        if (IS_NEW_MODE_ARCHIVE == 1 && substr($y, 0, -1) < date('Y') && $real_server != APP_SERVER) {
            $pdo = get_pdo_15($real_server);
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
    } else {
        $result = R::getAll($sql);
    }


    $r = array();


    $i = 0;
    foreach ($result as $value) {
        $r['id_rig'] = $value['id_rig'];
        $r['date_msg'] = $value['date_msg'];
        $r['time_msg'] = $value['time_msg'];
        $r['time_loc'] = $value['time_loc'];
        $r['time_likv'] = $value['time_likv'];
        $r['address'] = (empty($value['address'])) ? ((!empty($value['additional_field_address'])) ? $value['additional_field_address'] : '') : $value['address'];

        $r['is_address'] = (empty($value['address'])) ? 0 : 1;

        $r['inf_region'] = array();
        if (strpos($value['region_name'], "г.") === 0)
            $r['region_name'] = '';
        else
            $r['region_name'] = $value['region_name'] . ' область';

        if (strpos($value['local_name'], "г.") === 0)
            $r['local_name'] = '';
        else
            $r['local_name'] = $value['local_name'] . ' район';

        if (!empty($r['region_name']))
            $r['inf_region'][] = $r['region_name'];
        if (!empty($r['local_name']))
            $r['inf_region'][] = $r['local_name'];

        $r['inf_additional_field'] = array();
        if (!empty($value['additional_field_address']))
            $r['inf_additional_field'][] = $value['additional_field_address'];
        if ($value['is_opposite'] == 1)
            $r['inf_additional_field'][] = 'напротив';







        $r['reasonrig_name'] = ($value['reasonrig_name'] == 'не выбрано') ? '' : (stristr($value['reasonrig_name'], ' '));
        $r['view_work'] = ($value['view_work'] == 'не выбрано') ? '' : $value['view_work'];
        $r['firereason_name'] = ($value['firereason_name'] == 'не выбрано') ? '' : $value['firereason_name'];
        $r['inspector'] = (empty($value['inspector']) || $value['inspector'] == '') ? '' : $value['inspector'];



        $r['description'] = (empty($value['description']) || $value['description'] == '') ? '' : $value['description'];
        $r['inf_detail'] = (empty($value['inf_detail']) || $value['inf_detail'] == '') ? '' : $value['inf_detail'];
        $r['firereason_description'] = (empty($value['firereason_description']) || $value['firereason_description'] == '') ? '' : $value['firereason_description'];



        $r['people'] = (empty($value['people']) || $value['people'] == '') ? '' : $value['people'];
        $r['object'] = (empty($value['object']) || $value['object'] == '') ? '' : $value['object'];
        $r['office_name'] = ($value['office_name'] == 'не выбрано') ? '' : $value['office_name'];

        $r['latitude'] = (empty($value['latitude']) || $value['latitude'] == 0 || $value['latitude'] == NULL) ? '' : $value['latitude'];
        $r['longitude'] = (empty($value['longitude']) || $value['longitude'] == 0 || $value['longitude'] == NULL) ? '' : $value['longitude'];

        $r['google_link'] = '';
        $r['yandex_link'] = '';
        $r['coord_link'] = array();

        if (!empty($r['latitude']) && !empty($r['longitude'])) {
            $yandex_link = 'https://yandex.by/maps/26010/kobrin/?ll=' . $r['longitude'] . '%2C' . $r['latitude'] . '&mode=search&sll=27.492966%2C53.870999&sspn=0.493011%2C0.173885&text=' . $r['latitude'] . '%2C%20' . $r['longitude'] . '&z=17';
            $yandex_link_new = '<a href="' . $yandex_link . '" target="_blank"><img src="/journal/assets/images/yandex.png" style="width: 1.5%"></a>';
            $google_link = 'https://www.google.com/search?q=' . $r['latitude'] . '%2C+' . $r['longitude'] . '&rlz=1C1VFKB_enBY842BY842&oq=' . $r['latitude'] . '%2C+' . $r['longitude'] . '&aqs=chrome..69i57.487j0j7&sourceid=chrome&ie=UTF-8';
            $google_link_new = '<a href="' . $google_link . '" target="_blank"><img src="/journal/assets/images/google.png" style="width: 1.2%"></a>';
            $r['coord'] = $r['latitude'] . ', ' . $r['longitude'];


            $r['coord_link'][] = $yandex_link_new;
            $r['coord_link'][] = $google_link_new;
        } elseif (!empty($r['latitude']))
            $r['coord'] = $r['latitude'];
        elseif (!empty($r['longitude']))
            $r['coord'] = $r['longitude'];
        else
            $r['coord'] = '';



        /* sily mchs */
        $is_likv_before = ($value['is_likv_before_arrival'] == 0) ? 'нет' : 'да';
        $arr_silymchs = explode('~', $value['silymchs']);

        $silymchs = array();

        // 1 car
        foreach ($arr_silymchs as $row) {
            // $row_data=array();
            if (!empty($row)) {
                $i++;
                $arr_mark = explode('#', $row);
                /* mark - before # */
                // $mark[]=$arr_mark[0];
                $mark = $arr_mark[0];

                /* all after # explode, exit,arrival......is_return , result -all  after ? */
                $arr_time = explode('?', $arr_mark[1]);


                $numbsign_part = explode('$', $arr_time[0]);
                $numbsign = $numbsign_part[0];
                $podr_part = explode('%', $numbsign_part[1]);
                $podr = $podr_part[0] . ', ' . $podr_part[1];


                /* all  after ? explode.  exit,arrival......is_return */
                $each_time = explode('&', $arr_time[1]);
                $t_exit = (!empty($each_time[0]) && $each_time[0] != '-') ? date('H:i', strtotime($each_time[0])) : '-';
                $t_arrival = (!empty($each_time[1]) && $each_time[1] != '-') ? date('H:i', strtotime($each_time[1])) : '-';
                $t_follow = (!empty($each_time[2]) && $each_time[2] != '-') ? date('H:i', strtotime($each_time[2])) : '-';
                $t_end = (!empty($each_time[3]) && $each_time[3] != '-') ? date('H:i', strtotime($each_time[3])) : '-';
                $t_return = (!empty($each_time[4]) && $each_time[4] != '-') ? date('H:i', strtotime($each_time[4])) : '-';
                $t_distance = $each_time[5];
                $t_is_return = ($each_time[6] == 0) ? 'нет' : 'да';



                $row_data = array('mark'           => $mark, 'numbsign'       => $numbsign, 'podr'           => $podr, 'time_msg'       => date('H:i', strtotime($value['time_msg'])), 't_exit'         => $t_exit,
                    't_arrival'      => $t_arrival, 'is_likv_before' => $is_likv_before, 't_end'          => $t_end, 't_return'       => $t_return, 't_follow'       => $t_follow,
                    't_distance'     => $t_distance, 't_is_return'    => $t_is_return);

                $silymchs[] = $row_data;
            }
        }
        $data['silymchs'] = $silymchs;



        /* inner service */

        $innerservice = array();

        $arr = explode('~', $value['innerservice']);

        foreach ($arr as $row) {

            if (!empty($row)) {
                $i++;
                $arr_name = explode('#', $row);
                /* fio - before # */
                $service_name = $arr_name[0];

                /* all  after # explode. time_msg,time_exit.... */
                $each_time = explode('&', $arr_name[1]);

                $t_msg = (!empty($each_time[0]) && $each_time[0] != '-') ? date('H:i', strtotime($each_time[0])) : '-';
                $t_arrival = (!empty($each_time[1]) && $each_time[1] != '-') ? date('H:i', strtotime($each_time[1])) : '-';

                $note = explode('%', $each_time[2]);

                $t_distance = $note[0];
                $t_note = $note[1];


                $row_data = array('service_name' => $service_name, 'time_msg'     => $t_msg,
                    't_arrival'    => $t_arrival,
                    't_distance'   => $t_distance, 'note'         => $t_note);

                $innerservice[] = $row_data;
            }
        }
        $data['innerservice'] = $innerservice;



        /* informing */

        $informing = array();
        $i = 0;

        $arr = explode('~', $value['informing']);

        foreach ($arr as $row) {
            if (!empty($row)) {
                $i++;
                $arr_fio = explode('#', $row);
                /* fio - before # */
                $fio = $arr_fio[0];

                /* all  after # explode. time_msg,time_exit.... */
                $each_time = explode('&', $arr_fio[1]);

                $t_msg = (!empty($each_time[0]) && $each_time[0] != '-') ? date('H:i', strtotime($each_time[0])) : '-';
                $t_exit = (!empty($each_time[1]) && $each_time[1] != '-') ? date('H:i', strtotime($each_time[1])) : '-';
                $t_arrival = (!empty($each_time[2]) && $each_time[2] != '-') ? date('H:i', strtotime($each_time[2])) : '-';

                $row_data = array('fio'       => $fio, 'time_msg'  => $t_msg, 't_exit'    => $t_exit,
                    't_arrival' => $t_arrival);

                $informing[] = $row_data;
            }
        }
        $data['informing'] = $informing;

        /* results_battle */
        $results_battle = array();
        $i = 0;

        if (!empty($value['results_battle'])) {
            $arr = explode('#', $value['results_battle']);
            if (!empty($arr)) {
                $results_battle['dead_man'] = $arr[0];
                $results_battle['dead_child'] = $arr[1];
                $results_battle['save_man'] = $arr[2];
                $results_battle['inj_man'] = $arr[3];
                $results_battle['ev_man'] = $arr[4];
                $results_battle['save_an'] = $arr[11];
                $results_battle['save_plan'] = $arr[14];
                $results_battle['save_build'] = $arr[5];
                $results_battle['save_teh'] = $arr[8];
            }
        }
        $data['results_battle'] = $results_battle;




        /* trunk */
        $arr_trunk = explode('~', $value['trunk']);

        $trunk = array();

        // 1 car
        foreach ($arr_trunk as $row) {
            // $row_data=array();
            if (!empty($row)) {
                $i++;
                $arr_mark = explode('#', $row);
                /* mark - before # */
                $mark = $arr_mark[0];

                $arr_time = explode('?', $arr_mark[1]);


                /* numsign$locorg_name%pasp_name */
                $car = $arr_time[0];
                $car_detail = explode('$', $car);
                $numbsign = $car_detail[0];

                $grochs_detail = explode('%', $car_detail[1]);
                $locorg_name = $grochs_detail[0];
                $pasp_name = $grochs_detail[1];
                $podr = $locorg_name . ', ' . $pasp_name;


                /* all  after ? explode.  time_pod, trunk_name, cnt, water */
                $each_time = explode('&', $arr_time[1]);

                $time_pod = $each_time[0];
                $trunk_name = $each_time[1];
                $cnt = $each_time[2];
                $water = $each_time[3];


                $row_data = array('mark'     => $mark, 'numbsign' => $numbsign, 'podr'     => $podr, 'time_pod' => $time_pod, 'cnt'      => $cnt, 'type'     => $trunk_name,
                    'water'    => $water);

                $trunk[$mark][] = $row_data;
            }
        }
        $data['trunk'] = $trunk;
    }






    // print_r($silymchs);exit();


    $data['result'] = $r;

    return $data;
}
/* select data from bd. card by id rig. rigtable journal */

function getCardByIdRigFromJournal($id_rig)
{
    $sql = ' SELECT * FROM rigtable  WHERE  id = ' . $id_rig;

    $result = R::getAll($sql);
    $r = array();


    $i = 0;
    foreach ($result as $value) {
        $r['id_rig'] = $value['id'];
        $r['date_msg'] = $value['date_msg'];
        $r['time_msg'] = date('H:i', strtotime($value['time_msg']));
        $r['time_loc'] = $value['time_loc'];
        $r['time_likv'] = $value['time_likv'];
        $r['address'] = (empty($value['address'])) ? ((!empty($value['additional_field_address'])) ? $value['additional_field_address'] : '') : $value['address'];

        $r['is_address'] = (empty($value['address'])) ? 0 : 1;

        $r['inf_region'] = array();
        if (strpos($value['region_name'], "г.") === 0)
            $r['region_name'] = '';
        else
            $r['region_name'] = $value['region_name'] . ' область';

        if (strpos($value['local_name'], "г.") === 0)
            $r['local_name'] = '';
        else
            $r['local_name'] = $value['local_name'] . ' район';

        if (!empty($r['region_name']))
            $r['inf_region'][] = $r['region_name'];
        if (!empty($r['local_name']))
            $r['inf_region'][] = $r['local_name'];

        $r['inf_additional_field'] = array();
        if (!empty($value['additional_field_address']))
            $r['inf_additional_field'][] = $value['additional_field_address'];
        if ($value['is_opposite'] == 1)
            $r['inf_additional_field'][] = 'напротив';


        $r['reasonrig_name'] = ($value['reasonrig_name'] == 'не выбрано') ? '' : (stristr($value['reasonrig_name'], ' '));
        $r['view_work'] = ($value['view_work'] == 'не выбрано') ? '' : $value['view_work'];
        $r['firereason_name'] = ($value['firereason_name'] == 'не выбрано') ? '' : $value['firereason_name'];
        $r['inspector'] = (empty($value['inspector']) || $value['inspector'] == '') ? '' : $value['inspector'];



        $r['description'] = (empty($value['description']) || $value['description'] == '') ? '' : $value['description'];
        $r['inf_detail'] = (empty($value['inf_detail']) || $value['inf_detail'] == '') ? '' : $value['inf_detail'];
        $r['firereason_description'] = (empty($value['firereason_description']) || $value['firereason_description'] == '') ? '' : $value['firereason_description'];



        // $r['people']=(empty($value['people']) || $value['people'] == '') ? '' : $value['people'];
        $r['object'] = (empty($value['object']) || $value['object'] == '') ? '' : $value['object'];
        $r['office_name'] = ($value['office_name'] == 'не выбрано') ? '' : $value['office_name'];

        $r['latitude'] = (empty($value['latitude']) || $value['latitude'] == 0 || $value['latitude'] == NULL) ? '' : $value['latitude'];
        $r['longitude'] = (empty($value['longitude']) || $value['longitude'] == 0 || $value['longitude'] == NULL) ? '' : $value['longitude'];

        $r['google_link'] = '';
        $r['yandex_link'] = '';
        $r['coord_link'] = array();

        if (!empty($r['latitude']) && !empty($r['longitude'])) {
            $yandex_link = 'https://yandex.by/maps/26010/kobrin/?ll=' . $r['longitude'] . '%2C' . $r['latitude'] . '&mode=search&sll=27.492966%2C53.870999&sspn=0.493011%2C0.173885&text=' . $r['latitude'] . '%2C%20' . $r['longitude'] . '&z=17';
            $yandex_link_new = '<a href="' . $yandex_link . '" target="_blank"><img src="/journal/assets/images/yandex.png" style="width: 1.5%"></a>';
            $google_link = 'https://www.google.com/search?q=' . $r['latitude'] . '%2C+' . $r['longitude'] . '&rlz=1C1VFKB_enBY842BY842&oq=' . $r['latitude'] . '%2C+' . $r['longitude'] . '&aqs=chrome..69i57.487j0j7&sourceid=chrome&ie=UTF-8';
            $google_link_new = '<a href="' . $google_link . '" target="_blank"><img src="/journal/assets/images/google.png" style="width: 1.2%"></a>';
            $r['coord'] = $r['latitude'] . ', ' . $r['longitude'];


            $r['coord_link'][] = $yandex_link_new;
            $r['coord_link'][] = $google_link_new;
        } elseif (!empty($r['latitude']))
            $r['coord'] = $r['latitude'];
        elseif (!empty($r['longitude']))
            $r['coord'] = $r['longitude'];
        else
            $r['coord'] = '';


        /* people */
        $people = R::getAll('select * from people where id_rig = ?', array($id_rig));
        $arr_people = array();
        if (!empty($people)) {
            foreach ($people as $p) {

                if (!empty($p['fio']))
                    $arr_people[] = $p['fio'];
                if (!empty($p['phone']))
                    $arr_people[] = 'тел: ' . $p['phone'];
                if (!empty($p['position']))
                    $arr_people[] = $p['position'];
                if (!empty($value['address']))
                    $arr_people[] = $p['address'];
            }
        }


        $r['people'] = (empty($arr_people) ) ? '' : implode(', ', $arr_people);


        /* sily mchs */
        $is_likv_before = ($value['is_likv_before_arrival'] == 0) ? 'нет' : 'да';
        $arr_silymchs = R::getAll('select * from jrig where id_rig = ?', array($id_rig));

        $silymchs = array();

        // 1 car
        foreach ($arr_silymchs as $row) {
            // $row_data=array();
            if (!empty($row)) {
                $i++;

                $mark = $row['mark'];

                $numbsign = $row['numbsign'];
                $podr = $row['locorg_name'] . ', ' . $row['pasp_name'];


                /* all  after ? explode.  exit,arrival......is_return */
                $t_exit = (!empty($row['time_exit']) && $row['time_exit'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_exit'])) : '-';
                $t_arrival = (!empty($row['time_arrival']) && $row['time_arrival'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_arrival'])) : '-';
                $t_follow = (!empty($row['time_follow']) && $row['time_follow'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_follow'])) : '-';
                $t_end = (!empty($row['time_end']) && $row['time_end'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_end'])) : '-';
                $t_return = (!empty($row['time_return']) && $row['time_return'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_return'])) : '-';
                $t_distance = (!empty($row['distance'])) ? $row['distance'] : '0';
                $t_is_return = ($row['is_return'] == 0) ? 'нет' : 'да';



                $row_data = array('mark'           => $mark, 'numbsign'       => $numbsign, 'podr'           => $podr, 'time_msg'       => date('H:i', strtotime($value['time_msg'])), 't_exit'         => $t_exit,
                    't_arrival'      => $t_arrival, 'is_likv_before' => $is_likv_before, 't_end'          => $t_end, 't_return'       => $t_return, 't_follow'       => $t_follow,
                    't_distance'     => $t_distance, 't_is_return'    => $t_is_return);

                $silymchs[] = $row_data;
            }
        }
        $data['silymchs'] = $silymchs;


//
//             /* inner service */

        $innerservice = array();

        $innerservice_m = new Model_Innerservice();
        $arr = $innerservice_m->selectAllForCard($id_rig);

        foreach ($arr as $row) {

            if (!empty($row)) {
                $i++;

                /* fio - before # */
                $service_name = $row['service_name'];

                /* all  after # explode. time_msg,time_exit.... */

                $t_msg = (!empty($row['time_msg']) && $row['time_msg'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_msg'])) : '-';
                $t_arrival = (!empty($row['time_arrival']) && $row['time_arrival'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_arrival'])) : '-';


                $t_distance = (!empty($row['distance'])) ? $row['distance'] : '0';
                $t_note = $row['note'];


                $row_data = array('service_name' => $service_name, 'time_msg'     => $t_msg,
                    't_arrival'    => $t_arrival,
                    't_distance'   => $t_distance, 'note'         => $t_note);

                $innerservice[] = $row_data;
            }
        }
        $data['innerservice'] = $innerservice;

//
//
//             /* informing */

        $informing = array();
        $i = 0;

        $informing_m = new Model_Informing();
        $arr = $informing_m->selectAllByIdRig($id_rig);

        foreach ($arr as $row) {
            if (!empty($row)) {
                $i++;

                /* fio - before # */
                $fio = $row['fio'];

                /* all  after # explode. time_msg,time_exit.... */

                $t_msg = (!empty($row['time_msg']) && $row['time_msg'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_msg'])) : '-';
                $t_exit = (!empty($row['time_exit']) && $row['time_exit'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_exit'])) : '-';
                $t_arrival = (!empty($row['time_arrival']) && $row['time_arrival'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_arrival'])) : '-';

                $row_data = array('fio'       => $fio, 'time_msg'  => $t_msg, 't_exit'    => $t_exit,
                    't_arrival' => $t_arrival);

                $informing[] = $row_data;
            }
        }
        $data['informing'] = $informing;


        /* result battle */
        $result_battle = R::getRow('select dead_man,dead_child, save_man, inj_man, ev_man,save_an,save_plan, save_build, save_teh from results_battle where id_rig = ?', array($id_rig));
        $data['results_battle'] = $result_battle;




        /* trunk */
        $arr_trunk = R::getAll('SELECT j.`mark`,j.`numbsign`,j.`locorg_name`,j.`pasp_name`, t.`time_pod`, tl.`name` AS trunk_name ,
                t.`cnt`,t.`water`
FROM trunkrig AS t LEFT JOIN
jrig AS j ON t.`id_silymchs`=j.`id_sily`
LEFT JOIN trunklist AS tl ON tl.`id`=t.`id_trunk_list` WHERE j.`id_rig` =  ?', array($id_rig));

        $trunk = array();

        // 1 car
        foreach ($arr_trunk as $row) {
            // $row_data=array();
            if (!empty($row)) {
                $i++;

                $mark = $row['mark'];

                $numbsign = $row['numbsign'];
                $podr = $row['locorg_name'] . ', ' . $row['pasp_name'];

                $t_pod = (!empty($row['time_pod']) && $row['time_pod'] != '00:00') ? $row['time_pod'] : '-';
                $type = $row['trunk_name'];
                $water = $row['water'];


                $row_data = array('mark'     => $mark, 'numbsign' => $numbsign, 'podr'     => $podr, 'time_pod' => $t_pod, 'cnt'      => $row['cnt'], 'type'     => $type,
                    'water'    => $water);

                $trunk[$mark][] = $row_data;
            }
        }
        $data['trunk'] = $trunk;
    }

    // print_r($silymchs);exit();





    $data['result'] = $r;

    return $data;
}
/* ----------- results battle -------------- */
$app->group('/results_battle', function () use ($app, $log) {
    // view form
    $app->get('/:id_rig(/:is_success/:active_tab)', function ($id_rig, $is_success = 0, $active_tab = 1) use ($app) {


        $bread_crumb = array('Результаты боевой работы');
        $data['title'] = 'Результаты боевой работы';
        $data['title_block'] = 'rb';

        $data['settings_user'] = getSettingsUser();

        $data['active_tab'] = $active_tab;

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;

        /* --------- добавить инф о редактируемом вызове ------------ */
        $rig_table_m = new Model_Rigtable();
        $inf_rig = $rig_table_m->selectByIdRig($id_rig); // дата, время, адрес объекта для редактируемого вызова по id
        if ($id_rig != 0) {


            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];

                    $data['id_user'] = $value['id_user'];
                    $data['current_reason_rig'] = $value['id_reasonrig'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }


            /* is updeting now ?  */
            if (isset($is_success) && $is_success == 0) {
                $rig_m = new Model_Rig();
                $rig = $rig_m->selectAllById($id_rig);

                $is_update_now = is_update_rig_now($rig, $id_rig);
                if (!empty($is_update_now)) {
                    //  echo $is_update_now;
                    $data['is_update_now'] = $is_update_now;
                }
            }
            /* is updeting now ?  */
        }
        /* --------- добавить инф о редактируемом вызове ------------ */


        $data['id_rig'] = $id_rig;


        /* select battle for rig from bd */
        $battle = R::getRow('select * from results_battle WHERE id_rig = ? ', array($id_rig));

        if (isset($battle) && !empty($battle))
            $data['id_battle'] = $battle['id'];
        else
            $data['id_battle'] = 0;

        $data['battle'] = $battle;



        /* select battle for rig from bd PART 1 */
        $part_1 = R::getRow('select * from rb_chapter_1 WHERE id_rig = ? ', array($id_rig));

        if (isset($part_1) && !empty($part_1))
            $data['id_part_1'] = $part_1['id'];
        else
            $data['id_part_1'] = 0;

        $data['part_1'] = $part_1;


        /* select battle for rig from bd PART 2 */
        $part_2 = R::getRow('select * from rb_chapter_2 WHERE id_rig = ? ', array($id_rig));

        if (isset($part_2) && !empty($part_2))
            $data['id_part_2'] = $part_2['id'];
        else
            $data['id_part_2'] = 0;

        $data['part_2'] = $part_2;



        /* select battle for rig from bd PART 3 */
        $part_3 = R::getRow('select * from rb_chapter_3 WHERE id_rig = ? ', array($id_rig));

        if (isset($part_3) && !empty($part_3))
            $data['id_part_3'] = $part_3['id'];
        else
            $data['id_part_3'] = 0;

        $data['part_3'] = $part_3;


        if (isset($is_success))
            $data['is_success'] = $is_success;

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/trunk/header.php', $data);
        $data['path_to_view'] = 'results_battle/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/trunk/footer.php');
    });


    $app->post('/:id_rig', function ($id_rig) use ($app) {


        $save_data = array();
        $save_data['dead_man'] = (empty($app->request()->post('dead_man'))) ? 0 : intval($app->request()->post('dead_man'));
        $save_data['dead_child'] = (empty($app->request()->post('dead_child'))) ? 0 : intval($app->request()->post('dead_child'));

        $save_data['save_man'] = (empty($app->request()->post('save_man'))) ? 0 : intval($app->request()->post('save_man'));
        $save_data['save_child'] = (empty($app->request()->post('save_child'))) ? 0 : intval($app->request()->post('save_child'));
        $save_data['save_mchs'] = (empty($app->request()->post('save_mchs'))) ? 0 : intval($app->request()->post('save_mchs'));

        $save_data['inj_man'] = (empty($app->request()->post('inj_man'))) ? 0 : intval($app->request()->post('inj_man'));

        $save_data['ev_man'] = (empty($app->request()->post('ev_man'))) ? 0 : intval($app->request()->post('ev_man'));
        $save_data['ev_child'] = (empty($app->request()->post('ev_child'))) ? 0 : intval($app->request()->post('ev_child'));
        $save_data['ev_mchs'] = (empty($app->request()->post('ev_mchs'))) ? 0 : intval($app->request()->post('ev_mchs'));

        $save_data['save_build'] = (empty($app->request()->post('save_build'))) ? 0 : intval($app->request()->post('save_build'));
        $save_data['dam_build'] = (empty($app->request()->post('dam_build'))) ? 0 : intval($app->request()->post('dam_build'));
        $save_data['des_build'] = (empty($app->request()->post('des_build'))) ? 0 : intval($app->request()->post('des_build'));

        $save_data['save_teh'] = (empty($app->request()->post('save_teh'))) ? 0 : intval($app->request()->post('save_teh'));
        $save_data['dam_teh'] = (empty($app->request()->post('dam_teh'))) ? 0 : intval($app->request()->post('dam_teh'));
        $save_data['des_teh'] = (empty($app->request()->post('des_teh'))) ? 0 : intval($app->request()->post('des_teh'));

        $save_data['save_an'] = (empty($app->request()->post('save_an'))) ? 0 : intval($app->request()->post('save_an'));
        $save_data['dam_an'] = (empty($app->request()->post('dam_an'))) ? 0 : intval($app->request()->post('dam_an'));
        $save_data['des_an'] = (empty($app->request()->post('des_an'))) ? 0 : intval($app->request()->post('des_an'));

        $save_data['save_an_mchs'] = (empty($app->request()->post('save_an_mchs'))) ? 0 : intval($app->request()->post('save_an_mchs'));

        $save_data['save_plan'] = (empty($app->request()->post('save_plan'))) ? 0 : $app->request()->post('save_plan');
        $save_data['dam_plan'] = (empty($app->request()->post('dam_plan'))) ? 0 : $app->request()->post('dam_plan');
        $save_data['des_plan'] = (empty($app->request()->post('des_plan'))) ? 0 : $app->request()->post('des_plan');

        $save_data['dam_money'] = (empty($app->request()->post('dam_money'))) ? 0 : $app->request()->post('dam_money');
        $save_data['save_wealth'] = (empty($app->request()->post('save_wealth'))) ? 0 : $app->request()->post('save_wealth');




        $id_battle = (empty($app->request()->post('id_battle'))) ? 0 : $app->request()->post('id_battle');

        //save
        $battle = R::load('results_battle', $id_battle);

        if ($id_battle == 0) {//insert
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $id_rig;
        }
        $save_data['last_update'] = date("Y-m-d H:i:s");

        $battle->import($save_data);

        R::store($battle);

        /* is updeting now ?  */
        if ($id_rig != 0) {//edit
            unset_update_rig_now($id_rig);
        }

        //active tab 1
        $app->redirect(BASE_URL . '/results_battle/' . $id_rig . '/1/1');
    });
});

/* ----------- END results battle -------------- */





/* ----------- results battle PART 1-------------- */
$app->group('/results_battle_part_1', function () use ($app, $log) {

    //save PART 1
    $app->post('/:id_rig', function ($id_rig) use ($app) {

        //print_r($_POST);
//exit();

        $save_data = array();
        $save_data['people_help'] = (empty($app->request()->post('people_help'))) ? 0 : intval($app->request()->post('people_help'));
        $save_data['gos_help'] = (empty($app->request()->post('gos_help'))) ? 0 : intval($app->request()->post('gos_help'));
        $save_data['alone_otd'] = (empty($app->request()->post('alone_otd'))) ? 0 : intval($app->request()->post('alone_otd'));
        $save_data['alone_shift'] = (empty($app->request()->post('alone_shift'))) ? 0 : intval($app->request()->post('alone_shift'));
        $save_data['dop_mes'] = (empty($app->request()->post('dop_mes'))) ? 0 : intval($app->request()->post('dop_mes'));
        $save_data['no_water'] = (empty($app->request()->post('no_water'))) ? 0 : intval($app->request()->post('no_water'));
        $save_data['water'] = (empty($app->request()->post('water'))) ? 0 : intval($app->request()->post('water'));


        $save_data['other_mes'] = (empty($app->request()->post('other_mes'))) ? 0 : intval($app->request()->post('other_mes'));
        $save_data['one_gdzs'] = (empty($app->request()->post('one_gdzs'))) ? 0 : intval($app->request()->post('one_gdzs'));
        $save_data['many_gdzs'] = (empty($app->request()->post('many_gdzs'))) ? 0 : intval($app->request()->post('many_gdzs'));


        $save_data['tool_meh'] = (empty($app->request()->post('tool_meh'))) ? 0 : intval($app->request()->post('tool_meh'));
        $save_data['tool_pnev'] = (empty($app->request()->post('tool_pnev'))) ? 0 : intval($app->request()->post('tool_pnev'));
        $save_data['tool_gidr'] = (empty($app->request()->post('tool_gidr'))) ? 0 : intval($app->request()->post('tool_gidr'));

        $save_data['avia_help'] = (empty($app->request()->post('avia_help'))) ? 0 : intval($app->request()->post('avia_help'));


        $save_data['powder_mob'] = (empty($app->request()->post('powder_mob'))) ? 0 : intval($app->request()->post('powder_mob'));
        $save_data['save_p_mask'] = (empty($app->request()->post('save_p_mask'))) ? 0 : intval($app->request()->post('save_p_mask'));
        $save_data['pred_build'] = (empty($app->request()->post('pred_build'))) ? 0 : intval($app->request()->post('pred_build'));

        $save_data['pred_vehicle'] = (empty($app->request()->post('pred_vehicle'))) ? 0 : intval($app->request()->post('pred_vehicle'));




        $save_data['powder_out'] = (empty($app->request()->post('powder_out'))) ? 0 : $app->request()->post('powder_out');
        $save_data['pred_food'] = (empty($app->request()->post('pred_food'))) ? 0 : $app->request()->post('pred_food');

        //print_r($save_data);exit();

        $id_battle = (empty($app->request()->post('id_part_1'))) ? 0 : $app->request()->post('id_part_1');

        //save

        $battle = R::load('rb_chapter_1', $id_battle);
        if ($id_battle == 0) {//insert
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $id_rig;
        }

        $save_data['last_update'] = date("Y-m-d H:i:s");

        $battle->import($save_data);

        R::store($battle);

        /* is updeting now ?  */
        if ($id_rig != 0) {//edit
            unset_update_rig_now($id_rig);
        }

        $app->redirect(BASE_URL . '/results_battle/' . $id_rig . '/1/2');
    });
});

/* ----------- END results battle PART 1 -------------- */


/* ----------- results battle PART 2-------------- */
$app->group('/results_battle_part_2', function () use ($app, $log) {

    //save PART 1
    $app->post('/:id_rig', function ($id_rig) use ($app) {

        //print_r($_POST);
//exit();

        $save_data = array();
        $save_data['pred_build_4s'] = (empty($app->request()->post('pred_build_4s'))) ? 0 : intval($app->request()->post('pred_build_4s'));
        $save_data['pred_vehicle_4s'] = (empty($app->request()->post('pred_vehicle_4s'))) ? 0 : intval($app->request()->post('pred_vehicle_4s'));
        $save_data['avia_4s'] = (empty($app->request()->post('avia_4s'))) ? 0 : intval($app->request()->post('avia_4s'));

        $save_data['tool_meh'] = (empty($app->request()->post('tool_meh'))) ? 0 : intval($app->request()->post('tool_meh'));
        $save_data['tool_pnev'] = (empty($app->request()->post('tool_pnev'))) ? 0 : intval($app->request()->post('tool_pnev'));
        $save_data['tool_gidr'] = (empty($app->request()->post('tool_gidr'))) ? 0 : intval($app->request()->post('tool_gidr'));

        //print_r($save_data);exit();

        $id_battle = (empty($app->request()->post('id_part_2'))) ? 0 : $app->request()->post('id_part_2');

        //save

        $battle = R::load('rb_chapter_2', $id_battle);
        if ($id_battle == 0) {//insert
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $id_rig;
        }

        $save_data['last_update'] = date("Y-m-d H:i:s");

        $battle->import($save_data);

        R::store($battle);

        /* is updeting now ?  */
        if ($id_rig != 0) {//edit
            unset_update_rig_now($id_rig);
        }

        $app->redirect(BASE_URL . '/results_battle/' . $id_rig . '/1/3');
    });
});

/* ----------- END results battle PART 2 -------------- */



/* ----------- results battle PART 3-------------- */
$app->group('/results_battle_part_3', function () use ($app, $log) {

    //save PART 3
    $app->post('/:id_rig', function ($id_rig) use ($app) {

        //print_r($_POST);
//exit();

        $save_data = array();
        $save_data['s_peop_dtp'] = (empty($app->request()->post('s_peop_dtp'))) ? 0 : intval($app->request()->post('s_peop_dtp'));
        $save_data['s_chi_dtp'] = (empty($app->request()->post('s_chi_dtp'))) ? 0 : intval($app->request()->post('s_chi_dtp'));
        $save_data['d_dead_dtp'] = (empty($app->request()->post('d_dead_dtp'))) ? 0 : intval($app->request()->post('d_dead_dtp'));

        $save_data['s_peop_water'] = (empty($app->request()->post('s_peop_water'))) ? 0 : intval($app->request()->post('s_peop_water'));
        $save_data['s_chi_water'] = (empty($app->request()->post('s_chi_water'))) ? 0 : intval($app->request()->post('s_chi_water'));
        $save_data['d_dead_water'] = (empty($app->request()->post('d_dead_water'))) ? 0 : intval($app->request()->post('d_dead_water'));


        $save_data['s_people_grunt'] = (empty($app->request()->post('s_people_grunt'))) ? 0 : intval($app->request()->post('s_people_grunt'));
        $save_data['s_chi_grunt'] = (empty($app->request()->post('s_chi_grunt'))) ? 0 : intval($app->request()->post('s_chi_grunt'));

        $save_data['s_people_kon'] = (empty($app->request()->post('s_people_kon'))) ? 0 : intval($app->request()->post('s_people_kon'));
        $save_data['s_chi_kon'] = (empty($app->request()->post('s_chi_kon'))) ? 0 : intval($app->request()->post('s_chi_kon'));

        $save_data['s_people_cons'] = (empty($app->request()->post('s_people_cons'))) ? 0 : intval($app->request()->post('s_people_cons'));
        $save_data['s_chi_cons'] = (empty($app->request()->post('s_chi_cons'))) ? 0 : intval($app->request()->post('s_chi_cons'));

        $save_data['col_arg'] = (empty($app->request()->post('col_arg'))) ? 0 : $app->request()->post('col_arg');
        $save_data['col_was'] = (empty($app->request()->post('col_was'))) ? 0 : $app->request()->post('col_was');


        $save_data['ins_kill_free'] = (empty($app->request()->post('ins_kill_free'))) ? 0 : intval($app->request()->post('ins_kill_free'));
        $save_data['ins_kill_charge'] = (empty($app->request()->post('ins_kill_charge'))) ? 0 : intval($app->request()->post('ins_kill_charge'));
        $save_data['ins_kill_free_threat'] = (empty($app->request()->post('ins_kill_free_threat'))) ? 0 : intval($app->request()->post('ins_kill_free_threat'));
        $save_data['ins_kill_charge_estate'] = (empty($app->request()->post('ins_kill_charge_estate'))) ? 0 : intval($app->request()->post('ins_kill_charge_estate'));
        $save_data['ins_kill_charge_dog'] = (empty($app->request()->post('ins_kill_charge_dog'))) ? 0 : intval($app->request()->post('ins_kill_charge_dog'));
        $save_data['ins_kill_free_before_school'] = (empty($app->request()->post('ins_kill_free_before_school'))) ? 0 : intval($app->request()->post('ins_kill_free_before_school'));
        $save_data['ins_kill_free_school'] = (empty($app->request()->post('ins_kill_free_school'))) ? 0 : intval($app->request()->post('ins_kill_free_school'));

        $save_data['hero_in'] = (empty($app->request()->post('hero_in'))) ? 0 : intval($app->request()->post('hero_in'));
        $save_data['hero_out'] = (empty($app->request()->post('hero_out'))) ? 0 : intval($app->request()->post('hero_out'));


        //print_r($save_data);exit();

        $id_battle = (empty($app->request()->post('id_part_3'))) ? 0 : $app->request()->post('id_part_3');

        //save

        $battle = R::load('rb_chapter_3', $id_battle);
        if ($id_battle == 0) {//insert
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $id_rig;
        }

        $save_data['last_update'] = date("Y-m-d H:i:s");

        $battle->import($save_data);

        R::store($battle);

        /* is updeting now ?  */
        if ($id_rig != 0) {//edit
            unset_update_rig_now($id_rig);
        }

        $app->redirect(BASE_URL . '/results_battle/' . $id_rig . '/1/4');
    });
});

/* ----------- END results battle PART 3 -------------- */





/* ----------- results battle for archive 2019 -------------- */
$app->group('/results_battle_for_archive_2019', function () use ($app, $log) {
    // view form
    $app->get('/:is_success', function ($is_success = 0) use ($app) {


        $bread_crumb = array('Результаты боевой работы');
        $data['settings_user'] = getSettingsUser();




        $data['title'] = 'Результаты боевой работы';




        /* select battle for rig from bd */
        $battle = R::getRow('select * from results_battle_archive_2019 WHERE id_region = ? and id_organ = ? and year = ? ', array($_SESSION['id_region'], $_SESSION['id_organ'], 2019));

        if (isset($battle) && !empty($battle))
            $data['id_battle'] = $battle['id'];
        else
            $data['id_battle'] = 0;

        $data['battle'] = $battle;



        $data['is_success'] = $is_success;

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/trunk/header.php', $data);
        $data['path_to_view'] = 'results_battle/for_archive_2019.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/trunk/footer.php');
    });


    $app->post('/', function () use ($app) {


        $save_data = array();
        $save_data['dead_man'] = (empty($app->request()->post('dead_man'))) ? 0 : intval($app->request()->post('dead_man'));
        $save_data['dead_child'] = (empty($app->request()->post('dead_child'))) ? 0 : intval($app->request()->post('dead_child'));


        $save_data['dead_man_fire'] = (empty($app->request()->post('dead_man_fire'))) ? 0 : intval($app->request()->post('dead_man_fire'));
        $save_data['dead_child_fire'] = (empty($app->request()->post('dead_child_fire'))) ? 0 : intval($app->request()->post('dead_child_fire'));

        $save_data['inj_man'] = (empty($app->request()->post('inj_man'))) ? 0 : intval($app->request()->post('inj_man'));
        $save_data['inj_man_fire'] = (empty($app->request()->post('inj_man_fire'))) ? 0 : intval($app->request()->post('inj_man_fire'));

        $save_data['des_build'] = (empty($app->request()->post('des_build'))) ? 0 : intval($app->request()->post('des_build'));
        $save_data['des_build_fire'] = (empty($app->request()->post('des_build_fire'))) ? 0 : intval($app->request()->post('des_build_fire'));

        $save_data['dam_build'] = (empty($app->request()->post('dam_build'))) ? 0 : intval($app->request()->post('dam_build'));
        $save_data['dam_build_fire'] = (empty($app->request()->post('dam_build_fire'))) ? 0 : intval($app->request()->post('dam_build_fire'));


        $save_data['des_teh'] = (empty($app->request()->post('des_teh'))) ? 0 : intval($app->request()->post('des_teh'));
        $save_data['des_teh_fire'] = (empty($app->request()->post('des_teh_fire'))) ? 0 : intval($app->request()->post('des_teh_fire'));


        $save_data['dam_teh'] = (empty($app->request()->post('dam_teh'))) ? 0 : intval($app->request()->post('dam_teh'));
        $save_data['dam_teh_fire'] = (empty($app->request()->post('dam_teh_fire'))) ? 0 : intval($app->request()->post('dam_teh_fire'));


        $save_data['dam_money'] = (empty($app->request()->post('dam_money'))) ? 0 : $app->request()->post('dam_money');
        $save_data['save_wealth'] = (empty($app->request()->post('save_wealth'))) ? 0 : $app->request()->post('save_wealth');


        $save_data['save_man'] = (empty($app->request()->post('save_man'))) ? 0 : intval($app->request()->post('save_man'));
        $save_data['save_child'] = (empty($app->request()->post('save_child'))) ? 0 : intval($app->request()->post('save_child'));

        $save_data['save_man_fire'] = (empty($app->request()->post('save_man_fire'))) ? 0 : intval($app->request()->post('save_man_fire'));
        $save_data['save_child_fire'] = (empty($app->request()->post('save_child_fire'))) ? 0 : intval($app->request()->post('save_child_fire'));


        $save_data['save_mchs'] = (empty($app->request()->post('save_mchs'))) ? 0 : intval($app->request()->post('save_mchs'));


        $save_data['ev_man'] = (empty($app->request()->post('ev_man'))) ? 0 : intval($app->request()->post('ev_man'));
        $save_data['ev_child'] = (empty($app->request()->post('ev_child'))) ? 0 : intval($app->request()->post('ev_child'));

        $save_data['ev_man_fire'] = (empty($app->request()->post('ev_man_fire'))) ? 0 : intval($app->request()->post('ev_man_fire'));
        $save_data['ev_child_fire'] = (empty($app->request()->post('ev_child_fire'))) ? 0 : intval($app->request()->post('ev_child_fire'));


        $save_data['ev_mchs'] = (empty($app->request()->post('ev_mchs'))) ? 0 : intval($app->request()->post('ev_mchs'));



        $save_data['save_an'] = (empty($app->request()->post('save_an'))) ? 0 : intval($app->request()->post('save_an'));

        $save_data['save_an_mchs'] = (empty($app->request()->post('save_an_mchs'))) ? 0 : intval($app->request()->post('save_an_mchs'));





        $save_data['r_teh'] = (empty($app->request()->post('r_teh'))) ? 0 : intval($app->request()->post('r_teh'));
        $save_data['r_teh_fire'] = (empty($app->request()->post('r_teh_fire'))) ? 0 : intval($app->request()->post('r_teh_fire'));
        $save_data['r_life_sector'] = (empty($app->request()->post('r_life_sector'))) ? 0 : intval($app->request()->post('r_life_sector'));
        $save_data['r_live_support'] = (empty($app->request()->post('r_live_support'))) ? 0 : intval($app->request()->post('r_live_support'));


        $save_data['r_other_teh_hs'] = (empty($app->request()->post('r_other_teh_hs'))) ? 0 : intval($app->request()->post('r_other_teh_hs'));
        $save_data['r_nature_ltt'] = (empty($app->request()->post('r_nature_ltt'))) ? 0 : intval($app->request()->post('r_nature_ltt'));

        $save_data['rig_teh_hs'] = (empty($app->request()->post('rig_teh_hs'))) ? 0 : intval($app->request()->post('rig_teh_hs'));
        $save_data['rig_fire'] = (empty($app->request()->post('rig_fire'))) ? 0 : intval($app->request()->post('rig_fire'));
        $save_data['rig_life'] = (empty($app->request()->post('rig_life'))) ? 0 : intval($app->request()->post('rig_life'));
        $save_data['rig_other_teh_hs'] = (empty($app->request()->post('rig_other_teh_hs'))) ? 0 : intval($app->request()->post('rig_other_teh_hs'));
        $save_data['rig_hs_nature'] = (empty($app->request()->post('rig_hs_nature'))) ? 0 : intval($app->request()->post('rig_hs_nature'));

        $save_data['rig_les'] = (empty($app->request()->post('rig_les'))) ? 0 : intval($app->request()->post('rig_les'));
        $save_data['rig_torf'] = (empty($app->request()->post('rig_torf'))) ? 0 : intval($app->request()->post('rig_torf'));
        $save_data['rig_other_zagor'] = (empty($app->request()->post('rig_other_zagor'))) ? 0 : intval($app->request()->post('rig_other_zagor'));
        $save_data['rig_suh_trava'] = (empty($app->request()->post('rig_suh_trava'))) ? 0 : intval($app->request()->post('rig_suh_trava'));
        $save_data['rig_musor'] = (empty($app->request()->post('rig_musor'))) ? 0 : intval($app->request()->post('rig_musor'));

        $save_data['rig_piha'] = (empty($app->request()->post('rig_piha'))) ? 0 : intval($app->request()->post('rig_piha'));
        $save_data['rig_short_zam'] = (empty($app->request()->post('rig_short_zam'))) ? 0 : intval($app->request()->post('rig_short_zam'));
        $save_data['rig_help'] = (empty($app->request()->post('rig_help'))) ? 0 : intval($app->request()->post('rig_help'));
        $save_data['rig_help_org'] = (empty($app->request()->post('rig_help_org'))) ? 0 : intval($app->request()->post('rig_help_org'));
        $save_data['rig_help_people'] = (empty($app->request()->post('rig_help_people'))) ? 0 : intval($app->request()->post('rig_help_people'));
        $save_data['rig_signal'] = (empty($app->request()->post('rig_signal'))) ? 0 : intval($app->request()->post('rig_signal'));

        $save_data['rig_demerk'] = (empty($app->request()->post('rig_demerk'))) ? 0 : intval($app->request()->post('rig_demerk'));
        $save_data['rig_all_zan'] = (empty($app->request()->post('rig_all_zan'))) ? 0 : intval($app->request()->post('rig_all_zan'));
        $save_data['rig_tsu'] = (empty($app->request()->post('rig_tsu'))) ? 0 : intval($app->request()->post('rig_tsu'));
        $save_data['rig_tsz'] = (empty($app->request()->post('rig_tsz'))) ? 0 : intval($app->request()->post('rig_tsz'));
        $save_data['rig_other_zanyatia'] = (empty($app->request()->post('rig_other_zanyatia'))) ? 0 : intval($app->request()->post('rig_other_zanyatia'));

        $save_data['rig_false'] = (empty($app->request()->post('rig_false'))) ? 0 : intval($app->request()->post('rig_false'));
        $save_data['prohie'] = (empty($app->request()->post('prohie'))) ? 0 : intval($app->request()->post('prohie'));


        $id_battle = (empty($app->request()->post('id_battle_2019'))) ? 0 : $app->request()->post('id_battle_2019');

        //save
        $battle = R::load('results_battle_archive_2019', $id_battle);

        if ($id_battle == 0) {//insert
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
        }
        $save_data['last_update'] = date("Y-m-d H:i:s");
        $save_data['year'] = date("Y");

        $save_data['id_region'] = $_SESSION['id_region'];
        $save_data['id_organ'] = $_SESSION['id_organ'];


        $battle->import($save_data);

        R::store($battle);


        $app->redirect(BASE_URL . '/results_battle_for_archive_2019/1');
    });
});

/* ----------- END results battle for archive 2019 -------------- */






/* ----------- trunk -------------- */
$app->group('/trunk', 'is_login', function () use ($app, $log) {

    /* add new trunk */
    $app->post('/add_trunk_ajax', function () use ($app) {

        $name = $app->request()->post('name');
        $is_water = $app->request()->post('is_water');
        //$name = urldecode($name);
        $is_trunk = R::getAll('select * from trunklist where name = ?', array($name));



        if (empty($is_trunk) && $name != '') {

            $trunk = R::dispense('trunklist');
            $save['name'] = $name;
            $save['is_water'] = (isset($is_water) && $is_water == 1) ? 1 : 0;
            $save['date_insert'] = date("Y-m-d H:i:s");
            $save['id_user'] = $_SESSION['id_user'];
            $save['last_update'] = date("Y-m-d H:i:s");

            $trunk->import($save);
            $id = R::store($trunk);

            echo json_encode([
                'id'         => $id,
                'message'    => 'Тип был успешно добавлен в БД',
                "tag_name"   => $name,
                "is_water"   => (isset($is_water) && $is_water == 1) ? 1 : 0,
                "water_text" => (isset($is_water) && $is_water == 1) ? '(водяной)' : ''
                //'removeTagsForm' => getRemoveTagsForm()
            ]);
        }
    });

    /* edit new trunk */
    $app->post('/edit_trunk_ajax', function () use ($app) {

        $name = $app->request()->post('new_name');
        $id = $app->request()->post('id');
        $is_water = $app->request()->post('is_water');

        if ($name != '')
            $is_trunk = R::getAll('select * from trunklist where name = ? and id != ?', array($name, $id));
        else
            $is_trunk = array();



        if (empty($is_trunk) && !empty($id)) {

            $trunk = R::load('trunklist', $id);
            if ($name != '')
                $save['name'] = $name;
            $save['is_water'] = (isset($is_water) && $is_water == 1) ? 1 : 0;
            $save['last_update'] = date("Y-m-d H:i:s");

            $trunk->import($save);
            $id = R::store($trunk);

            $trunk_new = R::load('trunklist', $id);

            echo json_encode([
                //'id' => $id,
                'message'    => 'Редактирование выполнено успешно',
                "tag_name"   => $trunk_new->name,
                "is_water"   => (isset($is_water) && $is_water == 1) ? 1 : 0,
                "water_text" => (isset($is_water) && $is_water == 1) ? '(водяной)' : ''
                //'removeTagsForm' => getRemoveTagsForm()
            ]);
        }
    });

    /* delete trunk */
    $app->post('/del_trunk_ajax', function () use ($app) {

        $id = $app->request()->post('id');

        if (isset($id) && !empty($id)) {

            $trunk = R::load('trunklist', $id);

            if ($trunk->id_user == $_SESSION['id_user']) {

                R::trash($trunk);
            }
        }
    });


    // view form
    $app->get('/:id_rig(/:is_success)', function ($id_rig, $is_success = 0) use ($app) {


        $bread_crumb = array('Подача стволов');
        $data['title_block'] = 'trunks';

        $data['settings_user'] = getSettingsUser();

        $data['reasonrig_with_informing'] = REASONRIG_WITH_INFORMING;

        /* --------- добавить инф о редактируемом вызове ------------ */
        $rig_table_m = new Model_Rigtable();
        $inf_rig = $rig_table_m->selectByIdRig($id_rig); // дата, время, адрес объекта для редактируемого вызова по id
        if ($id_rig != 0) {


            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];

                    $data['id_user'] = $value['id_user'];
                    $data['current_reason_rig'] = $value['id_reasonrig'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }

            $rig_m = new Model_Rig();
            $rig = $rig_m->selectAllById($id_rig);
            $data['rig_time'] = $rig;

            /* is updeting now ?  */
            if (isset($is_success) && $is_success == 0) {
                $rig_m = new Model_Rig();
                $rig = $rig_m->selectAllById($id_rig);

                $is_update_now = is_update_rig_now($rig, $id_rig);
                if (!empty($is_update_now)) {
                    //  echo $is_update_now;
                    $data['is_update_now'] = $is_update_now;
                }
            }
            /* is updeting now ?  */
        }
        /* --------- добавить инф о редактируемом вызове ------------ */


        $data['title'] = 'Подача стволов';

        $data['id_rig'] = $id_rig;


        /* select silymchs for rig from bd */
        $sily_m = new Model_Jrig();
        $data['sily'] = $sily_m->selectAllByIdRig($id_rig);

        $data['trunk_list'] = R::getAll('select * from trunklist order by name ');

        /* trunks for rig */
        $trunk_edit = R::getAll('select tr.*, s.id_teh from trunkrig as tr left join silymchs as s on tr.id_silymchs=s.id where s.id_rig = ? ', array($id_rig));

        /* trunk for delete/edit */
        if ($_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1)
            $data['trunk_for_del'] = R::getAll('select * from trunklist  where is_delete = ? order by name ', array(0));
        else
            $data['trunk_for_del'] = R::getAll('select * from trunklist  where is_delete = ? and id_user = ? order by name ', array(0, $_SESSION['id_user']));

        $trunk_edit_arr = array();

        if (!empty($trunk_edit)) {
            foreach ($trunk_edit as $value) {

                $trunk_edit_arr[$value['id_teh']][] = $value;
            }
        }
        $data['trunk_edit'] = $trunk_edit_arr;

        if (isset($is_success))
            $data['is_success'] = $is_success;

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/trunk/header.php', $data);
        $data['path_to_view'] = 'trunk/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/trunk/footer.php');
    });


    $app->post('/:id_rig', function ($id_rig) use ($app) {

        // print_r($_POST);        echo '<br><br>';
        $sily = $app->request()->post('sily');

        $rig_m=new Model_rig();

        if (isset($sily) && !empty($sily)) {

            foreach ($sily as $id_teh => $value) {

                $id_silymchs = R::getCell('select id from silymchs where id_rig = ? and id_teh = ?', array($id_rig, $id_teh));

                if (!empty($id_silymchs)) {


                    //delete current trunk for rig and car
                    R::exec('DELETE FROM trunkrig  WHERE id_silymchs = ?', array($id_silymchs));

                    //set new trunk

                    $cnt_rows = count($value['time_pod']);
                    for ($j = 0; $j < $cnt_rows; $j++) {

                        $save_sily = array();

                        if (isset($value['trunk'][$j]) && !empty($value['trunk'][$j]) && isset($value['means'][$j]) && !empty($value['means'][$j]) && $value['means'][$j] > 0) {

                            if ($rig_m->isDateTimeValid(trim($value['time_pod'][$j]), "H:i")) {

                                $save_sily['time_pod'] = \DateTime::createFromFormat("H:i", trim($value['time_pod'][$j]))->format('H:i');
                            } else {
                                $save_sily['time_pod'] = '';
                            }


                            $save_sily['id_silymchs'] = $id_silymchs;

                            $save_sily['id_trunk_list'] = $value['trunk'][$j];
                            $save_sily['cnt'] = (isset($value['means'][$j]) && !empty($value['means'][$j])) ? intval($value['means'][$j]) : 0;
                            $save_sily['water'] = $value['water'][$j];


                            //save
                            if (!empty($save_sily)) {
                                // print_r($save_sily); echo '<br><br>';
                                $trunk = R::dispense('trunkrig');
                                $save_sily['date_insert'] = date("Y-m-d H:i:s");
                                $save_sily['id_user'] = $_SESSION['id_user'];
                                $trunk->import($save_sily);
                                R::store($trunk);
                            }
                        }
                    }
                }
            }
        }

        //exit();
        $save_data = array();

        $save_data['s_bef'] = (empty($app->request()->post('s_bef'))) ? 0 : $app->request()->post('s_bef');
        $save_data['s_loc'] = (empty($app->request()->post('s_loc'))) ? 0 : $app->request()->post('s_loc');



        //save
        $rig = R::load('rig', $id_rig);

        if ($id_rig != 0) {//update
            $save_data['last_update'] = date("Y-m-d H:i:s");
        }
        $rig->import($save_data);
        R::store($rig);

        /* is updeting now ?  */
        if ($id_rig != 0) {//edit
            unset_update_rig_now($id_rig);
        }

        $app->redirect(BASE_URL . '/trunk/' . $id_rig . '/1');
    });
});

/* ----------- END trunk -------------- */



/* --------  guide pasp  -------- */

$app->group('/guide_pasp', 'is_login', 'is_permis', function () use ($app, $log) {

    // table
    $app->get('/', function () use ($app) {

        $data['title'] = 'Справочник ПАСП';

        $bread_crumb = array('Справочник ПАСП');
        $data['bread_crumb'] = $bread_crumb;

        $cp = array(8, 9, 12);


        if ($_SESSION['id_level'] == 1 && $_SESSION['id_organ'] == 5) {//rcu
            $data['name_table'] = 'Подразделения по республике';

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp ');
        } elseif ($_SESSION['id_level'] == 3 && !in_array($_SESSION['id_organ'], $cp)) {//rochs
            $data['name_table'] = $_SESSION['locorg_name'];

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ not in(' . implode(',', $cp) . ')', array($_SESSION['id_locorg']));
        } elseif ($_SESSION['id_level'] == 3 && in_array($_SESSION['id_organ'], $cp)) {//rosn pinsk
            $data['name_table'] = $_SESSION['locorg_name'];

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
        } elseif ($_SESSION['id_level'] == 2 && in_array($_SESSION['id_organ'], $cp)) {//rosn, ugz,avia - g. Minsk
            $data['name_table'] = $_SESSION['locorg_name'];

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
        } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] == 3) {//umchs g.Minsk
            $data['name_table'] = 'Подразделения г.Минска';

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array(3));
        } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] != 3) {//umchs
            $data['name_table'] = 'Подразделения области';

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array($_SESSION['id_region']));
        }


        foreach ($data['podr'] as $key => $value) {

            $data['podr'][$key]['address'] = R::getCell('select address from guide_pasp_view where id_pasp = ?', array($value['id']));
        }



        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'guide_pasp/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //form edit
    $app->get('/:id_pasp', function ($id_pasp) use ($app) {

        $data['title'] = 'Справочник ПАСП/Редактировать';

        $bread_crumb = array('Справочник ПАСП', 'Редактировать');
        $data['bread_crumb'] = $bread_crumb;

        $cp = array(8, 9, 12);

        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области

        if ($_SESSION['id_level'] != 1) {
            foreach ($data['region'] as $k => $value) {
                if ($value['id'] != $_SESSION['id_region']) {
                    unset($data['region'][$k]);
                }
            }
        }




        if ($_SESSION['id_level'] == 1 && $_SESSION['id_organ'] == 5) {//rcu
            $data['name_table'] = 'Подразделения по республике';
        } elseif ($_SESSION['id_level'] == 3 && !in_array($_SESSION['id_organ'], $cp)) {//rochs
            $data['name_table'] = $_SESSION['locorg_name'];

            // $data['podr'] = R::getRow('select id,pasp_name, locorg_name, latitude, longitude from pasp where id = ? ', array($id_pasp));
        } elseif ($_SESSION['id_level'] == 3 && in_array($_SESSION['id_organ'], $cp)) {//rosn pinsk
            $data['name_table'] = $_SESSION['locorg_name'];
        } elseif ($_SESSION['id_level'] == 2 && in_array($_SESSION['id_organ'], $cp)) {//rosn, ugz,avia - g. Minsk
            $data['name_table'] = $_SESSION['locorg_name'];
        } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] == 3) {//umchs g.Minsk
            $data['name_table'] = 'Подразделения г.Минска';

            // $data['podr'] = R::getRow('select id,pasp_name, locorg_name, latitude, longitude from pasp where id = ? ', array($id_pasp));
        }

        $data['podr'] = R::getRow('select id,pasp_name, locorg_name, latitude, longitude from pasp where id = ? ', array($id_pasp));

        $edit_guide_pasp = R::findOne('guidepasp', ' id_pasp = ? ', [$id_pasp]);


        $local = new Model_Local();
        // $data['local'] = $local->selectAll(); //районы
        $locality = new Model_Locality();
        //$data['locality'] = $locality->selectAll(); //нас.пункты
        $street = new Model_Street();
        // $data['street'] = $street->selectAll(); //улицы
        $selsovet = new Model_Selsovet();
        //$data['selsovet'] = $selsovet->selectAll();
        $vid_locality_m = new Model_Vid_Locality();
        $data['vid_locality'] = $vid_locality_m->selectAll();

        if (isset($edit_guide_pasp) && !empty($edit_guide_pasp)) {//edit
            //echo $edit_guide_pasp['id_region'];
            $data['edit_podr'] = R::getRow('select * from guidepasp where id_pasp = ?', array($id_pasp));



            /* ------------------ выбор классификаторов с учетом редактируемого вызова ------------------- */
            $data['local'] = $local->selectAllByRegion($edit_guide_pasp['id_region']); //районы для области редактируемого вызова

            if ($edit_guide_pasp['id_local'] != 0) {

                $id_loc = ($edit_guide_pasp['id_local'] < 0) ? 123 : $edit_guide_pasp['id_local'];

                $data['selsovet'] = $selsovet->selectAllByLocal($id_loc); //сельсоветы для района редактируемого вызова
                $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района
            } elseif ($edit_guide_pasp['id_region'] != 0) {
                $data['locality'] = $locality->selectAllByRegion($edit_guide_pasp['id_region']); //нас.пункты области
            }

            if ($edit_guide_pasp['id_locality'] != 0) {
                $data['street'] = $street->selectAllByLocality($edit_guide_pasp['id_locality']); //улицы
            }

            /* ------------------ END выбор классификаторов с учетом редактируемого вызова ------------------- */
        }

        /* ------------- КОНЕЦ Редактирование выезда -------------- */ else {
            $data['edit_podr']['id'] = 0;

            //если по умолчанию выбирать в адресе район - город( Витебск, Жодино,...), то надо подгрузить сразу нас.пункты и улицы
            $city = array(21, 22, 123, 124, 135, 136, 137, 138, 139, 140, 141);

//$_SESSION['auto_local']<0 только для районов г.минска
            if (in_array($_SESSION['auto_local'], $city) || ($_SESSION['auto_local'] < 0)) {//если по умолчанию город выбран
                $data['auto_local_city'] = $city;

                //если районы г.Минска - выбрать нас пунктом г.Минск
                $id_loc = ($_SESSION['auto_local'] < 0) ? 123 : $_SESSION['auto_local'];

                $locality_result = $locality->selectAllByLocal($id_loc); //нас.пункты района
                //print_r($locality_result);
                $data['locality'] = $locality_result;
                foreach ($locality_result as $value) {
                    $id_locality = $value['id'];
                }

                //  echo $id_locality;
                //exit();
                $data['street'] = $street->selectAllByLocality($id_locality); //улицы района
            } else {
                if ($_SESSION['auto_local'] != 0) {

                    //если районы г.Минска - выбрать нас пунктом г.Минск
                    $id_loc = ($_SESSION['auto_local'] < 0) ? 123 : $_SESSION['auto_local'];

                    $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района

                    $data['selsovet'] = $selsovet->selectAllByLocal($_SESSION['auto_local']); //сельсоветы для района
                }
            }


            $data['local'] = $local->selectAllByRegion($_SESSION['id_region']); //районы авторизованной области
        }



        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'guide_pasp/edit_form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //save
    $app->post('/', function () use ($app) {

//         print_r($_POST);exit();

        $id_region = $app->request()->post('id_region');
        $id_local = $app->request()->post('id_local');
        $id_locality = $app->request()->post('id_locality');
        $id_selsovet = $app->request()->post('id_selsovet');
        $id_street = $app->request()->post('id_street');
        $home_number = $app->request()->post('home_number');
        $housing = $app->request()->post('housing');

        $save['id_pasp'] = $app->request()->post('id_pasp');
        $save['id_region'] = (isset($id_region) && !empty($id_region)) ? intval($id_region) : 0;
        $save['id_local'] = (isset($id_local) && !empty($id_local)) ? intval($id_local) : 0;
        $save['id_locality'] = (isset($id_locality) && !empty($id_locality)) ? intval($id_locality) : 0;

        $save['id_selsovet'] = (isset($id_selsovet) && !empty($id_selsovet)) ? intval($id_selsovet) : 0;

        $save['id_street'] = (isset($id_street) && !empty($id_street)) ? $id_street : 0;
        $save['home_number'] = (isset($home_number) && !empty($home_number)) ? $home_number : '-';
        $save['housing'] = (isset($housing) && !empty($housing)) ? $housing : '-'; //корпус, кв, подъезд


        $guide_pasp = R::findOne('guidepasp', ' id_pasp = ? ', [$save['id_pasp']]);

        if (empty($guide_pasp)) {

            $guide_pasp = R::dispense('guidepasp');
            $save['date_insert'] = date('Y-m-d H:i:s');
            $save['id_user'] = $_SESSION['id_user'];
        } else {
            $guide_pasp = R::load('guidepasp', $guide_pasp['id']);
        }
        $save['last_update'] = date('Y-m-d H:i:s');

        $guide_pasp->import($save);

        R::store($guide_pasp);


        $app->redirect(BASE_URL . '/guide_pasp');
    });
});

/* ------------------------- END   guide pasp ------------------------------- */




/* is updeting now ?  */

function is_update_rig_now($rig, $id)
{

    if ($rig['date_start_update'] != null && $rig['now_update_by_user'] != null && $rig['now_update_by_user'] != $_SESSION['id_user']) {
        // if ($rig['date_start_update'] != null && $rig['now_update_by_user'] != null ) {
//        $datetime1 = new DateTime(date('Y-m-d H:i:s'));
//        $datetime2 = new DateTime($rig['date_start_update']);
//        $interval = $datetime1->diff($datetime2);
//        $raznost = $interval->i;
//        $raznost_y = $interval->y;
//        $raznost_d = $interval->d;
//        $raznost_h = $interval->h;
//        $raznost_m = $interval->m;

        $datetime1 = strtotime(date('Y-m-d H:i:s'));
        $datetime2 = strtotime($rig['date_start_update']);
        $interval = abs($datetime2 - $datetime1);
        $raznost = round($interval / 60);

        //if ($raznost < 10 && $raznost_d == 0 && $raznost_h==0 && $raznost_m == 0 && $raznost_y==0) {
        if ($raznost < 10) {
            $name_user = R::getCell('select user_name from permissions where id_user = ?', array($rig['now_update_by_user']));

            // update now
            $is_update_now = 'На текущий момент данный выезд редактируется пользователем "' . $name_user . '". Внесите изменения позже.';
        } elseif ($_SESSION['can_edit'] == 1 && $_SESSION['id_user'] != 2) {//set, that rig is update by user. OVPO is only see rig
            R::exec('UPDATE rig SET now_update_by_user = ?, date_start_update = ? WHERE id = ?', array($_SESSION['id_user'], date('Y-m-d H:i:s'), $id));
        }
    } elseif ($_SESSION['can_edit'] == 1 && $_SESSION['id_user'] != 2) {//set, that rig is update by user. OVPO is only see rig
        R::exec('UPDATE rig SET now_update_by_user = ?, date_start_update = ? WHERE id = ?', array($_SESSION['id_user'], date('Y-m-d H:i:s'), $id));
    }

    return (isset($is_update_now)) ? $is_update_now : '';
}
/* unset updeting now   */

function unset_update_rig_now($id)
{
    $now_update_by_user = R::getCell('select now_update_by_user from rig where id = ?', array($id));

    if ($now_update_by_user != null && $now_update_by_user == $_SESSION['id_user'])
        R::exec('UPDATE rig SET now_update_by_user = ?, date_start_update = ? WHERE id = ?', array(null, null, $id));
}
/* is updeting now -refresh rig table ?  */

function is_update_rig_now_refresh_table($rig, $id)
{

    if ($rig['date_start_update'] != null && $rig['now_update_by_user'] != null && $rig['now_update_by_user'] != $_SESSION['id_user']) {
        //if ($rig['date_start_update'] != null && $rig['now_update_by_user'] != null ) {
//        $datetime1 = new DateTime(date('Y-m-d H:i:s'));
//        $datetime2 = new DateTime($rig['date_start_update']);
//        $interval = $datetime1->diff($datetime2);
//        $raznost = $interval->i;
//        $raznost_y = $interval->y;
//        $raznost_d = $interval->d;
//        $raznost_h = $interval->h;
//        $raznost_m = $interval->m;


        $datetime1 = strtotime(date('Y-m-d H:i:s'));
        $datetime2 = strtotime($rig['date_start_update']);
        $interval = abs($datetime2 - $datetime1);
        $raznost = round($interval / 60);
        // echo 'Diff. in minutes is: ' . $minutes;
        //echo $raznost;exit();
        //if ($raznost < 10 && $raznost_d == 0 && $raznost_h==0 && $raznost_m == 0 && $raznost_y==0) {
        if ($raznost < 10) {
            $name_user = R::getCell('select user_name from permissions where id_user = ?', array($rig['now_update_by_user']));

            // update now
            $is_update_now = $name_user . ' редактирует вызов';
        } else {
            // R::exec('UPDATE rig SET now_update_by_user = ?, date_start_update = ? WHERE id = ?', array(null, null, $id));
        }
    }

    return (isset($is_update_now)) ? $is_update_now : '';
}
/* is updeting now ?  */



/* ------------- ajax is update rig now or no --------------- */
$app->post('/is_update_rig_now', function () use ($app) {


    $arr_id_rigs = $app->request()->post('id_rigs');

    $arr_res = array();
    foreach ($arr_id_rigs as $value) {
        //$arr_res[$value] = 't' . $value;

        $rig = R::getRow('select * from rig where id = ?', array($value));
        $is_update_now = is_update_rig_now_refresh_table($rig, $value);
        if (!empty($is_update_now)) {

            $arr_res[$value] = '<div class="typing-indicator" aria-hidden="true" data-toggle="tooltip" data-placement="top" '
                . 'title="' . $is_update_now . '">

    <span></span>
    <span></span>
    <span></span>
</div>';
        } else {
            $arr_res[$value] = '';
        }
    }
    echo json_encode($arr_res);
});
/* ------------- END ajax is update rig now or no --------------- */


/* get results battle */

function getResultsBattle($rig)
{
    foreach ($rig as $k => $r) {
        $result = R::getRow('select * from results_battle where id_rig = ?', array($r['id']));

        if ($r['id_reasonrig'] == REASON_FIRE || $r['id_reasonrig'] == REASON_HS) {
            $rb1 = R::getRow('select * from rb_chapter_1 where id_rig = ?', array($r['id']));
            $rb2 = R::getRow('select * from rb_chapter_2 where id_rig = ?', array($r['id']));
            $rb3 = R::getRow('select * from rb_chapter_3 where id_rig = ?', array($r['id']));

            $rb_arr = [];
            $rb_1_arr = [];
            $rb_2_arr = [];
            $rb_3_arr = [];
            $exclude = array('id', 'date_insert', 'id_user', 'id_rig', 'last_update');


            if (!empty($result)) {
                foreach ($result as $n => $value) {
                    if (!in_array($n, $exclude))
                        $rb_arr[] = $value;
                }
            }

            if (!empty($rb1)) {
                foreach ($rb1 as $n => $value) {
                    if (!in_array($n, $exclude))
                        $rb_1_arr[] = $value;
                }
            }

            if (!empty($rb2)) {
                foreach ($rb2 as $n => $value) {
                    if (!in_array($n, $exclude))
                        $rb_2_arr[] = $value;
                }
            }
            if (!empty($rb3)) {
                foreach ($rb3 as $n => $value) {
                    if (!in_array($n, $exclude))
                        $rb_3_arr[] = $value;
                }
            }

            $max = (isset($rb_arr) && !empty($rb_arr)) ? max($rb_arr) : 0;
            $max_rb1 = (isset($rb_1_arr) && !empty($rb_1_arr)) ? max($rb_1_arr) : 0;
            $max_rb2 = (isset($rb_2_arr) && !empty($rb_2_arr)) ? max($rb_2_arr) : 0;
            $max_rb3 = (isset($rb_3_arr) && !empty($rb_3_arr)) ? max($rb_3_arr) : 0;
            //      echo $r['id'];        echo '<br>';
            //echo $max.'='.$max_rb1.'='.$max_rb2.'='.$max_rb3; echo '<br>'; echo '<br>';

            if ($max == 0 && $max_rb1 == 0 && $max_rb2 == 0 && $max_rb3 == 0)
                $rig[$k]['is_empty_rb'] = 1;
        }


        if (!empty($result)) {
            //  echo $is_update_now;
            $rig[$k]['dead_man'] = $result['dead_man'];
            $rig[$k]['dead_child'] = $result['dead_child'];
            $rig[$k]['save_man'] = $result['save_man'];
            $rig[$k]['inj_man'] = $result['inj_man'];
            $rig[$k]['ev_man'] = $result['ev_man'];
        } else {
            $rig[$k]['dead_man'] = 0;
            $rig[$k]['save_man'] = 0;
            $rig[$k]['inj_man'] = 0;
            $rig[$k]['ev_man'] = 0;
        }
        //  exit();
    }
    //exit();
    return $rig;
}
/* END get results battle */

function getSettingsUserMode()
{
    $settings_user_bd = R::getAll('SELECT  *
 FROM settings_user_br_table  WHERE id_user = ?', array($_SESSION['id_user']));
    $settings_user = array();
    foreach ($settings_user_bd as $value) {
        $settings_user[] = $value['id_reasonrig'];
    }
    return $settings_user;
}

function getTrunkByRigs($id_rig_arr)
{
    $trunk = array();
    if (!empty($id_rig_arr))
        $trunk = R::getAll('select tr.*, s.id_rig, s.id_teh from trunkrig as tr left join silymchs as s on tr.id_silymchs=s.id where s.id_rig IN( ' . implode(',', $id_rig_arr) . ')');
    $trunk_by_rig = array();
    if (!empty($trunk)) {
        foreach ($trunk as $value) {
            $trunk_by_rig[$value['id_rig']][] = $value;
        }
    }
    return $trunk_by_rig;
}
/* ------------- ajax change mode --------------- */
$app->post('/change_mode', function () use ($app) {


    $is_change = $app->request()->post('val');

    if ($is_change == 1) {
        $_SESSION['br_table_mode'] = 1;

        if (isset($_SESSION['remember_filter_reasonrig']) && !empty($_SESSION['remember_filter_reasonrig'])) {
            unset($_SESSION['remember_filter_reasonrig']);
        }
    } else {
        if (isset($_SESSION['br_table_mode']))
            unset($_SESSION['br_table_mode']);
    }

    $res = 1;

    echo json_encode($res);
});
/* ------------- END ajax change mode --------------- */



$app->group('/maps', function () use ($app) {

    function rigs_for_map($reason_rig_array,$filter=NULL)
    {
        $rig_m = new Model_Rigtable();
        $points = $rig_m->selectAllRigByReason($reason_rig_array, 0,0,$filter);
        return $points;
    }
    $app->get('/', function () use ($app) {

        $data['map_mode'] = 1;

        /* classif */

        $data['region'] = R::getAll('select * from ss.regions'); //области
        $data['local'] = R::getAll('select * from ss.locals'); //районы


        /* set reasonrig
         * 14 - other
         * 34 - fire
         * 38 - help for people
         * 76 - help for organization
         * 79 - fire in eco system */

        $reasons = array(14, 34, 38, 76, 79);

        $reason_rig = R::getAll('select name from reasonrig where id IN(' . implode(',', $reasons) . ')');
        $reasons_names = array();
        foreach ($reason_rig as $value) {
            $reasons_names[] = trim(stristr($value['name'], ' '));
        }
        $data['reasons_names'] = $reasons_names;


        $rigs = rigs_for_map($reasons);
        $ids_rig = array();
        foreach ($rigs as $value) {
            if (!in_array($value['id'], $ids_rig)) {
                $ids_rig[] = $value['id'];
            }
        }
        $data['cnt_rigs'] = count($ids_rig);

        $app->render('layouts/maps/header.php');
        $data['path_to_view'] = 'maps/index.php';
        $app->render('layouts/div_wrapper_map.php', $data);
        $app->render('layouts/maps/footer.php');
    });


    $app->get('/getjson', function () use ($app) {

        $data['map_mode'] = 1;

        /* data for map */
        //$points=R::getAll('select * from rigtable where  latitude is not null and longitude is not null AND latitude <> 0 AND longitude <> 0');


        /* set reasonrig
         * 14 - other
         * 34 - fire
         * 38 - help for people
         * 76 - help for organization
         * 79 - fire in eco system */
        $reasons = array(14, 34, 38, 76, 79);

        $points = rigs_for_map($reasons);
        $res1 = array();

        foreach ($points as $value) {
            $res = array();
            $res['location'] = array('type' => 'Point', 'coordinates' => array($value['longitude'], $value['latitude']));
            $res['reasonrig_name'] = '.:' . trim(stristr($value['reasonrig_name'], ' ')) . ':.';

            if (!empty($value['address'])) {
                $obl = '';
                if ($value['id_region'] != 3)
                    $obl = $value['region_name'] . ' обл., ';

                $res['address'] = $obl . $value['address'];
            } else
                $res['address'] = $value['additional_field_address'];


            if (!empty($value['object']))
                $res['object'] = $value['object'];

            if ($value['id_reasonrig'] == 14)
                $res['new_icon'] = 'assets/images/leaflet/other.png';
            elseif ($value['id_reasonrig'] == 34)
                $res['new_icon'] = 'assets/images/leaflet/fire.png';
            elseif ($value['id_reasonrig'] == 38)
                $res['new_icon'] = 'assets/images/leaflet/help.png';
            elseif ($value['id_reasonrig'] == 76)
                $res['new_icon'] = 'assets/images/leaflet/help.png';
            elseif ($value['id_reasonrig'] == 79)
                $res['new_icon'] = 'assets/images/leaflet/priroda.png';
            else
                $res['new_icon'] = 'assets/images/leaflet/point123.png';

            $res['card_by_rig_url'] = 'card_rig/0/' . $value['id'];

            $res1[] = $res;

            /* ss */

//        $podr = R::getAll('select p.*, (
//    6371 * ACOS (
//      COS ( RADIANS(?) )
//      * COS( RADIANS( p.`latitude` ) )
//      * COS( RADIANS( p.`longitude` ) - RADIANS(?) )
//      + SIN ( RADIANS(?) )
//      * SIN( RADIANS( p.`latitude` ) )
//    )
//  ) AS distance from journal.pasp as p where p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 '
//                        . 'and p.longitude is not null HAVING distance < 5 ',array($value['latitude'],$value['longitude'],$value['latitude']));
//
//        if (!empty($podr)) {
//                foreach ($podr as $row) {
//                    $ss = array();
//                    $ss['location'] = array('type' => 'Point', 'coordinates' => array($row['longitude'], $row['latitude']));
//                    $ss['address'] = $value['address_disloc'];
//                   // $ss['new_icon'] = 'assets/leaflet/images/marker-icon-violet.png';
//                    $res1[] = $ss;
//                }
//            }
        }


//
//$res['location']=array('type'=>'Point','coordinates'=>array("27.546803", "53.855383"));
//$res['name']='hh';
//$res['new_icon']='assets/images/leaflet/coffee.png';
//$res1[]=$res;


        $data['points'] = json_encode($res1);


        echo $data['points'];
    });


    /* get pasp from kusis */
    $app->post('/getjson', function () use ($app) {

        $data['map_mode'] = 1;
        $rig_m = new Model_Rigtable();

        /* data for map */

        $res1 = array();
        $res = array();
        $ecxlude_ids = array();
        $dubl_ids = [];

        $res['location'] = array('type' => 'Point', 'coordinates' => array("27.546803", "53.855383"));
        $res['name'] = 'hh';

        $id_region = $app->request()->post('id_region');
        $id_local = $app->request()->post('id_local');
        $show_closest_podr = $app->request()->post('show_closest_podr');

        $filter['id_region'] = $id_region;
        $filter['id_local'] = $id_local;

        if ($show_closest_podr == 0 || (isset($id_region) && !empty($id_region)) || (isset($id_local) && !empty($id_local))) {


            $sql = 'select * from journal.pasp as p where p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 and p.longitude is not null ';

            if (isset($id_region) && !empty($id_region)) {
                $sql = $sql . ' and p.id_region IN(' . implode(',', $id_region) . ') ';
            }
            if (isset($id_local) && !empty($id_local)) {
                $sql = $sql . ' and p.id_local IN(' . implode(',', $id_local) . ')';
            }
            $sql = $sql . ' order by p.pasp_name asc';

            $podr = R::getAll($sql);



            if (!empty($podr)) {

                foreach ($podr as $value) {

                    if (!in_array($value['id'], $dubl_ids)) {
                        $ecxlude_ids[] = $value['id'];

                        $res = array();
                        $res['id'] = $value['id'];
                        $res['location'] = array('type' => 'Point', 'coordinates' => array($value['longitude'], $value['latitude']));
                        $res['locorg_name'] = $value['locorg_name'];
                        $res['pasp_name'] = $value['pasp_name'];

                        $obl = '';
                        if ($value['id_region'] != 3)
                            $obl = $value['region_name'] . ' обл., ';

                        $res['address_disloc'] = $obl . $value['address_disloc'];
                        // $res['new_icon'] = 'assets/images/leaflet/coffee.png';
                        $res['ss_url_text'] = 'перейти в карточку сил и средств';
                        $res['ss_url'] = '/ss/card/' . $value['id_region'] . '/' . $value['id_loc_org'];


                        /* dublicate pasp */
                        $coords['longitude'] = $value['longitude'];
                        $coords['latitude'] = $value['latitude'];
                        $coords['id_region'] = $id_region;
                        $coords['id_local'] = $id_local;
                        $coords['id'] = $value['id'];



                        //echo $res['pasp_name'];
                        $duplicate_pasp = $rig_m->get_dublicate_pasp_by_coords($coords);
                        // print_r($duplicate_pasp);
                        if (!empty($duplicate_pasp)) {

                            foreach ($duplicate_pasp as $key => $dublicate) {
                                $dubl_ids[] = $dublicate['id'];
                                if ($dublicate['id_loc_org'] != $value['id_loc_org'])
                                    $res['pasp_name'] = $res['pasp_name'] . '; ' . $dublicate['locorg_name'] . ', ' . $dublicate['pasp_name'];
                                else
                                    $res['pasp_name'] = $res['pasp_name'] . '; ' . $dublicate['pasp_name'];
                            }
                        }



                        $res1[] = $res;
                    }
                }
            }
            else {//empty result
                $res = array();
                $res1[] = $res;
            }
        }

        if ($show_closest_podr == 1) {

            /* set reasonrig
             * 14 - other
             * 34 - fire
             * 38 - help for people
             * 76 - help for organization
             * 79 - fire in eco system */
            $reasons = array(14, 34, 38, 76, 79);
            $points = rigs_for_map($reasons, $filter);

            foreach ($points as $value) {

                $circle = [];
                $circle['is_circle'] = 1;
                $circle['lat'] = $value['latitude'];
                $circle['lon'] = $value['longitude'];
                $res1[] = $circle;

                /* ss */

                $podr = R::getAll('select p.*, (
    6371 * ACOS (
      COS ( RADIANS(?) )
      * COS( RADIANS( p.`latitude` ) )
      * COS( RADIANS( p.`longitude` ) - RADIANS(?) )
      + SIN ( RADIANS(?) )
      * SIN( RADIANS( p.`latitude` ) )
    )
  ) AS distance from journal.pasp as p where p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 '
                        . 'and p.longitude is not null HAVING distance < 5 order by p.pasp_name asc', array($value['latitude'], $value['longitude'], $value['latitude']));

                if (!empty($podr)) {
                    foreach ($podr as $row) {


                        if (!in_array($row['id'], $ecxlude_ids) && !in_array($row['id'], $dubl_ids)) {
                            $ss = array();
                            $ss['location'] = array('type' => 'Point', 'coordinates' => array($row['longitude'], $row['latitude']));
                            $ss['locorg_name'] = $row['locorg_name'];
                            $ss['pasp_name'] = $row['pasp_name'];

                            $obl = '';
                            if ($row['id_region'] != 3)
                                $obl = $row['region_name'] . ' обл., ';

                            $ss['address_disloc'] = $obl . $row['address_disloc'];
                            $ss['ss_url_text'] = 'перейти в карточку сил и средств';
                            //$ss['ss_url_text'] = 'просмотреть карточку сил и средств';
                            $ss['ss_url'] = '/ss/card/' . $row['id_region'] . '/' . $row['id_loc_org'];
                            $ss['is_closest_podr'] = 1;
                            $ss['distance'] = number_format($row['distance'], 1, '.', '');

                            /* dublicate pasp */
                            $coords['longitude'] = $row['longitude'];
                            $coords['latitude'] = $row['latitude'];
                            $coords['id_region'] = $id_region;
                            $coords['id_local'] = $id_local;
                            $coords['id'] = $row['id'];

                            $duplicate_pasp = $rig_m->get_dublicate_pasp_by_coords($coords);

                            if (!empty($duplicate_pasp)) {

                                foreach ($duplicate_pasp as $key => $dublicate) {
                                    // echo $ss['pasp_name'] . '; ' . $dublicate['pasp_name'];
                                    $dubl_ids[] = $dublicate['id'];
                                    if ($dublicate['id_loc_org'] != $row['id_loc_org'])
                                        $ss['pasp_name'] = $ss['pasp_name'] . ' (' . $dublicate['locorg_name'] . ', ' . $dublicate['pasp_name'].')';
                                    else
                                        $ss['pasp_name'] = $ss['pasp_name'] . ' (' . $dublicate['pasp_name'].')';
                                }
                            }


                            $res1[] = $ss;
                        }
                        else if (in_array($row['id'], $ecxlude_ids)) {

                            foreach ($res1 as $a => $arr) {
                                if (isset($arr['id']) && $arr['id'] == $row['id']) {
                                    $res1[$a]['distance'] = number_format($row['distance'], 1, '.', '');
                                }
                            }
                        }
                    }
                }
            }
        } else {

        }


        if (empty($res1))
            $res1['error'] = 'Нет данных для отображения';



        $data['points'] = json_encode($res1);


        echo $data['points'];
    });




    /* classif. get locals by region */
    $app->post('/get_locals_by_region', function () use ($app) {

        //$data['map_mode']=1;

        $ids_region = $app->request()->post('ids_region');
        // print_r($ids_region);
        if (isset($ids_region) && !empty($ids_region)) {
            $locals = R::getAll('select l.*, r.name as region_name from ss.locals as l left join ss.regions as r on l.id_region=r.id where l.id_region IN(' . implode(',', $ids_region) . ')  ORDER BY id_region, name ASC');
            //$locals = R::getAll('select * from journal.locals where  id !=123 ORDER BY sort, name ASC');
            if (!empty($locals)) {
                echo json_encode($locals);
            }
        }
    });
});











/* ----------------------------- UMTO ------------------------- */
$app->group('/maps_for_mes', function () use ($app) {



    $app->get('/', function () use ($app) {

        $regions = R::getAll('select * from ss.regions');
        $cp_region[] = array('id' => 8, 'name' => 'РОСН');
        $cp_region[] = array('id' => 9, 'name' => 'УГЗ');
        $cp_region[] = array('id' => 12, 'name' => 'Авиация');
        $data['region'] = array_merge($regions, $cp_region);


        $exclude_views_car = array(115, 33, 102, 125, 16, 85, 13, 103, 66, 61, 129, 14, 114, 52, 73, 70, 112, 86, 117, 77, 87, 79, 74, 84, 30, 97, 95, 56, 101, 126, 98, 76, 128, 127, 67, 68, 132,
            133, 134, 88, 69, 89, 91, 108, 8, 106, 135, 41, 90, 99, 9, 92, 118, 78, 109, 113, 82, 107, 71, 124, 96, 131, 136);
        $data['name_car'] = R::getAll('select * from ss.views WHERE id not in (' . implode(',', $exclude_views_car) . ') order by name ASC');
        $data['type_car'] = R::getAll('select * from ss.types order by name ASC');
        $data['vid_car'] = R::getAll('select * from ss.vid order by name ASC');
        //$data['ob_ac'] = R::getAll('select distinct(v), v  from ss.card where v is not null and v <> ""  ORDER BY v ASC ');


        /* set grochs of minsk by default */
        /* ptc, cou, schlchs */
        $exclude_diviz = array(7, 8, 9);

        $cp_exclude = array(ROSN, UGZ, AVIA);

        $only_organs_in_region = array(GOCHS, ROCHS, GROCHS, PASO, PASOO);
        /* without ptc, cou */
        $data['grochs'] = R::getAll('select distinct(id_loc_org), region_name, locorg_name as name, id_loc_org as id  from journal.pasp where id_region = ? and id_divizion NOT IN(' . implode(',', $exclude_diviz) . ') and id_organ IN(' . implode(',', $only_organs_in_region) . ') and id_organ NOT IN(' . implode(',', $cp_exclude) . ')  ORDER BY region_name, locorg_name ASC ', array(3));


        $app->render('layouts/maps_for_mes/header.php');
        $data['path_to_view'] = 'maps_for_mes/index.php';
        $app->render('layouts/maps_for_mes/div_wrapper_map.php', $data);
        $app->render('layouts/maps_for_mes/footer.php');


//        $app->render('layouts/maps_for_mes/header.php');
//        $data['path_to_view'] = 'maps_for_mes/index.php';
//        $app->render('layouts/maps_for_mes/div_wrapper_map.php', $data);
//        $app->render('layouts/maps_for_mes/footer.php');
    });


    /* default ^ by minsk, AC */
    $app->get('/getjson', function () use ($app) {

        /* ptc, cou, schlchs */
        $exclude_diviz = array(7, 8, 9);
        $exclude_organs_in_region = array(UMCHS, RCU);


        $res1 = array();

        $filter['id_region'] = array(3); //minsk default
        $filter['id_name_car'] = array(1); //AC default

        $res1 = getDataFilter($filter);

        $data['points'] = json_encode($res1);


        echo $data['points'];
    });


    /* get cars from kusis - cars */
    $app->post('/getjson', function () use ($app) {


        $exclude_diviz = array(7, 8, 9);
        $exclude_organs_in_region = array(UMCHS, RCU);

        /* data for map */

        $res1 = array();

        $filter['id_region'] = $app->request()->post('id_region');
        $filter['id_local'] = $app->request()->post('id_local');
        $filter['id_pasp'] = $app->request()->post('id_pasp');

        $filter['id_name_car'] = $app->request()->post('id_name_car');
        $filter['id_type_car'] = $app->request()->post('id_type_car'); //boevay, res
        $filter['id_ob_car'] = $app->request()->post('id_ob_car'); // v
        $filter['id_vid_car'] = $app->request()->post('id_vid_car'); // spec, osn,...



        $is_show_name_pasp = $app->request()->post('show_number_pasp');
        if (isset($is_show_name_pasp) && !empty($is_show_name_pasp) && $is_show_name_pasp == 1) {
            $filter['show_number_pasp'] = 1;
        }

        $res1 = getDataFilter($filter);



        if (empty($res1))
            $res1['error'] = 'Нет данных для отображения';


        $data['points'] = json_encode($res1);


        echo $data['points'];
    });




    /* classif. get locals by region */
    $app->post('/get_grochs_by_region', function () use ($app) {


        $ids_region = $app->request()->post('ids_region');


        /* ptc, cou, schlchs */
        $exclude_diviz = array(7, 8, 9);

        $cp_exclude = array(ROSN, UGZ, AVIA);

        $only_organs_in_region = array(GOCHS, ROCHS, GROCHS, PASO, PASOO);

        $grochs_by_region = array();


        if (isset($ids_region) && !empty($ids_region)) {


            /* rosn, ugz, avia */
            if (in_array(ROSN, $ids_region)) {

                foreach ($ids_region as $key => $value) {
                    if ($value == ROSN) {
                        unset($ids_region[$key]);
                    }
                }

                /* without ptc, cou */
                $grochs_by_rosn = R::getAll('select distinct(id_loc_org), region_name, locorg_name as name, id_loc_org as id  from journal.pasp where id_organ = ? and id_divizion NOT IN(' . implode(',', $exclude_diviz) . ')  ORDER BY region_name, locorg_name ASC ', array(ROSN));
            }
            if (in_array(UGZ, $ids_region)) {

                foreach ($ids_region as $key => $value) {
                    if ($value == UGZ) {
                        unset($ids_region[$key]);
                    }
                }
                /* without ptc, cou */
                $grochs_by_ugz = R::getAll('select distinct(id_loc_org), region_name, locorg_name as name, id_loc_org as id  from journal.pasp where id_organ = ? and id_divizion NOT IN(' . implode(',', $exclude_diviz) . ')  ORDER BY region_name, locorg_name ASC ', array(UGZ));
            }
            if (in_array(AVIA, $ids_region)) {

                foreach ($ids_region as $key => $value) {
                    if ($value == AVIA) {
                        unset($ids_region[$key]);
                    }
                }
                /* without ptc, cou */
                $grochs_by_avia = R::getAll('select distinct(id_loc_org), region_name, locorg_name as name, id_loc_org as id  from journal.pasp where id_organ = ? and id_divizion NOT IN(' . implode(',', $exclude_diviz) . ')  ORDER BY region_name, locorg_name ASC ', array(AVIA));
            }

            /* only: GOCHS, ROCHS, GROCHS, PASO, PASOO. without rosn, ugz, avia. without ptc, cou, umchs  */
            if ((!empty($ids_region)))
                $grochs_by_region = R::getAll('select distinct(id_loc_org), region_name, locorg_name as name, id_loc_org as id  from journal.pasp where id_region IN(' . implode(',', $ids_region) . ') and id_divizion NOT IN(' . implode(',', $exclude_diviz) . ') and id_organ IN(' . implode(',', $only_organs_in_region) . ') and id_organ NOT IN(' . implode(',', $cp_exclude) . ')  ORDER BY region_name, locorg_name ASC ');

            if (isset($grochs_by_rosn))
                $grochs_by_region = array_merge($grochs_by_region, $grochs_by_rosn);

            if (isset($grochs_by_ugz))
                $grochs_by_region = array_merge($grochs_by_region, $grochs_by_ugz);

            if (isset($grochs_by_avia))
                $grochs_by_region = array_merge($grochs_by_region, $grochs_by_avia);


            if (!empty($grochs_by_region)) {
                echo json_encode($grochs_by_region);
            }
        }
    });



    /* classif. get pasp by grochs */
    $app->post('/get_pasp_by_grochs', function () use ($app) {

        /* ptc, cou, schlchs */
        $exclude_diviz = array(7, 8, 9);

        $ids_grochs = $app->request()->post('ids_grochs');
        // print_r($ids_region);
        if (isset($ids_grochs) && !empty($ids_grochs)) {
            // $locals = R::getAll('select l.*, r.name as region_name from ss.locals as l left join ss.regions as r on l.id_region=r.id where l.id_region IN(' . implode(',', $ids_region) . ')  ORDER BY id_region, name ASC');
            $pasp = R::getAll('select distinct(pasp_id), region_name, pasp_name as name, pasp_id as id, locorg_name   from journal.pasp where id_loc_org IN(' . implode(',', $ids_grochs) . ')  and id_divizion NOT IN(' . implode(',', $exclude_diviz) . ')  ORDER BY region_name, locorg_name ASC ');
            if (!empty($pasp)) {
                echo json_encode($pasp);
            }
        }
    });



    /* classif. get ob ac */
//    $app->post('/get_ob_ac', function () use ($app) {
//
//        //$data['map_mode']=1;
//        $ids_region = $app->request()->post('id_region');
//        $ids_grochs = $app->request()->post('id_grochs');
//        $ids_pasp = $app->request()->post('id_pasp');
//
//
//
//        if (isset($ids_pasp) && $ids_pasp != 0) {
//            $ob = R::getAll('select distinct(v), v  from ss.card where id_record IN(' . implode(',', $ids_pasp) . ') and v is not null and v <> "" ORDER BY v ASC ');
//        } elseif (isset($ids_grochs) && $ids_grochs != 0) {
//            $ob = R::getAll('select distinct(v), v  from ss.card where id_card IN(' . implode(',', $ids_grochs) . ') and v is not null and v <> ""  ORDER BY v ASC ');
//        } elseif (isset($ids_region) && $ids_region != 0) {
//            $ob = R::getAll('select distinct(v), v  from ss.card where region IN(' . implode(',', $ids_region) . ') and v is not null and v <> ""  ORDER BY v ASC ');
//        } else {//by RB
//            $ob = R::getAll('select distinct(v), v  from ss.card where v is not null and v <> ""  ORDER BY v ASC ');
//        }
//
//
//        if (!empty($ob)) {
//            echo json_encode($ob);
//        }
//    });



    /* right table */
    $app->post('/get_right_table', function () use ($app) {

        $exclude_diviz = array(7, 8, 9);
        $exclude_organs_in_region = array(UMCHS, RCU);

        /* data for map */

        $res1 = array();

        $filter['id_region'] = $app->request()->post('id_region');
        $filter['id_local'] = $app->request()->post('id_local');
        $filter['id_pasp'] = $app->request()->post('id_pasp');

        $filter['id_name_car'] = $app->request()->post('id_name_car');
        $filter['id_type_car'] = $app->request()->post('id_type_car'); //boevay, res
        $filter['id_ob_car'] = $app->request()->post('id_ob_car'); // v
        $filter['id_vid_car'] = $app->request()->post('id_vid_car'); // spec, osn,...


        $res1 = getRightTable($filter);
        $data['res'] = $res1;

        $view = $app->render('maps_for_mes/right_table.php', $data);
        $response = ['success' => TRUE, 'view' => $view];
    });

    function getDataFilter($filter, $get_sql = 0)
    {

        $exclude_diviz = array(7, 8, 9);
        $exclude_organs_in_region = array(UMCHS, RCU);

        /* data for map */

        $res1 = array();
        $res = array();
        $sql = '';

        if ($get_sql == 0) {

            $sql = 'select distinct(p.tid), p.longitude, p.latitude,p.disloc, p.mark,p.f, p.pasp,p.region, p.id_card, p.id_record,p.orgid, p.name_teh,p.divizid,p.divizion_num,p.extra_pasp_num,p.extra_pasp_name_or_number from ss.card as p where p.name_teh <> "-" and p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 and p.longitude is not null'
                . ' and p.divizid NOT IN(' . implode(',', $exclude_diviz) . ') and p.orgid NOT IN(' . implode(',', $exclude_organs_in_region) . ')';
        }

        if (isset($filter['id_region']) && !empty($filter['id_region'])) {
            $sql_reg = '';
            $sql_rosn = '';
            $sql_ugz = '';
            $sql_avia = '';
            $sql_all_reg = '';




            foreach ($filter['id_region'] as $key => $value) {
                /* rosn, ugz, avia */
                if ($value == ROSN) {
                    unset($filter['id_region'][$key]);

                    $sql_rosn = ' p.orgid = 8 ';
                }


                /* without ptc, cou */
                if ($value == UGZ) {
                    unset($filter['id_region'][$key]);
                    $sql_ugz = ' p.orgid = 9 ';
                }


                if ($value == AVIA) {
                    unset($filter['id_region'][$key]);
                    $sql_avia = ' p.orgid = 12 ';
                }
            }





            if (!empty($filter['id_region']))
                $sql_reg = $sql_reg . '  p.region IN(' . implode(',', $filter['id_region']) . ') ';

            if (!empty($sql_rosn))
                $sql_all_reg = $sql_all_reg . '' . $sql_rosn;
            if (!empty($sql_ugz)) {

                if (!empty($sql_all_reg)) {
                    $sql_all_reg = $sql_all_reg . ' OR ' . $sql_ugz;
                } else
                    $sql_all_reg = $sql_all_reg . $sql_ugz;
            }
            if (!empty($sql_avia)) {

                if (!empty($sql_all_reg)) {
                    $sql_all_reg = $sql_all_reg . ' OR ' . $sql_avia;
                } else {
                    $sql_all_reg = $sql_all_reg . $sql_avia;
                }
            }


            if (!empty($sql_reg)) {
                if (!empty($sql_all_reg)) {
                    $sql_all_reg = $sql_all_reg . ' OR ' . $sql_reg;
                } else
                    $sql_all_reg = $sql_all_reg . $sql_reg;
            }


            $sql = $sql . ' and (' . $sql_all_reg . ') ';
        }
        if (isset($filter['id_local']) && !empty($filter['id_local'])) {
            $sql = $sql . ' and p.id_card IN(' . implode(',', $filter['id_local']) . ')';
        }
        if (isset($filter['id_pasp']) && !empty($filter['id_pasp'])) {
            $sql = $sql . ' and p.id_record IN(' . implode(',', $filter['id_pasp']) . ')';
        }

        if (isset($filter['id_name_car']) && !empty($filter['id_name_car'])) {
            $sql = $sql . ' and p.idvie IN(' . implode(',', $filter['id_name_car']) . ')';
        }


        if (isset($filter['id_type_car']) && !empty($filter['id_type_car'])) {
            $sql = $sql . ' and p.typeid = ' . $filter['id_type_car'];
        }

        if (isset($filter['id_ob_car']) && !empty($filter['id_ob_car'])) {


            $sql_v = '';

            foreach ($filter['id_ob_car'] as $v) {

                if ($v == 1) {
                    if ($sql_v == '')
                        $sql_v = $sql_v . ' (p.v >= 1000 and p.v <= 4000)';
//                        $sql_v = $sql_v . ' p.v <= 4000';
                    else
                        $sql_v = $sql_v . ' OR (p.v >= 1000 and p.v <= 4000)';
//                        $sql_v = $sql_v . ' OR p.v <= 4000 ';
                }
                elseif ($v == 2) {
                    if ($sql_v == '')
                        $sql_v = $sql_v . ' (p.v > 4000 and p.v <= 7000)';
                    else
                        $sql_v = $sql_v . ' OR (p.v > 4000 and p.v <= 7000)';
                }
                elseif ($v == 3) {

                    if ($sql_v == '')
                        $sql_v = $sql_v . ' p.v >= 8000 ';
                    else
                        $sql_v = $sql_v . ' OR p.v >= 8000 ';
                }
            }
            $sql = $sql . ' and  ( ' . $sql_v . ') ';
        }

        if (isset($filter['id_vid_car']) && !empty($filter['id_vid_car'])) {
            $sql = $sql . ' and p.vid_id IN(' . implode(',', $filter['id_vid_car']) . ')';
        }

        //$sql=$sql.' ORDER BY p.name_teh ASC';
        //echo $sql;
//exit();


        if ($get_sql != 0) {
            return $sql;
            die;
        }

        $podr = R::getAll($sql);

        $locorg_coords = $ob = R::getAll('select * from ss.coord_locorg where  latitude is not null and longitude is not null and id_pasp <> 0');
        $ids_pasp_otdel = array();

        foreach ($locorg_coords as $value) {
            $ids_pasp_otdel[] = $value['id_pasp'];
        }

        if (!empty($podr)) {


            /* show list of all cars */
            $car_list_by_record = array();
            $podr_with_all_car = array();
            $list_cars_by_record = array();
            foreach ($podr as $value) {
                $car_list_by_record[$value['id_record']][] = $value['name_teh'];
                $list_cars_by_record[$value['id_record']][] = $value['mark'];
            }


            foreach ($podr as $k => $value) {
                if (isset($car_list_by_record[$value['id_record']]) && !empty($car_list_by_record[$value['id_record']])) {

                    //$value['mark']= implode(',<br>', $car_list_by_record);
                    sort($car_list_by_record[$value['id_record']]);
                    $cnt_per_name_teh = array_count_values($car_list_by_record[$value['id_record']]);

                    $str_mark = '';
                    $cnt_cars = 0;
                    foreach ($cnt_per_name_teh as $name => $cnt) {
                        $str_mark = $str_mark . '<br>' . $name . ' - ' . $cnt;
                        $cnt_cars += $cnt;
                    }
                    $value['mark'] = $str_mark;
                    $value['cnt_cars'] = $cnt_cars;

                    if (isset($list_cars_by_record[$value['id_record']]) && !empty($list_cars_by_record[$value['id_record']])) {
                        $all_mark_str = '';
                        foreach ($list_cars_by_record[$value['id_record']] as $all_mark) {
                            $all_mark_str = $all_mark_str . '<br>' . $all_mark;
                        }
                        if ($all_mark_str != '')
                            $value['all_mark'] = $all_mark_str;
                    }


                    $podr_with_all_car[] = $value;
                }
            }

            $unique_ids_podr = [];
            $k = 0;

            foreach ($podr_with_all_car as $value) {

                $k++;
                $res = array();

                if (!in_array($value['id_record'], $unique_ids_podr)) {

                    $unique_ids_podr[] = $value['id_record'];

                    $res['location'] = array('type' => 'Point', 'coordinates' => array($value['longitude'], $value['latitude']));
                    $res['disloc'] = $value['disloc'];
                    $res['mark'] = $value['mark'];

                    if (isset($value['cnt_cars']))
                        $res['cnt_cars'] = $value['cnt_cars'];
                    else
                        $res['cnt_cars'] = 0;

                    $obl = '';
//                if ($value['region'] != 3)
//                    $obl = $value['regionn'].' обл.';
//                else
//                    $obl=$value['regionn'];



                    if (($value['orgid'] == 8 && $value['divizid'] == 4) || ( $value['orgid'] == 6 && $value['divizid'] == 1)) {//rosn, rosn; paso, paso
                        $res['address'] = $obl . $value['f'];
                    } else {
                        $res['address'] = $obl . $value['f'] . ', ' . $value['pasp'];
                    }

                    $res['ppp'] = (!empty($value['divizion_num'])) ? $value['divizion_num'] : '';
                    $res['extra_pasp_num'] = (!empty($value['extra_pasp_num'])) ? $value['extra_pasp_num'] : '';
                    $res['extra_pasp_name_or_number'] = intval($value['extra_pasp_name_or_number']);

                    if (isset($filter['show_number_pasp']) && $filter['show_number_pasp'] == 1) {
                        $res['show_number_pasp'] = 1;
                    }

                    $res['ss_url_text'] = 'перейти в карточку сил и средств';

                    //$res['ss_url_text'] = 'просмотреть карточку сил и средств';
                    $res['ss_url'] = '/ss/card/' . $value['region'] . '/' . $value['id_card'];

                    if (in_array($value['id_record'], $ids_pasp_otdel)) {
                        $res['is_otdel'] = 1;
                        if ($value['id_record'] == 482) {//otdel of vitebskogo ROHS is in PASH 2 Vit GOHS!!!!!482 - pash 2 of Vit GOHS
                            $res['note_otdel'] = 'Витебского РОЧС';
                        }
                    }

                    $res['orgid'] = $value['orgid'];
                    if (in_array($value['orgid'], array(6, 7))) {//paso
                        $res['is_paso'] = 1;
                    }


                    if (isset($value['all_mark']) && !empty($value['all_mark'])) {
                        $res['all_mark'] = $value['all_mark'];
                    }


                    $res1[] = $res;
                }
            }
        } else {//empty result
            $res = array();
            $res1 = $res;
        }
        return $res1;
    }

    function getRightTable($filter)
    {

        $exclude_diviz = array(7, 8, 9);
        $exclude_organs_in_region = array(UMCHS, RCU);

        /* data for map */

        $sql = 'select distinct(p.tid), count(p.tid) as cnt, p.longitude, p.latitude,p.disloc, p.mark,p.f, p.pasp,p.region, p.id_card, p.id_record, concat(p.name_teh," (",p.des,")") as name_teh from ss.card as p where p.name_teh <> "-" and p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 and p.longitude is not null'
            . ' and p.divizid NOT IN(' . implode(',', $exclude_diviz) . ') and p.orgid NOT IN(' . implode(',', $exclude_organs_in_region) . ')';
        $sql = $sql . getDataFilter($filter, 1);
        $sql = $sql . ' GROUP BY p.`idvie`';
        $sql = $sql . ' ORDER BY p.`name_teh`';

        $podr = R::getAll($sql);

        if (!empty($podr))
            return $podr;
        else
            return array();;
    }
});


/* ----------------------------- ENd UMTO ------------------------- */





/* ------------------------------ min obl maps ------------------------------ */

$app->group('/maps_for_min_obl', function () use ($app) {

    function rigs_for_map_by_region($reason_rig_array, $id_region)
    {
        $rig_m = new Model_Rigtable();
        $points = $rig_m->selectAllRigByReason($reason_rig_array, 0, $id_region);
        return $points;
    }
    $app->get('/', function () use ($app) {

        $data['map_mode'] = 1;

        /* classif */

        $data['region'] = R::getAll('select * from ss.regions'); //области
        $data['local'] = R::getAll('select * from ss.locals'); //районы


        /* set reasonrig
         * 14 - other
         * 34 - fire
         * 38 - help for people
         * 76 - help for organization
         * 79 - fire in eco system */

        $reasons = array(14, 34, 38, 76, 79);

        $reason_rig = R::getAll('select name from reasonrig where id IN(' . implode(',', $reasons) . ')');
        $reasons_names = array();
        foreach ($reason_rig as $value) {
            $reasons_names[] = trim(stristr($value['name'], ' '));
        }
        $data['reasons_names'] = $reasons_names;


        $rigs = rigs_for_map($reasons);
        $ids_rig = array();
        foreach ($rigs as $value) {
            if (!in_array($value['id'], $ids_rig)) {
                $ids_rig[] = $value['id'];
            }
        }
        $data['cnt_rigs'] = count($ids_rig);

        $app->render('layouts/maps_for_min_obl/header.php');
        $data['path_to_view'] = 'maps_for_min_obl/index.php';
        $app->render('layouts/div_wrapper_map.php', $data);
        $app->render('layouts/maps_for_min_obl/footer.php');
    });

    //default rigs
    $app->get('/getjson', function () use ($app) {

        $data['map_mode'] = 1;

        /* data for map */
        //$points=R::getAll('select * from rigtable where  latitude is not null and longitude is not null AND latitude <> 0 AND longitude <> 0');


        /* set reasonrig
         * 14 - other
         * 34 - fire
         * 38 - help for people
         * 76 - help for organization
         * 79 - fire in eco system */
        $reasons = array(14, 34, 38, 76, 79);

        $points = rigs_for_map_by_region($reasons, $_SESSION['id_region']);
        $res1 = array();


        foreach ($points as $value) {
            $res = array();
            $res['location'] = array('type' => 'Point', 'coordinates' => array($value['longitude'], $value['latitude']));
            $res['reasonrig_name'] = '.:' . trim(stristr($value['reasonrig_name'], ' ')) . ':.';

            if (!empty($value['address'])) {
                $obl = '';
                if ($value['id_region'] != 3)
                    $obl = $value['region_name'] . ' обл., ';

                $res['address'] = $obl . $value['address'];
            } else
                $res['address'] = $value['additional_field_address'];


            if (!empty($value['object']))
                $res['object'] = $value['object'];

            if ($value['id_reasonrig'] == 14)
                $res['new_icon'] = 'assets/images/leaflet/other.png';
            elseif ($value['id_reasonrig'] == 34)
                $res['new_icon'] = 'assets/images/leaflet/fire.png';
            elseif ($value['id_reasonrig'] == 38)
                $res['new_icon'] = 'assets/images/leaflet/help.png';
            elseif ($value['id_reasonrig'] == 76)
                $res['new_icon'] = 'assets/images/leaflet/help.png';
            elseif ($value['id_reasonrig'] == 79)
                $res['new_icon'] = 'assets/images/leaflet/priroda.png';
            else
                $res['new_icon'] = 'assets/images/leaflet/point123.png';

            $res['card_by_rig_url'] = 'card_rig/0/' . $value['id'];

            $res1[] = $res;
        }


//
//$res['location']=array('type'=>'Point','coordinates'=>array("27.546803", "53.855383"));
//$res['name']='hh';
//$res['new_icon']='assets/images/leaflet/coffee.png';
//$res1[]=$res;


        $data['points'] = json_encode($res1);


        echo $data['points'];
    });


    /* get pasp from kusis */
    $app->post('/getjson', function () use ($app) {

        $data['map_mode'] = 1;

        /* data for map */

        $res1 = array();
        $res = array();

        $res['location'] = array('type' => 'Point', 'coordinates' => array("27.546803", "53.855383"));
        $res['name'] = 'hh';
//$res['new_icon']='assets/images/leaflet/menu.png';


        $id_region = $app->request()->post('id_region');
        $id_local = $app->request()->post('id_local');

        $sql = 'select * from journal.pasp as p where p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 and p.longitude is not null ';

        if (isset($id_region) && !empty($id_region)) {
            $sql = $sql . ' and p.id_region IN(' . implode(',', $id_region) . ') ';
        }
        if (isset($id_local) && !empty($id_local)) {
            $sql = $sql . ' and p.id_local IN(' . implode(',', $id_local) . ')';
        }


        $podr = R::getAll($sql);

        if (!empty($podr)) {

            foreach ($podr as $value) {
                $res = array();
                $res['location'] = array('type' => 'Point', 'coordinates' => array($value['longitude'], $value['latitude']));
                $res['locorg_name'] = $value['locorg_name'];
                $res['pasp_name'] = $value['pasp_name'];

                $obl = '';
                if ($value['id_region'] != 3)
                    $obl = $value['region_name'] . ' обл., ';

                $res['address_disloc'] = $obl . $value['address_disloc'];
                // $res['new_icon'] = 'assets/images/leaflet/coffee.png';
                $res['ss_url_text'] = 'перейти в карточку сил и средств';
                //$res['ss_url_text'] = 'просмотреть карточку сил и средств';
                $res['ss_url'] = '/ss/card/' . $value['id_region'] . '/' . $value['id_loc_org'];

                $res1[] = $res;
            }
        } else {//empty result
            $res = array();
            $res1[] = $res;
        }





        if (empty($res1))
            $res1['error'] = 'Нет данных для отображения';



        $data['points'] = json_encode($res1);


        echo $data['points'];
    });




    /* classif. get locals by region */
    $app->post('/get_locals_by_region', function () use ($app) {

        //$data['map_mode']=1;

        $ids_region = $app->request()->post('ids_region');
        // print_r($ids_region);
        if (isset($ids_region) && !empty($ids_region)) {
            $locals = R::getAll('select l.*, r.name as region_name from ss.locals as l left join ss.regions as r on l.id_region=r.id where l.id_region IN(' . implode(',', $ids_region) . ')  ORDER BY id_region, name ASC');
            //$locals = R::getAll('select * from journal.locals where  id !=123 ORDER BY sort, name ASC');
            if (!empty($locals)) {
                echo json_encode($locals);
            }
        }
    });
});

/* ----------------------------------- END min obl maps --------------------- */




/* ------------------------- diagram results_battle ------------------------------- */

$app->group('/diagram_results_battle', 'is_login', function () use ($app, $log) {


    $app->get('/', function () use ($app) {

        $data['title'] = 'Диаграммы/Боевая работа';

        $bread_crumb = array('Диаграммы', 'Боевая работа');
        $data['bread_crumb'] = $bread_crumb;



        $data['head_date'] = LIST_MONTH[(date('n'))] . ' ' . date('Y');


        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы

        /*         * *** end classif **** */

        $filter['year'] = date('Y');
        $filter['month'] = date('m');
        $filter['month_single'] = date('n');

        /* ----- get data  from BD - by year by RB ------ */
        $data['cnt_per_month_by_year'] = getCntDeadManByYear($filter);
        /* ----- END get data  from BD - by year by RB ------ */


        /* ----- get data  from BD - by month by RB ------ */
        $data['cnt_by_month_per_region'] = getCntDeadManByMonthPerRegion($filter);
        /* ----- END get data  from BD - by month by RB ------ */


        /* ----- get data  from BD - by days in month by RB ------ */
        $data['cnt_per_days'] = getCntDeadManByDay($filter);
        /* ----- END get data  from BD - by days in month by RB ------ */


        $app->render('diagram/results_battle/header.php', $data);
        $data['path_to_view'] = 'diagram/results_battle/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });



    $app->post('/', function () use ($app) {


        /*         * *** classif **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        /*         * *** end classif **** */

        $rig_m = new Model_Rig();


        $is_ajax = $app->request->isAjax();
        if ($is_ajax) {

            $filter = $app->request()->post();



            if (isset($filter['month']) && !empty($filter['month'])) {
                $data['head_date'] = LIST_MONTH[($filter['month'])] . ' ' . $filter['year'];
            } else {
                $data['head_date'] = LIST_MONTH[(date('n'))] . ' ' . $filter['year'];
            }

            if(isset($filter['month']))
            $filter['month_single'] = $filter['month'];

            if (isset($filter['month']) && $filter['month'] < 10)
                $filter['month'] = '0' . $filter['month'];


            $type_save_name = array();
            if (isset($filter['type_save']) && !empty($filter['type_save'])) {
                foreach ($filter['type_save'] as $value) {
                    switch ($value) {
                        case 1:$type_save_name[] = 'Погибло всего';
                            break;
                        case 2:$type_save_name[] = 'Погибло детей';
                            break;
                        case 3:$type_save_name[] = 'Спасено всего';
                            break;
                        case 4:$type_save_name[] = 'Спасено детей';


                            break;

                        default:
                            break;
                    }
                }
            }
            $data['type_save_name'] = $type_save_name;

            if (isset($filter['id_region']) && !empty($filter['id_region'])) {

                $data['name_region_filter'] = R::getCell('select name from journal.regions where id = ?', array($filter['id_region']));
            }
            if (isset($filter['id_local']) && !empty($filter['id_local'])) {

                $data['name_local_filter'] = R::getCell('select name from journal.locals where id = ?', array($filter['id_region']));
            }

            $data['filter'] = $filter;


            if ($filter['all'] == 3) {
                $data['cnt_per_month_by_year'] = getCntDeadManByYear($filter); //by year by RB
            } else if ($filter['all'] == 1 || $filter['all'] == 2) {
                $data['cnt_by_month_per_region'] = getCntDeadManByMonthPerRegion($filter); //by month by RB
                $data['cnt_per_days'] = getCntDeadManByDay($filter); //by days in month by RB
            }





            if (isset($filter['all']) && !empty($filter['all']) && $filter['all'] == 2) {
                $view = $app->render('diagram/results_battle/parts/div-per-days-diag.php', $data);
                $response = ['success' => TRUE, 'view' => $view];
            } elseif (isset($filter['all']) && !empty($filter['all']) && $filter['all'] == 3) {//block 1
                $view = $app->render('diagram/results_battle/parts/div-year-diag.php', $data);
                $response = ['success' => TRUE, 'view' => $view];
            } else {

                $view = $app->render('diagram/results_battle/parts/div-all-diag.php', $data);
                $response = ['success' => TRUE, 'view' => $view];
            }
        }
    });
});

/* cnt dead man by year per each month */

function getCntDeadManByYear($filter)
{

    $main_m = new Model_Main();

    $mas = array();
    $dead_man_by_year_by_rb = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
    $dead_child_by_year_by_rb = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
    $save_man_by_year_by_rb = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
    $save_child_by_year_by_rb = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);



//  from journal
    $dead_man_j = R::getAll('SELECT DATE_FORMAT(r.`time_msg`,"%c") as numb_month,DATE_FORMAT(r.`time_msg`,"%Y") as numb_year,
                SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child, SUM(rb.`save_man`) AS save_man,
                SUM(rb.`save_child`) AS save_child
FROM results_battle AS rb
LEFT JOIN rig AS r ON rb.`id_rig`=r.`id`
WHERE r.`is_delete`=0
AND DATE_FORMAT(r.`time_msg`,"%Y")= ?
GROUP BY DATE_FORMAT(r.`time_msg`,"%m")', array($filter['year']));

    if (!empty($dead_man_j)) {

        foreach ($dead_man_j as $row) {

            $dead_man_by_year_by_rb[$row['numb_month']] += $row['dead_man'];
            $dead_child_by_year_by_rb[$row['numb_month']] += $row['dead_child'];
            $save_man_by_year_by_rb[$row['numb_month']] += $row['save_man'];
            $save_child_by_year_by_rb[$row['numb_month']] += $row['save_child'];
        }
    }

    // 2019 ????
    if ($filter['year'] == '2019') {//add data
        $dead_man_j_2019 = R::getAll('SELECT SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM results_battle_archive_2019 AS rb');
    }

    // from archive
    $real_server = $main_m->get_js_connect($filter['year']);

    $tbl_name = 'results_battle_a_' . $filter['year'];

       if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
        $pdo = get_pdo_15($real_server);
        $sql = 'SELECT rb.numb_month,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM jarchive.' . $tbl_name . ' AS rb GROUP BY rb.numb_month';
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $dead_man_archive = $sth->fetchAll();
    } else {
        $dead_man_archive = R::getAll('SELECT rb.numb_month,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM jarchive.' . $tbl_name . ' AS rb GROUP BY rb.numb_month');
    }



    if (!empty($dead_man_archive)) {

        foreach ($dead_man_archive as $row) {

            $dead_man_by_year_by_rb[$row['numb_month']] += $row['dead_man'];
            $dead_child_by_year_by_rb[$row['numb_month']] += $row['dead_child'];
            $save_man_by_year_by_rb[$row['numb_month']] += $row['save_man'];
            $save_child_by_year_by_rb[$row['numb_month']] += $row['save_child'];
        }
    }

    $sum = array_sum($dead_man_by_year_by_rb) + array_sum($dead_child_by_year_by_rb) + array_sum($save_man_by_year_by_rb) + array_sum($save_child_by_year_by_rb);

    $mas['dead_man'] = $dead_man_by_year_by_rb;
    $mas['dead_child'] = $dead_child_by_year_by_rb;
    $mas['save_man'] = $save_man_by_year_by_rb;
    $mas['save_child'] = $save_child_by_year_by_rb;

    $mas['dead_man_percent'] = ($sum > 0) ? round((100 * array_sum($dead_man_by_year_by_rb) / $sum)) : 0;
    $mas['dead_child_percent'] = ($sum > 0) ? round((100 * array_sum($dead_child_by_year_by_rb) / $sum)) : 0;
    $mas['save_man_percent'] = ($sum > 0) ? round((100 * array_sum($save_man_by_year_by_rb) / $sum)) : 0;
    $mas['save_child_percent'] = ($sum > 0) ? round((100 * array_sum($save_child_by_year_by_rb) / $sum)) : 0;


    return $mas;
}

function getCntDeadManByMonthPerRegion($filter)
{
    $main_m = new Model_Main();

    $mas = array();
    $dead_man = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0); //by region
    $dead_child = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0); //by region
    $save_man = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0); //by region
    $save_child = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0); //by region
    //echo  $filter['month'];
//  from journal
    $dead_man_j = R::getAll('SELECT r.id_region, DATE_FORMAT(r.`time_msg`,"%c") as numb_month,DATE_FORMAT(r.`time_msg`,"%Y") as numb_year,
                SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child, SUM(rb.`save_man`) AS save_man,
                SUM(rb.`save_child`) AS save_child
FROM results_battle AS rb
LEFT JOIN rig AS r ON rb.`id_rig`=r.`id`
WHERE r.`is_delete`=0
AND DATE_FORMAT(r.`time_msg`,"%Y")= ?  AND DATE_FORMAT(r.`time_msg`,"%c") = ?
GROUP BY r.id_region', array($filter['year'], $filter['month_single']));
//print_r($dead_man_j);
    if (!empty($dead_man_j)) {

        foreach ($dead_man_j as $row) {

            $dead_man[$row['id_region']] += $row['dead_man'];
            $dead_child[$row['id_region']] += $row['dead_child'];
            $save_man[$row['id_region']] += $row['save_man'];
            $save_child[$row['id_region']] += $row['save_child'];
        }
    }

    // 2019 ????
    if ($filter['year'] == '2019') {//add data
        $dead_man_j_2019 = R::getAll('SELECT rb.`id_region`,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM results_battle_archive_2019 AS rb GROUP BY rb.`id_region`');

        if (!empty($dead_man_j_2019)) {

//            foreach ($dead_man_j_2019 as $row) {
//
//                $dead_man[$row['id_region']] += $row['dead_man'];
//                $dead_child[$row['id_region']] += $row['dead_child'];
//                $save_man[$row['id_region']] += $row['save_man'];
//                $save_child[$row['id_region']] += $row['save_child'];
//            }
        }
    }

    // from archive
    $real_server = $main_m->get_js_connect($filter['year']);
    $tbl_name = 'results_battle_a_' . $filter['year'];


       if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
        $pdo = get_pdo_15($real_server);
        $sql = 'SELECT rb.id_region, rb.numb_month,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM jarchive.' . $tbl_name . ' AS rb WHERE rb.numb_month = ' . $filter['month_single'] . ' GROUP BY rb.id_region';
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $dead_man_archive = $sth->fetchAll();
    } else {
        $dead_man_archive = R::getAll('SELECT rb.id_region, rb.numb_month,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM jarchive.' . $tbl_name . ' AS rb WHERE rb.numb_month = ' . $filter['month_single'] . ' GROUP BY rb.id_region');
    }


    if (!empty($dead_man_archive)) {

        foreach ($dead_man_archive as $row) {
            $dead_man[$row['id_region']] += $row['dead_man'];
            $dead_child[$row['id_region']] += $row['dead_child'];
            $save_man[$row['id_region']] += $row['save_man'];
            $save_child[$row['id_region']] += $row['save_child'];
        }
    }




    $sum = array_sum($dead_man) + array_sum($dead_child) + array_sum($save_man) + array_sum($save_child);

    $mas['dead_man'] = $dead_man;
    $mas['dead_child'] = $dead_child;
    $mas['save_man'] = $save_man;
    $mas['save_child'] = $save_child;

    $mas['dead_man_percent'] = ($sum > 0) ? round((100 * array_sum($dead_man) / $sum)) : 0;
    $mas['dead_child_percent'] = ($sum > 0) ? round((100 * array_sum($dead_child) / $sum)) : 0;
    $mas['save_man_percent'] = ($sum > 0) ? round((100 * array_sum($save_man) / $sum)) : 0;
    $mas['save_child_percent'] = ($sum > 0) ? round((100 * array_sum($save_child) / $sum)) : 0;




//print_r($mas);
    $mas['is_empty'] = 0;

    if (isset($filter['month']) && !empty($filter['month'])) {

        if ($mas['dead_man_percent'] == 0 && $mas['dead_child_percent'] == 0 && $mas['save_man_percent'] == 0 &&
            $mas['save_child_percent'] == 0) {
            $mas['is_empty'] ++;
        }
    }

    if (isset($filter['type_save']) && !empty($filter['type_save'])) {

        foreach ($filter['type_save'] as $value) {

            switch ($value) {
                case 1:
                    if ($mas['dead_man_percent'] == 0) {
                        $mas['is_empty'] ++;
                    }
                    break;
                case 2:
                    if ($mas['dead_child_percent'] == 0) {
                        $mas['is_empty'] ++;
                    }
                    break;
                case 3:
                    if ($mas['save_man_percent'] == 0)
                        $mas['is_empty'] ++;
                    break;
                case 4:
                    if ($mas['save_child_percent'] == 0)
                        $mas['is_empty'] ++;


                    break;

                default:
                    break;
            }
        }
    }


    return $mas;
}

function getCntDeadManByDay($filter)
{
    $main_m = new Model_Main();

    $mas = array();
    $query_date = $filter['year'] . '-' . $filter['month'] . '-01';
    //echo $filter['month_single'];
    //echo $query_date;
// First day of the month.
    $first_day = date('Y-m-01', strtotime($query_date));
// Last day of the month.
    $last_day = date('Y-m-t', strtotime($query_date));

    $begin = new DateTime($first_day);
    $end = new DateTime($last_day);
    $end = $end->modify('+1 day');
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);

    foreach ($daterange as $date) {
        $d = $date->format("d.m.Y");
        $mas['days'][] = '"' . $date->format("d.m") . '"';
        $dead_man[$d] = 0;
        $dead_child[$d] = 0;
        $save_man[$d] = 0;
        $save_child[$d] = 0;
        //echo $date->format("d.m.Y") . "<br>";
    }

    $real_server = $main_m->get_js_connect($filter['year']);


//  from journal

    $sql = 'SELECT r.id_region, r.`id_local`, DATE_FORMAT(r.`time_msg`,"%d.%m.%Y") AS day_numb, DATE_FORMAT(r.`time_msg`,"%Y") as numb_year,
                SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child, SUM(rb.`save_man`) AS save_man,
                SUM(rb.`save_child`) AS save_child
FROM results_battle AS rb
LEFT JOIN rig AS r ON rb.`id_rig`=r.`id`
WHERE r.`is_delete`=0
AND DATE_FORMAT(r.`time_msg`,"%Y")= ' . $filter['year'] . '  AND DATE_FORMAT(r.`time_msg`,"%c") = ' . $filter['month_single'];


    if (isset($filter['id_region']) && !empty($filter['id_region'])) {
        $sql = $sql . ' AND r.id_region = ' . $filter['id_region'];
    }
    if (isset($filter['id_local']) && !empty($filter['id_local'])) {
        $sql = $sql . ' AND r.id_local = ' . $filter['id_local'];
    }

    $sql = $sql . ' GROUP BY DATE_FORMAT(r.`time_msg`,"%Y-%m-%d")';

    $dead_man_j = R::getAll($sql);

    if (!empty($dead_man_j)) {

        foreach ($dead_man_j as $row) {

            $dead_man[$row['day_numb']] += $row['dead_man'];
            $dead_child[$row['day_numb']] += $row['dead_child'];
            $save_man[$row['day_numb']] += $row['save_man'];
            $save_child[$row['day_numb']] += $row['save_child'];
        }
    }

    // 2019 ????
    if ($filter['year'] == '2019') {//add data
        $dead_man_j_2019 = R::getAll('SELECT rb.`id_region`,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM results_battle_archive_2019 AS rb GROUP BY rb.`id_region`');

        if (!empty($dead_man_j_2019)) {

//            foreach ($dead_man_j_2019 as $row) {
//
//                $dead_man[$row['id_region']] += $row['dead_man'];
//                $dead_child[$row['id_region']] += $row['dead_child'];
//                $save_man[$row['id_region']] += $row['save_man'];
//                $save_child[$row['id_region']] += $row['save_child'];
//            }
        }
    }

    // from archive

    $tbl_name = 'results_battle_a_' . $filter['year'];


    $sql_a = 'SELECT rb.id_region,rb.id_local, rb.numb_month, DATE_FORMAT(rb.`date_msg`,"%d.%m.%Y") AS day_numb,  SUM(rb.`dead_man`) AS dead_man,SUM(rb.`dead_child`) AS dead_child,
                SUM(rb.`save_man`) AS save_man, SUM(rb.`save_child`) AS save_child
FROM jarchive.' . $tbl_name . ' AS rb WHERE rb.numb_month = ' . $filter['month_single'];

    if (isset($filter['id_region']) && !empty($filter['id_region'])) {
        $sql_a = $sql_a . ' AND rb.id_region = ' . $filter['id_region'];
    }
    if (isset($filter['id_local']) && !empty($filter['id_local'])) {
        $sql_a = $sql_a . ' AND rb.id_local = ' . $filter['id_local'];
    }

    $sql_a = $sql_a . ' GROUP BY rb.`date_msg`';


    if (IS_NEW_MODE_ARCHIVE == 1 && $filter['year'] < date('Y') && $real_server != APP_SERVER) {
        $pdo = get_pdo_15($real_server);

        $sth = $pdo->prepare($sql_a);
        $sth->execute();
        $dead_man_archive = $sth->fetchAll();
    } else {
        $dead_man_archive = R::getAll($sql_a);
    }



    if (!empty($dead_man_archive)) {

        foreach ($dead_man_archive as $row) {
            $dead_man[$row['day_numb']] += $row['dead_man'];
            $dead_child[$row['day_numb']] += $row['dead_child'];
            $save_man[$row['day_numb']] += $row['save_man'];
            $save_child[$row['day_numb']] += $row['save_child'];
        }
    }



    $sum = array_sum($dead_man) + array_sum($dead_child) + array_sum($save_man) + array_sum($save_child);

    $mas['dead_man'] = $dead_man;
    $mas['dead_child'] = $dead_child;
    $mas['save_man'] = $save_man;
    $mas['save_child'] = $save_child;

    $mas['dead_man_percent'] = ($sum > 0) ? round((100 * array_sum($dead_man) / $sum)) : 0;
    $mas['dead_child_percent'] = ($sum > 0) ? round((100 * array_sum($dead_child) / $sum)) : 0;
    $mas['save_man_percent'] = ($sum > 0) ? round((100 * array_sum($save_man) / $sum)) : 0;
    $mas['save_child_percent'] = ($sum > 0) ? round((100 * array_sum($save_child) / $sum)) : 0;

//print_r($mas);

    return $mas;
}
/* ------------------------- END diagram results_battle ------------------------------- */



/* -------------------------- COPY RIG ------------------------------ */


$app->group('/copy_rig', 'is_login', 'is_permis', function () use ($app, $log) {


    $app->get('/:id', function ($id = 0) use ($app) {

        $cp = array(8, 9, 12);


        $model_rig = new Model_Rig();
        $model_people = new Model_People();
        $model_silymchs = new Model_Silymchs();
        $model_innerservice = new Model_Innerservice();
        $model_informing = new Model_Informing();

        //rig
        $rig = R::getRow("select * from rig where id = ?", array($id));

        unset($rig['id']);
        $rig['time_msg'] = date('Y-m-d H:i:s');


        $rig['is_copy'] = 1;
        $rig['copy_rig_id'] = $id;
        $rig['copy_rig_date'] = date('Y-m-d H:i:s');
        //!!!!!
        $new_id = $model_rig->save($rig, 0);

        //people
        $people = R::getRow("select * from people where id_rig = ? limit ?", array($id, 1));
        if (!empty($people)) {
            unset($people['id']);
            $people['id_rig'] = $new_id;

            //!!!!!
            $model_people->copy_people($people);
        }


        //silymchs
        $silymchs = R::getAll("select * from silymchs where id_rig = ?", array($id));

        if (!empty($silymchs)) {
            foreach ($silymchs as $row) {
                $new_silymchs = [];

                $id_silymchs = $row['id'];

                unset($row['id']);
                $new_silymchs = $row;
                $new_silymchs['id_rig'] = $new_id;
                $new_silymchs['last_update'] = date('Y-m-d H:i:s');
                $new_silymchs['date_insert'] = date('Y-m-d H:i:s');

                // !!!
                $new_id_silymchs = $model_silymchs->copy_silymchs($new_silymchs);


                //trunk
                $trunk = R::getAll("select * from trunkrig where id_silymchs = ?", array($id_silymchs));

                if (!empty($trunk)) {
                    foreach ($trunk as $row) {
                        $new_trunk = [];
                        unset($row['id']);
                        $new_trunk = $row;
                        $new_trunk['id_silymchs'] = $new_id_silymchs;

                        // !!!
                        $model_silymchs->copy_trunk($new_trunk);

                        print_r($new_trunk);
                        echo '<br><br>';
                    }
                }
            }
        }


        //innerservice
        $innerservice = R::getAll("select * from innerservice where id_rig = ?", array($id));

        if (!empty($innerservice)) {
            foreach ($innerservice as $row) {
                $new_innerservice = [];
                unset($row['id']);
                $new_innerservice = $row;
                $new_innerservice['id_rig'] = $new_id;

                // !!!
                $model_innerservice->copy_innerservice($new_innerservice);
            }
        }


        //informing
        $informing = R::getAll("select * from informing where id_rig = ?", array($id));

        if (!empty($informing)) {
            foreach ($informing as $row) {
                $new_informing = [];
                unset($row['id']);
                $new_informing = $row;
                $new_informing['id_rig'] = $new_id;

                // !!!
                $model_informing->copy_informing($new_informing);
            }
        }



        //rb
        $rb = R::getRow("select * from results_battle where id_rig = ?", array($id));

        $save_data = [];

        if (!empty($rb)) {
            $save_data = $rb;
            unset($save_data['id']);

            $battle = R::load('results_battle', 0);
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $new_id;
            $save_data['last_update'] = date("Y-m-d H:i:s");
            $battle->import($save_data);
            R::store($battle);
        }

        //rb chapter 1
        $rb_chapter_1 = R::getRow("select * from rb_chapter_1 where id_rig = ?", array($id));

        $save_data = [];

        if (!empty($rb_chapter_1)) {


            $save_data = $rb_chapter_1;
            unset($save_data['id']);

            $battle = R::load('rb_chapter_1', 0);
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $new_id;
            $save_data['last_update'] = date("Y-m-d H:i:s");
            $battle->import($save_data);
            R::store($battle);
        }



        //rb chapter 2
        $rb_chapter_2 = R::getRow("select * from rb_chapter_2 where id_rig = ?", array($id));
        $save_data = [];
        if (!empty($rb_chapter_2)) {


            $save_data = $rb_chapter_2;
            unset($save_data['id']);

            $battle = R::load('rb_chapter_2', 0);
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $new_id;
            $save_data['last_update'] = date("Y-m-d H:i:s");
            $battle->import($save_data);
            R::store($battle);
        }


        //rb chapter3
        $rb_chapter_3 = R::getRow("select * from rb_chapter_3 where id_rig = ?", array($id));
        $save_data = [];
        if (!empty($rb_chapter_3)) {


            $save_data = $rb_chapter_3;
            unset($save_data['id']);

            $battle = R::load('rb_chapter_3', 0);
            $save_data['date_insert'] = date("Y-m-d H:i:s");
            $save_data['id_user'] = $_SESSION['id_user'];
            $save_data['id_rig'] = $new_id;
            $save_data['last_update'] = date("Y-m-d H:i:s");
            $battle->import($save_data);
            R::store($battle);
        }


        $app->redirect(BASE_URL . '/rig/new/' . $new_id);
    });
});



/* -------------------------- END COPY RIG ------------------------------ */



/* -------------------- notifications -------------------- */
$app->get('/notifications', function () use ($app) {

    $data['title'] = 'Уведомления';

    $bread_crumb = array('Уведомления', 'Все');
    $data['bread_crumb'] = $bread_crumb;

    $user_m = new Model_User();
    $data['all_notifications'] = $user_m->getAllNotif($_SESSION['id_user']);

    $data['is_unseen_notif'] = array_column($data['all_notifications'], 'is_see');

    $app->render('layouts/header.php', $data);
    $data['path_to_view'] = 'notifications/list.php';
    $app->render('layouts/div_wrapper.php', $data);
    $app->render('layouts/footer.php');
});


$app->post('/readNotify', function () use ($app) {
    $is_ajax = $app->request->isAjax();
    if ($is_ajax) {
        $id = $app->request()->post('id');

        R::exec('UPDATE notifications SET is_see=?, date_read = ? WHERE id = ?', array(1, date('Y-m-d H:i:s'), $id));


        set_notifications($_SESSION['id_user']);
//        $data['unseen_notifications'] = getUnseenNotificationsByUser();
//        $view = $app->render('notifications/parts/unseen_notifications_for_topmenu.php', $data);
//        $response = ['success' => TRUE, 'view' => $view];
        $response = ['success' => TRUE];
    }
});

$app->post('/readAllNotify', function () use ($app) {
    $is_ajax = $app->request->isAjax();
    if ($is_ajax) {
        R::exec('UPDATE notifications SET is_see=?, date_read = ? WHERE id_user = ? and is_see = ?', array(1, date('Y-m-d H:i:s'), $_SESSION['id_user'], 0));

        set_notifications($_SESSION['id_user']);
        echo json_encode(array('success' => 'Все уведомление прочитаны'));
        return true;
    }
});
/* -------------------- END notifications -------------------- */



/* ------------- auto login RCU BOSS ---------------- */

$app->get('/rcu_boss_2020', function () use ($app, $log) {

    $user_m = new Model_User();
    $rcu_boss_id = $user_m->get_rcu_boss();
    //echo $rcu_boss_id;exit();
    if (isset($rcu_boss_id) && !empty($rcu_boss_id)) {
        $permissions = new Model_Permissions();
        $permis = $permissions->getPrmissionById($rcu_boss_id);

        if (isset($permis) && !empty($permis)) {

            do_login($permis);
            set_cookie($permis);

            //print_r($_SESSION);
            //exit();

            $array = array('time' => date("Y-m-d H:i:s"), 'ip-address' => $_SERVER['REMOTE_ADDR'], 'login' => $permis['login'], 'password' => $permis['password'], 'user_name' => $_SESSION['user_name']);
            $log_array = json_encode($array, JSON_UNESCAPED_UNICODE);
            $log->info('Сессия -  :: Вход пользователя с - id = ' . $_SESSION['id_user'] . ' данные - : ' . $log_array); //запись в logs


            /* save log to bd */
            $arr = array('user_id' => $_SESSION['id_user'], 'user_name' => $_SESSION['user_name'], 'region_name' => $_SESSION['region_name'], 'locorg_name' => $_SESSION['locorg_name']);
            $loglogin = new Model_Loglogin();
            $loglogin->save($arr, 1);

            set_notifications($_SESSION['id_user']);


            if (isset($_SESSION['id_ghost']))
                unset($_SESSION['id_ghost']);

            $app->redirect(BASE_URL . '/table_close_rigs');
        }
        else {
            $app->redirect(BASE_URL . '/login');
        }
    } else {
        $app->redirect(BASE_URL . '/login');
    }
});


/* ------------- auto login RCU BOSS ---------------- */




/* ------------ export rigtable to excel -------------- */
$app->get('/export_rigtable/:from/:to/:reasonrig(/:id_region)', function ($from, $to, $reasonrig, $id_region = 0) use ($app) {


    /* MODELS */
    $sily_m = new Model_Jrig();
    $rig_m = new Model_Rigtable();
    $inner_m = new Model_Innerservice();
    $informing_m = new Model_Informing();
    $sily_mchs_m = new Model_Silymchs();

    $data['settings_user'] = getSettingsUser();
    $data['settings_user_br_table'] = getSettingsUserMode();

    $filter = [];

    if (isset($reasonrig) && !empty($reasonrig) && $reasonrig != 0)
        $filter['reasonrig'] = explode(',', trim($reasonrig));
    elseif (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {//mode
        $filter['reasonrig'] = $data['settings_user_br_table'];
    }


    if (isset($from) && !empty($from)) {
        $rig_m->setDateStart(trim($from));
    } else {
        if (date("H:i:s") <= '06:00:00') {//до 06 утра
            $rig_m->setDateStart(date("d.m.Y", time() - (60 * 60 * 24)));
        } else {
            $rig_m->setDateStart(date("d.m.Y"));
        }
    }

    if (isset($to) && !empty($to)) {
        $rig_m->setDateEnd(trim($to));
    } else {
        if (date("H:i:s") <= '06:00:00') {//до 06 утра
            $rig_m->setDateEnd(date("d.m.Y"));
        } else {
            $rig_m->setDateEnd(date("d.m.Y", time() + (60 * 60 * 24)));
        }
    }


    $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

    $caption = '';

    if ($id_region != 0) {//rcu
        if (!in_array($id_region, $cp)) {//выезды за области без ЦП
            $data['rig'] = $rig_m->selectAllByIdRegion($id_region, 0, 0, $filter); //без ЦП
        } else {//выезды за РОСН, УГЗ, АВиацию
            $data['rig'] = $rig_m->selectAllByIdOrgan($id_region, 0, $filter); //за весь орган
        }


        if (!in_array($id_region, $cp)) {
            $region_name = R::getCell('select name from regions where id = ?', array($id_region));

            if ($id_region != 3)
                $caption = $region_name . ' область';
        } elseif ($id_region == ROSN) {
            $caption = 'РОСН';
        } elseif ($id_region == UGZ) {
            $caption = 'УГЗ';
        } elseif ($id_region == AVIA) {
            $caption = 'Авиация';
        }
    } elseif ($_SESSION['id_level'] == 3) {
        $caption = $_SESSION['locorg_name'];


        //выезды за ГРОЧС
        $rig = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0, $filter); //за ГРОЧС

        if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
            $rig_neighbor_id = $rig_m->selectIdRigByIdGrochs(0, $_SESSION['id_locorg'], $filter); //за ГРОЧС
            $rig_neighbor = $rig_m->selectAllByIdLocorgNeighbor($rig_neighbor_id, $filter);
            $data['rig'] = array_merge($rig, $rig_neighbor);
        } else {
            $data['rig'] = $rig;
        }
    } elseif ($_SESSION['id_level'] == 2) {
        $caption = $_SESSION['locorg_name'];

        if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
            $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0, $filter); //за весь орган
        } else {// UMCHS
            $rig = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0, $filter); //выезды за всю область(не включая ЦП), не удаленные записи

            if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                $rig_neighbor_id = $rig_m->selectIdRigByIdRegion(0, $_SESSION['id_region'], $filter); //за ГРОЧС
                $rig_neighbor = $rig_m->selectAllByIdRegionNeighbor($rig_neighbor_id, $filter);
                $data['rig'] = array_merge($rig, $rig_neighbor);
            } else {
                $data['rig'] = $rig;
            }
        }
    }


    if (!empty($data['rig']))
        usort($data['rig'], "order_rigs");

    $id_rig_arr = array();
    $id_rig_informing = array();
    $id_rig_sis_mes = array();

    foreach ($data['rig'] as $value) {//id of rigs
        if ($value['id'] != null) {
            $id_rig_arr[] = $value['id'];
            $id_rig_informing[] = $value['id'];
        }

        if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
            $id_rig_sis_mes[] = $value['id'];
        }
    }


    $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
    $data['sily_mchs'] = $sily_mchs;


    /* --- for table type 2 ---- */
    $res = getSilyForType2($sily_mchs);
    $data['teh_mark'] = $res['teh_mark'];
    $data['exit_time'] = $res['exit_time'];
    $data['arrival_time'] = $res['arrival_time'];
    $data['follow_time'] = $res['follow_time'];
    $data['end_time'] = $res['end_time'];
    $data['return_time'] = $res['return_time'];
    $data['distance'] = $res['distance'];
    /* --- END for table type 2 ---- */


    $objPHPExcel = new PHPExcel();
    $objReader = PHPExcel_IOFactory::createReader("Excel2007");
    $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/excel_rigtable.xlsx');

    $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
    $sheet = $objPHPExcel->getActiveSheet();


    $sheet->setCellValue('A1', 'Выезды с с 06:00 ' . (\DateTime::createFromFormat('Y-m-d', $rig_m->date_start)->format('d.m.Y')) . ' до 06:00 ' . (\DateTime::createFromFormat('Y-m-d', $rig_m->date_end)->format('d.m.Y'))); //выбранный период
    $sheet->setCellValue('A2', $caption); //выбранный область и район

    $r = 8; //начальная строка для записи
    $i = 0; //счетчик кол-ва записей № п/п
    if (!empty($data['rig'])) {
        foreach ($data['rig'] as $row) {
            $i++;
            $c = 0; //начальный столбец для записи

            if ($row['time_loc'] != NULL && $row['time_loc'] != '0000-00-00 00:00:00') {
                $t_loc = new DateTime($row['time_loc']);
                $time_loc = $t_loc->Format('H:i');
            } else {
                $time_loc = '';
            }


            if ($row['time_likv'] != NULL && $row['time_likv'] != '0000-00-00 00:00:00') {
                $t_likv = new DateTime($row['time_likv']);
                $time_likv = $t_likv->Format('H:i');
            } elseif ($row['is_likv_before_arrival'] == 1) {
                $time_likv = 'ликв.до прибытия';
            } elseif ($row['is_closed'] == 1) {
                $time_likv = 'не учитывать даты';
            } else {
                $time_likv = '';
            }

            // Заполнение цветом
            if (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) {
                $style_neighbor = array(
                    'fill'    => array(
                        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                        'color' => array(
                            'rgb' => 'c0c0c0'
                        )
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $sheet->getStyleByColumnAndRow($c, $r, $c + 18, $r)->applyFromArray($style_neighbor);
            }


            $sheet->setCellValueByColumnAndRow($c, $r, $i);
            $c++;
            $sheet->setCellValueByColumnAndRow($c, $r, $row['id']);
            $c++;
            $sheet->setCellValueByColumnAndRow($c, $r, date('d.m.Y', strtotime($row['date_msg'])));
            $c++;
            $sheet->setCellValueByColumnAndRow($c, $r, date('H:i', strtotime($row['time_msg'])));
            $c++;
            $sheet->setCellValueByColumnAndRow($c, $r, $row['local_name']);
            $c++;


            if ($row['address'] != NULL) {
                $addr = $row['address'] . chr(10) . $row['additional_field_address'];
            } else {
                $addr = $row['additional_field_address'];
            }



            if (!empty($row['object'])) {
                $addr = $addr . chr(10);
                $addr = $addr . '(' . $row['object'] . ')';
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $addr);
            $c++;

            //  short on technic
            $teh = '';
            if (isset($data['teh_mark'][$row['id']]) && !empty($data['teh_mark'][$row['id']])) {

                foreach ($data['teh_mark'][$row['id']] as $si) {

                    if (!empty($teh))
                        $teh = $teh . chr(10) . strip_tags($si);
                    else
                        $teh = strip_tags($si);
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $teh);
            $c++;


            $exit = '';
            if (isset($data['exit_time'][$row['id']]) && !empty($data['exit_time'][$row['id']])) {

                foreach ($data['exit_time'][$row['id']] as $si) {
                    if (!empty($exit))
                        $exit = $exit . chr(10) . $si;
                    else
                        $exit = $si;
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $exit);
            $c++;




            $arrival = '';
            if (isset($data['arrival_time'][$row['id']]) && !empty($data['arrival_time'][$row['id']])) {

                foreach ($data['arrival_time'][$row['id']] as $si) {
                    if (!empty($arrival))
                        $arrival = $arrival . chr(10) . $si;
                    else
                        $arrival = $si;
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $arrival);
            $c++;

            $sheet->setCellValueByColumnAndRow($c, $r, $time_loc);
            $c++;
            $sheet->setCellValueByColumnAndRow($c, $r, $time_likv);
            $c++;

            $end_time = '';
            if (isset($data['end_time'][$row['id']]) && !empty($data['end_time'][$row['id']])) {

                foreach ($data['end_time'][$row['id']] as $si) {
                    if (!empty($end_time))
                        $end_time = $end_time . chr(10) . $si;
                    else
                        $end_time = $si;
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $end_time);
            $c++;

            $return_time = '';
            if (isset($data['return_time'][$row['id']]) && !empty($data['return_time'][$row['id']])) {

                foreach ($data['return_time'][$row['id']] as $si) {
                    if (!empty($return_time))
                        $return_time = $return_time . chr(10) . $si;
                    else
                        $return_time = $si;
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $return_time);
            $c++;


            $follow = '';
            if (isset($data['follow_time'][$row['id']]) && !empty($data['follow_time'][$row['id']])) {

                foreach ($data['follow_time'][$row['id']] as $si) {
                    if (!empty($follow))
                        $follow = $follow . chr(10) . $si;
                    else
                        $follow = $si;
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $follow);
            $c++;


            $distance = '';
            if (isset($data['distance'][$row['id']]) && !empty($data['distance'][$row['id']])) {

                foreach ($data['distance'][$row['id']] as $si) {
                    if (!empty($distance))
                        $distance = $distance . chr(10) . $si;
                    else
                        $distance = $si;
                }
            }
            $sheet->setCellValueByColumnAndRow($c, $r, $distance);
            $c++;

            $sheet->setCellValueByColumnAndRow($c, $r, $row['inf_detail']);
            $c++;

            $sheet->setCellValueByColumnAndRow($c, $r, $row['reasonrig_name']);
            $c++;

            $sheet->setCellValueByColumnAndRow($c, $r, $row['view_work']);
            $c++;

            $sheet->setCellValueByColumnAndRow($c, $r, $row['number_sim']);
            $c++;


            $creator = $row['auth_locorg'];
            if (isset($row['date_insert']) && !empty($row['date_insert'])) {
                $creator = $creator . ' ' . date('d.m.Y H:i:s', strtotime($row['date_insert']));
            }


            $sheet->setCellValueByColumnAndRow($c, $r, $creator);
            $c++;
            $r++;
        }
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Выезды за сутки.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
});




/* ------------ export rigtable to word -------------- */
$app->get('/export_word/:from/:to/:reasonrig(/:id_region)', function ($from, $to, $reasonrig, $id_region = 0) use ($app) {


    /* MODELS */
    $sily_m = new Model_Jrig();
    $rig_m = new Model_Rigtable();
    $inner_m = new Model_Innerservice();
    $informing_m = new Model_Informing();
    $sily_mchs_m = new Model_Silymchs();

    $data['settings_user'] = getSettingsUser();
    $data['settings_user_br_table'] = getSettingsUserMode();

    $filter = [];

    if (isset($reasonrig) && !empty($reasonrig) && $reasonrig != 0)
        $filter['reasonrig'] = explode(',', trim($reasonrig));
    elseif (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {//mode
        $filter['reasonrig'] = $data['settings_user_br_table'];
    }


    if (isset($from) && !empty($from)) {
        $rig_m->setDateStart(trim($from));
    } else {
        if (date("H:i:s") <= '06:00:00') {//до 06 утра
            $rig_m->setDateStart(date("d.m.Y", time() - (60 * 60 * 24)));
        } else {
            $rig_m->setDateStart(date("d.m.Y"));
        }
    }

    if (isset($to) && !empty($to)) {
        $rig_m->setDateEnd(trim($to));
    } else {
        if (date("H:i:s") <= '06:00:00') {//до 06 утра
            $rig_m->setDateEnd(date("d.m.Y"));
        } else {
            $rig_m->setDateEnd(date("d.m.Y", time() + (60 * 60 * 24)));
        }
    }


    $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

    $caption = '';

    if ($id_region != 0) {//rcu
        if (!in_array($id_region, $cp)) {//выезды за области без ЦП
            $data['rig'] = $rig_m->selectAllByIdRegion($id_region, 0, 0, $filter); //без ЦП
        } else {//выезды за РОСН, УГЗ, АВиацию
            $data['rig'] = $rig_m->selectAllByIdOrgan($id_region, 0, $filter); //за весь орган
        }

        if (!empty($data['rig']))
            usort($data['rig'], "order_rigs");

        if (!in_array($id_region, $cp)) {
            $region_name = R::getCell('select name from regions where id = ?', array($id_region));

            if ($id_region != 3)
                $caption = $region_name . ' область';
        } elseif ($id_region == ROSN) {
            $caption = 'РОСН';
        } elseif ($id_region == UGZ) {
            $caption = 'УГЗ';
        } elseif ($id_region == AVIA) {
            $caption = 'Авиация';
        }
    } elseif ($_SESSION['id_level'] == 3) {
        $caption = $_SESSION['locorg_name'];


        //выезды за ГРОЧС
        $rig = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0, $filter); //за ГРОЧС

        if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
            $rig_neighbor_id = $rig_m->selectIdRigByIdGrochs(0, $_SESSION['id_locorg'], $filter); //за ГРОЧС
            $rig_neighbor = $rig_m->selectAllByIdLocorgNeighbor($rig_neighbor_id, $filter);
            $data['rig'] = array_merge($rig, $rig_neighbor);
        } else {
            $data['rig'] = $rig;
        }
    } elseif ($_SESSION['id_level'] == 2) {
        $caption = $_SESSION['locorg_name'];

        if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
            $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0, $filter); //за весь орган
        } else {// UMCHS
            $rig = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0, $filter); //выезды за всю область(не включая ЦП), не удаленные записи

            if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                $rig_neighbor_id = $rig_m->selectIdRigByIdRegion(0, $_SESSION['id_region'], $filter); //за ГРОЧС
                $rig_neighbor = $rig_m->selectAllByIdRegionNeighbor($rig_neighbor_id, $filter);
                $data['rig'] = array_merge($rig, $rig_neighbor);
            } else {
                $data['rig'] = $rig;
            }
        }
    }


    if (!empty($data['rig']))
        usort($data['rig'], "order_rigs_asc");

    /* ------- select information on SiS MHS -------- */
    $id_rig_arr = array();
    $id_rig_informing = array();
    $id_rig_sis_mes = array();

    $is_fire = 0;
    $is_other_zagor = 0;
    $is_help = 0;
    $is_demerk = 0;
    $is_molnia = 0;
    $is_ltt = 0;

    $all_reasons= array(array(REASON_OTHER_ZAGOR), REASON_HELP, array(REASON_DEMERK),
        array(REASON_MOLNIA), array(REASON_LTT));


    foreach ($data['rig'] as $value) {//id of rigs
        if ($value['id_reasonrig'] == REASON_FIRE) {
            $is_fire++;
        }

        if ($value['id_reasonrig'] == REASON_OTHER_ZAGOR) {
            $is_other_zagor++;
        }
        if (in_array($value['id_reasonrig'], REASON_HELP)) {
            $is_help++;
        }
        if ($value['id_reasonrig'] == REASON_DEMERK) {
            $is_demerk++;
        }
        if ($value['id_reasonrig'] == REASON_MOLNIA) {
            $is_molnia++;
        }
        if ($value['id_reasonrig'] == REASON_LTT) {
            $is_ltt++;
        }


        if ($value['id'] != null) {
            $id_rig_arr[] = $value['id'];
            $id_rig_informing[] = $value['id'];
        }

        if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
            $id_rig_sis_mes[] = $value['id'];
        }
    }

    /* ------- END select information on SiS MHS-------- */

    $rig_cars = [];
    $rig_innerservice = [];
    $rig_informing = [];
    if (!empty($id_rig_sis_mes)) {
        //sis mchs
        $jrig = $sily_m->get_jrig_by_rigs_for_word($id_rig_sis_mes);

        if (!empty($jrig)) {
            foreach ($jrig as $row) {
                $rig_cars[$row['id_rig']][] = $row;
            }
        }
    }

    //sis inner
    if (!empty($id_rig_arr)) {
        $inner = $inner_m->get_innerservice_by_rigs($id_rig_arr);

        if (!empty($inner)) {
            foreach ($inner as $row) {
                $rig_innerservice[$row['id_rig']][] = $row;
            }
        }
    }


    //informing
    if (!empty($id_rig_informing)) {
        $informing = $informing_m->get_informing_by_rigs($id_rig_informing);

        if (!empty($informing)) {
            foreach ($informing as $row) {

                $rig_informing[$row['id_rig']][] = $row;
            }
        }
    }

    $data['rig_cars'] = $rig_cars;
    $data['rig_innerservice'] = $rig_innerservice;
    $data['rig_informing'] = $rig_informing;

//print_r($data['rig']);exit();





    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultFontName('Times New Roman');

    $style_php_word = new Class_Phpword;
    /* DON'T CHECK WORDS */
    $phpWord->getSettings()->setThemeFontLang(new PhpOffice\PhpWord\Style\Language(PhpOffice\PhpWord\Style\Language::RU_RU));
    $phpWord->getSettings()->setHideSpellingErrors(true);
    $phpWord->getSettings()->setHideGrammaticalErrors(true);
    //$phpWord->getSettings()->setAutoHyphenation(true);


    $section = $phpWord->addSection(
        array('marginLeft'   => PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), 'marginRight'  => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75),
            'marginTop'    => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.95), 'marginBottom' => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.63),
            'orientation'  => 'landscape')
    );


    $table = $section->addTable((array('borderSize' => 3, 'cellMarginLeft' => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19), 'cellMarginRight' => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19))));

    $table->addRow();
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('vMerge' => 'restart', 'valign' => 'center', 'align' => 'center', 'textDirection' => PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR))->addText("№ п/п", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), $style_php_word::cellRowSpan)->addText('Адрес,<w:br/>ведомственная принадлежность', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(10), $style_php_word::cellRowSpan)->addText('Привлекаемые силы<w:br/>МЧС и организаций<w:br/>(подразделение,<w:br/>техника)', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(6), $style_php_word::cellColSpan_6)->addText("Время", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('vMerge' => 'restart', 'valign' => 'center', 'align' => 'center', 'textDirection' => PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR))->addText('Расстоя-<w:br/>ние, км', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    /* second row of head */
    $table->addRow();
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), $style_php_word::cellRowContinue);
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), $style_php_word::cellRowContinue);
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(10), $style_php_word::cellRowContinue);

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'center', 'align' => 'center'))->addText("сообщения<w:br/>о ЧС", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'center', 'align' => 'center'))->addText("выезда", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'center', 'align' => 'center'))->addText("прибытия<w:br/>к месту<w:br/>ЧС", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'center', 'align' => 'center'))->addText("локализа-<w:br/>ции", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'center', 'align' => 'center'))->addText("ликвида-<w:br/>ции", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'center', 'align' => 'center'))->addText("возвра-<w:br/>щения", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), $style_php_word::cellRowContinue);

    /* third row of head */
    $table->addRow();
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), $style_php_word::cellColSpan_10_yellow)->addText("ПОЖАРЫ", array('align' => 'center', 'size' => 12, 'bold' => true, 'color' => "red"), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));


    if ($is_fire > 0) {
        $i = 0;
        foreach ($data['rig'] as $row) {
            if ($row['id_reasonrig'] == REASON_FIRE) {
                $i++;
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($i, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));

                    $addr = '';

                    if(!in_array($row['locality_id_vid'], CITY_VID)){
                        $addr=$row['local_name'].' район, ';
                    }

                    if ($row['address_type_table_4'] != NULL) {
                        $addr = $addr.$row['address_type_table_4'] . ((!empty($row['additional_field_address']) ? '<w:br/>' . $row['additional_field_address'] : ''));
                    } else {
                        $addr = $addr.$row['additional_field_address'];
                    }
                    if (!empty($row['object'])) {
                        $addr = $addr . '<w:br/>';
                        $addr = $addr . '(' . $row['object'] . ')';
                    }

                if (isset($row['id_owner_category']) && $row['id_owner_category'] != 0) {
                    $addr = $addr . '. ' . mb_convert_case($row['category_name'], MB_CASE_TITLE, "UTF-8") . ': ';
                }
                if (isset($row['owner_fio']) && !empty($row['owner_fio'])) {
                    $addr = $addr . $row['owner_fio'];
                }
                if (isset($row['owner_year_birthday']) && !empty($row['owner_year_birthday']) && $row['owner_year_birthday'] != 0) {
                    $addr = $addr . ', ' . $row['owner_year_birthday'] . ' г.р.';
                }
                if (isset($row['owner_position']) && !empty($row['owner_position'])) {
                    $addr = $addr . ', ' . $row['owner_position'];
                }
                if (isset($row['owner_job']) && !empty($row['owner_job'])) {
                    $addr = $addr . ' ' . $row['owner_job'];
                }


                //$addr=$addr.'. Хозяин(ка): устанавливается.';


                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), array('valign' => 'top', 'align' => 'left'))->addText($addr, $style_php_word::style_cell_font, array('align' => 'left', 'spaceAfter' => 0, 'spacing' => 0));

                $cars = '';
                if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                    foreach ($rig_cars[$row['id']] as $val) {
//                        if ($val['is_return'] == 1)
//                            $cars = $cars . "<w:p><w:r><w:rPr><w:strike/></w:rPr>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'] . "</w:r></w:p>";
//                        else

                        if ($cars=='')
                            $cars = $cars . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'];
                        else
                            $cars = $cars . "<w:br/>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'];

                        //$cars = $cars ."<w:br/>";
                        //$cars = $cars . "<w:p><w:r><w:rPr><w:strike/></w:rPr><w:t>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'] . "</w:t></w:r></w:p>";
                    }
                    //$table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), array('valign' => 'top', 'align' => 'center'))->addText($cars, $style_php_word::style_cell_font, array('align' => 'left', 'spaceAfter' => 0, 'spacing' => 0));
                }

                if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                    foreach ($rig_innerservice[$row['id']] as $val) {

                        if ($cars=='')
                            $cars = $cars . $val['service_name'];
                        else
                            $cars = $cars . "<w:br/>" . $val['service_name'];
                        //$cars = $cars ."<w:p><w:r><w:rPr></w:rPr><w:t>" .$val['service_name'] . "</w:t></w:r></w:p>";
                    }
                }

                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(10), array('valign' => 'top', 'align' => 'center'))->addText($cars, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));

                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText(date('H:i', strtotime($row['time_msg'])), $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));


                $t_exit = '';
                if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                    foreach ($rig_cars[$row['id']] as $val) {

                        if ($t_exit=='')
                            $t_exit = $t_exit . (($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                        else
                            $t_exit = $t_exit . "<w:br/>" . (($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                    }
                }

                if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                    foreach ($rig_innerservice[$row['id']] as $val) {

                        if ($t_exit=='')
                            $t_exit = $t_exit . ((isset($val['time_exit']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                        else
                            $t_exit = $t_exit . "<w:br/>" . ((isset($val['time_exit']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                    }
                }

                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($t_exit, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));




                $t_arrival = '';
                if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                    foreach ($rig_cars[$row['id']] as $val) {

                        if ($t_arrival=='')
                            $t_arrival = $t_arrival . (($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-'));
                        else
                            $t_arrival = $t_arrival . "<w:br/>" . (($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-'));
                    }
                }

                if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                    foreach ($rig_innerservice[$row['id']] as $val) {

                        if ($t_arrival=='')
                            $t_arrival = $t_arrival . (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-');
                        else
                            $t_arrival = $t_arrival . "<w:br/>" . (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-');
                    }
                }

                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($t_arrival, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));


                if ($row['time_loc'] != NULL && $row['time_loc'] != '0000-00-00 00:00:00') {
                    $t_loc = new DateTime($row['time_loc']);
                    $time_loc = $t_loc->Format('H:i');
                } else {
                    $time_loc = '';
                }

                if ($row['time_likv'] != NULL && $row['time_likv'] != '0000-00-00 00:00:00') {
                    $t_likv = new DateTime($row['time_likv']);
                    $time_likv = $t_likv->Format('H:i');
                } elseif ($row['is_likv_before_arrival'] == 1) {
                    $time_likv = 'ликв.до<w:br/>приб.';
                } elseif ($row['is_closed'] == 1) {
                    $time_likv = '-';
                } else {
                    $time_likv = '';
                }
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($time_loc, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($time_likv, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));



                $t_return = '';
                if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                    foreach ($rig_cars[$row['id']] as $val) {
                        if ($t_return=='')
                            $t_return = $t_return . (($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '-');
                        else
                            $t_return = $t_return . "<w:br/>" . (($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '-');
                    }
                }


                if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                    foreach ($rig_innerservice[$row['id']] as $val) {
                        if ($t_return=='')
                            $t_return = $t_return . '-';
                        else
                            $t_return = $t_return . "<w:br/>" . '-';
                    }
                }

                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($t_return, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));



                $distance = '';
                if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                    foreach ($rig_cars[$row['id']] as $val) {
                        if ($distance=='')
                            $distance = $distance . $val['distance'];
                        else
                            $distance = $distance . "<w:br/>" . $val['distance'];
                    }
                }
                if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                    foreach ($rig_innerservice[$row['id']] as $val) {
                        if ($distance=='')
                            $distance = $distance . $val['distance'];
                        else
                            $distance = $distance . "<w:br/>" . $val['distance'];
                    }
                }


                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($distance, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));

                /* detail inf */
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), array('gridSpan' => 10, 'align' => 'both'))->addText(trim($row['inf_detail']), array('align' => 'both', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'both'));
            }
        }
    } else {
        $table->addRow();
        $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), array('gridSpan' => 10, 'align' => 'center'))->addText("нет", array('align' => 'center', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    }


    /* OTHER ZAGOR */
    $section->addTextBreak(1, $style_php_word::header_style_cell_size, $style_php_word::header_style_cell_font);
    $table = $section->addTable((array('borderSize' => 3, 'cellMarginLeft' => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19), 'cellMarginRight' => PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19))));
    $table->addRow();
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('vMerge' => 'restart', 'valign' => 'center', 'align' => 'center', 'textDirection' => PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR))->addText("№ п/п", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), $style_php_word::cellRowSpan)->addText('Адрес,<w:br/>ведомственная принадлежность', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(24), $style_php_word::cellRowSpan)->addText('Привлекаемые силы<w:br/>МЧС и организаций<w:br/>(подразделение,<w:br/>техника)', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.8), $style_php_word::cellColSpan_6)->addText("Время", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.7), array('vMerge' => 'restart', 'valign' => 'center', 'align' => 'center', 'textDirection' => PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR))->addText('Расстоя-<w:br/>ние, км', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), $style_php_word::cellRowSpan)->addText('Описание', array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

    /* second row of head */
    $table->addRow();
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), $style_php_word::cellRowContinue);
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), $style_php_word::cellRowContinue);
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(24), $style_php_word::cellRowContinue);

    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'center', 'align' => 'center'))->addText("сооб-<w:br/>щения<w:br/>о ЧС", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'center', 'align' => 'center'))->addText("выез-<w:br/>да", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'center', 'align' => 'center'))->addText("прибы-<w:br/>тия<w:br/>к месту<w:br/>ЧС", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'center', 'align' => 'center'))->addText("лока-<w:br/>лиза-<w:br/>ции", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'center', 'align' => 'center'))->addText("лик-<w:br/>вида-<w:br/>ции", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'center', 'align' => 'center'))->addText("воз-<w:br/>враще-<w:br/>ния", array('align' => 'center', 'size' => 10, 'bold' => true), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.7), $style_php_word::cellRowContinue);
    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), $style_php_word::cellRowContinue);


    foreach ($all_reasons as $reason) {
        $i = 0;

        /* third row of head */
        if (!in_array(REASON_FIRE, $reason)) {
            $table->addRow();
        }
        if (in_array(REASON_OTHER_ZAGOR, $reason)) {
            $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), $style_php_word::cellColSpan_11_yellow)->addText("НЕУЧЕТНЫЕ ЗАГОРАНИЯ", array('align' => 'center', 'size' => 12, 'bold' => true, 'color' => "red"), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

            if ($is_other_zagor == 0) {
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), array('gridSpan' => 11, 'align' => 'center'))->addText("нет", array('align' => 'center', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            }
        } elseif (empty(array_diff(REASON_HELP, $reason))) {
            $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), $style_php_word::cellColSpan_11_yellow)->addText("ОКАЗАНИЕ ПОМОЩИ", array('align' => 'center', 'size' => 12, 'bold' => true, 'color' => "red"), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));

            if ($is_help == 0) {
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), array('gridSpan' => 11, 'align' => 'center'))->addText("нет", array('align' => 'center', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            }
        } elseif (in_array(REASON_DEMERK, $reason)) {
            $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), $style_php_word::cellColSpan_11_yellow)->addText("ДЕМЕРКУРИЗАЦИЯ", array('align' => 'center', 'size' => 12, 'bold' => true, 'color' => "red"), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            if ($is_demerk == 0) {
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), array('gridSpan' => 11, 'align' => 'center'))->addText("нет", array('align' => 'center', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            }
        } elseif (in_array(REASON_MOLNIA, $reason)) {
            $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), $style_php_word::cellColSpan_11_yellow)->addText("МОЛНИЯ", array('align' => 'center', 'size' => 12, 'bold' => true, 'color' => "red"), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            if ($is_molnia == 0) {
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), array('gridSpan' => 11, 'align' => 'center'))->addText("нет", array('align' => 'center', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            }
        } elseif (in_array(REASON_LTT, $reason)) {
            $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.0), $style_php_word::cellColSpan_11_yellow)->addText("ЗАГОРАНИЯ В ЭКОСИСТЕМАХ", array('align' => 'center', 'size' => 12, 'bold' => true, 'color' => "red"), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            if ($is_ltt == 0) {
                $table->addRow();
                $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), array('gridSpan' => 11, 'align' => 'center'))->addText("нет", array('align' => 'center', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'center'));
            }
        }


        if (!in_array(REASON_FIRE, $reason)) {


            foreach ($data['rig'] as $row) {


                if (in_array($row['id_reasonrig'], $reason)) {

                    $i++;
                    $table->addRow();
                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(1), array('valign' => 'top', 'align' => 'center'))->addText($i, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));

                    $addr = '';

                    if(!in_array($row['locality_id_vid'], CITY_VID)){
                         $addr=$addr.$row['local_name'].' район, ';
                    }

                    if ($row['address_type_table_4'] != NULL) {
                        $addr = $addr.$row['address_type_table_4'] . ((!empty($row['additional_field_address']) ? '<w:br/>' . $row['additional_field_address'] : ''));
                    } else {
                        $addr = $addr.$row['additional_field_address'];
                    }
                    if (!empty($row['object'])) {
                        $addr = $addr . '<w:br/>';
                        $addr = $addr . '(' . $row['object'] . ')';
                    }



                    if (isset($row['id_owner_category']) && $row['id_owner_category'] != 0) {
                        $addr = $addr . '. ' . mb_convert_case($row['category_name'], MB_CASE_TITLE, "UTF-8") . ': ';
                    }
                    if (isset($row['owner_fio']) && !empty($row['owner_fio'])) {
                        $addr = $addr . $row['owner_fio'];
                    }
                    if (isset($row['owner_year_birthday']) && !empty($row['owner_year_birthday']) && $row['owner_year_birthday'] != 0) {
                        $addr = $addr . ', ' . $row['owner_year_birthday'] . ' г.р.';
                    }
                    if (isset($row['owner_position']) && !empty($row['owner_position'])) {
                        $addr = $addr . ', ' . $row['owner_position'];
                    }
                    if (isset($row['owner_job']) && !empty($row['owner_job'])) {
                        $addr = $addr . ' ' . $row['owner_job'];
                    }



                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), array('valign' => 'top', 'align' => 'left'))->addText($addr, $style_php_word::style_cell_font, array('align' => 'left', 'spaceAfter' => 0, 'spacing' => 0));

                    $cars = '';
                    if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                        foreach ($rig_cars[$row['id']] as $val) {
//                        if ($val['is_return'] == 1)
//                            $cars = $cars . "<w:p><w:r><w:rPr><w:strike/></w:rPr>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'] . "</w:r></w:p>";
//                        else

                            if ($cars=='')
                                $cars = $cars . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'];
                            else
                                $cars = $cars . "<w:br/>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'];

                            //$cars = $cars ."<w:br/>";
                            //$cars = $cars . "<w:p><w:r><w:rPr><w:strike/></w:rPr><w:t>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'] . "</w:t></w:r></w:p>";
                        }
                        //$table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), array('valign' => 'top', 'align' => 'center'))->addText($cars, $style_php_word::style_cell_font, array('align' => 'left', 'spaceAfter' => 0, 'spacing' => 0));
                    }

                    if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                        foreach ($rig_innerservice[$row['id']] as $val) {

                            if ($cars=='')
                                $cars = $cars . $val['service_name'];
                            else
                                $cars = $cars . "<w:br/>" . $val['service_name'];
                            //$cars = $cars ."<w:p><w:r><w:rPr></w:rPr><w:t>" .$val['service_name'] . "</w:t></w:r></w:p>";
                        }
                    }

                        $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(24), array('valign' => 'top', 'align' => 'center'))->addText($cars, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));




                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'top', 'align' => 'center'))->addText(date('H:i', strtotime($row['time_msg'])), $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));





                    $t_exit = '';
                    if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                        foreach ($rig_cars[$row['id']] as $val) {

                            if ($t_exit=='')
                                $t_exit = $t_exit . (($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                            else
                                $t_exit = $t_exit . "<w:br/>" . (($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                        }
                    }

                    if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                        foreach ($rig_innerservice[$row['id']] as $val) {

                            if ($t_exit=='')
                                $t_exit = $t_exit . ((isset($val['time_exit']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                            else
                                $t_exit = $t_exit . "<w:br/>" . ((isset($val['time_exit']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                        }
                    }

                        $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'top', 'align' => 'center'))->addText($t_exit, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));




                    $t_arrival = '';
                    if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                        foreach ($rig_cars[$row['id']] as $val) {

                            if ($t_arrival=='')
                                $t_arrival = $t_arrival . (($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-'));
                            else
                                $t_arrival = $t_arrival . "<w:br/>" . (($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-'));
                        }
                    }

                    if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                        foreach ($rig_innerservice[$row['id']] as $val) {

                            if ($t_arrival=='')
                                $t_arrival = $t_arrival . (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-');
                            else
                                $t_arrival = $t_arrival . "<w:br/>" . (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-');
                        }
                    }

                        $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'top', 'align' => 'center'))->addText($t_arrival, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));




                    if ($row['time_loc'] != NULL && $row['time_loc'] != '0000-00-00 00:00:00') {
                        $t_loc = new DateTime($row['time_loc']);
                        $time_loc = $t_loc->Format('H:i');
                    } else {
                        $time_loc = '';
                    }

                if ($row['time_likv'] != NULL && $row['time_likv'] != '0000-00-00 00:00:00') {
                    $t_likv = new DateTime($row['time_likv']);
                    $time_likv = $t_likv->Format('H:i');
                } elseif ($row['is_likv_before_arrival'] == 1) {
                    $time_likv = 'ликв.<w:br/>до<w:br/>приб.';
                } elseif ($row['is_closed'] == 1) {
                    $time_likv = '-';
                } else {
                    $time_likv = '';
                }
                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'top', 'align' => 'center'))->addText($time_loc, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));
                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'top', 'align' => 'center'))->addText($time_likv, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));



                    $t_return = '';
                    if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                        foreach ($rig_cars[$row['id']] as $val) {
                            if ($t_return == '')
                                $t_return = $t_return . (($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '-');
                            else
                                $t_return = $t_return . "<w:br/>" . (($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '-');
                        }
                    }


                    if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                        foreach ($rig_innerservice[$row['id']] as $val) {
                            if ($t_return == '')
                                $t_return = $t_return . '-';
                            else
                                $t_return = $t_return . "<w:br/>" . '-';
                        }
                    }

                        $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8), array('valign' => 'top', 'align' => 'center'))->addText($t_return, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));



                    $distance = '';
                    if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                        foreach ($rig_cars[$row['id']] as $val) {
                            if ($distance=='')
                                $distance = $distance . $val['distance'];
                            else
                                $distance = $distance . "<w:br/>" . $val['distance'];
                        }
                    }
                    if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                        foreach ($rig_innerservice[$row['id']] as $val) {
                            if ($distance=='')
                                $distance = $distance . $val['distance'];
                            else
                                $distance = $distance . "<w:br/>" . $val['distance'];
                        }
                    }


                        $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.7), array('valign' => 'top', 'align' => 'center'))->addText($distance, $style_php_word::style_cell_font, array('align' => 'center', 'spaceAfter' => 0, 'spacing' => 0));

                    /* detail inf */
                    $table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), array('align' => 'both'))->addText(trim($row['inf_detail']), array('align' => 'both', 'size' => 12), array('spaceAfter' => 0, 'spacing' => 0, 'align' => 'both'));
                }
            }
        }
    }





    $phpWord->addParagraphStyle(
        'leftTab', array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('left', 9090)))
    );

    $file_download = $caption.' с 06-00 ' . (\DateTime::createFromFormat('Y-m-d', $rig_m->date_start)->format('d.m.Y')) . ' до 06-00 ' . (\DateTime::createFromFormat('Y-m-d', $rig_m->date_end)->format('d.m.Y')).'.docx';
    header("Content-Description: File Transfer");
    header('Content-Disposition: attachment; filename="' . $file_download . '"');
    header("Content-Type: application/msword");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save("php://output");
});






/* edit np */

$app->get('/np_edit','is_login', function () use ($app) {

    $data['title'] = 'Нас.пункты/Редактировать';

    $bread_crumb = array('Нас.пункты', 'Редактировать');
    $data['bread_crumb'] = $bread_crumb;

    /*     * *** Классификаторы **** */
    $region = new Model_Region();
    $data['region'] = $region->selectAll(); //области
    $local = new Model_Local();
    $data['local'] = $local->selectAll(); //районы

    $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

    /*     * *** КОНЕЦ Классификаторы **** */

    $app->render('layouts/header.php', $data);
    $data['path_to_view'] = 'np_edit/form.php';
    $app->render('layouts/div_wrapper.php', $data);
    $app->render('layouts/footer.php');
});


$app->post('/np_edit','is_login', function () use ($app) {

    $region_m = new Model_Region();

    $post = $app->request()->post();

    if (isset($post['save_edit'])) {//save
        $id_region = $post['id_region'];
        $id_local = $post['id_local'];

        $delete = [];

        if (!empty($post['locality'])) {


            foreach ($post['locality'] as $row) {

                if (isset($row['is_delete']) && $row['is_delete'] == 1 && isset($row['id']) && !empty($row['id'])) {
                    $delete[] = $row['id'];
                } elseif (isset($row['id']) && !empty($row['id'])) {
                    $main = R::load('locality', $row['id']);
                    $main->name = $row['name'];
                    $main->id_vid = $row['id_vid'];
                    $main->id_selsovet = $row['id_selsovet'];
                    $main->last_update = date('Y-m-d H:i:s');
                    R::store($main);
                } elseif (empty($row['id']) && !empty($row['name']) && (!isset($row['is_delete']) || $row['is_delete'] == 0)) {

                    $main = R::dispense('locality');
                    $main->id_region = $id_region;
                    $main->id_local = $id_local;
                    $main->name = $row['name'];
                    $main->id_vid = $row['id_vid'];
                    $main->id_selsovet = $row['id_selsovet'];
                    $main->date_create = date('Y-m-d H:i:s');
                    R::store($main);
                }
            }
        }

        if (!empty($post['without_loc'])) {

            foreach ($post['without_loc'] as $row) {

                if (isset($row['is_delete']) && $row['is_delete'] == 1 && isset($row['id']) && !empty($row['id'])) {
                    $delete[] = $row['id'];
                } elseif (isset($row['id']) && !empty($row['id'])) {
                    $main = R::load('locality', $row['id']);
                    $main->name = $row['name'];
                    $main->id_vid = $row['id_vid'];
                    $main->id_selsovet = (isset($row['id_selsovet']) && !empty($row['id_selsovet'])) ? $row['id_selsovet'] : 0;
                    $main->last_update = date('Y-m-d H:i:s');
                    R::store($main);
                } elseif (empty($row['id']) && !empty($row['name']) && (!isset($row['is_delete']) || $row['is_delete'] == 0)) {

                    $main = R::dispense('locality');
                    $main->id_region = $id_region;
                    $main->id_local = $id_local;
                    $main->name = $row['name'];
                    $main->id_vid = $row['id_vid'];
                    $main->id_selsovet = $row['id_selsovet'];
                    $main->date_create = date('Y-m-d H:i:s');
                    R::store($main);
                }
            }
        }

        if (!empty($delete)) {

            foreach ($delete as $value) {
                $f = R::load('locality', $value);
                R::trash($f);
            }
        }

        $app->redirect('np_edit');
    } else {//get all selsovets by local
        $data['title'] = 'Нас.пункты/Редактировать';

        $bread_crumb = array('Нас.пункты', 'Редактировать');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** Классификаторы **** */

        $data['region'] = $region_m->selectAll(); //области
        $local_m = new Model_Local();
        $data['local'] = $local_m->selectAll(); //районы

        $data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        /*         * *** КОНЕЦ Классификаторы **** */


        $id_reg = $app->request()->post('id_region');
        $id_loc = $app->request()->post('id_local');


        $data['vid_locality'] = $local_m->get_vid_locality();


        $selsovet = $local_m->get_all_selsovet_by_local($id_loc);

        if (isset($selsovet) && !empty($selsovet)) {
            foreach ($selsovet as $key => $row) {
                $selsovet[$key]['locality'] = $local_m->get_all_locality_by_selsovet($row['id']);
            }
        }

        $data['selsovet'] = $selsovet;

        $locality_without_selsovet = $local_m->get_locality_without_selsovet($id_loc);
        $data['locality_without_selsovet'] = $locality_without_selsovet;





        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/np_edit/header.php', $data);
        $data['path_to_view'] = 'np_edit/index_1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/np_edit/footer.php');

//        $app->render('layouts/header.php', $data);
//        //$data['path_to_view'] = 'np_edit/index.php';
//        $data['path_to_view'] = 'np_edit/index_1.php';
//        $app->render('layouts/div_wrapper.php', $data);
//        $app->render('layouts/footer.php');
    }
});



$app->post('/loadApi/:type','is_login', function ($type) use ($app) {




//print_r($_FILES);
        if (!empty($_FILES) && isset($type) && !empty($type)) {

                                        function translit($s)
            {
                $s = (string) $s; // преобразуем в строковое значение
                $s = trim($s); // убираем пробелы в начале и конце строки
                $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
                $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
                return $s; // возвращаем результат
            }

            $uploaddir = UPLOAD_PATH.'/remark/';

            $config = [];


            if($type=='remark_rcu_file'){


                $allowed_extension = array('doc', 'docx', 'txt', 'xls', 'xlsx', 'jpg', 'png','pdf');


                $count = count($_FILES['file']['name']);
                $post = $_FILES['file'];
                $arr_photo = [];
                $arr_error = [];


                //check sum size photo
                $size=0;
                for ($i = 0; $i < $count; $i++) {
                    $size += $post['size'][$i];//in bytes
                }

                 if($size>SIZE_SUM_REMARK_RCU_FILE){
                     $msg= 'Суммарный объем файлов превышает допустимый ('.(SIZE_SUM_REMARK_RCU_FILE/1000000).' Мб)';
                     $arr_error = array('error' => $msg);
                        echo json_encode($arr_error);
                        die();
                 }




                for ($i = 0; $i < $count; $i++) {

                    $_FILES['file']['name'] = $post['name'][$i];
                    $_FILES['file']['type'] = $post['type'][$i];
                    $_FILES['file']['tmp_name'] = $post['tmp_name'][$i];
                    $_FILES['file']['error'] = $post['error'][$i];
                    $_FILES['file']['size'] = $post['size'][$i];
                    $_FILES['file']['tmp_name'] = $post['tmp_name'][$i];
                    //echo $_FILES['file']['name'];


                      $info = new SplFileInfo($post['name'][$i]);
                $extens = $info->getExtension();


                if(in_array($extens,['txt','doc','docx','xls','xlsx','ppt','pptx'])){
                    $type_source='file';
                }
                else{
                    $type_source='img';
                }

                // Allow certain file formats
                if (!in_array($extens, $allowed_extension)) {

                    $msg = "Допустимы только следующие файлы: " . implode(',', $allowed_extension) . ".";

                    $arr_error = array('error' => $msg);
                    echo json_encode($arr_error);
                    die();
                }





                $uploadfile = $uploaddir . basename($_FILES['file']['name']);

                            $file_name_only = basename($uploadfile, "." . $info->getExtension());

                            $translit_file=translit($file_name_only) . '.' . $info->getExtension();
            $new_name_file = $uploaddir . $translit_file;

                                if (move_uploaded_file($_FILES['file']['tmp_name'], $new_name_file)) {
     $arr_photo[] = array('success' => $new_name_file, 'file_name' => $translit_file,'type_source'=>$type_source);
                } else {
                    $msg = "Возможная атака с помощью файловой загрузки!";
                   $arr_error = array('error' => $msg,'name_file_error'=>$_FILES['file']['name']);
                        echo json_encode($arr_error);
                        die();

                }


                }

                if (empty($arr_error)){
                    $res['is_ok']=1;
                    $res['images']=$arr_photo;
                    echo json_encode($res);
                }

                die();



            }
        }


});


/* NII reports */

$app->group('/nii_reports', 'is_login', 'is_permis', function () use ($app, $log) {


    $app->get('/', function () use ($app) {

        $data['title'] = 'ОСА НИИ ПБиЧС/Отчеты';

        $bread_crumb = array('ОСА НИИ ПБиЧС', 'Отчеты');
        $data['bread_crumb'] = $bread_crumb;

        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        //$data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        /*         * *** КОНЕЦ Классификаторы **** */

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'nii_reports/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->get('/rep1', function () use ($app) {


        $data['title'] = 'ОСА НИИ ПБиЧС/Отчеты';
        $data['name_rep'] = 'Отчет по пожарам и неучетным загораниям';

        $bread_crumb = array('ОСА НИИ ПБиЧС', '<a href="' . BASE_URL . '/nii_reports">Отчеты</a>', $data['name_rep']);
        $data['bread_crumb'] = $bread_crumb;



        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        //$data['reasonrig'] = R::getAll('select * from reasonrig where is_delete = ?', array(0));

        /*         * *** КОНЕЦ Классификаторы **** */

        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'nii_reports/rep1/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->post('/rep1', function () use ($app) {

        $filter = [];

        $post = $app->request()->post();
        $from = (isset($post['date_start']) && !empty($post['date_start'])) ? (\DateTime::createFromFormat('Y-m-d', $post['date_start'])->format('Y-m-d')) : '';
        $to = (isset($post['date_end']) && !empty($post['date_end'])) ? (\DateTime::createFromFormat('Y-m-d', $post['date_end'])->format('Y-m-d')) : '';
        $id_region = $filter['id_region'] = (isset($post['id_region']) && !empty($post['id_region'])) ? $post['id_region'] : 0;
        $id_local = $filter['id_local'] = (isset($post['id_local']) && !empty($post['id_local'])) ? $post['id_local'] : '';


        /* MODELS */
        $sily_m = new Model_Jrig();
        $rig_m = new Model_Rigtable();
        $inner_m = new Model_Innerservice();
        $informing_m = new Model_Informing();
        $sily_mchs_m = new Model_Silymchs();

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();





        $filter['reasonrig'] = array(REASON_FIRE, REASON_OTHER_ZAGOR);




        if (isset($from) && !empty($from)) {
            $rig_m->setDateStart(trim($from));
        } else {
            if (date("H:i:s") <= '06:00:00') {//до 06 утра
                $rig_m->setDateStart(date("d.m.Y", time() - (60 * 60 * 24)));
            } else {
                $rig_m->setDateStart(date("d.m.Y"));
            }
        }

        if (isset($to) && !empty($to)) {
            $rig_m->setDateEnd(trim($to));
        } else {
            if (date("H:i:s") <= '06:00:00') {//до 06 утра
                $rig_m->setDateEnd(date("d.m.Y"));
            } else {
                $rig_m->setDateEnd(date("d.m.Y", time() + (60 * 60 * 24)));
            }
        }


        $caption = 'по Республике';


        $data['rig'] = $rig_m->select_all_rigs($filter); //без ЦП


        if (!empty($data['rig']))
            usort($data['rig'], "order_rigs");

        if ($id_region != 0) {
            $region_name = R::getCell('select name from regions where id = ?', array($id_region));


            if ($id_region != 3)
                $caption = $region_name . ' область';
            else
                $caption = $region_name;
        }

        if ($id_local != 0) {
            $local_name = R::getCell('select name from locals where id = ?', array($id_local));

            if ($id_region != 0) {
                $caption = $caption . ', район: ' . $local_name;
            } else
                $caption = 'Район: ' . $local_name;
        }




        if (!empty($data['rig']))
            usort($data['rig'], "order_rigs_asc");

        /* ------- select information on SiS MHS -------- */
        $id_rig_arr = array();
        $id_rig_informing = array();
        $id_rig_sis_mes = array();

        $is_fire = 0;
        $is_other_zagor = 0;
        $is_help = 0;
        $is_demerk = 0;
        $is_molnia = 0;
        $is_ltt = 0;

        $all_reasons = array(REASON_FIRE, REASON_OTHER_ZAGOR);


        foreach ($data['rig'] as $value) {//id of rigs
            if ($value['id_reasonrig'] == REASON_FIRE) {
                $is_fire++;
            }

            if ($value['id_reasonrig'] == REASON_OTHER_ZAGOR) {
                $is_other_zagor++;
            }


            if ($value['id'] != null) {
                $id_rig_arr[] = $value['id'];
                $id_rig_informing[] = $value['id'];
            }

            if ($value['is_sily_mchs'] != 1 && $value['id'] != null) {
                $id_rig_sis_mes[] = $value['id'];
            }
        }

        /* ------- END select information on SiS MHS-------- */

        $rig_cars = [];
        $rig_innerservice = [];
        $rig_informing = [];
        if (!empty($id_rig_sis_mes)) {
            //sis mchs
            $jrig = $sily_m->get_jrig_by_rigs_for_word($id_rig_sis_mes);

            if (!empty($jrig)) {
                foreach ($jrig as $row) {
                    $rig_cars[$row['id_rig']][] = $row;
                }
            }
        }

        //sis inner
        if (!empty($id_rig_arr)) {
            $inner = $inner_m->get_innerservice_by_rigs($id_rig_arr);

            if (!empty($inner)) {
                foreach ($inner as $row) {
                    $rig_innerservice[$row['id_rig']][] = $row;
                }
            }
        }


        //informing
        if (!empty($id_rig_informing)) {
            $informing = $informing_m->get_informing_by_rigs($id_rig_informing);

            if (!empty($informing)) {
                foreach ($informing as $row) {

                    $rig_informing[$row['id_rig']][] = $row;
                }
            }
        }

        $data['rig_cars'] = $rig_cars;
        $data['rig_innerservice'] = $rig_innerservice;
        $data['rig_informing'] = $rig_informing;

//print_r($data['rig']);




        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/nii_reports/rep1.xlsx');

        $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
        $sheet = $objPHPExcel->getActiveSheet();


        $sheet->setCellValue('A1', 'Выезды с 06:00 ' . (\DateTime::createFromFormat('Y-m-d', $from)->format('d.m.Y')) . ' до 06:00 ' . (\DateTime::createFromFormat('Y-m-d', $to)->format('d.m.Y'))); //выбранный период
        $sheet->setCellValue('A2', $caption); //выбранный область и район

        $r = 8; //начальная строка для записи
        $c = 0; //счетчик кол-ва записей № п/п



        $style_reason = array(
            'fill' => array(
                'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                'color' => array(
                    'rgb' => '7ad4f5'
                )
            )
        );
        $style_ate = array(
            'fill' => array(
                'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
                'color' => array(
                    'rgb' => 'fafa28'
                )
            )
        );
        $style_all = array(
// Заполнение цветом
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if (isset($data['rig']) && !empty($data['rig'])) {



            foreach ($all_reasons as $reason) {

                $i = 0;
                $sheet->mergeCells('A' . $r . ':Q' . $r);
                if ($reason == REASON_FIRE) {

                    $sheet->setCellValueByColumnAndRow($c, $r, 'ПОЖАРЫ');
                    $sheet->getStyle('A' . $r . ':Q' . $r)->applyFromArray($style_reason);
                    if ($is_fire == 0) {

                        $r++;
                        $sheet->mergeCells('A' . $r . ':Q' . $r);
                        $sheet->setCellValueByColumnAndRow($c, $r, 'нет');
                    }
                } elseif ($reason == REASON_OTHER_ZAGOR) {

                    $sheet->setCellValueByColumnAndRow($c, $r, 'НЕУЧЕТНЫЕ ЗАГОРАНИЯ');
                    $sheet->getStyle('A' . $r . ':Q' . $r)->applyFromArray($style_reason);
                    if ($is_other_zagor == 0) {

                        $r++;
                        $sheet->mergeCells('A' . $r . ':Q' . $r);
                        $sheet->setCellValueByColumnAndRow($c, $r, 'нет');
                    }
                }

                $r++;

                if (($reason == REASON_FIRE && $is_fire > 0) || ($reason == REASON_OTHER_ZAGOR && $is_other_zagor > 0)) {

                    foreach ($data['rig'] as $row) {
                        $c = 0;
                        if ($row['id_reasonrig'] == $reason) {
                            $i++;


                            $sheet->setCellValueByColumnAndRow($c, $r, $i);
                            $c++;

                            $sheet->setCellValueByColumnAndRow($c, $r, $row['id']);
                            $c++;
//code ate
                            $sheet->setCellValueByColumnAndRow($c, $r, $row['locality_id']);
                            $sheet->getStyle('C' . $r . ':C' . $r)->applyFromArray($style_ate);
                            $c++;
                            $sheet->setCellValueByColumnAndRow($c, $r, date('d.m.Y', strtotime($row['date_msg'])));
                            $c++;
                            $sheet->setCellValueByColumnAndRow($c, $r, date('H:i', strtotime($row['time_msg'])));
                            $c++;
                            $sheet->setCellValueByColumnAndRow($c, $r, $row['local_name']);
                            $c++;

                            $addr = '';

                            if (!in_array($row['locality_id_vid'], CITY_VID)) {
                                $addr = $row['local_name'] . ' район, ';
                            }

                            if ($row['address_type_table_4'] != NULL) {
                                $addr = $addr . $row['address_type_table_4'] . ((!empty($row['additional_field_address']) ? '<w:br/>' . $row['additional_field_address'] : ''));
                            } else {
                                $addr = $addr . $row['additional_field_address'];
                            }

                            if (!empty($row['object'])) {
                                $addr = $addr . chr(10);
                                $addr = $addr . '(' . $row['object'] . ')';
                            }

                            if (isset($row['id_owner_category']) && $row['id_owner_category'] != 0) {
                                $addr = $addr . '. ' . mb_convert_case($row['category_name'], MB_CASE_TITLE, "UTF-8") . ': ';
                            }
                            if (isset($row['owner_fio']) && !empty($row['owner_fio'])) {
                                $addr = $addr . $row['owner_fio'];
                            }
                            if (isset($row['owner_year_birthday']) && !empty($row['owner_year_birthday']) && $row['owner_year_birthday'] != 0) {
                                $addr = $addr . ', ' . $row['owner_year_birthday'] . ' г.р.';
                            }
                            if (isset($row['owner_position']) && !empty($row['owner_position'])) {
                                $addr = $addr . ', ' . $row['owner_position'];
                            }
                            if (isset($row['owner_job']) && !empty($row['owner_job'])) {
                                $addr = $addr . ' ' . $row['owner_job'];
                            }

                            $sheet->setCellValueByColumnAndRow($c, $r, $addr);
                            $c++;


                            $cars = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                                foreach ($rig_cars[$row['id']] as $val) {
//                        if ($val['is_return'] == 1)
//                            $cars = $cars . "<w:p><w:r><w:rPr><w:strike/></w:rPr>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'] . "</w:r></w:p>";
//                        else

                                    if ($cars == '')
                                        $cars = $cars . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'];
                                    else
                                        $cars = $cars . chr(10) . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'];

                                    //$cars = $cars ."<w:br/>";
                                    //$cars = $cars . "<w:p><w:r><w:rPr><w:strike/></w:rPr><w:t>" . $val['view_name'] . ' ' . $val['pasp_name'] . ' ' . $val['locorg_name'] . "</w:t></w:r></w:p>";
                                }
                                //$table->addCell(PhpOffice\PhpWord\Shared\Converter::cmToTwip(7), array('valign' => 'top', 'align' => 'center'))->addText($cars, $style_php_word::style_cell_font, array('align' => 'left', 'spaceAfter' => 0, 'spacing' => 0));
                            }

                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                                foreach ($rig_innerservice[$row['id']] as $val) {

                                    if ($cars == '')
                                        $cars = $cars . $val['service_name'];
                                    else
                                        $cars = $cars . chr(10) . $val['service_name'];
                                    //$cars = $cars ."<w:p><w:r><w:rPr></w:rPr><w:t>" .$val['service_name'] . "</w:t></w:r></w:p>";
                                }
                            }

                            $sheet->setCellValueByColumnAndRow($c, $r, $cars);
                            $c++;

                            $t_exit = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                                foreach ($rig_cars[$row['id']] as $val) {

                                    if ($t_exit == '')
                                        $t_exit = $t_exit . (($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                                    else
                                        $t_exit = $t_exit . chr(10) . (($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                                }
                            }

                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                                foreach ($rig_innerservice[$row['id']] as $val) {

                                    if ($t_exit == '')
                                        $t_exit = $t_exit . ((isset($val['time_exit']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                                    else
                                        $t_exit = $t_exit . chr(10) . ((isset($val['time_exit']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '-');
                                }
                            }

                            $sheet->setCellValueByColumnAndRow($c, $r, $t_exit);
                            $c++;

                            $t_arrival = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                                foreach ($rig_cars[$row['id']] as $val) {

                                    if ($t_arrival == '')
                                        $t_arrival = $t_arrival . (($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-'));
                                    else
                                        $t_arrival = $t_arrival . chr(10) . (($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-'));
                                }
                            }

                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                                foreach ($rig_innerservice[$row['id']] as $val) {

                                    if ($t_arrival == '')
                                        $t_arrival = $t_arrival . (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-');
                                    else
                                        $t_arrival = $t_arrival . chr(10) . (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '-');
                                }
                            }

                            $sheet->setCellValueByColumnAndRow($c, $r, $t_arrival);
                            $c++;


                            if ($row['time_loc'] != NULL && $row['time_loc'] != '0000-00-00 00:00:00') {
                                $t_loc = new DateTime($row['time_loc']);
                                $time_loc = $t_loc->Format('H:i');
                            } else {
                                $time_loc = '';
                            }

                            if ($row['time_likv'] != NULL && $row['time_likv'] != '0000-00-00 00:00:00') {
                                $t_likv = new DateTime($row['time_likv']);
                                $time_likv = $t_likv->Format('H:i');
                            } elseif ($row['is_likv_before_arrival'] == 1) {
                                $time_likv = 'ликв.до' . chr(10) . 'приб.';
                            } elseif ($row['is_not_measures'] == 1) {
                                $time_likv = 'меры не' . chr(10) . ' прин.';
                            } elseif ($row['is_closed'] == 1) {
                                $time_likv = '-';
                            } else {
                                $time_likv = '';
                            }

                            $sheet->setCellValueByColumnAndRow($c, $r, $time_loc);
                            $c++;
                            $sheet->setCellValueByColumnAndRow($c, $r, $time_likv);
                            $c++;



                            $t_end = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                                foreach ($rig_cars[$row['id']] as $val) {

                                    if ($t_end == '')
                                        $t_end = $t_end . (($val['time_end'] != null) ? date('H:i', strtotime($val['time_end'])) : '-');
                                    else
                                        $t_end = $t_end . chr(10) . (($val['time_end'] != null) ? date('H:i', strtotime($val['time_end'])) : '-');
                                }
                            }

                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {

                                foreach ($rig_innerservice[$row['id']] as $val) {

                                    if ($t_end == '')
                                        $t_end = $t_end . ((isset($val['time_end']) && $val['time_exit'] != null) ? date('H:i', strtotime($val['time_end'])) : '-');
                                    else
                                        $t_end = $t_end . chr(10) . ((isset($val['time_end']) && $val['time_end'] != null) ? date('H:i', strtotime($val['time_end'])) : '-');
                                }
                            }

                            $sheet->setCellValueByColumnAndRow($c, $r, $t_end);
                            $c++;



                            $t_return = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                                foreach ($rig_cars[$row['id']] as $val) {
                                    if ($t_return == '')
                                        $t_return = $t_return . (($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '-');
                                    else
                                        $t_return = $t_return . chr(10) . (($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '-');
                                }
                            }


                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                                foreach ($rig_innerservice[$row['id']] as $val) {
                                    if ($t_return == '')
                                        $t_return = $t_return . '-';
                                    else
                                        $t_return = $t_return . chr(10) . '-';
                                }
                            }
                            $sheet->setCellValueByColumnAndRow($c, $r, $t_return);
                            $c++;



                            $time_follow = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                                foreach ($rig_cars[$row['id']] as $val) {
                                    if ($time_follow == '')
                                        $time_follow = $time_follow . date('H:i', strtotime($val['time_follow']));
                                    else
                                        $time_follow = $time_follow . chr(10) . date('H:i', strtotime($val['time_follow']));
                                }
                            }
                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                                foreach ($rig_innerservice[$row['id']] as $val) {
                                    if ($time_follow == '')
                                        $time_follow = $time_follow . date('H:i', strtotime($val['time_follow']));
                                    else
                                        $time_follow = $time_follow . chr(10) . date('H:i', strtotime($val['time_follow']));
                                }
                            }


                            $sheet->setCellValueByColumnAndRow($c, $r, $time_follow);
                            $c++;


                            $distance = '';
                            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                                foreach ($rig_cars[$row['id']] as $val) {
                                    if ($distance == '')
                                        $distance = $distance . $val['distance'];
                                    else
                                        $distance = $distance . chr(10) . $val['distance'];
                                }
                            }
                            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                                foreach ($rig_innerservice[$row['id']] as $val) {
                                    if ($distance == '')
                                        $distance = $distance . $val['distance'];
                                    else
                                        $distance = $distance . chr(10) . $val['distance'];
                                }
                            }


                            $sheet->setCellValueByColumnAndRow($c, $r, $distance);
                            $c++;

                            $sheet->setCellValueByColumnAndRow($c, $r, trim($row['inf_detail']));
                            $c++;

                            $r++;
                        }
                    }
                }
            }

            $sheet->getStyle('A' . 8 . ':Q' . ($r - 1))->applyFromArray($style_all);
        }



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по пожарам и неучетным загораниям.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    });
});





/* ---------------------- SPECIAL D auth --------------------- */
$app->group('/login_to_speciald', 'is_login', function () use ($app, $log) {

    // login
    $app->get('/:id_rig/:type_sd/:id_template', function ($id_rig = 0,$type_sd='standart',$id_template=0) use ($app) {
        // echo $_SESSION['id_level'];exit();
        // can or not go to speciald
        // if (($_SESSION['can_edit'] == 1) || ($_SESSION['id_level'] == 2 || $_SESSION['id_level'] == 1)) {

        $is_rig = R::getRow('select * from journal.rig where id = ? ', array($id_rig));
        if ($id_rig != 0 && isset($is_rig) && !empty($is_rig)) {

            $id_user_sd = R::getCell('select id_user_sd from journal.user where id = ?', array($_SESSION['id_user']));

            if (isset($id_user_sd) && !empty($id_user_sd)) {

                $user_sd_by_id = R::getCell('select id from speciald.users where id = ?', array($id_user_sd));

                if (isset($user_sd_by_id) && !empty($user_sd_by_id)) {

                    $app->redirect('/speciald/authjour/index/' . $id_user_sd . '/' . $id_rig.'/'.$type_sd.'/'.$id_template);
                } else {
                    $data['title'] = 'Переход в специальное донесение';

                    $bread_crumb = array('Переход в специальное донесение');

                    $data['bread_crumb'] = $bread_crumb;
                    $data['msg'] = 'Невозможно перейти в специальное донесение. Проблема на стороне ПС "Журнал ЦОУ" (нет соответствия пользователей). Обратитесь в ОВПО РЦУРЧС.';
                    $app->render('layouts/header.php', $data);
                    $data['path_to_view'] = 'login_to_speciald/error.php';
                    $app->render('layouts/div_wrapper.php', $data);
                    $app->render('layouts/footer.php');
                }
            } else {


                // can or not go to speciald
                if (($_SESSION['can_edit'] == 1) || ($_SESSION['id_level'] == 2 || $_SESSION['id_level'] == 1)) {

                    //$guest=R::getRow('select * from speciald.users where is_guest = AND can_edit = ? AND ',array(1,1));


                    if (in_array($_SESSION['id_organ'], array(8, 9, 12)) && $_SESSION['id_level'] == 2) {//in SD there is not level 2 for this organs
                        $sql_a = 'select * from speciald.users where is_delete = 0 AND is_guest = 1 AND can_edit = 1 '
                            . 'AND id_region = ' . $_SESSION['id_region'] . ' AND sub = ' . $_SESSION['sub'];
                    } else {

                        $sql_a = 'select * from speciald.users where is_delete = 0 AND is_guest = 1 AND can_edit = 1 AND level = ' . $_SESSION['id_level'] . ''
                            . ' AND id_region = ' . $_SESSION['id_region'] . ' AND sub = ' . $_SESSION['sub'];
                    }



                    if ($_SESSION['id_level'] == 2 && $_SESSION['sub'] == 2) {//oumchs, ROSN Minsk, UGZ Minsk, AVIA Minsk
                        $sql_a = $sql_a . ' AND  id_local = ' . $_SESSION['id_local'];
                        $sql_a = $sql_a . ' AND  id_organ = ' . $_SESSION['id_organ'];
                    } elseif ($_SESSION['id_level'] == 3 && $_SESSION['sub'] == 2) {//local of ROSN , UGZ , AVIA
                        $sql_a = $sql_a . ' AND  id_local = ' . $_SESSION['id_local'];
                        $sql_a = $sql_a . ' AND  id_organ = ' . $_SESSION['id_organ'];
                    } elseif ($_SESSION['id_level'] == 3 && $_SESSION['sub'] == 0) {//local of umchs
                        $sql_a = $sql_a . ' AND  id_local = ' . $_SESSION['id_local'];
                    }

                    $guest = R::getAll($sql_a);

                    if (isset($guest) && !empty($guest) && $id_rig != 0) {


//            $fio=$_SESSION['fio'];
//            $position=$_SESSION['position'];
                        $fio = $_SESSION['user_name'];
                        $position = 'должность';

                        $app->redirect('/speciald/guest/index/' . $guest[0]['id'] . '/' . $_SESSION['id_user'] . '/' . $id_rig);
                    } else {
                        $data['title'] = 'Переход в специальное донесение';

                        $bread_crumb = array('Переход в специальное донесение');

                        $data['bread_crumb'] = $bread_crumb;
                        $data['msg'] = 'Невозможно перейти в специальное донесение в режиме гостя. Проблема на стороне ПС "Специальные донесения" (возможно отсутствует роль гостя для данного района). Обратитесь в ОВПО РЦУРЧС.';
                        $app->render('layouts/header.php', $data);
                        $data['path_to_view'] = 'login_to_speciald/error.php';
                        $app->render('layouts/div_wrapper.php', $data);
                        $app->render('layouts/footer.php');
                    }
                } else {
                    //$app->redirect(BASE_URL . '/login_to_speciald/not_allowed');
                    $data['title'] = 'Переход в специальное донесение';

                    $bread_crumb = array('Переход в специальное донесение');

                    $data['bread_crumb'] = $bread_crumb;
                    $data['msg'] = 'Невозможно перейти в специальное донесение в режиме гостя. Проблема на стороне ПС "Журнал ЦОУ" - у Вас нет прав на выполнение данной операции. Обратитесь в ОВПО РЦУРЧС.';
                    $app->render('layouts/header.php', $data);
                    $data['path_to_view'] = 'login_to_speciald/error.php';
                    $app->render('layouts/div_wrapper.php', $data);
                    $app->render('layouts/footer.php');
                }
            }
        } else {
            $data['title'] = 'Переход в специальное донесение';

            $bread_crumb = array('Переход в специальное донесение');

            $data['bread_crumb'] = $bread_crumb;
            $data['msg'] = 'Невозможно перейти в специальное донесение. Проблема на стороне ПС "Журнал ЦОУ" - невозможно найти запрошенный выезд. Обратитесь в ОВПО РЦУРЧС.';
            $app->render('layouts/header.php', $data);
            $data['path_to_view'] = 'login_to_speciald/error.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
//        } else {
//
//            $app->redirect(BASE_URL . '/login_to_speciald/not_allowed');
//        }
    })->conditions(array('id_rig' => '\d+'));


    $app->get('/not_allowed', function () use ($app) {

        $data['title'] = 'Переход в специальное донесение';

        $bread_crumb = array('Переход в специальное донесение');

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'login_to_speciald/error.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});




$app->run();
