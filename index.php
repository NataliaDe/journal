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
use Dompdf\Dompdf;

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
use App\MODELS\Model_Actionwaybill;//meri dly putevki
use App\MODELS\Model_Loglogin;
use App\MODELS\Model_Logs;

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
        elseif (strpos($app->request->getResourceUri(), 'archive_1')) {

            /* only rcu or umchs */
            $arr_organ=array(4,5);
            $arr_level=array(1,2);
                if (in_array($_SESSION['id_level'], $arr_level) && in_array($_SESSION['id_organ'], $arr_organ)) {

                }
                else{
                    $app->redirect(BASE_URL . '/no_permission');
                }


    }
            elseif (strpos($app->request->getResourceUri(), 'archive')) {

        /* only rcu admin */

        if ($_SESSION['id_user'] != 2) {
            $app->redirect(BASE_URL . '/no_permission');
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


                /* save log to bd */
                $arr = array('user_id' => $_SESSION['id_user'], 'user_name' => $_SESSION['user_name'], 'region_name' => $_SESSION['region_name'], 'locorg_name' => $_SESSION['locorg_name']);
                $loglogin = new Model_Loglogin();
                $loglogin->save($arr,1);


                 if(isset($_SESSION['id_ghost']))
                    unset($_SESSION['id_ghost']);


                $app->redirect(BASE_URL . '/rig');
            } else {
                $app->redirect(BASE_URL . '/login');
            }
        } else {
            $app->redirect(BASE_URL . '/login');                /* save log to bd */
                $arr = array('user_id' => $_SESSION['id_user'], 'user_name' => $_SESSION['user_name'], 'region_name' => $_SESSION['region_name'], 'locorg_name' => $_SESSION['locorg_name']);
                $loglogin = new Model_Loglogin();
                $loglogin->save($arr,0);
        }
    });
});

