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
         <v-btn color="primary" flat @click="openUser">Add Client</v-btn>
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
       :items="AllClients"
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
            <v-btn icon class="mx-0" @click="routePush(props.item)">
              <v-icon color="blue darken-2">account_circle</v-icon>
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
<AddClients @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :Showrole="AllRoles"></AddClients>
<EditClients @closeRequest="close" :openEditRequest="pdialog2" :editedItemCon="editedItem" :Showrole="AllRoles"></EditClients>
<Profile @closeRequest="close" :openEditRequest="proDialog" :ProfileDetail="routerItem" :doneJobs="JobsDone" :users="Allusers"></Profile>
</div>
</template>

<script>
let AddClients = require('./AddClients.vue')
let EditClients = require('./EditClients.vue')
let Profile = require('./Profile.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddClients, EditClients, Profile
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
    AllRoles: {},
    search: '',
    e1: true,
    loader: false,
    loading: false,
    dispAdd: false,
    docsdialog2: false,
    pdialog2: false,
    proDialog: false,
    snackbar: false,
    commdialog2: false,
    pdialog: false,
    timeout: 5000,
    color: '',
    message: '',
    AllClients: [],
    Allusers: {},
    docNo: {},
    Alldocs: [],
    editedItem: {},
    JobsDone: {},
    routerItem: {},
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
    this.editedIndex = this.AllClients.indexOf(item)
    // console.log(this.editedItem);
    this.pdialog2 = true
  },
  /*routePush(item) {
    this.routerItem = Object.assign({}, item)
    this.editedIndex = this.AllClients.indexOf(item)
    // router.push({ path: '/user', params: { userId }}) // -> /user
    router.push({ path: `/clients/${this.routerItem.id}` }) // -> /user/123
  },*/
  routePush(item) {
    this.routerItem = Object.assign({}, item)
    this.editedIndex = this.AllClients.indexOf(item)
    this.proDialog = true

    axios.post(`getJobs/${this.routerItem.id}`)
    .then((response) => {
      this.JobsDone = response.data
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
  
  deleteItem(item) {
    this.delItem = Object.assign({}, item)
    this.editedIndex = this.AllClients.indexOf(item)
    const index = this.AllClients.indexOf(item)
    if (confirm('Are you sure you want to delete this item?')) {
      // this.loader = true
      axios.delete(`/users/${this.delItem.id}`)
      .then((response) => {
        this.AllClients.splice(index, 1)
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
    this.dispAdd= this.docsdialog2 = this.pdialog2 = this.proDialog = false
  },

},
mounted() {
  this.loader=true
  axios.post('getClient')
  .then((response) => {
    this.AllClients = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })

  axios.post('getUsers')
  .then((response) => {
    this.AllClients = response.data
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