<?php

class TagsModel extends BaseModel
{
    public function getAll()
    {
        $statement = self::$db->query("SELECT id, name FROM tags;");

        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    public function checkIfExists($name)
    {
        $statement = self::$db->prepare("SELECT COUNT(id) FROM tags WHERE name = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        //var_dump($result);

        return $result['COUNT(id)'] > 0;
    }

    public function create($name)
    {
        if ($this->checkIfExists($name)) {
            return false;
        }

        $statement = self::$db->prepare("INSERT INTO tags(name) VALUES (?)");
        $statement->bind_param("s", $name);
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function getByName($name)
    {
        $statement = self::$db->prepare("SELECT id FROM tags WHERE name = ?");
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        return $result['id'];
    }

}