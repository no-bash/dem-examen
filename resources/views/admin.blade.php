@extends('layout')

@section('content')
    <div>Админ панель</div>
    <div class="header_category">
        <p>Категории</p>
        <form action="/admin/category/add" method="POST">
            @csrf
            <input type="text" name="category" placeholder="Категория" required pattern=".{1,64}">
            <button type="submit">Добавить</button>
        </form>
        <form action="/admin/category/delete" method="POST">
            @csrf
            <div class="line">
                <select name="category_id" required>
                    <option value selected disabled>Категории</option>
                    @if (count($categories))
                        @foreach ($categories as $val)
                            <option value="{{$val->category_id}}">{{$val->category}}</option>
                        @endforeach
                    @endif
                </select>
                <button>Удалить</button>
            </div>
        </form>
    </div>
    <div class="new_app">
        <h3>Новые заявки</h3>
        @if (count($new))
            @foreach ($new as $val)
                <img src="{{asset('assets/'.$val->path_img_before)}}" alt="Проблема">
                <h4>{{$val->title}}</h4>
                <p>{{$val->status}}</p>
                <p>{{$val->category}}</p>
                <p>{{$val->description}}</p>
                <h4>Форма одобрения заявки</h4>
                <form action="/admin/app/approve" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="file" required name="image">
                    <button value="{{$val->application_id}}" name="app_id" type="submit">Отправить</button>
                </form>
                <h4>Форма удаления заявки</h4>
                <form action="/admin/app/reject" method="POST">
                    @csrf
                    <textarea name="rejection_reason" pattern='.{1,256}' required></textarea>
                    <button value="{{$val->application_id}}" name="app_id" type="submit">Отправить</button>
                </form>
            @endforeach
        @else 
            <h3>Данные отсутсвуюты</h3>
        @endif
    </div>

    <div class="new_app">
        <h3>Одобренные заявки</h3>
        @if (count($approved))
            @foreach ($approved as $val)
                <img src="{{asset('assets/'.$val->path_img_before)}}" alt="Проблема">
                <h4>{{$val->title}}</h4>
                <p>{{$val->status}}</p>
                <p>{{$val->category}}</p>
                <p>{{$val->description}}</p>
            @endforeach
        @else 
            <h3>Данные отсутсвуюты</h3>
        @endif
    </div>

    <div class="new_app">
        <h3>Отклоненные заявки</h3>
        @if (count($rejected))
            @foreach ($rejected as $val)
                <img src="{{asset('assets/'.$val->path_img_before)}}" alt="Проблема">
                <h4>{{$val->title}}</h4>
                <p>{{$val->status}}</p>
                <p>{{$val->category}}</p>
                <p>{{$val->description}}</p>
            @endforeach
        @else 
            <h3>Данные отсутсвуюты</h3>
        @endif
    </div>
@endsection