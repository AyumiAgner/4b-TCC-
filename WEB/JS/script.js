perfil = document.querySelector('.header .flex .perfil');

document.querySelector('#user-btn').onclick = () =>{
    perfil.classList.toggle('active');
}

var myIndex = 0;
carousel();

function carousel(){
    var i;
    var x = document.getElementsByClassName("pic");

    for (i = 0; i < x.length; i++){
        x[i].style.display = "none";
    }

    myIndex++;

    if (myIndex > x.length) {myIndex = 1}
    x[myIndex-1].style.display = "block";
    setTimeout(carousel, 4000);
}

// var slide = 1;
// showDivs(slide);

// function plusDivs(n) {
//     showDivs(slide += n);
// }

// function currentDiv(n) {
//     showDivs(slide = n);
// }

// function showDivs(n) {
//     var i; 
//     var x = document.getElementsByClassName("image");
//     var dots = document.getElementsByClassName("demo");

//     if (n > x.length){slide = 1}
//     if (n < 1) {slide = x.length}

//     for (i = 0; i < x.length; i++){
//        x[i].style.display = "none";    
//     }
    
//     for (i = 0; i < dots.length; i++){
//         dots[i].className = dots[i].className.replace("white", "");
//     }
//     x[slide-1].style.display = "flex";
//     dots[slide-1].className += "white";
// }