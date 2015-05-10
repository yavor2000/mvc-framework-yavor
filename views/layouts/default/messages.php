<?php
if (isset($_SESSION['messages'])) {
    echo '<ul>';
    foreach ($_SESSION['messages'] as $msg) {
        echo '<li class="' . $msg['type'] . ' message">';
        echo htmlspecialchars($msg['text']);
        echo '</li>';
    }
    echo '</ul>';
    unset($_SESSION['messages']);
}
