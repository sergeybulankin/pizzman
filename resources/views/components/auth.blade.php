<div id="login" class="container home-tabs pb-5">
    <nav>
        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true">Войти</a>
            <a class="nav-item nav-link" id="nav-authorization-tab" data-toggle="tab" href="#nav-authorization" role="tab" aria-controls="nav-authorization" aria-selected="false">Создать аккаунт</a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
            <div class="d-flex justify-content-center">
                <div class="col-lg-4">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <input id="name" type="text" class="form-control" name="name" placeholder="Номер телефона" value="{{ old('name') }}" required autofocus>
                            <input type="hidden" name="email" value="admin@admin.com" class="form-control">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" placeholder="Пароль" class="form-control">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button class="btn btn-default pull-right p-2 pl-3 pr-3">войти</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-authorization" role="tabpanel" aria-labelledby="nav-login-tab">
            <div class="d-flex justify-content-center">
                <div class="col-lg-4">
                    <phone-register></phone-register>
                </div>
            </div>
        </div>
    </div>
</div>