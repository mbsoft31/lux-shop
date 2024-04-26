import './bootstrap';

import Alpine from 'alpinejs';

// Check if Alpine.js is already initialized
if (!window.Alpine) {
    // If Alpine.js is not initialized, set it to the imported instance
    window.Alpine = Alpine;

    // Start Alpine.js
    Alpine.start();
} else {
    console.warn('Alpine.js is already initialized.');
}
