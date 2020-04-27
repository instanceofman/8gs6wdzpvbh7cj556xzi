<?php

namespace Intass;

use App\Exceptions\ModelNotFoundException;

class Model
{
    /**
     * @return Database
     */
    protected $db;

    protected $attributes = [];

    protected $readonly = [];

    public function __construct()
    {
        $this->db = Container::getInstance()->getDatabase();
    }

    public function getTableName()
    {
        $class = explode('\\', get_class($this));
        $entity = array_pop($class);

        return strtolower($entity) . 's';
    }

    public function load($id)
    {
        $result = $this->db->query('SELECT * FROM ' . $this->getTableName() . ' WHERE id = ' . $id . ' limit 1');

        if (!$result) {
            throw new ModelNotFoundException;
        }

        $this->attributes = $result;

        return $this;
    }

    /**
     * @return Model
     * @throws ModelNotFoundException
     */
    public static function find($id)
    {
        return (new static())->load($id);
    }

    public function fill($attributes)
    {
        foreach ($this->readonly as $field) {
            unset($attributes[$field]);
        }

        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    public function save()
    {
        $set = [];
        $data = [];

        foreach ($this->attributes as $field => $value) {
            if (in_array($field, $this->readonly)) {
                continue;
            }

            $set[] = $field . ' = ' . "?";
            $data[] = $value;
        }

        $cmd = 'UPDATE ' . $this->getTableName() . ' SET ' . implode(',', $set) . ' WHERE id = ' . $this->id;

        $this->db->update($cmd, $data);

        return $this;
    }

    public function __get($name)
    {
        if (!isset($this->attributes[$name])) {
            return null;
        }

        return $this->attributes[$name];
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
