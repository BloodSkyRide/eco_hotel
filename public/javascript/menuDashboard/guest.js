





console.log("vea parcero")
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


    }


}