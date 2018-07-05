<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="500px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Give Job</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12>
                      <v-text-field
                        v-model="form.description"
                        color="blue"
                        multi-line
                      >
                        <div slot="label">
                          Job description 
                        </div>
                      </v-text-field>
                    <small class="has-text-danger" v-if="errors.description">{{ errors.description[0] }}</small>
                    </v-flex>
                  </v-layout>
            </v-container>
            <v-card-actions>
              <v-btn flat @click="resetForm">reset</v-btn>
              <v-btn flat @click="close">Close</v-btn>
              <v-spacer></v-spacer>
              <v-btn
              :disabled="loading"
              :loading="loading"
              flat
              color="primary"
              @click="save"
              >Submit</v-btn>
            </v-card-actions>
          </v-form>
        </v-layout>
      </v-container>
    </v-card-text>
  </v-card>
</v-dialog>
</v-layout>
</template>

<script>
export default {
  props: ['openAddRequest', 'editedItemCon'],
  components: {
    
  },
  data() {
      const defaultForm = Object.freeze({
        description: '',
        mechanic_id: null,
      })
    return{
      loading: false,
      errors: {},
      defaultForm,
      loader: false,
      form: Object.assign({}, defaultForm),
      rules: {
        age: [
          val => val < 10 || `I don't believe you!`
        ],
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    save() {
      this.loading = true
      this.form.mechanic_id = this.editedItemCon.id;
      axios.post('/jobs', this.$data.form).
      then((response) => {
        this.loading=false
        console.log(response);
        this.$emit('alertRequest');
        this.$parent.JobsDisp.push(response.data) 
        this.resetForm();
        this.$emit('closeRequest');
      })
      .catch((error) => {
        this.loading=false
        this.errors = error.response.data.errors
      })
    },
    resetForm () {
        this.form = Object.assign({}, this.defaultForm)
        this.$refs.form.reset()
      },
    close() {
      this.$emit('closeRequest')
    },
  },
    mounted() {
    axios.post('getCompanyAdmin')
    .then((response) => {
      this.Allusers = response.data
    })
    .catch((error) => {
        this.errors = error.response.data.errors
      })


      axios.post('getCompanies')
      .then((response) => {
        this.companies = response.data
      })
      .catch((error) => {
        this.errors = error.response.data.errors
      })
    },
  computed: {
   formIsValid () {
     return (
       this.form.name &&
       this.form.email &&
       this.form.phone &&
       this.form.password
     )
   },
 },
  mounted() {

  }
}
</script>
