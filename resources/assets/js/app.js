
import './bootstrap';
import router from './routes';
import Notification from './components/Notification';

new Vue({
    el: '#app',

    router,

    components: {
		Notification
	}
});
