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

            <?php if($this->isLoggedIn) : ?>
                <li id="logoutLi">
                    <a href="/users/logout" id="logoutAtag">Logout</a>
                </li>
                <li id="userProfileLi">
                    <a href="/users/profile/<?= htmlspecialchars($this->getUsername()) ?>" id="userProfile">
                        <?= htmlspecialchars($this->getUsername()) ?>'s profile
                    </a>
                </li>
            <?php else : ?>
                <li id="registerLi">
                    <a href="/users/register" id="registerAtag" style="display: inline-block;">Register</a>
                </li>
                <li id="loginLi">
                    <a href="/users/login" id="loginAtag">Login</a>
                </li>
            <?php endif; ?>
            <li>
                <a href="/questions/create">Ask Question</a>
            </li>
            <li>
                <a href="/">Home</a>
            </li>
        </ul>
    </nav>
</header>
<div class="mainContent">
    <main class="content">
<?php include('messages.php'); ?>