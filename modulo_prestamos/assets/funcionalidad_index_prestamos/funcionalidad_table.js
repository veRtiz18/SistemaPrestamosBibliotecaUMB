//Desarrollador: Carlos Ricardo Vertiz
//Fecha: Junio, 2023.
//Nota, el código desarrollado se basa del siguiente vídeo: https://www.youtube.com/watch?v=ghbWKVlJ3X8
//Esta basado en ese vídeo, sin embargo, ha sido adaptado y modificado acorde a las reglas de negocio de nuestro cliente
//Tecnológico de Estudios Superiores de Jilotepec, 2020-2024.

//confirmacionModal
confirmacionModal.addEventListener('shown.bs.modal', event => {
    let button = event.relatedTarget;
    let id = button.getAttribute('data-bs-id');

    let inputId = confirmacionModal.querySelector('.modal-body #id');
    let inputnombre_libro = confirmacionModal.querySelector('.modal-body #nombre_libro')
    let inputno_inventario = confirmacionModal.querySelector('.modal-body #no_inventario')
    let inputnombre_editorial = confirmacionModal.querySelector('.modal-body #editorial')
    let inputnombre_autor = confirmacionModal.querySelector('.modal-body #autor_libro')
    let inputmatricula = confirmacionModal.querySelector('.modal-body #matricula')

    let url = "./getPrestamo.php";
    let formData = new FormData();
    formData.append('id', id);

    fetch(url, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            inputId.value = data.id_prestamo;
            inputnombre_libro.value = data.titulo_libro;
            inputno_inventario.value = data.no_inventario;
            inputnombre_editorial.value = data.editorial_libro;
            inputnombre_autor.value = data.autor_libro;
            inputmatricula.value = data.matricula;
        })
        .catch(err => console.error(err));
});

//funcionalidad nuevoModal
let nuevoModal = document.getElementById('nuevoModal')
nuevoModal.addEventListener('shown.bs.modal', event => {
    nuevoModal.querySelector('.modal-body #campo').focus()
})

nuevoModal.addEventListener('hide.bs.modal', event => {
    nuevoModal.querySelector('.modal-body #campo').value = ""
    nuevoModal.querySelector('.modal-body #campoUsuarios').value = ""
    nuevoModal.querySelector('.modal-body #fecha').value = ""
    var lista = document.getElementById('lista');
    lista.innerHTML = "";

    var listaUsuarios = document.getElementById('listaUsuarios');
    listaUsuarios.innerHTML = "";

    var btn_estatus = document.getElementById('btn_estatus')
    btn_estatus.innerHTML = "";
})

//funcionalidad verModal
let verModal = document.getElementById('verModal')
verModal.addEventListener('shown.bs.modal', event => {
    let button = event.relatedTarget;
    let id = button.getAttribute('data-bs-id');

    let inputId = verModal.querySelector('.modal-body #folio');
    let inputnombre_libro = verModal.querySelector('.modal-body #nombre_libro')
    let inputno_inventario = verModal.querySelector('.modal-body #no_inventario')
    let inputnombre_editorial = verModal.querySelector('.modal-body #nombre_editorial')
    let inputnombre_autor = verModal.querySelector('.modal-body #nombre_autor')
    let inputanio = verModal.querySelector('.modal-body #anio')

    let inputnombre_alumno = verModal.querySelector('.modal-body #nombre_alumno')
    let inputmatricula = verModal.querySelector('.modal-body #matricula')
    let inputcarrera = verModal.querySelector('.modal-body #carrera')
    let inputsemestre = verModal.querySelector('.modal-body #semestre')

    let inputestatus = verModal.querySelector('.modal-body #estatus')
    let inputfecha_inicio = verModal.querySelector('.modal-body #fecha_inicio')
    let inputfecha_final = verModal.querySelector('.modal-body #fecha_final')
    let carrera_alumno = verModal.querySelector('.modal-body #carrera_alumno')

    let url = "./getPrestamo.php";
    let formData = new FormData();
    formData.append('id', id);

    fetch(url, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {

            inputId.value = data.id_prestamo;
            inputnombre_libro.value = data.titulo_libro;
            inputno_inventario.value = data.no_inventario;
            inputnombre_editorial.value = data.editorial_libro;
            inputnombre_autor.value = data.autor_libro;
            inputanio.value = data.anio_libro;

            inputnombre_alumno.value = data.nombre_estudiante + " " + data.ape_Paterno + " " + data.ape_Materno;
            inputmatricula.value = data.matricula;
            inputcarrera.value = data.carrera_alumno;
            inputsemestre.value = data.carrera_semestre;

            inputestatus.value = data.descripcion_estatus;
            inputfecha_inicio.value = data.fecha;
            inputfecha_final.value = data.fecha_entrega;
        })
        .catch(err => console.error(err));
});

//funcionalidad confirmacionGenerarPDF

confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
    confirmacionGenerarPDF.querySelector('.modal-body #matricula').value = "";
})
confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
    confirmacionGenerarPDF.querySelector('.modal-body #nombre_alumno').value = "";
})
confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
    confirmacionGenerarPDF.querySelector('.modal-body #carrera').value = "";
})
confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
    confirmacionGenerarPDF.querySelector('.modal-body #semestre').value = "";
})

