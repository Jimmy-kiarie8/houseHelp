<template>
  <div>
    <v-content>
      <div v-show="loader" style="text-align: center; width: 100%;">
        <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
      </div>

      <!-- Send Email -->
      <v-dialog v-model="maildialog" persistent max-width="400px">
            <div v-show="Mailloader" style="text-align: center; width: 100%;">
              <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
            </div>
           <v-card v-show="!Mailloader">
             <v-card-title>
               <span class="headline">User Subscription</span>
             </v-card-title>
             <v-card-text>
               <v-container grid-list-md>
                 <v-layout wrap>
                  <v-form ref="form" @submit.prevent>
                   <v-flex xs12 sm12>
                     <v-text-field
                     v-model="form.title"
                     :rules="rules.name"
                     color="blue darken-2"
                     label="Title"
                     required
                     ></v-text-field>
                     <small class="has-text-danger" v-if="errors.title">{{ errors.title[0] }}</small>
                   </v-flex>
                   <v-flex xs12>
                     <v-text-field
                       v-model="form.content"
                       color="blue"
                       multi-line>
                       <div slot="label">
                         Content
                       </div>
                     </v-text-field>
                     <small class="has-text-danger" v-if="errors.content">{{ errors.content[0] }}</small>
                   </v-flex>
                   <v-card-actions>
                     <v-btn flat @click="resetForm">Cancel</v-btn>
                     <v-spacer></v-spacer>
                     <v-btn
                       flat
                       color="primary"
                       :disabled="loading"
                       :loading="loading"
                       @click="sendmail"
                     >Send Mail</v-btn>
                   </v-card-actions>
                 </v-form>
                 </v-layout>
               </v-container>
             </v-card-text>
           </v-card>
         </v-dialog>
      <!-- Send Email -->

      <v-container fluid fill-height v-show="!loader">
        <v-layout justify-center align-center>
          <div v-show="!loader">
           <v-card-title>
            Subscribers
            <v-btn color="primary" raised @click="openModalAdd">Add Subscribers</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" flat @click="openModalUns">UnSubscribed</v-btn>
            <v-btn color="primary" flat @click="openModalMail">Send Email</v-btn>
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
          :items="AllSubscribers"
          :search="search"
          counter
          class="elevation-1"
          >
          <template slot="items" slot-scope="props">
            <td>{{ props.item.name }}</td>
            <td class="text-xs-right">{{ props.item.email }}</td> 
            <td class="text-xs-right">{{ props.item.created_at }}</td> 
            <td class="justify-center layout px-0">
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
  </v-layout>
</v-container>
</v-content>
<AddSubscribers 
  :openAddRequest="OpenAdd" 
  @closeRequest="close" 
  @alertRequest="alert"
  :Subscribers='AllSubscribers'>
</AddSubscribers>
<Unsubscribed 
  :openUnRequest="OpenUns" 
  @closeRequest="close" 
  @alertRequest="alert"
  :Unsubscribed='AllUnSubscribed'>
</Unsubscribed>
<v-snackbar
:timeout="timeout"
:bottom="y === 'bottom'"
:color="color"
:left="x === 'left'"
v-model="snackbar"
>
{{ message }}
<v-btn flat color="white">Close</v-btn>
</v-snackbar>
</div>
</template>

<script>
let AddSubscribers = require('./AddSubscribers')
let Unsubscribed = require('./Unsubscribed')
export default {
  props: ['user', 'role'],
  components: {
    AddSubscribers, Unsubscribed
  },

  data () {
    const defaultForm = Object.freeze({
      title: '',
      content: '',
    })
    return{
      defaultForm,
      loading: false,
      errors: {},
      form: Object.assign({}, defaultForm),
      OpenAdd: false,
      OpenUns: false,
      maildialog: false,
      Mailloader: false,
      search: '',
      snackbar: false,
      timeout: 5000,
      message: 'Success',
      color: 'black',
      y: 'bottom',
      x: 'left',
      headers: [
      {
        text: 'User Name',
        align: 'left',
        value: 'name'
      },
      { text: 'Email', value: 'email' },
      { text: 'Subscribed on', value: 'created_at' },
      { text: 'Actions', value: 'name', sortable: false }
      ],
      AllSubscribers: [],
      AllUnSubscribed: [],
      editedIndex: -1,
      loader: false,
      editedItem: {},
      emailRules: [
      v => {
        return !!v || 'E-mail is required'
      },
      v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
      ],
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },


  methods: { 
    sendmail() {
      this.loading = true
      axios.post('/sendmail', this.$data.form)
      .then((response) => {
        this.loading = false
        console.log(response);
        // this.$parent.AllCompanies.push(response.data) 
        // this.close();
        // this.resetForm();
        // this.close()
        this.color = 'indigo'
        this.message = 'Sent'
        this.snackbar = true
      })
      .catch((error) => {
        this.errors = error.response.data.errors
        // this.close()
        this.color = 'red'
        this.message = 'Something went wrong'
        this.snackbar = true
        this.loading = false
      })
    },
    resetForm () {
      this.form = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
    },
    openModalAdd() {
      this.OpenAdd = true
    },
    openModalMail() {
      this.maildialog =true
    },
    openModalUns() {
      this.OpenUns = true
    },
    alert() {
      this.message = 'Thanks for subscribing'
      this.color = 'black'
      this.snackbar = true
    },
    close () {
      this.OpenAdd = this.OpenUns = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    }, 
    deleteItem (item) {
      const index = this.AllSubscribers.indexOf(item)
      if (confirm('Are you sure you want to delete this item?')) {
        axios.delete(`/email/${item.id}`)
        .then((response) => {          
            this.message = 'Deleted'           
            this.color = 'black'           
            this.snackbar = true  
             // console.log(response);
        })
         .catch((error) => {
          this.errors = error.response.data.errors
          this.message = 'something went wrong'           
          this.color = 'red'           
          this.snackbar = true  
        })
      }
      // confirm('Are you sure you want to delete this item?') && this.AllSubscribers.splice(index, 1)
    },
    resetForm () {
      this.form = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
    },
  },
mounted() {
  this.loader=true
   axios.post('getsubscribers')
    .then((response) => {
      this.AllSubscribers = response.data
      this.loader=false
    })
    .catch((error) => {
      this.errors = error.response.data.errors
      this.loader=false
    })

   axios.post('getunsubscribed')
    .then((response) => {
      this.AllUnSubscribed = response.data
      this.loader=false
    })
    .catch((error) => {
      this.errors = error.response.data.errors
      this.loader=false
    })
},
computed: {
 formIsValid () {
   return (
    this.form.title &&
    this.form.content    
  )
 },
},

/*beforeRouteEnter(to, from, next) {
 next(vm => {
  if (vm.role === 'Admin') {
    next(); 
  } else {
    next('/');
  }
})
}*/
}
</script>