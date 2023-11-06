let perfil = document.querySelector('.header .flex .perfil');

document.querySelector('#user-btn').onclick = () =>{
    perfil.classList.toggle('active');
}

pesquisa = document.querySelector('.header .flex .pesquisa');

document.querySelector('#pesquisa-btn').onclick = () =>{
    pesquisa.classList.toggle('active');
}

desc = document.querySelector('.menu .box-container .box .desc');

document.querySelector('#desc-btn').onclick = () =>{
    desc.classList.toggle('active');
}

boxcontainer1 = document.querySelector('.profile .boxcontainer1');
per = document.querySelector('.per');

document.querySelector('#perf').onclick = () =>{
    boxcontainer1.classList.toggle('active');
    per.classList.toggle('active');
}

boxcontainer2 = document.querySelector('.address .boxcontainer2');

document.querySelector('#end').onclick = () =>{
    boxcontainer2.classList.toggle('active');
    per.classList.toggle('active');
}

boxcontainer3 = document.querySelector('.orders .boxcontainer3');

document.querySelector('#order').onclick = () =>{
    boxcontainer3.classList.toggle('active');
}

