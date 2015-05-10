<?php if($this->hasQuestion) : ?>
    <article class="small-question" data-id="<?= $this->question['id'] ?>">
        <header>
            <a href="/" class="small-question-category"><?= htmlspecialchars($this->question['category_name']) ?></a>
            <h2 class="small-question-title">
                <a href="/questions/view/<?= htmlspecialchars($this->question['id']) ?>">
                    <?= htmlspecialchars($this->question['title']) ?>
                </a>
            </h2>
            <div class="post-info">
                <a href="/users/profile/<?= htmlspecialchars($this->question['author_name']) ?>" class="small-question-author">Author: <?= htmlspecialchars($this->question['author_name']) ?></a>
                <span><?= htmlspecialchars($this->question['created_on']) ?></span>
                <span class="small-question-visits">Visits: <?= htmlspecialchars($this->question['visits'])?></span>
            </div>
        </header>
        <main>
            <p class="small-question-content"><?= htmlspecialchars($this->question['content']) ?></p>
        </main>
        <footer>
            <?php if($this->userIsAuthorToQuestion($this->question['id'])) : ?>
                <form action="/questions/delete/<?= $this->question['id']?>" method="post">
                    <input type="submit" value="Delete"/>
                </form>
            <?php endif;?>
            <p>
                <?php if (isset($this->question['tags'])) foreach($this->question['tags'] as $tag) : ?>
                    <a href="/"><?= htmlspecialchars($tag['name'])?></a>
                <?php endforeach; ?>
            </p>
        </footer>
    </article>
    <ul data-type="answersToQuestion">
        <?php foreach ($this->answers as $answer) : ?>
            <li data-type="answer" data-id="<?= htmlspecialchars($answer['id']) ?>">
                <div class="post-info">
                    <a href="/users/profile/<?= htmlspecialchars($answer['author_name']) ?>" class="small-question-author">
                        Author: <?= htmlspecialchars($answer['author_name']) ?>
                    </a>
                    <span><?= htmlspecialchars($answer['created_on']) ?></span>
                </div>
                <p><?= htmlspecialchars($answer['content']) ?></p>
                <?php if($this->userIsAuthorToAnswer($answer['id'])) : ?>
                    <form action="/answers/delete/<?= $answer['id']?>" method="post">
                        <input type="submit" value="Delete"/>
                    </form>
                <?php endif;?>
            </li>
        <?php endforeach ?>
    </ul>
    <?php if($this->isLoggedIn) :?>
        <form method="post" action="/answers/create">
            <textarea id="answer-content-input" name="answer_content"></textarea>
            <input id="add-answer-btn" type="submit" value="Add new answer">
        </form>
    <?php endif; ?>
<?php endif; ?>
