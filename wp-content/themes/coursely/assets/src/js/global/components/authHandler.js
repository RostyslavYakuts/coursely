import * as $ from 'jquery';

export const authHandler = ()=>{
    $('#login_form').on('submit',async function (e) {
        e.preventDefault();

        const form = $(this);
        const pk = localizedScript.pk;
        const nonce = localizedScript.login_form_nonce;
        const action = localizedScript.login_form_action;
        $('.error').html('');
        const token = await grecaptcha.execute(pk, {action: action});
        $.ajax({
            url: localizedScript.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: action,
                nonce: nonce,
                recaptcha_token: token,
                email: $('#login_user_email').val().trim(),
                password: $('#login_user_password').val()
            },

            beforeSend() {
                form.addClass('loading');
            },

            success(response) {
                console.log(response);
                if (response.success) {
                    window.location.reload();
                    return;
                }

                if (response.data?.field_errors) {
                    Object.entries(response.data.field_errors).forEach(
                        ([field, message]) => {
                            $(`#${field}_error`).text(message);
                        }
                    );
                }

                if (response.data?.message) {
                    alert(response.data.message);
                }
            },

            complete() {
                form.removeClass('loading');
            }
        });


    })
}