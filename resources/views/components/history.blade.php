<div class="container" id="track">
    <h1 class="text-center text-uppercase font-weight-bold">Истории заказов</h1>

    <div style="margin: 10px 0">
        @foreach($orders as $order)
            <div style="border-bottom: 1px solid red; padding: 10px;">
                <h4>Заказ номер #{{ $order->u_id }}</h4>

                <div>
                    @foreach($order->food as $food)
                        @foreach($food->food_additive as $key => $value)
                            {{ $value->food[$key]->name }} <br>

                            <i>{{ $value->additive[$key]->name }}</i> <br><br>
                        @endforeach()
                    @endforeach()
                </div>

                @foreach($order->order_status as $status)
                    @if($status->status_id == 1)
                        <a href="/delivery/{{ $order->u_id }}">Оформить заказ</a>

                        <form action="/order/delete/{{ $order->id }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}

                            <button>Удалить заказ</button>
                        </form>
                    @else
                    @endif()
                @endforeach()
                <a href="/account/tracking/{{ $order->id }}">Просмотреть</a>
            </div>
        @endforeach()
    </div>
</div>