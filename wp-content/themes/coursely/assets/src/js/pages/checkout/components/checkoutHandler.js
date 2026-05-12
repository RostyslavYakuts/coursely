import $ from 'jquery';
import { loadStripe } from '@stripe/stripe-js';


export const checkoutHandler = async () => {

    const $form = $('#checkout_form');
    if (!$form.length) return;

    const stripe = await loadStripe(localizedScript.spk);

    if (!stripe) return;

    const elements = stripe.elements();

    const elementStyle = {
        base: {
            fontSize: '16px',
            color: '#111827',
            fontFamily: 'inherit',
            '::placeholder': {
                color: '#9CA3AF',
            },
        },
    };

    const cardNumber = elements.create('cardNumber', {
        style: elementStyle,
    });

    const cardExpiry = elements.create('cardExpiry', {
        style: elementStyle,
    });

    const cardCvc = elements.create('cardCvc', {
        style: elementStyle,
    });

    cardNumber.mount('#card_number');
    cardExpiry.mount('#card_expiry');
    cardCvc.mount('#card_cvc');

    let stripeState = {
        cardNumber: false,
        cardExpiry: false,
        cardCvc: false,
    };
    cardNumber.on('change', (event) => {
        stripeState.cardNumber = event.complete;

        toggleStripeError('card_number_err', event);
    });

    cardExpiry.on('change', (event) => {
        stripeState.cardExpiry = event.complete;

        toggleStripeError('card_expiry_err', event);
    });

    cardCvc.on('change', (event) => {
        stripeState.cardCvc = event.complete;

        toggleStripeError('card_cvc_err', event);
    });


    $form.on('submit', async function (e) {

        e.preventDefault();

        const $submit = $(this).find('[type="submit"]');

        $submit.prop('disabled', true);

        const params = new URLSearchParams(window.location.search);
        const plan = params.get('price_id');

        $('.input-error').text('');
        let hasError = false;

        const requiredFields = [
            { id: '#subscriber_name', err: '#subscriber_name_err' },
            { id: '#subscriber_email', err: '#subscriber_email_err' },
            { id: '#subscriber_phone', err: '#subscriber_phone_err' },
            { id: '#subscriber_password', err: '#subscriber_password_err' },
            { id: '#subscriber_password_confirm', err: '#subscriber_password_confirm_err' },
            { id: '#subscriber_street_address', err: '#subscriber_street_address_err' },
            { id: '#subscriber_city', err: '#subscriber_city_err' },
            { id: '#subscriber_country', err: '#subscriber_country_err' },
            { id: '#subscriber_state', err: '#subscriber_state_err' },
            { id: '#subscriber_zip', err: '#subscriber_zip_err' },
        ];
        requiredFields.forEach(field => {
            const value = $(field.id).val();

            if (!value) {
                $(field.err).text('This field is required');
                hasError = true;
            }
        });
        if (!stripeState.cardNumber) {
            $('#card_number_err').text('Card number is incomplete');
            hasError = true;
        }

        if (!stripeState.cardExpiry) {
            $('#card_expiry_err').text('Expiration date is incomplete');
            hasError = true;
        }

        if (!stripeState.cardCvc) {
            $('#card_cvc_err').text('CVC is incomplete');
            hasError = true;
        }

        const email = $('#subscriber_email').val();
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            $('#subscriber_email_err').text('Invalid email');
            hasError = true;
        }
        const phone = $('#subscriber_phone').val();
        if (phone.length < 8) {
            $('#subscriber_phone_err').text('Invalid phone');
            hasError = true;
        }


        if (hasError) {
            $submit.prop('disabled', false);
            console.log('Has Error');
            return;
        }

        const { paymentMethod, error } =
            await stripe.createPaymentMethod({
                type: 'card',
                card: cardNumber,
                billing_details: {
                    name: $('#subscriber_cardholder_name').val(),
                    email: $('#subscriber_email').val(),
                    phone: $('#subscriber_phone').val(),

                    address: {
                        line1: $('#subscriber_street_address').val(),
                        line2: $('#subscriber_street_address_2').val(),
                        city: $('#subscriber_city').val(),
                        state: $('#subscriber_state').val(),
                        postal_code: $('#subscriber_zip').val(),
                        country: $('#subscriber_country').val(),
                    }
                }
            });

        if (error) {
            $('#card_number_err').text(error.message);
            $submit.prop('disabled', false);
            return;
        }

        console.log(paymentMethod);

        //Prepare ajax
        const formData = {
            action: localizedScript.checkout_action,
            nonce: localizedScript.checkout_nonce,
            payment_method_id: paymentMethod.id,
            plan_id: plan,

            // Subscriber Details
            subscriber_name: $('#subscriber_name').val(),
            subscriber_email: $('#subscriber_email').val(),
            subscriber_phone: $('#subscriber_phone').val(),
            subscriber_password: $('#subscriber_password').val(),
            subscriber_street_address: $('#subscriber_street_address').val(),
            subscriber_street_address_2: $('#subscriber_street_address_2').val(),
            subscriber_city: $('#subscriber_city').val(),
            subscriber_state: $('#subscriber_state').val(),
            subscriber_zip: $('#subscriber_zip').val(),
            subscriber_country: $('#subscriber_country').val(),
        };

        $.ajax({
            url: localizedScript.ajax_url,
            type: 'POST',
            data: formData,
            success: async function (response) {
                if (response.success) {
                    if (response.data.requires_action) {
                        const { client_secret } = response.data;

                        // show bank modal window
                        const { error, paymentIntent } = await stripe.confirmCardPayment(client_secret, {
                            payment_method: { card: cardNumber }
                        });

                        if (error) {
                          // wrong code or other
                            $('#card_number_err').text(error.message);
                            $submit.prop('disabled', false);
                        } else {
                            // Success 3D Secure
                            window.location.href = response.data.redirect_url || '/account/';
                        }

                    }else if (response.data.redirect_url) {
                        // --- no 3D Secure ---
                        window.location.href = response.data.redirect_url;
                    }else {
                        $('#card_number_err').text('Payment successful, but redirect failed.');
                        $submit.prop('disabled', false);
                    }

                } else {
                    $('#card_number_err').text(response.data.message);
                    $submit.prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                // Technical AJAX error (500, 404, etc)
                console.error(error);
                $('#card_number_err').text('An unexpected error occurred. Please try again.');
                $submit.prop('disabled', false);
            }
        });


        $submit.prop('disabled', false);
    });


    function toggleStripeError(id, event) {
        const $el = $('#' + id);

        if (event.error) {
            $el.text(event.error.message);
        } else {
            $el.text('');
        }
    }


};