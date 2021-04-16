'use strict';

const selectImgBtn = document.querySelector('#select-img-btn');
const selectedImgName = document.querySelector('#selected-file');
const inputFile = document.querySelector('#input-file');

let key;
function addChecker(interval = 200) {
    key = setInterval(check, interval);
}
function check() {
    let len = inputFile.files.length;
    if (len == 0) {
        return;
    } else {
        let tmpName = inputFile.files[len - 1].name;
        tmpName.length > 23 ? tmpName = cutString(tmpName, 14, len - 8) : null;
        selectedImgName.textContent = tmpName;
        clearInterval(key);
    }
}
function cutString(inputStr, start, end) {
    return `${inputStr.substr(0, start)}...${inputStr.substr(end)}`
}
selectImgBtn.addEventListener('click', addChecker);

