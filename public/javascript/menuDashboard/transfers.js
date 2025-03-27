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
        
    }
}