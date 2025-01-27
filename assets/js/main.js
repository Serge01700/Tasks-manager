let navBar = document.getElementById('bottom-nav');
let footerNone = document.getElementById('footer');
let editForm = document.getElementsByClassName('edit-form') ;


const statutDivs = document.querySelectorAll('#statut .statuts');
const taskContainers = document.querySelectorAll('#tasks .task-container');


let deconnexion = document.getElementById('logout-link');

deconnexion.addEventListener('click' , ()=> {
    let deconnexion = document.getElementById('logout-link');
    window.location.href = 'logout.php' ;
})

console.log(deconnexion);

function showEditForm(taskId) {
    document.getElementById('edit-form-' + taskId).style.display = 'block';
}

window.addEventListener('rezise', function(){
    if(window.innerWidth < 780){
        editForm.style.marginRight = '555px';
    }

})

function hideEditForm(taskId) {
    document.getElementById('edit-form-' + taskId).style.display = 'none';
}


window.addEventListener('resize', function() {
    let sideBar = document.getElementById('side-bar');
    if (window.innerWidth < 780) {
        sideBar.style.display = 'none';
        navBar.style.display = 'block'; 
        footerNone.style.display ='none';
    } else {
        sideBar.style.display = 'block';
        navBar.style.display = 'none'; 
        footerNone.style.display ='block'
    }
});

window.addEventListener('load', function() {
    let sideBar = document.getElementById('side-bar');
    if (window.innerWidth < 780) {
        sideBar.style.display = 'none';
        navBar.style.display = 'block'; 
    } else {
        sideBar.style.display = 'block';
        navBar.style.display = 'none';
    }
});





// statut

statutDivs.forEach(statutDiv => {
    statutDiv.addEventListener('click', () => {
        const statut = statutDiv.dataset.statut; // Récupère le statut *avant* de modifier les classes

        statutDivs.forEach(div => div.classList.remove('active'));
        statutDiv.classList.add('active');

        taskContainers.forEach(container => {
            if (container.dataset.statut === statut) {
                container.style.display = 'block'; 
            } else {
                container.style.display = 'none'; 
            }
        });
    });
});