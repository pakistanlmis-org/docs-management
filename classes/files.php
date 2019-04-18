<?php

require_once 'database.php';

/**
 * clsStockMaster
 * @package classes
 * 
 * @author     Ajmal Hussain
 * @email <ahussain@ghsc-psm.org>
 * 
 * @version    2.2
 * 
 */
// If it's going to need the database, then it's
// probably smart to require it before we start.
class files {

    // table name
    protected static $table_name = "edoc_files";
    // db connection
    private $conn;
    //db fileds
    protected static $db_fields = array('file_no', 'file_title', 'receive_from', 'file_description', 'file_department', 'status', 'created_date', 'created_by', 'modified_by', 'modified_date');
    public $file_no;
    public $file_title;
    public $receive_from;
    public $file_description;
    public $file_department;
    public $status;
    public $created_date;
    public $created_by;
    public $modified_by;
    public $modified_date;
    public $pk_id;

    public function __construct() {
        $this->conn = new database();
    }

    /**
     * 
     * find_all
     * @return type
     * 
     * 
     */
    public function find_all() {
        return $this->conn->query("SELECT * FROM " . static::$table_name);
    }

    /**
     * 
     * find_by_id
     * @param type $id
     * @return type
     * 
     * 
     */
    public function find_by_id($id = 0) {
        //select query
        $strSql = "SELECT * FROM " . static::$table_name . " WHERE pk_id={$id} LIMIT 1";
        //query result
        return $this->conn->query($strSql);
    }

    /**
     * 
     * find_by_id
     * @param type $id
     * @return type
     * 
     * 
     */
    public function find_by_user($id = 0) {
        //select query
        $strSql = "SELECT
        edoc_files.pk_id,
	edoc_files.file_no,
	edoc_files.`status`,

IF (
	edoc_files.created_date = edoc_files.modified_date,
	'created',
	'transfered'
) iscreated,
edoc_users.username,
DATE_FORMAT(edoc_files.created_date,'%d %M, %Y') created_date,
edoc_departments.`name` file_department,
desk.username ondesk,
edoc_files.receive_from,
edoc_files.file_description
FROM
	edoc_files
INNER JOIN edoc_users ON edoc_files.created_by = edoc_users.pk_id
INNER JOIN edoc_users mod_user ON edoc_files.modified_by = mod_user.pk_id
INNER JOIN edoc_departments ON edoc_files.file_department = edoc_departments.pk_id
INNER JOIN edoc_users AS desk ON edoc_files.modified_by = desk.pk_id";
        //query result
        return $this->conn->query($strSql);
    }

    /**
     * 
     * count_all
     * @global type $this->conn
     * @return type
     * 
     * 
     */
    public function count_all() {
        //select query
        $sql = "SELECT COUNT(*) FROM " . static::$table_name;
        //query result
        $result_set = $this->conn->query($sql);
        $row = $this->conn->fetch_array($result_set);
        return array_shift($row);
    }

    /**
     * 
     * instantiate
     * @param type $record
     * @return \self
     * 
     * 
     */
    private function instantiate($record) {
        // Could check that $record exists and is an array
        $object = new self;
        // Simple, long - form approach:
        // More dynamic, short - form approach:
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    /**
     * 
     * has_attribute
     * @param type $attribute
     * @return type
     * 
     * 
     */
    private function has_attribute($attribute) {
        // We don't care about the value, we just want to know if the key exists
        // Will return true or false
        return array_key_exists($attribute, $this->attributes());
    }

    /**
     * 
     * attributes
     * @return type
     * 
     * 
     */
    protected function attributes() {
        // return an array of attribute names and their values
        $attributes = array();
        foreach (static::$db_fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    /**
     * 
     * sanitized_attributes
     * @global type $this->conn
     * @return type
     * 
     * 
     */
    protected function sanitized_attributes() {
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $this->conn->escape_value($value);
        }
        return $clean_attributes;
    }

    /**
     * 
     * save
     * @return type
     * 
     * 
     */
    public function save() {
        // A new record won't have an id yet.
        return isset($this->pk_id) ? $this->update() : $this->create();
    }

    /**
     * create
     * @global type $this->conn
     * @return boolean
     */
    public function create() {
        // Don't forget your SQL syntax and good habits:
        // - INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single - quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();

        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if ($this->conn->query2($sql)) {
            return $this->conn->insert_id();
        } else {
            return false;
        }
    }

    /**
     * update
     * @global type $this->conn
     * @return type
     */
    public function update() {
        // Don't forget your SQL syntax and good habits:
        // - UPDATE table SET key = 'value', key = 'value' WHERE condition
        // - single - quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach ($attributes as $key => $value) {
            if (isset($value) && !empty($value)) {
                $attribute_pairs[] = "{$key}='{$value}'";
            }
        }
        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE pk_id=" . $this->conn->escape_value($this->pk_id);
        $this->conn->query2($sql);
        return $this->pk_id;
    }

    /**
     * 
     * delete
     * @global type $this->conn
     * @return type
     * 
     * 
     */
    public function delete() {
        // Don't forget your SQL syntax and good habits:
        // - DELETE FROM table WHERE condition LIMIT 1
        // - escape all values to prevent SQL injection
        // - use LIMIT 1
        //delete query
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE pk_id=" . $this->conn->escape_value($this->pk_id);
        $sql .= " LIMIT 1";
        return $this->conn->query2($sql);
    }

    public function _imagecache_recursive_delete($dir) {
        $d = dir($dir);
        if (is_dir($dir) && !is_link($dir)) {
            if ($d = opendir($dir)) {
                while (($entry = readdir($d)) !== false) {
                    if ($entry == '.' || $entry == '..')
                        continue;
                    $path = $dir . '/' . $entry;
                    if (is_file($path))
                        unlink($path);
                    if (is_dir($path))
                        _imagecache_recursive_delete($path);
                }
                closedir($d);
            }
            return rmdir($dir);
        }
        return unlink($dir);
    }

}
