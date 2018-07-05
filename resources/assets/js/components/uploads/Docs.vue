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
         :items="Alldocs"
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
         <!-- <td class="text-xs-right">{{ props.item.location }}</td>
         <td class="text-xs-right">{{ props.item.current_status }}</td> -->
         <td class="text-xs-right">{{ props.item.status }}</td>
         <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="blue darken-2">edit</v-icon>
          </v-btn>
          <!-- <v-btn icon class="mx-0" @click="UpdateItem(props.item)">
            <v-icon color="blue darken-2" dark>save</v-icon>
          </v-btn> -->
          <v-btn icon class="mx-0" @click="download(props.item)">
            <v-icon color="pink darken-2">delete</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="showDetails(props.item)">
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
  <v-btn flat color="white">Close</v-btn>
</v-snackbar>
</v-content>
</div>
</template>

<script>
export default {
  props: ['user'],
 components: {
  
}, 
data() {
  return{
    headers: [
    { text: 'Name', align: 'left', value: 'name'},
    { text: 'email', value: 'email' },
    { text: 'Id Number', value: 'id_no' },
    { text: 'Rating', value: 'rating' },
    // { text: 'Location', value: 'location' },
    // { text: 'Current Status', value: 'current_status' },
    { text: 'Status', value: 'status' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
     search: '',
     e1: true,
     loader: false,
     snackbar: false,
     timeout: 5000,
     color: '',
     message: '',
     Alldocs: [],
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
  showDetails() {

  },
   download(item) {
    axios.get(`/${this.editedItem}`)
    .then((response) => {
      this.message = 'Successifully Added';
      this.snackbar = true;
      this.color = 'indigo';
    })  
      .catch((error) => {
        this.errors = error.response.data.errors
        this.message = 'failed ';
        this.snackbar = true;
        this.color = 'red';
      })
   },

  /* axios({
      url: 'http://localhost:5000/static/example.pdf',
      method: 'GET',
      responseType: 'blob', // important
    }).then((response) => {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'file.pdf');
      document.body.appendChild(link);
      link.click();
    });*/

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
      this.dispAdd= this.dispShow = this.pdialog2 = this.dispEdit  =  false
   },
},
mounted() {
  this.loader=true
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