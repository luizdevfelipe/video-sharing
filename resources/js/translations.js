export  function getTranslations() {
    const locale = import.meta.env.VITE_APP_LOCALE;

    const translations = {
        en: {
            enable2FACode: "To enable 2FA, you must scan this QR Code and submit the confirmation code below",
            submit: "Submit",
            code: "Code",
            invalid2FACode: "Invalid 2FA code",
            successEnable2FA: "2FA successfully enabled",
        },
        "pt-br": {
            enable2FACode: "Para ativar a 2FA, você deve escanear este QR Code e enviar o código de confirmação abaixo",
            submit: "Enviar",
            code: "Código",
            invalid2FACode: "Código 2FA inválido",
            successEnable2FA: "2FA ativada com sucesso",
        }
    };

    return translations[locale] || translations.en;
}