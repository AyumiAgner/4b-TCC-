
const form = document.getElementById("form");
const username = document.getElementById("username");
const password = document.getElementById("password");

console.log('panda');

form.addEventListener("submit", (e) => {
    checkInputs();
});
function checkInputs() {
    const usernameValue = username.value;
    const passwordValue = password.value;

    if (usernameValue === "") {
        setErrorFor(username, "o nome de usuário tem que ser preenchido");
    } else {
        setSuccessFor(username);
    }

    if (passwordValue === "") {
        setErrorFor(password, "a senha precisa ser preenchida");
    } else if (passwordValue.length < 5) {
        setErrorFor(password, " a senha tem quje ter mínimo 5 caracteres");
    } else {
        setSuccessFor(password);
    }

    const formControls = form.querySelectorAll(".form-control");
    const formIsValid = [...formControls].every((formControl) => {
        return formControl.className === "form-control success";
    });



    if (formIsValid) {
        console.log("o formulário graças a Deus foi prenchido e bem feito");
    }
}


function setErrorFor(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector("small");

    // Adiciona a mensagem de erro
    small.innerText = message;

    // Adiciona a classe de erro
    formControl.className = "form-control error";
}

function setSuccessFor(input) {
    const formControl = input.parentElement;

    // Adicionar a classe de sucesso
    formControl.className = "form-control success";
}