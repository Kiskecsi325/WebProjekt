function showSidebar(){
    const sidebar =document.querySelector('.sidebar')
    sidebar.style.display='flex';
    
}
function hideSidebar(){
    const sidebar =document.querySelector('.sidebar')
    sidebar.style.display='none';
   
}

var darkmode = document.getElementById("darkModeSwitch");

darkmode.onclick=function(){
    document.body.classList.toggle("dark-theme");
    if(document.body.classList.contains("dark-theme")){
        darkModeSwitch.src="../images/Icons/sun.svg" 
    }else{
        darkModeSwitch.src="../images/Icons/moon.svg";
    }
}

