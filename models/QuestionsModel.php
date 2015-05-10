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
                c.id AS category_id,
                (select count(v.id) from question_visits v where v.question_id = q.id) AS visits
            FROM questions q
            LEFT JOIN users u ON q.author_id = u.id
            LEFT JOIN categories c ON q.category_id = c.id
            ORDER BY q.created_on DESC;");

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
                c.name AS category_name,
                c.id AS category_id,
                count(v.id) AS visits
            FROM questions q
            LEFT JOIN users u ON q.author_id = u.id
            LEFT JOIN categories c ON q.category_id = c.id
            LEFT JOIN question_visits v ON v.question_id = q.id
            WHERE q.id = ?;");
        $statement->bind_param("i", intval($id));
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        $getTagsStatement = self::$db->prepare(
            "SELECT t.name
            FROM questions q
            JOIN questions_tags qt ON q.id = qt.question_id
            JOIN tags t ON t.id = qt.tag_id
            WHERE q.id = ?;");
        $getTagsStatement->bind_param("i", intval($id));
        $getTagsStatement->execute();
        $tags = $getTagsStatement->get_result()->fetch_all(MYSQL_ASSOC);
        $result['tags'] = $tags;

        return $result;
    }

    public function createQuestion($title, $content, $username, $categoryId, $tagsArray)
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
        self::$db->begin_transaction();
        $statement = self::$db->prepare(
            "INSERT INTO questions(title, content, author_id, created_on, category_id) VALUES(?, ?, ?, ?, ?)");
        $statement->bind_param("ssisi", $title, $content, intval($user['id']), date("y-m-d H:i:s"), $categoryId);
        $statement->execute();
        if ($statement->affected_rows == 0) {
            self::$db->rollback();

            return false;
        }

        $questionId = $statement->insert_id;

        foreach ($tagsArray as $tagName) {
            if (!$this->createQuestionTags($questionId, $tagName)) {
                self::$db->rollback();

                return false;
            }
        }

        self::$db->commit();

        return true;
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
                u.username AS author_name
            FROM answers a
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.question_id = ?
            ORDER BY a.created_on;");
        $statement->bind_param("i", intval($questionId));
        $statement->execute();

        return $statement->get_result();
    }

    public function createQuestionTags($questionId, $tagName)
    {
        $tagDb = new TagsModel();
        if (!$tagDb->checkIfExists($tagName)) {
            if (!$tagDb->create($tagName)) {
                return false;
            }
        }

        $tagId = $tagDb->getByName($tagName);
        $statement = self::$db->prepare("INSERT INTO questions_tags (tag_id, question_id) VALUES (?, ?);");
        $statement->bind_param("ii", intval($tagId), intval($questionId));
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function addVisit($questionId, $userId)
    {
        if ($userId == null) {
            $statement = self::$db->prepare("INSERT INTO question_visits(question_id, datetime) VALUES(?,?)");
            $statement->bind_param("is", intval($questionId), date("y-m-d H:i:s"));
        } else {
            $statement = self::$db->prepare("INSERT INTO question_visits(question_id, user_id, datetime) VALUES(?,?,?)");
            $statement->bind_param("iis", intval($questionId), intval($userId), date("y-m-d H:i:s"));
        }
        $statement->execute();

        return $statement->affected_rows > 0;
    }

}
