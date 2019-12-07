<div class="container" id="track">
    <h1 class="text-center text-uppercase font-weight-bold">Отслеживание заказа</h1>
    <ul class="pt-5">
        @for($i = 1; $i <= $orderStatus->status_id; $i++)
            <li class="mb-4">
                <h3>{{ $statuses[$i - 1]->name }}</h3>
                <p class="p-0 m-0">{{ $statuses[$i - 1]->description }}</p>
                @if($i == 1)
                    <h5 class="p-0"><small><b><i>время: {{ $statuses[$i - 1]->created_at }}</i></b></small></h5>
                @elseif($i > 1)
                    <h5 class="p-0"><small><b><i>время: {{ $statuses[$i - 1]->updated_at }}</i></b></small></h5>
                @endif()
            </li>
        @endfor()
    </ul>

    <!--
    <h3>Спасибо за заказ!</h3>
    <p>Пожалуйста, оставьте отзыв. Мы постараемся учесть все Ваши пожелания!</p>
    <div class="d-flex" id="star">
        <div class="fa m-2 fa-star" onclick="update_star(this)"></div>
        <div class="fa m-2 fa-star" onclick="update_star(this)"></div>
        <div class="fa m-2 fa-star" onclick="update_star(this)"></div>
        <div class="fa m-2 fa-star-o" onclick="update_star(this)"></div>
        <div class="fa m-2 fa-star-o" onclick="update_star(this)"></div>
    </div>
    <textarea class="w-100" placeholder="комментарий..."></textarea>
    <button class="btn btn-default">отправить</button>-->
</div>