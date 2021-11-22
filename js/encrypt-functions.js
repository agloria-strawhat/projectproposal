// const encrypt = function (password1, password2, key) {
//     if (comparePassword(password1, password2)) {
//         let cipherPassword = CryptoJS.AES.encrypt(password1, key);
//         cipherPassword = cipherPassword.toString();
//         console.log(cipherPassword);
//         return cipherPassword
//     } else {
//         console.log('Mismatch Password')
//     }
// }

const comparePassword = function (password1, password2) {
    return password1 === password2
}

const decrypt = function (encryptedPassword) {
    let decipher = CryptoJS.AES.decrypt(encryptedPassword, key);
    decipher = decipher.toString(CryptoJS.enc.Utf8);
    console.log(decipher);
}

const createPassword = function (password1, password2) {
    console.log((password1[0]+password2).toLowerCase())
}

const encrypt = function (password, key) {
        let cipherPassword = CryptoJS.AES.encrypt(password, key);
        cipherPassword = cipherPassword.toString();
        console.log(cipherPassword);
        return cipherPassword
    }