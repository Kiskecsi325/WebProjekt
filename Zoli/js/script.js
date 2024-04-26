function showSidebar() {
    const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'flex';

}
function hideSidebar() {
    const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'none';

}

var darkmode = document.getElementById("darkModeSwitch");

// Ellenőrizzük, hogy van-e "darkmode" nevű cookie, és az alapján beállítjuk az oldal megjelenését
document.addEventListener("DOMContentLoaded", function() {
    var darkmodeCookie = getCookie("darkmode");
    if (darkmodeCookie && darkmodeCookie === "true") {
        document.body.classList.add("dark-theme");
        darkModeSwitch.src = "../images/Icons/sun.svg"; // Sötét módban a nap ikon
    } else {
        darkModeSwitch.src = "../images/Icons/moon.svg"; // Világos mód esetén a hold ikon
    }
});

darkmode.onclick = function () {
    // Ellenőrizzük, hogy van-e "darkmode" nevű cookie
    var darkmodeCookie = getCookie("darkmode");
    if (darkmodeCookie && darkmodeCookie === "true") {
        // Ha a cookie értéke "true", akkor töröljük, és világos módba váltunk
        document.cookie = "darkmode=false; expires=Fri, 31 Dec 9999 23:59:59 UTC; path=/;";
        document.body.classList.remove("dark-theme");
        darkModeSwitch.src = "../images/Icons/moon.svg"; // Világos mód esetén a hold ikon
    } else {
        // Ha a cookie nincs vagy az értéke "false", akkor hozzáadjuk, és sötét módba váltunk
        document.cookie = "darkmode=true; expires=Fri, 31 Dec 9999 23:59:59 UTC; path=/;";
        document.body.classList.add("dark-theme");
        darkModeSwitch.src = "../images/Icons/sun.svg"; // Sötét mód esetén a nap ikon
    }
}

// Segédfüggvény a cookie lekérdezéséhez
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
