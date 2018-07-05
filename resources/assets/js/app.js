
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
 
window.Vue = require('vue');
// import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import StarRating from 'vue-star-rating'

Vue.component('star-rating', StarRating);
Vue.use(VueRouter) 
Vue.use(Vuetify) 
/** 
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('star-rating', VueStarRating.default);
Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('file-management', require('./components/uploads/FileManagement.vue'));
Vue.component('attachment-list', require('./components/uploads/AttachmentList.vue'));
  
let myView = require('./components/Dashboard.vue')
let myHeader = require('./components/include/Head.vue') 
let myUser = require('./components/users/User.vue')
let myDocs = require('./components/uploads/Docs.vue')
let myProfile = require('./components/users/Profile.vue')
let myResume = require('./components/resum/Resume.vue')
let myResumeHome = require('./components/resum/Home.vue')
let myJob = require('./components/jobs/Job.vue')
// let myMech = require('./components/mechanics/Mechanics.vue')
let mysubsicriber = require('./components/emails/Subscribe.vue');
// let myBlog = require('./components/blog/Blog.vue');
// let myBlogPost = require('./components/blog/BlogPost.vue');
let myJobRequest = require('./components/jobs/JobsRequest.vue');
let myClient = require('./components/clients/Clients.vue')
let myMechanic = require('./components/mechanics/Mechanic.vue')

const routes = [
	{path: '/', component: myView},
	{path: '/users', component: myUser},
	{path: '/docs', component: myDocs},
	{path: '/profile', component: myProfile},
	{path: '/resume', component: myResume}, 
	{path: '/home', component: myResumeHome},
	{path: '/jobs', component: myJob},
	{path: '/mechanics', component: myMechanic},
	{path: '/subscribers', component: mysubsicriber },
	// {path: '/blogs', component: myBlog },
	// {path: '/blogpost', component: myBlogPost },
	{path: '/jobRequest', component: myJobRequest },
	{path: '/clients', component: myClient },
] 
const router = new VueRouter({
// mode: 'history',
	routes // short for `routes: routes`
})
const app = new Vue({
    el: '#app',
    router,
    components: {
    	StarRating, myView, myUser, myHeader, myDocs, myProfile, myResume, 
    	myResumeHome, myJob, myMechanic, mysubsicriber, myJobRequest, myMechanic, myClient
    	// myBlog, myBlogPost,
    }
});
