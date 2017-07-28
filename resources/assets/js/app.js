
import './bootstrap';
import router from './routes';
import Admin from './components/Admin';

new Vue({
    el: '#app',

    data: {
    	dropdown: false,
    	dropdownUser: false
    },

    router,

    components: {
		Admin
	}
});
