document.getElementById('order').addEventListener('click', function () {
    // Display the payment processing animation
    document.getElementById('payment-animation').classList.remove('hidden');
    document.getElementById('payment-animation').classList.add('show');

    // Wait for some time to simulate the payment process
    setTimeout(function () {
        // Redirect to the homepage after the animation
        window.location.href = '../../index.html';
    }, 5000); // Adjust the timeout duration to match your animation
});