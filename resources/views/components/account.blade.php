<div class="container" id="track">
    <h1 class="text-center text-uppercase font-weight-bold">Мой аккаунт</h1>

    @if($orders->isEmpty())
        <h2>У вас есть отслеживаемые заказы</h2>

        @foreach($orders as $order)
            <h3><i>Заказ номер #{{ $order->order->u_id }}</i></h3>
            <a href="account/tracking/{{ $order->order->id }}">просмотреть</a>
        @endforeach()
    @else()
        <h2>У вас нет активных заказов</h2>
    @endif()
</div>