document.addEventListener('touchstart', handleTouchStart, false);
document.addEventListener('touchmove', handleTouchMove, false);
document.addEventListener('mousedown', handleMouseStart, false);
document.addEventListener('mousemove', handleMouseMove, false);

let x1 = null;
let swipe_size = null;

function handleTouchStart(event){
    x1 = event.touches[0].clientX;
    swipe_size = 0.8*window.innerWidth;
}

function handleTouchMove(event){
    if(!x1){
        return false;
    }
    let x2 = event.touches[0].clientX;
    if((x2-x1)>swipe_size){
        document.getElementById('main_menu').style.display = "block";
        document.getElementById('block_main').style.display = "none";
    } else if((x2-x1)<-swipe_size){
        document.getElementById('main_menu').style.display="none";
        document.getElementById('block_main').style.display = "block";
    }
}

function handleMouseStart(event){
    x1 = event.pageX;
    swipe_size = 0.8*window.innerWidth;
}

function handleMouseMove(event){
    if(!x1){
        return false;
    }
    x2 = event.pageX;
    if((x2-x1)>swipe_size){
        document.getElementById('main_menu').style.display = "block";
        document.getElementById('block_main').style.display = "none";
        x1 = null;
    } else if((x2-x1)<-swipe_size){
        document.getElementById('main_menu').style.display="none";
        document.getElementById('block_main').style.display = "block";
        x1 = null;
    }
}

let check = 1;
function displayOptions(){
    let options = document.getElementsByClassName('options');
    let records = document.getElementsByClassName('records');
    if(check) {
        for (let i = 0; i < options.length; i++) {
            options[i].style.display = "block";
            records[i].style.display = "none";
        }
        check = 0;
    }
    else{
        for (let i = 0; i < options.length; i++) {
            options[i].style.display = "none";
            records[i].style.display = "block";
        }
        check = 1;
    }
}