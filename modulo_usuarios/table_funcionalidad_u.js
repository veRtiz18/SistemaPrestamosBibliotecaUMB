// Este funciona con el segundo video que te mande 

let paginaActual_u = 1;
getData(paginaActual_u)

document.getElementById("campo_u").addEventListener("keyup",function(){
    getData(1)
},false)

document.getElementById("num_registros_u").addEventListener("change", function(){
    getData(paginaActual_u)
},false)


function getData(pagina) {
    let input = document.getElementById("campo_u").value
    let num_registros_u = document.getElementById("num_registros_u").value
    let content = document.getElementById("content_u")

    if (pagina != null) {
        paginaActual_u = pagina;
    }

    let url = "vista_table_u.php";
    let formaData = new FormData();

    formaData.append('campo_u', input)
    formaData.append('registros', num_registros_u)
    formaData.append('pagina', pagina)

    fetch(url, {
        method: 'POST',
        body: formaData
    }).then(response => response.json())
    .then(data => {
        content.innerHTML = data.data
        document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
        ' de ' + data.totalRegistros + ' registros';
        document.getElementById("nav-paginacion").innerHTML = data.paginacion;

    }).catch(err => console.log(err))
}
