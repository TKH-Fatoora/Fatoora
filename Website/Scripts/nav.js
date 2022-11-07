let user = document.querySelector('.header .flex .account');
let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').addEventListener("click", () =>
{
   navbar.classList.toggle('active');
   user.classList.remove('active');
});

document.querySelector('#user-btn').addEventListener("click", () =>
{
   user.classList.toggle('active');
   navbar.classList.remove('active');
});

window.onscroll = () =>{
   navbar.classList.remove('active');
   user.classList.remove('active');
}
