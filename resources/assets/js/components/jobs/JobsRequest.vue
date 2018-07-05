<template>
 <div>
  <v-content>
   <v-container fluid fill-height>
    <v-layout justify-center align-center>
    <div v-show="loader" style="text-align: center">
      <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div> 
     <div class="container" v-show="!loader">
       <div v-show="!loader">
        <v-card-title>
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
       :items="AllJobs"
       :search="search"
       counter
       class="elevation-1"
       >
       <template slot="items" slot-scope="props">
        <td>
          {{ props.item.description }}
        </td>
        <td class="text-xs-right">{{ props.item.mechanic_id }}</td>
        <td class="text-xs-right">{{ props.item.client_id }}</td>
        <td class="text-xs-right">{{ props.item.rating }}</td>
           <td class="text-xs-right">{{ props.item.respo }}</td>
           <td class="justify-center layout px-0">
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
<!-- <AddJob @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :editedItemCon="editedItem"></AddJob>
<EditJob @closeRequest="close" :openEditRequest="pdialog2" :editedItemCon="editedItem"></EditJob>-->
<SeeJob @closeRequest="close" :openRequest="JobDialog" :jobs="editedItem" @alertRequest="showAlert"></SeeJob> 
</div>
</template>

<script>
let SeeJob = require('./SeeJob.vue')
export default {
  props: ['user', 'role'],
  components: {
    SeeJob
  }, 
  data() {
    return{
      rating: 4,
      headers: [
      { text: 'Description', align: 'left', value: 'description'},
      { text: 'Mechanics', value: 'mechanic_id' },
      { text: 'Client', value: 'client_id' },
      { text: 'Rating', value: 'rating' },
      { text: 'Status', value: 'respo' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    search: '',
    loader: false,
    dispAdd: false,
    JobDialog: false,
    pdialog2: false,
    snackbar: false,
    timeout: 5000,
    color: '',
    message: '',
    editedItem: {},
    JobsDisp: [],
    AllJobs: [],
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
    this.editedIndex = this.AllJobs.indexOf(item)
    // console.log(this.editedItem);
    this.dispAdd = true
  },
  ShowJobSt(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.AllJobs.indexOf(item)
    // console.log(this.editedItem);
    this.JobDialog = true

/*    axios.post(`getJobs/${this.editedItem.id}`)
    .then((response) => {
      this.JobsDisp = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })*/
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
  axios.post(`getJobInfo/${this.user.id}`)
  .then((response) => {
    this.loader=false
    this.AllJobs = response.data
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

</style>