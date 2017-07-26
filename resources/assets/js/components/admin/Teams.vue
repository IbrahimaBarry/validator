<template>
	<div>
		<h1 class="title is-spaced has-text-centered" style="color: rgba(0, 0, 0, 0.8)">Planning des équipes</h1>
		<div class="level-left">
		    <div class="level-item">
		      <div class="field has-addons">
		        <p class="control">
		          <input class="input" type="text" placeholder="Recherche">
		        </p>
		        <p class="control">
		          <button class="button">
		            Ajouter
		          </button>
		        </p>
		      </div>
		    </div>
		</div>
		
		

	</div>
</template>

<script>
	export default {
		data() {
			return {
				teams: [],
				users: [],
				newTeam: {
					name: ''
				}
			}
		},

		methods: {
			addTeam() {
				axios.post('/teams/store', this.newTeam).then(response => this.teams = response.data);
			}
		},

		mounted() {
			axios.get('/teams/all').then(function(response) {
				this.teams = response.data.teams;
			});
		}
	}
</script>

<style>
	.title {
		color: black;
	}
</style>