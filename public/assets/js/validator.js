const errors = document.getElementById('error');
const form = document.getElementById('form');
let messages = [];
let error = false;

form.addEventListener("submit", (e) =>{

    const title = document.getElementById('task_title');
    const content = document.getElementById('task_content');
    if(title.value.length < 3) {
            messages.push("Le titre doit contenir au moins 3 caractères ! ");
            error = true;
    }

    if(title.value.length > 70) {
            messages.push("Le titre ne doit pas contenir plus de 70 caractères ! ");
            error = true;
    }
    

    if(content.value.length < 3) {
        messages.push("Le contenu doit contenir au moins 3 caractères ! ");
        error = true;
    }
        
    if(error == true){
            e.preventDefault();
            errors.innerText = messages.join(', ');
    }
}) 

