<template>
<div>
  <v-layout row justify-center>
    <v-dialog v-model="openRequest" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click.native="close">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Jobs</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <!-- <v-btn dark flat @click.native="dialog = false">Save</v-btn> -->
          </v-toolbar-items>
        </v-toolbar>
          <div class="container">
            <table class="table table-hover table-stripped" v-if="openRequest">
              <thead>
                <th>Mechanic</th>
                <th>Client</th>
                <th>Description</th>
                <th>Rating</th>
                <th>Created On</th>
                <th>#</th>
              </thead>
              <!-- <tbody v-if="AllJobsDisp.length === 1">
                <tr>
                  <td v-for="user in users" v-if="user.id === AllJobsDisp.mechanic_id">{{ user.name }}</td>
                  <td v-for="user in users" v-if="user.id === AllJobsDisp.client_id">{{ user.name }}</td>
                  <td>{{ AllJobsDisp.description }}</td>
                  <td>{{ AllJobsDisp.rating }}</td>
                  <td>{{ AllJobsDisp.created_at }}</td>
                  <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="ShowJobSt(AllJobsDisp.id)">
                      <v-icon color="blue darken-2">visibility</v-icon>
                    </v-btn>
                  </td> 
                </tr>
              </tbody> -->
              <tbody>
                <tr v-for="jobs, key in AllJobsDisp" :key="jobs.id">
                  <td v-for="user in users" v-if="user.id === jobs.mechanic_id">{{ user.name }}</td>
                  <td v-for="user in users" v-if="user.id === jobs.client_id">{{ user.name }}</td>
                  <td>{{ jobs.description }}</td>
                  <td>{{ jobs.rating }}</td>
                  <td>{{ jobs.created_at }}</td>
                  <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="ShowJobSt(key)">
                      <v-icon color="blue darken-2">visibility</v-icon>
                    </v-btn>
                  </td> 
                </tr>
              </tbody>
            </table>
          </div>
      </v-card>
    </v-dialog>
  </v-layout>
<ShowJob @closeRequestD="closeD" 
  :openProRequest="JobDialog" 
  :users="users" 
  :showD="editedItemCon"
  :allDets="AllJobsDisp"
  :test="editedItem"
  ></ShowJob>
</div>
</template>

<script>
let ShowJob = require('./ShowJob.vue')
export default {
  props: ['openRequest', 'editedItemCon', 'users', 'AllJobsDisp'],
  components: {
    ShowJob
  }, 
  data () {
    return {
      JobDialog: false,
      dialog: false,
      AllJobs: [],
      JobsDisp: [],
      editedItem: {}
    }
  },

  methods: {

    ShowJobSt(key) {
      // this.editedItem = Object.assign({}, item)
      // this.editedIndex = this.AllJobs.indexOf(item)
      console.log(this.AllJobsDisp[key]);
      this.$children[0].list = this.AllJobsDisp[key]
      // console.log(this.editedItem);
      this.JobDialog = true

      /*axios.post(`getJobs/${this.editedItem.id}`)
      .then((response) => {
        this.JobsDisp = response.data
      })
      .catch((error) => {
        this.errors = error.response.data.errors
      })*/
    },
    close() {
      this.$emit('closeRequest')
    },
    closeD() {
      this.JobDialog = false
    },
  },

  mounted() {
    /*axios.post(`getJobs/${this.editedItemCon.id}`)
    .then((response) => {
      this.AllJobs = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })*/
  }
}
</script>