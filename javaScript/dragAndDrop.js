// let allPagesList = document.getElementById('allPagesList');
// let visiblePagesList = document.getElementById("visiblePages");

// let pageElement = allPagesList.querySelectorAll('.my-page-block');
// let dragged = null;

// allPagesList.addEventListener("dragstart", (event) => dragged = event.target);
// visiblePagesList.addEventListener("dragover", function (event){
//     event.preventDefault()
//     let currentElement = event.target;
// });
// visiblePagesList.addEventListener("drop", (event) => {
//     dragged.parentNode.removeChild(dragged);
//     event.target.appendChild(dragged);
// });
// allPagesList.addEventListener('dragend', (event) => {
//     event.visiblePagesList.classList.remove('selected');
// });

// visiblePagesList.addEventListener("dragstart", (event) => dragged = event.target);
// allPagesList.addEventListener("dragover", function (event){
//     event.preventDefault()
//     let currentElement = event.target;
// });
// allPagesList.addEventListener("drop", (event) => {
//     dragged.parentNode.removeChild(dragged);
//     event.target.appendChild(dragged);
// });
// visiblePagesList.addEventListener('dragend', (event) => {
//     event.allPagesList.classList.remove('selected');
// });

let pagesLists = document.querySelectorAll('.pagesList');
let draggables = document.querySelectorAll('.draggable');

draggables.forEach(draggable => {
    draggable.addEventListener('dragstart', () => {
        draggable.classList.add('dragging');
    });
    draggable.addEventListener('dragend', () => {
        draggable.classList.remove('dragging');
    });
});
pagesLists.forEach(pageList => {
    pageList.addEventListener('dragover', event => {
        event.preventDefault();
        let afterElement = dragAfter(pageList, event.clientY);
        console.log(afterElement);
        let draggable = document.querySelector('.dragging');

        if(afterElement == null){
            pageList.appendChild(draggable);
        } else {
            pageList.insertBefore(draggable, afterElement);
        }
    })
});
function dragAfter(pageList, y){
    let draggableElements = [...pageList.querySelectorAll('.draggable:not(.dragging)')];
    return draggableElements.reduce((closest, child) => {
        let box = child.getBoundingClientRect();
        let offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset){
            return {offset: offset, element: child};
        } else {
            return closest;
        }
    }, {offset: Number.NEGATIVE_INFINITY}).element;
}