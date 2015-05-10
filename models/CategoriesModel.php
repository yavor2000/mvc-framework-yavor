<?php

class CategoriesModel extends BaseModel
{
    public function getAll()
    {
        $statement = self::$db->query("SELECT id, name FROM categories;");

        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    public function checkIfExists($name)
    {
        $statement = self::$db->prepare("SELECT COUNT(id) FROM categories WHERE name = ?");
        $statement->bind_params("s", $name);
        $statement->execute();
        $result = $statement->get_result()->fetch_all();

        return $result['COUNT(id)'] > 0;
    }

    public function create($name)
    {
        if ($this->checkIfExists($name)) {
            return false;
        }

        $statement = self::$db->prepare("INSERT INTO categories(name) VALUES (?)");
        $statement->bind_params("s", $name);
        $statement->execute();

        return $statement->affected_rows > 0;
    }
}