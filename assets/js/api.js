function apiCall(url) {
    return fetch(url, {
        method:"GET",
        headers:{
            "Content-Type":"application/json"
        }
    }).then(
        (response)=>{
            return response.text();
        }
    ).then(
        (data)=>{
            return JSON.parse(data);
        }
    )
}

export function getPersonDescription(id) {
    return apiCall("/api/getPersonDescription/"+id);
}

let matches = document.querySelectorAll(".getDetail");
let popupDiv = document.getElementById("popup");
let popupText = document.getElementById("popupText");

matches.forEach(
    function (element) {
        let id = element.dataset.personid;

        element.addEventListener("click",
            async function (event){
                event.preventDefault();

                popupText.innerHTML = await getPersonDescription(id);
                popupDiv.style.visibility = "visible"
            }
        )
    }
)

document.addEventListener("keyup",
    function (key){
        if (key.code === "Escape"){
            popupDiv.style.visibility = "hidden"
        }
    }
)
document.addEventListener("click",
    function (event) {
        if (event.target.id === "popup" || event.target.id === "buttonClose"){
            popupDiv.style.visibility = "hidden"
        }
    }
)