<?php

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

/* ----------------- END CONSTANT ------------------- */

use \RedBeanPHP\Facade as R;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
use App\MODELS\Model_Listmail;//список email
use App\MODELS\Model_Mailsend;// отправленыые путевки
use App\MODELS\Model_Listmailview;//список email


//архив
    use App\MODELS\Model_Archivedate;
        use App\MODELS\Model_Archiveyear;

/* ----------------- END MODELS ----------------- */



/* ----------------- MIDDLEWARE ------------------- */

//use \Slim\Middleware;
//use App\MW\AllCapsMiddleware;
function mw1() {
    echo "This is middleware!";
}

//авторизован ли пользователь
function is_login() {
    $app = \Slim\Slim::getInstance();
    if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {

        //Проверяем, не пустые ли нужные нам куки...
        if (!empty($_COOKIE['id_user']) && ! empty($_COOKIE['key'])) {
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

function is_permis() {
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
    }

        elseif (strpos($app->request->getResourceUri(), 'table')) {//табл выездов кроме РЦУ - фильтр по датам
        //если нет прав н ред/доб выездов -  фильтр по датам работает
    }


            elseif ($_SESSION['can_edit'] != 1) {
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
    }
    elseif(strpos($app->request->getResourceUri(), 'logs')){
                if ($_SESSION['id_user'] == 2 ) {// rcu ovpo

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

    }
}

/* ----------------- END MIDDLEWARE -------------- */

/* -------------------------- ФУНКЦИИ ------------------------- */

/*+++ Генерация key for COOKIE +++*/
	function generateSalt()
	{
		$salt = '';
		$saltLength = 8; //длина соли
		for($i=0; $i<$saltLength; $i++) {
			$salt .= chr(mt_rand(33,126)); //символ из ASCII-table
		}
		return $salt;
	}
/*+++ END Генерация key for COOKIE +++*/


/* ++ Вывод ошибок после валидации формы ++ */
/* array - массив ошибок
 *  url_back - на какую страницу перейти, если нужна конкретная стр
 *  post - post-данные, которые надо отрисовать  в виде формы и выполнить обратный переход методом post
 *  path_to_form_back - путь до файла с формой с кнопкой назад
 */
function show_error($array,$url_back=NULL,$post=NULL,$path_to_form_back=NULL) {
    $data['error'] = $array;
           $data['url_back']=$url_back;
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

function search_rig_by_id($rig_m, $id_rig) {

    $rig = $rig_m->selectAllByIdRig($id_rig, 0); //неудаленный выезд

    if (empty($rig)) {

        $rig = array();
    }

    return $rig;
}

/* +++ Поиск выезда по введенному Id +++ */


/* empty or no technics, time character, informing in rig. If empty - icon is red */
function empty_icons($id_rig_arr)
{
    $result=array();

      /* id of rigs, where silymschs/innerservice are not selected */

    if (!empty($id_rig_arr)) {

        /* silymchs is empty */
        $id_rig_empty_sily = R::getAll('SELECT id_rig FROM countsily WHERE c=? AND id_rig IN (' . implode(',', $id_rig_arr) . ')', array(0));

        $id_rig = array();

        if (!empty($id_rig_empty_sily)) {
            foreach ($id_rig_empty_sily as $value) {
                $id_rig[] = $value['id_rig'];
            }
        }


        /* innerservice is not empty  for this rigs */
        $id_rig_empty_inner=array();
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
    if (!empty($id_rig_arr)) {

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
    if (!empty($id_rig_arr)) {

        $id_rig_empty_character = R::getAll('SELECT id_rig FROM countcharacter WHERE  id_rig IN(' . implode(',', $id_rig_arr) . ')');
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



/* -------------------------- END ФУНКЦИИ ------------------------- */



/* -------------- baseUrl ---------------------- */

$app->hook('slim.before', function () use ($app) {
    $app->view()->appendData(array('baseUrl' => '/journal'));
});
/* -------------- END baseUrl ---------------------- */



/* ------------------------- LogOn ------------------------------- */

$app->group('/login', function () use ($app,$log) {
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
    $log->info('Сессия -  :: Выход пользователя с - id = ' . $_SESSION['id_user'] .' выполнил '.$_SESSION['user_name'].' данные - : ' . $log_array); //запись в logs
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

        $data['title']='Новый пользователь';

        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll();
        $locorg = new Model_Locorgview();
        $data['locorg'] = $locorg->selectAll();

        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы
        $locality = new Model_Locality();
        $data['locality'] = $locality->selectAll(); //нас.пункты

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

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'user/userForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    // add, edit user
    $app->post('/new(/:id)', function ($id = 0) use ($app,$log) {

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

        /* ++  КОНЕЦ обработка POST-данных ++ */

        $user = new Model_User();
        $ok = $user->save($array, $id); //save user

        if ($ok){
					$log_array=json_encode($array,JSON_UNESCAPED_UNICODE);
            $log->info('Сессия -  :: Сохранение пользователя - id = ' . $id.' выполнил '.$_SESSION['user_name'].' данные - : '.$log_array); //запись в logs
             $app->redirect(BASE_URL . '/user');
        }

        else {
            $data['title']='Новый пользователь';
            $bread_crumb = array('Пользователи');
            $data['bread_crumb'] = $bread_crumb;

            $app->render('layouts/header.php',$data);
            $data['path_to_view'] = 'user/error.php';
            $app->render('layouts/div_wrapper.php', $data);
            $app->render('layouts/footer.php');
        }
    });

    //таблица с пользователями
    $app->get('/', function () use ($app) {
$data['title']='Пользователи';
        $permis = new Model_Permissions();
        $data['permissions'] = $permis->selectAll();
        $bread_crumb = array('Пользователи');
        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'user/userTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //вопрос об удалении пользователя
    $app->get('/:id', function ($id) use ($app) {

        $data['title']='Удаление пользователя';

        $bread_crumb = array('Пользователи', 'Удалить');
        $data['bread_crumb'] = $bread_crumb;

        $data['id'] = $id;
        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'user/questionOfDelete.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    })->conditions(array('id' => '\d+'));

    //удаление пользователя
    $app->delete('/:id', function ($id) use ($app, $log) {
        //delete from bd
        $user = new Model_User();

        if ($user->deleteUserById($id)) {
            $log->info('Сессия -  :: Удаление пользователя - запись с id = ' . $id.' выполнил '.$_SESSION['user_name']); //запись в logs
            $app->redirect(BASE_URL . '/user');
        } else {
            $app->redirect(BASE_URL . '/error');
        }
    })->conditions(array('id' => '\d+'));
});

/* ------------------------- END  user ------------------------------- */



/* ------------------------- rig ------------------------------- */

$app->group('/rig', 'is_login', 'is_permis', function () use ($app,$log) {

    // form rig - add, edit
    $app->get('/new(/:id(/:active_tab))', function ($id = 0, $active_tab = 1) use ($app) {


        $data['active_tab'] = $active_tab; //number of active tab
        $data['id'] = $id; //id of rig

        /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $locorg = new Model_Locorgview();
        $data['locorg'] = $locorg->selectAll(1); //выбрать все подразд кроме РЦУ, УМЧС(там нет техники)
        $pasp = new Model_Pasp();
        $data['pasp'] = $pasp->selectAll();

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

            $rig_table_m=new Model_Rigtable();
            $inf_rig=$rig_table_m->selectByIdRig($id);// дата, время, адрес объекта для редактируемого вызова по id

            if ($active_tab != 2) {
                // инф по вызову
                $rig_m = new Model_Rig();
                $rig = $rig_m->selectAllById($id);
                $data['rig'] = $rig;


                /* ------------------ выбор классификаторов с учетом редактируемого вызова ------------------- */
                $data['local'] = $local->selectAllByRegion($rig['id_region']); //районы для области редактируемого вызова

                if ($rig['id_local'] != 0) {

                    $id_loc=($rig['id_local']<0) ? 123 :$rig['id_local'];

                    $data['selsovet'] = $selsovet->selectAllByLocal($id_loc); //сельсоветы для района редактируемого вызова
                     $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района
                }
elseif ($rig['id_region'] != 0) {
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
        }

        /* ------------- КОНЕЦ Редактирование выезда -------------- */

        else {

            //если по умолчанию выбирать в адресе район - город( Витебск, Жодино,...), то надо подгрузить сразу нас.пункты и улицы
            $city = array(21, 22,123,  124, 135, 136, 137, 138, 139, 140, 141);

//$_SESSION['auto_local']<0 только для районов г.минска
            if (in_array($_SESSION['auto_local'], $city) || ($_SESSION['auto_local']<0) ) {//если по умолчанию город выбран
                $data['auto_local_city'] = $city;

                  //если районы г.Минска - выбрать нас пунктом г.Минск
                    $id_loc=($_SESSION['auto_local']<0) ? 123 : $_SESSION['auto_local'];

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
                    $id_loc=($_SESSION['auto_local']<0) ? 123 : $_SESSION['auto_local'];

                    $data['locality'] = $locality->selectAllByLocal($id_loc); //нас.пункты района

                    $data['selsovet'] = $selsovet->selectAllByLocal($_SESSION['auto_local']); //сельсоветы для района
                }
            }


            $data['local'] = $local->selectAllByRegion($_SESSION['id_region']); //районы авторизованной области
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

        /*--------- добавить инф о редактируемом вызове ------------*/

        if($id != 0){

            if(isset($inf_rig) && !empty($inf_rig)){
                foreach ($inf_rig as $value) {
                    $date_rig=$value['date_msg'].' '.$value['time_msg'];
                    $adr_rig=(empty($value['address'])) ? $value['additional_field_address']: $value['address'];
                }
                $bread_crumb[]=$date_rig;
                $bread_crumb[]=$adr_rig;
            }

        }

         /*--------- добавить инф о редактируемом вызове ------------*/

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php', $data);
        $data['path_to_view'] = 'rig/tabsRig/rigForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    // form informing
    $app->get('/:id/info', function ($id) use ($app) {

        $bread_crumb = array('Информирование');
        $data['title']='Информирование';

        $data['id_rig'] = $id;


                   /*--------- добавить инф о редактируемом вызове ------------*/
        if($id != 0){

           $rig_table_m=new Model_Rigtable();
           $inf_rig=$rig_table_m->selectByIdRig($id);// дата, время, адрес объекта для редактируемого вызова по id

            if(isset($inf_rig) && !empty($inf_rig)){
                foreach ($inf_rig as $value) {
                    $date_rig=$value['date_msg'].' '.$value['time_msg'];
                    $adr_rig=(empty($value['address'])) ? $value['additional_field_address']: $value['address'];
                }
                $bread_crumb[]=$date_rig;
                $bread_crumb[]=$adr_rig;
            }

        }
         /*--------- добавить инф о редактируемом вызове ------------*/


        $data['bread_crumb'] = $bread_crumb;

        /*         * ********* Классификаторы ************* */
        $destination_m = new Model_Destinationlist();
        $data['destinationlist'] = $destination_m->selectAll(); //Список адресатов

        /*         * ********* КОНЕЦ Классификаторы************* */

        /* --------------- Уже существующие адресаты по выезду ------------------- */
        $informing_m = new Model_Informing();
        $data['informing_by_rig'] = $informing_m->selectAllByIdRig($id);
        /* --------------- КОНЕЦ Уже существующие адресаты по выезду ------------------- */

        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'rig/info/infoForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //save info
    $app->post('/:id/info', function ($id) use ($app,$log) {

        /*         * ********* Обработка POST-данных************* */
        $informing_m = new Model_Informing();
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

				$log_post_info=json_encode($post_info,JSON_UNESCAPED_UNICODE);
 $log->info('Сессия -  :: Сохранение ИНФОРМИРОВАНИЕ - id_rig = ' . $id.' данные - : '.$log_post_info); //запись в logs
        $app->redirect(BASE_URL . '/rig');
    });


    // form time character, journal of rigs
    $app->get('/:id/character', function ($id) use ($app) {

        $bread_crumb = array('Временные характеристики выезда');

        $data['title']='Временные характеристики выезда';
        $data['id'] = $id;


                           /*--------- добавить инф о редактируемом вызове ------------*/
        if($id != 0){

           $rig_table_m=new Model_Rigtable();
           $inf_rig=$rig_table_m->selectByIdRig($id);// дата, время, адрес объекта для редактируемого вызова по id

            if(isset($inf_rig) && !empty($inf_rig)){
                foreach ($inf_rig as $value) {
                    $date_rig=$value['date_msg'].' '.$value['time_msg'];
                    $adr_rig=(empty($value['address'])) ? $value['additional_field_address']: $value['address'];
                }
                $bread_crumb[]=$date_rig;
                $bread_crumb[]=$adr_rig;
            }

        }
         /*--------- добавить инф о редактируемом вызове ------------*/



        /*         * ********* Временные характеристики вызова ************* */
        $time_character_m = new Model_Rig();
        $data['time_character'] = $time_character_m->selectTimeCharacter($id);

        /*         * ********* КОНЕЦ Временные характеристики вызова ************* */


        /*         * ********* Журнал вызова - СиС МЧС ************* */
        $sily_m = new Model_Jrig();
        $data['sily'] = $sily_m->selectAllByIdRig($id);

        /*         * ********* КОНЕЦ Журнал вызова  - СиС МЧС************* */

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'rig/character/characterForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    // SAVE time character, journal of rigs
    $app->post('/:id/character', function ($id) use ($app,$log) {

        /*         * ********* Обработка POST-данных************* */
        $time_character_m = new Model_Rig();
        $post_character = $time_character_m->getPOSTTimeCharacter(); //врем характеристики вызова

        $jrig_m = new Model_Jrig();
        $post_jrig = $jrig_m->getPOSTData(); //журнал выезда

        /*         * ********* КОНЕЦ Обработка POST-данных ************* */



        /* -------- Прошла ли валидация ------- */
        if(!empty($post_jrig)){
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
         if(!empty($post_jrig)){
              $jrig_m->save($post_jrig); //журнал вызова
         }

        /* ---------------------------- КОНЕЦ Сохранить---------------------------- */
		$log_post_character=json_encode($post_character,JSON_UNESCAPED_UNICODE);
		$log_post_jrig=json_encode($post_jrig,JSON_UNESCAPED_UNICODE);
 $log->info('Сессия -  :: Сохранение ВРЕМЕННЫЕ ХАР-КИ ПО ВЫЕЗДУ - id_rig = ' . $id.' данные - : '.$log_post_character); //запись в logs
  $log->info('Сессия -  :: Сохранение ЖУРНАЛ ПО ВЫЕЗДУ - id_rig = ' . $id.' данные - : '.$log_post_jrig); //запись в logs
        $app->redirect(BASE_URL . '/rig');
    });


     //rigtable for rcu
     $app->get('/table/for_rcu/:id(/:id_rig)', function ($id,$id_rig=0) use ($app) {
        $bread_crumb = array('Все выезды');

        $data['id_page']=$id;//номер вклдаки

           $rig_m = new Model_Rigtable();

            $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

               /* -------------- Поиск вызова по введенному id ---------------- */
        if ($id_rig != 0) {
            $rig = search_rig_by_id($rig_m, $id_rig);
            $data['rig'] = $rig;
        }
        /* -------------- END Поиск вызова по введенному id ---------------- */
        elseif ($id_rig == 0) {//обычная таблица

            /* -------- таблица выездов в зависимости от авт пользователя -------- */

            if (!in_array($id, $cp)) {//выезды за области без ЦП
                $data['rig'] = $rig_m->selectAllByIdRegion($id, 0, 0); //без ЦП
            } else {//выезды за РОСН, УГЗ, АВиацию
                $data['rig'] = $rig_m->selectAllByIdOrgan($id, 0); //за весь орган
            }

            /* ----- КОНЕЦ таблица выездов в зависимости от авт пользователя --------- */
        }

                //-------- цвет статусов выездов ----------*/
          $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //цвет причин выездов
        $reasonrig_color=array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']]=$value['color'];
        }
        $data['reasonrig_color']=$reasonrig_color;
           /*-------- END цвет статусов выездов ----------*/


                              /* ------- select information on SiS MHS -------- */
        $id_rig_arr = array();
        foreach ($data['rig'] as $value) {//id of rigs
            $id_rig_arr[] = $value['id'];
        }
        $sily_m = new Model_Jrig();
        $sily_mchs = $sily_m->selectInvolvedUnits($id_rig_arr);        // in format mas[id_rig]=>array()
        $data['sily_mchs'] = $sily_mchs;
        /* ------- END select information on SiS MHS-------- */


        /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        //print_r($id_rig_empty_character);
        //exit();

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php');
        $data['active_tab'] = $id; //активная вклдака - id области
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


         // table for rcu - filter on dates
     $app->post('/table/for_rcu/:id(/:id_rig)', function ($id,$id_rig=0) use ($app) {
        $bread_crumb = array('Все выезды');
                $data['bread_crumb'] = $bread_crumb;


                        $data['id_page']=$id;//number of tabs

          /* ++++++ proccessing of POST-data ++++++++ */
        $rig_m = new Model_Rigtable();
        $post_date = $rig_m->getPOSTData(); //dates for filter
        //print_r($post_silymchs);
        //exit();
        /* +++++++++ END proccessing of POST-data +++++++++ */

        /* -------- validate is success------- */
        if (!empty($post_date['error'])) {
            $data['url_back']='rig';//back
            $error=$post_date['error'];
            unset($post_date['error']);
            show_error($error,NULL,$post_date,'/rig/rigTable/form_search.php');//view dates for repeat choose
            exit();
        }
        /* -------- END validate is success ------- */


                /*-------- color of reasonrig ----------*/
          $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //color of reasonrig
        $reasonrig_color=array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']]=$value['color'];
        }
        $data['reasonrig_color']=$reasonrig_color;
           /*-------- END color of reasonrig --------*/



        /* -------- rigtable according to session user -------- */

        $cp = array(8, 9, 12); //rosn, ugz,avia tabs


        if (!in_array($id, $cp)) {//rigs for regions without CP
            $data['rig'] = $rig_m->selectAllByIdRegion($id, 0, 0); //without CP
        }
        else{//rosn, ugz,avia rigs
             $data['rig'] = $rig_m->selectAllByIdOrgan($id, 0); //for all organ
        }
        /*----- END rigtable according to session user --------- */




                /* ------- select information on SiS MHS -------- */
        $id_rig_arr = array();
        foreach ($data['rig'] as $value) {//id of rigs
            $id_rig_arr[] = $value['id'];
        }
        $sily_m = new Model_Jrig();
        $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
        $data['sily_mchs'] = $sily_mchs;
        /* ------- END select information on SiS MHS-------- */

        /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        // print_r($sily_mchs);
        // exit();


        $app->render('layouts/header.php');
        $data['active_tab'] = $id; // active tab - id of region
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    //rigtable
    $app->get('(/:id_rig)', function ($id_rig = 0) use ($app) {
        $bread_crumb = array('Все выезды');
        $data['bread_crumb'] = $bread_crumb;

        $rig_m = new Model_Rigtable();

        /* -------------- Поиск вызова по введенному id ---------------- */
        if ($id_rig != 0) {

            $rig = search_rig_by_id($rig_m, $id_rig);
            foreach ($rig as $r) {
                $region = $r['id_region_user']; //кто создал
                $organ = $r['id_organ_user']; //кто создал
            }
            $data['rig'] = $rig;
        }
        /* -------------- END Поиск вызова по введенному id ---------------- */

                /*-------- цвет статусов выездов ----------*/
          $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //цвет причин выездов
        $reasonrig_color=array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']]=$value['color'];
        }
        $data['reasonrig_color']=$reasonrig_color;
           /*-------- END цвет статусов выездов ----------*/


        /* -------- таблица выездов в зависимости от авт пользователя -------- */

        if ($_SESSION['id_level'] == 3) {

            if ($id_rig == 0) {
                //выезды за ГРОЧС
                $data['rig'] = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС
            }
        } elseif ($_SESSION['id_level'] == 2) {

            if ($id_rig == 0) {

                if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                    $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0); //за весь орган
                } else {// UMCHS
                    $data['rig'] = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //выезды за всю область(не включая ЦП), не удаленные записи
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
                    $app->redirect(BASE_URL . '/rig/table/for_rcu/' . $i.'/'.$id_rig);
                } else {
                    // выезды за РБ
                    $app->redirect(BASE_URL . '/rig/table/for_rcu/1');
                }
            }
        }

        /* ----- КОНЕЦ таблица выездов в зависимости от авт пользователя --------- */


                              /* ------- select information on SiS MHS -------- */
$id_rig_arr=array();
                foreach ($data['rig'] as $value) {//id of rigs
                    $id_rig_arr[]=$value['id'];
                }
        $sily_m = new Model_Jrig();
        $sily_mchs = $sily_m->selectInvolvedUnits($id_rig_arr);        // in format mas[id_rig]=>array()
        $data['sily_mchs']=$sily_mchs;
        /* ------- END select information on SiS MHS-------- */


                        /* id of rigs, where silymschs/innerservice are not selected */
        $id_rig_empty_sily = R::getAll('SELECT id_rig FROM countsily WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ') AND'
            . ' id_rig not IN(select id_rig from countsily where id_rig IN(' . implode(',', $id_rig_arr) . ') AND c=?)', array(0,1));
        foreach ($id_rig_empty_sily as $value) {
             $data['id_rig_empty_sily'][] = $value['id_rig'];
        }
        /* END id of rigs, where silymschs/innerservice are not selected */


        /* id of rigs, where informing are not selected */
        $id_rig_empty_informing = R::getAll('SELECT id_rig FROM countinforming WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ')', array(0));
                foreach ($id_rig_empty_informing as $value) {
             $data['id_rig_empty_informing'][] = $value['id_rig'];
        }
        /* END id of rigs, where informing are not selected */

                        /* id of rigs, where time character are not selected */
        $id_rig_empty_character = R::getAll('SELECT id_rig FROM countcharacter WHERE  id_rig IN(' . implode(',', $id_rig_arr) . ')');
        foreach ($id_rig_empty_character as $value) {
            $data['id_rig_empty_character'][] = $value['id_rig'];
        }
        /* END id of rigs, where time character are not selected */

                /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    //rigtable - filter on dates
    $app->post('/table', function () use ($app) {
        $bread_crumb = array('Все выезды');
        $data['bread_crumb'] = $bread_crumb;

        /* ++++++ обработка POST-данных ++++++++ */
        $rig_m = new Model_Rigtable();
        $post_date = $rig_m->getPOSTData(); //даты для фильтра
        //print_r($post_silymchs);
        //exit();
        /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

        /* -------- Прошла ли валидация ------- */
        if (!empty($post_date['error'])) {
//            $data['url_back']='rig';
//            show_error($post_date['error'],$data['url_back']);
//            exit();

                $data['url_back']='rig';//куда вернуться
            $error=$post_date['error'];
            unset($post_date['error']);
            show_error($error,NULL,$post_date,'/rig/rigTable/form_search.php');//отобразить даты для повторного выбора
            exit();
        }
        /* -------- КОНЕЦ Прошла ли валидация ------- */

        /* -------- таблица выездов в зависимости от авт пользователя -------- */

        if ($_SESSION['id_level'] == 3) {
                //выезды за ГРОЧС
                 $data['rig'] = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС

        } elseif ($_SESSION['id_level'] == 2) {
            if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                 $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0); //за весь орган
            } else {// UMCHS
                $data['rig'] = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //rigs on region without CP, deleted rigs
            }
        } else {
            // выезды за РБ
              //for_rcu
        }

        /* ----- КОНЕЦ таблица выездов в зависимости от авт пользователя --------- */



                /*-------- цвет статусов выездов ----------*/
          $reasonrigcolor_m = new Model_Reasonrigcolor();
        $reasonrigcolor = $reasonrigcolor_m->selectAllByIdUser($_SESSION['id_user']); //цвет причин выездов
        $reasonrig_color=array();
        foreach ($reasonrigcolor as $value) {
            $reasonrig_color[$value['id_reasonrig']]=$value['color'];
        }
        $data['reasonrig_color']=$reasonrig_color;
           /*-------- END цвет статусов выездов ----------*/

                      /* ------- select information on SiS MHS -------- */

        $id_rig_arr=array();
                foreach ($data['rig'] as $value) {//id of rigs
                    $id_rig_arr[]=$value['id'];
                }
        $sily_m = new Model_Jrig();
        $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
        $data['sily_mchs']=$sily_mchs;
        /* ------- END select information on SiS MHS-------- */


                        /* id of rigs, where silymschs/innerservice are not selected */
        $id_rig_empty_sily = R::getAll('SELECT id_rig FROM countsily WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ') AND'
            . ' id_rig not IN(select id_rig from countsily where id_rig IN(' . implode(',', $id_rig_arr) . ') AND c=?)', array(0,1));
        foreach ($id_rig_empty_sily as $value) {
             $data['id_rig_empty_sily'][] = $value['id_rig'];
        }
        /* END id of rigs, where silymschs/innerservice are not selected */


        /* id of rigs, where informing are not selected */
        $id_rig_empty_informing = R::getAll('SELECT id_rig FROM countinforming WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ')', array(0));
                foreach ($id_rig_empty_informing as $value) {
             $data['id_rig_empty_informing'][] = $value['id_rig'];
        }
        /* END id of rigs, where informing are not selected */

                        /* id of rigs, where time character are not selected */
        $id_rig_empty_character = R::getAll('SELECT id_rig FROM countcharacter WHERE  id_rig IN(' . implode(',', $id_rig_arr) . ')');
        foreach ($id_rig_empty_character as $value) {
            $data['id_rig_empty_character'][] = $value['id_rig'];
        }
        /* END id of rigs, where time character are not selected */


                /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    // question with delete rig
    $app->get('/delete/:id', function ($id) use ($app) {
        $bread_crumb = array('Выезд', 'Удалить');


                                   /*--------- добавить инф о редактируемом вызове ------------*/
        if($id != 0){

           $rig_table_m=new Model_Rigtable();
           $inf_rig=$rig_table_m->selectByIdRig($id);// дата, время, адрес объекта для редактируемого вызова по id

            if(isset($inf_rig) && !empty($inf_rig)){
                foreach ($inf_rig as $value) {
                    $date_rig=$value['date_msg'].' '.$value['time_msg'];
                    $adr_rig=(empty($value['address'])) ? $value['additional_field_address']: $value['address'];
                }
                $bread_crumb[]=$date_rig;
                $bread_crumb[]=$adr_rig;
            }

        }
         /*--------- добавить инф о редактируемом вызове ------------*/

        $data['bread_crumb'] = $bread_crumb;

        $data['id'] = $id;
        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/questioOfDelete.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    //delete rig
    $app->delete('/:id', function ($id) use ($app,$log) {

        $rig = new Model_Rig();
        $rig->deleteRigById($id); // update is_delete=1

        $log->info('Сессия -  :: УДАЛЕНИЕ ВЫЕЗДА - id_rig = ' . $id.' выполнил '.$_SESSION['user_name']); //запись в logs
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
        $post_silymchs = $silymchs->getPOSTData(); //данные по силам МЧС
        //print_r($post_silymchs);
        //exit();
        /* -------- КОНЕЦ обработка POST-данных ---------- */


        /* ---------- сохранить вызов ----------- */

        if ($active_tab != 2) {
            $new_id = $rig->save($post_rig, $id); //id of rig
            $id = ($id == 0) ? $new_id : $id; //id of rig
        } else {//только вкладка "Техника"
            $new_id = $id;
            $id = $id;
        }

        /* ------- END сохранить вызов -------- */


        $region_of_rig = R::getCell('select id_region_user from rigtable where id = ?', array($id)); //id_region  of rig
        $organ_of_rig = R::getCell('select id_organ_user from rigtable where id = ?', array($id)); //id_organ of rig

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

/* ------------------------- END  rig ------------------------------- */



/* ------------------------- SEARCH rig by Id ------------------------------- */

$app->group('/search',  function () use ($app) {

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
$app->group('/news',  function () use ($app) {

    // show news
    $app->get('/', function () use ($app) {

        $data['title']='Новости';

     $bread_crumb = array('Новости');

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/header.php',$data);
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

            if ($bean == 'listmail'){

                $post['mail'] = $_POST['name']; //mail
                if($id==0 && isset($_POST['id_pasp']) && !empty($_POST['id_pasp'])){//create new
                     $post['id_pasp'] = $_POST['id_pasp'];
                }
            }
            else
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
        $log->info('Сессия -  :: УДАЛЕНИЕ записи из таблицы ' . $bean . '  - id = ' . $id.' выполнил '.$_SESSION['user_name']); //запись в logs
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
        }

        $bread_crumb = array('Классификаторы', $name_bean);
        $data['bread_crumb'] = $bread_crumb;

        $bean1 = strtolower($bean); //преобразовать строку в нижн регистр - название таблицы
        $data['classif_active'] = $bean1;

        $array_tables = array('reasonrig', 'firereason', 'service', 'officebelong','statusrig','destination','workview','listmail'); //перечень возможных классификаторов

        if (!in_array($bean1, $array_tables)) {
            $data['url_back'] = 'rig'; //куда вернуться
            $error = array('Такого классификатора не существует!');
            show_error($error, $data['url_back']);
            exit();
        }


        if($bean1=='destination'){
              /* ---------------------- Выборка данных -------------------- */
         $model = new Model_Destination();
        $data['list'] = $model->selectAll(); //выбор всех данных

        //должность - классификатор
        $data['position']=R::getAll('SELECT * FROM position');


        //звание - классификатор
        $data['rank']=R::getAll('SELECT * FROM rank');

        /* ---------------------- END Выборка данных -------------------- */
        }
        elseif($bean1=='listmail'){
              $model = new Model_Listmailview();
        $data['classif'] = $model->selectAll(); //выбор всех данных



                /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $locorg = new Model_Locorgview();
        $data['locorg'] = $locorg->selectAll(1); //выбрать все подразд кроме РЦУ, УМЧС(там нет техники)
        $pasp = new Model_Pasp();
        $data['pasp'] = $pasp->selectAll();


        }

        else{

                    /* ---------------------- Создать экземпляр класса Bean -------------------- */
        $model = new Model_Classificator($bean1);
        $data['classif'] = $model->selectAll(); //выбор всех данных
        /* ---------------------- END Создать экземпляр класса Bean -------------------- */



           if($bean1 == 'workview'){
                        $reasonrig_m = new Model_Reasonrig();
            $data['reasonrig'] = $reasonrig_m->selectAll(0); //все причины
        }


        }

        $app->render('layouts/header.php');
               if($bean1=='destination'){
                   $data['path_to_view'] = 'classif/destination/destinationTable.php';
               }
               elseif($bean1=='listmail'){

                   $data['path_to_view'] = 'classif/listmail/listmailTable.php';
               }
 else {
             $data['path_to_view'] = 'classif/classifTable.php';
 }

        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    })->conditions(array('bean' => '[a-z]{5,}'));


});


//классификатор информируемых лиц
$app->group('/destination', 'is_login', 'is_permis', function () use ($app, $log) {

    //добавление записи/редактирование
    $app->post('/post/:id', function ($id=0) use ($app, $log) {

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

        $post['fio']='ivan';

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

$app->group('/settings', 'is_login', 'is_permis', function () use ($app, $log) {

    //добавление записи
        $app->post('/reason_rig_color', function () use ($app) {

             /* ++++++ обработка POST-данных ++++++++ */
            if(isset($_POST['id_reasonrig']) && !empty($_POST['id_reasonrig'])){
                  $post['id_reasonrig'] = $_POST['id_reasonrig'];

        if(isset($_POST['color'])){
            $post['color'] = (empty($_POST['color'])) ? 'white' : $_POST['color'];
        }

        /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

        /*         * ********* сохранить  **************** */
        $status_m = new Model_Reasonrigcolor();
         $status_m->save_new_record($post); //сохранить

        /*         * ********* END сохранить  **************** */
            }


           $app->redirect(BASE_URL . '/settings/reason_rig_color' );

    });

      //ред записи
        $app->post('/reason_rig_color/:id', function ($id) use ($app) {

             /* ++++++ обработка POST-данных ++++++++ */
            if(isset($_POST['id_reasonrig']) && !empty($_POST['id_reasonrig'])){
                  $post['id_reasonrig'] = $_POST['id_reasonrig'];

        if(isset($_POST['color'])){
            $post['color'] = (empty($_POST['color'])) ? 'white' : $_POST['color'];
        }

        /* +++++++++ КОНЕЦ обработка POST-данных +++++++++ */

        /*         * ********* сохранить  **************** */
        $status_m = new Model_Reasonrigcolor();
         $status_m->edit($post,$id); //сохранить

        /*         * ********* END сохранить  **************** */
            }


         //  $app->redirect(BASE_URL . '/settings/status_rig_color' );

    });



    //удаление classif
    $app->delete('/reason_rig_color/:id', function ($id) use ($app, $log) {
       $status_m = new Model_Reasonrigcolor();
        $status_m->deleteById($id);
        $log->info('Сессия -  :: УДАЛЕНИЕ записи из таблицы reasonrigcolor  - id = ' . $id.' выполнил '.$_SESSION['user_name']); //запись в logs
    });

    //таблица
    $app->get('/reason_rig_color', function () use ($app) {


        $bread_crumb = array('Настройки', 'Цвет причины вызова');
        $data['bread_crumb'] = $bread_crumb;



              /* ---------------------- Выборка данных -------------------- */
         $model = new Model_Reasonrigcolor();
        $data['list'] = $model->selectAllDataByIdUser($_SESSION['id_user']); //выбор всех данных

        //статус выезда (НЕ УДАЛЕННЫЙ) - классификатор
        $data['statusrig']=R::getAll('SELECT id, name FROM reasonrig where is_delete <> ?',array(1));

        /* ---------------------- END Выборка данных -------------------- */


        $app->render('layouts/header.php');

             $data['path_to_view'] = 'settings/reason_rig_color.php';


        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


});


/* ------------------------- END   settings------------------------------- */




/* ------------------------- report ------------------------------- */

$app->group('/report', 'is_login', function () use ($app, $log) {

    // export to excel rep1
    $app->post('/rep1', function () use ($app, $log) {

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
        $id_local = (isset($_POST['id_local']) && !empty($_POST['id_local'])) ? intval($_POST['id_local']) : 0;//куда был выезд

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

        /* ------- КОНЕЦ Запрошенные область и район------ */



        /* ------------------- обработка POST-данных и получение результата по выезду ----------------- */
        $rig = new Model_Rigtable();
        $result = $rig->validateRep1(); //результат по вызову
        /* --------------КОНЕЦ обработка POST-данных  и получение результата по выезду -------------- */

        if(empty($result)){//нет вызовов
            // $app->redirect(BASE_URL . '/error');
            $arr[]='Нет данных для отображения!';
            show_error($arr);
             exit();
        }

        /* ------- все id вызовов, для которых надо выбрать остальные данные --------- */
        foreach ($result as $row) {
            $id_rig[] = $row['id'];
        }
        /* ------- КОНЕЦ все id вызовов, для которых надо выбрать остальные данные --------- */


        /* -------выбор инф по заявителю-------- */
        $p = new Model_People();
        $people = $p->selectAllInIdRig($id_rig);        // в формате mas[id_rig]=>array()
        /* -------КОНЕЦ выбор инф по заявителю-------- */


        /* -------выбор инф по СиС МЧС-------- */
        $sily_m = new Model_Jrig();
        $sily_mchs = $sily_m->selectAllInIdRig($id_rig);        // в формате mas[id_rig]=>array()
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

        /* ---------------------------------------------------- ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
     $objPHPExcel = new PHPExcel();
                    $objReader = PHPExcel_IOFactory::createReader("Excel2007");
                    $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/report/rep1.xlsx');

                    $objPHPExcel->setActiveSheetIndex(0);//activate worksheet number 1
                    $sheet = $objPHPExcel->getActiveSheet();

                    $r = 9;//начальная строка для записи
                    $c = 0;//начальный столбец для записи

                    $i=0;//счетчик кол-ва записей № п/п


                      $sheet->setCellValue('A2', 'с '.$d1.' по '.$d2);//выбранный период
                      $sheet->setCellValue('A3', 'область: '.$region_name.', район: '.$local_name);//выбранный область и район

                    foreach ($result as $row) {
            $i++;
            $id_r = $row['id']; //id of rig

 		if(isset($sily_mchs) && !empty($sily_mchs) && isset($sily_mchs[$id_r]))
			$a=count($sily_mchs[$id_r]);
		else
			$a=0;

				if(isset($inner) && !empty($inner) && isset($inner[$id_r]))
			$b=count($inner[$id_r]);
		else
			$b=0;

						if(isset($informing) && !empty($informing) && isset($informing[$id_r]))
			$c=count($informing[$id_r]);
		else
			$c=0;




            $count_str = $a + $b + $c ;  // сколько строк для одного выезда объединить

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

 /*------------------- данные по вызову --------------------------*/
            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['date_msg']);
            $sheet->setCellValue('C' . $r, $row['time_msg']);

            $sheet->setCellValue('E' . $r, $row['description']);


            $adr = ($row['address'] == NULL ) ? $row['additional_field_address'] : $row['address'];  /*   <!--                            если адрес пуст-выводим дополнит поле с адресом--> */
            $adr_region=($row['id_region'] == 3 && $row['id_local']==123  ) ? '' : ( ($row['id_region'] == 3) ? $row['region_name'].', ' : $row['region_name'].' обл., ');
            $local_arr=array(21,22,123,124,135,136,137,138,139,140,141);//id_local городов - им не надо слово район
             $adr_local=(in_array($row['id_local'] , $local_arr) || empty($row['id_local'])) ? '' : $row['local_name'].' район., ';

//                 if($row['id_local']==123){//г.Минск
//                     $adr_region='';
//                 }

            $sheet->setCellValue('F' . $r, $adr_region.$adr_local. $adr);

            $sheet->setCellValue('K' . $r, $row['time_loc']);
            $sheet->setCellValue('L' . $r, $row['time_likv']);
            $sheet->setCellValue('P' . $r, $row['inf_detail']);
            $sheet->setCellValue('Q' . $r, $row['view_work']);
             /*------------------- КОНЕЦ данные по вызову --------------------------*/

            /*------------------- данные по заявителю --------------------------*/
            $tel= ($people[$row['id']]['phone'] == NULL || empty($people[$row['id']]['phone']) ) ? '': ('тел. '.$people[$row['id']]['phone']);
          $sheet->setCellValue('D' . $r, $people[$row['id']]['fio'].chr(10).$tel.chr(10).$people[$row['id']]['address'].chr(10).$people[$row['id']]['position']);


           /* ------------------- данные по СиС МЧС -------------------------- */
            // Заполнение цветом
            $style_sily = array(
                'fill' => array(
                    'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
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
                                'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
                                'color' => array(
                                    'rgb' => 'ebf1de'
                                )
                            ),
                            'font' => array(
                                'strike' => TRUE//зачеркнутый текст
                            )
                        );
                        $sheet->getStyle('G' . $s)->applyFromArray($style_return_car);
                    }
                    else{
                        $sheet->getStyle('G' . $s)->applyFromArray($style_sily);
                    }

                    $sheet->setCellValue('G' . $s, $si['locorg_name'] . ', ' . $si['pasp_name'] . ', ' . $si['mark'] . ' ( гос. номер ' . $si['numbsign'] . ')');
                    $sheet->setCellValue('H' . $s, '-');
                    $sheet->setCellValue('I' . $s, $si['time_exit']);
                    $sheet->setCellValue('J' . $s, $si['time_arrival']);
                    $sheet->setCellValue('M' . $s, $si['time_end']);
                    $sheet->setCellValue('N' . $s, $si['time_return']);
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
                    'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
                    'color' => array(
                        'rgb' => 'dce6f1'
                    )
                )
            );
            if (!empty($inner[$id_r])) {
                foreach ($inner[$id_r] as $si) {
                    $sheet->setCellValue('G' . $s, $si['service_name']);
                    $sheet->setCellValue('H' . $s, $si['time_msg']);
                    $sheet->setCellValue('I' . $s, '-');
                    $sheet->setCellValue('J' . $s, $si['time_arrival']);
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
                    'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
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
                    $sheet->setCellValue('H' . $s, $si['time_msg']);
                    $sheet->setCellValue('I' . $s, $si['time_exit']);
                    $sheet->setCellValue('J' . $s, $si['time_arrival']);
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


            $r+= ($count_str != 0) ? $count_str : 1;
        }

                /* устанавливаем бордер ячейкам */
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$sheet->getStyleByColumnAndRow(0, 8, 16, $r-1)->applyFromArray($styleArray);

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

        $data['title']='Отчеты/Журнал';

        $bread_crumb = array('Отчеты', 'Журнал');
        $data['bread_crumb'] = $bread_crumb;

  /*         * *** Классификаторы **** */
        $region = new Model_Region();
        $data['region'] = $region->selectAll(); //области
        $local = new Model_Local();
        $data['local'] = $local->selectAll(); //районы

        /*         * *** КОНЕЦ Классификаторы **** */

        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'report/rep1/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
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
                if($row['id'] != 123){// кроме г.Минск
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

            $id_loc=($_POST['id_local']<0) ? 123 :$_POST['id_local'];

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
                if (isset($_POST['selected_locality']) && $_POST['selected_locality'] == $row['id'] || $_POST['id_region'] ==3 ) {//НА ФОРМЕ РЕД ВЫБРАНО ПО УМОЛЧАНИЮ
                    echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" selected value="' . $row['id'] . '">' . $row['name']  . '</option>';
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
                    if ($row['id'] == $local_of_locality && $local_of_locality!=123 ) {
                        echo '<option selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                    } elseif($row['id'] !=123) {
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
                echo '<option data-toggle="tooltip" data-placement="left"  title="' . $row['local_name'] . '" value="' . $row['id'] . '" >' . $row['name'] .  '</option>';
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
             $list_teh=array();

            /* cou or pasp */

            $id_divizion=R::getCell('select id_divizion FROM ss.records WHERE id = ?',array($_POST['id_pasp']));

             /* cou or pasp */

            /*-------------- technics - trip + from other divizion ----------------*/

            $today=  date("Y-m-d");//выбор техники из строевой на сегодняшн.сутки
            $yesterday=date("Y-m-d", time()-(60*60*24));
            //$today = '2018-03-28';

            if($id_divizion != 8){
                            /* pasp. take or not on duty */
            $is_duty=R::getCell('SELECT id FROM str.main WHERE id_card = ? AND dateduty = ? AND is_duty = ? ',array($_POST['id_pasp'],$today,1));
            }
            else{
                  /* cou. take or not on duty today */
            $is_duty=R::getCell('SELECT id FROM str.maincou WHERE id_card = ? AND dateduty = ? AND is_duty = ? ',array($_POST['id_pasp'],$today,1));

            }


            if(empty($is_duty)){// today is not taken on duty

                if($id_divizion != 8){
                            /* pasp. take or not on duty yesterday */
             $is_duty=R::getCell('SELECT id FROM str.main WHERE id_card = ? AND dateduty = ? AND is_duty = ? ',array($_POST['id_pasp'],$yesterday,1)); //Заступила ли ПАСЧ на дежурство вчера
            }
            else{
                  /* cou. take or not on duty yesterday */
            $is_duty=R::getCell('SELECT id FROM str.maincou WHERE id_card = ? AND dateduty = ? AND is_duty = ? ',array($_POST['id_pasp'],$yesterday,1));

            }



            if(empty($is_duty)){
                $list_teh=array();//list of technics is empty
            }
            else{
                $dateduty=$yesterday;
            }

            }
            else{// today is taken on duty
                $dateduty=$today;
            }
 $dateduty='2018-10-27';
            if (isset($dateduty)) {
                $list_teh = R::getAssoc("CALL `getListTeh`('{$_POST['id_pasp']}','{$dateduty}');");
            } else {
                $list_teh = array();
            }

            /*-------------- END technics - trip + from other divizion ----------------*/

            /*------------- техника данного ПАСЧ на выезде - пометить как (В) --------------------*/
            $teh_on_rig_m = new Model_Silymchs();
            $teh_on_rig = $teh_on_rig_m->selectAllOnRig();

            if (!empty($teh_on_rig)) {
                foreach ($teh_on_rig as $value) {
                    $on_rig[] = $value['id_teh'];
                }
            } else {
                $on_rig = array();
            }
             /*------------- END техника данного ПАСЧ на выезде - пометить как (В) --------------------*/

            /* ----------------- техника из др ПАСЧ - пометить как (К) ----------------- */
		 	 $on_reserve = array();
             if (isset($dateduty)) {
                $on_reserve = R::getAssoc("CALL `getReserveTeh`('{$_POST['id_pasp']}','{$dateduty}');");
            }

            /* ----------------- END техника из др ПАСЧ - пометить как (К) ----------------- */
/* &#155; - on rig;  */
			if (!empty($list_teh)) {
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
            }
            break;


                    /* ------------- авт отображение вида нас.пункта по нас.п. -------------- */
        case "showVidLocality":

            $locality_m = new Model_Locality();
            $vid = $locality_m->selectVidByIdLocality($_POST['id_locality']);

            if (!empty($vid)) {

                foreach ($vid as $row) {
                        echo  $row['name'] ;

                }
            }

            break;


                    /* ------------- функция формирует список вида работ в зависимости от выбранной причины выезда-------------- */
        case "showWorkviewByReasonrig":


            if($_POST['id_reasonrig'] == 0){//не выбрано причина выезда - доступны все виды работ

            $workview_m = new Model_Workview();
            $workview = $workview_m->selectAll();
            }
            else{//доступны только виды работ выбранной причины
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
              $id_reasonrig= $workview_m->selectIdReasonrig($_POST['id_workview']); //определяем причину выезда, к которой относится выбранный вид работ

            $reasonrig_m = new Model_Reasonrig();
            $reasonrig = $reasonrig_m->selectAll(0); //все причины

            if(!isset($_POST['id_workview']))
            echo '<option value="0">не выбрано</option>';

            foreach ($reasonrig as $row) {
                if ($row['id'] == $id_reasonrig) {
                    echo '<option selected value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                } else {
                    echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                }
            }
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



/*--------------- Путевка ----------------------*/

$app->group('/waybill', 'is_login', 'is_permis', function () use ($app) {

    //данные для путевки из БД
    function getData($id_rig) {

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
    }


          /* mail - форма рассылки
           * ok=0 default
           * ok=1 success send
           * ok=2 send with error */
$app->get('/mail/:id_rig(/:ok)', function ($id_rig,$ok=0) use ($app) {


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

             $list_mail_array=array();

        if(!empty($list_mail)){
            foreach ($list_mail as $value) {
                 $list_mail_array[$value['id_pasp']]['mail']=$value['mail'];
                  $list_mail_array[$value['id_pasp']]['is_delete']=$value['is_delete'];
            }

        }

        $data['list_mail_array'] = $list_mail_array;

        //Кому ранее отсылали путевку по этому выезду
        $mail_send_m = new Model_Mailsend();
        $mail_send = $mail_send_m->getAll($id_rig);

        $mail_send_array=array();

        if(!empty($mail_send)){
            foreach ($mail_send as $value) {
                 $mail_send_array[$value['id_pasp']]['id_rig']=$value['id_rig'];
                  $mail_send_array[$value['id_pasp']]['date_send']=$value['date_send'];
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

            $array=getData($id_rig);//данные для путевки из БД

$pdf = new tFPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVub','','DejaVuSansCondensed-Bold.ttf',true);
$pdf->SetFont('DejaVub','',14);
//$pdf->SetFont('Times','',14);

// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');

$pdf->Cell(0, 8, 'ПУТЕВКА № '.$id_rig, 0, 1, 'C', false);
$pdf->Cell(0, 5, 'для выезда дежурной смены подразделения', 0, 1, 'C', false);

$pdf->Ln( 10 );//отступ после заголовка

/* 1.Адрес  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'1.Адрес      ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['address'].$array['object']);

$pdf->Ln( 10 );//отступ после заголовка

/* 2.Цель выезда  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'2.Цель выезда      ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['purpose']);

$pdf->Ln( 10 );//отступ после заголовка

/* Время и дата получения сообщения */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'3.Время и дата получения сообщения     ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['hour']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  часов  ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['minutes']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  минут(ы)');

$pdf->Ln( 10 );//отступ после строки
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'«'.$array['day'].'»');
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  '.$array['name_month']);
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'  '.$array['year']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  г.');

$pdf->Ln( 10 );//отступ после строки

/* 4. Данные о заявителе  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'4. Данные о заявителе     ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['data_people']);


$pdf->Ln( 10 );//отступ после строки


/* Подпись дежурного диспетчера */

$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'Подпись дежурного диспетчера   ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'                                            ');


$f_pdf = mt_rand() . '_tmp.pdf';
$pdf->Output(__DIR__ . '/temp/' . $f_pdf,'F');//сохранить в папку

    /* ---------------------------------------------------- END ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */



     /*--- отправка на почту ---*/

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
    $mail->Body    = '<b>Путевка в прикрепленном файле!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

     $mail->addAddress('nata.deshchenya@mail.ru', 'Joe User');     // Add a recipient

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

    // exit();


     /*--- END отправка на почту --*/

});

      // pdf_print
$app->get('/pdf_print/:id_rig', function ($id_rig) use ($app) {

     $array=getData($id_rig);

    /* ---------------------------------------------------- ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

$pdf = new tFPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVub','','DejaVuSansCondensed-Bold.ttf',true);
$pdf->SetFont('DejaVub','',14);
//$pdf->SetFont('Times','',14);

// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');

$pdf->Cell(0, 8, 'ПУТЕВКА № '.$id_rig, 0, 1, 'C', false);
$pdf->Cell(0, 5, 'для выезда дежурной смены подразделения', 0, 1, 'C', false);

$pdf->Ln( 10 );//отступ после заголовка

/* 1.Адрес  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'1.Адрес      ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['address'].$array['object']);

$pdf->Ln( 10 );//отступ после заголовка

/* 2.Цель выезда  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'2.Цель выезда      ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['purpose']);

$pdf->Ln( 10 );//отступ после заголовка

/* Время и дата получения сообщения */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'3.Время и дата получения сообщения     ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['hour']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  часов  ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['minutes']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  минут(ы)');

$pdf->Ln( 10 );//отступ после строки
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'«'.$array['day'].'»');
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  '.$array['name_month']);
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'  '.$array['year']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  г.');

$pdf->Ln( 10 );//отступ после строки

/* 4. Данные о заявителе  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'4. Данные о заявителе     ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['data_people']);


$pdf->Ln( 10 );//отступ после строки


/* Подпись дежурного диспетчера */

$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'Подпись дежурного диспетчера   ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'                                            ');

$f = mt_rand() . '_tmp.pdf';
$pdf->Output(__DIR__ . '/temp/' . $f,'F');//сохранить в папку



    $content = file_get_contents(__DIR__ . '/temp/' . $f);

    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($content));
    header('Content-Disposition: inline; filename="YourFileName.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    die($content);

    //сохраняем на сервере для дальнейшей отправки на почту
     //$f = mt_rand() . '_tmp.xlsx';
     //$objWriter->save(__DIR__ . '/tmpl/tmpl' . $f);

    /* ---------------------------------------------------- END ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

     /*--- отправка на почту ---*/





     /*--- END отправка на почту --*/



});


      // pdf_download
$app->get('/pdf_download/:id_rig', function ($id_rig) use ($app) {

        $array=getData($id_rig);
    /* ---------------------------------------------------- ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */

$pdf = new tFPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVub','','DejaVuSansCondensed-Bold.ttf',true);
$pdf->SetFont('DejaVub','',14);
//$pdf->SetFont('Times','',14);

// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');

$pdf->Cell(0, 8, 'ПУТЕВКА № '.$id_rig, 0, 1, 'C', false);
$pdf->Cell(0, 5, 'для выезда дежурной смены подразделения', 0, 1, 'C', false);

$pdf->Ln( 10 );//отступ после заголовка

/* 1.Адрес  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'1.Адрес      ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['address'].$array['object']);

$pdf->Ln( 10 );//отступ после заголовка

/* 2.Цель выезда  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'2.Цель выезда      ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['purpose']);

$pdf->Ln( 10 );//отступ после заголовка

/* Время и дата получения сообщения */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'3.Время и дата получения сообщения     ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['hour']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  часов  ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['minutes']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  минут(ы)');

$pdf->Ln( 10 );//отступ после строки
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'«'.$array['day'].'»');
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  '.$array['name_month']);
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'  '.$array['year']);
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'  г.');

$pdf->Ln( 10 );//отступ после строки

/* 4. Данные о заявителе  */
$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'4. Данные о заявителе     ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,$array['data_people']);


$pdf->Ln( 10 );//отступ после строки


/* Подпись дежурного диспетчера */

$pdf->SetFont('DejaVu','',14);
$pdf->Write(8,'Подпись дежурного диспетчера   ');
$pdf->SetFont('DejaVu','U',14);
$pdf->Write(8,'                                            ');

$filename='putevka'.$id_rig.'.pdf';
$pdf->Output($filename,'D');

    /* ---------------------------------------------------- END ЭКСПОРТ в PDF ------------------------------------------------------------------------------ */


});

      // excel_download
$app->get('/excel_download/:id_rig', function ($id_rig) use ($app) {

    $array=getData($id_rig);


    /* ---------------------------------------------------- ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */
     $objPHPExcel = new PHPExcel();
    $objReader = PHPExcel_IOFactory::createReader("Excel2007");
    $objPHPExcel = $objReader->load(__DIR__ . '/tmpl/waybill/waybill.xlsx');

    $objPHPExcel->setActiveSheetIndex(0); //activate worksheet number 1
    $sheet = $objPHPExcel->getActiveSheet();

    $sheet->setCellValue('A1', 'ПУТЕВКА № '.$id_rig);

    $sheet->setCellValue('E4', $array['address'].$array['object']); //адрес
    $sheet->setCellValue('E5', $array['purpose']); //цель выезда
    $sheet->setCellValue('J6', $array['hour']); //часы
    $sheet->setCellValue('L6', $array['minutes']); //минуты
    $sheet->setCellValue('B7', $array['day']); //день
    $sheet->setCellValue('D7', $array['name_month']); //месяц
    $sheet->setCellValue('E7', $array['year']); //год
    $sheet->setCellValue('G8', $array['data_people']); //данные по заявителю



   // Сохранить в файл
    $filename='putevka'.$id_rig.'.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');


    //сохраняем на сервере для дальнейшей отправки на почту
    // $f_excel = mt_rand() . '_tmp.xlsx';
     //$objWriter->save(__DIR__ . '/temp/' . $f_excel);

    /* ---------------------------------------------------- END ЭКСПОРТ в EXCEL ------------------------------------------------------------------------------ */



});


});



/*--------------- КОНЕЦ  Путевка ----------------------*/


/* ------------------------- Logs ------------------------------- */

$app->group('/logs', 'is_login', 'is_permis', function () use ($app) {

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Логи', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Логи';


        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'logs/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->post('/', function () use ($app) {


        $bread_crumb = array('Логи', 'Просмотр');
        $data['bread_crumb'] = $bread_crumb;
        $data['title']='Логи';

        $date = (isset($_POST['date_start']) && !empty($_POST['date_start']) ) ? $_POST['date_start'] : date("Y-m-d");

        $filename = 'share/logs/development_' . $date . '.log';

        if (file_exists($filename)) {
            $data['file'] = file($filename);
        }


        $app->render('layouts/header.php',$data);
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
         $data['title']='Сохранить в json';


                 $archive_m = new Model_Archivedate();
    $data['archive_date'] = $archive_m->selectAll();//какие архивы уже сделаны
        $archive_year_m = new Model_Archiveyear();
        $data['archive_year']= $archive_year_m->selectAll();//какие года есть в БД






        $app->render('layouts/header.php',$data);
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

           $rig_m = new Model_Rigtable();//rig
           $rig = $rig_m->selectAllForJson(0,$d1,$d2);

           if(isset($rig) && !empty($rig)){
                         $json_val=array();
                         $id_rigs=array();

          foreach ($rig as $row) {
              $json=array();
              $json['id_rig']=$row['id'];
              $json['date_msg']=$row['date_msg'];
              $json['time_msg']=$row['time_msg'];
              $json['id_locorg']=$row['id_locorg'];//создатель
              $json['local_name']=$row['local_name'];
              $json['region_name']=$row['region_name'];
              $json['address']=$row['address'];
              $json['floor']=$row['floor'];
              $json['reasonrig_name']=$row['reasonrig_name'];
              $json['description']=$row['description'];
              $json['firereason_name']=$row['firereason_name'];
              $json['inspector']=$row['inspector'];
              $json['id_statusrig']=$row['id_statusrig'];
              $json['statusrig_name']=$row['statusrig_name'];
              $json['statusrig_color']=$row['statusrig_color'];
              $json['is_closed']=$row['is_closed'];
              $json['id_organ_user']=$row['id_organ_user'];//создатель
              $json['is_delete']=$row['is_delete'];
              $json['id_region_user']=$row['id_region_user'];//создатель
              $json['sub']=$row['sub'];
              $json['id_region']=$row['id_region'];//куда выезжали
              $json['id_local']=$row['id_local'];//куда выезжали
              $json['additional_field_address']=$row['additional_field_address'];
              $json['time_loc']=$row['time_loc'];
              $json['time_likv']=$row['time_likv'];
              $json['inf_detail']=$row['inf_detail'];
              $json['view_work']=$row['view_work'];
              $json['office_name']=$row['office_name'];
              $json['object']=$row['object'];
              $json['is_opg']=$row['is_opg'];
              $json['opg_text']=$row['opg_text'];


              $id_rigs[]=$json['id_rig'];

              array_push($json_val, $json);


          }


           //инф по привлекаемым СиС МЧС
            $jrig_m = new Model_Jrig();
            $silymchs = $jrig_m-> selectAllInIdRig($id_rigs);

         //   print_r($silymchs);

          if(!empty($silymchs)){
              foreach ($json_val as $key=> $row) {
                  if(isset($silymchs[$row['id_rig']]) ){//есть СиС МЧС по этому выезду
$json_val[$key]['silymchs']=$silymchs[$row['id_rig']];
                  }
              }
          }


          //инф о заявителе
               $people_m = new Model_People();
            $people = $people_m-> selectAllInIdRig($id_rigs);

                      if(!empty($people)){
              foreach ($json_val as $key=> $row) {
                  if(isset($people[$row['id_rig']]) ){//есть заявитель по этому выезду
$json_val[$key]['people']=$people[$row['id_rig']];
                  }
              }
          }


                    //инф о informing
               $informing_m = new Model_Informing();
            $informing = $informing_m-> selectAllInIdRig($id_rigs);

                      if(!empty($informing)){
              foreach ($json_val as $key=> $row) {
                  if(isset($informing[$row['id_rig']]) ){//есть informing по этому выезду
$json_val[$key]['informing']=$informing[$row['id_rig']];
                  }
              }
          }



                    //инф о innerservice - привлекаемые ведомства
               $innerservice_m = new Model_Innerservice();
            $innerservice = $innerservice_m-> selectAllInIdRig($id_rigs);

                      if(!empty($innerservice)){
              foreach ($json_val as $key=> $row) {
                  if(isset($innerservice[$row['id_rig']]) ){//есть innerservice по этому выезду
$json_val[$key]['innerservice']=$innerservice[$row['id_rig']];
                  }
              }
          }

          //print_r($json_val);
          //exit();

       /*  экспорт в json */
          $fp = fopen('tmpl/save_to_json/'.$d1.'_'.$d2.'.json', 'w');
fwrite($fp, json_encode($json_val, JSON_UNESCAPED_UNICODE));
fclose($fp);

 $data['msg']='Файл '.$d1.'_'.$d2.'.json успешно сформирован!';


                /*  записать этот диапазон в БД */
        $archive_m = new Model_Archivedate();
           $archive_m->save($d1,$d2);

         }
           else{
               $data['msg']='Нет данных!';
           }




                            $archive_m = new Model_Archivedate();
    $data['archive_date'] = $archive_m->selectAll();//какие архивы уже сделаны
        $archive_year_m = new Model_Archiveyear();
        $data['archive_year']= $archive_year_m->selectAll();//какие года есть в БД


  $bread_crumb = array('Сохранить в json', 'Выбор диапазона дат');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Сохранить в json';


        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'save_to_json/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');


});

});


/* ------------------------- END  Save to json ------------------------------- */



/* ------------------------- Archive Журнал ЦОУ ------------------------------- */

$app->group('/archive', function () use ($app) {

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Архив', 'Параметры');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Журнал ЦОУ. Архив';



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


   $isset_date = $archive_m->selectAll();//какие архивы уже сделаны
    $isset_year = $archive_year_m->selectAll();//какие года есть в БД


        $app->render('layouts/archive/header.php',$data);
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

if(isset($array_of_content_file_json)&& !empty($array_of_content_file_json)){
    $data['result']=$array_of_content_file_json;
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


/* ------------------------- END  Archive Журнал ЦОУ ------------------------------- */




/* ------------------------- diagram ------------------------------- */

$app->group('/diagram', 'is_login', function () use ($app, $log) {


    $app->get('/diag1', function () use ($app) {

        $data['title']='Диаграммы/Диаграмма1';

        $bread_crumb = array('Диаграммы', 'Диаграмма1');
        $data['bread_crumb'] = $bread_crumb;

  /*         * *** Данные **** */
        $x=0;//всего
                $y=34;//причины выезда - пожар


        $umchs_vsego = R::getAssoc("CALL `diag1_umchs`('{$x}');");   //всего
        $data['umchs_vsego'] = $umchs_vsego; //всего по областям


        $umchs_fair = R::getAssoc("CALL `diag1_umchs`('{$y}');");//пожары
        $data['umchs_fair'] = $umchs_fair;


        //РОСН,УГЗ, АВИАЦИЯ
        $cp_vsego = R::getAssoc("CALL `diag1_cp`('{$x}');");//всего
        $data['cp_vsego'] = $cp_vsego; //всего по областям

        $cp_fair = R::getAssoc("CALL `diag1_cp`('{$y}');");//пожары
        $data['cp_fair'] = $cp_fair;


        /*         * *** КОНЕЦ Данные **** */

        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'diagram/diag1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

/* ------------------------- END diagram ------------------------------- */



$app->run();
