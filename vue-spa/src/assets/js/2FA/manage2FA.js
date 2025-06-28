import api from '../../../../services/api.js';

export function remove2FA() {
    api.post('api/two-factor-authentication', {
        _method: 'DELETE',
    }).then(function () {
        location.reload();
    });
}

export function getCodes() {
    api.get('api/two-factor-recovery-codes')
        .then(function (response) {
            const button = document.getElementById('getCodes')
            if (button) { button.remove(); }
            const manageCodes = document.getElementById('manageCodes');
            const codeListExists = document.getElementById('codeList');
            if (codeListExists) { codeListExists.remove(); }
            let codeList = document.createElement('ul');
            codeList.id = 'codeList';
            codeList.className = 'text-dark text-center dark:text-white';
            codeList.style.fontFamily = 'monospace';
            manageCodes.appendChild(codeList);
            codeList.innerHTML = '';
            response.data.forEach(code => {
                let li = document.createElement('li');
                li.textContent = code;
                codeList.appendChild(li);
            });
        });
};

export function newCodes() {
    api.post('/api/two-factor-recovery-codes').then(function () {
        getCodes();
        const button = document.getElementById('newCodes');
        if (button) { button.remove(); }
    });
}