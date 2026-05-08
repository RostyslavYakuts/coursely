import * as $ from 'jquery';

/**
 * @var userLocalizedScript
 */
export const profileSettingsEdit = () => {
    const form = $('#profile_settings_edit');

    if (!form.length) {
        return;
    }

    const imageInput = $('#user_photo');
    const imageWrapper = $('#user_image_wrapper');

    imageInput.on('change', function () {
        const file = this.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = (e) => {
            imageWrapper.html(`
                <img 
                    class="rounded-full object-cover w-[120px] h-[120px]"
                    src="${e.target.result}"
                    alt="user-preview"
                    width="120"
                    height="120"
                >
            `);
        };

        reader.readAsDataURL(file);
    });

    form.on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        formData.append('action', userLocalizedScript.profile_settings_edit_action);
        formData.append('nonce', userLocalizedScript.profile_settings_edit_nonce);

        $.ajax({
            url: userLocalizedScript.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: (response) => {
                console.log(response);
                alert('Profile Settings are updated successfully');
            },
            error: (error) => {
                console.log(error);
            }
        });
    });
};