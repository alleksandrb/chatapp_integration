<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        tr {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
            animation-delay: 0.2s;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #444;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            display: block;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #555;
        }

        section {
            padding: 20px;
        }
    </style>
    <style>
        .form-container {
            border: 1px solid #fff;
            border-radius: 10px;
            font-family: Arial, sans-serif;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        form {
            border: 1px solid grey;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 60%;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .phone-inputs input {
            margin-bottom: 8px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .no-select {
            user-select: none;
        }

        .checkbox-container {
            display: flex;
            justify-content: start;
        }

        .checkbox-container input {
            margin-right: 8px;
        }
    </style>
    <style>
        .add-button {
            display: inline-block;
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            position: relative;
            overflow: hidden;
        }

        .add-button::before,
        .add-button::after {
            content: '';
            position: absolute;
            width: 2px;
            height: 15px;
            background-color: #fff;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .add-button::after {
            transform: translate(-50%, -50%) rotate(90deg);
        }

        .add-button:hover {
            background-color: #45a049;
        }
    </style>

    <title>Красивый Header с Навигацией</title>
</head>

<body>

    <header>
        <h1>ChatApp</h1>
    </header>

    <nav>
        <a href="{{route('home')}}">Главная</a>
        <a href="{{route('status')}}">Статус рассылок</a>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
            {{ __('Выйти') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
            @csrf
        </form>
    </nav>

    @guest

    @else




    @endguest


    @yield('content')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

</body>

</html>