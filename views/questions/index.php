<h1><?= htmlspecialchars($this->title) ?></h1>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Created on</th>
        <th>Author</th>
        <th>Author Id</th>
        <th>Category</th>
        <th>Category Id</th>
        <th>Action</th>
    </tr>
    <?php foreach ($this->questions as $question) : ?>
        <tr>
            <td><?= $question['id'] ?></td>
            <td><a href="/questions/view/<?=$question['id']?> "><?= htmlspecialchars($question['title']) ?></a></td>
            <td><?= htmlspecialchars($question['created_on']) ?></td>
            <td><?= htmlspecialchars($question['author_name']) ?></td>
            <td><?= htmlspecialchars($question['author_id']) ?></td>
            <td><?= htmlspecialchars($question['category_name']) ?></td>
            <td><?= htmlspecialchars($question['category_id']) ?></td>
            <td><a href="/questions/delete/<?=$question['id']?> ">[Delete]</a></td>
        </tr>
    <?php endforeach ?>
</table>

<a href="/questions/create">[New]</a>
