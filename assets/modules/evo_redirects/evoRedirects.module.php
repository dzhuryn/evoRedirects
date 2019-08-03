<?php
//создаем модуль и вставляем строку: include_once(MODX_BASE_PATH.'assets/modules/easyImport/easyImport.module.php');
if (IN_MANAGER_MODE != "true" || empty($modx) || !($modx instanceof DocumentParser)) {
    die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
}
if (!$modx->hasPermission('exec_module')) {
    header("location: " . $modx->getManagerPath() . "?a=106");
}

//Подключаем обработку шаблонов через DocLister
include_once(MODX_BASE_PATH.'assets/snippets/DocLister/lib/DLTemplate.class.php');
include_once(MODX_BASE_PATH.'assets/modules/evo_redirects/evoRedirects.php');

$tpl = DLTemplate::getInstance($modx);

$moduleurl = 'index.php?a=112&id='.$_GET['id'].'&';
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

$data = array ('moduleurl'=>$moduleurl, 'manager_theme'=>$modx->config['manager_theme'], 'session'=>$_SESSION, 'action'=>$action , 'selected'=>array($action=>'selected'));


$evoRedirects = new evoRedirects($modx);
$mainTable = $evoRedirects->table;
//выполнение действий
switch ($action) {

    case 'home'://главная страничка вывод и шаблон
        $template = '@CODE:' . file_get_contents(dirname(__FILE__) . '/templates/home.tpl');
        $outTpl = $tpl->parseChunk($template, $data);
        break;

    case 'load':
        $outData = $evoRedirects->getAll();
        break;
    case 'save':
        $webix_operation = !empty($_POST['webix_operation'])?$_POST['webix_operation']:'update';

        $fields = [
            'doc_id' => (int)$_POST['doc_id'],
            'old_url' => $_POST['old_url'],
            'new_url' => $_POST['new_url'],
        ];
        //f
        //екранирум данные
        $id = (int) $_POST['id'];
        $fields = $modx->db->escape($fields);

        switch ($webix_operation){
            case 'insert':
                $newId = $modx->db->insert($fields,$mainTable);
                $outData = ['status'=>'success','newid'=>$newId];
                break;
            case 'delete':
                $modx->db->delete($mainTable,'id = '.$id);
                $outData = ['status'=>'success'];
                break;
            case 'update':
                $modx->db->update($fields,$mainTable,'id = '.$id);
                $outData = ['status'=>'success'];
                break;
        }
        break;
}

// Вывод результата или шаблон или Ajax
if(!is_null($outTpl)){
    $headerTpl = '@CODE:'.file_get_contents(dirname(__FILE__).'/templates/header.tpl');
    $footerTpl = '@CODE:'.file_get_contents(dirname(__FILE__).'/templates/footer.tpl');
    $output = $tpl->parseChunk($headerTpl,$data) . $outTpl . $tpl->parseChunk($footerTpl,$data);
}else{
    header('Content-type: application/json');
    $output = json_encode($outData);

}
echo $output;
?>