confirmacionGenerarPDF.addEventListener('shown.bs.modal', event => {
    let button = event.relatedTarget;
    let id = button.getAttribute('data-bs-id');
    let inputId = confirmacionGenerarPDF.querySelector('.modal-body #id');

    let inputmatricula = confirmacionGenerarPDF.querySelector('.modal-body #matricula')
    let inputnombre_alumno = confirmacionGenerarPDF.querySelector('.modal-body #nombre_alumno')
    let inputcarrera = confirmacionGenerarPDF.querySelector('.modal-body #carrera')
    let inputsemestre = confirmacionGenerarPDF.querySelector('.modal-body #semestre')


    let url = "./getPrestamo.php";
    let formData = new FormData();
    formData.append('id', id);

    fetch(url, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {

            inputId.value = data.id_prestamo
            inputnombre_alumno.value = data.nombre_estudiante + " " + data.ape_Paterno + " " + data.ape_Materno;
            inputmatricula.value = data.matricula;
            inputcarrera.value = data.carrera_alumno;
            inputsemestre.value = data.carrera_semestre;
        })
        .catch(err => console.error(err));
});

//funcionalidad aplazarPrestamoModal 

aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #matricula').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #nombre_alumno').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #carrera').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #semestre').value = "";
})

aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #folio').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #nombre_libro').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #nombre_editorial').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #nombre_autor').value = "";
})

aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #estatus').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #fecha_inicio').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #fecha_final').value = "";
})
aplazarPrestamoModal.addEventListener('hide.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #carrera_alumno').value = "";
})

aplazarPrestamoModal.addEventListener('shown.bs.modal', event => {
    aplazarPrestamoModal.querySelector('.modal-body #fecha_final').focus()
})
aplazarPrestamoModal.addEventListener('shown.bs.modal', event => {
    let button = event.relatedTarget;
    let id = button.getAttribute('data-bs-id');

    let inputId = aplazarPrestamoModal.querySelector('.modal-body #folio');
    let inputnombre_libro = aplazarPrestamoModal.querySelector('.modal-body #nombre_libro')
    let inputno_inventario = aplazarPrestamoModal.querySelector('.modal-body #no_inventario')
    let inputnombre_editorial = aplazarPrestamoModal.querySelector('.modal-body #nombre_editorial')
    let inputnombre_autor = aplazarPrestamoModal.querySelector('.modal-body #nombre_autor')
    let inputanio = aplazarPrestamoModal.querySelector('.modal-body #anio')

    let inputnombre_alumno = aplazarPrestamoModal.querySelector('.modal-body #nombre_alumno')
    let inputmatricula = aplazarPrestamoModal.querySelector('.modal-body #matricula')
    let inputcarrera = aplazarPrestamoModal.querySelector('.modal-body #carrera')
    let inputsemestre = aplazarPrestamoModal.querySelector('.modal-body #semestre')

    let inputestatus = aplazarPrestamoModal.querySelector('.modal-body #estatus')
    let inputfecha_inicio = aplazarPrestamoModal.querySelector('.modal-body #fecha_inicio')
    let inputfecha_final = aplazarPrestamoModal.querySelector('.modal-body #fecha_final')
    let carrera_alumno = aplazarPrestamoModal.querySelector('.modal-body #carrera_alumno')


    let url = "./getPrestamo.php";
    let formData = new FormData();
    formData.append('id', id);

    fetch(url, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Asegúrate de que el elemento con el ID 'id' existe dentro del modal body
            inputId.value = data.id_prestamo;
            inputnombre_libro.value = data.titulo_libro;
            inputno_inventario.value = data.no_inventario;
            inputnombre_editorial.value = data.editorial_libro;
            inputnombre_autor.value = data.autor_libro;
            inputanio.value = data.anio_libro;

            inputnombre_alumno.value = data.nombre_estudiante + " " + data.ape_Paterno + " " + data.ape_Materno;
            inputmatricula.value = data.matricula;
            inputcarrera.value = data.carrera_alumno;
            inputsemestre.value = data.carrera_semestre;

            inputestatus.value = data.descripcion_estatus;
            inputfecha_inicio.value = data.fecha;
            inputfecha_final.value = data.fecha_entrega;

        })
        .catch(err => console.error(err));
});

/* Llamando a la función getData() */
getData()

/* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
document.getElementById("campoBusqueda").addEventListener("keyup", function () {
    getData()
}, false)
document.getElementById("num_registros").addEventListener("change", function () {
    getData()
}, false)

/* Peticion AJAX */
function getData() {
    let input = document.getElementById("campoBusqueda").value
    let num_registros = document.getElementById("num_registros").value
    let content = document.getElementById("content")
    let pagina = document.getElementById("pagina").value
    let orderCol = document.getElementById("orderCol").value
    let orderType = document.getElementById("orderType").value

    if (pagina == null) {
        pagina = 1
    }

    let url = "./busqueda/cargar.php"
    let formaData = new FormData()
    formaData.append('campoBusqueda', input)
    formaData.append('registros', num_registros)
    formaData.append('pagina', pagina)
    formaData.append('orderCol', orderCol)
    formaData.append('orderType', orderType)

    fetch(url, {
        method: "POST",
        body: formaData
    }).then(response => response.json())
        .then(data => {
            content.innerHTML = data.data
            document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                ' de ' + data.totalRegistros + ' registros'
            document.getElementById("nav-paginacion").innerHTML = data.paginacion
        }).catch(err => console.log(err))
}

function nextPage(pagina) {
    document.getElementById('pagina').value = pagina
    getData()
}

let columns = document.getElementsByClassName("sort")
let tamanio = columns.length
for (let i = 0; i < tamanio; i++) {
    columns[i].addEventListener("click", ordenar)
}

function ordenar(e) {
    let elemento = e.target

    document.getElementById('orderCol').value = elemento.cellIndex

    if (elemento.classList.contains("asc")) {
        document.getElementById("orderType").value = "asc"
        elemento.classList.remove("asc")
        elemento.classList.add("desc")
    } else {
        document.getElementById("orderType").value = "desc"
        elemento.classList.remove("desc")
        elemento.classList.add("asc")
    }
    getData()
}