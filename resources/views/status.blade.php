@extends('layouts.main')
@section('content')

Обновляйте страницу для получения актуальной информации
<table>
    <thead>
        <tr>
            <th>Телефон</th>
            <th>Сообщение</th>
            <th>Статус</th>
        </tr>
    </thead>
    <tbody class="tbody">
        @foreach($status as $stat)
        <tr>
            <td>{{$stat->phone}}</td>
            <td>{{$stat->message}}</td>
            <td>{{$stat->status==1?'ok':'fail'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>


<script>
    window.onload = function() {
        let pusher = new Pusher('ChatsAppApiProdKey', {
            wsHost: 'socket.chatapp.online',
            wssPort: 6001,
            disableStats: true,
            authEndpoint: 'https://api.chatapp.online/broadcasting/auth',
            auth: {
                headers: {
                    'Authorization': '{{ \App\Models\Token::latest()->get()->value("access_token") }}' // accessToken, полученный методом v1.tokens.make
                }
            },
            enabledTransports: ['ws'],
            forceTLS: true
        });

        let channel = pusher.subscribe('private-v1.licenses.42354.messengers.grWhatsApp');

        channel.bind('message', (data) => {
            console.log(data.payload.data[0].message.text);

        });

        channel.bind('messageStatus', (data) => {
            // console.log(data);
            console.log(data.payload.data[0].type);
            console.log(data.payload.data[0].chat.phone);

            //когда-нибудь доделаю


            // fetch('{{route("log.status.message")}}', {
            //         method: 'POST',
            //         body: {
            //             'type': 1,
            //             'phone': 33333333
            //         },
            //     })
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error('Произошла ошибка сети.');
            //         }
            //         return response;
            //     })
            //     .then(data => {
            //         // Обработка успешного ответа
            //         console.log(data);
            //     })
            //     .catch(error => {
            //         // Обработка ошибки
            //         console.error('Произошла ошибка при выполнении запроса:', error.message);
            //     });
            // console.log(data);

        });


    }
</script>
@endsection