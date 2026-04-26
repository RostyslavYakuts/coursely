/**
 * @var grecaptcha
 * @var localizedScript
 */
export const contactFormHandler = () => {
    const form = document.getElementById("contact_us_form");
    if (!form) return;

    function shortenFileName(name) {
        const dotIndex = name.lastIndexOf('.');
        if (dotIndex === -1) return name;
        const ext = name.slice(dotIndex);
        const base = name.slice(0, dotIndex);
        if (base.length <= 15) return name;
        return base.slice(0, 15) + '(...)' + ext;
    }

    const fileInput = document.getElementById('user_file');
    const placeholder = document.querySelector('.file-placeholder-js');
    const placeholderText = placeholder.textContent;
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) {
            placeholder.textContent = shortenFileName(fileInput.files[0].name);
        } else {
            placeholder.textContent = placeholderText;
        }
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const name = form.querySelector("#user_name").value.trim();
        const email = form.querySelector("#user_email").value.trim();
        const message = form.querySelector("#user_message").value.trim();
        const nameError = form.querySelector("#user_name_error");
        const emailError = form.querySelector("#user_email_error");
        const messageError = form.querySelector("#user_message_error");
        const fileError = form.querySelector("#user_file_error");
        const globalMsg = document.getElementById("result_message");
        [nameError, emailError, messageError].forEach(el => {
            el.textContent = ""; el.classList.add("hidden");
        });
        form.querySelectorAll(".form-input").forEach(el =>{
            el.classList.remove("border-error");
        });
        let valid = true;

        const nameLabel = document.querySelector('label[for="user_name"]');
        const emailLabel = document.querySelector('label[for="user_email"]');
        const messageLabel = document.querySelector('label[for="user_message"]');
        const fileLabel = document.querySelector('.pseudo-label');

        if (name.length < 2) {
            nameLabel.classList.add('label-error');
            nameError.textContent = "Please enter your name (min. 2 chars)";
            nameError.classList.remove("hidden");
            form.querySelector("#user_name").classList.add("border-error");
            valid = false;
        }else if (name.length > 200) {
            nameLabel.classList.add('label-error');
            nameError.textContent = "Your name is too long. (max. 200 chars)";
            nameError.classList.remove("hidden");
            form.querySelector("#user_name").classList.add("border-error");
            valid = false;
        }else{
            nameLabel.classList.remove('label-error');
            nameError.classList.add("hidden");
            form.querySelector("#user_name").classList.remove("border-error");
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            emailLabel.classList.add('label-error');
            emailError.textContent = "Please enter a valid email.";
            emailError.classList.remove("hidden");
            form.querySelector("#user_email").classList.add("border-error");
            valid = false;
        }else{
            emailLabel.classList.remove('label-error');
        }

        const messageValue = message;
        if (messageValue.length > 0 && messageValue.length < 10) {
            messageLabel.classList.add('label-error');
            messageError.textContent = "Minimum number of characters 10";
            messageError.classList.remove("hidden");
            form.querySelector("#user_message").classList.add("border-error");
            valid = false;
        } else if (messageValue.length > 0 && messageValue.length > 1000) {
            messageLabel.classList.add('label-error');
            messageError.textContent = "Maximum number of characters: 1000";
            messageError.classList.remove("hidden");
            form.querySelector("#user_message").classList.add("border-error");
            valid = false;
        }else{
            messageLabel.classList.remove('label-error');
        }

        if (fileInput.files.length) {
            const file = fileInput.files[0];
            const allowedTypes = ["text/plain", "image/jpeg", "image/png", "application/pdf"];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (!allowedTypes.includes(file.type)) {
                fileLabel.classList.add('label-error');
                fileError.textContent = "Only TXT, JPG, PNG, PDF files are allowed.";
                fileError.classList.remove("hidden");
                fileInput.classList.add("border-error");
                valid = false;
            } else if (file.size > maxSize) {
                fileLabel.classList.add('label-error');
                fileError.textContent = "File size must not exceed 2MB.";
                fileError.classList.remove("hidden");
                fileInput.classList.add("border-error");
                valid = false;
            } else {
                fileLabel.classList.remove('label-error');
                fileError.classList.add("hidden");
                fileInput.classList.remove("border-error");
            }
        }

        if (!valid) return;



        const pk = localizedScript.pk;
        const nonce = localizedScript.contact_us_form_nonce;
        const action = localizedScript.contact_us_form_action;


        try {
            const token = await grecaptcha.execute(pk, { action: action });

            const formData = new FormData();
            formData.append("action", action);
            formData.append("name", name);
            formData.append("email", email);
            formData.append("message", message);
            formData.append("nonce", nonce);
            formData.append("recaptcha_token", token);

            // Add file if selected
            if (fileInput.files.length) {
                formData.append("user_file", fileInput.files[0]);
            }

            const res = await fetch(localizedScript.url, {
                method: "POST",
                body: formData,
            });

            const result = await res.json();
            console.log(result);
            if (result.success === false) {
                globalMsg.innerHTML = result?.data?.message || "Error. Try again later.";
                showThankYouModal('fail');
                return;
            }

            form.reset();
            placeholder.textContent = placeholderText; // reset file placeholder
            globalMsg.innerHTML = result?.data?.message || "Thank you for your message!";
            showThankYouModal('success');
        } catch (error) {
            console.log(error);
            globalMsg.textContent = "Connecting Error. Try again later.";
            showThankYouModal('fail');
        }
    });
};


const showThankYouModal = (result) => {
    const modal = document.getElementById('contact_us_modal');
    modal.classList.remove('hidden');
    modal.classList.add(result);

    const closeButton = document.getElementById('modal_close');
    closeButton.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
};