
import './bootstrap';
import router from './routes';
import Admin from './components/Admin';

window.sort = function() {
    console.log('sor function')
};

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
