<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="400px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Add comment</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12>
                      <v-text-field
                        v-model="post.comment"
                        color="blue"
                        multi-line
                      >
                        <div slot="label">
                          Comment 
                        </div>
                      </v-text-field>
                      <small class="has-text-danger" v-if="errors.comment">{{ errors.comment[0] }}</small>
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
                  >Comment</v-btn>
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
  props: ['openAddRequest', 'blogP'],
  data() {
    const defaultForm = Object.freeze({
      comment: '',
    })
    return{
      errors: {},
      defaultForm,
      post: {},
      loading: false,
      form: Object.assign({}, defaultForm),
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    save() {
      this.loading=true
      axios.post(`/Postcom/${this.post.id}`, this.$data.post).
      then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        this.resetForm();
        this.$emit('closeRequest');
        this.$emit('alertRequest');
        this.$parent.blogComment.push(response.data) 

      })
      .catch((error) => {
        this.loading=false
        this.errors = error.response.data.errors
      })
    },
    resetForm () {
      this.post = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
    },
    close() {
      this.$emit('closeRequest')
    },
  },
  computed: {
   formIsValid () {
     return (
       this.form.comment
       )
   },
 },
 mounted() {
 }
}
</script>
