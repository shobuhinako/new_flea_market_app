document.addEventListener('DOMContentLoaded', async function() {
    const paymentForm = document.getElementById('payment-form');
    const stripeKey = paymentForm.getAttribute('data-stripe-key');
    const paymentIntentUrl = paymentForm.getAttribute('data-payment-intent-url');
    const csrfToken = paymentForm.getAttribute('data-csrf-token');
    const itemId = paymentForm.getAttribute('data-item-id');

    const stripe = Stripe(stripeKey);

    const response = await fetch(paymentIntentUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            item_id: itemId,
        }),
    });

    const { clientSecret } = await response.json();

    const elements = stripe.elements({
        clientSecret,
        appearance: {
            theme: 'stripe',
            labels: 'floating',
            variables: {
                colorPrimary: '#0570de',
                colorBackground: '#ffffff',
                colorText: '#32325d',
                colorDanger: '#df1b41',
                fontFamily: 'Ideal Sans, system-ui, sans-serif',
                spacingUnit: '2px',
                borderRadius: '4px'
            },
            rules: {
                '.Link': {
                    display: 'none'
                },
                '.Tab': {
                    display: 'none'
                }
            }
        }
    });

    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-form');

    document.getElementById('submit-button').addEventListener('click', async (e) => {
        e.preventDefault();
        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: `${window.location.origin}/return.html`,
            },
        });

        if (error) {
            console.error(error.message);
        } else {
            console.log('Payment successful!');
        }
    });

    document.getElementById('change-payment-method').addEventListener('click', function(e) {
        e.preventDefault();
        const paymentMethod = prompt('支払い方法を選択してください（cardまたはbank_transfer）:');
        if (paymentMethod === 'bank_transfer' || paymentMethod === 'card') {
            fetch(paymentIntentUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    item_id: itemId,
                    payment_method: paymentMethod,
                }),
            })
            .then(response => response.json())
            .then(data => {
                elements.update({ clientSecret: data.clientSecret });
            });
        } else {
            alert('無効な支払い方法です。');
        }
    });
});
