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

    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    sendJsonRequest('login.php', {username, password})
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

    const username = document.getElementById('register-username').value;
    const password = document.getElementById('register-password').value;

    sendJsonRequest('register.php', {username, password})
        .then((response) => {
            if (response.ok) {
                alert("Inscription réussie");
            } else {
                alert("Erreur lors de l'inscription");
            }
        });
});
