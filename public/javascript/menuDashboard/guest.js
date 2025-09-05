async function getShowGuest(url) {
    const token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            contentType: "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
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

function addGuest() {
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

    let number_companions = document.getElementById("number_companions");

    let type_document = document.getElementById("type_document");

    let verify = verifyInputs2();

    if (verify) {
        let add_td = `<tr id="td_row${flag}"><td>${name_guest.value}</td>
        <td>${last_name.value}</td>
        <td>${fecha_nacimiento.value}</td>
        <td>${type_document.value}</td>
        <td>${cedula.value}</td>
        <td>${number_companions.value}</td>
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
        type_document.value = "selected";
        number_companions.value = "0";
        number_companions.disabled = true;

        if (flag >= 2) room.disabled = true;
        else {
            room.disabled = false;
            room.value = "selected";
        }
    } else {
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

function getGuests() {
    let long = document.querySelectorAll("#container_tr > tr").length;
    let data_object_array = [];
    for (let i = 0; i < long; i++) {
        let guest = document.querySelectorAll(`#td_row${i + 1} > td`); // aca estamos obtenieno todos los campos para empezar a extraer los innerText

        data_object_array.push({
            nombres: guest[0].innerText.trim(),
            apellidos: guest[1].innerText.trim(),
            nacimiento: guest[2].innerText.trim(),
            tipo_documento: guest[3].innerText.trim(),
            cedula: guest[4].innerText.trim(),
            numero_acompanantes: guest[5].innerText.trim(),
            email: guest[6].innerText.trim(),
            origen: guest[7].innerText.trim(),
            destino: guest[8].innerText.trim(),
            estado_civil: guest[9].innerText.trim(),
            celular: guest[10].innerText.trim(),
            habitacion: guest[11].innerText.trim(),
        });
    }

    return data_object_array;
}

function deleteGuest(id_row) {
    let item = document.getElementById(`td_row${id_row}`);
    let room = document.getElementById("room");

    let flag = document.querySelectorAll("#container_tr > tr").length;

    if (flag < 1) room.disabled = false;

    item.remove();
}

function verifySend() {
    let price = document.getElementById("costo").value;

    let estadia = document.getElementById("estado").value;

    let finally_data = true;

    if (price === "")
        finally_data = "Debes ingresar el precio de alquiler de la habitacion";
    if (estadia === "selected") finally_data = "Debes elegir una estadia";

    return finally_data;
}

function verifyInputs2() {
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

    let number_companions = document.getElementById("number_companions").value;

    let type_document = document.getElementById("type_document").value;

    let data_verify = [
        room,
        estado_civil,
        type_document,
        number_companions,
        name_guest,
        last_name,
        fecha_nacimiento,
        cedula,
        correo,
        origen,
        destino,
        number_contact,
    ];

    let finally_data = true;

    data_verify.forEach((item, index) => {
        if (index >= 0 && index <= 2) {
            if (item === "selected") finally_data = false;
        }

        if (item.length < 1) finally_data = false;
    });

    return finally_data;
}

async function registerGuest(url) {
    let array = getGuests();

    let verify_send = verifySend();

    if (verify_send === true) {
        let price = document.getElementById("costo");
        let estadia = document.getElementById("estado");

        let token = localStorage.getItem("access_token");
        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
                registros: array,
                precio: price.value,
                estadia: estadia.value,
            }),
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
                title: "Se ha alquilado la habitacion de manera satisfactoria! "+ data.message,
            });
            console.log(data.message);

            price.value = "";
            estadia.value = "selected";
            document.getElementById("room").value = "selected";

            let deletes = document.getElementById("container_tr");

            deletes.innerHTML = "";

            let room = document.getElementById("room");

            room.disabled = false;
        }
    } else {
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

async function getForRangeGuests(url) {
    let date = document.getElementById("fecha_rango");
    let fecha = date.value;
    let token = localStorage.getItem("access_token");
    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            fecha: date.value,
        }),
    });

    let data = await response.json();

    if (data.status) {
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

async function getReservationsO(url) {
    let date = document.getElementById("");
    let token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "GET",
        headers: {
            contentType: "application/json",
            Authorization: `Bearer ${token}`,
        },
    });

    let data = await response.json();

    if (data.status) {
    }
}

