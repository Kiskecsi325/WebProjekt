function showSidebar(){
    const sidebar =document.querySelector('.sidebar')
    sidebar.style.display='flex';
    
}
function hideSidebar(){
    const sidebar =document.querySelector('.sidebar')
    sidebar.style.display='none';
   
}

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Az alapértelmezett esemény megszakítása (az űrlap küldésének megakadályozása)

    // Ellenőrizd a mezőket
    let formIsValid = true;
    document.querySelectorAll('.inputBox input, .inputBox textarea').forEach(function(input) {
        if (!input.checkValidity()) {
            formIsValid = false;
            input.parentNode.querySelector('.error-txt').style.display = 'block'; // Hibaszöveg megjelenítése
        } else {
            input.parentNode.querySelector('.error-txt').style.display = 'none'; // Hibaszöveg elrejtése
        }
    });

    // Ellenőrizd az email címet
    const emailInput = document.querySelector('input[type="email"]');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailInput && !emailPattern.test(emailInput.value)) {
        formIsValid = false;
        emailInput.parentNode.querySelector('.error-txt').style.display = 'block';
    } else if (emailInput) {
        emailInput.parentNode.querySelector('.error-txt').style.display = 'none';
    }

    // Ellenőrizd a telefonszámot
    const phoneInput = document.querySelector('input[type="tel"]');
    const phonePattern = /^\+(?:36)(?:20|30|70)\d{3}\d{2}\d{2}$/;
    if (phoneInput && !phonePattern.test(phoneInput.value)) {
        formIsValid = false;
        phoneInput.parentNode.querySelector('.error-txt').style.display = 'block';
    } else if (phoneInput) {
        phoneInput.parentNode.querySelector('.error-txt').style.display = 'none';
    }

    // Ha az űrlap érvényes, elküldheted az adatokat
    if (formIsValid) {
        // Ide írd meg az adatküldés logikáját vagy hívj egy funkciót, ami ezt végzi
        alert('Az űrlap érvényes, elküldhető!');
    }
});