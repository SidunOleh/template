<?php

namespace App\Models;

use App\Components\DB;
use PDO;

abstract class Model
{
    /** 
     * @var array model's properties
     */
    private $props;

    public function __construct($props=[])
    {
        $this->props = $props;
    }

    /** 
     * Save model
     * 
     * @return bool
     */
    public function save()
    {
        return DB::query($this->insertQuery()) ? true : false;
    }

    /**
     * Update model
     * 
     * @return bool
     */
    public function update()
    {
       return DB::query($this->updateQuery()) ? true : false;
    }

    /** 
     * Delete model
     * 
     * @return bool
     */
    public function delete()
    {
        return DB::query($this->deleteQuery()) ? true : false;
    }

    /**
     * Get model by id
     * 
     * @param int $id
     * @return Model|null
     */
    public static function id($id)
    {
        $result = DB::query("SELECT * FROM " . static::$table . " WHERE `id`=$id");

        if (! $user = $result->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        return new static($user);
    }

    /**
     * Get all models
     * 
     * @return array array with models
     */
    public static function all()
    {
        $result = DB::query("SELECT * FROM " . static::$table);

        $users = [];
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $user) {
            $users[] = new static($user);
        }

        return $users;
    }

    /** 
     * Return insert query
     * 
     * @return string insert query
     */
    protected function insertQuery()
    {
        $fields = '';
        $values = '';
        foreach ($this->props as $field => $value) {
            $fields = $fields . "`$field`,";
            $values = $values . "'$value',";
        }

        $query = "INSERT INTO " . static::$table . "(" . rtrim($fields, ','). ") 
            VALUES(" . rtrim($values, ',') . ")";

        return $query;
    }

    /** 
     * Return update query
     * 
     * @return string update query
     */
    protected function updateQuery()
    {
        $set = '';
        foreach ($this->props as $field => $value) {
            $set .= "`$field`='$value',";
        }

        $query = "UPDATE " . static::$table . " SET " . rtrim($set, ',') . " WHERE `id`={$this->props['id']}";

        return $query;
    }

    /** 
     * Return delete query
     * 
     * @return string delete query
     */
    protected function deleteQuery()
    {
        $query = "DELETE FROM " . static::$table . " WHERE `id`={$this->props['id']}";

        return $query;
    }

    public function __get($name)
    {
        if (! isset($this->props[$name])) {
            return null;
        }

        return $this->props[$name];
    }

    public function __set($name, $value)
    {
        $this->props[$name] = $value;
    }
}
