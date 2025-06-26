import api from '../../../../services/api.js';

document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('getCodes').addEventListener('click', function (e) {
        api.get('api/two-factor-recovery-codes')
            .then(function (response) {
                document.getElementById('getCodes').remove();
                const manageCodes = document.getElementById('manageCodes');
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
    });

    document.getElementById('remove2FA').addEventListener('click', function (e) {
        api.post('api/two-factor-authentication', {
            _method: 'DELETE',
        }).then(function () {
            location.reload();
        });
    });

    document.getElementById('newCodes').addEventListener('click', function (e) {
        api.post('/api/two-factor-recovery-codes').then(function () {
            api.get('api/two-factor-recovery-codes')
                .then(function (response) {
                    document.getElementById('getCodes').remove();
                    const manageCodes = document.getElementById('manageCodes');
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
        });
    });

});