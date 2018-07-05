<template>
  <v-layout row justify-center>
    <v-dialog v-model="openEditRequest" persistent max-width="1300px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Add Post</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm12>
                      <v-text-field
                      v-model="editBlog.title"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Title"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>

                    <v-flex xs12>
                      <v-text-field
                        v-model="editBlog.description"
                        color="blue"
                        multi-line
                      >
                        <div slot="label">
                          Post 
                        </div>
                      </v-text-field>
                    </v-flex>
                    <vue-editor v-model="editBlog.content" ></vue-editor>
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
                  >Update</v-btn>
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
import { VueEditor } from 'vue2-editor'
export default {
  props: ['openEditRequest', 'editBlog'],
  components: {
    VueEditor
  },
  data() {
    const defaultForm = Object.freeze({
      title: '',
      content: '',
      description: '',
    })
    return{
      errors: {},
      defaultForm,
      loading: false,
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    save() {
      this.loading=true
      // this.editBlog.content = this.content
      axios.patch(`/blog/${this.editBlog.id}`, this.editBlog)
      .then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        this.resetForm();
        this.editBlog.content = ''

        this.$emit('closeRequest');
        this.$emit('alertRequest');
        Object.assign(this.$parent.blogPosts[this.$parent.editedIndex], this.$parent.editedItem)

      })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loading=false
      })
    },
    resetForm () {
      this.editBlog = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
    },
    close() {
      this.$emit('closeRequest')
    },
  },
  computed: {
   formIsValid () {
     return (
       this.form.title &&
       this.form.description
       )
   },
 },
 mounted() {
 }
}
</script>
