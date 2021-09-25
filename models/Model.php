<?php

class Model
{
    private PDO $db;
    private string $tableName;
    private array $data = [];
    private string $customIdName = 'id';
    private string $relationsColumnName;

    public function __construct()
    {
        if ($this->idName) {
            $this->customIdName = $this->idName;
        }

        $this->relationsColumnName = strtolower(get_called_class()) . '_id';

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

    public function update(array $data): bool
    {
        $customIdName = $this->customIdName;
        unset($data['id']);
        $array_column_value = [];

        foreach ($data as $column => $value) {
            $array_column_value[] = "$column='$value'";
        }

        $columnsAndValues = implode(',', $array_column_value);

        $request = $this->db->prepare("UPDATE $this->tableName SET $columnsAndValues WHERE $this->customIdName = {$this->$customIdName}");

        return $request->execute();
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function get()
    {
        $request = $this->db->prepare($this->query);
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function orderBy($columnName, $sortBy)
    {
        $this->query .= " ORDER BY $columnName $sortBy";

        return $this;
    }

    public function hasMany(string $className)
    {
        $className = strtolower($className) . 's';
        $this->query = "SELECT * FROM $className WHERE $this->relationsColumnName = $this->id";

        return $this;
    }
}