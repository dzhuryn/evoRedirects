## evoRedirects
evoRedirects аналог RedirectMap, был написан по просьбе одного из заказчиков для удобного добавления редиректов.  
Модуль написан на webix с простым интерфейсом.  
Также небольшой класс для удобного добавления и поиска редиректов.  
Есть возможность указать как id документа, так и url.  

```php
include_once(MODX_BASE_PATH.'assets/modules/evo_redirects/evoRedirects.php');
$evoRedirects = new evoRedirects($modx);

$data = $evoRedirects->checkRedirect($url); //вернет информацию по url, если для него есть редирект
$data = $evoRedirects->addRedirect($oldUrl,$docId,$newUrl); //добавить новый редирект
```