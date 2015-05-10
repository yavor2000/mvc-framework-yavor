
<form method="post" action="/questions/create">
    <div>Title: </div>
    <input type="text" name="question_title">
    <div>Content: </div>
    <input type="text" name="question_content">
    <br/>
    <select name="category_id">
        <?php foreach($this->categories as $category) : ?>
            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Create">
</form>
