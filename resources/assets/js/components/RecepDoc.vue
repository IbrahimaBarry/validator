<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Valider réception du document {{ id }}</p>
	      <button class="delete" @click="hideModal"></button>
	    </header>
	    <section class="modal-card-body">
	      <!-- Content ... -->
	      <div class="field">
			  <label class="label">Date de publication</label>
			  <p class="control">
			    <input class="input" type="date" placeholder="Text input" v-model="document.sourceDate">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Nombre de page</label>
			  <p class="control">
			    <input class="input" type="number" placeholder="Text input" v-model="document.nbrPage">
			  </p>
			</div>

			<div class="field">
			  <p class="control">
			    <label class="checkbox">
			      <input type="checkbox" v-bind:true-value="id" v-bind:false-value="0" v-model="document.document_id">
			      Je confirmer la reception du document
			    </label>
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
					nbrPage: 0,
					document_id: 0
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