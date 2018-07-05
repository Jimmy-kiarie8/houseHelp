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
         <!-- <v-btn color="primary" flat @click="openUser">Add User</v-btn> -->
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
        <td class="text-xs-right">{{ props.item.status }}</td>
        <td class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="editItem(props.item)">
              <v-icon color="blue darken-2">edit</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="education(props.item)">
              <v-icon color="blue darken-2">school</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="personal(props.item)">
              <v-icon color="blue darken-2">account_circle</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="skills(props.item)">
              <v-icon color="blue darken-2">info</v-icon>
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
<myEducation :openRequest="openCreate" :resumeInfo="editedItem" @alertRequest="alert" @closeRequest="close"></myEducation>
<myExperience :openRequest="openExp" :resumeInfo="editedItem" @alertRequest="alert" @closeRequest="close"></myExperience>
<myPersonal :openRequest="openPer" :resumeInfo="editedItem" @alertRequest="alert" @closeRequest="close"></myPersonal>
<mySkills :openRequest="openSkill" :resumeInfo="editedItem" @alertRequest="alert" @closeRequest="close"></mySkills>

</div>
</template>

<script>
let myEducation = require('./Education.vue')
let myExperience = require('./Experience.vue')
let myPersonal = require('./Personal.vue')
let mySkills = require('./Skills.vue')
export default {
  props: ['user', 'role'],
  components: {
    myEducation, myExperience, myPersonal, mySkills
  }, 
  data() {
    return{
      openCreate: false,
      openExp: false,
      openPer: false,
      openSkill: false,
      headers: [
        { text: 'Name', align: 'left', value: 'name'},
        { text: 'email', value: 'email' },
        { text: 'Id Number', value: 'id_no' },
        { text: 'Phone Number', value: 'phone' },
        { text: 'Rating', value: 'rating' },
        // { text: 'Location', value: 'location' },
        // { text: 'Current Status', value: 'current_status' },
        { text: 'Status', value: 'status' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      search: '',
      loader: false,
      snackbar: false,
      timeout: 5000,
      color: '',
      message: '',
      Allusers: [],
      editedItem: {},
      educationobj: [],
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
  editItem(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.openExp = true
  },

  education(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.openCreate = true
  },
  skills(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.openSkill = true
  },
  personal(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.openPer = true
  },
  alert() {
    this.message='success'
    this.color="indigo"
    this.snackbar=true
  },
  close() {
    this.openCreate = this.openExp = this.openPer = this.openSkill = false
  },
},
mounted() {
  this.loader=true
  axios.post('getUsers')
  .then((response) => {
    this.Allusers = response.data
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
</style>