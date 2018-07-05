<template>
	<!-- <div class="container"> -->
		<div>
			<section class="section">

				<div v-show="loader" style="text-align: center">
					<v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
				</div> 
				<div class="content" v-show="!loader">
					<div class="columns is-8 is-centered">

						<div class="column is-2 column-shadow" style="background: #3f67a7; color: #fff;">
							<div class="profile">
								<figure class="image profile-image is-128x128" v-if="user.profile">
									<img :src="user.profile" alt="profile">
								</figure>
								<p class="has-text-light title">
									<span class="has-text-weight-light"><i class="fa fa-user"></i>{{user.name}}</span>
								</p><br>
								<p class="subtitle has-text-light is-size-7"><i class="fa fa-envelope"></i>{{user.email}}</p>

								<p class="header-text has-text-light has-text-weight-light"><i class="fa fa-phone"></i>{{user.phone}}</p><br>
								<p class="subheader-text has-text-light">
									{{user.address}}
								</p>
								<div class="external">
									<span>
										<span class="icon">
											<i class="fa fa-external-link-square">{{user.name}}</i>
										</span>
									</span>
								</div>
					<!-- <div v-for="link in profile.external" :key="link.value" class="detail-item">
						<a class="has-text-light" href="#">
							<p class="icon">
								<i class="fa fa-user"></i>
							</p>
							{{link.title}}
						</a>
					</div> -->
				</div>


			</div>


			<div class="column is-6 card-boxing column-shadow">
				<div class="content">
					<h1 class="headline">
						<span>
							<span class="icon">
								<i class="fa fa-user"></i>
							</span>About Me
						</span>
					</h1>
					<p class="has-text-justified" v-for="personal in personals">{{ personal.about }}</p>
				</div>

				<div class="content">
					<h1 class="headline">
						<span>
							<span class="icon">
								<i class="fa fa-user"></i>
							</span>QUALIFICATIONS
						</span>
					</h1>
					<p class="has-text-justified" v-for="personal in personals">{{ personal.quarification }}</p>
				</div>

				<!-- education -->

				<div class="content">
					<h1 class="headline">
						<span>
							<span class="icon">
								<i class="fa fa-graduation-cap"></i>
							</span>Education
						</span>
					</h1>

					<div class="cvitem" v-for="education in educations">
						<article class="media">
							<div class="media-left">
								<!-- TimelineView -->
								<div class="timeline">
									<div class="tag is-medium" style="background: #41748c; color: #fff;"><span class="hint--bottom">{{education.end_date}}</span></div>
									<div class="timeline-bar">000</div>
									<div class="tag is-medium" style="background: #3f51b5; color: #fff;"><span class="hint--bottom">{{education.start_date}}</span></div>
								</div>
								<!-- TimelineView -->
							</div>
							<div class="media-content">
								<div class="content">

									<p class="title is-4 is-capitalized">
										{{ education.institute }}
										<!-- <a class="icon fa fa-link" href="#"></a> -->
									</p>
									<p class="subtitle is-capitalized">
										<span class="is-capitalized has-text-weight-light">{{ education.course_name }}</span>
										<!-- <span>MA Political Science</span> -->
									</p>
									<p class="has-text-justified">{{education.bio}}</p>
									<p class="headline course-headline"><span class="icon">
										<!-- <i class="fa fa-arrow-down"></i> -->
									</span></p>
									<!--  Coursework</span></p> -->

										<!-- <transition
										name="coursework-transition"
										enter-active-class="animated fadeInDown"
										leave-active-class="animated fadeOutUp"
										>
										<div v-show="isVisible(index)">
											<div>
												<dl class="course">
													<dt><span>Political Violence </span> <span class="has-text-weight-light">8300</span></dt>
													<dd class="course-detail has-text-justified">Inquiry into what constitutes violence, and how entities use violence for politically-motivated ends. Final paper argued that the US House should switch to MMD.</dd>
												</dl>
											</div>
										</transition> -->

									</div>
								</div>
							</article>
						</div>
					</div>
					<!-- education -->

					<!-- employment -->
					<div class="content">
						<h1 class="headline">
							<span>
								<span class="icon">
									<i class="fa fa-briefcase"></i>
								</span>Experience
							</span>
						</h1>
						<div class="cvitem" v-for="experience in experiences">
							<article class="media">
								<div class="media-left">
									
									<!-- TimelineView -->
									<div class="timeline">
										<div style="background: #41748c; color: #fff;" class="tag is-medium"><span class="hint--bottom">{{experience.end_date}}</span></div>
										<div class="timeline-bar">000</div>
										<div class="tag is-medium" style="background: #3f51b5; color: #fff;"><span class="hint--bottom">{{experience.start_date}}</span></div>
									</div>
									<!-- TimelineView -->
								</div>
								<div class="media-content">
									<div class="content">
										<p class="title is-4 ">{{ experience.job_title }}
											<!-- <a class="icon fa fa-link" href="#"></a> --></p>
											<p class="subtitle">{{ experience.company_name	 }}</p>
											<p class="has-text-justified">{{ experience.bio }}</p>
										</div>
									</div>
								</article>
							</div>
						</div>
						<!-- employment -->



						<!-- skills -->
						<div class="columns is-variable is-8">
							<div class="column">
								<div class="content">
									<h1 class="headline">
										<span>
											<span class="icon">
												<i class="fa fa-rocket"></i>
											</span>Skills
										</span>
									</h1>
									<dl class="cvitem" v-for="skill in mechSkills" :key="skill.id">
										<dt>
											<i class="fa fa-rocket"></i> {{ skill.skill_title }}
										</dt>
										<dd class="has-text-justified">
											{{ skill.bio }}
										</dd>
									</dl>
								</div>

							</div>
							<div class="column">
								<div class="content">
									<h1 class="headline">
										<span>
											<span class="icon">
												<i class="fa fa-globe"></i>
											</span>Reference
										</span>
									</h1>
									<dl v-for="personal in personals">
										<dd>
											{{personal.reference}}
										</dd>
									</dl>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<footer class="footer hero">
			<div class="container">
				<div class="content has-text-centered">
					<p>
						<strong>{{user.name}}</strong><span> ©{{ new Date().getFullYear() }}</span>
					</p>
				</div>
			</div>
		</footer>
		<!-- </div> -->
	</div>
</template>



<script>
// let TimelineView = require('../resume/TimelineView.vue')
export default {
	props: ['user'],
	data() {
		return{
			loader: false,
			educations: {},
			experiences: {},
			personals: {},
			mechSkills: {},
		}
	},
	mounted() {
		this.loader=true
		axios.post('getEducation')
		.then((response) => {
			// console.log(response.data);
			this.educations = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getMeckSkills')
		.then((response) => {
			// console.log(response.data);
			this.mechSkills = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getPersonal')
		.then((response) => {
			// console.log(response.data);
			this.personals = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getExperience')
		.then((response) => {
			// console.log(response.data);
			this.experiences = response.data
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
@import './bulma.css';
</style>
