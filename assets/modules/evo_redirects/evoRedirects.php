<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 002 02.08.19
 * Time: 21:51
 */

class evoRedirects
{

    /** @var $modx DocumentParser */
    private $modx;
    public $table;

    public function __construct($modx)
    {
        $this->modx = $modx;
        $this->table = $this->modx->db->getFullTableName('evo_redirects');
        $this->createTable();
    }

    public function checkRedirect($url){
        $eUrl = $this->modx->db->escape($url);

        return $this->modx->db->getRow(        $this->modx->db->query(
            "select * from $this->table where `old_url` = '$eUrl'"
        ));
    }

    public function addRedirect($oldUrl,$docId=0,$newUrl=''){
        $check = $this->checkRedirect($oldUrl);
        if(!empty($check)) return false;

        $fields = [
            'old_url' => $oldUrl,
            'doc_id' => (int) $docId,
            'new_url' => $newUrl,
        ];
        $fields = $this->modx->db->escape($fields);
        return $this->modx->db->insert($fields,$this->table);

    }
    public function getAll(){
        return $this->modx->db->makeArray($this->modx->db->select('*',$this->table,'','id asc'));
    }
    private function createTable()
    {
        $sql = <<< OUT
        CREATE TABLE IF NOT EXISTS {$this->table} (
          `id` int(4) unsigned NOT NULL auto_increment,
          `doc_id` int(10) unsigned NOT NULL,
          `old_url` varchar(255) NOT NULL,
          `new_url` varchar(255) NOT NULL,
          PRIMARY KEY  (`id`)
        ) ENGINE=MyISAM ;
OUT;

        return $this->modx->db->query($sql);
    }

}