import $ from "jquery";

/**
 * @var grecaptcha
 * @var localizedScript
 */
export const formHandler = ()=>{


    document.addEventListener("DOMContentLoaded", function () {
        const phoneInput = document.getElementById("user_phone");
        if(!phoneInput){
            return;
        }
        const maxDigits = 12;
        phoneInput.addEventListener("input", function () {
            let val = this.value.replace(/[^0-9]/g, "");

            if (val.length > maxDigits) {
                val = val.substring(0, maxDigits);
            }

            this.value = val;
        });


    });
        const mainEvents = {

            filesToUpload: [],
            handleLoadFile: () => {
                const fileItem = (item) => {
                    return `
          <div class="file__item">
						<div class="item__close">
							<svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M10.0459 0.146484C9.85069 -0.0488281 9.5341 -0.0488281 9.33884 0.146484L5.09626 4.38916L0.853645 0.146484C0.658363 -0.0488281 0.341805 -0.0488281 0.146523 0.146484C-0.0487289 0.341797 -0.0487289 0.658203 0.146523 0.853516L4.38917 5.09619L0.146461 9.33887C-0.0488205 9.53418 -0.0488205 9.85083 0.146461 10.0459C0.341713 10.2412 0.658302 10.2412 0.853554 10.0459L5.09623 5.80322L9.33891 10.0459C9.53419 10.2412 9.85078 10.2412 10.046 10.0459C10.2413 9.85059 10.2413 9.53418 10.046 9.33887L5.80329 5.09619L10.0459 0.853516C10.2412 0.658447 10.2412 0.341797 10.0459 0.146484Z" fill="#B0B0B0"/>
							</svg>
						</div>
            <div class="item__name">${item}</div>
          </div>
          `;
                };

                $('#file_input').on('change', (e) => {
                    const input = $(e.currentTarget);
                    const $fileList = $('.file-list');
                    const file = $(e.target.files)[0];
                    console.log('single file', file);
                    console.log(!/\.(pdf|doc|docx|txt)$/i.test(file.name));
                    console.log(file.name);
                    if (!/\.(pdf|doc|docx|txt)$/i.test(file.name)) {
                        $fileList.text('Invalid extension file. (.pdf, .doc, .docx, .txt)');
                        input.val(null);
                        return;
                    }
                    if (file.size > 2079418) {
                        input.val(null);
                        $fileList.text('Files must be less than 2MB.');
                        return;
                    }
                    $fileList.html('');
                    $fileList.append(fileItem(file.name));
                    console.log('filesToUpload', mainEvents.filesToUpload);
                });
            },
            handleDeleteFile: () => {
                $(document).on('click', '.work .item__close', (e) => {
                    const $this = $(e.currentTarget);
                    $('#file_input').val(null);
                    $this.closest('.file__item').remove();
                });
            },
            handleSubmitForm: () => {
                const validateEmail = (email) => {
                    return String(email)
                        .toLowerCase()
                        .match(
                            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        );
                };
                async function validData() {
                    // Name
                    const $inputName = $('#user_name');
                    const $nameErrorMsg = $('.name-error-msg');
                    const inputName = $inputName.val();
                    if (inputName.length < 2) {
                        $inputName.closest('.form-group').addClass('has-error');
                        $nameErrorMsg.text('Invalid name, min length 2');
                        return false;
                    } else if ($inputName.closest('.form-group').hasClass('has-error')) {
                        $inputName.closest('.form-group').removeClass('has-error');
                        $nameErrorMsg.text('');
                    }
                    // Phone
                    const $inputPhone = $('#user_phone');
                    const $phoneErrorMsg = $('.phone-error-msg');
                    const inputPhone = $inputPhone.val().trim();
                    if (inputPhone.length < 8) {
                        $inputPhone.closest('.form-group').addClass('has-error');
                        $phoneErrorMsg.text('Invalid phone, min length 8');
                        return false;
                    } else if ($inputPhone.closest('.form-group').hasClass('has-error')) {
                        $inputPhone.closest('.form-group').removeClass('has-error');
                        $phoneErrorMsg.text('');
                    }

                    if (true) {
                        $inputPhone.closest('.form-group').addClass('has-error');
                        $phoneErrorMsg.text('Invalid phone number');
                        return false;
                    } else {
                        $inputPhone.closest('.form-group').removeClass('has-error');
                        $phoneErrorMsg.text('');
                    }

                    // Email
                    const $inputEmail = $('#user_email');
                    const $emailErrorMsg = $('.email-error-msg');
                    const inputEmail = $inputEmail.val();
                    if (!validateEmail(inputEmail)) {
                        $inputEmail.closest('.form-group').addClass('has-error');
                        $emailErrorMsg.text('Invalid email address!');
                        return false;
                    } else if ($inputEmail.closest('.form-group').hasClass('has-error')) {
                        $inputEmail.closest('.form-group').removeClass('has-error');
                        $emailErrorMsg.text('');
                    }

                    // Message
                    const $message = $('#user_message');
                    const $messageErrorMsg = $('.message-error-msg');
                    const messageValue = $message.val();
                    if (messageValue.length > 0 && messageValue.length < 10) {
                        $message.closest('.form-group').addClass('has-error');
                        $messageErrorMsg.text('Minimum number of characters 10');
                        return false;
                    } else if (messageValue.length > 0 && messageValue.length > 1000) {
                        $message.closest('.form-group').addClass('has-error');
                        $messageErrorMsg.text('Maximum number of characters: 1000');
                        return false;
                    }else{
                        $message.closest('.form-group').removeClass('has-error');
                        $messageErrorMsg.text('');
                    }

                    const pk = localizedScript.pk;
                    const token = await grecaptcha.execute(pk, {action: localizedScript.contacts_form_action});
                    const countryCode = $('.iti__selected-dial-code').text();
                    const countryLetterCode = $('.iti__selected-country .iti__flag').attr('class').match(/iti__([a-z]{2})\b/)[1];
                    const form_data = new FormData();
                    form_data.append('action', localizedScript.contacts_form_action);
                    form_data.append('nonce', localizedScript.contacts_form_nonce);
                    form_data.append('recaptcha_token', token);
                    form_data.append('utm', window.location.search);
                    form_data.append('user_name', inputName);
                    form_data.append('user_phone', inputPhone );
                    form_data.append('user_phone_code', countryCode);
                    form_data.append('user_country_code', countryLetterCode);
                    form_data.append('user_email', inputEmail);
                    form_data.append('user_message', messageValue);

                    const $fileInput = $('#file_input');
                    if ($fileInput.prop('files') && $fileInput.prop('files').length) {
                        form_data.append('file', $fileInput.prop('files')[0]);
                    }
                    return form_data;
                }
                const $form = $("#home_contacts_form");
                if (!$form) return;
                $form.on('submit', async function (e) {
                    e.preventDefault();
                    const data = await validData();
                    console.log(data);
                    if (data) {
                        $('.form-submit').css('pointer-events', 'none');
                        $.ajax({
                            url: localizedScript.ajax_url,
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: data,
                            async: true,
                            type: 'post',
                            dataType: 'json',
                            success: function (response) {
                                console.log('response', response);
                                if (response.success) {
                                    showThankYouModal(response.data.message, 'success');
                                    $form.reset();
                                    $('.file-ist').html('');
                                    mainEvents.filesToUpload = [];
                                    $('.form-submit').css('pointer-events', 'auto');
                                } else {
                                    showThankYouModal(response.data.message, 'failed');
                                    $('.form-submit').css('pointer-events', 'auto');
                                }
                            },
                        });
                    }
                    return false;
                });
            },
        }
    mainEvents.handleLoadFile();
    mainEvents.handleDeleteFile();
    mainEvents.handleSubmitForm();

    const showThankYouModal = (result,resultClass) => {
        const modal = document.getElementById('contacts_modal');
        modal.classList.remove('hidden');
        modal.classList.add(resultClass);
        $('#result_message').html(result);

        const closeButton = document.getElementById('modal_close');
        closeButton.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    };

}