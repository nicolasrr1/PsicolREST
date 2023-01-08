

import './bootstrap';
import { createApp } from 'vue';



const app = createApp({});


import UserForm from './components/tasks/UserForm.vue';

app.component('use-frorm', UserForm);




app.mount('#app');
