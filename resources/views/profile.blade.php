@extends('layout')

@section('content')
    <div class="head">Ваши заявки</div>
    <div class="logout_btn">
        <a href="/logout">
            Выйти
        </a>
    </div>
    <div class="small">
        Все | Новые | Решенные | Отклоненные
    </div>
    <div class="row">
        @if(count($app))
            @foreach ($app as $val)
                <div class="col">
                    <h3>{{$val->title}}</h3>
                    <p>
                        Статус заявки: {{$val->status}}
                    </p>
                    <p>
                        Категория заявки: {{$val->category}}
                    </p>
                    <p>
                        Описание заявки: {{$val->description}}
                    </p>
                    <img src="{{asset("public/assets/" . $val->path_img_before)}}" alt="Фотография до">

                    @if($val->status="Новая")
                        <a href="/profile/app/{{$val->application_id}}/delete" 
                        onclick="return window.confirm('Вы точно хотите удалить заявку')">
                            Удалить заявку
                        </a>
                    @elseif($val->status="Отклонена")
                        <p>
                            Причина отклонения: {{$val->rejection_reason}}
                        </p>
                    @endif
                </div>
            @endforeach
            @else
                <h3>Данные отсутсвуют</h3>
        @endif
    </div>
    <div class="head">
        Добавить заявку
    </div>
    <form action="/profile/app-add" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Название (до 64 символов)" required pattern=".{1,64}">
        <textarea name="description" placeholder="Описание (до 256 символов)" required pattern=".{1,256}"></textarea>
        <select name="category" required>
            <option value selected disabled>Категория заявки</option>
            @if(count($categories))
                @foreach ($categories as $val)
                    <option value="{{$val->category}}">{{$val->category}}</option>
                @endforeach
            @endif
        </select>
        <p>Фото заявки</p>
        <input type="file" required name="image">
        <button>Создать заявку</button>
    </form>
@endsection