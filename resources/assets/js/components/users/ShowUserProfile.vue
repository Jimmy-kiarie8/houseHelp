<template>
	<div>
		<v-layout row justify-center>
			<v-dialog v-model="detailsModal" persistent max-width="900">
				<v-card>
					<v-card-title class="headline">Job</v-card-title>
					<v-card-text>
						<div class="col-md-12 col-sm-12">
						  <ul class="list-group" v-for="job in AllJobs">
						    <li class="list-group-item row active">
						      <label class="col-md-5 col-lg-5"><b>User</b></label> {{ job.user_id }}
						    </li>

						    <li class="list-group-item row">
						      <label class="col-md-5 col-lg-5"><b>Mechanic</b></label> {{ job.mechanic_id }}
						    </li>
						    <li class="list-group-item row">
						      <label class="col-md-5 col-lg-5"><b>Rating</b></label> {{ job.rating }}
						    </li>
						  </ul>
						</div>
					</v-card-text>
				</v-card>
			</v-dialog>
		 </v-layout>
		<!-- profile -->
		<v-dialog v-model="openProRequest" fullscreen hide-overlay transition="dialog-bottom-transition">
			<v-card style="background: #f5f8fa;">
				<v-card-title>
					<v-toolbar dark color="primary">
						<v-btn icon dark @click.native="close">
							<v-icon color="black">close</v-icon>
						</v-btn>
						<v-spacer></v-spacer>
					</v-toolbar>
					<span class="headline"></span>
				</v-card-title>
				<v-card-text>

					<v-card>
						<v-layout row>
							<v-flex sm3 offset-sm1>
								<img src="" alt="profile">
								<star-rating  :read-only="true" :increment="0.01" v-model="rating" :star-size="20"></star-rating>
								<p>{{docsPass.name}}</p>            
								<p>{{docsPass.email}}</p>            
								<p>{{docsPass.ratings}}</p>            
							</v-flex>

							<v-flex sm8>
								<v-card style="max-height: 200px;overflow-y: scroll; border-left: 1px solid #333; background: #f9f9f9;">
									<v-layout row>
										<v-flex xs12 sm10 offset-sm1>
											<v-card>
												<v-layout v-for="comment in AllComments" :key="comment.id">
													<v-flex sm2>
														<div v-for="user in users" v-if="user.id === comment.user_id">commented By:{{ user.name }}</div>
													</v-flex>
													<v-flex sm3>
														On: {{ comment.created_at }}
													</v-flex>
													<v-flex sm3>
														{{ comment.comment }}
													</v-flex>
													<v-flex sm4>
														<star-rating  :read-only="true" :increment="0.01" v-model="comment.rating" :star-size="20"></star-rating>
													</v-flex>
												</v-layout>
											</v-card>
										</v-flex>
									</v-layout>
								</v-card>
							</v-flex>
						</v-layout>
					</v-card>

					<div style="height: 50px"></div>
					<v-divider></v-divider>
					<div style="height: 50px"></div>

					<v-container grid-list-md text-xs-center>

					<!-- Jobs -->

					<v-card-title>
						<h3 class="text-center">Previous Jobs</h3>
					</v-card-title>
					<v-data-table
					:headers="jobsheaders"
					:items="users"
					counter
					class="elevation-1"
					>
					<template slot="items" slot-scope="props">
						<td>
							{{ props.item.name }}
						</td>
						<td class="text-xs-right">{{ props.item.email }}</td>
						<td class="text-xs-right">{{ props.item.created_at }}</td>
						<td class="justify-center layout px-0">
							<v-btn icon class="mx-0" @click="openJob(props.item)">
								<v-icon color="blue darken-2">visibility</v-icon>
							</v-btn>

						</td> 
					</template>
					<template slot="pageText" slot-scope="{ pageStart, pageStop }">
						From {{ pageStart }} to {{ pageStop }}
					</template>
				</v-data-table>
				<!-- Jobs -->

			</v-container>
		</v-card-text>
	</v-card>

</v-dialog>
<!-- profile -->

</div>
</template>

<script>
export default{
	props: ['openProRequest', 'users', 'docsPass'],
	data() {
		return {
			search: '',
			rating: 4,
			seeDocuments: {},
			detailsModal: false,
			AllComments: [],
			Alldocs: [],
			AllJobs: {},
			jobsheaders: [
			{ text: 'Client Name', align: 'left', value: 'name'},
			{ text: 'Client Email', value: 'email' },
			{ text: 'Done on', value: 'created_at' },
			{ text: 'Actions', value: 'name', sortable: false }

			],
			headers: [
			{ text: 'Name', align: 'left', value: 'name'},
			{ text: 'email', value: 'email' },
			{ text: 'Id Number', value: 'id_no' },
			{ text: 'Phone Number', value: 'phone' },
			{ text: 'Rating', value: 'rating' },
				// { text: 'Location', value: 'location' },
				// { text: 'Current Status', value: 'current_status' },
				{ text: 'Status', value: 'status' },
				{ text: 'Actions', value: 'name', sortable: false }
				],
			}

		},
		methods: {
		  // Ratings && Comments
		  commdialog() {
		    // this.commdialog2 = true
		    axios.post(`/comments/${this.feedback.id}`, this.feedback)
		    .then((response) => {

		    	this.message = 'Commented'
		    	this.color = 'indigo'
		    	this.snackbar = true
		    })
		    .catch((error) => {
		    	this.errors = error.response.data.errors
		    	this.message = 'something went wrong'
		    	this.color = 'red'
		    	this.snackbar = true
		    })
		},		
		 openJob(item) {
		 	this.detailsModal = true
		 },
		close() {
			this.$emit('closeRequest')
		},
	},
	mounted() {
		axios.post('getJobs')
		.then((response) => {
			this.AllJobs = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getComments')
		.then((response) => {
			this.AllComments = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getCategory')
		.then((response) => {
			this.Alldocs = response.data
			this.loader=false
		})
		.catch((error) => {
			this.errors = error.response.data.errors
			this.loader=false
		})
	}
}
</script>

<style scoped>

</style>