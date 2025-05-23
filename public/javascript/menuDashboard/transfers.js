async function getShowTransfers(url){

    let token = localStorage.getItem("access_token");

    let response = await fetch(url,{

        method: "GET",
        headers: {

            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        }
    });

    let data = await response.json();

    if(data.status){
       
        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        listenEvent2();
    }
}

function listenEvent2(){
    var input_image2 = document.getElementById("comprobante_transferencia");
    input_image2.addEventListener("change", (e) => {
        let container_image = document.getElementById("container_image");
        

        
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


async function insertTransfer(url){

    let value_trans = document.getElementById("valor_transferencia");


    if(value_trans.value !== ""){
        
        let token = localStorage.getItem("access_token");
        let entity_bank = document.getElementById("entidad"); 
        let trans_description = document.getElementById("descripcion_transferencia");
        let image = document.getElementById("comprobante_transferencia");
    
        let formData = new FormData();
        formData.append("image", image.files[0]); // Agregar la imagen al FormData
        formData.append("valor", value_trans.value); // Si necesitas enviar otro campo
        formData.append("descripcion", trans_description.value); // Si necesitas enviar otro campo
        formData.append("entidad", entity_bank.value);
    
        let response = await fetch(url,{
    
            method: "POST",
            headers: {
    
                "Authorization": `Bearer ${token}`
            },
            body: formData
        });
    
    
        let data = await response.json();

        
    let button = document.getElementById("button_insert_transfers");
    button.setAttribute("disabled", "true");
      let iterator = 15;
    for (i = 1; i <= 15; i++) {
        await retardoTransfer(iterator);

        iterator--;

        if (iterator === 0) {
            button.innerHTML = `<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Registrar Egreso`;
            button.removeAttribute("disabled");
        }
    }
    
        if(data.status){
    
            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
    
            Toast.fire({
                icon: "success",
                title: "Transferencia guardada de manera exitosa!",
            });
    
    
        }

    }else{


        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: "Por favor recuerda ponerle un precio a la transferencia!",
        });
    }


}


async function serachForRangeTransfers(url){

    let token = localStorage.getItem("access_token");

    let search = document.getElementById("range_search");

    let response = await fetch(url,{

        method: "POST",
        headers: {

            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({
            
            range: search.value
        })


    });

    let data = await response.json();



    if(data.status){

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;

        let new_date = document.getElementById("range_search");
        new_date.value = search.value;

    }
}


function retardoTransfer(iterator) {
    return new Promise((resolve, reject) => {
        let button = document.getElementById("button_insert_transfers");

        setTimeout(() => {
            button.innerHTML = `<i class="fa-solid fa-upload"></i>&nbsp;&nbsp;Subiendo Transferencia... (${
                iterator - 1
            })`;
            // object_button.innerHTML = `<i class="fa-solid fa-clock" ></i> Cargando ... (${
            //     iterator - 1
            // })`;
            resolve();
        }, 1000);
    });
}