const hamburguesa = document.querySelector('.hamburguesa');
const navegacion = document.querySelector('.navegacion');
const enlaces = document.querySelectorAll('.navegacion h4');
const fecha = document.querySelector('.fecha');
document.addEventListener('DOMContentLoaded',()=>{
    mostrarMenu();
    cerrarMenu();
    fechaActual();
});

function mostrarMenu(){
    hamburguesa.addEventListener('click',()=>{
        navegacion.classList.toggle('ocultar');

    }); 
}

function cerrarMenu(){
    enlaces.forEach(enlace =>{
        enlace.addEventListener('click',(e)=>{
            e.preventDefault();
            const seccion = document.querySelector(e.target.attributes.href.value);
            cambioSeccion(seccion);
            if(e.target.tagName === 'A'){
                navegacion.classList.add('ocultar');
            }
        });
    });
}

function cambioSeccion(seccion){
    seccion.scrollIntoView({
        behavior:'smooth'
    })
}

function fechaActual(){
    let fechaHoy = new Date().getFullYear();
    fecha.textContent = fechaHoy;
}
const a=document.querySelectorAll(".nav-item");
const sec=document.querySelectorAll("section");

function activeMenu(){
    let len=sec.length;
    while(--len && window.scrollY + 97 < sec[len].offsetTop){}
    a.forEach(ltx => ltx.classList.remove("active"));
    a[len].classList.add("active");
} 
activeMenu();
window.addEventListener("scroll", activeMenu);
