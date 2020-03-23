<div class="container" id="track">
    <h1 class="text-center text-uppercase font-weight-bold">Изменить данные аккаунта</h1>

    <div style="margin: 10px 0">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif()

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                Данные заполнены некоректно
            </div>
        @endif()

        <form action="/profile/update/{{ $account->id }}" method="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $account->id }}"> <br>

            <div class="form-group">
                <label for="first_name">имя</label>
                <input type="text" id="first_name" name="name" class="form-control" value="{{ $account->name }}"> <br>
            </div>

            <div class="form-group">
                <label for="second_name">фамилия</label>
                <input type="text" id="second_name" name="second_name" class="form-control" value="{{ $account->second_name }}"> <br>
            </div>

            <input type="submit" value="Обновить">
        </form>
    </div>
</div>