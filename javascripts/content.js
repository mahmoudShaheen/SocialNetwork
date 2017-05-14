var Index = 0;
showSlide();

function showSlide() {
    var i;
    var slide = document.getElementsByClassName("content");
    for (i = 0; i < slide.length; i++) {
        slide[i].style.display = "none"; 
    }
    Index++;
    if (Index> slide.length) {Index = 1} 
    slide[Index-1].style.display = "block"; 
    setTimeout(showSlide, 1700); // Change image every 2 seconds
}
