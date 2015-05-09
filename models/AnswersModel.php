<?php

class AnswersModel extends BaseModel {
    public function createAnswer($content, $questionId, $username) {
        if ($content == '' || is_null($questionId)) {
            return false;
        }

        $getUserStatement = self::$db->prepare(
            "SELECT id FROM users WHERE username = ?");
        $getUserStatement->bind_param("s", $username);
        $getUserStatement->execute();
        $user = $getUserStatement->get_result()->fetch_assoc();

        if(!isset($user['id'])){
            return false;
        }

        $statement = self::$db->prepare(
            "INSERT INTO answers(content, question_id, user_id, created_on) VALUES(?, ?, ?, ?)");
        $statement->bind_param("siis", $content, $questionId, $user['id'], date("y-m-d H:i:s"));
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function deleteAnswer($id) {
        $statement = self::$db->prepare(
            "DELETE FROM answers WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
}