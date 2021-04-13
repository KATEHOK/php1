'use strict';
const formEl = document.querySelector('#form');
const userPhoneEl = document.querySelector('#user_phone');
formEl.addEventListener('submit', e => {
    let status = false;
    if (userPhoneEl.value !== userPhoneEl.defaultValue) {
        status = true;
    }
    let radioChecked = document.querySelector('input.radio_input:checked');
    if (!status) {
        console.log('stop');
        e.preventDefault();
        return;
    }
    formEl.insertAdjacentHTML('beforeend', `<input type='hidden' name='status_name' value='${radioChecked.id}'>`);
});
// TO DO
// сделать логику передачи выбранных чекбоксов