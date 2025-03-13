// Configura la URL base si es necesario



const input_pass = document.getElementById("pass");

input_pass.addEventListener('keypress', function(event){


    if(event.key === 'Enter'){

        sendData();

    }

});

// Configuración de AJAX para incluir el token CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

async function sendData() {
    let cedula = document.getElementById("cedula").value;
    let pass = document.getElementById("pass").value;

    console.log("Entra en la función: " + cedula);

    try {
        // const res = await $.ajax({
        //     url: './login',
        //     type: 'POST',
        //     dataType: 'json',
        //     data: { cedula, pass }
        // });

        let response = await fetch('./login',{

            method: "POST",
            headers: {

                "Content-Type": "application/json",
            },
            body: JSON.stringify({

                cedula,
                pass


            })
        });

        let data = await response.json();

        if (data.status) {

            localStorage.setItem('access_token', data.access_token);
            const token = localStorage.getItem('access_token');

            console.log("Token a enviar: " + token);

        //   let responses =  await fetch('/reloj/public/dashboard',{
        //         method: "POST",
        //         headers: {
        //             'Authorization': `Bearer ${token}`
        //         },
                
        //     })

                 window.location.href = `./dashboard?token=${encodeURIComponent(token)}`;

            console.log(data);
        }else{

            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 6000,
            });

    
            Toast.fire({
                icon: "error",
                title: "Clave erronea, por favor intenta nuevamente!",
            });
            throw new Error('Error en la respuesta del dashboard');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}