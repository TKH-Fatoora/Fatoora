let user = document.querySelector('.header .flex .account');
let navbar = document.querySelector('.header .flex .navbar');

if (document.querySelector('#menu-btn')){

  document.querySelector('#menu-btn').addEventListener("click", () =>
  {
    navbar.classList.toggle('active');
    user.classList.remove('active');
  });
}

if (document.querySelector('#user-btn')){

  document.querySelector('#user-btn').addEventListener("click", () =>
  {
    user.classList.toggle('active');
    navbar.classList.remove('active');
  });
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   user.classList.remove('active');
}
