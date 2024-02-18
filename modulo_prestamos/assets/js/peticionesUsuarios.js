// Autor: Carlos Ricardo Vertiz 
// correo ricardovertizcarlos@gmail.com
// Fecha: Jueves 17 de febrero del 2024


document.getElementById("campoUsuarios").addEventListener("keyup", getCodigos)

function getCodigos() {
    let inputCP = document.getElementById("campoUsuarios").value
    let lista = document.getElementById("listaUsuarios")


    if (inputCP.length > 0) {


        let url = "./../inc/getUsuarios.php";
        let formData = new FormData()
        formData.append("campoUsuarios", inputCP)

        fetch(url, {
            method: "POST",
            body: formData,
            mode: "cors"

        }).then(response => response.json()).then(data => {
            lista.style.display = 'block'
            lista.innerHTML = data
        })
            .catch(err => console.log(err))
    } else {
        lista.style.display = 'none'
     }
}