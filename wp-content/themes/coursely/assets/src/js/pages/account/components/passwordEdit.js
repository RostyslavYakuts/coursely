import * as $ from 'jquery';

/**
 * @var userLocalizedScript
 */
export const passwordEdit = () => {

    const form = $('#profile_password_edit');

    if (!form.length) {
        return;
    }

    form.on('submit', function (e) {

        e.preventDefault();

        const currentPassword = $('#user_current_password').val().trim();
        const newPassword = $('#user_new_password').val().trim();
        const repeatPassword = $('#user_repeat_new_password').val().trim();

        if (!currentPassword || !newPassword || !repeatPassword) {
            alert('All fields are required');
            return;
        }

        if (newPassword.length < 8) {
            alert('Password must contain at least 8 characters');
            return;
        }

        if (newPassword !== repeatPassword) {
            alert('Passwords do not match');
            return;
        }

        const formData = new FormData(this);

        formData.append(
            'action',
            userLocalizedScript.password_edit_action
        );

        formData.append(
            'nonce',
            userLocalizedScript.password_edit_nonce
        );

        $.ajax({
            url: userLocalizedScript.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: (response) => {
                console.log(response);
                if (!response.success) {
                    alert(response.data.message);
                    return;
                }

                alert(response.data.message);

                form.trigger('reset');
            },

            error: (error) => {
                console.log(error);
            }
        });
    });
};