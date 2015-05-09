<main class="content">
    <?php foreach ($this->questions as $question) : ?>
        <article class="small-question" data-id="<?= $question['id'] ?>">
            <header>
                <a href="/" class="small-question-category"><?= htmlspecialchars($question['category_name']) ?></a>
                <h2 class="small-question-title">
                    <a href="/questions/view/<?= htmlspecialchars($question['id']) ?>">
                        <?= htmlspecialchars($question['title']) ?>
                    </a>
                </h2>
                <div class="post-info">
                    <a href="/users/profile/<?= htmlspecialchars($question['author_name']) ?>" class="small-question-author">
                        Author: <?= htmlspecialchars($question['author_name']) ?>
                    </a>
                    <span><?= htmlspecialchars($question['created_on']) ?></span>
                    <span class="small-question-visits">Visits: 10</span>
                </div>
            </header>
            <footer>
                <a href="/">*tags*</a>
                <?php if($this->userIsAuthorToQuestion($question['id'])) : ?>
                    <form action="/questions/delete/<?= $question['id']?>" method="post">
                        <input type="submit" value="Delete"/>
                    </form>
                <?php endif;?>
            </footer>
        </article>
    <?php endforeach ?>
</main>
