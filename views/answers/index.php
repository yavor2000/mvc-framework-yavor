<h1><?= htmlspecialchars($this->title) ?></h1>

<table>
    <tr>
        <th>ID</th>
        <th>Content</th>
        <th>Action</th>
    </tr>
    <?php foreach ($this->answers as $answer) : ?>
        <tr>
            <td><?= $answer['id'] ?></td>
            <td><?= htmlspecialchars($answer['content']) ?></td>
            <td><a href="/answers/delete/<?=$answer['id']?> ">[Delete]</a></td>
        </tr>
    <?php endforeach ?>
</table>

<a href="/answers/create">[New]</a>