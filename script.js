navbar = document.querySelector('.header .flex .navbar');
document.querySelector('#menu-btn').onclick =() =>{
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}

profile = document.querySelector('.header .flex .profile');
document.querySelector('#user-btn').onclick =() =>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
} 

window.onscroll = () => {
    navbar.classList.remove('active');
    profile.classList.remove('active');
}

function loader(){
    document.querySelector('.loader').style.display = 'none';
 }
 
 function fadeOut(){
    setInterval(loader, 2000);
 }
 
 window.onload = fadeOut;


//order form
 function openOrderForm(dishName, price) {
    document.getElementById('dishName').value = dishName;
    document.getElementById('price').value = price;
    document.getElementById('orderFormModal').style.display = 'block';
}

function closeOrderForm() {
    document.getElementById('orderFormModal').style.display = 'none';
}



// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
    const modal = document.getElementById('orderFormModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Form submission handler
// document.getElementById('orderForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     alert('Order placed successfully!');
//     closeOrderForm();
// });
