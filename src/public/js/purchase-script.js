document.addEventListener('DOMContentLoaded', function() {
    const changePaymentMethodButton = document.getElementById('change-payment-method');
    const paymentMethodSelection = document.getElementById('payment-method-selection');
    const selectedPaymentMethod = document.getElementById('selected-payment-method');
    const displaySelectedPaymentMethod = document.getElementById('display-selected-payment-method');
    const hiddenPaymentMethodInput = document.getElementById('hidden-payment-method');
    const submitButton = document.getElementById('submit-button');

    const post = document.getElementById('user-post').value;
    const address = document.getElementById('user-address').value;

    changePaymentMethodButton.addEventListener('click', function() {
        paymentMethodSelection.style.display = 'block';
    });

    document.getElementById('confirm-payment-method').addEventListener('click', function() {
        const selectedMethod = document.querySelector('input[name="payment-method"]:checked').value;
        const methodText = selectedMethod === 'card' ? 'クレジットカード' : '銀行振込';
        selectedPaymentMethod.textContent = methodText;
        displaySelectedPaymentMethod.textContent = methodText;
        hiddenPaymentMethodInput.value = selectedMethod;
        paymentMethodSelection.style.display = 'none';
    });

    if (!post || !address) {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
});

