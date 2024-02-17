document.getElementById("campoUsuarios").addEventListener("keyup", getCodigos);
document.getElementById("campo").addEventListener("keyup", getCodigos);

function getCodigos() {
    const inputCPU = document.getElementById("campoUsuarios").value;
    const inputCP = document.getElementById("campo").value;
    const lista = document.getElementById("btn_estatus");

    if (inputCP.length > 0 && inputCPU.length > 0) {
        let url = "./../inc/getBoton.php";
        let formData = new FormData();
        formData.append("campoUsuarios", inputCPU);
        formData.append("campo", inputCP);

        fetch(url, {
            method: "POST",
            body: formData,
            mode: "cors"
        })
        .then(response => response.json())
        .then(data => {
            lista.style.display = 'block';
            lista.innerHTML = data;
        })
        .catch(err => console.log(err));
    } else {
        lista.style.display = 'none';
    }
}
