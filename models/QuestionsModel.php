<?php

class QuestionsModel extends BaseModel
{
    public function getAll()
    {
        $statement = self::$db->query(
            "SELECT q.id,
                q.title,
                q.created_on,
                u.username AS author_name,
                u.id AS author_id,
                c.name AS category_name,
                c.id AS category_id
            FROM questions q
            LEFT JOIN users u ON q.author_id = u.id
            LEFT JOIN categories c ON q.category_id = c.id
            ORDER BY q.created_on;");

        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $statement = self::$db->prepare(
            "SELECT q.id,
                q.title,
                q.content,
                q.created_on,
                u.username AS author_name,
                u.id AS author_id,
                c.name AS category_name,
                c.id AS category_id
            FROM questions q
            LEFT JOIN users u ON q.author_id = u.id
            LEFT JOIN categories c ON q.category_id = c.id
            WHERE q.id = ?;");
        $statement->bind_param("i", intval($id));
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    public function createQuestion($title, $content, $username, $categoryId)
    {
        if ($title == '' || $content == '' || $username == '') {
            return false;
        }

        $getUserStatement = self::$db->prepare(
            "SELECT id FROM users WHERE username = ?");
        $getUserStatement->bind_param("s", $username);
        $getUserStatement->execute();
        $user = $getUserStatement->get_result()->fetch_assoc();

        if (!isset($user['id'])) {
            return false;
        }

        $statement = self::$db->prepare(
            "INSERT INTO questions(title, content, author_id, created_on, category_id) VALUES(?, ?, ?, ?, ?)");
        $statement->bind_param("ssisi", $title, $content, intval($user['id']), date("y-m-d H:i:s"), $categoryId);
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function deleteQuestion($id)
    {
        $statement = self::$db->prepare(
            "DELETE FROM questions WHERE id = ?");
        $statement->bind_param("i", intval($id));
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function getAllAnswersForQuestion($questionId)
    {
        $statement = self::$db->prepare(
            "SELECT a.id,
                a.content,
                a.created_on,
                u.username AS author_name,
                u.id AS author_id
            FROM answers a
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.question_id = ?
            ORDER BY a.created_on;");
        $statement->bind_param("i", intval($questionId));
        $statement->execute();

        return $statement->get_result();
    }

    public function getAllCategories()
    {
        $statement = self::$db->query(
            "SELECT id, name
            FROM categories
            ORDER BY name;");

        return $statement->fetch_all(MYSQLI_ASSOC);
    }
}
