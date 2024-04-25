import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faTrash, faEdit, faEye, faSliders, faSearch } from '@fortawesome/free-solid-svg-icons';

library.add(faTrash, faEdit, faEye, faSliders, faSearch);