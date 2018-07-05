<template>
 <v-content>
  <v-container fluid fill-height>
        <div v-show="loader" style="text-align: center; width: 100%;">
          <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
   <v-layout justify-center align-center v-show="!loader">
    <div class="wrapper">
      <div class="content">
        <div class="row">

          <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">account_circle</i>
                </div>
                <p class="card-category">Users</p>
                <h3 class="card-title">{{ Allusers.length }} <small>Users</small></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons text-danger">warning</i>
                  <a href="#">Go to users</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">store</i>
                </div>
                <p class="card-category">Jobs</p>
                <h3 class="card-title">{{ AllJobs.length }}</h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">date_range</i> Last 72 Hours
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">info_outline</i>
                </div>
                <p class="card-category">Subscribers</p>
                <h3 class="card-title">{{ AllJobs.length }}</h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">local_offer</i> Tracked from Email
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">comment</i> Tracked from Github
                </div>
                <p class="card-category">comments</p>
                <h3 class="card-title">{{ Allcomments.length }}</h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">update</i> Just Updated
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Best Mechanics</h4>
              <p class="card-category">Mechanics with the highest rating</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <tr><th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Rating</th>
                  </tr></thead>
                  <tbody>
                    <tr v-for="users in FewUsers" :key="users.id">
                      <td>{{ users.id_no }}</td>
                      <td>{{ users.name }}</td>
                      <td>{{ users.email }}</td>
                      <td>{{ users.phone }}</td>
                      <td>{{ users.rating }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Comments -->
          <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">Recent Comments</h4>
              <p class="card-category">Recent comments</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <tr>
                    <th>Comment</th>
                    <th>Rating</th>
                    <th>Commented On</th>
                  </tr></thead>
                  <tbody>
                    <tr v-for="comment in FewComs" :key="comment.id">
                      <td>{{ comment.comment }}</td>
                      <td>{{ comment.rating }}</td>
                      <td>{{ comment.created_at }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Comments -->
          <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-info">
              <h4 class="card-title">Recent Subscribers</h4>
              <p class="card-category">Recent Subscribers</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-info">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subscribed On</th>
                  </tr></thead>
                  <tbody>
                    <tr v-for="subscribe in FewSubs" :key="subscribe.id">
                      <td>{{ subscribe.name }}</td>
                      <td>{{ subscribe.email }}</td>
                      <td>{{ subscribe.created_at }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>
      </div>
      </v-layout>
  </v-container>
 </v-content>
</template>

<script>
export default {
 data() {
  return{
   Allusers: {},
   loader: false,
   AllJobs: {},
   AllBlogs: {},
   AllSubscribers: {},
   notCompleted: {},
   Allcomments: {},
   FewUsers: {},
   FewComs: {},
   FewSubs: {},
 }
},
mounted() {
  this.loader = true
  axios.post('getUsers')
  .then((response) => {
    this.Allusers = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })

  axios.post('getJobs')
  .then((response) => {
    this.AllJobs = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })

  axios.post('getBlog')
  .then((response) => {
    this.AllBlogs = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })


    axios.post('getsubscribers')
    .then((response) => {
      this.AllSubscribers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('fewComments')
    .then((response) => {
      this.FewComs = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('fewUsers')
    .then((response) => {
      this.FewUsers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('fewSubs')
    .then((response) => {
      this.FewSubs = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('getComments')
    .then((response) => {
      this.loader = false
      this.Allcomments = response.data
    })
    .catch((error) => {
      this.loader = false
      this.errors = error.response.data.errors
    })
  }
}
</script>


<style scoped>
/*#tiles .col-md-3{
 width: 90%;
 height: 90px;
 border-radius: 3px;
}
.bg-green{
 background: green;
}
.bg-purple{
 background: purple;
}
.bg-orange{
 background: orange;
}
.bg-aqua{
 background: aqua;
}*/
#cols{
 background: #f0f0f0;
}
</style>