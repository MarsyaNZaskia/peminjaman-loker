import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Swal from 'sweetalert2';
window.Swal = Swal;

// Flash message handler for SweetAlert2
window.showFlashMessage = function(type, message) {
    if (!message) return;
    
    const config = {
        success: {
            icon: 'success',
            title: 'Berhasil',
            confirmButtonColor: '#22c55e',
        },
        error: {
            icon: 'error',
            title: 'Error',
            confirmButtonColor: '#ef4444',
        },
        warning: {
            icon: 'warning',
            title: 'Peringatan',
            confirmButtonColor: '#f59e0b',
        },
        info: {
            icon: 'info',
            title: 'Informasi',
            confirmButtonColor: '#3b82f6',
        }
    };
    
    const settings = config[type] || config.info;
    
    Swal.fire({
        ...settings,
        text: message,
        confirmButtonText: 'OK'
    });
};