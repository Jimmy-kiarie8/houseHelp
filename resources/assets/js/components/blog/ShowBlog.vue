
<template>
  <v-layout row justify-center>
    <v-dialog v-model="openRequest" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click.native="close">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Settings</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <!-- <v-btn dark flat @click.native="dialog = false">Save</v-btn> -->
          </v-toolbar-items>
        </v-toolbar>

        <div v-show="loader" style="text-align: center">
          <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div> 
             <section>
               <div id="wrapper">
                 <div class="content-wrapper container">
                   <div class="row">
                     <div class="col-sm-12">
                       <div class="page-title">
                         <h1>Blog Post <small></small></h1>
                         <ol class="breadcrumb">
                           <li><a href="#"><i class="fa fa-home"></i></a></li>
                           <li class="active">blog post</li>
                         </ol>
                       </div>
                     </div>
                   </div><!-- end .page title-->


                   <div class="row">
                    <div class="col-sm-8">
                      <div class="blog-single-post">
                        <div class="post-header">
                          <h2>
                            {{post.title}}
                          </h2>
                          <span class="blog-meta"><a href="#">By Admin</a> 24 July 2015 <a href="#">934 Comments</a></span>
                        </div>
                        <div id="image" v-html="post.content"></div>


                      </div>
                    </div>
                    <hr>
                  </div>
                </div>
                <div class="panel">
                 <div class="panel-heading">
                   <em class="fa fa-pencil"></em> Add your Comment</div>
                   <div class="panel-body">
                     <v-form ref="form" @submit.prevent>
                       <v-flex xs12>
                         <v-text-field
                         v-model="post.comment"
                         color="blue"
                         multi-line
                         >
                         <div slot="label">
                           Comment 
                         </div>
                       </v-text-field>
                      <small class="has-text-danger" v-if="errors.comment">{{ errors.comment[0] }}</small>
                     </v-flex>
                   </v-form>
                   <v-btn
                   :disabled="loading"
                   :loading="loading"
                   flat
                   color="primary"
                   @click="save"
                   >Comment</v-btn>
                 </div>
               </div>

               <div class="panel">
                 <div class="panel-heading" v-if="openRequest">{{comments.length}} Comments</div>
                 <div class="panel-body">
                   <div class="media" v-for="comment in comments" :key="comment.id">
                     <div class="media-left"
                          v-for="itemuser in allUsers"
                          v-if="comment.user_id === itemuser.id">
                       <a href="#">
                         <img v-if="itemuser.profile!='/storage/profile/noimage.png'" :src="itemuser.profile" class="media-object img-circle" alt="image" width="60">
                        <avatar :username="itemuser.name" v-else></avatar>
                       </a>
                     </div>
                     <div class="media-body">
                       <h4 id="media-heading" class="media-heading" 
                          v-for="itemuser in allUsers"
                          v-if="comment.user_id === itemuser.id"
                          >{{itemuser.name}}
                        <small>{{comment.created_at}}</small>
                         <a href="#media-heading">
                           <span class="anchorjs-icon"></span>
                         </a>
                       </h4>
                       <p>{{ comment.comment }}</p>
                     </div>
                   </div>
                   <hr>
                 </div>
               </div>
             </div>

        <!--      <div class="col-sm-3 col-sm-offset-1">
          <div class="sidebar-widget">
            <h4>Text widget</h4>
            <p>
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.  
            </p>
          </div>
          <div class="sidebar-widget">
           <h4>tag clouds</h4>
           <div class="tag-list">
             <a href="#">nibh</a>
             <a href="#">gravida</a>
             <a href="#">nulla</a>
             <a href="#">commodo</a>
             <a href="#">metus</a>
             <a href="#">Lorem</a>
             <a href="#">ante</a>
           </div>
         </div>
            </div> -->
         
        </section>
      </v-card>
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
    </v-dialog>
  </v-layout>
</template>

<script>
import Avatar from 'vue-avatar'
export default {
 props: ['user', 'role', 'openRequest', 'comments'],
 components: {
  Avatar
},
 data() {
  const defaultForm = Object.freeze({
    comment: ''
  })
  return{
    loader: false,
    form: Object.assign({}, defaultForm),
    defaultForm,
    post: {},
    allUsers: {},
    loading: false,
    snackbar: false,
    timeout: 5000,
    color: '',
    message: '',
  }
},
methods: {
  save() {
    this.loading=true
    axios.post(`/Postcom/${this.post.id}`, this.$data.post).
    then((response) => {
      this.loading=false
      console.log(response.data);
        // this.close;
        this.resetForm();
        this.message = 'commented'
        this.color='indigo'
        this.snackbar=true
        this.comments.push(response.data) 
        this.$parent.blogComment.push(response.data) 

      })
    .catch((error) => {
      this.loading=false
      this.errors = error.response.data.errors
    })
  },
  resetForm () {
    this.form = Object.assign({}, this.defaultForm)
    this.$refs.form.reset()
  },
  close() {
    this.$emit('closeRequest')
  },
},

computed: {
 formIsValid () {
   return (
     this.form.comment 
     )
 }
},
mounted()  {
    axios.post('/getUsers')
    .then((response) => {
      this.allUsers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })
}
}

</script>


<style scoped>

</style>


