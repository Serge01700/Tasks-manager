let navBar = document.getElementById('bottom-nav');
let footerNone = document.getElementById('footer');
window.addEventListener('resize', function() {
    let sideBar = document.getElementById('side-bar');
    if (window.innerWidth < 780) {
        sideBar.style.display = 'none';
        navBar.style.display = 'block'; 
        footerNone.style.display ='none';
    } else {
        sideBar.style.display = 'block';
        navBar.style.display = 'none'; 
        footerNone.style.diplay ='block'
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
