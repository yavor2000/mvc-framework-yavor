<?php

class UsersModel extends BaseModel
{
    public function register($username, $password)
    {
        $checkUsernameStatement = self::$db->prepare(
            "SELECT COUNT(id) FROM users WHERE username = ?");
        $checkUsernameStatement->bind_param("s", $username);
        $checkUsernameStatement->execute();
        $result = $checkUsernameStatement->get_result()->fetch_assoc();
        if ($result['COUNT(id)'] > 0) {
            return false;
        }

        $passHash = password_hash($password, PASSWORD_BCRYPT);

        $registerStatement = self::$db->prepare(
            "INSERT INTO users(username, password_hash) VALUES(?, ?)");
        $registerStatement->bind_param("ss", $username, $passHash);
        $registerStatement->execute();

        return $registerStatement->affected_rows > 0;
    }

    public function login($username, $password)
    {
        $checkUsernameStatement = self::$db->prepare(
            "SELECT id, username, password_hash FROM users WHERE username = ?");
        $checkUsernameStatement->bind_param("s", $username);
        $checkUsernameStatement->execute();
        $result = $checkUsernameStatement->get_result()->fetch_assoc();
        if (password_verify($password, $result['password_hash'])) {
            return true;
        }

        return false;
    }

    public function checkIfAuthorToAnswer($username, $answerId)
    {
        $statement = self::$db->prepare("
        SELECT COUNT(a.id)
        FROM answers a
        JOIN users u ON u.id = a.user_id
        WHERE u.username = ? AND a.id = ?;
        ");
        $statement->bind_param("si", $username, intval($answerId));
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        return $result['COUNT(a.id)'] != 0;
    }

    public function checkIfAuthorToQuestion($username, $questionId)
    {
        $statement = self::$db->prepare("
        SELECT COUNT(q.id)
        FROM questions q
        JOIN users u ON u.id = q.author_id
        WHERE u.username = ? AND q.id = ?;
        ");
        $statement->bind_param("si", $username, intval($questionId));
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        return $result['COUNT(q.id)'] != 0;
    }
}