<?php

namespace Core;

use PDO;

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function connect()
    {
        $config = require base_path('config/database.php');
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $username = $config['username'];
        $password = $config['password'];

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $setPart WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    public function updateWhere($data, $where)
    {
        $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $wherePart = implode(" AND ", array_map(fn($key) => "$key = :where_$key", array_keys($where)));
        $sql = "UPDATE {$this->table} SET $setPart WHERE $wherePart";
        
        $params = array_merge($data, array_combine(
            array_map(fn($key) => "where_$key", array_keys($where)),
            array_values($where)
        ));
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    public function whereOrderBy($column, $operator, $value, $orderByColumn, $direction = 'ASC')
    {
        $sql = "SELECT * FROM {$this->table} WHERE $column $operator :value ORDER BY $orderByColumn $direction";
        return $this->query($sql, ['value' => $value])->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->query($sql, ['id' => $id]);
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC)??[];
    }
    public function orderBy($column, $direction = 'ASC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY $column $direction";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->query($sql, ['id' => $id])->fetch(PDO::FETCH_ASSOC);
    }

    public function where($column, $operator, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $column $operator :value";
        return $this->query($sql, ['value' => $value])->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function firstWhere($column, $operator, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $column $operator :value LIMIT 1";
        return $this->query($sql, ['value' => $value])->fetch(PDO::FETCH_ASSOC);
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) AS count FROM {$this->table}";
        return $this->query($sql)->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function paginate($limit, $offset)
    {
        $sql = "SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset";
        return $this->query($sql, ['limit' => $limit, 'offset' => $offset])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rawQuery($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rawUpdate($sql, $params = [])
    {
        return $this->query($sql, $params);
    }
    
}
