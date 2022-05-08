<?php
ini_set('display_errors', '1');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Max-Age: 1728000');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    die();
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require __DIR__ . "/vendor/autoload.php";

//**    INIT APP START
use App\services\Data;
use App\services\Connect;
use App\services\AppInit;
use App\controllers\StockRegisterController;

$data               = new Data();
$connect            = new Connect();
$init               = new AppInit();
$StockRegController = new StockRegisterController();

$databaseSetup  = $data->tableData();
$langs          = $data->langSetup();
$devices        = $data->deviceSetup();
$users          = $data->initDummyUsers();

for ($i=0, $length = count($databaseSetup); $i < $length ; ++$i) { 
    //$init->createTable($databaseSetup[$i]["tablename"], $databaseSetup[$i]["params"]);
}
function insertDataToDb() {
    $init->insertData("users", $users);
    $init->insertData("devices", $devices);
    $init->insertData("langs", $langs);
}
//insertDataToDb();
//**    INIT APP END

$post = json_decode(file_get_contents('php://input'));

if (isset($post)) {
    if (preg_match("/[^A-Za-z'-]/", $post->method )) die("INVALID METHOD NAME SHOULD BE ALPHA!");
    
    switch ($post->method) {
        case 'save':
            $response = $StockRegController->saveDataToDb($post->data);
            break;
        case 'getDevices':
            $StockRegController->getDevicesFromDb($post->data->tablename);
            break;
        
        default:
            break;
    }
}
