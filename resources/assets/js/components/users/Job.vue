<template>
 <div>
  <v-content>
   <v-container fluid fill-height>
    <div v-show="loader" style="text-align: center">
      <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div> 
    <v-layout justify-center align-center v-show="!loader" >
     <div class="container">
       <!-- users display -->
       <div v-show="!loader">
        <v-card-title>
         <!-- <v-btn color="primary" flat @click="openUser">Add Job</v-btn> -->
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
         <!--   <td class="text-xs-right">{{ props.item.current_status }}</td> -->
           <td class="text-xs-right">{{ props.item.status }}</td>
           <td class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="giveJob(props.item)">
              <v-icon color="blue darken-2">add</v-icon>
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
<!-- <AddJob @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert"></AddJob>
<EditJob @closeRequest="close" :openEditRequest="pdialog2" :editedItemCon="editedItem"></EditJob>
<ShowJob @closeRequest="close" :openProRequest="docsdialog2" :users="Allusers" :docsPass="seeDocuments"></ShowJob> -->
</div>
</template>

<script>
// let AddJob = require('./AddJob.vue')
// let ShowJob = require('./ShowJob.vue')
// let EditJob = require('./EditJob.vue')
export default {
  props: ['user', 'role'],
  components: {
    // AddJob, ShowJob, EditJob
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
    // { text: 'Location', value: 'location' },
    // { text: 'Current Status', value: 'current_status' },
    { text: 'Status', value: 'status' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
    feedback: {},
    search: '',
    e1: true,
    loader: false,
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
  giveJob(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    // this.pdialog2 = true
  },

  showAlert(){
    this.message = 'Successifully Added';
    this.snackbar = true;
    this.color = black;
  },
  del(key, id) {
    if (confirm('Are you sure you want to delete this item?')) {
      this.loader = true
      axios.delete(`/users/${id}`)
      .then((response) => {
        this.Allusers.splice(index, 1)
        this.loader = false
        this.message = 'deleted successifully'
        this.color = 'red'
        this.snackbar = true
      })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loader = false
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
    // this.commdialog2 = true
    axios.post(`/comments/${this.feedback.id}`, this.feedback)
    .then((response) => {

        this.message = 'Commented'
        this.color = 'indigo'
        this.snackbar = true
    })
      .catch((error) => {
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


  axios.post('getCategory')
  .then((response) => {
    this.Alldocs = response.data
    this.loader=false
  })
  .catch((error) => {
    this.errors = error.response.data.errors
    this.loader=false
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