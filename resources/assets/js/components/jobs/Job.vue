<template>
 <div>
  <v-content>
   <v-container fluid fill-height>
    <v-layout justify-center align-center>
    <div v-show="loader" style="text-align: center">
      <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div> 
     <div class="container" v-show="!loader">
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
            <v-btn icon class="mx-0" @click="ShowJobSt(props.item)">
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
<AddJob @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :editedItemCon="editedItem"></AddJob>
<EditJob @closeRequest="close" :openEditRequest="pdialog2" :editedItemCon="editedItem"></EditJob>
<JobShow @closeRequest="close" :AllJobsDisp="JobsDisp" :openRequest="JobDialog" :users="Allusers" :editedItemCon="editedItem"></JobShow>
</div>
</template>

<script>
let AddJob = require('./AddJob.vue')
let JobShow = require('./JobShow.vue')
let EditJob = require('./EditJob.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddJob, JobShow, EditJob
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
    JobDialog: false,
    pdialog2: false,
    snackbar: false,
    pdialog: false,
    timeout: 5000,
    color: '',
    message: '',
    Allusers: [],
    Alldocs: [],
    editedItem: {},
    JobsDisp: [],
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
  giveJob(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.dispAdd = true
  },
  ShowJobSt(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.JobDialog = true

    axios.post(`getJobs/${this.editedItem.id}`)
    .then((response) => {
      this.JobsDisp = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })
  },

  showAlert(){
    this.message = 'Successifully Added';
    this.snackbar = true;
    this.color = 'indigo';
  },
  close() {
    this.dispAdd= this.JobDialog = this.pdialog2 = false
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