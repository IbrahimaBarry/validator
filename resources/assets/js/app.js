
import './bootstrap';
import router from './routes';
import Admin from './components/Admin';

new Vue({
    el: '#app',

    router,

    components: {
		Admin
	}
});
