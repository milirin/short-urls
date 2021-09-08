<?php

class Model
{
    protected PDO $db;
    protected string $tableName;
    protected array $data = [];
    protected string $customIdName = 'id';

    public function __construct()
    {
        if ($this->idName) {
            $this->customIdName = $this->idName;
        }

        $this->db = (new Database())->pdo;

        if ($this->table) {
            $this->tableName = $this->table;
        } else {
            $this->tableName = strtolower(get_called_class()) . 's';
        }
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    public function findAll(): array
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id)
    {
        $className = get_called_class();
        $class = new $className;
        $request = $class->db->prepare("SELECT * FROM $class->tableName WHERE $class->customIdName = $id");
        if ($request->execute()) {
            $object = $request->fetchObject($className);

            return $object;
        } else {
            return false;
        }
    }

    public function store()
    {
        $dataKeys = array_keys($this->data);
        $dataKeysColon = [];

        foreach ($dataKeys as $key) {
            $dataKeysColon[] = ":$key";
        }

        $columns = implode(',', $dataKeys);
        $values = implode(',', $dataKeysColon);

        $request = $this->db->prepare("INSERT INTO $this->tableName ($columns) VALUES ($values)");

        foreach ($this->data as $key => $value) {
            $request->bindValue($key, $value);
        }

        return $request->execute();
    }

    public function delete(): bool
    {
        $customIdName = $this->customIdName;
        $request = $this->db->prepare("DELETE FROM $this->tableName WHERE $this->customIdName = $this->$customIdName");
        
        return $request->execute();
    }
}