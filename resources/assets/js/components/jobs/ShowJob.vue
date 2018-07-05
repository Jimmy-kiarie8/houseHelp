<template>
  <v-layout row justify-center>
    <v-dialog v-model="openProRequest" persistent max-width="700px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Job Details</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <div class="col-md-12 col-sm-12">
              <ul class="list-group">
                <li class="list-group-item row active">
                  <label class="col-md-5 col-lg-5"><b>Mechanic Name</b></label> {{ showD.name }}
                </li>

                <li class="list-group-item row">
                  <label class="col-md-5 col-lg-5"><b>Mechanic Email</b></label> {{ showD.email }}
                </li>
                <li class="list-group-item row">
                  <label class="col-md-5 col-lg-5"><b>Rating</b></label> {{ list.rating }}
                </li>
                <li class="list-group-item row">
                  <label class="col-md-5 col-lg-5"><b>Description</b></label> {{ list.description }}
                </li>
                <li class="list-group-item row" 
                  v-for="users in Allusers" 
                  :key="users.id"
                  v-if="users.id === list.client_id">
                  <label class="col-md-5 col-lg-5"><b>Client</b></label> {{ users.name }}
                </li>
                <li class="list-group-item row">
                  <label class="col-md-5 col-lg-5"><b>Status</b></label> {{ list.status }}
                </li>
              </ul>
            </div>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn raised @click="updateStTrue" 
            color="primary" 
            darken-2 
            :loading="loading"
            :disabled="loading"
            v-show="!status"
          >Complete</v-btn>
          <v-btn raised 
            @click="updateStFalse" 
            color="primary" 
            darken-2 
            :loading="loading"
            :disabled="loading"
            v-show="status">Uncomplete</v-btn>
          <v-spacer></v-spacer>
          <v-btn flat @click="close">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: ['openProRequest', 'showD', 'allDets'],
  data() {
    return{
      status: false,
      list: {},
      Allusers: [],
      loading: false,
    }
  },
  methods: {
    updateStTrue() {
        this.loading=true
      axios.post(`updateJobTrue/${this.list.id}`, !this.status)
      .then((response) => {
        this.loading=false
        this.status = !this.status
        console.log(response);
        /*this.$parent.Allusers.push(response.data) 
        this.close;
        this.resetForm();
        this.$emit('closeRequest');
        this.$emit('alertRequest');*/

      })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loading=false
      })
    },

    updateStFalse() {
        this.loading=true
      axios.post(`updateJobFalse/${this.list.id}`, !this.status)
      .then((response) => {
        this.loading=false
        this.status = !this.status
        console.log(response);
        /*this.$parent.Allusers.push(response.data) 
        this.close;
        this.resetForm();
        this.$emit('closeRequest');
        this.$emit('alertRequest');*/

      })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loading=false
      })
    },
    close() {
      this.$emit('closeRequestD')
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
