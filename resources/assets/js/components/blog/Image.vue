<template>
  <div>
    <v-layout row justify-center>
      <v-dialog v-model="openImgRequest" persistent max-width="500px">
        <v-card>
          <v-card-title fixed>
            <span class="headline">Add User</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                  <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Upload</v-btn>
                  <input type="file" @change="Getimage" accept="image/*" style="display: none" ref="fileInput">
                  <img v-if="avatar != ''" :src="avatar" style="width: 200px; height: 200px;">
              </v-layout>
            </v-container>
            <v-card-actions>
              <v-btn
              :disabled="loading"
              :loading="loading"
              flat
              color="primary"
              v-show="imagePlaced"
              @click="upload"
              >Upload</v-btn>
              <v-btn @click="cancle" flat v-show="imagePlaced">Cancle</v-btn>
              <v-spacer></v-spacer>
              <v-btn @click="close" flat>Close</v-btn>
            </v-card-actions>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>

<script>
export default {
  props: ['user', 'openImgRequest', 'imginfo', 'avatar'],
  data () {
    return {
      imagePlaced: false,
      loading: false,
    }
  },
  methods: {
    // Image Upload
    onPickFile() {
      this.$refs.fileInput.click()
    },
    onFilePicked(event) {
      this.imagePlaced = true
      const files = event.target.files
      let filename = files[0].name
      if (filename.lastIndexOf('.') <= 0) {
        return alert('please upload a valid image')
      }
      const fileReader = new FileReader()
      fileReader.addEventListener('load', () => {
        this.avatar = fileReader.result
      })
      fileReader.readAsDataURL(files[0])
      this.image = files[0]
    },
    Getimage(e) {
      let image = e.target.files[0];
      // this.read(image);
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.avatar = e.target.result
      }
      this.imagePlaced = true
      let form = new FormData();
      form.append('image', image);
      this.file = form
      console.log(e.target.files);
    },

    upload() {
      this.loading = true
      axios.post(`/blogImage/${this.imginfo.id}`, this.file)
      .then((response) => {
        console.log(response);
        this.loading = false
        this.imagePlaced = false;
        this.avatar.push(response.data) 
        // this.$emit('closeRequest');
        this.$emit('alertRequest');
      })
      .catch((error) => {
        this.loading=false
        this.errors = error.response.data.errors
      })
    },
    cancle() {
      this.avatar = this.imginfo.image;
      this.imagePlaced = false;
    },
    close() {
      this.$emit('closeRequest')
    },
  },
  mounted() {
  }
}
</script>