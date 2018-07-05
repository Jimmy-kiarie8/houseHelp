<template>

<!-- Edit User -->
<v-dialog v-model="openEditRequest" max-width="800px" persistent>
  <v-card>
    <v-card-title>
      {{ editedItemCon.name }}
    </v-card-title>
    <v-card-text>
      <v-form ref="form" @submit.prevent="update">
        <v-container grid-list-xl fluid>
          <v-layout wrap>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.name"
              :rules="rules.name"
              color="purple darken-2"
              label="Full name"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>  -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.email"
              :rules="emailRules"
              color="blue darken-2"
              label="Email"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.id_no"
              color="blue darken-2"
              label="Id Number"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
            </v-flex>
            <v-flex  xs12 sm6>
              <v-text-field
              :append-icon="e1 ? 'visibility' : 'visibility_off'"
              :append-icon-cb="() => (e1 = !e1)"
              :type="e1 ? 'password' : 'text'"
              v-model="editedItemCon.password"
              name="input-10-2"
              label="Enter your password"
              hint="At least 8 characters"
              min="8"
              value=""
              class="input-group--focused"
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.password">{{ errors.password[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.address"
              :rules="rules.name"
              color="blue darken-2"
              label="Address"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>  -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.city"
              :rules="rules.name"
              color="blue darken-2"
              label="City"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
             <v-slider
             v-model="editedItemCon.age"
             :rules="rules.age"
             color="orange"
             label="Age"
             hint="Be honest"
             min="1"
             max="100"
             thumb-label
             ></v-slider>
           </v-flex>
           <v-flex xs12 sm6>
            <v-text-field
            v-model="editedItemCon.country"
            :rules="rules.name"
            color="blue darken-2"
            label="Country"
            required
            ></v-text-field>
            <!-- <small class="has-text-danger" v-if="errors.country">{{ errors.country[0] }}</small> -->
          </v-flex>
          <v-flex xs12 sm6>
            <v-text-field
            v-model="editedItemCon.phone"
            :rules="rules.name"
            color="blue darken-2"
            label="Phone"
            required
            ></v-text-field>
            <!-- <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small> -->
          </v-flex>
          <div class="form-group col-md-6">
            <label for="password" class="col-md-8 col-form-label text-md-right">Role</label>
            <div class="col-md-12">
                <select class="custom-select" v-model="editedItemCon.role">
                  <option v-for="element in Showrole" data-subtext="" :value="element.id">{{element.name}}</option>
                </select>
            </div>
          </div>
              <!-- <div class="form-group">
                <vue-google-autocomplete
                ref="address"
                id="map"
                classname="form-control col-md-12"
                placeholder="Please type your address"
                v-on:placechanged="getAddressData"
                country="ke"
                ></vue-google-autocomplete>
              </div> -->
            </v-layout>
          </v-container>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" flat @click.stop="close">Close</v-btn>
        <v-spacer></v-spacer>
        <v-btn 
          color="primary" 
          flat 
          @click="update"
          :loading="loading"
          :disabled="loading"
          >Add</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <!-- Edit User -->

</template>

<script>
export default {
  props: ['editedItemCon', 'openEditRequest', 'Showrole'],
  data() {
    return{
      e1: true,
      loader: false,
      loading:false,
      list: {},
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
    update() {
      this.loading=true
      axios.patch(`/users/${this.editedItemCon.id}`, {form: this.editedItemCon, location: this.address})
      .then((response) => {
        // console.log(response);
            this.loading=false
            this.close;
            // this.resetForm();
            Object.assign(this.$parent.Allusers[this.$parent.editedIndex], this.$parent.editedItem)
            this.$emit('closeRequest');
            this.$emit('alertRequest');

      })
      .catch((error) => {
      this.errors = error.response.data.errors
      this.loading=false
    })
    },
    /*resetForm () {
        this.form = Object.assign({}, this.defaultForm)
        this.$refs.form.reset()
      },*/
    close() {
      this.$emit('closeRequest')
    },
  },
  mounted() {

  }
}
</script>
