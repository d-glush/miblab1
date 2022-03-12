<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/back/packages/UsersService/UserService.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/back/packages/Response/Response.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/back/packages/AuthService/AuthService.php';
include_once 'src/php/header.php';
$userService = new UserService();
$authService = new AuthService($userService);

if (!$authService->isAuthed()) {
    header("Location: /");
    exit;
}
?>
<link rel="stylesheet" type="text/css" href="src/css/account.css">

<div class="account_wrapper">

    <div class="personal">
        <div class="personal__ava">
            <img src="src/img/ava.jpg" width="100" height="100" alt="Ваша аватарка">
        </div>
        <div class="personal__data">
            <div class="data__login">
                Логин: <?= $authService->getCurrentUser()->getLogin() ?>
            </div>
            <div class="data__button">
                <button id="password_change_btn">Сменить пароль</button>
            </div>
        </div>
    </div>

    <?php if ($authService->isAdmin()) {?>
        <div class="admin_panel">
            <div>
                <form class="addUserForm" id="addUserForm">
                    <div>
                        <label>Логин:</label>
                        <input type="text" name="login">
                    </div>
                    <div>
                        <button type="submit">Добавить пользователя</button>
                    </div>
                    <div class="error" id="error">
                    </div>
                </form>
            </div>
            <div class="user_list">
            </div>
        </div>
    <?php } ?>

</div>

<script src="/src/js/account.js"></script>
<?php
include_once 'src/php/footer.php';
?>
