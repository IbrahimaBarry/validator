<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Valider réception du document</p>
	      <button class="delete" @click="hideModal"></button>
	    </header>
	    <section class="modal-card-body">
	      <!-- Content ... -->
	      	<div class="field">
			  <label class="label">Jour de publication</label>
			  <p class="control">
			    <input class="input" type="date" v-model="document.sourceDate">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Heure de publication</label>
			  <p class="control">
			    <input class="input" type="time" v-model="document.time">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Nombre de page</label>
			  <p class="control">
			    <input class="input" type="number" placeholder="Text input" v-model="document.nbrPage">
			  </p>
			</div>

			<textarea class="textarea" placeholder="Preciser la cause du retard de la réception ici" v-model="document.message"></textarea>

			<div class="field">
			  <p class="control">
			    <label class="checkbox">
			      <input type="checkbox" v-bind:true-value="id" v-bind:false-value="0" v-model="document.document_id">
			      Je confirme la reception du document
			    </label>
			    <div v-if="document.document_id == 0">
                    <p class="help is-danger">Veilllez confirmer la reception du document avant de valider</p>
			    </div>
			  </p>
			</div>
	    </section>
	    <footer class="modal-card-foot">
	      <a class="button is-success" @click.prevent="addReception">Valider</a>
	      <a class="button" @click="hideModal">Fermer</a>
	    </footer>
	  </div>
	</div>
</template>

<script>
	export default {
		props: ['id'],

		data() {
			return {
				document: {
					sourceDate: '',
					time: '',
					nbrPage: 0,
					document_id: 0,
					message: ''
				}
			}
		},

		methods: {
			hideModal() {
				this.$emit('hideRecepDoc');
			},

			addReception() {
				if (this.document.document_id != 0) {
	        		axios.post('/receptions/store', this.document)
					  .then(response => this.$emit('documentRecepted', response.data));
				}
        	}
		},

		mounted() {
			
		}
    }
</script>

<style scoped>
	label.checkbox {
		color: black
	}
</style>