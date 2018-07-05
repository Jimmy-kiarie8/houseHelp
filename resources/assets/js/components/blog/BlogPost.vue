<template>
 <div>
  <v-content>
   <v-container fluid fill-height>
    <div v-show="loader" style="text-align: center; width: 100%; margin-top: 200px;">
      <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div>
    <v-layout justify-center align-center v-show="!loader">
     <div class="container">
       <!-- users display -->
       <div>
        <v-card-title>
         <v-btn color="primary" flat @click="openUser">Add Post</v-btn>
         <v-spacer></v-spacer>
         <v-text-field
         v-model="search"
         append-icon="search"
         label="Search"
         single-line
         hide-details
         ></v-text-field>
       </v-card-title>
       <v-data-table
       :headers="headers"
       :items="blogPosts"
       :search="search"
       counter
       class="elevation-1"
       >
       <template slot="items" slot-scope="props">
        <td>
          {{ props.item.title }}
        </td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
        <td class="text-xs-right">{{ props.item.updated_at }}</td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="blue darken-2">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="addImage(props.item)">
            <v-icon color="blue darken-2">image</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="seeDocs(props.item)">
            <v-icon color="blue darken-2">visibility</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink darken-2">delete</v-icon>
          </v-btn>
        </td> 
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
       Your search for "{{ search }}" found no results.
     </v-alert>
     <template slot="pageText" slot-scope="{ pageStart, pageStop }">
       From {{ pageStart }} to {{ pageStop }}
     </template>
   </v-data-table>
 </div>
</div>
<!-- Data table -->
</v-layout>
</v-container>
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
</v-content>
<AddBlog @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert"></AddBlog>
<EditBlog @closeRequest="close" :openEditRequest="pdialog2" :editBlog="editedItem" @alertRequest="showAlert"></EditBlog>
<ShowBlog @closeRequest="close" :openShowRequest="docsdialog2" :users="Allusers"></ShowBlog>
<ImageBlog @closeRequest="close" :openImgRequest="imgdialog" :users="Allusers" :imginfo="editedItem" @alertRequest="showAlert" :avatar="image"></ImageBlog>
</div>
</template>

<script>
let AddBlog = require('./AddBlog.vue')
let ShowBlog = require('./ShowBlog.vue')
let EditBlog = require('./EditBlog.vue')
let ImageBlog = require('./Image.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddBlog, ShowBlog, EditBlog, ImageBlog
  }, 
  data() {
    return{
      imgdialog: false,
      headers: [
      { text: 'Title', align: 'left', value: 'name'},
      { text: 'Created On', value: 'created_at' },
      { text: 'Last Update', value: 'updated_at' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
    feedback: {},
    search: '',
    loader: false,
    loading: false,
    dispAdd: false,
    docsdialog2: false,
    pdialog2: false,
    snackbar: false,
    timeout: 5000,
    color: '',
    image: '',
    message: '',
    Allusers: [],
    blogPosts: [],
    editedItem: {},
    emailRules: [
    v => {
      return !!v || 'E-mail is required'
    },
    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
    ],
    rules: {
      age: [
      val => val < 10 || `I don't believe you!`
      ],
      name: [val => (val || '').length > 0 || 'This field is required']
    },
  }
},
methods: {  
  openUser(){
    this.dispAdd  = true
  },
  editItem(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.blogPosts.indexOf(item)
    // console.log(this.editedItem);
    this.pdialog2 = true
  },

  addImage(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.blogPosts.indexOf(item)
    // console.log(this.editedItem);
    this.imgdialog = true
    axios.post(`getImgBlog/${this.editedItem.id}`)
    .then((response) => {
      this.image = response.data
    })
  },
  deleteItem(item) {

  },
  showAlert(){
    this.message = 'Successifully Added';
    this.snackbar = true;
    this.color = 'indigo';
  },
  close() {
    this.dispAdd= this.docsdialog2 = this.pdialog2 = this.imgdialog = false
  },

},
mounted() {
  this.loader=true
  axios.post('getUsers')
  .then((response) => {
    this.Allusers = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })


  axios.post('/getBlog')
  .then((response) => {
    this.blogPosts = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  }) 


  axios.post('getCategory')
  .then((response) => {
    this.Alldocs = response.data
    this.loader=false
  })
  .catch((error) => {
    this.loader=false
    this.errors = error.response.data.errors
  })
},
 /*beforeRouteEnter(to, from, next) {
   next(vm => {
    if (vm.role === 'Admin' || vm.role === 'companyAdmin') {
      next(); 
    } else {
      next('/');
    }
  })
}*/
}
</script>


<style scoped>
.content--wrap{
 margin-top: -50px
}
#profile { 
 width: 70px;
 height: 60px;
 border-radius: 50%;
 margin-left: 80px;
 margin-top: -30px;
}
i{
 padding: 7px;
 background: #f0f0f0;
 border-radius: 50%;
}
.list-group-item:hover, .list-group-item:focus {
 z-index: 1;
 background: #f9f9f9;
 text-decoration: none;
}
</style>