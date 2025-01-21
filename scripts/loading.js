// carga de aplicaciones
document.addEventListener("DOMContentLoaded", function() {
    let cards = document.querySelectorAll('.card-app');
    setTimeout( () =>{
        cards.forEach( (card) => {
            // Agrega la clase 'loaded' para cada tarjeta
            card.classList.add('loaded');
            // Oculta el elemento de carga si existe
            let loadingElement = card.querySelector('.card-app__loading');
            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
        });
    }, 1000);
});


// loading carousel - tambien se agrego un temporizador para que la pagina quede no disponible mientras se carga todo
document.addEventListener('DOMContentLoaded', () => {
    
    const carouselLoading = document.querySelector('#carousel-principal-fluid ');
    const carouselPrincipalLoading = document.querySelector('#carousel-principal');
    // seleccionamos al #carousel-principal y al .carousel-inner
    const carouselInner = document.querySelector('#carousel-principal-fluid .carousel-inner');
    const carouselPrincipalInner = document.querySelector('#carousel-principal .carousel-inner');

    // Agregamos un temporizador para que la pagina quede no disponible mientras se carga todo
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'block';
    // indicamos que el display de los elementos seleccionados en el querySelector. sea none
    carouselInner.style.display = 'none';
    carouselPrincipalInner.style.display = 'none';
    // Agregar la clase 'loading' para indicar que está cargando
    carouselLoading.classList.add("loading");
    carouselPrincipalLoading.classList.add("loading");
    // Esperar 3 segundos antes de quitar la clase 'loading' y mostrar el .carousel-inner
    setTimeout(() =>{
        // una vez que pasan 3 segundos eliminamos del carousel-principal la clase 'loading'
        carouselLoading.classList.remove("loading");
        carouselPrincipalLoading.classList.remove("loading");
        // y mostramos el .carousel-inner
        carouselInner.style.display = 'block';
        carouselPrincipalInner.style.display = "block";
        // quitamos el overlay
        overlay.style.display = 'none';
    }, 1000);  // 3000 milisegundos = 3 segundos
});

// seguir viendo 
document.addEventListener('DOMContentLoaded', () => {
    // esto hay que ocultarlo al principio y mostrarlo al final
    let cardsSeguirViendo = document.querySelectorAll('.card-seguir-viendo');

    let cards = document.querySelectorAll('.card-top-10 img');

    // muestro el card loading en el top 10
    let top10__loading = document.querySelectorAll('.card-app__loading');
    // esto hay que mostrarlo al principio
    let cardsSeguirViendoLoading = document.querySelectorAll('.card-seguir-viendo__loading');

    cards.forEach((card)=>{
        card.style.display='none';
    })
    
    setTimeout(() => {
        cardsSeguirViendo.forEach((cardImg) => {
            // esto me muestra la imagen despues de cargado
            cardImg.classList.add('loaded');
        });

        top10__loading.forEach((card) =>{
            card.style.display = 'none';
        });

        cards.forEach((card)=>{
            card.style.display='block';
        })

        cardsSeguirViendoLoading.forEach((cardLoading)=>{
            // luego de cargado aplico un display none
            cardLoading.style.display = 'none';
        });
    }, 1000);
});

