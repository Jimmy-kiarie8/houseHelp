<template>
 <div>
      <v-dialog v-model="openRequest" persistent max-width="700px">
        <v-card>
          <v-card-title fixed>
            <span class="headline">Education</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap v-show="!loader">
                <v-form ref="form" @submit.prevent>
                  <v-container grid-list-xl fluid>
                    <v-layout wrap>
                      <v-flex xs12 sm6>
                        <v-text-field
                        v-model="form.course_name"
                        :rules="rules.name"
                        color="blue darken-2"
                        label="Course Name"
                        required
                        ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                      </v-flex>
                      <v-flex xs12 sm6>
                        <v-text-field
                        v-model="form.institute"
                        :rules="rules.name"
                        color="blue darken-2"
                        label="Institute"
                        required
                        ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                      </v-flex>
                      <v-flex xs12 sm6>
                        <v-text-field
                        v-model="form.start_date"
                        color="blue darken-2"
                        type="date"
                        label="Start Date"
                        required
                        ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
                      </v-flex>
                      <v-flex xs12 sm6>
                        <v-text-field
                        v-model="form.end_date"
                        :rules="rules.name"
                        color="blue darken-2"
                        label="End Date"
                        type="date"
                        required
                        ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small> -->
                      </v-flex>
                      <v-flex xs12>
                        <v-text-field
                          v-model="form.bio"
                          color="blue"
                          multi-line
                        >
                          <div slot="label">
                            Other Information <small>(optional)</small>
                          </div>
                        </v-text-field>
                      </v-flex>
                </v-layout>
              </v-container>
              <v-card-actions>
                <v-btn flat @click="resetForm">reset</v-btn>
                <v-btn flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn
                   :loading="loading"
                   :disabled="loading"
                   color="primary"
                   flat
                   @click="education"
                 >
                   Submit
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-layout>
         <div v-show="loader" style="text-align: center; width: 100%;">
             <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
         </div>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</div>
</template>

<script>
export default {
  props: ['openRequest', 'resumeInfo'],
  components: {
    
  }, 
  data() {
    const defaultForm = Object.freeze({
      course_name: '',
      institute: '',
      start_date: '',
      end_date: '',
      bio: '',
    })
    return{
      loading: false,
      loader: false,
      e1: true,
      form: Object.assign({}, defaultForm),
      defaultForm,
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
  education() {
    this.loading = true
    axios.post(`/education/${this.resumeInfo.id}`, this.$data.form).
    then((response) => {
      console.log(response);
      // this.$parent.educationobj.push(response.data) 
      this.resetForm();
      this.loading = false
      // this.$emit('closeRequest');
      this.$emit('alertRequest');
    })
    .catch((error) => {
      this.loading = false
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

 computed: {
  formIsValid () {
    return (
      this.form.course_name &&
      this.form.institute &&
      this.form.start_date &&
      this.form.end_date 
    )
  },
},
mounted() {},
}
</script>


<style scoped>
.content--wrap{
 margin-top: -100px
}
.list-group-item:hover, .list-group-item:focus {
 z-index: 1;
 background: #f9f9f9;
 text-decoration: none;
}
</style>