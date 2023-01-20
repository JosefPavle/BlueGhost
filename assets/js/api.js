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
let  popupDiv = document.getElementById("popup");

matches.forEach(
    function (element) {
        let id = element.dataset.personid;

        element.addEventListener("click",
            async function (event){
                event.preventDefault();

                popupDiv.innerHTML = await getPersonDescription(id);
            }
        )
    }
)