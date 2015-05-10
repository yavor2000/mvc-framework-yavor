<?php if(count($this->questions) == 0 ) :?>
    <form>
        <p>There are no questions right now. Would you like to <a href="/questions/create">ask a question</a>?</p>
    </form>
<?php else : ?>
    <?php  foreach ($this->questions as $question) : ?>
        <article class="small-question" data-id="<?= $question['id'] ?>">
            <header>
                <div class="small-question-category">
                    <span>Category:</span>
                    <a href="/"> <?= htmlspecialchars($question['category_name']) ?></a>
                </div>
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
                    <span class="small-question-visits">Visits: <?= htmlspecialchars($question['visits'])?></span>
                </div>
            </header>
        </article>
    <?php endforeach; ?>
<?php endif; ?>