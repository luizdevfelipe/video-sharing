import { getTranslations } from '@/js/translations.js';
import api from '../../../../services/api.js';

const translations = getTranslations();

document.addEventListener('DOMContentLoaded', function () {
    const twoFactorForm = document.getElementById('twoFactorForm');
    const formContainer = document.getElementById('form');

    if (twoFactorForm) {
        twoFactorForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const url = twoFactorForm.getAttribute('action');

            api.post(url)
                .then(function () {
                    api.get('api/two-factor-qr-code')
                        .then(function (response) {
                            formContainer.innerHTML = `
                                <div class="m-auto w-55">
                                    <div class="flex justify-center bg-white p-2">${response.data.svg}</div>
                                </div>
                                <p class="text-center dark:text-white">${translations.enable2FACode}</p>
                                <div class="mb-5 size-64 m-auto h-20">
                                    <label for="icode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">${translations.code}</label>
                                    <input type="text" id="icode" name="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123456" required autofocus />
                                </div>
                                <div class="flex justify-center">
                                    <button id="twoFactorConfirmCodeSubmit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">${translations.submit}</button>
                                </div>
                            `;
                        });
                })
                .catch(function () {
                    window.location.href = '/confirm-password';
                });
        });
    }

    if (formContainer) {
        formContainer.addEventListener('click', function (e) {
            if (e.target && e.target.id === 'twoFactorConfirmCodeSubmit') {
                e.preventDefault();
                const codeInput = document.getElementById('icode');
                api.post(
                    'api/confirmed-two-factor-authentication',
                    { code: codeInput ? codeInput.value : '' },
                    { headers: { 'Content-Type': 'application/json' } }
                )
                    .then(function () {
                        alert(translations.successEnable2FA);
                        window.location.href = '/profile/settings';
                    })
                    .catch(function (error) {
                        alert(error.response?.data?.message || 'Error');
                    });
            }
        });
    }
});
