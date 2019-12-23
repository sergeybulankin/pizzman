<div class="container">
    <h1 class="text-center text-uppercase font-weight-bold">Изменить данные аккаунта</h1>

    <div style="margin: 10px 0">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <form action="/profile/edit/{{ $account->id }}" method="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="first_name">имя</label>
                <input type="text" id="first_name" name="name" class="form-control" value="{{ $account->name }}"> <br>
            </div>

            <div class="form-group">
                <label for="second_name">фамилия</label>
                <input type="text" id="second_name" name="second_name" class="form-control" value="{{ $account->second_name }}"> <br>
            </div>

            <div class="form-group">
                <label for="link">ссылка ВК</label>
                <input type="text" id="link" name="link" class="form-control" value="{{ $account->link }}"> <br>
            </div>

            <input type="submit" value="Обновить">
        </form>
    </div>
</div>