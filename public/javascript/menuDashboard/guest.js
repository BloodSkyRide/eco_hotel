
async function getShowGuest(url){

    const token = localStorage.getItem("access_token");

    let response = await fetch(url,{

        method: 'POST',
        headers:{

            contentType: 'application/json',
            Authorization: `Bearer ${token}`
        }

    });


    let data = await response.json();

    if(data.status){

        let element_container = document.getElementById("container_menu");
        element_container.innerHTML = data.html;
        $("#table_guests").DataTable({
            info: true,
            responsive: true,
            order: [[0, "asc"]],
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            language: {
                search: "Buscar en la tabla:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                },
                emptyTable: "No hay datos disponibles",
            },
        });
    }
}


function addGuest(){

    let room = document.getElementById("room");
    let flag = document.querySelectorAll("#container_tr > tr").length + 1;
    
    let name_guest = document.getElementById("nombre_huesped");

    let last_name = document.getElementById("apellido_huesped");

    let fecha_nacimiento = document.getElementById("date");
    
    let cedula = document.getElementById("documento");

    let correo = document.getElementById("correo");

    let origen = document.getElementById("origen");

    let destino = document.getElementById("destino");

    let estado_civil = document.getElementById("select_item_state");

    let number_contact = document.getElementById("contacto");

    let verify = verifyInputs();


    if(verify){

        let add_td = `<tr id="td_row${flag}"><td>${name_guest.value}</td>
        <td>${last_name.value}</td>
        <td>${fecha_nacimiento.value}</td>
        <td>${cedula.value}</td>
        <td>${correo.value}</td>
        <td>${origen.value}</td>
        <td>${destino.value}</td>
        <td>${estado_civil.value}</td>
        <td>${number_contact.value}</td>
        <td>${room.value}</td>
        <td><a type="button" title="Eliminar registro de huesped" onclick="deleteGuest(${flag})"><i class="fa-solid fa-user-xmark" style="color: rgb(163, 5, 5)"></i></a></td>
        </tr>`;
        
        
        let add = document.getElementById("container_tr");
        
        add.innerHTML += add_td;
        flag = flag + 1;
    
        name_guest.value = "";
        last_name.value = "";
        fecha_nacimiento.value = "";
        cedula.value = "";
        correo.value = "";
        origen.value = "";
        destino.value = "";
        estado_civil.value = "selected";
        number_contact.value = "";
    
        if(flag >= 2) room.disabled = true; 
        else{
    
            room.disabled = false; 
            room.value = "selected";
    
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
            title: "Por favor verifica que todos los campos estan bien diligenciados para agregar un huesped",
        });
    }


}


function getGuests(){


    let long = document.querySelectorAll("#container_tr > tr").length;
    let data_object_array = [];
    for(let i = 0; i < long; i++) {

        let guest = document.querySelectorAll(`#td_row${i + 1} > td`); // aca estamos obtenieno todos los campos para empezar a extraer los innerText

        
        data_object_array.push({

            nombre: guest[0].innerText.trim(),
            apellido: guest[1].innerText.trim(),
            nacimiento: guest[2].innerText.trim(),
            cedula: guest[3].innerText.trim(),
            email: guest[4].innerText.trim(),
            origen: guest[5].innerText.trim(),
            destino: guest[6].innerText.trim(),
            estado_civil: guest[7].innerText.trim(),
            celular: guest[8].innerText.trim(),
            habitacion: guest[9].innerText.trim(),
        })
    
    }

    return data_object_array;
    
}

function deleteGuest(id_row){

    let item = document.getElementById(`td_row${id_row}`);
    let room = document.getElementById("room");

    let flag = document.querySelectorAll("#container_tr > tr").length;

    if(flag < 1) room.disabled = false;
    
    item.remove();
}

function verifySend(){


    let price = document.getElementById("costo").value;

    let estadia = document.getElementById("estado").value;




    let finally_data = true;

    if(price === "") finally_data = "Debes ingresar el precio de alquiler de la habitacion";
    if(estadia === "selected") finally_data = "Debes elegir una estadia";

    return finally_data;
}


function verifyInputs2(){


    let room = document.getElementById("room").value;
    
    let name_guest = document.getElementById("nombre_huesped").value;

    let last_name = document.getElementById("apellido_huesped").value;

    let fecha_nacimiento = document.getElementById("date").value;
    
    let cedula = document.getElementById("documento").value;

    let correo = document.getElementById("correo").value;

    let origen = document.getElementById("origen").value;

    let destino = document.getElementById("destino").value;

    let estado_civil = document.getElementById("select_item_state").value;

    let number_contact = document.getElementById("contacto").value;




    let data_verify = [room, name_guest, last_name, fecha_nacimiento, cedula, correo,
        origen, destino, estado_civil, number_contact]

    let finally_data = true;


    data_verify.forEach((item, index) => {

        if(index === 0){
            if(item === "selected") finally_data = false;
        }

        if(item < 1) finally_data = false;
        
    });

    return finally_data;
}


async function registerGuest(url){

    let array = getGuests();

    let verify_send = verifySend();

    if(verify_send === true){


        let price = document.getElementById("costo");
        let estadia = document.getElementById("estado");
    
        let token = localStorage.getItem("access_token");
        let response = await fetch(url,{
    
            method: "POST",
            headers:{
    
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
    
                registros : array,
                precio: price.value,
                estadia: estadia.value
    
            })
    
        });
    
        let data = await response.json();
    
    
        if(data.status){


            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
    
            Toast.fire({
                icon: "success",
                title: "Se ha alquilado la habitacion de manera satisfactoria!",
            });
    
            price.value = "";
            estadia.value = "selected";
            document.getElementById("room").value = "selected";

            let deletes = document.getElementById("container_tr");
            
            deletes.innerHTML = "";
            
            
    
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
            title: verify_send,
        });
    }


}


async function getForRangeGuests(url){

    let date = document.getElementById("fecha_rango");
    let fecha = date.value;
    let token = localStorage.getItem("access_token");
    let response = await fetch(url,{
    
            method: "POST",
            headers:{
    
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
    
                fecha: date.value
    
            })
    
        });
    
        let data = await response.json();


        if(data.status){

            let new_date = fecha;
            let element_container = document.getElementById("container_menu");
            element_container.innerHTML = data.html;
            $("#table_guests").DataTable({
                info: true,
                responsive: true,
                order: [[0, "asc"]],
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                language: {
                    search: "Buscar en la tabla:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior",
                    },
                    emptyTable: "No hay datos disponibles",
                },
            });

            let nuevo = document.getElementById("fecha_rango");

            nuevo.value = new_date;

        }

}