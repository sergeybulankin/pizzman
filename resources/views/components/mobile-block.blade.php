<div class="modal" tabindex="-1" role="dialog" id="menu-mobil">
    <div class="modal-dialog m-0" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="navbar-nav ">
                    <div class="navbar navbar-expand-lg header_main header_menu">

                        <div class="navbar-collapse">
                            <div class="navbar-nav pb-3">
                                <ul class="navbar-nav md-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="http://pizza.ru/#menu_link" onclick="close_modal(this)">
                                            <img src="images/pizza.svg">
                                            <span>Пицца</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="http://pizza.ru/#menu_link" onclick="close_modal(this)"><img src="images/burgers.svg">
                                            <span>Выпечка</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="http://pizza.ru/#menu_link" onclick="close_modal(this)"><img src="images/deserts.svg">
                                            <span>Десерты</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="http://pizza.ru/#menu_link" onclick="close_modal(this)"><img src="images/drinks.svg">
                                            <span>Напитки</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="navbar-collapse" id="about"> <!--collapse-->

                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="http://laravel.arimle.ru/#about_us_link" onclick="close_modal(this)">О компании</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://laravel.arimle.ru/#contacts" onclick="close_modal(this)">Контакты</a>
                                </li>
                            </ul>
                        </div>

                        <div class="navbar-collapse">
                            <ul class="navbar-nav justify-content-md-center">
                                <li class="nav-item">
                                    <span class="nav-link" style="font-size:16px;"> <i class="fa fa-phone"></i>  +7(917)805-89-36 </span>
                                </li>

                                <li class="nav-item">
                                    <a  href="#" data-toggle="modal" data-target="#call_me_back"><span class="nav-link"> перезвоните мне</span></a>
                                    <div class="modal" tabindex="-1" role="dialog" id="call_me_back">
                                        <call-me></call-me>
                                    </div>
                                </li>
                            </ul>

                            <ul class="navbar-nav d-lg-none pt-5 pb-5" id="about">
                                <li class="nav-item pl-0 d-flex justify-content-between align-items-end">
                                    <div>
                                        <a href="#"><i class="fa fa-facebook "></i></a>
                                        <a href="#"><i class="fa fa-instagram "></i></a>
                                        <a href="#"><i class="fa fa-vk "></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!--navbar-expand-lg-->
                </div><!--navbar-nav-->



            </div><!--modal-body-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!-- modal-->