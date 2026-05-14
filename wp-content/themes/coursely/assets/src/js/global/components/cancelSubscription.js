/**
 * @var localizedScript
 */
export const cancelSubscription = ()=>{
    const buttons = document.querySelectorAll('.cancel-subscription-js');

    if (!buttons.length) return;
    buttons.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();

            const subscriptionId = btn.dataset.subscription_id;
            const nonce = btn.dataset.nonce;

            if (!subscriptionId || !nonce) {
                console.error('Missing subscription ID or nonce');
                return;
            }

            if (!confirm('Are you sure you want to cancel your subscription?')) {
                return;
            }

            btn.disabled = true;
            const originalText = btn.innerText;
            btn.innerText = 'Processing...';

            try {
                const res = await fetch(localizedScript.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'cancel_subscription',
                        subscription_id: subscriptionId,
                        nonce: nonce
                    })
                });

                const json = await res.json();

                if (!json.success) {
                    alert(json.data?.message || 'Error cancelling subscription');
                    btn.disabled = false;
                    btn.innerText = originalText;
                    return;
                }

                alert(json.data.message);
                window.location.reload();

            } catch (error) {
                console.error(error);
                alert('Network error. Please try again.');
                btn.disabled = false;
                btn.innerText = originalText;
            }
        });
    });
}