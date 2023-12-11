@extends('layouts.main')
@section('content')

<div class="form-container">
    <form id="myForm" action="{{route('create.message')}}" method="post">
        @csrf
        <label for="phone">Номера телефонов:</label>
        <div class="phone-inputs">
            <input id="phone" class="phoneNumber clone" type="tel" name="phoneNumber[]" placeholder="Введите номер телефона" required>
        </div>
        <div style="margin-bottom:15px;"><button type="button" onclick="addPhoneNumberInput()" class="add-button"></button></div>
        <div class="checkbox-container">
            <div class="no-select"><label for="useoldphone">Использовать номера из базы</label></div>
            <div>
                <input type="hidden" name="useoldphone" value="0">
                <input id="useoldphone" onclick="phoneNotRequired()" type="checkbox" name="useoldphone" value="1">
            </div>
        </div>

        <label for="textMessage">Текст сообщения:</label>
        <textarea id="textMessage" name="textMessage" rows="4" placeholder="Введите текст сообщения"></textarea>



        <button type="submit">Отправить</button>
    </form>
</div>

<script>
    function phoneNotRequired() {
        const checkBox = document.querySelector('#useoldphone')
        const phoneNumberDivs = document.querySelectorAll(".phoneNumber")
        if (checkBox.checked) {
            phoneNumberDivs.forEach(phoneNumberDiv => {
                phoneNumberDiv.required = false
            })
        } else {
            phoneNumberDivs.forEach(phoneNumberDiv => {
                phoneNumberDiv.required = true
            })
        }
    }

    function addPhoneNumberInput() {
        const phoneInputs = document.querySelector('.phone-inputs')
        const clone = document.querySelector('.clone')
        const newInput = clone.cloneNode(true)
        phoneInputs.appendChild(newInput);
    }
</script>

@endsection