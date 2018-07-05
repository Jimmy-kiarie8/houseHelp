<template>
  <v-layout row justify-center>
    <v-dialog v-model="openRequest" persistent max-width="700px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Job Details</span>
        </v-card-title>
        <v-card-text v-if="openRequest">
          <v-container grid-list-md>
            <div class="col-md-12 col-sm-12">
              <ul class="list-group">
                <li class="list-group-item row active"
                  v-for="users in Allusers" 
                  :key="users.id"
                  v-if="users.id === jobs.client_id">
                  <label class="col-md-5 col-lg-5"><b>Client Name</b></label> {{ users.name }}
                </li>

                <li class="list-group-item row"
                  v-for="users in Allusers" 
                  :key="users.email"
                  v-if="users.id === jobs.client_id">
                  <label class="col-md-5 col-lg-5"><b>Client Email</b></label> {{ users.email }}
                </li>
                <li class="list-group-item row"
                  v-for="users in Allusers" 
                  :key="users.phone"
                  v-if="users.id === jobs.client_id">
                  <label class="col-md-5 col-lg-5"><b>Client Phone Number</b></label> {{ users.phone }}
                </li>
                <li class="list-group-item row">
                  <label class="col-md-5 col-lg-5"><b>Description</b></label> {{ jobs.description }}
                </li>
                <li class="list-group-item row">
                  <label class="col-md-5 col-lg-5"><b>Status</b></label> {{ jobs.respo }}
                </li>
              </ul>
            </div>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <!-- <v-btn raised @click="updateStTrue" 
            color="primary" 
            darken-2 
            :loading="loading"
            :disabled="loading"
            v-show="!status"
          >Complete</v-btn> -->
          <v-btn flat @click="close">Close</v-btn>
          <v-spacer></v-spacer>
          <v-btn raised 
            @click="updateStTrue" 
            color="primary" 
            darken-2 
            flat
            :loading="Tloading"
            :disabled="Tloading"
            >Accept</v-btn>
          <v-btn raised 
            @click="updateStFalse" 
            color="primary" 
            darken-2 
            flat
            :loading="Floading"
            :disabled="Floading"
            >Regect</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: ['openRequest', 'jobs'],
  data() {
    return{
      status: false,
      list: {},
      Allusers: [],
      Floading: false,
      Tloading: false,
      form: {
        respo: '',
      }
    }
  },
  methods: {
    updateStTrue() {
        this.Tloading=true
        this.form.respo='Accepted'
      axios.post(`updateReqTrue/${this.jobs.id}`, this.$data.form)
      .then((response) => {
        this.Tloading=false
        this.respo = 'Accepted'
        console.log(response);
        Object.assign(this.$parent.AllJobs[this.$parent.editedIndex], this.$parent.editedItem)
        /*this.$parent.Allusers.push(response.data) 
        this.close;
        this.resetForm();*/
        this.$emit('closeRequest');
        this.$emit('alertRequest');

      })
      .catch((error) => {
        this.Tloading=false
        this.errors = error.response.data.errors
      })
    },

    updateStFalse() {
        this.Floading=true
        this.form.respo='Regected'
      axios.post(`updateReqFalse/${this.jobs.id}`, this.$data.form)
      .then((response) => {
        this.Floading=false
        this.respo = 'Regected'
        console.log(response);
        Object.assign(this.$parent.AllJobs[this.$parent.editedIndex], this.$parent.editedItem)
        /*this.$parent.Allusers.push(response.data) 
        this.close;
        this.resetForm();*/
        this.$emit('closeRequest');
        this.$emit('alertRequest');

      })
      .catch((error) => {
        this.Floading=false
        this.errors = error.response.data.errors
      })
    },
    close() {
      this.$emit('closeRequest')
    },
  },
  mounted() {
    axios.post('getUsers')
    .then((response) => {
      this.Allusers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })
  }
}
</script>
