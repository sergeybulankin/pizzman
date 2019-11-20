<div id="login" class="container home-tabs pb-5">
    <nav>
        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true">Войти</a>
            <a class="nav-item nav-link" id="nav-authorization-tab" data-toggle="tab" href="#nav-authorization" role="tab" aria-controls="nav-authorization" aria-selected="false">Создать аккаунт</a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">

            <form method="POST" action="{{ route('login') }}">
                <div class="d-flex justify-content-center">
                    {{ csrf_field() }}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Номер телефона" class="form-control">
                            <input type="hidden" name="email" value="admin@admin.com" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" placeholder="Пароль" class="form-control">
                        </div>

                        <button class="btn btn-default pull-right p-2 pl-3 pr-3">войти</button>
                    </div>

                @if ($errors->has('password'))
                    <div class="HelpBlock">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif()
                </div>
            </form>





                <div class="d-flex justify-content-center">
                    <div class="col-lg-4">

                        <form id="register_form">
                            <div id="phone_form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Номер телефона*</label>
                                    <input type="phone" name="phone" class="form-control">
                                </div>

                                <h5>*<small>Ваш номер телефона - это логин. Пароль, который Вы получите по смс - пароль.</small></h5>
                                <!--<button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" onclick="sign_up(phone.value)">зарегистрироваться</button>-->
                                <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" type="button" onclick="sign_up(phone.value)">зарегистрироваться</button>
                            </div>

                            <div id="password_form" class="d-none">
                                <h5><small>На указанный номер телефона был отправлен пароль, введите его в поле ниже.</small></h5>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Пароль (код из смс)</label>
                                    <input type="phone" name="code" class="form-control">
                                </div>

                                <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" type="button" onclick="confirmCode(code.value)">подтвердить</button>
                            </div>


                            <div id="repeatPhone" class="repeat-sms">
                                <div class="alert alert-primary" role="alert">
                                    Номер телефона некоректен. Введите нормально номер телефона и повторите попытку
                                </div>
                                <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" type="button" onclick="sign_up(phone.value)">зарегистрироваться</button>
                            </div>

                            <div id="repeatSms" class="repeat-sms">
                                <div class="alert alert-primary" role="alert">
                                    Ошибка смс-кода. неправильно введен
                                </div>
                                <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" type="button" onclick="sign_up(phone.value)">зарегистрироваться</button>
                            </div>

                            <div class="alert alert-success d-none" role="alert">Поздравляем! Регистрация прошла успешно! Пожалуйста, авторизуйтесь.</div>
                        </form>
                    </div>
                </div>



        </div> <!--tab-pizza-->

        <!--<div class="tab-pane fade" id="nav-authorization" role="tabpanel" aria-labelledby="nav-authorization-tab">
            <div class="d-flex justify-content-center">
                <div class="col-lg-4">

                    <div id="phone_form">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Номер телефона*</label>
                            <input type="phone" class="form-control">
                        </div>

                        <h5>*<small>Ваш номер телефона - это логин. Пароль, который Вы получите по смс - пароль.</small></h5>
                        <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" onclick="sign_up()">зарегистрироваться</button>
                    </div>


                    <div id="password_form" class="d-none">
                        <h5><small>На указанный номер телефона был отправлен пароль, введите его в поле ниже.</small></h5>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Пароль (код из смс)</label>
                            <input type="phone" class="form-control">
                        </div>

                        <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" onclick="confirm()">подтвердить</button>
                    </div>

                    <div class="alert alert-success d-none" role="alert">Поздравляем! Регистрация прошла успешно! Пожалуйста, авторизуйтесь.</div>
                </div>
            </div>
        </div>-->
    </div><!--tab-content-->
</div>