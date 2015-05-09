<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/content/styles.css" />
    <title>
        <?php if (isset($this->title)) echo htmlspecialchars($this->title) ?>
    </title>
</head>

<body>
    <header>
        <a href="/"><img src="/content/images/site-logo.png"></a>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/questions">Questions</a></li>
        </ul>
        <?php if($this->isLoggedIn) : ?>
        <div id="logged-in-info">
            <span>Hello, <?= htmlspecialchars($this->getUsername()) ?></span>
            <form action="/users/logout"><input type="submit" value="Logout"/></form>
        </div>
        <?php else : ?>
        <div id="logged-out-info">
            <span>Hello, Stranger</span>
            <div>
                <a href="/users/login">Login</a> or <a href="/users/register">Register</a>
            </div>
        </div>
        <?php endif;?>
    </header>

    <?php include('messages.php'); ?>
