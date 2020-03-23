<div class="container" id="track">
    <h1 class="text-center text-uppercase font-weight-bold">Отслеживание заказа</h1>
    <ul class="pt-5">
        @foreach($order as $item)
            @foreach($item->order_status as $status)
                <li class="mb-4">
                    <h3>{{ $status->status->name }}</h3>
                    <p class="p-0 m-0">{{ $status->status->description }}</p>
                    <h5 class="p-0"><small><b><i>время: {{ $status->created_utc->format('d F H:i') }}</i></b></small></h5>
                </li>
            @endforeach()
        @endforeach()
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