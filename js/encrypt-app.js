//const CryptoJS = require("crypto-js");
const key = "HATDOGNAMALAKI";
let cipher


document.querySelector("#create-account").addEventListener('click', function(e){
    const firstName = document.querySelector("#first-name").value
    const lastName = document.querySelector("#last-name").value
    const password = createPassword(firstName, lastName)
    cipher = encrypt(password, key)
})

// document.querySelector("#encrypt").addEventListener('click', function (e) {
//     const password = document.querySelector("#first-name").value
//     const confirmPassword = document.querySelector("#last-name").value
//     cipher = encrypt(password, confirmPassword, key)
// })

// document.querySelector("#decrypt").addEventListener('click', function (e) {
//     decrypt(cipher)
// })

// document.querySelector("#create-password").addEventListener('click', function (e) {
//     const password = document.querySelector("#first-name").value
//     const confirmPassword = document.querySelector("#last-name").value
//     createPassword(password, confirmPassword)
// })