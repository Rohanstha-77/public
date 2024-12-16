
document.addEventListener("DOMContentLoaded", () => {

    const categoryList = document.querySelectorAll('.category_list');
    categoryList.forEach(function (category) {
        console.log(category.textContent); 
        category.addEventListener('click', () => {
            alert('Category clicked: ' + category.textContent); // Display the clicked category name
        });
    });

});
console.log('helksjfs')
alert('working');