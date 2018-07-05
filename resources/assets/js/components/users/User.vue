<template>
 <div>
  <v-content>
   <v-container fluid fill-height>
    <v-layout justify-center align-center>
    <div v-show="loader" style="text-align: center">
      <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div>
      <v-dialog v-model="commdialog2" max-width="800px" persistent>
        <v-card>
          <v-card-title>
            Customer Feedback
          </v-card-title>
          <v-card-text>
            <v-form ref="form" @submit.prevent="update">
              <v-container grid-list-xl fluid>
                <v-layout wrap>
                    <star-rating  :increment="0.01" v-model="feedback.rating" :star-size="20"></star-rating>
                    <v-flex xs12>
                      <v-text-field
                      v-model="feedback.comment"
                      color="blue"
                      multi-line
                      >
                      <div slot="label">
                        Comment <small>(optional)</small>
                      </div>
                    </v-text-field>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue darken-1" flat @click.native="commdialog2 = false">Close</v-btn>
                      <v-btn 
                        color="blue darken-1" 
                        flat 
                        @click.native="commdialog"
                        :loading="loading"
                        :disabled="loading"
                        >Save</v-btn>
                    </v-card-actions>
                    <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>  -->
                  </v-flex>
                </v-layout>
              </v-container>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>

     <div class="container" v-show="!loader">
       <!-- users display -->
       <div>
        <v-card-title>
         <v-btn color="primary" flat @click="openUser">Add User</v-btn>
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
       :items="Allusers"
       :search="search"
       counter
       class="elevation-1"
       >
       <template slot="items" slot-scope="props">
        <td>
          {{ props.item.name }}
        </td>
        <td class="text-xs-right">{{ props.item.email }}</td>
        <td class="text-xs-right">{{ props.item.id_no }}</td>
        <td class="text-xs-right">{{ props.item.phone }}</td>
        <td class="text-xs-right">{{ props.item.rating }}</td>
         <td class="text-xs-right">{{ props.item.locality }}</td>
           <td class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="editItem(props.item)">
              <v-icon color="blue darken-2">edit</v-icon>
            </v-btn>
          <v-btn icon class="mx-0" @click="ratingMec(props.item)">
            <v-icon color="blue darken-2" dark>star</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink darken-2">delete</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="seeDocs(props.item)">
            <v-icon color="blue darken-2">visibility</v-icon>
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
<AddUser @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :Showrole="AllRoles"></AddUser>
<EditUser @closeRequest="close" :openEditRequest="pdialog2" :editedItemCon="editedItem" @alertRequest="showAlert" :Showrole="AllRoles"></EditUser>
<ShowUserProfile @closeRequest="close" :openProRequest="docsdialog2" :users="Allusers" :docsPass="seeDocuments"></ShowUserProfile>
</div>
</template>

<script>
let AddUser = require('./AddUser.vue')
let ShowUserProfile = require('./ShowUserProfile.vue')
let EditUser = require('./EditUser.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddUser, ShowUserProfile, EditUser
  }, 
  data() {
    return{
      rating: 4,
      headers: [
      { text: 'Name', align: 'left', value: 'name'},
      { text: 'email', value: 'email' },
      { text: 'Id Number', value: 'id_no' },
      { text: 'Phone Number', value: 'phone' },
      { text: 'Rating', value: 'rating' },
      { text: 'Location', value: 'locality' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
    feedback: {},
    AllRoles: {},
    search: '',
    e1: true,
    loader: false,
    loading: false,
    dispAdd: false,
    docsdialog2: false,
    pdialog2: false,
    snackbar: false,
    commdialog2: false,
    pdialog: false,
    timeout: 5000,
    color: '',
    message: '',
    Allusers: [],
    docNo: {},
    Alldocs: [],
    editedItem: {},
    delItem: {},
    seeDocuments: {},
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
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.pdialog2 = true
  },

  showAlert(){
    this.message = 'Successifully Added';
    this.snackbar = true;
    this.color = 'indigo';
  },
  deleteItem(item) {
    this.delItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    const index = this.Allusers.indexOf(item)
    if (confirm('Are you sure you want to delete this item?')) {
      // this.loader = true
      axios.delete(`/users/${this.delItem.id}`)
      .then((response) => {
        this.Allusers.splice(index, 1)
        // this.loader = false
        this.message = 'deleted successifully'
        this.color = 'indigo'
        this.snackbar = true
      })
      .catch((error) => {
        this.errors = error.response.data.errors
        // this.loader = false
        this.message = 'something went wrong'
        this.color = 'red'
        this.snackbar = true
      })
    }
  },
  close() {
    this.dispAdd= this.docsdialog2 = this.pdialog2 = false
  },

  // Ratings && Comments
  commdialog() {
    this.loading = true
    axios.post(`/comments/${this.feedback.id}`, this.feedback)
    .then((response) => {
        this.loading = false
        this.message = 'Commented'
        this.color = 'indigo'
        this.snackbar = true
    })
      .catch((error) => {
        this.loading = false
        this.errors = error.response.data.errors
        this.message = 'something went wrong'
        this.color = 'red'
        this.snackbar = true
      })
  },
  ratingMec(item) {
    this.feedback = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.commdialog2 = true
  },

  // documents

  seeDocs(item) {
    this.seeDocuments = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.seeDocuments);
    this.docsdialog2 = true
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


  axios.post('getRoles')
  .then((response) => {
    this.AllRoles = response.data
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
 margin-top: -100px
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