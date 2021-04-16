'use strict';
const form = document.querySelector('#form');
const userPhone = document.querySelector('#user_phone');
form.addEventListener('submit', e => {
    let status = document.querySelector('input[type="radio"]:checked').value;
    if (userPhone.value === userPhone.defaultValue && status === 'ordered') {
        e.preventDefault();
        console.log('Stop submit!');
        form.insertAdjacentHTML("beforeend", "<span class='span_empty'>Вы не внесли изменения!</span>");
    }
});