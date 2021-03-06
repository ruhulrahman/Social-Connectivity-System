
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data:{
    	msg: 'Update your status',
    	content: '',
    	posts:[],
    },
    created(){
    		axios.get('/getPost')
			.then(response => {
			    console.log(response);
			    this.posts = response.data;
			})
			.catch(function (error) {
			    console.log(error);
			});
    },
    methods:{
    	addPost(){
    		//alert("Hello. It's ok");
    		axios.post('/addPost', {
			    content: this.content
			})
			.then(function (response) {
			    console.log('Save successfully');
			    if(response.status === 200){
			    	//alert('Your status has been aded');
			    	app.posts = response.data;
			    }
			})
			.catch(function (error) {
			    console.log(error);
			});
    	}
    }
});
