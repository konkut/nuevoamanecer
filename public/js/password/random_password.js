
function generate_password_random() {
    const caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";
    const longitud = 100;
    let password = "";
    for (let i = 0; i < longitud; i++) {
        const randomIndex = Math.floor(Math.random() * caracteres.length);
        password += caracteres[randomIndex];
    }
    return password;
}
if (document.getElementById('password')){
    document.getElementById('password').addEventListener('paste', (event) => {
        event.preventDefault();
        const random = generate_password_random();
        event.target.value = random;
    });
}
if (document.getElementById('password_confirmation')){
    document.getElementById('password_confirmation').addEventListener('paste', (event) => {
        event.preventDefault();
        const random = generate_password_random();
        event.target.value = random;
    });
}
if (document.getElementById('current_password')){
    document.getElementById('current_password').addEventListener('paste', (event) => {
        event.preventDefault();
        const random = generate_password_random();
        event.target.value = random;
    });
}
if (document.getElementById('password_two_factor')){
    document.getElementById('password_two_factor').addEventListener('paste', (event) => {
        event.preventDefault();
        const random = generate_password_random();
        event.target.value = random;
    });
}
if (document.getElementById('password_disable_account')){
    document.getElementById('password_disable_account').addEventListener('paste', (event) => {
        event.preventDefault();
        const random = generate_password_random();
        event.target.value = random;
    });
}




