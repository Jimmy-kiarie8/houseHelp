<template>
  <div>
    <v-content>
      <div v-show="loader" style="text-align: center; width: 100%;">
        <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
      </div>
      <v-container fluid fill-height v-show="!loader">
        <v-layout justify-center align-center>
          <v-layout row wrap>
            <v-flex xs12 sm4>
              <v-card>
                <img :src="avatar"style="width: 100px; height: 100px; border-radius: 50%; text-align:center; margin-top 70px;margin-left-100px">
                <!-- <v-icon class="text-center" color="indigo" style="font-size:100px; text-align:center;">account_circle</v-icon> -->
                <v-divider></v-divider>
                <h6 class="text-center" color="green">Admin</h6>
                <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Upload</v-btn>
                <!-- <input type="file" @change="Getimage" accept="image/*"> -->
                <input type="file" @change="Getimage" accept="image/*" style="display: none" ref="fileInput">
                <!-- <img v-show="imagePlaced" :src="avatar" style="width: 300px; height: 240px;"> -->
                <img v-show="imagePlaced" :src="avatar" style="width: 200px; height: 200px;">
                <v-btn @click="upload" flat v-show="imagePlaced">Upload</v-btn>
                <v-btn @click="cancle" flat v-show="imagePlaced">Cancle</v-btn>
              </v-card>
            </v-flex>

            <!-- User Form -->
            <v-flex xs12 sm7 offset-sm1>
              <v-card flat>
                <v-snackbar
                v-model="snackbar"
                absolute
                top
                right
                color="black"
                >
                <span>Details updated</span>
                <v-icon dark>check_circle</v-icon>
              </v-snackbar>
              <v-form ref="form" @submit.prevent="submit">
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.name"
                      :rules="rules.name"
                      color="purple darken-2"
                      label="Full name"
                      required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.email"
                      :rules="emailRules"
                      color="blue darken-2"
                      label="Email"
                      required
                      ></v-text-field>
                    </v-flex>
                    <v-flex  xs12 sm6>
                      <v-text-field
                      :append-icon="e1 ? 'visibility_off' : 'visibility'"
                      :append-icon-cb="() => (e1 = !e1)"
                      :type="e1 ? 'password' : 'text'"
                      v-model="LogedUser.password"
                      name="input-10-2"
                      label="Enter your password"
                      hint="At least 8 characters"
                      min="8"
                      value=""
                      class="input-group--focused"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.address"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Address"
                      required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.city"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="City"
                      required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.country"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Country"
                      required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.phone"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Phone"
                      required
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.zipcode"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Zip Code"
                      required
                      ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="LogedUser.branch"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Branch"
                      required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>
                </v-container>
                <v-card-actions>
                  <v-btn flat @click="resetForm">reset</v-btn>
                  <v-spacer></v-spacer>
                  <v-btn
                  :disabled="!formIsValid"
                  flat
                  color="primary"
                  @click="update"
                  >Submit</v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-flex>
          <!-- User Form -->



        </v-layout>
      </v-layout>
    </v-container>
  </v-content>
</div>
</template>

<script>
export default {
  props: ['user'],
  data () {
    const defaultForm = Object.freeze({
      name: '',
      password: '',
      email: '',
      phone: null,
      zipcode: null,
      branch: '',
      address: '',
      city: '',
      country: '',
    })
    return {
      imagePlaced: false,
      defaultForm,
      avatar: '',
      LogedUser: {},
      e1: true,
      snackbar: false,
      loader: false,
      form: Object.assign({}, defaultForm),
      emailRules: [
        v => {
          return !!v || 'E-mail is required'
        },
        v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
      ],
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
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
      axios.post(`/profile/${this.LogedUser.id}`, this.file)
      .then((response) => {
        console.log(response);
        this.imagePlaced = false;
        this.color = 'black';
        this.text = 'Profile image updated';
        this.snackbar = true;
        // this.close()
      })
    },
    cancle() {
      this.avatar = this.LogedUser.profile;
      this.imagePlaced = false;
    },
    resetForm () {
        this.LogedUser = Object.assign({}, this.defaultForm)
        this.$refs.LogedUser.reset()
      },
    update() {
        axios.patch(`/users/${this.LogedUser.id}`, this.$data.LogedUser).
        then((response) => {
          // console.log(response);
              this.loader=false
              this.close;
              this.resetForm();
              this.$emit('closeRequest');
              this.$emit('alertRequest');

        })
        .catch((error) => {
        this.errors = error.response.data.errors
        this.loader=false
      })
    }
  },
mounted() {
  this.loader=true
  axios.post('getLogedinUsers')
  .then((response) => {
    this.LogedUser = response.data
    this.avatar = response.data.profile
    this.loader=false
  })
  .catch((error) => {
      this.errors = error.response.data.errors
      this.loader=false
    })
},

  computed: {
   formIsValid () {
     return (
       this.LogedUser.name &&
       this.LogedUser.email &&
       this.LogedUser.phone &&
       this.LogedUser.password &&
       this.LogedUser.zipcode &&
       this.LogedUser.branch &&
       this.LogedUser.address &&
       this.LogedUser.city &&
       this.LogedUser.country
     )
   },
 },
}
</script>