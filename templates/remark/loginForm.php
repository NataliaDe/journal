<!-- <div class="container">-->

<form class="form-signin" role="form" id="loginForm" method="POST" action="<?= $baseUrl ?>/remark/remark_login">

    <h3 class="form-signin-heading" id="signin-heading">Авторизация</h3>
    <div class="form-group">
        <input type="login" class="form-control" placeholder="Логин"  id="login" name="login" value="" >
    </div>

    <div class="form-group">
        <input type="password" class="form-control" placeholder="Пароль"  id="password" name="password" >
    </div>


    <div class="form-group">
        <div class="checkbox checkbox-success">
            <input id="checkbox1" type="checkbox" name="remember_me" value="1" >
            <label for="checkbox1">
                Запомнить меня
            </label>
        </div>
    </div>


    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>

</form>

<!-- </div> /container -->

