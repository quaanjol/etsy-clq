var sideBarItems = document.querySelectorAll('.side-bar-item');
Array.from(sideBarItems).forEach(item => {
    item.classList.remove('active');
})