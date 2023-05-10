function sendJsonRequest(url, data) {
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    };

    return fetch(url, requestOptions);
}

document.getElementById('login-form').addEventListener('submit', (event) => {
    event.preventDefault();

    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    sendJsonRequest('login.php', {email, password})
        .then((response) => {
            if (response.ok) {
                location.href = 'protected_page.php';
            } else {
                alert("Erreur lors de la connexion");
            }
        });
});

document.getElementById('register-form').addEventListener('submit', (event) => {
    event.preventDefault();

    const lastname = document.getElementById('register-lastname').value;
    const firstname = document.getElementById('register-firstname').value;
    const birth = document.getElementById('register-birth').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;

    sendJsonRequest('register.php', {lastname, firstname, birth, email, password})
        .then((response) => {
            if (response.ok) {
                alert("Inscription réussie");
            } else {
                alert("Erreur lors de l'inscription");
            }
        });
});
