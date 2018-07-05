<template>
 <div>

  <!-- profile -->
  <v-dialog v-model="docsdialog2" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card id="shipment_det">
      <v-card-title>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click.native="docsdialog2 = false">
            <v-icon color="black">close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
        </v-toolbar>
        <span class="headline"></span>
      </v-card-title>
      <v-card-text>
        <v-container grid-list-md text-xs-center>
         <v-card-title>
          <v-btn color="primary" flat @click="openUser">Profile</v-btn>
          <v-spacer></v-spacer>
          <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
          ></v-text-field>
        </v-card-title>
        <v-card>
          <v-layout>
            <v-flex sm6>
              <img src="" alt="profile">
              <p>{{seeDocuments.name}}</p>            
              <p>{{seeDocuments.email}}</p>            
              <p>{{seeDocuments.ratings}}</p>            
            </v-flex>
            <v-divider></v-divider>
            <v-divider></v-divider>

            <v-flex sm6>
              <div style="max-height: 400px;overflow-y: scroll; border-left: 1px solid #333; background: #f9f9f9;">
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
                <p>comments</p>
              </div>
            </v-flex>
          </v-layout>
        </v-card>
        <v-data-table
        :headers="proheaders"
        :items="Alldocs"
        :search="search"
        counter
        class="elevation-1"
        >
        <template slot="items" slot-scope="props">
         <td>
           {{ props.item.name }}
         </td>
         <td class="text-xs-right">{{ props.item.description }}</td>
         <td class="text-xs-right">{{ props.item.created_at }}</td>
         <td class="justify-center layout px-0">
           <v-btn icon class="mx-0" @click="download(props.item)">
            <v-icon color="pink darken-2">cloud_upload</v-icon>
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
  </v-container>
</v-card-text>
</v-card>

</v-dialog>
<!-- profile -->

<!-- Edit User -->
<v-dialog v-model="pdialog2" max-width="800px" persistent>
  <v-card>
    <v-card-title>
      {{ editedItem.name }}
    </v-card-title>
    <v-card-text>
      <v-form ref="form" @submit.prevent="update">
        <v-container grid-list-xl fluid>
          <v-layout wrap>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItem.name"
              :rules="rules.name"
              color="purple darken-2"
              label="Full name"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>  -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItem.email"
              :rules="emailRules"
              color="blue darken-2"
              label="Email"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItem.id_no"
              color="blue darken-2"
              label="Id Number"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
            </v-flex>
            <v-flex  xs12 sm6>
              <v-text-field
              :append-icon="e1 ? 'visibility' : 'visibility_off'"
              :append-icon-cb="() => (e1 = !e1)"
              :type="e1 ? 'password' : 'text'"
              v-model="editedItem.password"
              name="input-10-2"
              label="Enter your password"
              hint="At least 8 characters"
              min="8"
              value=""
              class="input-group--focused"
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.password">{{ errors.password[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItem.address"
              :rules="rules.name"
              color="blue darken-2"
              label="Address"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>  -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItem.city"
              :rules="rules.name"
              color="blue darken-2"
              label="City"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItem.city"
              :rules="rules.name"
              color="blue darken-2"
              label="City"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
             <v-slider
             v-model="editedItem.age"
             :rules="rules.age"
             color="orange"
             label="Age"
             hint="Be honest"
             min="1"
             max="100"
             thumb-label
             ></v-slider>
           </v-flex>
           <v-flex xs12 sm6>
            <v-text-field
            v-model="editedItem.country"
            :rules="rules.name"
            color="blue darken-2"
            label="Country"
            required
            ></v-text-field>
            <!-- <small class="has-text-danger" v-if="errors.country">{{ errors.country[0] }}</small> -->
          </v-flex>
          <v-flex xs12 sm6>
            <v-text-field
            v-model="editedItem.phone"
            :rules="rules.name"
            color="blue darken-2"
            label="Phone"
            required
            ></v-text-field>
            <!-- <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small> -->
          </v-flex>
              <!-- <div class="form-group">
                <vue-google-autocomplete
                ref="address"
                id="map"
                classname="form-control col-md-12"
                placeholder="Please type your address"
                v-on:placechanged="getAddressData"
                country="ke"
                ></vue-google-autocomplete>
              </div> -->
            </v-layout>
          </v-container>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" flat @click.stop="pdialog2=false">Close</v-btn>
        <v-spacer></v-spacer>
        <v-btn color="primary" flat @click="update">Add</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <!-- Edit User -->

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
<v-btn flat color="white">Close</v-btn>
</v-snackbar>
</v-content>
<AddUser @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert"></AddUser>
<!-- <ShowUser @closeRequest="close" :openShowRequest="dispShow"></ShowUser> -->
<!-- <EditUser @closeRequest="close" :openEditRequest="dispEdit" @alertRequest="showAlert"></EditUser> -->
</div>
</template>

<script>
let AddUser = require('./AddUser.vue')
// let ShowUser = require('./ShowUser.vue')
// let EditUserUser = require('./EditUser.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddUser, /*ShowUser, EditUser*/
  }, 
  data() {
    return{
      proheaders: [
      { text: 'Name', align: 'left', value: 'name'},
      { text: 'description', value: 'description' },
      { text: 'Uploaded on', value: 'created_at' },
      { text: 'Actions', value: 'name', sortable: false }
      ],
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
    dispAdd: false,
    docsdialog2: false,
    dispEdit: false,
    pdialog2: false,
    snackbar: false,
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
  editItem(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.pdialog2 = true
  },

  update() {
    axios.patch(`/users/${this.editedItem.id}`, {form: this.editedItem, location: this.address})
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
    this.dispAdd= this.docsdialog2 =  false
  },

  // documents

  seeDocs(item) {
    this.seeDocuments = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    console.log(this.seeDocuments);
    this.docsdialog2 = true
  },

  download(item) {
   this.docNo = Object.assign({}, item)
   this.editedIndex = this.Alldocs.indexOf(item)
   /*axios.get(`/${this.seeDocuments.id}`)
   .then((response) => {
    console.log(reaponse);
     this.message = 'Successifully Added';
     this.snackbar = true;
     this.color = 'indigo';
   })  
   .catch((error) => {
     this.errors = error.response.data.errors
     this.message = 'failed ';
     this.snackbar = true;
     this.color = 'red';
   })*/
   axios({
     url: 'http://mechanics.dev/storage/attachments/LmztVebBIu9akwN97ZHUtDzQUgsPFB1odUZGCzkA.pdf',
     method: 'GET',
     responseType: 'blob', // important
   }).then((response) => {
     this.message = 'Successifully Added';
     this.snackbar = true;
     this.color = 'indigo';
     const url = window.URL.createObjectURL(new Blob([response.data]));
     const link = document.createElement('a');
     link.href = url;
     link.setAttribute('download', 'file.pdf');
     document.body.appendChild(link);
     link.click();
   })  
   .catch((error) => {
     this.errors = error.response.data.errors
     this.message = 'failed ';
     this.snackbar = true;
     this.color = 'red';
   });
 },
},
mounted() {
  this.loader=true
  axios.post('getUsers')
  .then((response) => {
    this.Allusers = this.temp = response.data
    this.loader=false
  })
  .catch((error) => {
    this.errors = error.response.data.errors
    this.loader=false
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