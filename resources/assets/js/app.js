import './bootstrap';
import router from './routes';
import Admin from './components/Admin';

window.today = function() {
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    if (day < 10) day = "0"+day;
    if (month < 10) month = "0"+month;
    return year+"-"+month+"-"+day;
};

window.success = function(message) {
    iziToast.success({
        title: 'OK',
        message: message,
        position: 'topRight'
    });
};

window.error = function(message) {
    iziToast.error({
        title: 'ERROR',
        message: message,
        position: 'topRight'
    });
}

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
