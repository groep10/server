<?php

/**
 * Description of db
 *
 * @author Joseph Verburg
 */
class Db extends PDO {

    public function __construct($data) {
        parent::__construct('mysql:host=' . $data['host'] . ';dbname=' . $data['database'] . ';charset=utf8;', $data['username'], $data['password'], array( PDO::ATTR_PERSISTENT => false, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false));
        $this->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    }


    private function buildFields($fields = '*') {
        $f = '';
        if(is_array($fields)) {
            foreach($fields as $field) {
                $f .= ',`'.$field . '`';
            }
            if(strlen($f) != 0)
                $f = substr($f, 1);
        } else {
            $f = $fields;
        }
        return $f;
    }

    public function fetchAll($tablename,$fields = '*', $where = '', array $whereparams = array()) {
        $where = ($where != '' ? (stripos($where, '?') !== false ? ' WHERE ' : ' ') . $where : '' );

        return $this->fetchAllRaw('SELECT ' . $this->buildFields($fields) . ' FROM ' . $tablename . $where, $whereparams);
    }

    public function fetchAllRaw($sql, $params = array()) {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

    /*
     *  $db->fetchRow('table_name', 'fields', 'id = ?', array($id));
     *
     */
    public function fetchRow($tablename,$fields = '*', $where = '', array $whereparams = array()) {
        $where = ($where != '' ? (stripos($where, '?') !== false ? ' WHERE ' : ' ') . $where : '' );

        $stmt = $this->prepare('SELECT ' . $this->buildFields($fields) . ' FROM ' . $tablename . $where);
        $stmt->execute($whereparams);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

    public function insert($tablename, array $values) {
        $i = '';
        foreach($values as $key => $value) {
            $i .= ',?';
        }
        if(strlen($i) != 0) {
            $i = substr($i, 1);
        }

        $stmt = $this->prepare('INSERT INTO ' . $tablename . ' (' . $this->buildFields(array_keys($values)) . ') VALUES (' . $i . ')');
        return $stmt->execute(array_values($values));
    }

    /*
     * $db->update('table_name', array( "new" => true ), 'id = ?', array($id));
     */
    public function update($tablename, $values, $where = '', array $whereparams = array()) {
        $v = '';
        foreach($values as $key => $value) {
            $v .= ',`' . $key . '` = ?';
        }
        if(strlen($v) != 0) {
            $v = substr($v, 1);
        }
        $stmt = $this->prepare('UPDATE ' . $tablename . ' SET ' . $v . ($where != '' ? ' WHERE ' . $where : '' ));
        return $stmt->execute(array_merge(array_values($values), $whereparams));
    }

    public function delete($tablename, $where = '', array $whereparams = array()) {
        $stmt = $this->prepare('DELETE FROM ' . $tablename . ($where != '' ? ' WHERE ' . $where : '' ));
        return $stmt->execute($whereparams);
    }
}

