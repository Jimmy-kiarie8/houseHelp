<template>
	<section class="page">
		<div id="wrapper">
			<div class="content-wrapper container">
				<div class="row">
					<div class="col-sm-12">
						<div class="page-title">
							<h1>Blog list <small></small></h1>
							<ol class="breadcrumb">
								<li><a href="#"><i class="fa fa-home"></i></a></li>
								<li class="active">blog list</li>
							</ol>
						</div>
					</div>
				</div><!-- end .page title-->


				<div class="row">
					<div class="col-md-4 margin-b-30" v-for="item, key in blogPosts" :key="item.id">
						<div class="blog-post">
							<!-- <a href="#"> -->
								<img :src="item.image" alt="image" class="img-responsive" style="max-height: 200px;">
							<!-- </a> -->
							<div class="blog-desc">
								<h3><a href="#">{{item.title}}</a></h3>
								<span class="blog-meta"><a href="#">By Admin</a> {{item.created_at}} <a href="#">{{blogComment.length}} Comments</a></span>
								<p>
									{{item.description}}
								</p>
								<v-card-actions>
									<v-btn flat color="primary" @click="comment(key)"><v-icon>comment</v-icon></v-btn>
									<v-spacer></v-spacer>
									<v-btn flat color="primary" @click="blogShow(key, item.id)">Reading more</v-btn>
								</v-card-actions>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
		<AddComment :blogP='blogPosts' :openAddRequest="addcomment" @closeRequest="close" @alertRequest="alert"></AddComment>
		<ShowBlog :blogP='blogPosts' :openRequest="showBlogPost" @closeRequest="close" @alertRequest="alert" :comments="commentsB"></ShowBlog>
		<v-snackbar
		:timeout="timeout"
		bottom
		:color="color"
		left
		v-model="snackbar"
		>
		{{ message }}
		<v-icon dark right>check_circle</v-icon>
		</v-snackbar>
	</section>
</template>

<script>
let AddComment = require('./AddComment.vue')
let ShowBlog = require('./ShowBlog.vue')
export default{
	components: {
		AddComment, ShowBlog
	},
	data() {
		return{
			blogPosts: {},
			blogComment: {},
			commentsB: {},
			showBlogPost: false,
			addcomment: false,
			snackbar: false,
			timeout: 5000,
			color: '',
			message: '',
		}
	},
	methods: {
		comment(key) {
			this.$children[0].post = this.blogPosts[key]
			this.addcomment = true
		},
		blogShow(key, id) {
			this.$children[1].post = this.blogPosts[key]
			this.showBlogPost = true


			axios.post(`/getBlogC/${id}`)
			.then((response) => {
	    		this.loader=false
				this.commentsB = response.data
			})
			.catch((error) => {
	    		this.loader=false
				this.errors = error.response.data.errors
			})

		},

		alert(){
		   this.message = 'Comment Added';
		   this.snackbar = true;
		   this.color = 'indigo';
		},
		close() {
			this.addcomment = this.showBlogPost = false
		}
	},
	mounted() {
		this.loader = true
		axios.post('/getBlog')
		.then((response) => {
			this.blogPosts = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('/getPostCom')
		.then((response) => {
    		this.loader=false
			this.blogComment = response.data
		})
		.catch((error) => {
    		this.loader=false
			this.errors = error.response.data.errors
		}) 
	}
}
</script>