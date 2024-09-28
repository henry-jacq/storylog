import getModalHandler from './libs/Modal.js';

var modal = getModalHandler();

document.getElementById('openModal').addEventListener('click', () => modal.createModal({
    title: 'Deactivate account',
    content: `<p>Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>`,
    svg: `<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>`,
    buttons: [
        {
            text: 'Deactivate',
            classes: 'inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto',
            action: (close) => {
                alert('Account deactivated!');
                close();
            }
        },
        {
            text: 'Cancel',
            classes: 'mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto',
            action: (close) => close()
        }
    ]
}));

