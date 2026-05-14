export const processingPage = () => {

    const tokenEl = document.querySelector(
        '[data-signup-token]'
    );

    if (!tokenEl) return;

    const token = tokenEl.dataset.signupToken;
    const nonce = tokenEl.dataset.nonce;

    const interval = setInterval(async () => {

        const res = await fetch(
            localizedScript.ajax_url,
            {
                method: 'POST',
                headers: {
                    'Content-Type':
                        'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    action: 'check_checkout_status',
                    token:token,
                    nonce:nonce
                })
            }
        );

        const json = await res.json();

        console.log(json);

        if (!json.success) {
            return;
        }

        if (json.data.ready) {
            clearInterval(interval);
            window.location.href = json.data.redirect_url;
        }

    }, 2000);
};