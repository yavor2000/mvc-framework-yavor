<h1>View Question</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Content</th>
        <th>Created on</th>
        <th>Author</th>
        <th>Author Id</th>
        <th>Category</th>
        <th>Category Id</th>
        <th>Action</th>
    </tr>
    <tr>
        <td><?= $this->question['id'] ?></td>
        <td><?= htmlspecialchars($this->question['title']) ?></td>
        <td><?= htmlspecialchars($this->question['content']) ?></td>
        <td><?= htmlspecialchars($this->question['created_on']) ?></td>
        <td><?= htmlspecialchars($this->question['author_name']) ?></td>
        <td><?= htmlspecialchars($this->question['author_id']) ?></td>
        <td><?= htmlspecialchars($this->question['category_name']) ?></td>
        <td><?= htmlspecialchars($this->question['category_id']) ?></td>
        <td><a href="/questions/delete/<?=$this->question['id']?> ">[Delete]</a></td>
    </tr>
</table>
<table>
    <tr>
        <th>Answer Id</th>
        <th>Content</th>
        <th>Created on</th>
        <th>Author</th>
        <th>Author Id</th>
        <th>Action</th>
    </tr>
    <?php foreach ($this->answers as $answer) : ?>
        <tr>
            <td><?= $answer['id'] ?></td>
            <td><?= htmlspecialchars($answer['content']) ?></td>
            <td><?= htmlspecialchars($answer['created_on']) ?></td>
            <td><?= htmlspecialchars($answer['author_name']) ?></td>
            <td><?= htmlspecialchars($answer['author_id']) ?></td>
            <td><a href="/answers/delete/<?=$answer['id']?> ">[Delete]</a></td>
        </tr>
    <?php endforeach ?>
</table>
<a href="/answers/create">[Add New Answer]</a>