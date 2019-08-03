<?php
include_once(MODX_BASE_PATH . 'assets/modules/evo_redirects/evoRedirects.php');
$evoRedirects = new evoRedirects($modx);
$url = $_GET['q'];

$check = $evoRedirects->checkRedirect($url);
if (!empty($check)) {

    $url = $check['new_url'];
    if (!empty($check['doc_id']) && is_numeric($check['doc_id'])) {
        $url = $modx->makeUrl($check['doc_id']);
    }

    if (!empty($url)) {
        $modx->sendRedirect($url, 0, 'REDIRECT_HEADER', 'HTTP/1.1 301 Moved Permanently');
    }

}
