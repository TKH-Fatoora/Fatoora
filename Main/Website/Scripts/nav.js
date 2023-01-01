
// selectng the divs for the navigation bar and the account info window
let user = document.querySelector('.header .flex .account');
let navbar = document.querySelector('.header .flex .navbar');

// _____________________________________________________________________________

// if the menu button is clicked, display the nav bar content and hide the account info window
if (document.querySelector('#menu-btn')){
  document.querySelector('#menu-btn').addEventListener("click", () =>
  {
    navbar.classList.toggle('active');
    user.classList.remove('active');
  });
}

// _____________________________________________________________________________

// if the account info button is clicked, display the account info content and hide the nav bar
if (document.querySelector('#user-btn')){
  document.querySelector('#user-btn').addEventListener("click", () =>
  {
    user.classList.toggle('active');
    navbar.classList.remove('active');
  });
}

// _____________________________________________________________________________

// if the user scrolled, hide both the nav bar content and the account info content
window.onscroll = () =>{
   navbar.classList.remove('active');
   user.classList.remove('active');
}
