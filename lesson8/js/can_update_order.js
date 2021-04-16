'use strict';
const form = document.querySelector('#form');
const userName = document.querySelector('#user_name');
const userPhone = document.querySelector('#user_phone');
const userWish = document.querySelector('#user_wish');
form.addEventListener('submit', e => {
    if (userName.value === userName.defaultValue && userPhone.value === userPhone.defaultValue && userWish.value === userWish.defaultValue) {
        e.preventDefault();
        console.log('Stop submit!');
        form.insertAdjacentHTML("beforeend", "<span class='span_empty'>Вы не внесли изменения!</span>");
    }
});