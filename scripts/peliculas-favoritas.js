function recargarPeliculfasFavoritas(){
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "home.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("lista-favoritos").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function addFavoritoPelicula(id_pelicula) {
    // Crear una nueva instancia de XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "home.php", true);
  
    // Configuramos el header para enviar datos tipo formulario
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    // Enviamos el id_pelicula correcto
    xhr.send("id_pelicula=" + id_pelicula);
  
    xhr.onload = function () {
      if (xhr.status == 200) {
        console.log(xhr.responseText); // Para ver respuesta del servidor
        alert("Película agregada correctamente.");

        // Suponiendo que la respuesta es exitosa, actualizamos la página dinámicamente
        const nuevaPelicula = document.createElement("div");
        nuevaPelicula.classList.add("card", "card-seguir-viendo", "col-4", "col-md-3", "col-lg-2", "p-0");
        
        nuevaPelicula.innerHTML = `
          <div class="card-seguir-viendo__loading"></div>
          <a href="peliculas/${id_pelicula}.html">
            <img src="ruta/a/imagen.jpg" class="card-img-top" alt="Título de la película">
          </a>
          <div class="card-body p-2 text-center">
            <img src="ruta/a/icono.png" class="platform-icon" alt="Nombre de la plataforma">
            <p class="icon-wrapper">
              <img src="./imagenes/icon/add-agregar-pelicula-icon.png" alt="Agregar pelicula">
            </p>
          </div>
        `;

        
  
        // Agregar el nuevo div al contenedor
        const contenedor = document.getElementById("div__seguirViendo");
        contenedor.querySelector(".row").appendChild(nuevaPelicula);
      } else {
        alert("Error al agregar la película.");
      }
    };
  
    console.log("Se hizo click y llegó: " + id_pelicula);
  }
  