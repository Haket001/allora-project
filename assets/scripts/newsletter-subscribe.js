document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('subscribe-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const email = form.subscriber_email.value;
        const messageDiv = document.getElementById('subscribe-message');

        const data = new FormData();
        data.append('action', 'save_subscription_email');
        data.append('subscriber_email', email);

        fetch(SubscribeFormData.ajax_url, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                messageDiv.textContent = 'Successfully subscribed!';
                form.reset();
            } else {
                messageDiv.textContent = result.data || 'Subscription failed.';
            }
        })
        .catch(() => {
            messageDiv.textContent = 'Error. Please try again later.';
        });
    });
});