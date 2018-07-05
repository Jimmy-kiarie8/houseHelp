<template>
  <v-dialog v-model="openUnRequest" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click.native="close">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>Unsubscribed</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn dark flat @click.native="subscribe">Save</v-btn>
        </v-toolbar-items>
      </v-toolbar>
    </v-card>
    <v-card style="margin-top: -400px !important;">
      <v-flex sm8 offset-sm2>
       <v-card-title>
        UnSubscribed
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
      :items="Unsubscribed"
      :search="search"
      counter
      class="elevation-1"
      >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.email }}</td> 
        <td class="text-xs-right">{{ props.item.deleted_at }}</td> 
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="refresh(props.item)">
            <v-icon color="pink darken-2">refresh</v-icon>
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
  </v-flex sm8 offset-sm2>
</v-card>
</v-dialog>
</template>

<script>
export default {
  props: ['openUnRequest', 'Unsubscribed'],
  data () {
    return {
      search: '',
      headers: [
      {
        text: 'User Name',
        align: 'left',
        value: 'name'
      },
      { text: 'Email', value: 'email' },
      { text: 'UnSubscribed On', value: 'deleted_at' },
      { text: 'Actions', value: 'name', sortable: false }
      ],
    }
  },
  methods: { 
    refresh (item) {
      const index = this.Unsubscribed.indexOf(item)
      if (confirm('Are you sure you want to subscribe this user?')) {
        axios.post(`/refresh/${item.id}`)
        .then((response) => {          
            this.message = 'Subscribe success'           
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
    close() {
      this.$emit('closeRequest');
    },
  }
}
</script>