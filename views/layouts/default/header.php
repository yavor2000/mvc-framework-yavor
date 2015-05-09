<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/content/responsive.css" />
    <link rel="stylesheet" href="/content/style.css" />


    <title>
        <?php if (isset($this->title)) echo htmlspecialchars($this->title) ?>
    </title>
</head>

<body class="body">

<header class="mainHeader">
    <a href="#/"><img src="/content/images/pin.png"></a>
    <nav>
        <ul>
            <li>
                <a href="/">Home</a>
            </li>
            <li>
                <a href="/questions/create">Ask Question</a>
            </li>
            <?php if($this->isLoggedIn) : ?>
                <li id="userProfileLi">
                    <a href="/users/profile/<?= htmlspecialchars($this->getUsername()) ?>" id="userProfile">
                        <?= htmlspecialchars($this->getUsername()) ?>'s profile
                    </a>
                </li>
                <li id="logoutLi">
                    <a href="/users/logout" id="logoutAtag">Logout</a>
                </li>
            <?php else : ?>
                <li id="loginLi">
                    <a href="/users/login" id="loginAtag">Login</a>
                </li>
                <li id="registerLi">
                    <a href="/users/register" id="registerAtag" style="display: inline-block;">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<?php include('messages.php'); ?>
<div class="mainContent">
