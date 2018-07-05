<template> 
 <v-content>
  <v-container fluid fill-height>
   <v-layout justify-center align-center>
    <div v-show="loader" style="text-align: center; width: 100%;">
        <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div>
    <v-flex xs12 sm12 v-show="!loader">
      <v-layout row wrap>
        <v-flex xs6 sm3>
          <v-card>
            <v-card-actions>
              <v-layout row wrap>
                <v-flex sm4>
                  <i class="pull-left fa fa-globe icon-rounded" style="font-size: 70px; color: red"></i>
                </v-flex>
                <v-flex sm7 offset-sm1>
                  <strong>10</strong>  <v-divider></v-divider>
                  <h6>Registered HouseHelps</h6>
                </v-flex>
              </v-layout>
            </v-card-actions>
          </v-card>
        </v-flex>
        <v-flex xs6 sm3>
          <v-card>
            <v-card-actions>
              <v-layout row wrap>
                <v-flex sm4>
                  <i class="pull-left fa fa-exchange" style="font-size: 70px; color: purple"></i>
                </v-flex>
                <v-flex sm7 offset-sm1>
                  <strong>12</strong>  <v-divider></v-divider>
                  <h6>Registered Employers</h6>
                </v-flex>
              </v-layout>
            </v-card-actions>
          </v-card>
        </v-flex>
        <v-flex xs6 sm3>
          <v-card>
            <v-card-actions>
              <v-layout row wrap>
                <v-flex sm4>
                  <i class="pull-left fa fa-check-circle" style="font-size: 70px; color: indigo"></i>
                </v-flex>
                <v-flex sm7 offset-sm1>
                  <strong>4</strong>  <v-divider></v-divider>
                  <h6>Employed Helpers</h6>
                </v-flex>
              </v-layout>
            </v-card-actions>
          </v-card>
        </v-flex>
        <v-flex xs6 sm3>
          <v-card>
            <v-card-actions>
              <v-layout row wrap>
                <v-flex sm4>
                  <i class="pull-left fa fa-plane" style="font-size: 70px; color: orange"></i>
                </v-flex>
                <v-flex sm7 offset-sm1>
                  <strong>2</strong>  <v-divider></v-divider>
                  <h6>Unemployed</h6>
                </v-flex>
              </v-layout>
            </v-card-actions>
          </v-card>
        </v-flex>
        <v-divider></v-divider>
        <v-divider></v-divider>
        <v-flex xs8>
          <line-chart 
            :messages="{empty: 'No data'}"
             :refresh="10"
            :download="true" 
            :data="[['2018-01-18 08:31:24', 11], ['2018-2-02 08:31:24', 4], ['2018-03-03 08:31:24', 19], ['2018-04-04 08:31:24', 12]]"
          ></line-chart>
        </v-flex>
        <v-flex xs4>
          <v-card>
            <v-toolbar color="white" dark>
              <v-toolbar-title>Business Stats</v-toolbar-title>
            </v-toolbar>
            <v-list two-line>
              <template>
                <v-list-tile avatar>
                  <v-list-tile-content>
                    <v-list-tile-sub-title> Waiting Approval</v-list-tile-sub-title>
                  </v-list-tile-content>
                  <v-list style="color: green"> {{ AllwaitingShipment.length }}</v-list>
                </v-list-tile>
                <v-list-tile avatar>
                  <v-list-tile-content>
                    <v-list-tile-sub-title> Derivery Orders</v-list-tile-sub-title>
                  </v-list-tile-content>
                  <v-list style="color: green"> {{ AllderiveredShipment.length }}</v-list>
                </v-list-tile>
                <v-list-tile avatar>
                  <v-list-tile-content>
                    <v-list-tile-sub-title> Total Packages</v-list-tile-sub-title>
                  </v-list-tile-content>
                  <v-list style="color: green"> {{ Allshipments.length }}</v-list>
                </v-list-tile>
                <v-list-tile avatar>
                  <v-list-tile-content>
                    <v-list-tile-sub-title> Delayed Orders</v-list-tile-sub-title>
                  </v-list-tile-content>
                  <v-list style="color: red"> {{ AlldelayedShipment.length }}</v-list>
                </v-list-tile>
                <v-list-tile avatar>
                  <v-list-tile-content>
                    <v-list-tile-sub-title> Orders Not Completed</v-list-tile-sub-title>
                  </v-list-tile-content>
                  <v-list style="color: red"> {{ notCompleted.length }}</v-list>
                </v-list-tile>
                <v-list-tile avatar>
                  <v-list-tile-content>
                    <v-list-tile-sub-title> Total Derivery</v-list-tile-sub-title>
                  </v-list-tile-content>
                  <v-list style="color: orange"> {{ AllderiveredShipment.length }}</v-list>
                </v-list-tile>
              </template>
            </v-list>
          </v-card>
        </v-flex>
        <v-divider></v-divider>
        <v-divider></v-divider>
        <v-divider></v-divider>

          </v-layout>
        </v-flex>
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
   Allshipments: {},
   AllContainers: {},
   AlldelayedShipment: {},
   notCompleted: {},
   AllwaitingShipment: {},
   AllderiveredShipment: {},
   AllapprovedShipment: {},
   chart: [],
   lables: [],
   rows: {},
 }
},
  mounted() {
/*    this.loader = true
    axios.post('getUsers')
    .then((response) => {
      this.Allusers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('getShipments')
    .then((response) => {
      this.Allshipments = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('getContainers')
    .then((response) => {
      this.AllContainers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    // Dashboard
    axios.post('delayedShipment')
    .then((response) => {
      this.AlldelayedShipment = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('waitingShipment')
    .then((response) => {
      this.AllwaitingShipment = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('deriveredShipment')
    .then((response) => {
      this.AllderiveredShipment = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('deriveredShipment')
    .then((response) => {
      this.AllderiveredShipment = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('getChartData')
    .then((response) => {
      console.log(response);
      this.chart = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('approvedShipment')
    .then((response) => {
      this.loader = false
      this.AllapprovedShipment = response.data
    })
    .catch((error) => {
      this.loader = false
      this.errors = error.response.data.errors
    })  */  
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