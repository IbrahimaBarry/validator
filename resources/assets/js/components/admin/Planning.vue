<template>
	<div>
		<!-- Main container -->
		<nav class="level">
		  <!-- Left side -->
		  <div class="level-left">
		    <div class="level-item">
		      <p class="subtitle is-5">
		        <strong>{{ month }}</strong>
		        <strong>{{ weeks }}</strong>
		      </p>
		    </div>
		  </div>

		  <!-- Right side -->
		  <div class="level-right">
		    <p class="level-item">
		    	<div class="field">
				  <label class="label">Mois</label>
				  <div class="control">
				    <div class="select">
				      <select v-model="month">
				        <option>Select mois</option>
				        <option v-for="month in months">{{ month }}</option>
				      </select>
				    </div>
				  </div>
				</div>
		    </p>
		  </div>
		</nav>

		<div class="card">
		  <div class="card-content">
		    <div class="content">
		      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
		      <a>@bulmaio</a>. <a>#css</a> <a>#responsive</a>
		      <br>
		      <small>11:09 PM - 1 Jan 2016</small>
		    </div>
		  </div>
		</div>

	</div>
</template>

<script>
	moment.locale('fr');
	export default {
		data() {
			return {
				months: moment.months(),
				weeks: moment.weekdays(),
				month: moment().startOf("month").format('MMMM')
			}
		}
	}
</script>

<style scoped>
	
</style>