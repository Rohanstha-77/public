let increaseNumber = document.getElementById('increaseNumber');
let decreaseNumber = document.getElementById('decreaseNumber');
let productNumber = document.getElementById('product_number');
let number = 1;

increaseNumber.addEventListener("click", () => {
    if (number < 20) {
        number++;
    }
    productNumber.innerHTML = number;
})
decreaseNumber.addEventListener("click", () => {
    if (number > 0) {
        number--;
    }
    productNumber.innerHTML = number;
});

// alert('working')