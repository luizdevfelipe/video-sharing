import { Modal } from 'flowbite';

const modals = {};

export function toggleModal(id) {
    if (!modals[id]) {
        const modalElement = document.getElementById(id);
        modals[id] = new Modal(modalElement);
    }

    const modal = modals[id];

    if (modal._isHidden) {
        modal.show();
    } else {
        modal.hide();
    }
}
