import { Modal } from 'flowbite';

export function closeModal(id) {
    const modalElement = document.getElementById(id);
    const modal = new Modal(modalElement);
    modal.hide();
}