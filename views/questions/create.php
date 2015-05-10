<form method="post" action="/questions/create" id="loginSection" class="small-question">
    <h2 id="loginLabel">Ask Question:</h2>
    <input id="userNameLoginInput" type="text" placeholder="title..." value="" name="question_title">
    <textarea id="answer-content-input" name="question_content" placeholder="content..."></textarea>
    <label for="category_id">Category: </label>
    <select name="category_id">
        <?php foreach($this->getAllCategories() as $category) : ?>
            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <input id="userNameLoginInput" type="text" placeholder="tags..." value="" name="question_tags">
    <input id="loginButton" type="submit" value="Create"/>
</form>
