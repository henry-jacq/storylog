// ModalHandler class definition (same as above)
class ModalHandler {
    constructor() {
        this.modal = null;
    }

    createModal({ title, content, buttons = [], svg = null }) {
        // Create modal element
        this.modal = document.createElement('div');
        this.modal.className = 'fixed inset-0 z-10 w-screen overflow-y-auto';
        this.modal.setAttribute('role', 'dialog');
        this.modal.setAttribute('aria-modal', 'true');
        this.modal.setAttribute('aria-labelledby', 'modal-title');

        const svgHtml = svg ? `
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                ${svg}
            </div>` : '';

        const buttonHtml = buttons.map((button, index) => `
            <button type="button" class="modal-button ${button.classes}" id="modal-button-${index}">
                ${button.text}
            </button>
        `).join('');

        this.modal.innerHTML = `
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-out duration-300 opacity-0"></div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform transition-all ease-out duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 overflow-hidden rounded-lg bg-white text-left shadow-xl sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            ${svgHtml}
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">${title}</h3>
                                <div class="mt-2">${content}</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        ${buttonHtml}
                    </div>
                </div>
            </div>
        `;

        // Append modal to the body
        document.body.appendChild(this.modal);

        // Initial trigger to start animation
        requestAnimationFrame(() => {
            this.modal.querySelector('.bg-gray-500').classList.replace('opacity-0', 'opacity-100');
            this.modal.querySelector('.relative').classList.replace('opacity-0', 'opacity-100');
            this.modal.querySelector('.relative').classList.replace('translate-y-4', 'translate-y-0');
            this.modal.querySelector('.relative').classList.replace('sm:scale-95', 'sm:scale-100');
        });

        // Event listeners for closing the modal
        this.modal.querySelectorAll('.modal-button').forEach((button, index) => {
            button.addEventListener('click', () => {
                const action = buttons[index].action;
                if (typeof action === 'function') {
                    action(this.closeModal.bind(this));
                }
            });
        });

        this.modal.querySelector('.fixed.inset-0.bg-gray-500').addEventListener('click', (e) => {
            if (e.target === this.modal.querySelector('.fixed.inset-0.bg-gray-500')) {
                this.closeModal();
            }
        });
    }

    closeModal() {
        if (this.modal) {
            // Trigger animation for closing
            this.modal.querySelector('.bg-gray-500').classList.replace('opacity-100', 'opacity-0');
            const modalContent = this.modal.querySelector('.relative');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            modalContent.classList.replace('translate-y-0', 'translate-y-4');
            modalContent.classList.replace('sm:scale-100', 'sm:scale-95');

            // Remove modal after animation ends
            setTimeout(() => {
                if (this.modal) {
                    this.modal.remove();
                    this.modal = null;
                }
            }, 300); // Match this to your animation duration
        }
    }
}

// Singleton instance
const Modal = new ModalHandler();

// Export a function that returns the singleton instance
export default function getModalHandler() {
    return Modal;
}
