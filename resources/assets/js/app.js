
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./main')

window.Vue = require('vue');

/*Vue imports*/
import notificationComponent from './components/NotificationComponent.vue'
import likeComponent from './components/LikeComponent.vue'
import likeCommentComponent from './components/LikeCommentComponent.vue'
import likeReplyComponent from './components/LikeReplyComponent.vue'

new Vue({
	components:{
		'notification-component': notificationComponent,
		'like-component': likeComponent,
		'like-comment-component': likeCommentComponent,
		'like-reply-component': likeReplyComponent
	},
	el: '#app'
})




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });


require('./bulma-extensions');
