@extends('layout')

@section('content')
    <div class="head">
        Последние одобренные заявки
    </div>
    <p class="small">
        Количество ободренных {{$count}}
    </p>
    <div class="row">
        @if(count($app))
            @foreach($app as $val)
                <div class="col">
                    <img src="{{ asset('assets/' .$val->path_img_after) }}" alt="Картинка">
                    <h3>{{$val->title}}</h3>
                    <p>Категория заявки:</p>
                    <b>{{$val->category}}</b>
                    <p class="small">
                        {{$val->created_at}}
                    </p>
                </div>
            @endforeach
        @else
            <h3>Заявок не найдено</h3>
        @endif
    </div>
    <div class="head" id="register">
        Регистрация
    </div>
    <form action="/register" method="POST">
        @csrf
        <input type="text" name="fio" placeholder="ФИО" require pattern="[а-яА-яёЁ\-\s]{1-32}">
        <input type="text" name="login" placeholder="Логин" pattern="[a-zA-z]{1-16}">
        <input type="email" name="email" id="email" placeholder="email" pattern=".{1,32}">
        <input type="password" name="password" id="password" pattern=".{1,32}" placeholder="Пароль" require>
        <input type="password" name="password" id="password_check" placeholder="Пароль повторите" require>

        <div class="line">
            <input type="checkbox" require>
            <p>Согласие на обработку ПД</p>
        </div>
        <button type="submit">Зарегестрироваться</button>
    </form>

    <div class="login" id="login">Войти</div>
    <form action="/login" method="POST">
        @csrf
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="password" id="password" placeholder="Пароль" require>
        <button type="submit">Войти</button>
    </form>
@endsection