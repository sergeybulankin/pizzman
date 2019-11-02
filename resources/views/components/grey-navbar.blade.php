<nav class="navbar navbar-expand-lg nav-gray">
    <!--data-toggle="collapse" data-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation"-->
    <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#menu-mobil">
        <span class="navbar-toggler-icon fa fa-bars"></span>
    </button>

    <a href="http://laravel.arimle.ru"><div class="navbar-brand md-auto">Пиццман&Калачев</div></a>

    <div class="navbar-nav pull-right search-sm">
        <i class="fa fa-search" data-toggle="modal" data-target="#search-modal"></i>
    </div>

    <div class="container">
        <div class="collapse navbar-collapse"> <!--collapse-->

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://laravel.arimle.ru/#about_us_link">О компании</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://laravel.arimle.ru/#menu_link">Меню</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://laravel.arimle.ru/#testimonials_link">Отзывы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://laravel.arimle.ru/#contacts">Контакты</a>
                </li>
            </ul>

            <ul class="navbar-nav justify-content-md-center">
                <li class="nav-item">
                    <span class="nav-link" style="font-size:16px;"> <i class="fa fa-phone"></i>  +7(917)805-89-36 </span>
                </li>

                <li class="nav-item">
                    <a  href="#" data-toggle="modal" data-target="#call_me_back"><span class="nav-link"> перезвоните мне</span></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <a class="nav-link" href="/logout"><i class="fa fa-user"></i> Выйти</a>
                    @else
                        <a class="nav-link" href="/auth"><i class="fa fa-user"></i> Войти</a>
                    @endif()
                </li>
            </ul>
        </div>
    </div>
</nav>