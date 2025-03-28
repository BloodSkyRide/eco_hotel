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
        listenEvent();
    }
}

function listenEvent(){
    var input_image = document.getElementById("comprobante_transferencia");
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