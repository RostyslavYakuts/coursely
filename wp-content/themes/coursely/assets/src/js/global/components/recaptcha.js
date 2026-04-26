/**
 * @var localizedScript
 */
export const recaptcha = ()=>{
	const pk = localizedScript.pk;
	if (document.querySelector('#recaptcha-script')) return;

	const recaptchaScript = document.createElement("script");
	recaptchaScript.id = 'recaptcha-script';
	recaptchaScript.src = "https://www.google.com/recaptcha/api.js?render=" + pk;
	recaptchaScript.async = true;
	document.head.appendChild(recaptchaScript);
}