async function makeReservation(url) {
    let verify = verificarInputs();
    if (verify) {
        let titular = document.getElementById("titular_reserva");
        let telefono = document.getElementById("telefono");
        let fecha = document.getElementById("date_reservation");
        let documento = document.getElementById("documento_cedula");
        let medio_pago = document.getElementById("select_medio_pago");
        let contacto = document.getElementById("contacto_numero");
        let huespedes = document.getElementById("number_huespedes");
        let descripcion = document.getElementById("description_reservation");
        let monto_reserva = document.getElementById("monto_reserva");
        let valor_paquete = document.getElementById("valor_total");

        let token = localStorage.getItem("access_token");
        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
                titular: titular.value,
                telefono: telefono.value,
                fecha: fecha.value,
                documento: documento.value,
                medio_pago: medio_pago.value,
                contacto: contacto.value,
                huespedes: huespedes.value,
                descripcion: descripcion.value,
                monto_reserva: monto_reserva.value,
                valor_paquete: valor_paquete.value,
            }),
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
                title: data.mesagge,
            });

            $("#reservationInformation").modal("show");

            let modal_id_body = document.getElementById("modal_body");



            modal_id_body.innerHTML = `<div class="row">

            <div class="col-sm">
                <label for="">Reservacion hecha por:</label> <span>${data.datos.titular}</span>
        <br>
        <label for="">cedula:</label> <span>${data.datos.cedula}</span>
        <br>
        <label for="">Abono reservado: <i class="fa-solid fa-dollar-sign text-success"></i></label><span>${data.datos.monto_reservado}</span>
        <br>
        <label for="">Adeuda: <i class="fa-solid fa-dollar-sign text-success"></i></label><span>${data.datos.monto_adeudado}</span>
        <br>
        <label for="">Medio de pago:</label> <span>${data.datos.medio_pago}</span>
        <br>
        <label for="">Número de huespedes:</label> <span>${data.datos.numero_huespedes}</span>
        <br>
        <label for="">Descripción:</label> <span>${data.datos.descripcion_reserva}</span>
            </div>
            <div class="col-sm">

                <label for="">Valor total de la reservación:</label> <span><i class="fa-solid fa-dollar-sign text-success"></i>${data.datos.valor_paquete}</span>
        <br>
        <label for="">Fecha de ingreso:</label> <span>${data.datos.fecha_reservacion}</span>
        <br>
        <label for="">Hora de reservación:</label> <span>${data.datos.hora_reserva}</span>
        <br>
        <label for="">Fecha de reserva:</label> <span>${data.datos.fecha}</span>
        <br>
        <label for="">contacto:</label> <span>${data.datos.contacto}</span>  
        <br>
        <label for="">Estado de la reserva:</label> <span class="badge badge-success">${data.datos.estado}</span>   
        <br>
        <label for="">Codigo de Reserva:</label> <span class="badge badge-success">${data.datos.id_reserva_unit}</span>

        
            </div>
        </div>
        <hr>
        <p>Nota: guarda esta informacion para canjear tu reservación, lo puedes hacer con el codigo de reserva.</p>`;
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
            title: "Por favor verifica que todos los campos estan bien diligenciados para realizar una reservación",
        });
    }
}

function verificarInputs() {
    let titular = document.getElementById("titular_reserva").value;
    let telefono = document.getElementById("telefono").value;
    let fecha = document.getElementById("date_reservation").value;
    let documento = document.getElementById("documento_cedula").value;
    let medio_pago = document.getElementById("select_medio_pago").value;
    let contacto = document.getElementById("contacto_numero").value;
    let huespedes = document.getElementById("number_huespedes").value;
    let descripcion = document.getElementById("description_reservation").value;

    let data_verify = [
        titular,
        telefono,
        documento,
        medio_pago,
        contacto,
        huespedes,
        descripcion,
    ];

    let finally_data = true;

    data_verify.forEach((item,index) => {
        if (item.length < 1) finally_data = false;
        console.log(`estoy en el indice ${index}, ademas la longitud es ${item.length}`);
    });

    if(fecha === "") finally_data = false;

    console.log(`la variable de verificacion es ${finally_data}`);

    return finally_data;
}


async function searchReservation(url) {
    

    let code = document.getElementById("search_reservation").value;
    let token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            codigo: code.trim(),
        }),
    });

    let data = await response.json();


    if(data.status){


        if(data.results == true){

             $("#reservationInformation").modal("show");

            let modal_id_body = document.getElementById("modal_body");

            let status = (data.datos.estado === "RESERVADO") ? "badge badge-success" : "badge badge-danger";

            modal_id_body.innerHTML = `<div class="row">

            <div class="col-sm">
                <label for="">Reservacion hecha por:</label> <span>${data.datos.titular}</span>
        <br>
        <label for="">cedula:</label> <span>${data.datos.cedula}</span>
        <br>
        <label for="">Abono reservado: <i class="fa-solid fa-dollar-sign text-success"></i></label><span>${data.datos.monto_reservado}</span>
        <br>
        <label for="">Adeuda: <i class="fa-solid fa-dollar-sign text-success"></i></label><span>${data.datos.monto_adeudado}</span>
        <br>
        <label for="">Medio de pago:</label> <span>${data.datos.medio_pago}</span>
        <br>
        <label for="">Número de huespedes:</label> <span>${data.datos.numero_huespedes}</span>
        <br>
        <label for="">Descripción:</label> <span>${data.datos.descripcion_reserva}</span>
            </div>
            <div class="col-sm">

                <label for="">Valor total de la reservación:</label> <span><i class="fa-solid fa-dollar-sign text-success"></i>${data.datos.valor_paquete}</span>
        <br>
        <label for="">Fecha de ingreso:</label> <span>${data.datos.fecha_reservacion}</span>
        <br>
        <label for="">Hora de reservación:</label> <span>${data.datos.hora_reserva}</span>
        <br>
        <label for="">Fecha de reserva:</label> <span>${data.datos.fecha}</span>
        <br>
        <label for="">contacto:</label> <span>${data.datos.contacto}</span>  
        <br>
        <label for="">Estado de la reserva:</label> <span class="${status}">${data.datos.estado}</span>   
        <br>
        <label for="">Codigo de Reserva:</label> <span class="badge badge-success">${data.datos.id_reserva_unit}</span>

        
            </div>
        </div>
        <hr>
        <p>Nota: guarda esta informacion para canjear tu reservación, lo puedes hacer con el codigo de reserva.</p>`;

        }else{


            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: "error",
                title: "No se ha encontrado la reservación, verifica el codigo de reserva",
            });
        }

           

    }

}



function closeModalInformation(){


    let modal_id_body = document.getElementById("modal_body");
    modal_id_body.innerHTML = "";

}


async function redmeeCode(url, id_reservation) {

    let token = localStorage.getItem("access_token");

    let response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            id_reserva: id_reservation,
        }),
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
            title: data.mesagge,
        });
    }else{


            var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        Toast.fire({
            icon: "error",
            title: data.mesagge,
        });


    }
}