//logout
$app->get('/logout', function () use ($app, $log) {

     $array = array('time' => date("Y-m-d H:i:s"), 'ip-address' => $_SERVER['REMOTE_ADDR'], 'login' => $_SESSION['login'], 'password' => $_SESSION['password'], 'user_name' => $_SESSION['user_name']);
    $log_array = json_encode($array, JSON_UNESCAPED_UNICODE);
    $log->info('Сессия -  :: Выход пользователя с - id = ' . $_SESSION['id_user'] .' выполнил '.$_SESSION['user_name'].' данные - : ' . $log_array); //запись в logs

                /* save log to bd */
                $arr = array('user_id' => $_SESSION['id_user'], 'user_name' => $_SESSION['user_name'], 'region_name' => $_SESSION['region_name'], 'locorg_name' => $_SESSION['locorg_name']);
                $loglogin = new Model_Loglogin();
                $loglogin->save($arr,0);

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

        $data['settings_user'] = getSettingsUser();

        $cp = array(8, 9, 12);

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

            $rig_table_m = new Model_Rigtable();
            $inf_rig = $rig_table_m->selectByIdRig($id); // дата, время, адрес объекта для редактируемого вызова по id
            // инф по вызову
            $rig_m = new Model_Rig();
            $rig = $rig_m->selectAllById($id);
            $data['is_sily_mchs']=$rig['is_sily_mchs'];

            if ($active_tab != 2) {

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
                $data['podr'] = R::getAll('select g.*, r.locorg_name, r.pasp_name as pasp_name_1, concat(r.pasp_name,", ",r.locorg_name,", ",r.region_name) as pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp  ');
            } elseif ($_SESSION['id_level'] == 3 && !in_array($_SESSION['id_organ'], $cp)) {//rochs
                $data['podr'] = R::getAll('select g.*, r.locorg_name, r.pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp where r.id_loc_org = ? ', array($_SESSION['id_locorg']));
            } elseif ($_SESSION['id_level'] == 3 && in_array($_SESSION['id_organ'], $cp)) {//rosn pinsk
                $data['podr'] = R::getAll('select g.*, r.locorg_name, r.pasp_name  from guidepasp as g left join pasp as r on r.id=g.id_pasp  where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
            } elseif ($_SESSION['id_level'] == 2 && in_array($_SESSION['id_organ'], $cp)) {//rosn, ugz,avia - all g. Minsk
                $data['podr'] = R::getAll('select g.*, r.locorg_name, r.pasp_name  from guidepasp as g left join pasp as r on r.id=g.id_pasp  where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_loc_org = ? and id_organ = ?', array($_SESSION['id_locorg'], $_SESSION['id_organ']));
            } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] == 3) {//umchs g.Minsk
                $data['podr'] = R::getAll('select g.*, r.locorg_name, r.pasp_name as pasp_name_1, concat(r.pasp_name,", ",r.locorg_name) as pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp  where r.id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array(3));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array(3));
            } elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] != 3) {//umchs
                $data['podr'] = R::getAll('select g.*, r.locorg_name, r.pasp_name as pasp_name_1, concat(r.pasp_name,", ",r.locorg_name) as pasp_name from guidepasp as g left join pasp as r on r.id=g.id_pasp  where r.id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array($_SESSION['id_region']));
                // $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array(3));
            }
        }
        //print_r($data['podr']);exit();

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

        $data['settings_user'] = getSettingsUser();


           $rig_table_m=new Model_Rigtable();
           $inf_rig=$rig_table_m->selectByIdRig($id);// дата, время, адрес объекта для редактируемого вызова по id

                   /*--------- добавить инф о редактируемом вызове ------------*/
        if($id != 0){


            if(isset($inf_rig) && !empty($inf_rig)){
                foreach ($inf_rig as $value) {
                    $date_rig=$value['date_msg'].' '.$value['time_msg'];
                    $adr_rig=(empty($value['address'])) ? $value['additional_field_address']: $value['address'];

                     $data['id_user']=$value['id_user'];
                }
                $bread_crumb[]=$date_rig;
                $bread_crumb[]=$adr_rig;
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
       // print_r($_POST);exit();
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

        $app->redirect(BASE_URL . '/rig');
    });


    // form time character, journal of rigs
    $app->get('/:id/character', function ($id) use ($app) {

        $bread_crumb = array('Временные характеристики выезда');

        $data['title']='Временные характеристики выезда';
        $data['id'] = $id;

        $data['settings_user'] = getSettingsUser();


           $rig_table_m=new Model_Rigtable();
           $inf_rig=$rig_table_m->selectByIdRig($id);// дата, время, адрес объекта для редактируемого вызова по id

                           /*--------- добавить инф о редактируемом вызове ------------*/
        if($id != 0){


            if(isset($inf_rig) && !empty($inf_rig)){
                foreach ($inf_rig as $value) {
                    $date_rig=$value['date_msg'].' '.$value['time_msg'];
                    $adr_rig=(empty($value['address'])) ? $value['additional_field_address']: $value['address'];

                    $data['id_user']=$value['id_user'];

                    $data['id_reasonrig']=$value['id_reasonrig'];
                }
                $bread_crumb[]=$date_rig;
                $bread_crumb[]=$adr_rig;
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


        /* is updeting now ?  */
        if ($id != 0) {//edit
            unset_update_rig_now($id);
        }

        /* ---------------------------- КОНЕЦ Сохранить---------------------------- */
		$log_post_character=json_encode($post_character,JSON_UNESCAPED_UNICODE);
		$log_post_jrig=json_encode($post_jrig,JSON_UNESCAPED_UNICODE);
 $log->info('Сессия -  :: Сохранение ВРЕМЕННЫЕ ХАР-КИ ПО ВЫЕЗДУ - id_rig = ' . $id.' данные - : '.$log_post_character); //запись в logs
  $log->info('Сессия -  :: Сохранение ЖУРНАЛ ПО ВЫЕЗДУ - id_rig = ' . $id.' данные - : '.$log_post_jrig); //запись в logs



                            /* save log to bd */
        $action = 'редактирование временных характеристик по выезду, журнала выезда';
        $arr = array('s_user_id' => $_SESSION['id_user'], 's_user_name' => $_SESSION['user_name'], 's_region_name' => $_SESSION['region_name'], 's_locorg_name' => $_SESSION['locorg_name'], 'id_rig' => $id, 'action' => $action);
        $logg = new Model_Logs();
        $logg->save($arr);


        $app->redirect(BASE_URL . '/rig');
    });


     //rigtable for rcu
     $app->get('/table/for_rcu/:id(/:id_rig)', function ($id,$id_rig=0) use ($app) {
        $bread_crumb = array('Все выезды');

        $data['id_page']=$id;//номер вклдаки

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();

           $rig_m = new Model_Rigtable();

            $cp = array(8, 9, 12); //вкладки РОСН, УГЗ,Авиация

               /* -------------- Поиск вызова по введенному id ---------------- */
        if ($id_rig != 0) {
            $rig = search_rig_by_id($rig_m, $id_rig);
            $data['rig'] = $rig;

            $data['search_rig_by_id']=1;

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
        $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
        $data['sily_mchs'] = $sily_mchs;


        /* --- for table type 2 ---- */

        $res=getSilyForType2($sily_mchs);
        $data['teh_mark'] = $res['teh_mark'];
        $data['exit_time'] = $res['exit_time'];
        $data['arrival_time'] = $res['arrival_time'];
        $data['follow_time'] = $res['follow_time'];
        $data['end_time'] =  $res['end_time'];
        $data['return_time'] = $res['return_time'];
        $data['distance'] = $res['distance'] ;

         /* --- END for table type 2 ---- */
        /* ------- END select information on SiS MHS-------- */


        /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        if(!empty($id_rig_arr)){
        $informing_m = new Model_Informing();
        $ids_rig_not_full_info= $informing_m->getNotFullInfo($id_rig_arr);
        foreach ($ids_rig_not_full_info as $value) {
            $data['not_full_info'][] =$value['id_rig'];
        }


         $sily_mchs_m = new Model_Silymchs();
        $ids_rig_not_full_sily= $sily_mchs_m->getNotFullSily($id_rig_arr);
        foreach ($ids_rig_not_full_sily as $value) {
            $data['not_full_sily'][] =$value['id_rig'];
        }
        }

        // empty fields
        $data['rig']=getEmptyFields($data['rig']);

        /* is updeting now ?  */
        foreach ($data['rig'] as $k=>$r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();


        }
         /* is updeting now ?  */


         $data['rig']=getResultsBattle($data['rig']);//results battle



         $data['trunk_by_rig']=getTrunkByRigs($id_rig_arr);

         /*  mode  */
        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {

            $del_val = $data['settings_user_br_table'];
            $data['rig'] = array_filter($data['rig'], function($e) use ($del_val) {
                // return (in_array($e['id_reasonrig'], $del_val));
                if (in_array($e['id_reasonrig'], $del_val)) {
                    return true;
                }
                return false;
            });
        }

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

                        $data['settings_user'] = getSettingsUser();
                        $data['settings_user_br_table'] = getSettingsUserMode();

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



        /* --- for table type 2 ---- */
        $teh_mark=array();
        $exit_time=array();
        $arrival_time=array();
        $follow_time=array();
        $end_time=array();
        $return_time=array();
        $distance=array();

        foreach ($sily_mchs as $id_rig=>$row) {

            foreach ($row as $si) {
         //$teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b> - '.$si['locorg_name'].', '.$si['pasp_name'];
         $teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b>, '.$si['pasp_name'];
         $exit_time[$id_rig][]=(isset($si['time_exit']) && !empty($si['time_exit'])) ? date('H:i', strtotime($si['time_exit'])) : '-';
         $arrival_time[$id_rig][]=(isset($si['time_arrival']) && !empty($si['time_arrival'])) ? date('H:i', strtotime($si['time_arrival'])) : '-';
         $follow_time[$id_rig][]=(isset($si['time_follow']) && !empty($si['time_follow'])) ? date('H:i', strtotime($si['time_follow'])) : '-';
         $end_time[$id_rig][]=(isset($si['time_end']) && !empty($si['time_end'])) ? date('H:i:s', strtotime($si['time_end'])) : '-';
         $return_time[$id_rig][]=(isset($si['time_return']) && !empty($si['time_return'])) ? date('H:i', strtotime($si['time_return'])) : '-';
         $distance[$id_rig][]=(isset($si['distance']) && !empty($si['distance'])) ? $si['distance'] : '-';
            }

        }

        $data['teh_mark'] = $teh_mark;
        $data['exit_time'] = $exit_time;
        $data['arrival_time'] = $arrival_time;
        $data['follow_time'] = $follow_time;
        $data['end_time'] = $end_time;
        $data['return_time'] = $return_time;
        $data['distance'] = $distance;

         /* --- END for table type 2 ---- */

        // print_r($teh_mark);exit();

        /* for table type 2 */


        /* ------- END select information on SiS MHS-------- */

        /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        if(!empty($id_rig_arr)){
        $informing_m = new Model_Informing();
        $ids_rig_not_full_info= $informing_m->getNotFullInfo($id_rig_arr);
        foreach ($ids_rig_not_full_info as $value) {
            $data['not_full_info'][] =$value['id_rig'];
        }


        $sily_mchs_m = new Model_Silymchs();
        $ids_rig_not_full_sily= $sily_mchs_m->getNotFullSily($id_rig_arr);
        foreach ($ids_rig_not_full_sily as $value) {
            $data['not_full_sily'][] =$value['id_rig'];
        }
        }
        // print_r($sily_mchs);
        // exit();

        // empty fields
        $data['rig']=getEmptyFields($data['rig']);

         /* is updeting now ?  */
        foreach ($data['rig'] as $k=>$r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();


        }
         /* is updeting now ?  */


         $data['rig']=getResultsBattle($data['rig']);//results battle
         //print_r($data['settings_user_br_table']);exit();
         //echo $_SESSION['br_table_mode'];exit();

         $data['trunk_by_rig']=getTrunkByRigs($id_rig_arr);

         /* mode */
        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {

            $del_val = $data['settings_user_br_table'];
            $data['rig'] = array_filter($data['rig'], function($e) use ($del_val) {
                // return (in_array($e['id_reasonrig'], $del_val));
                if (in_array($e['id_reasonrig'], $del_val)) {
                    return true;
                }
                return false;
            });
        }

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

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();

        $rig_m = new Model_Rigtable();

        /* -------------- Поиск вызова по введенному id ---------------- */
        if ($id_rig != 0) {

            $rig = search_rig_by_id($rig_m, $id_rig);
            foreach ($rig as $r) {
                $region = $r['id_region_user']; //кто создал
                $organ = $r['id_organ_user']; //кто создал
            }
            $data['rig'] = $rig;

            $data['search_rig_by_id']=1;
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
            //    $data['rig'] = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС
            //    $data['rig_neighbor'] = $rig_m->selectIdRigByIdGrochs(0,$_SESSION['id_locorg']); //за ГРОЧС
               // print_r($data['rig_neighbor']);exit();
            $rig = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС
                if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {//type1
                    $rig_neighbor_id = $rig_m->selectIdRigByIdGrochs(0, $_SESSION['id_locorg']); //за ГРОЧС
                    $rig_neighbor = $rig_m->selectAllByIdLocorgNeighbor($rig_neighbor_id);
                    $data['rig'] = array_merge($rig, $rig_neighbor);
                } else {
                    $data['rig'] = $rig;
                }
            }
        } elseif ($_SESSION['id_level'] == 2) {

            if ($id_rig == 0) {

                if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                    $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0); //за весь орган
                } else {// UMCHS
                    //$data['rig'] = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //выезды за всю область(не включая ЦП), не удаленные записи
                    $rig = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //выезды за всю область(не включая ЦП), не удаленные записи

                    if (isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes') {
                    $rig_neighbor_id = $rig_m->selectIdRigByIdRegion(0, $_SESSION['id_region']); //за ГРОЧС
                    $rig_neighbor = $rig_m->selectAllByIdRegionNeighbor($rig_neighbor_id);
                    $data['rig'] = array_merge($rig,$rig_neighbor);
                    }
                    else{
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
        $sily_mchs = $sily_m->selectAllInIdRig($id_rig_arr);        // in format mas[id_rig]=>array()
        $data['sily_mchs']=$sily_mchs;




        /* --- for table type 2 ---- */
        $teh_mark=array();
        $exit_time=array();
        $arrival_time=array();
        $follow_time=array();
        $end_time=array();
        $return_time=array();
        $distance=array();

        foreach ($sily_mchs as $id_rig=>$row) {

            foreach ($row as $si) {
         //$teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b> - '.$si['locorg_name'].', '.$si['pasp_name'];
         $teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b>, '.$si['pasp_name'];
         $exit_time[$id_rig][]=(isset($si['time_exit']) && !empty($si['time_exit'])) ? date('H:i', strtotime($si['time_exit'])) : '-';
         $arrival_time[$id_rig][]=(isset($si['time_arrival']) && !empty($si['time_arrival'])) ? date('H:i', strtotime($si['time_arrival'])) : '-';
         $follow_time[$id_rig][]=(isset($si['time_follow']) && !empty($si['time_follow'])) ? date('H:i', strtotime($si['time_follow'])) : '-';
         $end_time[$id_rig][]=(isset($si['time_end']) && !empty($si['time_end'])) ? date('H:i', strtotime($si['time_end'])) : '-';
         $return_time[$id_rig][]=(isset($si['time_return']) && !empty($si['time_return'])) ? date('H:i', strtotime($si['time_return'])) : '-';
         $distance[$id_rig][]=(isset($si['distance']) && !empty($si['distance'])) ? $si['distance'] : '-';
            }

        }

        $data['teh_mark'] = $teh_mark;
        $data['exit_time'] = $exit_time;
        $data['arrival_time'] = $arrival_time;
        $data['follow_time'] = $follow_time;
        $data['end_time'] = $end_time;
        $data['return_time'] = $return_time;
        $data['distance'] = $distance;

         /* --- END for table type 2 ---- */
        /* ------- END select information on SiS MHS-------- */


                        /* id of rigs, where silymschs/innerservice are not selected */
      /*  $id_rig_empty_sily = R::getAll('SELECT id_rig FROM countsily WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ') AND'
            . ' id_rig not IN(select id_rig from countsily where id_rig IN(' . implode(',', $id_rig_arr) . ') AND c=?)', array(0,1));
        foreach ($id_rig_empty_sily as $value) {
             $data['id_rig_empty_sily'][] = $value['id_rig'];
        }*/
        /* END id of rigs, where silymschs/innerservice are not selected */


        /* id of rigs, where informing are not selected */
       /* $id_rig_empty_informing = R::getAll('SELECT id_rig FROM countinforming WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ')', array(0));
                foreach ($id_rig_empty_informing as $value) {
             $data['id_rig_empty_informing'][] = $value['id_rig'];
        }*/
        /* END id of rigs, where informing are not selected */

                        /* id of rigs, where time character are not selected */
      /*  $id_rig_empty_character = R::getAll('SELECT id_rig FROM countcharacter WHERE  id_rig IN(' . implode(',', $id_rig_arr) . ')');
        foreach ($id_rig_empty_character as $value) {
            $data['id_rig_empty_character'][] = $value['id_rig'];
        }*/
        /* END id of rigs, where time character are not selected */

                /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */

        if(!empty($id_rig_arr)){
        $informing_m = new Model_Informing();
        $ids_rig_not_full_info= $informing_m->getNotFullInfo($id_rig_arr);
        foreach ($ids_rig_not_full_info as $value) {
            $data['not_full_info'][] =$value['id_rig'];
        }


        $sily_mchs_m = new Model_Silymchs();
        $ids_rig_not_full_sily= $sily_mchs_m->getNotFullSily($id_rig_arr);
        foreach ($ids_rig_not_full_sily as $value) {
            $data['not_full_sily'][] =$value['id_rig'];
        }
        }
                // empty fields
        $data['rig']=getEmptyFields($data['rig']);


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


        $data['rig']=getResultsBattle($data['rig']);//results battle

        $data['trunk_by_rig']=getTrunkByRigs($id_rig_arr);

        /* mode */
        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {

            $del_val = $data['settings_user_br_table'];
            $data['rig'] = array_filter($data['rig'], function($e) use ($del_val) {
                // return (in_array($e['id_reasonrig'], $del_val));
                if (in_array($e['id_reasonrig'], $del_val)) {
                    return true;
                }
                return false;
            });
        }

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'rig/rigTable.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    //rigtable - filter on dates
    $app->post('/table', function () use ($app) {
        $bread_crumb = array('Все выезды');
        $data['bread_crumb'] = $bread_crumb;

        $data['settings_user'] = getSettingsUser();
        $data['settings_user_br_table'] = getSettingsUserMode();

       // echo $_SESSION['id_locorg'];
       // print_r($_POST);exit();
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


        //print_r($data['settings_user']);exit();

        /* -------- таблица выездов в зависимости от авт пользователя -------- */

        if ($_SESSION['id_level'] == 3) {

                //выезды за ГРОЧС
           // $data['rig'] = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС
            $rig = $rig_m->selectAllByIdLocorg($_SESSION['id_locorg'], 0); //за ГРОЧС

            if(isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes'){//type1


            $rig_neighbor_id = $rig_m->selectIdRigByIdGrochs(0, $_SESSION['id_locorg']); //за ГРОЧС
            $rig_neighbor = $rig_m->selectAllByIdLocorgNeighbor($rig_neighbor_id);
            $data['rig'] = array_merge($rig,$rig_neighbor);
            }
            else{
                $data['rig'] = $rig;
            }

            //print_r($rig_neighbor);
          //  print_r($data['rig']);
          //  exit();
        } elseif ($_SESSION['id_level'] == 2) {
            if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                 $data['rig'] = $rig_m->selectAllByIdOrgan($_SESSION['id_organ'], 0); //за весь орган
            } else {// UMCHS
               // $data['rig'] = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //rigs on region without CP, deleted rigs

                $rig = $rig_m->selectAllByIdRegion($_SESSION['id_region'], 0, 0); //rigs on region without CP, deleted rigs

                if(isset($data['settings_user']['neighbor_rigs']) && $data['settings_user']['neighbor_rigs']['name_sign'] == 'yes'){//type1
                $rig_neighbor_id = $rig_m->selectIdRigByIdRegion(0, $_SESSION['id_region']); //за ГРОЧС
                $rig_neighbor = $rig_m->selectAllByIdRegionNeighbor($rig_neighbor_id);
                //print_r($rig_neighbor);exit();
                $data['rig'] = array_merge($rig,$rig_neighbor);
                }
                else{
                   $data['rig'] = $rig;
                }
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


        /* --- for table type 2 ---- */
        $teh_mark=array();
        $exit_time=array();
        $arrival_time=array();
        $follow_time=array();
        $end_time=array();
        $return_time=array();
        $distance=array();

        foreach ($sily_mchs as $id_rig=>$row) {

            foreach ($row as $si) {
         //$teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b> - '.$si['locorg_name'].', '.$si['pasp_name'];
         $teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b>, '.$si['pasp_name'];
         $exit_time[$id_rig][]=(isset($si['time_exit']) && !empty($si['time_exit'])) ? date('H:i', strtotime($si['time_exit'])) : '-';
         $arrival_time[$id_rig][]=(isset($si['time_arrival']) && !empty($si['time_arrival'])) ? date('H:i', strtotime($si['time_arrival'])) : '-';
         $follow_time[$id_rig][]=(isset($si['time_follow']) && !empty($si['time_follow'])) ? date('H:i', strtotime($si['time_follow'])) : '-';
         $end_time[$id_rig][]=(isset($si['time_end']) && !empty($si['time_end'])) ? date('H:i:s', strtotime($si['time_end'])) : '-';
         $return_time[$id_rig][]=(isset($si['time_return']) && !empty($si['time_return'])) ? date('H:i', strtotime($si['time_return'])) : '-';
         $distance[$id_rig][]=(isset($si['distance']) && !empty($si['distance'])) ? $si['distance'] : '-';
            }

        }

        $data['teh_mark'] = $teh_mark;
        $data['exit_time'] = $exit_time;
        $data['arrival_time'] = $arrival_time;
        $data['follow_time'] = $follow_time;
        $data['end_time'] = $end_time;
        $data['return_time'] = $return_time;
        $data['distance'] = $distance;

         /* --- END for table type 2 ---- */
        /* ------- END select information on SiS MHS-------- */


                        /* id of rigs, where silymschs/innerservice are not selected */
       /* $id_rig_empty_sily = R::getAll('SELECT id_rig FROM countsily WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ') AND'
            . ' id_rig not IN(select id_rig from countsily where id_rig IN(' . implode(',', $id_rig_arr) . ') AND c=?)', array(0,1));
        foreach ($id_rig_empty_sily as $value) {
             $data['id_rig_empty_sily'][] = $value['id_rig'];
        }*/
        /* END id of rigs, where silymschs/innerservice are not selected */


        /* id of rigs, where informing are not selected */
      /*  $id_rig_empty_informing = R::getAll('SELECT id_rig FROM countinforming WHERE c=? AND id_rig IN(' . implode(',', $id_rig_arr) . ')', array(0));
                foreach ($id_rig_empty_informing as $value) {
             $data['id_rig_empty_informing'][] = $value['id_rig'];
        }*/
        /* END id of rigs, where informing are not selected */

                        /* id of rigs, where time character are not selected */
       /* $id_rig_empty_character = R::getAll('SELECT id_rig FROM countcharacter WHERE  id_rig IN(' . implode(',', $id_rig_arr) . ')');
        foreach ($id_rig_empty_character as $value) {
            $data['id_rig_empty_character'][] = $value['id_rig'];
        }*/
        /* END id of rigs, where time character are not selected */


                /* fill or no icons */
        $data['result_icons'] = empty_icons($id_rig_arr);
        /* END fill or no icons */


if(!empty($id_rig_arr)){
        $informing_m = new Model_Informing();
        $ids_rig_not_full_info= $informing_m->getNotFullInfo($id_rig_arr);
        foreach ($ids_rig_not_full_info as $value) {
            $data['not_full_info'][] =$value['id_rig'];
        }

        $sily_mchs_m = new Model_Silymchs();
        $ids_rig_not_full_sily= $sily_mchs_m->getNotFullSily($id_rig_arr);
        foreach ($ids_rig_not_full_sily as $value) {
            $data['not_full_sily'][] =$value['id_rig'];
        }
}

                // empty fields
        $data['rig']=getEmptyFields($data['rig']);


                            /* is updeting now ?  */
        foreach ($data['rig'] as $k=>$r) {
            $is_update_now = is_update_rig_now_refresh_table($data['rig'][$k], $r['id']);
            //  echo $is_update_now;exit();
            if (!empty($is_update_now)) {
                //  echo $is_update_now;
                $data['rig'][$k]['is_update_now'] = $is_update_now;
            }
            //  exit();


        }
         /* is updeting now ?  */


        $data['rig']=getResultsBattle($data['rig']);//results battle

        $data['trunk_by_rig']=getTrunkByRigs($id_rig_arr);

        /* mode */
        if (isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1 && !empty($data['settings_user_br_table'])) {

            $del_val = $data['settings_user_br_table'];
            $data['rig'] = array_filter($data['rig'], function($e) use ($del_val) {
                // return (in_array($e['id_reasonrig'], $del_val));
                if (in_array($e['id_reasonrig'], $del_val)) {
                    return true;
                }
                return false;
            });
        }

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


         /* did sily mchs get involved or not */
        $is_sily_mchs = $app->request()->post('is_sily_mchs');
        if (isset($is_sily_mchs) && !empty($is_sily_mchs) && $is_sily_mchs == 1) {//no
            $is_sily_mchs = 1;
            $post_silymchs =array();
        } else {//involved
            $is_sily_mchs = 0;

            $post_silymchs = $silymchs->getPOSTData(); //данные по силам МЧС
        }
        $post_rig['is_sily_mchs'] = $is_sily_mchs;

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
            $rig->save(array('is_sily_mchs'=>$is_sily_mchs), $id);
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
        //print_r($post_service);exit();
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
        $bread_crumb = array('Классификаторы', $name_bean,'Добавление');
        $data['bread_crumb'] = $bread_crumb;

          $reasonrig_m = new Model_Reasonrig();
          $data['reasonrig'] = $reasonrig_m->selectAll(0); //all reason
           $workview = new Model_Workview();
            $data['workview'] = $workview->selectAll();

          if(isset($_SESSION['msg_success']) && !empty($_SESSION['msg_success'])){
              $data['msg_success']=$_SESSION['msg_success'];
              unset($_SESSION['msg_success']);
          }

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'classif/actionwaybill/addForm.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

        //actionwaybill classif - add/edit
    $app->post('/actionwaybill/addForm/:id', function ($id=0) use ($app, $log) {

        //echo  $_POST['id_reasonrig'];
      //  echo $_POST['myeditor'];
        //print_r($_POST['myeditor']);
       // print_r($_POST);
     //   echo '************<br>';

        $id_reasonrig=$app->request()->post('id_reasonrig');
        $id_work_view=$app->request()->post('id_work_view');
        $myeditor=$app->request()->post('myeditor');
        $is_off=$app->request()->post('is_off');
        $ord=$app->request()->post('ord');

        $add_data=array();

        if($id_reasonrig != 0 && $id_work_view != 0){
                    foreach ($myeditor as $key=>$value) {
            if(isset($value) && !empty($value)){

                /* include or no in waybill */
                if (isset($is_off[$key]) && $is_off[$key] == 1) {
                    $is = 1;
                } else {
                    $is = 0;
                }

                /* order in waybill - ord */


                $add_data[]=array('id_reasonrig'=>$id_reasonrig,'description'=>$value,'is_off'=>$is,'ord'=>$ord[$key],'id_work_view'=>$id_work_view);
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
            if ($new_id==TRUE) {
                /* add next block */
                if (isset($_POST['next'])) {

                    $_SESSION['msg_success'] = 'Информация успешно добавлена в БД!';
                    /* add next block */
                    $app->redirect(BASE_URL . '/classif/actionwaybill/addForm');
                }

                 else {
                    /* redirect to table */
                    $app->redirect(BASE_URL . '/classif/actionwaybill');
                }
            }
            else{
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
                    $id_reas=$add['id_reasonrig'];
                    $old_ord=$add['ord'];
                    $id_work=$add['id_work_view'];
                }
               // echo $new_ord.'    ****'.$old_ord ;exit();

                $way->editOrd($id_reas, $old_ord, $new_ord,$id_work);
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
        $bread_crumb = array('Классификаторы', $name_bean,'Редактирование');
        $data['bread_crumb'] = $bread_crumb;

          $reasonrig_m = new Model_Reasonrig();
          $data['reasonrig'] = $reasonrig_m->selectAll(0); //all reason
          $workview = new Model_Workview();
          $data['workview'] = $workview->selectAll();

           $way = new Model_Actionwaybill();
           $data['action']= $way->selectById($id);

$data['action_id']=$id;

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
    $app->get('/actionwaybill/edit/ord/:id_reasonrig/:id_work', function ($id_reasonrig,$id_work) use ($app, $log) {

        $name_bean = 'Меры безопасности (для путевки)';
        $bread_crumb = array('Классификаторы', $name_bean,'Редактирование','Последовательность в путевке');
        $data['bread_crumb'] = $bread_crumb;

          $reasonrig_m = new Model_Reasonrig();
          $data['reasonrig'] = $reasonrig_m->selectAll(0); //all reason
          $workview = new Model_Workview();
          $data['workview'] = $workview->selectAll();


           $way = new Model_Actionwaybill();
           $data['action']= $way->selectAllActionByIdReason($id_reasonrig,$id_work);

$data['action_id']=$id_reasonrig;

        $app->render('layouts/header.php');
        $data['path_to_view'] = 'classif/actionwaybill/editFormOrd.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

                //actionwaybill classif - edit  of order
    $app->post('/actionwaybill/edit/ord/:id_reasonrig/:id_work', function ($id_reasonrig,$id_work) use ($app, $log) {

       // print_r($_POST);
         $id_reasonrig=$app->request()->post('id_reasonrig');
          $id_work_view=$app->request()->post('id_work_view');
//        $myeditor=$app->request()->post('myeditor');
        $is_off=$app->request()->post('is_off');
        $ord=$app->request()->post('ord');

      $is_twice=  array_count_values ($ord);
      $max_ord= max($is_twice);
       // print_r($is_twice);
          //  echo 'da';
       // exit();

        if($max_ord>1)
         $app->redirect(BASE_URL . '/error/actionwaybill');

        $add_data=array();

        if($id_reasonrig != 0){

            foreach ($ord as $key=> $value) {
    /* include or no in waybill */
                if (isset($is_off[$key]) && $is_off[$key] == 1) {
                    $is = 1;
                } else {
                    $is = 0;
                }
                $add_data[$key]=array('id_reasonrig'=>$id_reasonrig,'is_off'=>$is,'ord'=>$ord[$key],'id_work_view'=>$id_work_view);

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

$app->group('/settings', 'is_login','is_permis',  function () use ($app, $log) {

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


    /* settings */
    $app->get('/index', function () use ($app) {


        $bread_crumb = array('Настройки', 'Настройки пользователя');
        $data['bread_crumb'] = $bread_crumb;


          $reasonrig = new Model_Reasonrig();
          $data['reasonrig'] = $reasonrig->selectAll(1);



        $all_settings=R::getAll('SELECT * FROM settings');
        $data['all_settings']=$all_settings;

        /* select */
        $all_settings_type=R::getAll('SELECT * FROM settings_type');
        $settings_type=array();
        foreach ($all_settings_type as $value) {
            $settings_type[$value['id_setting']][]=$value;
        }
        $data['settings_type']=$settings_type;


        $settings_user_bd=R::getAll('SELECT * FROM settings_user WHERE id_user = ?',array($_SESSION['id_user']));
        $settings_user=array();
        foreach ($settings_user_bd as $value) {
            $settings_user[]=$value['id_settings_type'];
        }
        $data['settings_user']=$settings_user;

        /* br table */
        $settings_user_bd=R::getAll('SELECT * FROM settings_user_br_table WHERE id_user = ?',array($_SESSION['id_user']));
        $reasonrig_by_user=array();
        foreach ($settings_user_bd as $value) {
            $reasonrig_by_user[]=$value['id_reasonrig'];
        }
        $data['settings_user_br_table']=$reasonrig_by_user;



        $app->render('layouts/header.php');

        $data['path_to_view'] = 'settings/index.php';


        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    $app->post('/index/save', function () use ($app) {

       // print_r($_POST);exit();

        $types=$_POST['type'];
        $id_reasonrig_for_br_table=$_POST['id_reasonrig_for_br_table'];

         R::exec('DELETE FROM settings_user  WHERE id_user = ?', array($_SESSION['id_user']));

         foreach ($types as $value) {

             R::exec('INSERT INTO settings_user(id_user, id_settings_type) values(?,?) ', array($_SESSION['id_user'],$value));
         }


         /* reason for br table */

        R::exec('DELETE FROM settings_user_br_table  WHERE id_user = ?', array($_SESSION['id_user']));
        if (isset($id_reasonrig_for_br_table) && !empty($id_reasonrig_for_br_table)) {
            foreach ($id_reasonrig_for_br_table as $value) {
                R::exec('INSERT INTO settings_user_br_table(id_user, id_settings, id_reasonrig) values(?,?,?) ', array($_SESSION['id_user'], 4, $value));
            }
        }
        else{
             if(isset($_SESSION['br_table_mode']))
            unset($_SESSION['br_table_mode']);
        }


         $app->redirect(BASE_URL . '/settings/index');


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


        if (isset($_POST['reasonrig']) && !empty($_POST['reasonrig'])) {
            $reasonrig_n = $_POST['reasonrig'];
        }

        if(isset($reasonrig_n) && !empty($reasonrig_n)) {
            $reasonrig_name=R::getCell('select name from reasonrig where id = ?',array($reasonrig_n));

        }
        else{
            $reasonrig_name='все';
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



                      $sheet->setCellValue('A3', 'область: '.$region_name.', район: '.$local_name.', причина вызова: '.$reasonrig_name);//выбранный область и район

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
            $sheet->setCellValue('B' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('C' . $r, date('H:i', strtotime($row['time_msg'])));

            $sheet->setCellValue('E' . $r, $row['description']);


            $adr = ($row['address'] == NULL ) ? $row['additional_field_address'] : $row['address'];  /*   <!--                            если адрес пуст-выводим дополнит поле с адресом--> */
            $adr_region=($row['id_region'] == 3 && $row['id_local']==123  ) ? '' : ( ($row['id_region'] == 3) ? $row['region_name'].', ' : $row['region_name'].' обл., ');
            $local_arr=array(21,22,123,124,135,136,137,138,139,140,141);//id_local городов - им не надо слово район
             $adr_local=(in_array($row['id_local'] , $local_arr) || empty($row['id_local'])) ? '' : $row['local_name'].' район., ';

//                 if($row['id_local']==123){//г.Минск
//                     $adr_region='';
//                 }

            $sheet->setCellValue('F' . $r, $adr_region.$adr_local. $adr);

            $sheet->setCellValue('K' . $r, (($row['time_loc']=='0000-00-00 00:00:00' || empty($row['time_loc'])) ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
            $sheet->setCellValue('L' . $r, (($row['time_likv']=='0000-00-00 00:00:00' || empty($row['time_likv'])) ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
            $sheet->setCellValue('P' . $r, $row['inf_detail']);
            $sheet->setCellValue('Q' . $r, $row['view_work']);
             /*------------------- КОНЕЦ данные по вызову --------------------------*/

            /*------------------- данные по заявителю --------------------------*/
            //$tel= ($people[$row['id']]['phone'] == NULL || empty($people[$row['id']]['phone']) ) ? '': ('тел. '.$people[$row['id']]['phone']);
          //$sheet->setCellValue('D' . $r, $people[$row['id']]['fio'].chr(10).$tel.chr(10).$people[$row['id']]['address'].chr(10).$people[$row['id']]['position']);

            $tt = '';
            if (isset($row['id']) && isset($people[$row['id']]) && isset($people[$row['id']]['phone'])) {
                if ($people[$row['id']]['phone'] == NULL || empty($people[$row['id']]['phone'])) {
                    $tt = '';
                } else {
                    $tt = 'тел. ' . $people[$row['id']]['phone'];
                }
            }

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



            $sheet->setCellValue('D' . $r, $people_fio . chr(10) . $tel . chr(10) . $people_address . chr(10) . $people_position);

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
                    $sheet->setCellValue('I' . $s, (($si['time_exit']=='0000-00-00 00:00:00' || empty($si['time_exit'])) ? '' : date('d.m.Y H:i', strtotime($si['time_exit']))) );
                    $sheet->setCellValue('J' . $s, (($si['time_arrival']=='0000-00-00 00:00:00' || empty($si['time_arrival'])) ? '' : date('d.m.Y H:i', strtotime($si['time_arrival']))));
                    $sheet->setCellValue('M' . $s, (($si['time_end']=='0000-00-00 00:00:00' || empty($si['time_end'])) ? '' : date('d.m.Y H:i', strtotime($si['time_end']))));
                    $sheet->setCellValue('N' . $s, (($si['time_return']=='0000-00-00 00:00:00' || empty($si['time_return'])) ? '' : date('d.m.Y H:i', strtotime($si['time_return']))));
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
                    $sheet->setCellValue('H' . $s, (($si['time_msg']=='0000-00-00 00:00:00' || empty($si['time_msg'])) ? '' : date('d.m.Y H:i', strtotime($si['time_msg']))));
                    $sheet->setCellValue('I' . $s, '-');
                    $sheet->setCellValue('J' . $s, (($si['time_arrival']=='0000-00-00 00:00:00' || empty($si['time_arrival'])) ? '' : date('d.m.Y H:i', strtotime($si['time_arrival']))));
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
                    $sheet->setCellValue('H' . $s, (($si['time_msg']=='0000-00-00 00:00:00' || empty($si['time_msg'])) ? '' : date('d.m.Y H:i', strtotime($si['time_msg']))));
                    $sheet->setCellValue('I' . $s, (($si['time_exit']=='0000-00-00 00:00:00' || empty($si['time_exit'])) ? '' : date('d.m.Y H:i', strtotime($si['time_exit']))) );
                    $sheet->setCellValue('J' . $s, (($si['time_arrival']=='0000-00-00 00:00:00' || empty($si['time_arrival'])) ? '' : date('d.m.Y H:i', strtotime($si['time_arrival']))));
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


        $data['reasonrig']=R::getAll('select * from reasonrig where is_delete = ?',array(0));

        /*         * *** КОНЕЦ Классификаторы **** */

        $app->render('layouts/header.php',$data);
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
        $archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');

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


        $table_name_year = $app->request()->post('archive_year');
        $month=$app->request()->post('archive_month');

        $months=array('01'=>'январь', '02'=>'февраль', '03'=>'март', '04'=>'апрель', '05'=>'май', '06'=>'июнь', '07'=>'июль', '08'=>'август'
    , '09'=>'сентябрь', '10'=>'октябрь', '11'=>'ноябрь', '12'=>'декабрь');

        $year = $table_name_year;
        $year = substr($year, 0, -1);

        // echo $table_name_year;
        if($month == ''){//all months
             $rigs = R::getAll('SELECT q.`reasonrig_name`, COUNT(q.`id`) as cnt FROM jarchive.' . $table_name_year . ' as q GROUP BY q.`reasonrig_name`');
        }
        else{
             $rigs = R::getAll('SELECT q.`reasonrig_name`, COUNT(q.`id`) as cnt FROM jarchive.' . $table_name_year . ' as q WHERE DATE_FORMAT( q.`date_msg`,"%m") ="'.$month.'" GROUP BY q.`reasonrig_name`');
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
});

/* ------------------------- END report ------------------------------- */

/* ------------------ сообщение об ошибке -------------------------- */
$app->get('/error', function () use ($app) {
    $app->render('layouts/header.php');
    $data['path_to_view'] = 'error.php';
    $app->render('layouts/div_wrapper.php', $data);
    $app->render('layouts/footer.php');
});

/* classif actionwaybill */
$app->get('/error/actionwaybill', function () use ($app) {
    $app->render('layouts/header.php');
    $data['path_to_view'] = 'error_actionwaybill.php';
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
// $dateduty='2018-10-27';
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
        if(!empty($row['object']))
            $object=' ('.$row['object'].')';
        else
            $object='';


        $purpose = $row['inf_detail']; //цель выезда

        $reasonrig_name=$row['reasonrig_name'];
        $view_work=$row['view_work'];
        $reasonrig_id=$row['id_reasonrig'];
        $work_id=$row['view_work_id'];



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
    $array=array('address'=>$address, 'object'=>$object, 'purpose'=>$purpose,'hour'=>$hour,'minutes'=>$minutes,'day'=>$day,
        'name_month'=>$name_month,'year'=>$year,'data_people'=>$data_people,'action'=>$action,'reasonrig_name'=>$reasonrig_name,
        'work_view'=>$view_work,'work_id'=>$work_id,'reasonrig_id'=>$reasonrig_id);
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

$pdf->Ln( 10 );//отступ после строки
$pdf->Ln( 10 );//отступ после строки
$pdf->SetFont('DejaVu','',14);
$text_1='По мнению президента, проект закона — один из ключевых вопросов кадровой политики, «ведь эффективность и авторитет всей системы власти во многом зависят от уровня подготовки и мотивированности работников государственных органов».

Президент отметил, что высокий правовой статус государственных служащих, обеспечивающий престижность этой профессии, невозможен без установления в законе социально-правовых гарантий для них. Но эти гарантии должны строго соотноситься с обязанностями и ответственностью каждого сотрудника госоргана, обратил внимание он.

«Поручая разработать этот закон, я предупреждал всех вас, что эти „коврижки“, которые у нас принято раздавать в любом законе в виде каких-то социальных гарантий, не должны быть выше того, что они есть, — сказал Александр Лукашенко. — Материальное положение госслужащих должно расти или падать в соответствии с ростом или падением жизненного уровня нашего населения. Это ключевое».
Читать полностью:  ';

$pdf->Write(8,$text_1);

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

// test!!!!!!
$app->get('/html_pdf_print/:id_rig/:is_action/:is_download', function ($id_rig,$is_action,$is_download) use ($app) {

     $array=getData($id_rig);
    // print_r($array);exit();

     /* generate html file of putevki */

        $font_default = '<style>body { font-family: DejaVu Sans; font-size: 16px } .vid{ font-size: 14px !important }</style>';
        $head = '<center><b>ПУТЕВКА № ' . $id_rig . '<br> для выезда дежурной смены подразделения</b></center><br><br>';



        /* 1.address  */
$address='1. Адрес&nbsp;&nbsp;&nbsp;<u>'.$array['address'].$array['object'].'</u><br>';

/* 2.purpose  */
$purpose='2. Цель выезда&nbsp;&nbsp;&nbsp;<u>'.$array['purpose'].'</u><br>';

/* 3. time and date of msg */
$date_time_msg='3. Время и дата получения сообщения&nbsp;&nbsp;&nbsp;<u>'.$array['hour'].'</u> часов <u>'.$array['minutes'].'</u> '.'  минут(ы) '.
    '<u>«'.$array['day'].'»</u> '.$array['name_month'].'&nbsp;<u>'.$array['year'].'</u>  г.<br>';


/* 4. data about people  */
$people='4. Данные о заявителе&nbsp;&nbsp;&nbsp;<u>'.$array['data_people'].'</u><br><br>';

/* sign of operativnogo */
$sign='Подпись дежурного диспетчера&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br><br>';


$text_1='По мнению президента, проект закона — один из ключевых вопросов кадровой политики, «ведь эффективность и авторитет всей системы власти во многом зависят от уровня подготовки и мотивированности работников государственных органов».

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

if($array['work_id'] !=0){
   $vid='<span class="vid">Вид:&nbsp;&nbsp;&nbsp;'. (($array['work_id'] !=0) ? $array['work_view']:'').'</span><br>';
}
else
    $vid='';


  $res = $font_default . $head.$address.$purpose.$date_time_msg.$people.$sign.$vid;

  /* with action */
  if($is_action == 1){
        if (!empty($array['action'])) {
            foreach ($array['action'] as $value) {
                $res = $res . $value['description'];
            }
        }
  }

//$aa= stristr($array['reasonrig_name'], ' ');
//echo $aa;exit();
 //print_r($res);exit();

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
if($is_download == 0){

     $output = $dompdf->output();
     file_put_contents(__DIR__ . '/temp/' . $f, $output);

/* see in browser */
    $content = file_get_contents(__DIR__ . '/temp/' . $f);

    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($content));
    header('Content-Disposition: inline; filename="YourFileName.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    die($content);
}
else{
$filename='putevka'.$id_rig.'.pdf';
$dompdf->stream($filename);
}



});

});



/*--------------- КОНЕЦ  Путевка ----------------------*/


/* ------------------------- Logs ------------------------------- */

$app->group('/logs', 'is_login', 'is_permis', function () use ($app) {


    /* login */
    $app->get('/login', function () use ($app) {

        $bread_crumb = array('Логи. Авторизация пользователей', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Логи';

        $date_from= date('Y-m-d');

          $data['logs']=R::getAll('select * from loglogin where date_format(date_in,"%Y-%m-%d") = ?',array($date_from));

        $app->render('layouts/header.php', $data);
       // $data['path_to_view'] = 'logs/login/form.php';
        $data['path_to_view'] = 'logs/login/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    $app->post('/login', function () use ($app) {

        $bread_crumb = array('Логи. Авторизация пользователей', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Логи';

            $date_from = (isset($_POST['date_start']) && !empty($_POST['date_start']) ) ? $_POST['date_start'] : date("Y-m-d");
   $date_to = (isset($_POST['date_end']) && !empty($_POST['date_end']) ) ? $_POST['date_end'] : date("Y-m-d");

         $data['logs']=R::getAll('select * from loglogin where date_format(date_in,"%Y-%m-%d") between ? and ?',array($date_from,$date_to));

        $app->render('layouts/header.php',$data);
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

        $date_from= date('Y-m-d');
         $data['logs'] = R::getAll('select * from logs where date_format(date_action,"%Y-%m-%d") = ?',array($date_from));

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

        $data['logs'] = R::getAll('select * from logs where date_format(date_action,"%Y-%m-%d") between ? and ?',array($date_from,$date_to));

        $app->render('layouts/header.php', $data);
        //$data['path_to_view'] = 'logs/form.php';
        $data['path_to_view'] = 'logs/actions/logs.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    /* json */

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Логи. json', 'Выбор даты');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Логи';


        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'logs/form.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });


    $app->post('/', function () use ($app) {


       $bread_crumb = array('Логи. json', 'Просмотр');
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
		   		 //  echo '123';
//exit();
		  // print_r($rig);
		   //exit();

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

    $app->get('/json_to_mysql', function () use ($app) {
    $file_json = '2018-12-31' . '_' . '2019-01-10';
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

         $p='';
            if (isset($row['people'])) {

                 $p = ((empty($row['people']['fio'])) ? '' : $row['people']['fio']) . '' . ((empty($row['people']['phone'])) ? '' : (', ' . $row['people']['phone'])) . '' . ((empty($row['people']['address'])) ? '' : (', ' . $row['people']['address'])) . '' . ((empty($row['people']['position'])) ? '' : (', ' . $row['people']['position']));

            }
  //echo $p;echo '<br>****************<br>';

         $silymchs_for_archive='';
           if (isset($row['silymchs'])) {

                  foreach ($row['silymchs'] as $silymchs) {
                     $silymchs_for_archive=$silymchs_for_archive. $silymchs['mark'] . '#' . $silymchs['numbsign'] . '$' . $silymchs['locorg_name'] . '%' . $silymchs['pasp_name'] . '?'.  ((empty($silymchs['time_exit'])) ? '-' : $silymchs['time_exit']) . '&'
                          .  ((empty($silymchs['time_arrival'])) ? '-' : $silymchs['time_arrival']) . '&'.  ((empty($silymchs['time_follow'])) ? '-' : $silymchs['time_follow']) . '&'. ((empty($silymchs['time_end'])) ? '-' : $silymchs['time_end']) . '&'
                          . ((empty($silymchs['time_return'])) ? '-' : $silymchs['time_return']) . '&'. ((empty($silymchs['distance'])) ? '-' : $silymchs['distance']) . '&'. ((empty($silymchs['is_return'])) ? '-' : $silymchs['is_return']) . '~';

                  }
           }
                            // echo $silymchs_for_archive;
                 // echo '<br>****************<br>';


           $informing_for_archive = '';
        if (isset($row['informing'])) {
            foreach ($row['informing'] as $informing) {
                $informing_for_archive=$informing_for_archive. $informing['fio'] . ' (' . $informing['position_name'] . ')' . '#'
                    .((empty($informing['time_msg'])) ? '-' : ($informing['time_msg'])).'&'
                    .((empty($informing['time_exit'])) ? '-' : ($informing['time_exit'])).'&'
                    .((empty($informing['time_arrival'])) ? '-' : ($informing['time_arrival'])).'~';
            }
        }
//                 echo $informing_for_archive;
//                 echo '<br>****************<br>';


                 $innerservice_for_archive='';
                   if (isset($row['innerservice'])) {
                        foreach ($row['innerservice'] as $innerservice) {
                           $innerservice_for_archive= $innerservice_for_archive.$innerservice['service_name'].'#'
                               .((empty($innerservice['time_msg'])) ? '-' :  $innerservice['time_msg']).'&'
                                .((empty($innerservice['time_arrival'])) ? '-' :  $innerservice['time_arrival']).'&'
                                .((empty($innerservice['distance'])) ? '-' :  $innerservice['distance']).'%'
                                .((empty($innerservice['note'])) ? '-' :  $innerservice['note']).'~';
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

$app->group('/archive','is_login','is_permis', function () use ($app) {

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

//    R::selectDatabase('ss');
//    $aa=R::getAll('select * from regions');
//    print_r($aa);    echo '******************<';
//     R::selectDatabase('default');
//    $bb=R::getAll('select * from destination');
//    print_r($bb);
//    exit();

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


/* new archive. bd */
$app->group('/archive_1','is_login','is_permis', function () use ($app) {

    $app->get('/', function () use ($app) {

        $bread_crumb = array('Архив', 'Параметры');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Журнал ЦОУ. Архив';



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
        $archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');

        foreach ($archive_year as $value) {
            $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
            $archive_year_1[] = $value;
        }
        $data['archive_year'] = $archive_year_1;


        $data['reasonrig']=R::getAll('select * from reasonrig where is_delete = ?',array(0));
        /*         * *** КОНЕЦ Классификаторы **** */


  // $isset_date = $archive_m->selectAll();//какие архивы уже сделаны
   // $isset_year = $archive_year_m->selectAll();//какие года есть в БД


        $app->render('layouts/archive/header.php',$data);
        $data['path_to_view'] = 'archive_1/form.php';
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

     $app->post('/getInfRig', function () use ($app) {


                      /* post data */
$date_start=$app->request()->post('date_start');
$date_end=$app->request()->post('date_end');
$table_name_year=$app->request()->post('archive_year');
$region_id=$app->request()->post('region');
$local=$app->request()->post('local');
$reasonrig=$app->request()->post('reasonrig');


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
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;



        if(isset($region) && $region !=''){
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }
        if(isset($local) && !empty($local)){
              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

        if(isset($reasonrig) && !empty($reasonrig)){
              $sql=$sql.' AND reasonrig_name = "'.$reasonrig.'"';
             //$param[] = $local;
        }

 $sql='SELECT id_rig '.$sql;
 $data['result']=R::getAll($sql, $param);

$cnt_result=count($data['result']);

$ids_rig=array();
foreach ($data['result'] as $value) {
    $ids_rig[]=$value['id_rig'];
}

//$data['cnt']=$cnt_result;
/* colors */

if (!empty($ids_rig)) {
            $_SESSION['colors'] = array();
            $spread = 25;
            for ($row = 0; $row < $cnt_result; ++$row) {
                for ($c = 0; $c < 3;  ++$c) {
                    $color[$c] = rand(0 + $spread, 255 - $spread);
                }
                //echo "<div style='float:left; background-color:rgb($color[0],$color[1],$color[2]);'>&nbsp;Base Color&nbsp;</div><br/>";
                for ($i = 0; $i < 92;  ++$i) {
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

             /* post data */
$date_start=$app->request()->post('date_start');
$date_end=$app->request()->post('date_end');
$table_name_year=$app->request()->post('archive_year');
$region_id=$app->request()->post('region');
$local=$app->request()->post('local');

$reasonrig=$app->request()->post('reasonrig');

$data['table_name_year']=$table_name_year;
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
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;



        if(isset($region) && $region !=''){
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;

              $region_for_export=$region;
        }
        else{
            $region_for_export='no';
        }
        if(isset($local) && !empty($local)){
              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
               $local_for_export=$local;
        }
         else{
            $local_for_export='no';
        }


         if(isset($reasonrig) && !empty($reasonrig)){
              $sql=$sql.' AND reasonrig_name = "'.$reasonrig.'"';
             //$param[] = $local;
               $reasonrig_for_export=$reasonrig;
        }
         else{
            $reasonrig_for_export='no';
        }



        $sql=$sql.' ORDER BY id_rig ASC';

if($id_tab=='table-content1'){//rig

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail,  people,time_loc, time_likv '.$sql;

}
elseif($id_tab=='table-content2'){//technic mchs

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival,silymchs '.$sql;

}
elseif($id_tab=='table-content3'){//informing

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, informing '.$sql;

}
elseif($id_tab=='table-content4'){//innerservice

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, innerservice '.$sql;

}
elseif($id_tab=='table-content5'){//results br

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, results_battle '.$sql;

}
elseif($id_tab=='table-content6'){//trunk

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, trunk '.$sql;

}

//echo $sql;
$data['result']=R::getAll($sql, $param);



if($id_tab=='table-content1'){
  $data['link_excel']='archive_1/exportExcelTab1/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no';
  $data['link_excel_hidden']='archive_1/exportExcelTab1/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export;
}
elseif($id_tab=='table-content2'){
  $data['link_excel']='archive_1/exportExcelTab2/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no';
  $data['link_excel_hidden']='archive_1/exportExcelTab2/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export;
}
elseif($id_tab=='table-content3'){
  $data['link_excel']='archive_1/exportExcelTab3/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no';
  $data['link_excel_hidden']='archive_1/exportExcelTab3/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export;
}
elseif($id_tab=='table-content4'){
  $data['link_excel']='archive_1/exportExcelTab4/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no';
  $data['link_excel_hidden']='archive_1/exportExcelTab4/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export;
}
elseif($id_tab=='table-content5'){
  $data['link_excel']='archive_1/exportExcelTab5/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no';
  $data['link_excel_hidden']='archive_1/exportExcelTab5/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export;
}
elseif($id_tab=='table-content6'){
  $data['link_excel']='archive_1/exportExcelTab6/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no'.'/'.'no';
  $data['link_excel_hidden']='archive_1/exportExcelTab6/'.$id_tab.'/'.$table_name_year.'/'.$date_start.'/'.$date_end.'/'.$region_for_export.'/'.$local_for_export.'/'.$reasonrig_for_export;
}


           $view = $app->render('archive_1/tab-content/'.$id_tab.'.php',$data);
        $response = ['success' => TRUE, 'view' => $view];
        // echo '9969';


    });


       $app->get('/exportExcelTab1/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/:reason/:work_view/:detail/:people/:time_loc/:time_likv',
           function ($id_tab,$table,$date_from,$date_to,$reg,$loc,$reasonrig_form,$id_rig,$date_msg,$time_msg,$local_1,$addr,$reason,$work_view,$detail,$people,$time_loc,$time_likv) use ($app) {

             /* get data */
$date_start=$date_from;
$date_end=$date_to;
$table_name_year=$table;
$region=$reg;
$local=$loc;



        /* from 06:00:00 till 06:00:00 */
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;

//var_dump($region);
        if($region != 'no' ){
           // echo 'uuuuuu';
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }

        if( $local != 'no'){

              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

        if( $reasonrig_form != 'no'){

              $sql=$sql.' AND reasonrig_name =  "'.$reasonrig_form.'"';
             //$param[] = $local;
        }


        /*--------------- filter from datatables ------------- */
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

        /*--------------- END filter from datatables ------------- */




        $sql=$sql.' ORDER BY id_rig ASC';

if($id_tab=='table-content1'){//rig

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv '.$sql;

}
elseif($id_tab=='table-content2'){//technic mchs

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs '.$sql;

}
elseif($id_tab=='table-content3'){//informing

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, informing '.$sql;

}
elseif($id_tab=='table-content4'){//innerservice

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, innerservice '.$sql;

}


$result=R::getAll($sql, $param);
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


        $sheet->setCellValue('A2', 'с ' . $date_start . ' по ' . $date_end); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no')?$region:'все') . ', район: ' . (($local != 'no')?$local:'все'). ', причина вызова: ' . (($reasonrig_form != 'no')?$reasonrig_form:'все')); //выбранный область и район

          /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if(!empty($result)){
         if($id_tab=='table-content1'){//rig
     foreach ($result as $row) {
            $i++;

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])) );
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
            $sheet->setCellValue('H' . $r, $row['view_work']);
            $sheet->setCellValue('I' . $r, $row['inf_detail']);
            $sheet->setCellValue('J' . $r, $row['people']);
            $sheet->setCellValue('K' . $r, (($row['time_loc']=='0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc'])) ));
            $sheet->setCellValue('L' . $r, (($row['time_likv']=='0000-00-00 00:00:00' || empty($row['time_likv']) ||$row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));

            $r++;
        }



        $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
}
elseif($id_tab=='table-content2'){//technic mchs

 $i=0;
    foreach ($result as $row) {
         $arr_silymchs= explode('~', $row['silymchs']);

    foreach ($arr_silymchs as $value) {
        if(!empty($value)){
                $i++;
         $arr_mark= explode('#', $value);

        $mark=$arr_mark[0];

        /* all after # explode, exit,arrival......is_return , result -all  after ? */
        $arr_time= explode('?', $arr_mark[1]);

          /* all  after ? explode.  exit,arrival......is_return*/
$each_time= explode('&', $arr_time[1]);

$t_exit=$each_time[0];
$t_arrival=$each_time[1];
$t_follow=$each_time[2];
$t_end=$each_time[3];
$t_return=$each_time[4];
$t_distance=$each_time[5];
$t_is_return=($each_time[6] == 0)?'нет':'да';

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $mark);
            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))) );
            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
             $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да':'нет'));
              $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end=='-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
              $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return=='-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
              $sheet->setCellValue('O' . $r, $t_distance);
              $sheet->setCellValue('P' . $r, $t_is_return);

            $r++;

    }
    }
    }
     $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);

}
elseif($id_tab=='table-content3'){//informing

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
                        $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit=='-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                        $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival)) ));

                        $r++;
                    }
                }
            }
               $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
        }
elseif($id_tab=='table-content4'){//innerservice

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
                        $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
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
      $app->get('/exportExcelTab2/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/:time_loc/:time_likv/:is_likv_before_arrival',
          function ($id_tab,$table,$date_from,$date_to,$reg,$loc,$reasonrig_form,$id_rig,$date_msg,$time_msg,$local_1,$addr,$time_loc,$time_likv,$is_likv_before_arrival) use ($app) {

             /* get data */
$date_start=$date_from;
$date_end=$date_to;
$table_name_year=$table;
$region=$reg;
$local=$loc;

        /* from 06:00:00 till 06:00:00 */
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;

//var_dump($region);
        if($region != 'no' ){
           // echo 'uuuuuu';
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }

        if( $local != 'no'){

              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

                if( $reasonrig_form != 'no'){

              $sql=$sql.' AND reasonrig_name =  "'.$reasonrig_form.'"';
             //$param[] = $local;
        }


        /*--------------- filter from datatables ------------- */
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

            $is_likv=($is_likv_before_arrival == 'нет') ? 0 : 1;

             $sql=$sql.' AND is_likv_before_arrival = ?';
             $param[] = $is_likv;

        }

        /*--------------- END filter from datatables ------------- */


        $sql=$sql.' ORDER BY id_rig ASC';

if($id_tab=='table-content1'){//rig

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv '.$sql;

}
elseif($id_tab=='table-content2'){//technic mchs

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs '.$sql;

}
elseif($id_tab=='table-content3'){//informing

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, informing '.$sql;

}
elseif($id_tab=='table-content4'){//innerservice

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, innerservice '.$sql;

}


$result=R::getAll($sql, $param);
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


        $sheet->setCellValue('A2', 'с ' . $date_start . ' по ' . $date_end); //выбранный период
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no')?$region:'все') . ', район: ' . (($local != 'no')?$local:'все'). ', причина вызова: ' . (($reasonrig_form != 'no')?$reasonrig_form:'все')); //выбранный область и район

          /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if(!empty($result)){
         if($id_tab=='table-content1'){//rig
     foreach ($result as $row) {
            $i++;

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])) );
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
            $sheet->setCellValue('H' . $r, $row['view_work']);
            $sheet->setCellValue('I' . $r, $row['inf_detail']);
            $sheet->setCellValue('J' . $r, $row['people']);
            $sheet->setCellValue('K' . $r, (($row['time_loc']=='0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc'])) ));
            $sheet->setCellValue('L' . $r, (($row['time_likv']=='0000-00-00 00:00:00' || empty($row['time_likv']) ||$row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));


            $r++;
        }



        $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
}
elseif($id_tab=='table-content2'){//technic mchs

 $i=0;
    foreach ($result as $row) {
         $arr_silymchs= explode('~', $row['silymchs']);

    foreach ($arr_silymchs as $value) {
        if(!empty($value)){
                $i++;
         $arr_mark= explode('#', $value);

        $mark=$arr_mark[0];

        /* all after # explode, exit,arrival......is_return , result -all  after ? */
        $arr_time= explode('?', $arr_mark[1]);

          /* all  after ? explode.  exit,arrival......is_return*/
$each_time= explode('&', $arr_time[1]);

$t_exit=$each_time[0];
$t_arrival=$each_time[1];
$t_follow=$each_time[2];
$t_end=$each_time[3];
$t_return=$each_time[4];
$t_distance=$each_time[5];
$t_is_return=($each_time[6] == 0)?'нет':'да';

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $mark);
            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))) );
            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
             $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да':'нет'));
             $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end=='-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
              $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return=='-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
              $sheet->setCellValue('O' . $r, $t_distance);
              $sheet->setCellValue('P' . $r, $t_is_return);

            $r++;

    }
    }
    }
     $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);

}
elseif($id_tab=='table-content3'){//informing

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
                        $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit=='-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                        $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival)) ));


                        $r++;
                    }
                }
            }
               $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
        }
elseif($id_tab=='table-content4'){//innerservice

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
                        $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
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
       $app->get('/exportExcelTab3/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab,$table,$date_from,$date_to,$reg,$loc,$reasonrig_form,$id_rig,$date_msg,$time_msg,$local_1,$addr) use ($app) {

             /* get data */
$date_start=$date_from;
$date_end=$date_to;
$table_name_year=$table;
$region=$reg;
$local=$loc;

        /* from 06:00:00 till 06:00:00 */
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;

//var_dump($region);
        if($region != 'no' ){
           // echo 'uuuuuu';
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }

        if( $local != 'no'){

              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

        if( $reasonrig_form != 'no'){

              $sql=$sql.' AND reasonrig_name =  "'.$reasonrig_form.'"';
             //$param[] = $local;
        }


         /*--------------- filter from datatables ------------- */
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


        /*--------------- END filter from datatables ------------- */


        $sql=$sql.' ORDER BY id_rig ASC';

if($id_tab=='table-content1'){//rig

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv '.$sql;

}
elseif($id_tab=='table-content2'){//technic mchs

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs '.$sql;

}
elseif($id_tab=='table-content3'){//informing

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, informing '.$sql;

}
elseif($id_tab=='table-content4'){//innerservice

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, innerservice '.$sql;

}


$result=R::getAll($sql, $param);
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
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no')?$region:'все') . ', район: ' . (($local != 'no')?$local:'все'). ', причина вызова: ' . (($reasonrig_form != 'no')?$reasonrig_form:'все')); //выбранный область и район

          /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if(!empty($result)){
         if($id_tab=='table-content1'){//rig
     foreach ($result as $row) {
            $i++;

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])) );
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
            $sheet->setCellValue('H' . $r, $row['view_work']);
            $sheet->setCellValue('I' . $r, $row['inf_detail']);
            $sheet->setCellValue('J' . $r, $row['people']);
            $sheet->setCellValue('K' . $r, (($row['time_loc']=='0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc'])) ));
            $sheet->setCellValue('L' . $r, (($row['time_likv']=='0000-00-00 00:00:00' || empty($row['time_likv']) ||$row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));

            $r++;
        }



        $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
}
elseif($id_tab=='table-content2'){//technic mchs

 $i=0;
    foreach ($result as $row) {
         $arr_silymchs= explode('~', $row['silymchs']);

    foreach ($arr_silymchs as $value) {
        if(!empty($value)){
                $i++;
         $arr_mark= explode('#', $value);

        $mark=$arr_mark[0];

        /* all after # explode, exit,arrival......is_return , result -all  after ? */
        $arr_time= explode('?', $arr_mark[1]);

          /* all  after ? explode.  exit,arrival......is_return*/
$each_time= explode('&', $arr_time[1]);

$t_exit=$each_time[0];
$t_arrival=$each_time[1];
$t_follow=$each_time[2];
$t_end=$each_time[3];
$t_return=$each_time[4];
$t_distance=$each_time[5];
$t_is_return=($each_time[6] == 0)?'нет':'да';

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $mark);
            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))) );
            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
             $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да':'нет'));
             $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end=='-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
              $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return=='-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
              $sheet->setCellValue('O' . $r, $t_distance);
              $sheet->setCellValue('P' . $r, $t_is_return);

            $r++;

    }
    }
    }
     $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);

}
elseif($id_tab=='table-content3'){//informing

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
                        $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit=='-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                        $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival)) ));


                        $r++;
                    }
                }
            }
               $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
        }
elseif($id_tab=='table-content4'){//innerservice

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
                        $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
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
       $app->get('/exportExcelTab4/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab,$table,$date_from,$date_to,$reg,$loc,$reasonrig_form,$id_rig,$date_msg,$time_msg,$local_1,$addr) use ($app) {

             /* get data */
$date_start=$date_from;
$date_end=$date_to;
$table_name_year=$table;
$region=$reg;
$local=$loc;

        /* from 06:00:00 till 06:00:00 */
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;

//var_dump($region);
        if($region != 'no' ){
           // echo 'uuuuuu';
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }

        if( $local != 'no'){

              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

        if( $reasonrig_form != 'no'){

              $sql=$sql.' AND reasonrig_name =  "'.$reasonrig_form.'"';
             //$param[] = $local;
        }



         /*--------------- filter from datatables ------------- */
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


        /*--------------- END filter from datatables ------------- */


        $sql=$sql.' ORDER BY id_rig ASC';

if($id_tab=='table-content1'){//rig

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,reasonrig_name, view_work, inf_detail, people,time_loc, time_likv '.$sql;

}
elseif($id_tab=='table-content2'){//technic mchs

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address,time_loc, time_likv, is_likv_before_arrival, silymchs '.$sql;

}
elseif($id_tab=='table-content3'){//informing

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, informing '.$sql;

}
elseif($id_tab=='table-content4'){//innerservice

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, innerservice '.$sql;

}


$result=R::getAll($sql, $param);
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
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no')?$region:'все') . ', район: ' . (($local != 'no')?$local:'все'). ', причина вызова: ' . (($reasonrig_form != 'no')?$reasonrig_form:'все')); //выбранный область и район

          /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if(!empty($result)){
         if($id_tab=='table-content1'){//rig
     foreach ($result as $row) {
            $i++;

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])) );
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $row['reasonrig_name']);
            $sheet->setCellValue('H' . $r, $row['view_work']);
            $sheet->setCellValue('I' . $r, $row['inf_detail']);
            $sheet->setCellValue('J' . $r, $row['people']);
             $sheet->setCellValue('K' . $r, (($row['time_loc']=='0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc'])) ));
            $sheet->setCellValue('L' . $r, (($row['time_likv']=='0000-00-00 00:00:00' || empty($row['time_likv']) ||$row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));

            $r++;
        }



        $sheet->getStyleByColumnAndRow(0, 8, 11, $r - 1)->applyFromArray($styleArray);
}
elseif($id_tab=='table-content2'){//technic mchs

 $i=0;
    foreach ($result as $row) {
         $arr_silymchs= explode('~', $row['silymchs']);

    foreach ($arr_silymchs as $value) {
        if(!empty($value)){
                $i++;
         $arr_mark= explode('#', $value);

        $mark=$arr_mark[0];

        /* all after # explode, exit,arrival......is_return , result -all  after ? */
        $arr_time= explode('?', $arr_mark[1]);

          /* all  after ? explode.  exit,arrival......is_return*/
$each_time= explode('&', $arr_time[1]);

$t_exit=$each_time[0];
$t_arrival=$each_time[1];
$t_follow=$each_time[2];
$t_end=$each_time[3];
$t_return=$each_time[4];
$t_distance=$each_time[5];
$t_is_return=($each_time[6] == 0)?'нет':'да';

            $sheet->setCellValue('A' . $r, $i); //№ п/п
            $sheet->setCellValue('B' . $r, $row['id_rig']);
            $sheet->setCellValue('C' . $r, date('d.m.Y', strtotime($row['date_msg'])));
            $sheet->setCellValue('D' . $r, date('H:i', strtotime($row['time_msg'])));
            $sheet->setCellValue('E' . $r, $row['local_name']);
            $sheet->setCellValue('F' . $r, $row['address']);
            $sheet->setCellValue('G' . $r, $mark);
            $sheet->setCellValue('H' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit == '-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
            $sheet->setCellValue('I' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))) );
            $sheet->setCellValue('J' . $r, (($row['time_loc'] == '0000-00-00 00:00:00' || empty($row['time_loc']) || $row['time_loc']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_loc']))));
            $sheet->setCellValue('K' . $r, (($row['time_likv'] == '0000-00-00 00:00:00' || empty($row['time_likv']) || $row['time_likv']=='-') ? '' : date('d.m.Y H:i', strtotime($row['time_likv']))));
             $sheet->setCellValue('L' . $r, (($row['is_likv_before_arrival']) == 1 ? 'да':'нет'));
              $sheet->setCellValue('M' . $r, (($t_end == '0000-00-00 00:00:00' || empty($t_end) || $t_end=='-' ) ? '' : date('d.m.Y H:i', strtotime($t_end))));
              $sheet->setCellValue('N' . $r, (($t_return == '0000-00-00 00:00:00' || empty($t_return) || $t_return=='-') ? '' : date('d.m.Y H:i', strtotime($t_return))));
              $sheet->setCellValue('O' . $r, $t_distance);
              $sheet->setCellValue('P' . $r, $t_is_return);

            $r++;

    }
    }
    }
     $sheet->getStyleByColumnAndRow(0, 8, 15, $r - 1)->applyFromArray($styleArray);

}
elseif($id_tab=='table-content3'){//informing

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
                        $sheet->setCellValue('H' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('I' . $r, (($t_exit == '0000-00-00 00:00:00' || empty($t_exit) || $t_exit=='-') ? '' : date('d.m.Y H:i', strtotime($t_exit))));
                        $sheet->setCellValue('J' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival)) ));

                        $r++;
                    }
                }
            }
               $sheet->getStyleByColumnAndRow(0, 8, 9, $r - 1)->applyFromArray($styleArray);
        }
elseif($id_tab=='table-content4'){//innerservice

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
                        $sheet->setCellValue('G' . $r, (($t_msg == '0000-00-00 00:00:00' || empty($t_msg) || $t_msg=='-') ? '' : date('d.m.Y H:i', strtotime($t_msg))));
                        $sheet->setCellValue('H' . $r, (($t_arrival == '0000-00-00 00:00:00' || empty($t_arrival) || $t_arrival=='-') ? '' : date('d.m.Y H:i', strtotime($t_arrival))));
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
       $app->get('/exportExcelTab5/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab,$table,$date_from,$date_to,$reg,$loc,$reasonrig_form,$id_rig,$date_msg,$time_msg,$local_1,$addr) use ($app) {

             /* get data */
$date_start=$date_from;
$date_end=$date_to;
$table_name_year=$table;
$region=$reg;
$local=$loc;

        /* from 06:00:00 till 06:00:00 */
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;

//var_dump($region);
        if($region != 'no' ){
           // echo 'uuuuuu';
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }

        if( $local != 'no'){

              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

        if( $reasonrig_form != 'no'){

              $sql=$sql.' AND reasonrig_name =  "'.$reasonrig_form.'"';
             //$param[] = $local;
        }



         /*--------------- filter from datatables ------------- */
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


        /*--------------- END filter from datatables ------------- */


        $sql=$sql.' ORDER BY id_rig ASC';

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, results_battle '.$sql;





$result=R::getAll($sql, $param);
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
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no')?$region:'все') . ', район: ' . (($local != 'no')?$local:'все'). ', причина вызова: ' . (($reasonrig_form != 'no')?$reasonrig_form:'все')); //выбранный область и район

          /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if(!empty($result)){



     foreach ($result as $row) {

         $res_battle=array();
         $res_battle= explode('#', $row['results_battle']);

          if(isset($res_battle) && !empty($res_battle) && count($res_battle) > 1 && max($res_battle) > 1){
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
       $app->get('/exportExcelTab6/:id_tab/:table/:date_from/:date_to/:reg/:loc/:reasonrig_form/:id_rig/:date_msg/:time_msg/:local_1/:addr/', function ($id_tab,$table,$date_from,$date_to,$reg,$loc,$reasonrig_form,$id_rig,$date_msg,$time_msg,$local_1,$addr) use ($app) {

             /* get data */
$date_start=$date_from;
$date_end=$date_to;
$table_name_year=$table;
$region=$reg;
$local=$loc;

        /* from 06:00:00 till 06:00:00 */
        $sql=' FROM jarchive.'.$table_name_year.'  WHERE date_msg between ? and ? and id_rig not in '
                . '  ( SELECT id_rig FROM jarchive.'.$table_name_year.' WHERE (date_msg = ? and time_msg< ? )'
            . ' or  (date_msg = ? and time_msg>= ? )  ) AND is_delete = 0 ';


        $param[] = $date_start;
        $param[] = $date_end;

        $param[] = $date_start;
        $param[] = '06:00:00';
        $param[] = $date_end;
        $param[] = '06:00:00';
      //  $param[]=0;

//var_dump($region);
        if($region != 'no' ){
           // echo 'uuuuuu';
           // $sql=$sql.' AND region_name like ?';
              $sql=$sql.' AND region_name = ?';
             $param[] = $region;
        }

        if( $local != 'no'){

              $sql=$sql.' AND ( local_name like "'.$local.'" OR local_name like "'.$local.'%" ) ';
             //$param[] = $local;
        }

        if( $reasonrig_form != 'no'){

              $sql=$sql.' AND reasonrig_name =  "'.$reasonrig_form.'"';
             //$param[] = $local;
        }



         /*--------------- filter from datatables ------------- */
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


        /*--------------- END filter from datatables ------------- */


        $sql=$sql.' ORDER BY id_rig ASC';

    $sql='SELECT id_rig,date_msg,time_msg, local_name,address, trunk '.$sql;





$result=R::getAll($sql, $param);
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
        $sheet->setCellValue('A3', 'область: ' . (($region != 'no')?$region:'все') . ', район: ' . (($local != 'no')?$local:'все'). ', причина вызова: ' . (($reasonrig_form != 'no')?$reasonrig_form:'все')); //выбранный область и район

          /* устанавливаем бордер ячейкам */
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        if(!empty($result)){



     foreach ($result as $row) {



          $arr_trunk= explode('~', $row['trunk']);

          if(isset($arr_trunk) && !empty($arr_trunk) ){
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
                    $sheet->setCellValue('I' . $r, ($locorg_name.', '.$pasp_name));
                    $sheet->setCellValue('J' . $r, $time_pod);
                    $sheet->setCellValue('K' . $r, $trunk_name);
                    $sheet->setCellValue('L' . $r, $cnt);
                    $sheet->setCellValue('M' . $r, $water);


                    $r++;
          }
                }
          }
        }



        $sheet->getStyleByColumnAndRow(0, 8, 22, $r - 1)->applyFromArray($styleArray);



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
        $archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');

        foreach ($archive_year as $value) {
            $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
            $archive_year_1[] = $value;
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

        /* select data from bd. */
        $id_rig = $app->request()->post('id_rig');
        $table_name_year = $app->request()->post('archive_year');

        $data=getCardByIdRig($table_name_year,$id_rig);



        $bread_crumb = array('Архив', 'Поиск по ID выезда');
        $data['bread_crumb'] = $bread_crumb;
        $data['title'] = 'Архив.Поиск по ID выезда';


        if (empty($data['result'])) {//no results

            $data['result_search_empty'] = 1;

            $archive_year = R::getAll('SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA="jarchive" ');
            foreach ($archive_year as $value) {
                $value['max_date'] = R::getCell('SELECT MAX(a.date_msg) as max_date FROM jarchive.' . $value['table_name'] . ' AS a  ');
                $archive_year_1[] = $value;
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
});

 $app->get('/no_permission', function () use ($app) {

        $bread_crumb = array('Архив', 'Параметры');
        $data['bread_crumb'] = $bread_crumb;
         $data['title']='Журнал ЦОУ. Архив';


        $app->render('layouts/header.php',$data);
       $data['path_to_view'] = 'archive_1/no_permission.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');



    });



/* ------------------------- END  Archive Журнал ЦОУ ------------------------------- */



/*-------- card of rig by id - link from journal rigtable, from archive rigtable -------*/
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
/*------ END card of rig by id - link from journal rigtable -------*/


/* ------------------------- diagram ------------------------------- */

$app->group('/diagram', 'is_login', function () use ($app, $log) {


    $app->get('/diag1', function () use ($app) {

        $data['title']='Диаграммы/Диаграмма1';

        $bread_crumb = array('Диаграммы', 'Диаграмма1');
        $data['bread_crumb'] = $bread_crumb;

  /*         * *** Данные **** */
        $x=0;//всего
                $y=34;//причины выезда - пожар
                $z=14;//drugie zagorania


        $umchs_vsego = R::getAssoc("CALL `diag1_umchs`('{$x}');");   //всего


        $umchs_fair = R::getAssoc("CALL `diag1_umchs`('{$y}');");//пожары
        $data['umchs_fair'] = $umchs_fair;

        $umchs_other = R::getAssoc("CALL `diag1_umchs`('{$z}');");//drugie zagorania
        $data['umchs_other'] = $umchs_other;

        foreach ($umchs_fair as $row) {
            $v = $row['vsego'];
            $id_region = $row['region_id'];
            $f[$id_region]=$v;
        }
       // print_r($f);echo '<br><br>';
        foreach ($umchs_vsego as $key=>$row) {
            $v=$row['vsego'];
            $id_region=$row['region_id'];
            $umchs_vsego[$key]['end']=$v-$f[$id_region];
        }
         $data['umchs_vsego'] = $umchs_vsego; //всего по областям



        //РОСН,УГЗ, АВИАЦИЯ
        $cp_vsego = R::getAssoc("CALL `diag1_cp`('{$x}');");//всего


        $cp_fair = R::getAssoc("CALL `diag1_cp`('{$y}');");//пожары
        $data['cp_fair'] = $cp_fair;

        $cp_other = R::getAssoc("CALL `diag1_cp`('{$z}');");//drugie zagorania
        $data['cp_other'] = $cp_other;



        foreach ($cp_fair as $key=>$row) {
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

        $min_d=R::getCell('SELECT MIN(r.`time_msg`) FROM rig AS r WHERE r.`time_msg` > "0000-00-00 00:00:00" and r.`is_delete`=0 '
            . 'and date_format(r.time_msg,"%Y") = ?',array(date('Y')));
        $max_d=R::getCell('SELECT MAX(r.`time_msg`) FROM rig AS r WHERE r.`time_msg`<=NOW() and r.`is_delete`=0');
        $data['min_d']=$min_d;
        $data['max_d']=$max_d;

        /*         * *** КОНЕЦ Данные **** */

        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'diagram/diag1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

/* ------------------------- END diagram ------------------------------- */


/* ------------------------- chart ------------------------------- */

$app->group('/chart', 'is_login', function () use ($app, $log) {


    $app->get('/last_week', function () use ($app) {

        $data['title']='Круговые диаграммы/Распределение выездов за текущую неделю в разрезе причин';

        $bread_crumb = array('Круговые диаграммы', 'Распределение выездов за текущую неделю в разрезе причин');
        $data['bread_crumb'] = $bread_crumb;


$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
$monday_next = date( 'Y-m-d', strtotime( 'monday next week' ) );


 $date1 = new DateTime($monday);
$date1_f = $date1->Format('d.m.Y');

 $date2 = new DateTime($monday_next);
$date2_f = $date2->Format('d.m.Y');

$data['monday']=$date1_f;
$data['monday_next']=$date2_f;

//$monday ='2018-12-01';
//$monday_prev = '2018-12-05';


        $cnt = R::getAssoc("CALL `cnt_reasonrig_by_period`('{$monday}','{$monday_next}');");

//        $cnt_uborka = R::getAssoc("CALL `cnt_reasonrig_by_period_by_id_reason`('{$monday}','{$monday_next}',81);");
//
//        if (empty($cnt_uborka)) {
//            $cnt_uborka = array("cnt" => 0, "reasonrig_name" => '24 обеспечение ПБ уборочная компания');
//        }

        $data['cnt'] = $cnt;



        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'diagram/chart/last_week.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });
});

/* ------------------------- END chart ------------------------------- */


/* ------------------------- table_close_rigs ------------------------------- */

$app->group('/table_close_rigs', 'is_login', function () use ($app, $log) {


    $app->get('/', function () use ($app) {

        $data['title']='Выезды за сутки';

        $bread_crumb = array('Выезды за сутки');
        $data['bread_crumb'] = $bread_crumb;


$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
$monday_next = date( 'Y-m-d', strtotime( 'monday next week' ) );


 $date1 = new DateTime($monday);
$date1_f = $date1->Format('d.m.Y');

 $date2 = new DateTime($monday_next);
$date2_f = $date2->Format('d.m.Y');

$data['monday']=$date1_f;
$data['monday_next']=$date2_f;

//$monday ='2018-12-01';
//$monday_prev = '2018-12-05';


$date_start=date('Y-m-d');
$date = new \DateTime();
$date->modify('+1 day');
$date_end=$date->format('Y-m-d');



        $rig_m = new Model_Rigtable();
        $rig_m->setStartEndDates($date_start,$date_end);

        $cp = array('РОСН'=>8, 'УГЗ'=>9, 'Авиация'=>12); //rosn, ugz,avia tabs

        $obl=array('Брестская область'=>1, 'Витебская область'=>2,'Гомельская область'=>4,'Гродненская область'=>5,'г. Минск'=>3,'Минская область'=>6,'Могилевская область'=>7);

        $rigs=array();

        foreach ($obl as $key=>$value) {

            $vsego=$rig_m->selectAllByIdRegion($value, 0, 0);
            $rigs[$value]['name']=$key;
            $rigs[$value]['vsego']=count($vsego);//without CP
            //print_r($vsego);            echo '<br><br>';
            //pogar


            $counts_1 = array_count_values(array_column($vsego, 'id_reasonrig'));
//print_r($counts_1);            echo '<br>';
            $rigs[$value]['pogar']=(isset($counts_1[34])) ? $counts_1[34]:0;
            $rigs[$value]['hs']=(isset($counts_1[73])) ? $counts_1[73]:0;
            $rigs[$value]['uborka']=(isset($counts_1[81])) ? $counts_1[81]:0;
            $rigs[$value]['other']=$rigs[$value]['vsego']-$rigs[$value]['pogar']-$rigs[$value]['hs']-$rigs[$value]['uborka'];

        }

        foreach ($cp as $key=>$value) {
             $vsego=$rig_m->selectAllByIdOrgan($value, 0);//for all organ


            $rigs[$value]['name']=$key;
            $rigs[$value]['vsego']=count($vsego);//without CP

            //pogar
            $counts_1 = array_count_values(array_column($vsego, 'id_reasonrig'));

            $rigs[$value]['pogar']=(isset($counts_1[34])) ? $counts_1[34]:0;
            $rigs[$value]['hs']=(isset($counts_1[73])) ? $counts_1[73]:0;
            $rigs[$value]['uborka']=(isset($counts_1[81])) ? $counts_1[81]:0;
            $rigs[$value]['other']=$rigs[$value]['vsego']-$rigs[$value]['pogar']-$rigs[$value]['hs']-$rigs[$value]['uborka'];


        }
$data['rigs']=$rigs;
//exit();
$itogo=array('vsego'=>0,'pogar'=>0,'hs'=>0,'other'=>0,'uborka'=>0);
foreach ($rigs as $value) {
    $itogo['vsego']+=$value['vsego'];
    $itogo['pogar']+=$value['pogar'];
    $itogo['hs']+=$value['hs'];
    $itogo['uborka']+=$value['uborka'];
    $itogo['other']+=$value['other'];
}
$data['itogo']=$itogo;
 //echo $counts_2;
//print_r($itogo);
 //exit();
       // print_r($rigs);exit();
        //$cnt = R::getAssoc("CALL `cnt_reasonrig_by_period`('{$monday}','{$monday_next}');");
       // $data['cnt'] = $cnt;

//exit();


        $app->render('layouts/header.php',$data);
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

        $data['title']='Экспорт в csv';

        $bread_crumb = array('Экспорт в csv');
        $data['bread_crumb'] = $bread_crumb;

        $data['export_csv_rep1']=1;

        $reasonrig = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig->selectAll(0);


        $app->render('layouts/header.php',$data);
        $data['path_to_view'] = 'csv/export/form_rep1.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/footer.php');
    });

    /* report 1: by date and vid of rig */
    $app->post('/:rep', function ($rep) use ($app) {

        $data['title']='Экспорт в csv/Результат';

        $bread_crumb = array('Экспорт в csv/Результат');
        $data['bread_crumb'] = $bread_crumb;

        $data['export_csv_rep1']=1;


        $reasonrig = new Model_Reasonrig();
        $data['reasonrig'] = $reasonrig->selectAll(0);

        /* post date */
        $rig_m = new Model_Rigtable();
        $post_date = $rig_m->getPOSTData(); //даты для фильтра

//        $post_id_reasonrig = (isset($_POST['id_reasonrig']) && !empty($_POST['id_reasonrig'])) ? $_POST['id_reasonrig'] : 0;
//        if ($post_id_reasonrig != 0)
//            $post_date['id_reasonrig'] = $post_id_reasonrig;

        $post_id_reasonrig=array(14,18,33,34,38,41,70,73,74,76,78);

        $post_date['id_reasonrig'] = $post_id_reasonrig;
        /* vid for reasonrig */
        $reasonrig_vid = R::getAll('select * from reasonrig where id IN ('. implode(',', $post_id_reasonrig).')');

        $arr_vid=array();

        foreach ($reasonrig_vid as $value) {
            $arr_vid[$value['id']]=$value['vid'];
        }

        //print_r($arr_vid);
        $data['reasonrig_vid']=$arr_vid;


        $post_limit = (isset($_POST['limit']) && !empty($_POST['limit'])) ? $_POST['limit'] : 0;
        $post_date['limit'] = $post_limit;


        $rigs = $rig_m->selectAllForCsv(0,$post_date); //all rigs
//REPLACE(address,CHAR(13)+CHAR(10)," ") AS address_1,


        if(!empty($rigs)){
             /* export to csv */
        $inf = array();
        foreach ($rigs as $row) {
            $reasonrig_name=trim(stristr($row['reasonrig_name'], ' '));



            //$arr_inf_detail= explode(' ', str_replace("\n",'',trim($row['inf_detail_1'])));
            //$arr_inf_detail= explode('.', str_replace("\n",'',$row['inf_detail_1']));

            //$array = array_filter($arr_inf_detail, function($item) { return !empty($item[0]); });
           // $array = array_filter($arr_inf_detail);

//            $detail='';
//            if(!empty($arr_inf_detail)){
//
//                foreach ($arr_inf_detail as $value) {
//                    $n= str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($value));
//                    $detail=$detail.' '.$n;
//                }
//            }



             $detail_1= trim(str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row['inf_detail_1'])));
             $detail=substr ($detail_1, 0, strrpos($detail_1, '.')).'.';//cut before last .

             if($detail == '.'){
                $detail_2= trim(str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row['inf_detail_1'])));
                 $detail= trim(str_replace(array('"',"'",";"), ' ',  strip_tags($detail_2)));

             }
             else{
                 $detail= trim(str_replace(array('"',"'",";"), ' ',  strip_tags($detail)));
             }


             /* vid */
             $vid=(isset($arr_vid[$row['id_reasonrig']])) ? $arr_vid[$row['id_reasonrig']] : 0;


            $inf[] = array('lat' => $row['latitude'], 'lon' => $row['longitude'], 'date_msg' => date('d.m.Y', strtotime($row['date_msg'])), 'address' => $row['address'], 'inf_detail' => $detail, 'vid' => $vid);
        }
       // print_r($inf);exit();



        $csv = new ParseCsv\Csv('data.csv');
       // $csv->encoding( 'UTF-8');
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

        if ($csv->save($path . '/ex_jor.csv',true)) {
            $data['is_save'] = array('success','Выезды успешно сохранены в папку 172.26.200.14/www/out/. Имя файла ex_jor.csv. ');
        } else {
            $data['is_save'] = array('danger','Что-то пошло не так. ');
        }
        }
        else{
            $data['is_save'] = array('danger','Данные, удовлетворяющие запросу, отсутствуют. ');
        }

        $app->render('layouts/header.php',$data);
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
$app->group('/remark',  function () use ($app, $log) {


    $app->get('/', function () use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;

        $data['remarks'] = R::getAll('select r.*, t.name as type_user,t2.name as type_rcu_admin,
            s.name as status_rcu_admin, s.color as color_type_rcu, s.id as status_id  from remark as r
left join remark_type as t on t.id=r.type_user
left join remark_status as s on s.id=r.status_rcu_admin
left join  remark_type as t2 on t2.id=r.type_rcu_admin WHERE r.is_delete = ?',array(0));

        $data['max_date']=R::getCell('select max(date_insert) from remark  ');


        $data['remark_type']=R::getAll('select * from remark_type');
        $data['remark_status']=R::getAll('select * from remark_status');

        $app->render('layouts/remark/header.php', $data);

        if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
            $data['path_to_view'] = 'remark/remark_rcu_admin.php';
        } else {
            $data['path_to_view'] = 'remark/remark.php';
        }



        if(isset($_SESSION['save_remark']) && $_SESSION['save_remark'] == 1){
            $data['save_remark']=1;
            unset($_SESSION['save_remark']);
        }

        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php',$data);

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

        $param=array();

        $is_where =  ' r.is_delete = ?  ';
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


        if(!empty($is_where)){
            $sql=$sql.$is_where;
        }


        $data['remarks']= R::getAll($sql, $param);

        $data['max_date']=R::getCell('select max(date_insert) from remark  ');


                $data['remark_type']=R::getAll('select * from remark_type');
        $data['remark_status']=R::getAll('select * from remark_status');

        $app->render('layouts/remark/header.php', $data);

        if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
            $data['path_to_view'] = 'remark/remark_rcu_admin.php';
        } else {
            $data['path_to_view'] = 'remark/remark.php';
        }



        if(isset($_SESSION['save_remark']) && $_SESSION['save_remark'] == 1){
            $data['save_remark']=1;
            unset($_SESSION['save_remark']);
        }

        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');

    });



    $app->get('/remark_form', function () use ($app) {

        $data['title'] = 'Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;


        $data['remark_type']=R::getAll('select * from remark_type');
        $data['remark_status']=R::getAll('select * from remark_status');

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


        $data['remark_type']=R::getAll('select * from remark_type');
        $data['remark_status']=R::getAll('select * from remark_status');
        $data['remark']=R::getAll('select * from remark where id = ?',array($id));
        $data['id_remark']=$id;

        $app->render('layouts/remark/header.php', $data);

        /* user is login */
        if (isset($_SESSION['id_user']) || isset($_SESSION['id_ghost'])) {

             if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1) {//admin rcu
                  $data['path_to_view'] = 'remark/edit_form_rcu_admin.php';
             }
             else{
                 $data['path_to_view'] = 'remark/edit_form.php';
             }

        }  else {
           $app->redirect(BASE_URL . '/remark');
        }


        $app->render('layouts/remark/div_wrapper.php', $data);
        $app->render('layouts/remark/footer.php');
    });


    $app->get('/auth/:sign', function ($sign) use ($app) {

        $data['title']='Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;

        $app->render('layouts/remark/header.php',$data);

        $data['remark_type']=R::getAll('select * from remark_type');

        /*  login from journal  */
        if($sign == 1){
            $app->redirect(BASE_URL . '/remark/remark_login');
        }
         /*  login as ghost  */
        else{
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


    $app->post('/remark_save/(:id)', function ($id=0) use ($app) {

        $data['title']='Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;

       // print_r($_POST);
       // print_r($_FILES['userfile']);

        //exit();

        $is_file=$app->request()->post('is_file');
         $is_file = (isset($is_file)) ? $is_file : 0;
         //echo $is_file;exit();

         $errors = array();

        if (isset($_FILES['userfile']) && !empty($_FILES['userfile']) && $_FILES['userfile']['error']==0 && $is_file == 0) {


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

            $allowed_extension = array('doc', 'docx', 'txt', 'xls', 'xlsx', 'jpg', 'png');

            $uploadOk = 1;

            $file_size = $_FILES['file']['size'];


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
                        unlink($file_name_for_delete);
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

            //echo $extens;
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
        }
        else{

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
             if (file_exists($file_name_for_delete)) {
            unlink($file_name_for_delete);
             }
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

        //

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

        $data['title']='Книга замечаний';

        $bread_crumb = array('Книга замечаний');
        $data['bread_crumb'] = $bread_crumb;


        $input = filter_input_array(INPUT_POST);


        $id=$input['id'];



        /* edit */
        if($input['action'] == 'edit'){


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
        }
        elseif($input['action'] == 'delete'){
            if ($id != 0) {
            deleteRemark($id);
            }
        }
                elseif($input['action'] == 'restore'){
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
});

function saveRemark($array,$id){
            $remark = R::load('remark', $id);

            if ($id == 0) {//insert
                $array['date_insert'] = date("Y-m-d H:i:s");
            }
            else{
                if(isset($array['id_journal_user'])){
                    unset($array['id_journal_user']);
                }
                elseif(isset ($array['id_ghost'])){
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
    $remark->is_delete=1;
    //R::trash($remark);
R::store($remark);
    $_SESSION['save_remark'] = 1;
}
function restoreRemark($id)
{
    $remark = R::load('remark', $id);
    $remark->is_delete=0;
    //R::trash($remark);
R::store($remark);
    $_SESSION['save_remark'] = 1;
}
/* END remark book */


function getSettingsUser()
{
    $settings_user_bd = R::getAll('SELECT  s.name, s.`type` as setting_type, st.id as type_id,st.name_sign
 FROM settings_user su
 left join settings_type as st on su.id_settings_type=st.id
 left join settings as s on s.id=st.id_setting WHERE su.id_user = ?', array($_SESSION['id_user']));
    $settings_user = array();
    foreach ($settings_user_bd as $value) {
        $settings_user[$value['setting_type']] = $value;
    }
    return $settings_user;
}



function getSilyForType2($sily_mchs)
{
    $teh_mark=array();
        $exit_time=array();
        $arrival_time=array();
        $follow_time=array();
        $end_time=array();
        $return_time=array();
        $distance=array();

        foreach ($sily_mchs as $id_rig=>$row) {

            foreach ($row as $si) {
         //$teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b> - '.$si['locorg_name'].', '.$si['pasp_name'];
         $teh_mark[$id_rig][]='<b>' . $si['mark'] . '</b>, '.$si['pasp_name'];
         $exit_time[$id_rig][]=(isset($si['time_exit']) && !empty($si['time_exit'])) ? date('H:i', strtotime($si['time_exit'])) : '-';
         $arrival_time[$id_rig][]=(isset($si['time_arrival']) && !empty($si['time_arrival'])) ? date('H:i', strtotime($si['time_arrival'])) : '-';
         $follow_time[$id_rig][]=(isset($si['time_follow']) && !empty($si['time_follow'])) ? date('H:i', strtotime($si['time_follow'])) : '-';
         $end_time[$id_rig][]=(isset($si['time_end']) && !empty($si['time_end'])) ? date('H:i', strtotime($si['time_end'])) : '-';
         $return_time[$id_rig][]=(isset($si['time_return']) && !empty($si['time_return'])) ? date('H:i', strtotime($si['time_return'])) : '-';
         $distance[$id_rig][]=(isset($si['distance']) && !empty($si['distance'])) ? $si['distance'] : '-';
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



function getEmptyFields($rigs){



    foreach ($rigs as $key=>$value) {
        $error=array();
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

        $rigs[$key]['empty_fields']=$error;
    }
   // print_r($rigs);exit();
    return $rigs;
}




/* select data from bd. card by id rig. archive_1 */
function getCardByIdRig($table_name_year,$id_rig){
     $sql = ' SELECT * FROM jarchive.' . $table_name_year . '  WHERE  id_rig = ' . $id_rig;

        $result = R::getAll($sql);
        $r=array();


        $i=0;
        foreach ($result as $value) {
            $r['id_rig']=$value['id_rig'];
             $r['date_msg']=$value['date_msg'];
             $r['time_msg']=$value['time_msg'];
             $r['time_loc']=$value['time_loc'];
             $r['time_likv']=$value['time_likv'];
             $r['address']=(empty($value['address'])) ? ((!empty($value['additional_field_address'])) ? $value['additional_field_address'] : '') : $value['address'];

              $r['is_address']=(empty($value['address'])) ? 0 : 1;

             $r['inf_region']=array();
             if(strpos($value['region_name'], "г.") === 0)
             $r['region_name']='';
             else
                 $r['region_name']=$value['region_name'].' область';

             if(strpos($value['local_name'], "г.") === 0)
             $r['local_name']='';
             else
                 $r['local_name']=$value['local_name'].' район';

             if(!empty($r['region_name']))
                 $r['inf_region'][]=$r['region_name'];
             if(!empty($r['local_name']))
                 $r['inf_region'][]=$r['local_name'];

             $r['inf_additional_field']=array();
             if(!empty($value['additional_field_address']))
                 $r['inf_additional_field'][]=$value['additional_field_address'];
                          if($value['is_opposite'] == 1)
                 $r['inf_additional_field'][]='напротив';







             $r['reasonrig_name']=($value['reasonrig_name'] == 'не выбрано') ? '' : (stristr($value['reasonrig_name'], ' '));
             $r['view_work']=($value['view_work'] == 'не выбрано') ? '' : $value['view_work'];
             $r['firereason_name']=($value['firereason_name'] == 'не выбрано') ? '' : $value['firereason_name'];
             $r['inspector']=(empty($value['inspector']) || $value['inspector'] == '') ? '' : $value['inspector'];



             $r['description']=(empty($value['description']) || $value['description'] == '') ? '' : $value['description'];
             $r['inf_detail']=(empty($value['inf_detail']) || $value['inf_detail'] == '') ? '' : $value['inf_detail'];
             $r['firereason_description']=(empty($value['firereason_description']) || $value['firereason_description'] == '') ? '' : $value['firereason_description'];



             $r['people']=(empty($value['people']) || $value['people'] == '') ? '' : $value['people'];
              $r['object']=(empty($value['object']) || $value['object'] == '') ? '' : $value['object'];
              $r['office_name']=($value['office_name'] == 'не выбрано') ? '' : $value['office_name'];

               $r['latitude']=(empty($value['latitude'] ) || $value['latitude'] == 0 || $value['latitude']  == NULL) ? '' : $value['latitude'];
               $r['longitude']=(empty($value['longitude'] ) || $value['longitude'] == 0 || $value['longitude']  == NULL) ? '' : $value['longitude'];

                $r['google_link']='';
                $r['yandex_link']='';
                $r['coord_link']=array();

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
            $is_likv_before=($value['is_likv_before_arrival'] == 0)?'нет':'да' ;
            $arr_silymchs = explode('~', $value['silymchs']);

            $silymchs=array();

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


                    $numbsign_part= explode('$', $arr_time[0]);
                    $numbsign=$numbsign_part[0];
                    $podr_part= explode('%', $numbsign_part[1]);
                    $podr=$podr_part[0].', '.$podr_part[1];


                    /* all  after ? explode.  exit,arrival......is_return */
                    $each_time = explode('&', $arr_time[1]);
                    $t_exit = (!empty($each_time[0]) && $each_time[0] != '-') ? date('H:i', strtotime($each_time[0])) : '-';
                    $t_arrival = (!empty($each_time[1]) && $each_time[1] != '-') ? date('H:i', strtotime($each_time[1])) : '-';
                    $t_follow =(!empty($each_time[2]) && $each_time[2] != '-') ? date('H:i', strtotime($each_time[2])) : '-';
                    $t_end = (!empty($each_time[3]) && $each_time[3] != '-') ? date('H:i', strtotime($each_time[3])) : '-';
                    $t_return = (!empty($each_time[4]) && $each_time[4] != '-') ? date('H:i', strtotime($each_time[4])) : '-';
                    $t_distance = $each_time[5];
                    $t_is_return = ($each_time[6] == 0) ? 'нет' : 'да';



                    $row_data=array('mark'=>$mark,'numbsign'=>$numbsign,'podr'=>$podr,'time_msg'=>date('H:i', strtotime($value['time_msg'])), 't_exit'=>$t_exit,
                       't_arrival'=>$t_arrival, 'is_likv_before'=>$is_likv_before,'t_end'=>$t_end, 't_return'=>$t_return,'t_follow'=>$t_follow,
                        't_distance'=>$t_distance,'t_is_return'=>$t_is_return);

                    $silymchs[]=$row_data;
                }
            }
             $data['silymchs'] = $silymchs;



             /* inner service */

             $innerservice=array();

   $arr = explode('~', $value['innerservice']);

            foreach ($arr as $row) {

                if (!empty($row)) {
                    $i++;
                    $arr_name = explode('#', $row);
                    /* fio - before # */
                    $service_name = $arr_name[0];

                    /* all  after # explode. time_msg,time_exit.... */
                    $each_time = explode('&', $arr_name[1]);

                    $t_msg =(!empty($each_time[0]) && $each_time[0] != '-') ? date('H:i', strtotime($each_time[0])) : '-';
                    $t_arrival = (!empty($each_time[1]) && $each_time[1] != '-') ? date('H:i', strtotime($each_time[1])) : '-';

                    $note = explode('%', $each_time[2]);

                    $t_distance = $note[0];
                    $t_note = $note[1];


                    $row_data=array('service_name'=>$service_name,'time_msg'=>$t_msg,
                       't_arrival'=>$t_arrival,
                        't_distance'=>$t_distance,'note'=>$t_note);

                    $innerservice[]=$row_data;
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

                   $t_msg =(!empty($each_time[0]) && $each_time[0] != '-') ? date('H:i', strtotime($each_time[0])) : '-';
                    $t_exit = (!empty($each_time[1]) && $each_time[1] != '-') ? date('H:i', strtotime($each_time[1])) : '-';
                    $t_arrival = (!empty($each_time[2]) && $each_time[2] != '-') ? date('H:i', strtotime($each_time[2])) : '-';

                    $row_data = array('fio' => $fio, 'time_msg'     => $t_msg, 't_exit'    => $t_exit,
                        't_arrival'    => $t_arrival);

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
                $results_battle['save_an'] = $arr[5];
                $results_battle['save_plan'] = $arr[6];
                $results_battle['save_build'] = $arr[7];
                $results_battle['save_teh'] = $arr[8];
            }
        }
        $data['results_battle'] = $results_battle;
    }

       // print_r($silymchs);exit();


        $data['result'] = $r;

        return $data;
}


/* select data from bd. card by id rig. rigtable journal */
function getCardByIdRigFromJournal($id_rig){
     $sql = ' SELECT * FROM rigtable  WHERE  id = ' . $id_rig;

        $result = R::getAll($sql);
        $r=array();


        $i=0;
        foreach ($result as $value) {
            $r['id_rig']=$value['id'];
             $r['date_msg']=$value['date_msg'];
             $r['time_msg']=date('H:i', strtotime($value['time_msg']));
             $r['time_loc']=$value['time_loc'];
             $r['time_likv']=$value['time_likv'];
             $r['address']=(empty($value['address'])) ? ((!empty($value['additional_field_address'])) ? $value['additional_field_address'] : '') : $value['address'];

              $r['is_address']=(empty($value['address'])) ? 0 : 1;

             $r['inf_region']=array();
             if(strpos($value['region_name'], "г.") === 0)
             $r['region_name']='';
             else
                 $r['region_name']=$value['region_name'].' область';

             if(strpos($value['local_name'], "г.") === 0)
             $r['local_name']='';
             else
                 $r['local_name']=$value['local_name'].' район';

             if(!empty($r['region_name']))
                 $r['inf_region'][]=$r['region_name'];
             if(!empty($r['local_name']))
                 $r['inf_region'][]=$r['local_name'];

             $r['inf_additional_field']=array();
             if(!empty($value['additional_field_address']))
                 $r['inf_additional_field'][]=$value['additional_field_address'];
                          if($value['is_opposite'] == 1)
                 $r['inf_additional_field'][]='напротив';


             $r['reasonrig_name']=($value['reasonrig_name'] == 'не выбрано') ? '' : (stristr($value['reasonrig_name'], ' '));
             $r['view_work']=($value['view_work'] == 'не выбрано') ? '' : $value['view_work'];
             $r['firereason_name']=($value['firereason_name'] == 'не выбрано') ? '' : $value['firereason_name'];
             $r['inspector']=(empty($value['inspector']) || $value['inspector'] == '') ? '' : $value['inspector'];



             $r['description']=(empty($value['description']) || $value['description'] == '') ? '' : $value['description'];
             $r['inf_detail']=(empty($value['inf_detail']) || $value['inf_detail'] == '') ? '' : $value['inf_detail'];
             $r['firereason_description']=(empty($value['firereason_description']) || $value['firereason_description'] == '') ? '' : $value['firereason_description'];




              $r['object']=(empty($value['object']) || $value['object'] == '') ? '' : $value['object'];
              $r['office_name']=($value['office_name'] == 'не выбрано') ? '' : $value['office_name'];

               $r['latitude']=(empty($value['latitude'] ) || $value['latitude'] == 0 || $value['latitude']  == NULL) ? '' : $value['latitude'];
               $r['longitude']=(empty($value['longitude'] ) || $value['longitude'] == 0 || $value['longitude']  == NULL) ? '' : $value['longitude'];

                $r['google_link']='';
                $r['yandex_link']='';
                $r['coord_link']=array();

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
            $people= R::getAll('select * from people where id_rig = ?',array($id_rig));
            $arr_people=array();
            if(!empty($people)){
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


         $r['people']=(empty($arr_people) ) ? '' : implode(', ', $arr_people);

            /* sily mchs */
            $is_likv_before=($value['is_likv_before_arrival'] == 0)?'нет':'да' ;
            $arr_silymchs = R::getAll('select * from jrig where id_rig = ?',array($id_rig));

            $silymchs=array();

            // 1 car
            foreach ($arr_silymchs as $row) {
               // $row_data=array();
                if (!empty($row)) {
                    $i++;

                    $mark = $row['mark'];

                    $numbsign=$row['numbsign'];
                    $podr=$row['locorg_name'].', '.$row['pasp_name'];


                    /* all  after ? explode.  exit,arrival......is_return */
                    $t_exit = (!empty($row['time_exit']) && $row['time_exit'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_exit'])) : '-';
                    $t_arrival = (!empty($row['time_arrival']) && $row['time_arrival'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_arrival'])) : '-';
                    $t_follow =(!empty($row['time_follow']) && $row['time_follow'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_follow'])) : '-';
                    $t_end = (!empty($row['time_end']) && $row['time_end'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_end'])) : '-';
                    $t_return =(!empty($row['time_return']) && $row['time_return'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_return'])) : '-';
                    $t_distance = (!empty($row['distance'])) ? $row['distance'] : '0';
                    $t_is_return = ($row['is_return'] == 0) ? 'нет' : 'да';



                    $row_data=array('mark'=>$mark,'numbsign'=>$numbsign,'podr'=>$podr,'time_msg'=>date('H:i', strtotime($value['time_msg'])), 't_exit'=>$t_exit,
                       't_arrival'=>$t_arrival, 'is_likv_before'=>$is_likv_before,'t_end'=>$t_end, 't_return'=>$t_return,'t_follow'=>$t_follow,
                        't_distance'=>$t_distance,'t_is_return'=>$t_is_return);

                    $silymchs[]=$row_data;
                }
            }
             $data['silymchs'] = $silymchs;


//
//             /* inner service */

             $innerservice=array();

            $innerservice_m = new Model_Innerservice();
            $arr = $innerservice_m->selectAllForCard($id_rig);

            foreach ($arr as $row) {

                if (!empty($row)) {
                    $i++;

                    /* fio - before # */
                    $service_name = $row['service_name'];

                    /* all  after # explode. time_msg,time_exit.... */

                    $t_msg =(!empty($row['time_msg']) && $row['time_msg'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_msg']))  : '-';
                    $t_arrival = (!empty($row['time_arrival']) && $row['time_arrival'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_arrival']))  : '-';


                    $t_distance = (!empty($row['distance'])) ? $row['distance'] : '0';
                    $t_note = $row['note'];


                    $row_data=array('service_name'=>$service_name,'time_msg'=>$t_msg,
                       't_arrival'=>$t_arrival,
                        't_distance'=>$t_distance,'note'=>$t_note);

                    $innerservice[]=$row_data;
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

                $t_msg = (!empty($row['time_msg']) && $row['time_msg'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_msg']))  : '-';
                $t_exit = (!empty($row['time_exit']) && $row['time_exit'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_exit'])) : '-';
                $t_arrival = (!empty($row['time_arrival']) && $row['time_arrival'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($row['time_arrival'])) : '-';

                $row_data = array('fio' => $fio, 'time_msg'     => $t_msg, 't_exit'    => $t_exit,
                        't_arrival'    => $t_arrival);

                    $informing[] = $row_data;
                }
            }
             $data['informing'] = $informing;



             /* result battle */
             $result_battle=R::getRow('select * from results_battle where id_rig = ?',array($id_rig));
             $data['results_battle']=$result_battle;
        }

       // print_r($silymchs);exit();


        $data['result'] = $r;

        return $data;
}



/* ----------- results battle -------------- */
$app->group('/results_battle', function () use ($app,$log) {
    // view form
    $app->get('/:id_rig(/:is_success)', function ($id_rig,$is_success=0) use ($app) {


        $bread_crumb = array('Результаты боевой работы');
        $data['settings_user'] = getSettingsUser();



         /* --------- добавить инф о редактируемом вызове ------------ */
        $rig_table_m = new Model_Rigtable();
        $inf_rig = $rig_table_m->selectByIdRig($id_rig); // дата, время, адрес объекта для редактируемого вызова по id
        if ($id_rig != 0) {


            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];

                    $data['id_user'] = $value['id_user'];
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


        $data['title'] = 'Результаты боевой работы';

        $data['id_rig']=$id_rig;


        /* select battle for rig from bd */
        $battle = R::getRow('select * from results_battle WHERE id_rig = ? ', array($id_rig));

        if (isset($battle) && !empty($battle))
            $data['id_battle'] = $battle['id'];
        else
            $data['id_battle'] = 0;

        $data['battle'] = $battle;


        if(isset($is_success))
        $data['is_success']=$is_success;

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/trunk/header.php', $data);
        $data['path_to_view'] = 'results_battle/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/trunk/footer.php');

    });


    $app->post('/:id_rig', function ($id_rig) use ($app) {


        $save_data=array();
        $save_data['dead_man'] = (empty($app->request()->post('dead_man'))) ? 0 : intval($app->request()->post('dead_man'));
        $save_data['dead_child'] = (empty($app->request()->post('dead_child'))) ? 0 : intval($app->request()->post('dead_child'));
        $save_data['save_man'] = (empty($app->request()->post('save_man'))) ? 0 : intval($app->request()->post('save_man'));
        $save_data['inj_man'] = (empty($app->request()->post('inj_man'))) ? 0 : intval($app->request()->post('inj_man'));
        $save_data['ev_man'] = (empty($app->request()->post('ev_man'))) ? 0 : intval($app->request()->post('ev_man'));

        $save_data['save_build'] = (empty($app->request()->post('save_build'))) ? 0 : intval($app->request()->post('save_build'));
        $save_data['dam_build'] = (empty($app->request()->post('dam_build'))) ? 0 : intval($app->request()->post('dam_build'));
        $save_data['des_build'] = (empty($app->request()->post('des_build'))) ? 0 : intval($app->request()->post('des_build'));

        $save_data['save_teh'] = (empty($app->request()->post('save_teh'))) ? 0 : intval($app->request()->post('save_teh'));
        $save_data['dam_teh'] = (empty($app->request()->post('dam_teh'))) ? 0 : intval($app->request()->post('dam_teh'));
        $save_data['des_teh'] = (empty($app->request()->post('des_teh'))) ? 0 : intval($app->request()->post('des_teh'));

        $save_data['save_an'] = (empty($app->request()->post('save_an'))) ? 0 : intval($app->request()->post('save_an'));
        $save_data['dam_an'] = (empty($app->request()->post('dam_an'))) ? 0 : intval($app->request()->post('dam_an'));
        $save_data['des_an'] = (empty($app->request()->post('des_an'))) ? 0 : intval($app->request()->post('des_an'));

        $save_data['save_plan'] = (empty($app->request()->post('save_plan'))) ? 0 : $app->request()->post('save_plan');
        $save_data['dam_plan'] = (empty($app->request()->post('dam_plan'))) ? 0 : $app->request()->post('dam_plan');
        $save_data['des_plan'] = (empty($app->request()->post('des_plan'))) ? 0 : $app->request()->post('des_plan');




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

        $app->redirect(BASE_URL . '/results_battle/'.$id_rig.'/1');
    });
});

/* ----------- END results battle -------------- */




/* ----------- trunk -------------- */
$app->group('/trunk', 'is_login', function () use ($app,$log) {

    /* add new trunk */
    $app->post('/add_trunk_ajax', function () use ($app) {

        $name = $app->request()->post('name');
        //$name = urldecode($name);
        $is_trunk = R::getAll('select * from trunklist where name = ?', array($name));



        if (empty($is_trunk) && $name != '') {

            $trunk = R::dispense('trunklist');
            $save['name'] = $name;
            $save['date_insert'] = date("Y-m-d H:i:s");
            $save['id_user'] = $_SESSION['id_user'];
            $save['last_update'] = date("Y-m-d H:i:s");

            $trunk->import($save);
            $id = R::store($trunk);

            echo json_encode([
                'id'       => $id,
                'message'  => 'Тип был успешно добавлен в БД',
                "tag_name" => $name
                //'removeTagsForm' => getRemoveTagsForm()
            ]);
        }
    });

    /* edit new trunk */
    $app->post('/edit_trunk_ajax', function () use ($app) {

        $name = $app->request()->post('new_name');
        $id = $app->request()->post('id');

        $is_trunk = R::getAll('select * from trunklist where name = ?', array($name));



        if (empty($is_trunk) && $name != '' && !empty($id)) {

            $trunk = R::load('trunklist', $id);
            $save['name'] = $name;
            $save['last_update'] = date("Y-m-d H:i:s");

            $trunk->import($save);
            $id = R::store($trunk);

            echo json_encode([
                //'id' => $id,
                'message'  => 'Редактирование выполнено успешно',
                "tag_name" => $name
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
    $app->get('/:id_rig(/:is_success)', function ($id_rig,$is_success=0) use ($app) {


        $bread_crumb = array('Подача стволов');

         $data['settings_user'] = getSettingsUser();


                           /* --------- добавить инф о редактируемом вызове ------------ */
        $rig_table_m = new Model_Rigtable();
        $inf_rig = $rig_table_m->selectByIdRig($id_rig); // дата, время, адрес объекта для редактируемого вызова по id
        if ($id_rig != 0) {


            if (isset($inf_rig) && !empty($inf_rig)) {
                foreach ($inf_rig as $value) {
                    $date_rig = $value['date_msg'] . ' ' . $value['time_msg'];
                    $adr_rig = (empty($value['address'])) ? $value['additional_field_address'] : $value['address'];

                    $data['id_user'] = $value['id_user'];
                }
                $bread_crumb[] = $date_rig;
                $bread_crumb[] = $adr_rig;
            }


                $rig_m = new Model_Rig();
                $rig = $rig_m->selectAllById($id_rig);
                $data['rig_time']=$rig;
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

        $data['id_rig']=$id_rig;


        /* select silymchs for rig from bd */
        $sily_m = new Model_Jrig();
        $data['sily'] = $sily_m->selectAllByIdRig($id_rig);

        $data['trunk_list']=R::getAll('select * from trunklist ');

        /* trunks for rig */
        $trunk_edit=R::getAll('select tr.*, s.id_teh from trunkrig as tr left join silymchs as s on tr.id_silymchs=s.id where s.id_rig = ? ',array($id_rig));

        /* trunk for delete/edit */
        $data['trunk_for_del']=R::getAll('select * from trunklist  where is_delete = ? and id_user = ? ',array(0,$_SESSION['id_user']));

        $trunk_edit_arr=array();

        if(!empty($trunk_edit)){
        foreach ($trunk_edit as $value) {

            $trunk_edit_arr[$value['id_teh']][]=$value;
        }
        }
        $data['trunk_edit']=$trunk_edit_arr;

        if(isset($is_success))
        $data['is_success']=$is_success;

        $data['bread_crumb'] = $bread_crumb;
        $app->render('layouts/trunk/header.php', $data);
        $data['path_to_view'] = 'trunk/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/trunk/footer.php');

    });


    $app->post('/:id_rig', function ($id_rig) use ($app) {

        //print_r($_POST);        echo '<br><br>';exit();

        $sily=$app->request()->post('sily');


        if(isset($sily) && !empty($sily)){

            foreach ($sily as $id_teh=>$value) {

                $id_silymchs=R::getCell('select id from silymchs where id_rig = ? and id_teh = ?',array($id_rig,$id_teh));

                if(!empty($id_silymchs)){


                    //delete current trunk for rig and car
                    R::exec('DELETE FROM trunkrig  WHERE id_silymchs = ?', array($id_silymchs));

                    //set new trunk

                    $cnt_rows= count($value['time_pod']);
                    for ($j = 0; $j < $cnt_rows; $j++) {

                         $save_sily=array();

                        if (isset($value['trunk'][$j]) && !empty($value['trunk'][$j]) && isset($value['means'][$j]) && !empty($value['means'][$j]) && $value['means'][$j] > 0) {

                            $save_sily['id_silymchs'] = $id_silymchs;
                            $save_sily['time_pod'] = $value['time_pod'][$j];
                            $save_sily['id_trunk_list'] = $value['trunk'][$j];
                            $save_sily['cnt'] = (isset($value['means'][$j]) && !empty($value['means'][$j])) ? intval($value['means'][$j]) : 0;
                            $save_sily['water'] = $value['water'][$j];

                            //save
                            if(!empty($save_sily)){
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
        $save_data=array();

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

        $app->redirect(BASE_URL . '/trunk/'.$id_rig.'/1');
    });




});

/* ----------- END trunk -------------- */


/*--------  guide pasp  --------*/

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
        } elseif ($_SESSION['id_level'] == 3 && in_array($_SESSION['id_organ'], $cp)) {//rosn pinsk, ugz gomel
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
        }
        elseif ($_SESSION['id_level'] == 2 && $_SESSION['id_organ'] == 4 && $_SESSION['id_region'] != 3) {//umchs
            $data['name_table'] = 'Подразделения области';

            //all podr from kusis
            $data['podr'] = R::getAll('select id,pasp_name, locorg_name, latitude, longitude from pasp where id_region = ? and id_organ not in(' . implode(',', $cp) . ')', array($_SESSION['id_region'] ));
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
function is_update_rig_now($rig,$id)
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
function is_update_rig_now_refresh_table($rig,$id)
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
        }
        else{
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

        if (!empty($result)) {
            //  echo $is_update_now;
            $rig[$k]['dead_man'] = $result['dead_man'];
            $rig[$k]['dead_child'] = $result['dead_child'];
            $rig[$k]['save_man'] = $result['save_man'];
            $rig[$k]['inj_man'] = $result['inj_man'];
            $rig[$k]['ev_man'] = $result['ev_man'];
        }
        else{
            $rig[$k]['dead_man'] = 0;
            $rig[$k]['save_man'] = 0;
            $rig[$k]['inj_man'] = 0;
            $rig[$k]['ev_man'] = 0;
        }
        //  exit();
    }
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

    if($is_change == 1){
        $_SESSION['br_table_mode']=1;
    }
    else{
        if(isset($_SESSION['br_table_mode']))
        unset($_SESSION['br_table_mode']);
    }

    $res=1;

    echo json_encode($res);
});
/* ------------- END ajax change mode --------------- */




$app->group('/maps',  function () use ($app) {

     $app->get('/', function () use ($app) {

        $app->render('layouts/maps/header.php');
        $data['path_to_view'] = 'maps/index.php';
        $app->render('layouts/div_wrapper.php', $data);
        $app->render('layouts/maps/footer.php');
     });


          $app->get('/getjson', function () use ($app) {

         /* data for map */
         //$points=R::getAll('select * from rigtable where  latitude is not null and longitude is not null AND latitude <> 0 AND longitude <> 0');

              $rig_m = new Model_Rigtable();
              $points=$rig_m->selectAllRigByReason(array(14,34),0);// only 34-12pogar, 14-04other fires
$res1=array();

         foreach ($points as $value) {
             $res=array();
            $res['location'] = array('type' => 'Point', 'coordinates' => array($value['longitude'],$value['latitude']));
            $res['name'] = $value['reasonrig_name'];
            $res['new_icon'] = 'assets/images/leaflet/coffee.png';
            $res['card_by_rig_url'] = 'card_rig/0/'.$value['id'];

$res1[]=$res;
         }


//
//$res['location']=array('type'=>'Point','coordinates'=>array("27.546803", "53.855383"));
//$res['name']='hh';
//$res['new_icon']='assets/images/leaflet/coffee.png';
//$res1[]=$res;


         $data['points']= json_encode($res1);


         echo $data['points'];
     });

      $app->post('/getjson', function () use ($app) {

         /* data for map */

$res1=array();
$res=array();

$res['location']=array('type'=>'Point','coordinates'=>array("27.546803", "53.855383"));
$res['name']='hh';
//$res['new_icon']='assets/images/leaflet/menu.png';
$res1[]=$res;


         $data['points']= json_encode($res1);


         echo $data['points'];
     });



});


$app->run();
