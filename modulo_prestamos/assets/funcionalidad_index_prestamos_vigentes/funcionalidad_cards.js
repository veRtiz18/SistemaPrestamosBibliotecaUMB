//Desarrollador: Carlos Ricardo Vertiz
//Fecha: Junio, 2023.
//Nota, el código desarrollado se basa del siguiente vídeo: https://www.youtube.com/watch?v=ghbWKVlJ3X8
//Esta basado en ese vídeo, sin embargo, ha sido adaptado y modificado acorde a las reglas de negocio de nuestro cliente
//Tecnológico de Estudios Superiores de Jilotepec, 2020-2024.

let confirmacionModal = document.getElementById('confirmacionModal');
        /* Llamando a la función getData() */
        getData();

        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campoBusqueda").addEventListener("keyup", function() {
            getData();
        }, false);
        document.getElementById("num_registros").addEventListener("change", function() {
            getData();
        }, false);

        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campoBusqueda").value;
            let num_registros = document.getElementById("num_registros").value;
            let content = document.getElementById("card_prestamo");
            let pagina = document.getElementById("pagina").value;
            let orderCol = document.getElementById("orderCol").value;
            let orderType = document.getElementById("orderType").value;

            if (pagina == null) {
                pagina = 1;
            }

            let url = "./busqueda/cargar_prestamos_vigentes.php";
            let formaData = new FormData();
            formaData.append('campoBusqueda', input);
            formaData.append('registros', num_registros);
            formaData.append('pagina', pagina);
            formaData.append('orderCol', orderCol);
            formaData.append('orderType', orderType);

            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data;
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros';
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion;
                }).catch(err => console.log(err));
        }

        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina;
            getData();
        }

        let columns = document.getElementsByClassName("sort");
        let tamanio = columns.length;
        for (let i = 0; i < tamanio; i++) {
            columns[i].addEventListener("click", ordenar);
        }

        function ordenar(e) {
            let elemento = e.target;

            document.getElementById('orderCol').value = elemento.cellIndex;

            if (elemento.classList.contains("asc")) {
                document.getElementById("orderType").value = "asc";
                elemento.classList.remove("asc");
                elemento.classList.add("desc");
            } else {
                document.getElementById("orderType").value = "desc";
                elemento.classList.remove("desc");
                elemento.classList.add("asc");
            }

            getData();
        }

        confirmacionModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');

            let inputId = confirmacionModal.querySelector('.modal-body #id');
            let inputnombre_libro = confirmacionModal.querySelector('.modal-body #nombre_libro')
            let inputno_inventario = confirmacionModal.querySelector('.modal-body #no_inventario')
            let inputnombre_editorial = confirmacionModal.querySelector('.modal-body #editorial')
            let inputnombre_autor = confirmacionModal.querySelector('.modal-body #autor_libro')
            let inputmatricula = confirmacionModal.querySelector('.modal-body #matricula')

            let url = "./acciones/getPrestamo.php";
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