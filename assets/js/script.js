const navToggle = document.querySelector(".nav-toggle");
const nav = document.querySelector(".nav");
const navOverlay = document.querySelector(".nav-overlay");
const closeNav = document.querySelector(".close");

navToggle.addEventListener("click",() =>{

 	navShow();
})
closeNav.addEventListener("click",() =>{
 	hideNav();
})
 
// hide nav after clicked outside of nav
navOverlay.addEventListener("click",(e) =>{
   hideNav();
})

function navShow(){
    navOverlay.style.transition = "all 0.5s ease";
    navOverlay.classList.add("open");
    nav.style.transition = "all 0.3s ease 0.5s";
    nav.classList.add("open");
}

function hideNav(){
   nav.style.transition = "all 0.3s ease";
   nav.classList.remove("open");
   navOverlay.style.transition = "all 0.5s ease 0.3s";
   navOverlay.classList.remove("open");
}

var words = document.getElementsByClassName('word');
var wordArray = [];
var currentWord = 0;

words[currentWord].style.opacity = 1;
for (var i = 0; i < words.length; i++) {
    splitLetters(words[i]);
}

function changeWord() {
    var cw = wordArray[currentWord];
    var nw = currentWord == words.length-1 ? wordArray[0] : wordArray[currentWord+1];
    for (var i = 0; i < cw.length; i++) {
        animateLetterOut(cw, i);
    }
        
    for (var i = 0; i < nw.length; i++) {
        nw[i].className = 'letter behind';
        nw[0].parentElement.style.opacity = 1;
        animateLetterIn(nw, i);
    }
        
        currentWord = (currentWord == wordArray.length-1) ? 0 : currentWord+1;
}

function animateLetterOut(cw, i) {
    setTimeout(function() {
        cw[i].className = 'letter out';
    }, i*80);
}

function animateLetterIn(nw, i) {
    setTimeout(function() {
        nw[i].className = 'letter in';
    }, 340+(i*80));
}

function splitLetters(word) {
    var content = word.innerHTML;
    word.innerHTML = '';
    var letters = [];
    for (var i = 0; i < content.length; i++) {
        var letter = document.createElement('span');
        letter.className = 'letter';
        letter.innerHTML = content.charAt(i);
        word.appendChild(letter);
        letters.push(letter);
    }
        
    wordArray.push(letters);
}

changeWord();
setInterval(changeWord, 4000);

$(document).ready(function(){
    $(window).scroll(function(){
        if($(window).scrollTop() < 100){ //-navbar-----scrolltop---fixed---jquery--/
            $('.planewrap').removeClass('navbar-scroll');
        } 
        else {
            $('.planewrap').addClass('navbar-scroll');
        }
    });

});


$(document).ready(function() {
    $('.open-menu').on('click', function() {
        $('.overlay').addClass('open');
    });

    $('.close-menu').on('click', function() {
        $('.overlay').removeClass('open');
    });
});
function aos_init() {
    AOS.init({
      duration: 1000,
    });
  }
  $(window).on('load', function() {
    aos_init();
});
//loader//
$(window).on('load', function() {
    if ($('#preloader').length) {
      $('#preloader').delay(500).fadeOut('slow', function() {
        $(this).remove();
      });
    }
});
AOS.init()
$('#radioUmum').on('click', function () {
    $('#mahasiswa').hide()
})

$('#radioMhs').on('click', function () {
    $('#mahasiswa').show()
})