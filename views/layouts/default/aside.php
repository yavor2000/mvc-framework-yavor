</main>
<aside id="categories">
    <h2>Category</h2>
    <ul>
        <?php foreach($this->getAllCategories() as $category) : ?>
            <li>
                <a href="/"><?= htmlspecialchars($category['name'])?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
<aside id="tags">
    <h2>Tags</h2>
    <p>
        <?php foreach($this->getAllTags() as $tag) : ?>
    <li>
        <a href="/"><?= htmlspecialchars($tag['name'])?></a>
    </li>
    <?php endforeach; ?>
    </p>
</aside>