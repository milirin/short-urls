<?php

class Model
{
    protected PDO $db;
    protected string $tableName;
    protected array $data = [];

    public function __construct()
    {
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

    public function findAll(): array
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName WHERE id = $id");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
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

    public function delete(int $id)
    {
        $request = $this->db->prepare("DELETE FROM $this->tableName WHERE id = $id");
        $request->execute();

        return $this->findAll();
    }
}
