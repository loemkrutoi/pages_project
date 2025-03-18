let allPagesList = document.getElementById('allPagesList');
let visiblePagesList = document.getElementById("visiblePages");
let pageElement = allPagesList.querySelectorAll('.my-page-block');
let dragged = null;

allPagesList.addEventListener("dragstart", (event) => dragged = event.target);
visiblePagesList.addEventListener("dragover", function (event){
    event.preventDefault()
    let currentElement = event.target;
});
visiblePagesList.addEventListener("drop", (event) => {
    dragged.parentNode.removeChild(dragged);
    event.target.appendChild(dragged);
});
allPagesList.addEventListener('dragend', (event) => {
    event.visiblePagesList.classList.remove('selected');
});

visiblePagesList.addEventListener("dragstart", (event) => dragged = event.target);
allPagesList.addEventListener("dragover", function (event){
    event.preventDefault()
    let currentElement = event.target;
});
allPagesList.addEventListener("drop", (event) => {
    dragged.parentNode.removeChild(dragged);
    event.target.appendChild(dragged);
});
visiblePagesList.addEventListener('dragend', (event) => {
    event.allPagesList.classList.remove('selected');
});