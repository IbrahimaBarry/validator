<template>
	<div>
		<section class="hero is-small">
	        <!-- Hero footer: will stick at the bottom -->
	        <div class="hero-foot">
	          <nav class="level">
	            <div class="level-item has-text-centered quotidienP">
	              <p class="heading">Quotidiens</p>
	              <p class="title"> {{quotidiens.length}}</p>
	            </div>
	            <div class="level-item has-text-centered hebdoP">
	              <p class="heading">Hebdomadaires</p>
	              <p class="title"> {{hebdomadaires.length}}</p>
	            </div>
	            <div class="level-item has-text-centered mensuelP">
	              <p class="heading">Mensuels</p>
	              <p class="title"> {{mensuels.length}}</p>
	            </div>
	          </nav>
	        </div>
	    </section>

	    <section class="section">
	        <div class="columns is-mobile is-multiline">
	          <div class="column is-one-third-desktop is-full-mobile">
	            <section class="panel">
	              <p class="panel-heading quotidien"></p>
	              <div class="panel-block">
	              	<p>Scannés = {{quotidiens.filter(doc => doc.scanned == true).length}}</p>
	              	<p>OCR = {{quotidiens.filter(doc => doc.ocr == true).length}}</p>
	              	<p>Importés = {{quotidiens.filter(doc => doc.imported == true).length}}</p>
	              	<p>Clippés = {{quotidiens.filter(doc => doc.clipped == true).length}}</p>
	              	<p>Exportés = {{quotidiens.filter(doc => doc.exported == true).length}}</p>
	              </div>
	            </section>
	          </div>
	          <div class="column is-one-third-desktop is-full-mobile">
	            <section class="panel">
	              <p class="panel-heading hebdo"></p>
	              <div class="panel-block">
	              	<p>Scannés = {{hebdomadaires.filter(doc => doc.scanned == true).length}}</p>
	              	<p>OCR = {{hebdomadaires.filter(doc => doc.ocr == true).length}}</p>
	              	<p>Importés = {{hebdomadaires.filter(doc => doc.imported == true).length}}</p>
	              	<p>Clippés = {{hebdomadaires.filter(doc => doc.clipped == true).length}}</p>
	              	<p>Exportés = {{hebdomadaires.filter(doc => doc.exported == true).length}}</p>
	              </div>
	            </section>
	          </div>
	          <div class="column is-one-third-desktop is-full-mobile">
	            <section class="panel">
	              <p class="panel-heading mensuel"></p>
	              <div class="panel-block">
	              	<p>Scannés = {{mensuels.filter(doc => doc.scanned == true).length}}</p>
	              	<p>OCR = {{mensuels.filter(doc => doc.ocr == true).length}}</p>
	              	<p>Importés = {{mensuels.filter(doc => doc.imported == true).length}}</p>
	              	<p>Clippés = {{mensuels.filter(doc => doc.clipped == true).length}}</p>
	              	<p>Exportés = {{mensuels.filter(doc => doc.exported == true).length}}</p>
	              </div>
	            </section>
	          </div>
	        </div>
	    </section>
	    <section>
	    	<h1 class="title">Statistiques du jour</h1>

			<!-- <div class="field">
			  <label class="label"><h5 class="title is-5">Profile</h5></label>
			  <div class="control">
			    <div class="select">
			      <select>
			        <option>Clipping</option>
			        <option>Reception</option>
			        <option>Scanne</option>
			        <option>Abby OCR</option>
			        <option>Import</option>
			        <option>Export</option>
			      </select>
			    </div>
			  </div>
			</div> -->

	    	<Bar-chart :chart-data="today" :chart-labels="labels"></Bar-chart>
	    </section>
	</div>
</template>

<script>
import BarChart from './BarChart.js'

	export default {
		components: {
			BarChart
		},

		data() {
			return {
				documents: [],
				chartData : [
					{label: 'reception', value: '23'}
				]
			}
		},

		computed: {
			quotidiens() {
				return this.documents.filter(document => document.document.frequence == 'Quotidien');
			},
			hebdomadaires() {
				return this.documents.filter(document => document.document.frequence == 'Hebdomadaire');
			},
			mensuels() {
				return this.documents.filter(document => document.document.frequence == 'Mensuel');
			},

			today() {
				return [
					'12'
				];
			},
			labels() {
				return ['reception']
			}
		},

		mounted() {
			var self = this;
			axios.get('/admin/dashboard').then(response => {
				self.documents = response.data.receptions;
				// self.chartData = response.data.chartData;
				// console.log(self.chartData);
			})
		}
	}
</script>

<style scoped>
	.level-item {
	  display: block;
	}

	.panel-block {
		display: block;
		line-height: 30px
	}

	.heading {
		font-size: 0.8em;
	}

	.quotidien {
		background: hsl(171, 100%, 41%)
	}
	.quotidienP p {
		color: hsl(171, 100%, 41%)
	}

	.hebdo {
		background: hsl(217, 71%, 53%)
	}
	.hebdoP p {
		color: hsl(217, 71%, 53%)
	}

	.mensuel {
		background: hsl(348, 100%, 61%)
	}
	.mensuelP p {
		color: hsl(348, 100%, 61%)
	}
</style>