var burgerBtn = document.getElementById('burgerBtn');
var closeBtn = document.getElementById('closeBtn');
var mobile = document.getElementById('mobile-menu');

burgerBtn.addEventListener('click', function(e) {
  e.preventDefault();
  mobile.classList.toggle('active');
  
}, false);

closeBtn.addEventListener('click', function(e) {
  e.preventDefault();
  mobile.classList.toggle('active');
  
}, false);
document.addEventListener('swiped-left', function() {

  var mobile = document.getElementById('mobile-menu');
  mobile.classList.remove('active');

}, false);