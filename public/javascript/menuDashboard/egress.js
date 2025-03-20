async function getShowContability(url) {
    let token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status == true) {
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        
        listenEvent();

    } else if (data.status == "error") {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: data.message,
        });
    } else {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: data.message,
        });
    }
}

async function sendEgress(url) {
    let token = localStorage.getItem("access_token");

    let image = document.getElementById("comprobante");

    let amount = document.getElementById("valor");

    let description = document.getElementById("descripcion_egreso");

    let formData = new FormData();
    formData.append("image", image.files[0]); // Agregar la imagen al FormData
    formData.append("valor", amount.value); // Si necesitas enviar otro campo
    formData.append("descripcion", description.value); // Si necesitas enviar otro campo
    
    let response = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`, // No agregues "Content-Type", se maneja solo con FormData
        },
        body: formData, // Enviar FormData en lugar de JSON
    });

    let data = await response.json();

    if (data.status) {

        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "success",
            title: "Egreso guardado de manera exitosa!",
        });
    }
}


function listenEvent(){
    var input_image = document.getElementById("comprobante");
    input_image.addEventListener("change", (e) => {
        let container_image = document.getElementById("container_image");
        let image_preview = document.getElementById("container_image");

        
        const file = e.target.files[0];
        
        if(file){
            
            let node_image = document.createElement("img");
            let reader = new FileReader();

            reader.onload = (ev) => {

                node_image.src = ev.target.result;
                node_image.style.display = "block";
                node_image.style.width = "200px";
                node_image.style.marginTop = "20px";
            }
            
            container_image.appendChild(node_image);
            reader.readAsDataURL(file);
    }
});
}



async function searchForRangeEgress(url){

    let token = localStorage.getItem("access_token");
    let fecha = document.getElementById("fecha_rango");
    let response = await fetch(url,{

        method: "POST",
        headers:{
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },

        body: JSON.stringify({

            fecha: fecha.value

        })

    });

    let data = await response.json();


    if(data.status){


        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        let new_date = document.getElementById("fecha_rango");

        new_date.value = fecha.value;

    }

}
