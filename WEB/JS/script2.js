const form = document.getElementById("form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const telefone = document.getElementById("telefone");
const cpf = document.getElementById("cpf");
const data = document.getElementById("data");
const password = document.getElementById("password");
const passwordConfirmation = document.getElementById("password-confirmation");

console.log('panda');

form.addEventListener("submit", (e) => {
   checkInputs();
});

function checkInputs() {
   const usernameValue = username.value;
   const emailValue = email.value;
   const telefoneValue = telefone.value;
   const cpfValue = cpf.value;
   const dataValue = data.value;
   const passwordValue = password.value;
   const passwordConfirmationValue = passwordConfirmation.value;

   if (usernameValue === "") {
      setErrorFor(username, "O nome de usuário tem que ser preenchido");
   } else {
      setSuccessFor(username);
   }

   if (emailValue === "") {
      setErrorFor(email, "O email tem que ser preenchido");
   } else if (!checkEmail(emailValue)) {
      setErrorFor(email, "Insira um email válido");
   } else {
      setSuccessFor(email);
   }

   if (telefoneValue === "") {
      setErrorFor(telefone, "O telefone tem que ser preenchido");
   } else {
      setSuccessFor(telefone);
   }

   if (cpfValue === "") {
      setErrorFor(cpf, "O Cpf tem que ser preenchido");
   } else {
      setSuccessFor(cpf);
   }

   if (dataValue === "") {
      setErrorFor(data, "A data tem que ser preenchido");
   } else {
      setSuccessFor(data);
   }

   if (passwordValue === "") {
      setErrorFor(password, "A senha precisa ser preenchida");
   } else if (passwordValue.length < 5) {
      setErrorFor(password, "A senha tem quje ter mínimo 5 caracteres");
   } else {
      setSuccessFor(password);
   }

   if (passwordConfirmationValue === "") {
      setErrorFor(passwordConfirmation, "A confirmação de senha tem que ser preenchida");
   } else if (passwordConfirmationValue !== passwordValue) {
      setErrorFor(passwordConfirmation, "As senhas não são iguais");
   } else {
      setSuccessFor(passwordConfirmation)
   };

   const formControls = form.querySelectorAll(".form-control");
   const formIsValid = [...formControls].every((formControl) => {
      return formControl.className === "form-control success";
   });



   if (formIsValid) {
      console.log("O formulário graças a Deus foi prenchido e bem feito");
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

function checkEmail(email) {
   return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      email
   );
}
