document.addEventListener('DOMContentLoaded', function() {
    // Select the form by its tag or assign an ID (e.g., #contactForm)
    const form = document.querySelector('form');

    if (!form) return;

    // Create a container for status messages if one doesn't exist
    let responseMessage = document.createElement('div');
    responseMessage.className = 'mt-3 text-center fw-bold';
    form.appendChild(responseMessage);

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent standard page refresh

        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);

        // Feedback during loading
        responseMessage.style.color = '#333';
        responseMessage.textContent = 'Šaljem...';
        if (submitBtn) submitBtn.disabled = true;

        fetch('send_mail.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                responseMessage.style.color = 'green';
                responseMessage.textContent = data.message;
                form.reset(); // Clear input fields
            } else {
                responseMessage.style.color = 'red';
                responseMessage.textContent = data.message;
            }
        })
        .catch(error => {
            responseMessage.style.color = 'red';
            responseMessage.textContent = 'Došlo je do greške prilikom slanja.';
            console.error('Error:', error);
        })
        .finally(() => {
            if (submitBtn) submitBtn.disabled = false;
        });
    });
});