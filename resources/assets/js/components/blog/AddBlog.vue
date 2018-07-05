<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="1300px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Add User</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm12>
                      <v-text-field
                      v-model="form.title"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Title"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>

                    <v-flex xs12>
                      <v-text-field
                        v-model="form.description"
                        color="blue"
                        multi-line
                      >
                        <div slot="label">
                          About 
                        </div>
                      </v-text-field>
                    </v-flex>
                    <vue-editor v-model="content" ></vue-editor>
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
                  >Post</v-btn>
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
  props: ['openAddRequest'],
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
      content: '',
      defaultForm,
      loading: false,
      form: Object.assign({}, defaultForm),
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {

/*    handleImageAdded(file, Editor, cursorLocation) {
      const CLIENT_ID = '993793b1d8d3e2e'
      var formData = new FormData();
      formData.append('image', file)

      axios.post('BlogImage', this.formData)
      .then((result) => {
        console.log(result);
        let url = result.data.data.link
        Editor.insertEmbed(cursorLocation, 'image', url);
      })
      .catch((err) => {
        console.log(err);
      })


      axios({
        url: 'http://mechanics.dev/BlogImage',
        method: 'POST',
        headers:{
          'Authorization': 'Client-ID ' + CLIENT_ID
        },
        data: formData
      })
      .then((result) => {
        console.log(result);
        let url = result.data.data.link
        Editor.insertEmbed(cursorLocation, 'image', url);
      })
      .catch((err) => {
        console.log(err);
      })
    }*/

      saveContent: function() {
        // You have the content to save
        console.log(this.content)
      },
    save() {
      this.loading=true
      this.form.content = this.content
      axios.post('/blog', this.$data.form).
      then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        // this.resetForm();
        this.$emit('closeRequest');
        this.$emit('alertRequest');
        this.$parent.blogPosts.push(response.data) 

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
