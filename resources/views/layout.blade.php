    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ДЭ Арсэн</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <header>
            <div class="top">
                <h1>Заголовок</h1>
                <h2>ЕЩЕ</h2>
            </div>
            <div class="content">
                <nav>

                </nav>
            </div>
        </header>
        <main>
            <div class="content">
                @yield('content')
            </div>
        </main>
    </body>
    </html>
