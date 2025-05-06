export  function getTranslations() {
    const locale = import.meta.env.VITE_APP_LOCALE;

    const translations = {
        en: {
            enable2FACode: "To enable 2FA, you must scan this QR Code and submit the confirmation code below"
        },
        "pt-br": {
            enable2FACode: "Para ativar a 2FA, você deve escanear este QR Code e enviar o código de confirmação abaixo"
        }
    };

    return translations[locale] || translations.en;
}